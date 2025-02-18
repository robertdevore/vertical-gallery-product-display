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
  * Version:     1.1.0
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

require 'includes/enqueue.php';
require 'includes/admin-settings.php';

require 'vendor/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/robertdevore/vertical-gallery-product-display/',
	__FILE__,
	'vertical-gallery-product-display'
);

// Set the branch that contains the stable release.
$myUpdateChecker->setBranch( 'main' );

// Define the plugin version.
define( 'VGPD_VERSION', '1.1.0' );
define( 'VGPD_PLUGIN_FILE', __FILE__ );

// Check if Composer's autoloader is already registered globally.
if ( ! class_exists( 'RobertDevore\WPComCheck\WPComPluginHandler' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use RobertDevore\WPComCheck\WPComPluginHandler;

new WPComPluginHandler( plugin_basename( __FILE__ ), 'https://robertdevore.com/why-this-plugin-doesnt-support-wordpress-com-hosting/' );

/**
 * Load plugin text domain for translations
 * 
 * @since 1.1.0
 * @return void
 */
function vgpd_load_textdomain() {
    load_plugin_textdomain( 
        'vertical-gallery-woocommerce', 
        false, 
        dirname( plugin_basename( __FILE__ ) ) . '/languages/'
    );
}
add_action( 'plugins_loaded', 'vgpd_load_textdomain' );
