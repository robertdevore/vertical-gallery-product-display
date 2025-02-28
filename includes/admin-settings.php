<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Register the settings page in the WordPress admin menu.
 *
 * @since  1.0.0
 * @return void
 */
function vgpd_register_settings_page() {
    add_submenu_page(
        'woocommerce',
        esc_html__( 'Vertical Gallery Settings', 'vertical-gallery-woocommerce' ),
        esc_html__( 'Vertical Gallery', 'vertical-gallery-woocommerce' ),
        'manage_options',
        'vgpd-settings',
        'vgpd_render_settings_page'
    );
}
add_action( 'admin_menu', 'vgpd_register_settings_page' );

/**
 * Render the settings page.
 * 
 * @since  1.0.0
 * @return void
 */
function vgpd_render_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Vertical Gallery Settings', 'vertical-gallery-woocommerce' ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'vgpd_settings_group' );
            do_settings_sections( 'vgpd-settings' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/**
 * Register the plugin settings.
 * 
 * @since  1.0.0
 * @return void
 */
function vgpd_register_settings() {
    register_setting(
        'vgpd_settings_group',
        'vgpd_gallery_position',
        [
            'default'           => 'right',
            'sanitize_callback' => 'sanitize_text_field',
        ]
    );

    add_settings_section(
        'vgpd_settings_section',
        esc_html__( 'Gallery Position', 'vertical-gallery-woocommerce' ),
        null,
        'vgpd-settings'
    );

    add_settings_field(
        'vgpd_gallery_position',
        esc_html__( 'Choose Gallery Position', 'vertical-gallery-woocommerce' ),
        'vgpd_render_position_field',
        'vgpd-settings',
        'vgpd_settings_section'
    );
}
add_action( 'admin_init', 'vgpd_register_settings' );

/**
 * Render the field for selecting the gallery position.
 * 
 * @since  1.0.0
 * @return void
 */
function vgpd_render_position_field() {
    $value = get_option( 'vgpd_gallery_position', 'right' );
    ?>
    <select name="vgpd_gallery_position" id="vgpd_gallery_position">
        <option value="right" <?php selected( $value, 'right' ); ?>>
            <?php esc_html_e( 'Right', 'vertical-gallery-woocommerce' ); ?>
        </option>
        <option value="left" <?php selected( $value, 'left' ); ?>>
            <?php esc_html_e( 'Left', 'vertical-gallery-woocommerce' ); ?>
        </option>
    </select>
    <?php
}
