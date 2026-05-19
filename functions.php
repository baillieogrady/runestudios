<?php
if ( ! defined( 'ABSPATH' ) ) exit;

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
