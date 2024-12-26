<?php

/*
 * Plugin Name: A.I Autocontent for Elementor
 * Version: 1.1
 * Plugin URI: https://codecanyon.net/item/ai-autocontent-for-elementor/42761346
 * Description: An awesome plugin that allows you to automatically generate pertinent and SEO optimized content directly from Elementor
 * Author: Biscay Charly (loopus)
 * Author URI: https://loopus.tech
 * Requires at least: 5.7
 * Tested up to: 6.5
 *
 * @package WordPress
 * @author Biscay Charly (loopus)
 * @since 1.0.0
 */

if (!defined('ABSPATH'))
    exit;


global $jal_db_version;
$jal_db_version = "1.1";

require_once('includes/aace_core.php');
require_once('includes/aace_admin.php');

function aace_ElementorAutoContent() {
    $version = 1.1;
    $instance = aace_core::instance(__FILE__, $version);
    if (is_null($instance->menu)) {
        $instance->menu = aace_admin::instance($instance);
    }
    return $instance;
}


aace_ElementorAutoContent();
