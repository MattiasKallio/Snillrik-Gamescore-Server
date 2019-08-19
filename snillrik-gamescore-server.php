<?php
/**
 * Plugin Name: Snillrik Gamescore server
 * Plugin URI: http://webbigt.se/wordpress/plugins/gamescore server
 * Description: Well, it's me Kallio making a games score server
 * Version: 0.1
 * Author: Mattias Kallio
 * Author URI: http://webbigt.se
 * Text Domain: snillrik-gamescore-server
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

require_once( WP_PLUGIN_DIR . '/snillrik-gamescore-server/SNGS_Settings.php' );
require_once( WP_PLUGIN_DIR . '/snillrik-gamescore-server/SNGS_User.php' );
require_once( WP_PLUGIN_DIR . '/snillrik-gamescore-server/SNGS_Shortcodes.php' );

new SNGS_User();
new SNGS_Settings();
new SNGS_Shortcodes();