<?php
/**
 * Plugin Name: BP Codeable Users Test
 * Description:  Adds Admin page with ajax enabled list table of all the users and their roles. (<strong>This is just a job-application test</strong>)
 * Version: 1.0
 * Author: Viktor Panteleev
 * Author URI: https://www.vpanteleev.com
 * License: GPLv2
 * Text Domain: bpcut
 */
 
define('BPCUT_PLUGIN_DIR', dirname(__FILE__));
define('BPCUT_PLUGIN_DIR_FULL', plugin_dir_path(__FILE__));
define('BPCUT_VERSION', '1.0');

define('BPCUT_PLUGIN_VIEWS_DIR', BPCUT_PLUGIN_DIR_FULL . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR );

if ( !function_exists( 'add_action' ) ) {
    exit;
}

require_once('autoloader.php');
require_once('init.php');
