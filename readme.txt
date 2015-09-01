=== Plugin Name ===
Contributors: SylvainMarty
Tags: breadcrumb, bootstrap, css, stylesheet, generate breadcrumb, plugin, wordpress
Requires at least: 3.0.1
Tested up to: 4.3.0
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display your Wordpress breadcrumb with Bootstrap 3.

== Description ==

It's a really simple Wordpress plugin which allow you, great front-end developper, to generate easily an enhanced breadcrumb with Bootstrap Framework v3.0.
Bootstrap breadcrumb use the Wordpress API for generate the breadcrumb in function to your website.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `bootstrap-breadcrumb.php` to the `/wp-content/plugins/bootstrap-breadcrumb/` directory
1. Activate the plugin through the *Plugins* menu in WordPress
1. Place the next code in your page template :
```
<?php 
if( function_exists('bootstrap_breadcrumb') )
	bootstrap_breadcrumb();
?>
```

== Frequently Asked Questions ==

= Can I use my existing WordPress theme ? =

Yes, you can use Bootstrap breadcrumbs plugin with nearly every WordPress theme.

= Where can I find documentation ? =

Docs can be found on [GitHub](https://github.com/SylvainMarty/wordpress-bootstrap-breadcrumb "GitHub repository").

== Screenshots ==

1. The breadcrumb

== Changelog ==

= 1.0 =
* First stable version
