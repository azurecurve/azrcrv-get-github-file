<?php
/**
 * ------------------------------------------------------------------------------
 * Plugin Name:		Get GitHub File
 * Description:		Get file from GitHub repository and output file using github-file shortcode
 * Version:			1.2.5
 * Requires	CP:		1.0
 * Requires PHP:	7.4
 * Author:			azurecurve
 * Author URI:		https://development.azurecurve.co.uk/classicpress-plugins/
 * Plugin URI:		https://development.azurecurve.co.uk/classicpress-plugins/get-github-file/
 * Donate link:		https://development.azurecurve.co.uk/support-development/
 * Text Domain:		get-github-file
 * Domain Path:		/languages
 * License:			GPLv2 or later
 * License URI:		http://www.gnu.org/licenses/gpl-2.0.html
 * ------------------------------------------------------------------------------
 * This is free software released under the terms of the General Public License,
 * version 2, or later. It is distributed WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Full
 * text of the license is available at https://www.gnu.org/licenses/gpl-2.0.html.
 * ------------------------------------------------------------------------------
 */

// Prevent direct access.
if (!defined('ABSPATH')){
	die();
}

// include plugin menu
require_once(dirname(__FILE__).'/pluginmenu/menu.php');
add_action('admin_init', 'azrcrv_create_plugin_menu_gghf');

// include update client
require_once(dirname(__FILE__).'/libraries/updateclient/UpdateClient.class.php');

/**
 * Setup registration activation hook, actions, filters and shortcodes.
 *
 * @since 1.0.0
 *
 */
// add actions
add_action('admin_menu', 'azrcrv_gghf_create_admin_menu');
add_action('admin_post_azrcrv_gghf_save_options', 'azrcrv_gghf_save_options');

// add filters
add_filter('plugin_action_links', 'azrcrv_gghf_add_plugin_action_link', 10, 2);
add_filter('codepotent_update_manager_image_path', 'azrcrv_gghf_custom_image_path');
add_filter('codepotent_update_manager_image_url', 'azrcrv_gghf_custom_image_url');

// add shortcodes
add_shortcode('github-file', 'azrcrv_gghf_get_github_file_shortcode');

/**
 * Custom plugin image path.
 *
 * @since 1.1.0
 *
 */
function azrcrv_gghf_custom_image_path($path){
    if (strpos($path, 'azrcrv-get-github-file') !== false){
        $path = plugin_dir_path(__FILE__).'assets/pluginimages';
    }
    return $path;
}

/**
 * Custom plugin image url.
 *
 * @since 1.1.0
 *
 */
function azrcrv_gghf_custom_image_url($url){
    if (strpos($url, 'azrcrv-get-github-file') !== false){
        $url = plugin_dir_url(__FILE__).'assets/pluginimages';
    }
    return $url;
}

/**
 * Get options including defaults.
 *
 * @since 1.1.0
 *
 */
function azrcrv_gghf_get_option($option_name){
 
	$defaults = array(
						'default_account' => '',
						'default_branch' => 'master',
						'default_folder' => '',
						'default_file' => 'README.md',
						'html_as_text' => 1,
						'shortcodes_as_text' => 1,
						'wordpress_titles' => "remove",
						'heading1' => '#####',
						'heading2' => '###',
						'heading3' => '#',
						'start_from_section' => '',
					);

	$options = get_option($option_name, $defaults);

	$options = wp_parse_args($options, $defaults);

	return $options;

}

/**
 * Add plugin action link on plugins page.
 *
 * @since 1.0.0
 *
 */
function azrcrv_gghf_add_plugin_action_link($links, $file){
	static $this_plugin;

	if (!$this_plugin){
		$this_plugin = plugin_basename(__FILE__);
	}

	if ($file == $this_plugin){
		$settings_link = '<a href="'.admin_url('admin.php?page=azrcrv-gghf').'"><img src="'.plugins_url('/pluginmenu/images/logo.svg', __FILE__).'" style="padding-top: 2px; margin-right: -5px; height: 16px; width: 16px;" alt="azurecurve" />'.esc_html__('Settings' ,'get-github-file').'</a>';
		array_unshift($links, $settings_link);
	}

	return $links;
}

