<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Enqueue CSS and JavaScript for the plugin.
 * 
 * @since  1.0.0
 * @return void
 */
function vgpd_enqueue_assets() {
    if ( is_product() ) {
        wp_enqueue_style(
            'vgpd-styles',
            plugins_url( 'css/vgpd-styles.css', VGPD_PLUGIN_FILE ),
            [],
            VGPD_VERSION
        );

        wp_enqueue_script(
            'vgpd-scripts',
            plugins_url( 'js/vgpd-scripts.js', VGPD_PLUGIN_FILE ),
            [ 'jquery' ],
            VGPD_VERSION,
            true
        );

        wp_localize_script(
            'vgpd-scripts',
            'vgpdSettings',
            [
                'position' => get_option( 'vgpd_gallery_position', 'right' ),
            ]
        );
    }
}
add_action( 'wp_enqueue_scripts', 'vgpd_enqueue_assets' );
