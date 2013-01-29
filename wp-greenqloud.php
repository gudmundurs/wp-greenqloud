<?php
/*
Plugin Name: GreenQloud for WordPress
Plugin URI: http://www.greenqloud.com
Description: Allows you to retrieve and delete objects stored in GreenQloud Storage and post them in WordPress.
Author: Joe Tan, GreenQloud, Gudmundur Jonsson
Version: 0.4
Author URI: http://greenqloud.com

Copyright (C) 2008 Joe Tan, 
Copyright (C) 2012, Gudmundur Jonsson
Copyright (C) 2012 GreenQloud

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA


*/
if (class_exists('GreenQloudWordPressPlugin')) return;

// s3 lib requires php5
if (strpos($_SERVER['REQUEST_URI'], '/wp-admin/') >= 0) { // just load in admin
	$ver = get_bloginfo('version');
    if (version_compare(phpversion(), '5.0', '>=') && version_compare($ver, '2.1', '>=')) {
        require_once(dirname(__FILE__).'/wp-greenqloud/class-plugin.php');
        $GreenQloudWordPressPlugin = new GreenQloudWordPressPlugin();
	} elseif (ereg('wordpress-mu-', $ver)) {
        require_once(dirname(__FILE__).'/wp-greenqloud/class-plugin.php');
        $GreenQloudWordPressPlugin = new GreenQloudWordPressPlugin();
    } else {
        class TanTanWordPressS3Error {
        function TanTanWordPressS3Error() {add_action('admin_menu', array(&$this, 'addhooks'));}
        function addhooks() {add_options_page('GreenQloud', 'GreenQloud', 10, __FILE__, array(&$this, 'admin'));}
        function admin(){include(dirname(__FILE__).'/wp-greenqloud/admin-version-error.html');}
        }
        $error = new TanTanWordPressS3Error();
    }
} else {
    require_once(dirname(__FILE__).'/wp-greenqloud/class-plugin-public.php');
    $GreenQloudWordPressPlugin = new GreenQloudWordPressPluginPublic();
}
?>