<?php

/**
  * The plugin bootstrap file
  *
  * @link              https://robertdevore.com
  * @since             1.0.0
  * @package           Vertical_Gallery_Product_Display
  *
  * @wordpress-plugin
  *
  * Plugin Name: Vertical Gallery Product Display for WooCommerce®
  * Description: Moves the WooCommerce product gallery to a vertical layout on single product pages.
  * Plugin URI:  https://github.com/robertdevore/vertical-gallery-product-display/
  * Version:     1.0.0
  * Author:      Robert DeVore
  * Author URI:  https://robertdevore.com/
  * License:     GPL-2.0+
  * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
  * Text Domain: vertical-gallery-woocommerce
  * Domain Path: /languages
  * Update URI:  https://github.com/robertdevore/vertical-gallery-product-display/
  */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

require 'includes/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/robertdevore/vertical-gallery-product-display/',
	__FILE__,
	'vertical-gallery-product-display'
);

// Set the branch that contains the stable release.
$myUpdateChecker->setBranch( 'main' );

// Define the plugin version.
define( 'VGPD_VERSION', '1.0.0' );

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
            plugin_dir_url( __FILE__ ) . 'css/vgpd-styles.css',
            [],
            VGPD_VERSION
        );

        wp_enqueue_script(
            'vgpd-scripts',
            plugin_dir_url( __FILE__ ) . 'js/vgpd-scripts.js',
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
