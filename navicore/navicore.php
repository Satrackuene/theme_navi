<?php
/**
 * Plugin Name: naviCore
 * Description: Funcionalidades de campañas recall y buscador de vehículos
 * Version: 0.1.7
 * Author: ChatGPT
 */

if (!defined('ABSPATH')) {
  exit;
}

define('NAVICORE_PATH', plugin_dir_path(__FILE__));
define('NAVICORE_URL', plugin_dir_url(__FILE__));
define('NAVICORE_VERSION', '0.1.7');

require_once NAVICORE_PATH . 'includes/class-vehicles.php';
require_once NAVICORE_PATH . 'includes/class-recall-cpt.php';
require_once NAVICORE_PATH . 'includes/class-rest.php';
require_once NAVICORE_PATH . 'includes/class-shortcode.php';
require_once NAVICORE_PATH . 'includes/class-admin.php';
require_once NAVICORE_PATH . 'includes/class-navicore.php';

register_activation_hook(__FILE__, array('Navicore\\Vehicles', 'install'));

Navicore\Plugin::instance();