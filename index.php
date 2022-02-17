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
