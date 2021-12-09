# [Get GitHub File ](https://development.azurecurve.co.uk/classicpress-plugins/get-github-file/)
![Plugin Banner](/assets/pluginimages/banner-1544x500.png)

# Description

Gets the content of a file from a GitHub repository and outputs using the `[github-file]` shortcode.

Settings allow default options, such as author, folder, filename to be specified. Additional options to allow the removal or conversion of WordPress headers in readme.txt files.

Available shortcode parameters:
* `account` - account on GitHub
* `branch` - branch to get file from
* `folder` - folder containing the file 
* `file` - file to get from GitHub repository
* `repository` - name of GitHub repository
* `startfrom` - text in file to start outputting from (e.g. # Description)
* `htmlastext` - 1 to output HTMl as text and 0 to output as HTML
* `shortcodesastext` - 1 to output shortcodes as text and 0 to output as shortcode
* `wordpresstitles` - remove/ignore/convert

All parameters except repository can be defined as defaults in settings.

Example shortcode usage:
```
[github-file branch="master" repository="azrcrv-get-github-file"]
```

Output is in markdown, but use of a plugin such as [Markdown by azurecurve](https://dev.azrcrv.co.uk/cp_m) can convert this markdown to HTML markup.

This plugin is multisite compatible; settings need to be configured for each site.

# Installation Instructions

 * Download the latest release of the plugin from [GitHub](https://github.com/azurecurve/azrcrv-get-github-file/releases/latest/).
 * Upload the entire zip file using the Plugins upload function in your ClassicPress admin panel.
 * Activate the plugin.
 * Configure relevant settings via the configuration page in the admin control panel (azurecurve menu).

# About azurecurve

**azurecurve** was one of the first plugin developers to start developing for Classicpress; all plugins are available from [azurecurve Development](https://development.azurecurve.co.uk/) and are integrated with the [Update Manager plugin](https://directory.classicpress.net/plugins/update-manager) for fully integrated, no hassle, updates.

Some of the other plugins available from **azurecurve** are:
 * Add Twitter Cards - [details](https://development.azurecurve.co.uk/classicpress-plugins/add-twitter-cards/) / [download](https://github.com/azurecurve/azrcrv-add-twitter-cards/releases/latest/)
 * Call-out Boxes - [details](https://development.azurecurve.co.uk/classicpress-plugins/call-out-boxes/) / [download](https://github.com/azurecurve/azrcrv-call-out-boxes/releases/latest/)
 * Contact Forms - [details](https://development.azurecurve.co.uk/classicpress-plugins/contact-forms/) / [download](https://github.com/azurecurve/azrcrv-contact-forms/releases/latest/)
 * Estimated Read Time - [details](https://development.azurecurve.co.uk/classicpress-plugins/estimated-read-time/) / [download](https://github.com/azurecurve/azrcrv-estimated-read-time/releases/latest/)
 * From Twitter - [details](https://development.azurecurve.co.uk/classicpress-plugins/from-twitter/) / [download](https://github.com/azurecurve/azrcrv-from-twitter/releases/latest/)
 * Gallery From Folder - [details](https://development.azurecurve.co.uk/classicpress-plugins/gallery-from-folder/) / [download](https://github.com/azurecurve/azrcrv-gallery-from-folder/releases/latest/)
 * Page Index - [details](https://development.azurecurve.co.uk/classicpress-plugins/page-index/) / [download](https://github.com/azurecurve/azrcrv-page-index/releases/latest/)
 * Shortcodes in Comments - [details](https://development.azurecurve.co.uk/classicpress-plugins/shortcodes-in-comments/) / [download](https://github.com/azurecurve/azrcrv-shortcodes-in-comments/releases/latest/)
 * To Twitter - [details](https://development.azurecurve.co.uk/classicpress-plugins/to-twitter/) / [download](https://github.com/azurecurve/azrcrv-to-twitter/releases/latest/)
 * URL Shortener - [details](https://development.azurecurve.co.uk/classicpress-plugins/url-shortener/) / [download](https://github.com/azurecurve/azrcrv-url-shortener/releases/latest/)
