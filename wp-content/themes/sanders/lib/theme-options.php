<?php

	if (!current_user_can('manage_options'))
		wp_die(__('You do not have sufficient permissions to manage options for this site.'));
		
	// Options Whitelist
	$options = array('homepage_mid_feature');


	if (isset($_POST) && !empty($_POST))
	{
		foreach ($options as $option) 
		{
			$value = null;
			
			if (isset($_POST[$option]))
				$value = $_POST[$option];
				
			if (!is_array($value))
				$value = trim($value);
				
			$value = stripslashes_deep($value);
			
			update_option($option, $value);
		}
	
		/**
		 * Handle settings errors and return to options page
		 */
		 
		// If no settings errors were registered add a general 'updated' message.
		if (!count(get_settings_errors()))
			add_settings_error('general', 'settings_updated', __('Settings saved.'), 'updated');
			
		set_transient('settings_errors', get_settings_errors(), 30);
		
		/**
		 * Redirect back to the settings page that was submitted
		 */
		$goback = add_query_arg('settings-updated', 'true', wp_get_referer());
		
		//if ($errors & isset($_GET['noheader']))
        //    require_once(ABSPATH . 'wp-admin/admin-header.php');
		
		wp_redirect($goback);
		exit;
	}
	
	function custom_settings_row($key, $label, $type = 'text', $values = array())
	{
		$output = '<tr valign="top">'
				. '<th scope="row"><label for="' . $key . '">' . $label . '</label></th>';
		
		if ($type == 'select')
		{
			$output .= '<td><select name="' . $key . '" id="' . $key . '">';
			
			foreach ($values as $k => $v)
				$output .= '<option value="' . $k . '"' . (get_option($key) == $k ? ' selected="selected"' : '') . '>' . $v . '</option>';
			
			$output .= '</select></td>';
		}
		else
		{
			$output .= '<td><input name="' . $key . '" type="' . $type . '" id="' . $key . '" value="' . get_option($key) . '" class="regular-text" /></td>';
		}
		
		$output .= '</tr>';
				
		return $output;
	}
?>

<div class="wrap">
	<div id="icon-themes" class="icon32"><br></div>
	<h2>Theme Options</h2>
	
	<?php if (isset($_GET['settings-updated'])): ?>
		<div id="setting-error-settings_updated" class="updated settings-error"> 
			<p><strong>Settings saved.</strong></p>
		</div>
	<?php endif; ?>
	
	<form method="post" action="?page=theme_options&noheader=true">
		<table class="form-table">
			<tbody>
				<?php 
				
					$pageValues = array();
					
					foreach(get_pages() as $page)
						$pageValues[$page->ID] = $page->post_title;
					
					
					echo custom_settings_row($options[0], 'Homepage Feature Page', 'select', $pageValues); 
				?>
			</tbody>
		</table>
		
		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button-primary" value="Save Changes">
		</p>
	</form>

</div><!-- / wrap -->