/**
 * Add to menu.
 *
 * @since 1.0.0
 *
 */
function azrcrv_gghf_create_admin_menu(){
	//global $admin_page_hooks;
	
	add_submenu_page("azrcrv-plugin-menu"
						,esc_html__("Get GitHub File Settings", 'get-github-file')
						,esc_html__("Get GitHub File", 'get-github-file')
						,'manage_options'
						,'azrcrv-gghf'
						,'azrcrv_gghf_display_options');
}

/**
 * Check if function active (included due to standard function failing due to order of load).
 *
 * @since 1.0.0
 *
 */
function azrcrv_gghf_is_plugin_active($plugin){
    return in_array($plugin, (array) get_option('active_plugins', array()));
}

/**
 * Display Settings page.
 *
 * @since 1.0.0
 *
 */
function azrcrv_gghf_display_options(){
	if (!current_user_can('manage_options')){
        wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'get-github-file'));
    }
	
	// Retrieve plugin configuration options from database
	$options = azrcrv_gghf_get_option('azrcrv-gghf');
	?>
	<div id="azrcrv-gghf-general" class="wrap">
		<fieldset>
			<h1>
				<?php
					echo '<a href="https://development.azurecurve.co.uk/classicpress-plugins/"><img src="'.plugins_url('/pluginmenu/images/logo.svg', __FILE__).'" style="padding-right: 6px; height: 20px; width: 20px;" alt="azurecurve" /></a>';
					esc_html_e(get_admin_page_title());
				?>
			</h1>
			
			<?php if(isset($_GET['settings-updated'])){ ?>
				<div class="notice notice-success is-dismissible">
					<p><strong><?php esc_html_e('Settings have been saved.', 'get-github-file'); ?></strong></p>
				</div>
			<?php } ?>
			
			<form method="post" action="admin-post.php">
			
				<input type="hidden" name="action" value="azrcrv_gghf_save_options" />
				<input name="page_options" type="hidden" value="default_account,default_folder,default_file,heading1,heading2,heading3,start_from_section,wordpress_titles,html_as_text" />
				
				<!-- Adding security through hidden referrer field -->
				<?php wp_nonce_field('azrcrv-gghf', 'azrcrv-gghf-nonce'); ?>
				<table class="form-table">
				
				<tr><th scope="row"><label for="default_account"><?php esc_html_e('Default Account', 'get-github-file'); ?></label></th><td>
					<input type="text" name="default_account" value="<?php echo esc_html(stripslashes($options['default_account'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e('Default GitHub account.', 'get-github-file'); ?></p>
				</td></tr>
				
				<tr><th scope="row"><label for="default_folder"><?php esc_html_e('Default Folder', 'get-github-file'); ?></label></th><td>
					<input type="text" name="default_folder" value="<?php echo esc_html(stripslashes($options['default_folder'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e('Default GitHub folder (only required if file not in root).', 'get-github-file'); ?></p>
				</td></tr>
				
				<tr><th scope="row"><label for="default_branch"><?php esc_html_e('Default Branch', 'get-github-file'); ?></label></th><td>
					<input type="text" name="default_branch" value="<?php echo esc_html(stripslashes($options['default_branch'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e('Default GitHub branch.', 'get-github-file'); ?></p>
				</td></tr>
				
				<tr><th scope="row"><label for="default_file"><?php esc_html_e('Default File', 'get-github-file'); ?></label></th><td>
					<input type="text" name="default_file" value="<?php echo esc_html(stripslashes($options['default_file'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e('Default GitHub file.', 'get-github-file'); ?></p>
				</td></tr>
				
				<tr><th scope="row"><label for="html_as_text"><?php esc_html_e('Output HTML as text?', 'get-github-file'); ?></label></th><td>
					<fieldset><legend class="screen-reader-text"><span>HTML output as text</span></legend>
						<label for="html_as_text"><input name="html_as_text" type="checkbox" id="html_as_text" value="1" <?php checked('1', $options['html_as_text']); ?> /><?php esc_html_e('Output HTML as simple text', 'get-github-file'); ?></label>
					</fieldset>
				</td></tr>
				
				<tr><th scope="row"><label for="shortcodes_as_text"><?php esc_html_e('Output shortcodes as text?', 'get-github-file'); ?></label></th><td>
					<fieldset><legend class="screen-reader-text"><span>Shortcode output as text</span></legend>
						<label for="shortcodes_as_text"><input name="shortcodes_as_text" type="checkbox" id="shortcodes_as_text" value="1" <?php checked('1', $options['shortcodes_as_text']); ?> /><?php esc_html_e('Output shortcodes as simple text', 'get-github-file'); ?></label>
					</fieldset>
				</td></tr>
				
				<tr><th scope="row"><label for="start_from_section"><?php esc_html_e('Start reading from...', 'get-github-file'); ?></label></th><td>
					<input type="text" name="start_from_section" value="<?php echo esc_html(stripslashes($options['start_from_section'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e('Start reading file from section of text such as "== Description ==".', 'get-github-file'); ?></p>
					<p class="description"><?php esc_html_e('If the entered text cannot be found, the whole file is read.', 'get-github-file'); ?></p>
				</td></tr>
				
				<tr><th scope="row"><label for="wordpress_titles"><?php esc_html_e('ClassicPress titles?', 'get-github-file'); ?></label></th><td>
					<select name="wordpress_titles">
						<option value="convert" <?php if($options['wordpress_titles'] == 'convert'){ echo ' selected="selected"'; } ?>><?php esc_html_e('Convert using settings below', 'get-github-file'); ?></option>
						<option value="remove" <?php if($options['wordpress_titles'] == 'remove'){ echo ' selected="selected"'; } ?>><?php esc_html_e('Remove from output', 'get-github-file'); ?></option>
						<option value="leave" <?php if($options['wordpress_titles'] == 'leave'){ echo ' selected="selected"'; } ?>><?php esc_html_e('Leave in output untouched', 'get-github-file'); ?></option>
					</select>
					<p class="description"><?php esc_html_e('What should be done with ==ClassicPress titles ==? If "Convert" is selected, the settings below will be used.', 'get-github-file'); ?></p>
				</td></tr>
				
				<tr><th scope="row"><label for="heading3"><?php esc_html_e('Convert Heading "=" to:', 'get-github-file'); ?></label></th><td>
					<input type="text" name="heading3" value="<?php echo esc_html(stripslashes($options['heading3'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e('Convert "=" heading to markdown tag such as "#####".', 'get-github-file'); ?></p>
				</td></tr>
				
				<tr><th scope="row"><label for="heading2"><?php esc_html_e('Convert Heading "==" to:', 'get-github-file'); ?></label></th><td>
					<input type="text" name="heading2" value="<?php echo esc_html(stripslashes($options['heading2'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e('Convert "==" heading to markdown tag such as "###".', 'get-github-file'); ?></p>
				</td></tr>
				
				<tr><th scope="row"><label for="heading1"><?php esc_html_e('Convert Heading "===" to:', 'get-github-file'); ?></label></th><td>
					<input type="text" name="heading1" value="<?php echo esc_html(stripslashes($options['heading1'])); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e('Convert "===" heading to markdown tag such as "#".', 'get-github-file'); ?></p>
				</td></tr>
				
				</table>
				<input type="submit" value="<?php esc_html_e('Save Changes', 'get-github-file'); ?>" class="button-primary"/>
			</form>
		</fieldset>
	</div>
	<?php
}

