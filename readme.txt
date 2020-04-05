=== Get GitHub File ===

Description:	Gets content of GitHub file and output using shortcode.
Version:		1.0.3
Tags:			get-github-file
Author:			azurecurve
Author URI:		https://development.azurecurve.co.uk/
Plugin URI:		https://development.azurecurve.co.uk/classicpress-plugins/get-github-file/
Download link:	https://github.com/azurecurve/azrcrv-get-github-file/releases/download/v1.0.3/azrcrv-get-github-file.zip
Donate link:	https://development.azurecurve.co.uk/support-development/
Requires PHP:	5.6
Requires:		1.0.0
Tested:			4.9.99
Text Domain:	get-github-file
Domain Path:	/languages
License: 		GPLv2 or later
License URI: 	http://www.gnu.org/licenses/gpl-2.0.html

Gets content of GitHub file and output using shortcode.

== Description ==

# Description

Gets the content of a file from a GitHub repository and outputs using a shortcode.

Settings allow default options, such as author, folder, filename to be specified. Additional options to allow the removal or conversion of WordPress headers in readme.txt files.

Available shortcode parameters:
* account - account on GitHub
* branch - branch to get file from
* folder - folder containing the file 
* file - file to get from GitHub repository
* repository - name of GitHub repository
* startfrom - text in file to start outputting from (e.g. # Description)
* htmlastext - 1 to output HTMl as text and 0 to output as HTML
* shortcodesastext - 1 to output shortcodes as text and 0 to output as shortcode
* wordpresstitles - remove/ignore/convert

All parameters except repository can be defined as defaults in settings.

Output is in markdown, but use of a plugin such as [Markdown by azurecurve](https://dev.azrcrv.co.uk/cp-m) can convert this markdown to HTML markup.

This plugin is multisite compatible; settings need to be configured for each site.

== Installation ==

# Installation Instructions

 * Download the plugin from [GitHub](https://github.com/azurecurve/azrcrv-get-github-file/releases/latest/).
 * Upload the entire zip file using the Plugins upload function in your ClassicPress admin panel.
 * Activate the plugin.
 * Configure relevant settings via the configuration page in the admin control panel (azurecurve menu).

== Frequently Asked Questions ==

# Frequently Asked Questions

### Can I translate this plugin?
Yes, the .pot fie is in the plugins languages folder and can also be downloaded from the plugin page on https://development.azurecurve.co.uk; if you do translate this plugin, please sent the .po and .mo files to translations@azurecurve.co.uk for inclusion in the next version (full credit will be given).

### Is this plugin compatible with both WordPress and ClassicPress?
This plugin is developed for ClassicPress, but will likely work on WordPress.

== Changelog ==

# Changelog

### [Version 1.0.4](https://github.com/azurecurve/azrcrv-get-github-file/releases/tag/v1.0.4)
 * Fix bug with setting of default options.
 * Fix bug with plugin menu.
 * Update plugin menu css.
 * Fix bug with wordpress_title default.
 * Replace call to deprecated each PHP function.

### [Version 1.0.2](https://github.com/azurecurve/azrcrv-get-github-file/releases/tag/v1.0.2)
 * Rewrite default option creation function to resolve several bugs.
 * Upgrade azurecurve plugin to store available plugins in options.
 
### [Version 1.0.1](https://github.com/azurecurve/azrcrv-get-github-file/releases/tag/v1.0.1)
 * Update Update Manager class to v2.0.0.
 * Update azurecurve menu icon with compressed image.

### [Version 1.0.0](https://github.com/azurecurve/azrcrv-get-github-file/releases/tag/v1.0.0)
 * Initial release.

== Other Notes ==

# About azurecurve

**azurecurve** was one of the first plugin developers to start developing for Classicpress; all plugins are available from [azurecurve Development](https://development.azurecurve.co.uk/) and are integrated with the [Update Manager plugin](https://codepotent.com/classicpress/plugins/update-manager/) by [CodePotent](https://codepotent.com/) for fully integrated, no hassle, updates.

Some of the top plugins available from **azurecurve** are:
* [Add Twitter Cards](https://development.azurecurve.co.uk/classicpress-plugins/add-twitter-cards/)
* [Breadcrumbs](https://development.azurecurve.co.uk/classicpress-plugins/breadcrumbs/)
* [Series Index](https://development.azurecurve.co.uk/classicpress-plugins/series-index/)
* [To Twitter](https://development.azurecurve.co.uk/classicpress-plugins/to-twitter/)
* [Theme Switches](https://development.azurecurve.co.uk/classicpress-plugins/theme-switcher/)
* [Toggle Show/Hide](https://development.azurecurve.co.uk/classicpress-plugins/toggle-showhide/)