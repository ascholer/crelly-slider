<?php
/**
 * Plugin Name: OCSTA Crelly Slider
 * Plugin URI: https://github.com/ascholer/crelly-slider
 * Description: A free responsive slider that supports layers. Add texts, images, videos and beautify them with transitions and animations. Fork customized for OCSTA by Andrew Scholer.
 * Version: 1.3.5
 * Author: Fabio Rinaldi
 * Text Domain: ocsta-crelly-slider
 * License: MIT
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*************/
/** GLOBALS **/
/*************/

define('CS_DEBUG', false);

define('CS_VERSION', '1.3.5');
define('CS_MIN_CAPABILITY', 'manage_options');
define('CS_PATH', plugin_dir_path(__FILE__));
define('CS_PLUGIN_URL', plugins_url() . '/ocsta-slider');

require_once CS_PATH . 'wordpress/common.php';
require_once CS_PATH . 'wordpress/tables.php';
require_once CS_PATH . 'wordpress/frontend.php';

// Create (or remove) 3 tables: the sliders settings, the slides settings and the elements proprieties. We will also store the current version of the plugin
register_activation_hook(__FILE__, array('CrellySliderTables', 'setVersion'));
register_activation_hook(__FILE__, array('CrellySliderTables', 'setTables'));
register_uninstall_hook(__FILE__, array('CrellySliderTables', 'clearDatabase'));

// This is a variable that should be included first to prevent backend issues.
if(is_admin()) {
	require_once CS_PATH . 'wordpress/admin.php';
	CrellySliderAdmin::setIsAdminJs();
}

// CSS and Javascript
CrellySliderCommon::setEnqueues();

CrellySliderFrontend::addShortcode();

if(is_admin()) {
	// Tables
	if(CS_DEBUG || CS_VERSION != get_option('cs_version')) {
		CrellySliderTables::setTables();
	}
	if(CS_VERSION != get_option('cs_version')) {
		CrellySliderTables::setVersion();
	}

	CrellySliderAdmin::setEnqueues();
	CrellySliderAdmin::showSettings();

	// Ajax functions
	require_once CS_PATH . 'wordpress/ajax.php';
}
?>