/**
 * Save settings.
 *
 * @since 1.0.0
 *
 */
function azrcrv_gghf_save_options(){
	// Check that user has proper security level
	if (!current_user_can('manage_options')){
		wp_die(esc_html__('You do not have permissions to perform this action', 'get-github-file'));
	}
	// Check that nonce field created in configuration form is present
	if (! empty($_POST) && check_admin_referer('azrcrv-gghf', 'azrcrv-gghf-nonce')){
	
		// Retrieve original plugin options array
		$options = get_option('azrcrv-gghf');
		
		$option_name = 'default_account';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		$option_name = 'default_folder';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		$option_name = 'default_file';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		$option_name = 'default_branch';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		
		$option_name = 'html_as_text';
		if (isset($_POST[$option_name])){
			$options[$option_name] = 1;
		}else{
			$options[$option_name] = 0;
		}
		
		$option_name = 'shortcodes_as_text';
		if (isset($_POST[$option_name])){
			$options[$option_name] = 1;
		}else{
			$options[$option_name] = 0;
		}
		
		$option_name = 'start_from_section';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		
		$option_name = 'wordpress_titles';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		$option_name = 'heading1';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		$option_name = 'heading2';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		$option_name = 'heading3';
		if (isset($_POST[$option_name])){
			$options[$option_name] = sanitize_text_field($_POST[$option_name]);
		}
		
		// Store updated options array to database
		update_option('azrcrv-gghf', $options);
		
		// Redirect the page to the configuration form that was processed
		wp_redirect(add_query_arg('page', 'azrcrv-gghf&settings-updated', admin_url('admin.php')));
		exit;
	}
}

