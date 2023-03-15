<?php
/*
Plugin Name: Stylebible DB Management Plugin
Description: Stylebible DB Management
Version:     1.0.0
Author:      forever
*/

require __DIR__ . '/model/save_city.php';
require __DIR__ . '/model/save_category.php';
require __DIR__ . '/model/save_sub_category.php';
require __DIR__ . '/model/save_establishment.php';
require __DIR__ . '/model/import_excel.php';

require __DIR__ . '/view/city.php';
require __DIR__ . '/view/category.php';
require __DIR__ . '/view/sub_category.php';
require __DIR__ . '/view/establishment.php';
require __DIR__ . '/view/excel.php';

add_action('admin_menu', 'stylebible_plugin_setup_menu');
 
function stylebible_plugin_setup_menu(){
    add_menu_page('Stylebible_Manage', 'Stylebible', 'manage_options', 'stylebible_plugin', 'city_manage');
    add_submenu_page('stylebible_plugin', 'city_manage', 'City', 'manage_options', 'stylebible_plugin', 'city_manage');
    add_submenu_page('stylebible_plugin', 'category_manage', 'Category', 'manage_options', 'category_plugin', 'category_manage');
    add_submenu_page('stylebible_plugin', 'sub_category_manage', 'Sub Category', 'manage_options', 'sub_category_plugin', 'sub_category_manage');
    add_submenu_page('stylebible_plugin', 'establishment_manage', 'Establishment', 'manage_options', 'establishment_plugin', 'establishment_manage');
    add_submenu_page('stylebible_plugin', 'Stylebible', 'Import Excel', 'manage_options', 'excel_plugin', 'excel');
}

function my_enqueue($hook) {
    wp_enqueue_style('my_custom_css', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Roboto|Varela+Round');
    wp_enqueue_style('font-materials', 'https://fonts.googleapis.com/icon?family=Material+Icons');
    wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    wp_enqueue_style('jquery-datatables-css', 'https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css');
    wp_enqueue_style('datatables-bootstrap-css', 'https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap.min.css');

    wp_enqueue_script('jquery_ajax_js', "https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js");
    wp_enqueue_script('jquery_js', "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js");
    wp_enqueue_script('xlsx_js', 'https://cdn.jsdelivr.net/npm/xlsx@0.18.0/dist/xlsx.full.min.js');
    wp_enqueue_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
    wp_enqueue_script('jquery-datatables-js', 'https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js', array('jquery'));
    wp_enqueue_script('jquery-blockUI', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js', array('jquery'), '2.7', true);
}

add_action('admin_enqueue_scripts', 'my_enqueue');