<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function runestudios_register_menus() {
    register_nav_menus(
        array(
            'header'  => 'Header',
            'socials' => 'Socials',
            'footer'  => 'Footer',
        )
    );
}
add_action( 'after_setup_theme', 'runestudios_register_menus' );

function runestudios_register_portfolio_post_type() {
    register_post_type(
        'portfolio',
        array(
            'labels'       => array(
                'name'                  => 'Portfolio',
                'singular_name'         => 'Portfolio Item',
                'menu_name'             => 'Portfolio',
                'add_new_item'          => 'Add New Portfolio Item',
                'edit_item'             => 'Edit Portfolio Item',
                'new_item'              => 'New Portfolio Item',
                'view_item'             => 'View Portfolio Item',
                'search_items'          => 'Search Portfolio',
                'not_found'             => 'No portfolio items found',
                'not_found_in_trash'    => 'No portfolio items found in Trash',
                'all_items'             => 'All Portfolio',
            ),
            'public'       => true,
            'has_archive'  => true,
            'menu_icon'    => 'dashicons-portfolio',
            'menu_position' => 21,
            'rewrite'      => array(
                'slug' => 'portfolio',
            ),
            'show_in_rest' => true,
            'supports'     => array(
                'title',
                'thumbnail',
                'excerpt',
            ),
        )
    );
}
add_action( 'init', 'runestudios_register_portfolio_post_type' );

function runestudios_is_vite_dev() {
    $cached_status = get_transient( 'runestudios_vite_dev_server' );

    if ( false !== $cached_status ) {
        return 'running' === $cached_status;
    }

    $response = wp_remote_get(
        'http://localhost:5173/@vite/client',
        array(
            'timeout' => 0.2,
        )
    );

    $is_running = ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response );

    set_transient( 'runestudios_vite_dev_server', $is_running ? 'running' : 'stopped', 10 );

    return $is_running;
}

function runestudios_asset_uri( $path = '' ) {
    return get_template_directory_uri() . ( $path ? '/' . ltrim( $path, '/' ) : '' );
}

function runestudios_enqueue_assets() {
    if ( runestudios_is_vite_dev() ) {
        wp_enqueue_script(
            'runestudios-vite-client',
            'http://localhost:5173/@vite/client',
            array(),
            null,
            true
        );

        wp_enqueue_script(
            'runestudios-main',
            'http://localhost:5173/src/main.js',
            array( 'runestudios-vite-client' ),
            null,
            true
        );

        return;
    }

    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';

    if ( ! file_exists( $manifest_path ) ) {
        return;
    }

    $manifest = json_decode( file_get_contents( $manifest_path ), true );
    $entry    = $manifest['src/main.js'] ?? null;

    if ( ! $entry ) {
        return;
    }

    if ( ! empty( $entry['css'] ) ) {
        foreach ( $entry['css'] as $index => $css_file ) {
            wp_enqueue_style(
                'runestudios-main-' . $index,
                runestudios_asset_uri( 'dist/' . $css_file ),
                array(),
                null
            );
        }
    }

    if ( ! empty( $entry['file'] ) ) {
        wp_enqueue_script(
            'runestudios-main',
            runestudios_asset_uri( 'dist/' . $entry['file'] ),
            array(),
            null,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'runestudios_enqueue_assets' );

function runestudios_module_scripts( $tag, $handle, $src ) {
    $module_handles = array(
        'runestudios-vite-client',
        'runestudios-main',
    );

    if ( in_array( $handle, $module_handles, true ) ) {
        return '<script type="module" src="' . esc_url( $src ) . '"></script>' . "\n";
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'runestudios_module_scripts', 10, 3 );

function runestudios_disable_page_editor() {
    remove_post_type_support( 'page', 'editor' );
}
add_action( 'init', 'runestudios_disable_page_editor' );

function runestudios_disable_page_block_editor( $use_block_editor, $post_type ) {
    if ( 'page' === $post_type ) {
        return false;
    }

    return $use_block_editor;
}
add_filter( 'use_block_editor_for_post_type', 'runestudios_disable_page_block_editor', 10, 2 );

function runestudios_register_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) ) {
        return;
    }

    acf_add_options_page(
        array(
            'page_title' => 'Options',
            'menu_title' => 'Options',
            'menu_slug'  => 'options',
            'capability' => 'edit_posts',
            'redirect'   => false,
            'position'   => 22,
        )
    );
}
add_action( 'acf/init', 'runestudios_register_options_page' );

function runestudios_use_custom_admin_menu_order() {
    return true;
}
add_filter( 'custom_menu_order', 'runestudios_use_custom_admin_menu_order' );

function runestudios_admin_menu_order( $menu_order ) {
    $top_level_items = array(
        'index.php',
        'edit.php?post_type=page',
        'edit.php?post_type=portfolio',
        'options',
        'themes.php',
        'upload.php',
    );

    return array_values(
        array_unique(
            array_merge(
                $top_level_items,
                array_diff( $menu_order, $top_level_items )
            )
        )
    );
}
add_filter( 'menu_order', 'runestudios_admin_menu_order' );

function runestudios_add_portfolio_count_to_nav_menu( $title, $item ) {
    if (
        isset( $item->type, $item->object )
        && 'post_type_archive' === $item->type
        && 'portfolio' === $item->object
    ) {
        $portfolio_count = wp_count_posts( 'portfolio' );
        $published_count = isset( $portfolio_count->publish ) ? (int) $portfolio_count->publish : 0;

        return sprintf( '%s (%d)', $title, $published_count );
    }

    return $title;
}
add_filter( 'nav_menu_item_title', 'runestudios_add_portfolio_count_to_nav_menu', 10, 2 );

function runestudios_can_upload_svg() {
    return current_user_can( 'unfiltered_html' );
}

function runestudios_allow_svg_uploads( $mimes ) {
    if ( runestudios_can_upload_svg() ) {
        $mimes['svg'] = 'image/svg+xml';
    }

    return $mimes;
}
add_filter( 'upload_mimes', 'runestudios_allow_svg_uploads' );

function runestudios_validate_svg_upload( $file ) {
    $file_type = wp_check_filetype( $file['name'] );

    if ( 'svg' !== $file_type['ext'] ) {
        return $file;
    }

    if ( ! runestudios_can_upload_svg() ) {
        $file['error'] = 'You do not have permission to upload SVG files.';
        return $file;
    }

    $svg = file_get_contents( $file['tmp_name'] );

    if ( false === $svg || ! preg_match( '/<svg[\s>]/i', $svg ) ) {
        $file['error'] = 'This SVG file could not be validated.';
        return $file;
    }

    $blocked_patterns = array(
        '/<script\b/i',
        '/<foreignObject\b/i',
        '/\son\w+\s*=/i',
        '/javascript\s*:/i',
        '/data\s*:/i',
    );

    foreach ( $blocked_patterns as $pattern ) {
        if ( preg_match( $pattern, $svg ) ) {
            $file['error'] = 'This SVG contains unsafe markup and was not uploaded.';
            return $file;
        }
    }

    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'runestudios_validate_svg_upload' );
