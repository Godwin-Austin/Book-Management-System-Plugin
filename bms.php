<?php
/*
Plugin Name:Book Management System
Plugin URI : https://example.com/books-management-system
Description:Plugin to  manage all books
Author:Divyank
Version:1.0.0
Author URI: http://yourdomain.com
License: GPL2
*/

define("BMS_PLUGIN_PATH", plugin_dir_path(__FILE__));
define("BMS_PLUGIN_URL", plugin_dir_url(__FILE__));
define("BMS_PLUGIN_BASENAME", plugin_basename(__FILE__));
include_once BMS_PLUGIN_PATH . 'class/BooksManagement.php';

$Books_Management_Object = new BooksManagement();

register_activation_hook(
    __FILE__,
    array(
        $Books_Management_Object,
        "CREATE_TABLE_BMS"
    )
);
register_deactivation_hook(
    __FILE__,
    array(
        $Books_Management_Object,
        "DROP_TABLE_BMS"
    )
);

add_action('wp_ajax_bms_action', array($Books_Management_Object, 'bms_handle_ajax_request'));
