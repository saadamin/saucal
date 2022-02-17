<?php
/*
Plugin Name: Saucal test
Plugin URI: https://team.saucal.com/developer-task/
Description: You’re requested to implement functionality to fetch a list of elements from an API, filtering from the currently logged in user preferences for that integration (think of it as if you needed to fetch tweets from specific Twitter users).
Version: 1.0.1
Author: Saad Amin
Author URI: https://profiles.wordpress.org/saadamin/
License: GPLv2 or later
Text Domain: saucal
*/
define('SAUCAL_PLUGIN_URL', plugin_dir_url(__FILE__));
include_once('lib/widget.php');
include_once('lib/post_form.php');

function saucal_employee_endpoint()
{
    add_rewrite_endpoint('saucal_employee', EP_ROOT | EP_PAGES);
    flush_rewrite_rules();
}

add_action('init', 'saucal_employee_endpoint');

// ------------------
// 2. Add new query var

function saucal_employee_list_query_vars($vars)
{
    $vars[] = 'saucal_employee';
    return $vars;
}

add_filter('query_vars', 'saucal_employee_list_query_vars', 0);

// ------------------
// 3. Insert the new endpoint into the My Account menu

function saucal_employee_link_my_account($items)
{
    $items['saucal_employee'] = 'Saucal Employee List';
    return $items;
}

add_filter('woocommerce_account_menu_items', 'saucal_employee_link_my_account');

// ------------------
// 4. Add content to the new tab

function saucal_employee_list_content()
{
    $t = new HighestSalaryRange();
    echo $t->getForm();
}

add_action('woocommerce_account_saucal_employee_endpoint', 'saucal_employee_list_content');

add_filter('the_title', 'saucal_employee_list_endpoint_title');
function saucal_employee_list_endpoint_title($title)
{
    global $wp_query;
    $is_endpoint = isset($wp_query->query_vars['saucal_employee']);
    if ($is_endpoint && !is_admin() && is_main_query() && in_the_loop() && is_account_page()) {
        // New page title.
        $title = __('Saucal Employee List', 'woocommerce');
        remove_filter('the_title', 'saucal_employee_list_endpoint_title');
    }
    return $title;
}


// Changing order

function saucal_woocommerce_my_account_order()
{
    $myorder = array(
        'dashboard' => __('Dashboard', 'woocommerce'),
        'orders' => __('Orders', 'woocommerce'),
        'downloads' => __('Downloads', 'woocommerce'),
        'edit-address' => __('Addresses', 'woocommerce'),
        'edit-account' => __('Account details', 'woocommerce'),
        'saucal_employee' => __('Saucal Employee', 'woocommerce'),
        'customer-logout' => __('Logout', 'woocommerce'),
    );
    return $myorder;
}
add_filter('woocommerce_account_menu_items', 'saucal_woocommerce_my_account_order');
