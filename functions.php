<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function runestudios_is_vite_dev() {
    return isset( $_GET['dev'] ) && '1' === $_GET['dev'];
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