/**
 * Check if function active (included due to standard function failing due to order of load).
 *
 * @since 1.0.0
 *
 */
function azrcrv_gghf_get_github_file_shortcode($atts, $content = null){
	
	$options = azrcrv_gghf_get_option('azrcrv-gghf');
	
	$args = shortcode_atts(array(
		'account' => stripslashes($options['default_account']),
		'branch' => stripslashes($options['default_branch']),
		'folder' => stripslashes($options['default_folder']),
		'file' => stripslashes($options['default_file']),
		'repository' => '',
		'startfrom' => stripslashes($options['start_from_section']),
		'htmlastext' => $options['html_as_text'],
		'shortcodesastext' => $options['shortcodes_as_text'],
		'wordpresstitles' => $options['wordpress_titles'],
	), $atts);
	$account = $args['account'];
	$folder = $args['folder'];
	$file = $args['file'];
	$branch = $args['branch'];
	$repository = $args['repository'];
	$startfrom = $args['startfrom'];
	$htmlastext = $args['htmlastext'];
	$shortcodesastext = $args['htmlastext'];
	
	if (strlen($folder) > 0){ $folder = trailingslashit($folder); }
	
	$path = "https://raw.githubusercontent.com/$account/$repository/$branch/$folder$file";
	
	$string = file_get_contents($path);
	
    if($string === FALSE) {
         return "Could not get the file.";
    }
	
    $file = explode("\n", $string);
	
	
	$output = array();
	$started = false;
    //while (list($linenumber, $line) = each($file)) {
	foreach ($file as $line){
		
		$line = trim($line);
		
		if ($line == $startfrom){
			$started = true;
		}
		
		if ($started == true){
			if (substr($line, -3) == '===' AND $options['wordpress_titles'] == "convert"){
				$line = substr($line, 3, -3);
				$line = esc_html($options['heading1']).' '.$line;
			}elseif (substr($line, -2) == '==' AND $options['wordpress_titles'] == "convert"){
				$line = substr($line, 2, -2);
				$line = esc_html($options['heading2']).' '.$line;
			}elseif (substr($line, -1) == '=' AND $options['wordpress_titles'] == "convert"){
				$line = substr($line, 1, -1);
				$line = esc_html($options['heading3']).' '.$line;
			}elseif ($options['wordpress_titles'] == "remove" AND substr($line, -1) == '='){
				$line = '';
			}
			
			$output[] = $line;
		}
    }
	if ($started == false){
		$output[] = $string;
	}
	
	$output = implode("\n", $output);
	
	if ($shortcodesastext == 1){
		global $shortcode_tags;
		// loop through registered shortcodes 
		foreach ($shortcode_tags as $shortcode => $func){
			// [shortcode parameters]content[/shortcode]
			$output = preg_replace("/\[$shortcode (.*?)\](.*?)\[\/$shortcode\]/", "[[$shortcode $1]]$2[[$shortcode]]", $output);
			// [shortcode parameters]
			$output = preg_replace("/\[$shortcode (.*?)\]/", "[[$shortcode $1]]", $output);
			// [shortcode=value]
			$output = preg_replace("/\[$shortcode=(.*?)\]/", "[[$shortcode=$1]]", $output);
			// [shortcode]
			$output = preg_replace("/\[$shortcode\]/", "[[$shortcode]]", $output);
		}
	}
	
	if ($htmlastext == 1){
		$output = str_replace('<', '&lt;', str_replace('>', '&gt;', $output));
	}
	return '<div class="azrcrv-gghf">' . $output . '</div>';

}
