<?php
/*
Plugin Name: constant contact
Plugin URI: http://www.gopiplus.com/work/2010/07/18/constant-contact/
Description: This constant contact form plugin automatically add your subscribers email address into your constantcontact.com account.
Author: Gopi Ramasamy
Version: 10.6
Author URI: http://www.gopiplus.com/work/2010/07/18/constant-contact/
Donate link: http://www.gopiplus.com/work/2010/07/18/constant-contact/
Text Domain: constant-contact
Domain Path: /languages
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

global $wpdb, $wp_version;

function gcc_show()
{
	if(get_option('gcc_username') <> "enter username") 
	{
		?>
		<div>
		  <div class="gcc_caption"><?php echo get_option('gcc_caption'); ?></div>
		  <div class="gcc_msg"><span id="gcc_msg"></span></div>
		  <div class="gcc_textbox"><input class="gcc_textbox_class" name="gcc_txt_email" onkeypress="if(event.keyCode==13) gcc_submit_form(this.parentNode,'<?php echo home_url(); ?>')" onblur="if(this.value=='') this.value='<?php echo get_option('gcc_with_in_textbox'); ?>';" onfocus="if(this.value=='<?php echo get_option('gcc_with_in_textbox'); ?>') this.value='';" id="gcc_txt_email" value="<?php echo get_option('gcc_with_in_textbox'); ?>" maxlength="150" type="text"></div>
		  <div class="gcc_button">
			<input class="gcc_textbox_button" type="button" name="gcc_txt_Button" onClick="javascript:gcc_submit_form(this.parentNode,'<?php echo home_url(); ?>');" id="gcc_txt_Button" value="<?php echo get_option('gcc_button'); ?>">
		  </div>
		</div>
		<?php 
	}
	else
	{
		?><div>Under Construction.</div><?php
	}
}

function gcc_activation()
{
	global $wpdb;
	$url = home_url();
	add_option('gcc_username', "enter username");
	add_option('gcc_password', "enter password");
	add_option('gcc_group', "General Interest");
	add_option('gcc_title', "Newsletter");
	add_option('gcc_caption', "Sign up for Hints & Tips e-Newsletter");
	add_option('gcc_adminemail', "admin@youremail.com");
	add_option('gcc_fromemail', "noreply@youremail.com");
	add_option('gcc_with_in_textbox', "Email:");
	add_option('gcc_button', "Submit");
	add_option('gcc_adminmail', "YES");
	add_option('gcc_adminmail_subject', "New email subscription");
	add_option('gcc_adminmail_content', "Hi Admin, We have received a request to subscribe new email address to receive emails from our website. Thank you.");
	add_option('gcc_usermail', "YES");
	add_option('gcc_usermail_subject', "Confirm subscription");
	add_option('gcc_usermail_content', "Hi User, We have received a request to subscribe this email address to receive newsletter from our website. Thank you.");
	add_option('gcc_homeurl', $url);
}

function gcc_widget($args) 
{
	extract($args);
	echo $before_widget;
	echo $before_title;
	echo get_option('gcc_title');
	echo $after_title;
	gcc_show();
	echo $after_widget;
}

function gcc_control() 
{
	echo '<p><b>';
	_e('Constant contact form', 'constant-contact');
	echo '.</b> ';
	_e('Check official website for more information', 'constant-contact');
	?> <a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/constant-contact/"><?php _e('click here', 'constant-contact'); ?></a></p><?php
}

function gcc_admin_options()
{
	?>
	<div class="wrap">
		<div class="form-wrap">
			<div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
			<h2><?php _e('Constant contact', 'constant-contact'); ?></h2>
			<p class="description">
				<?php _e('Constant Contact is an online email marketing service that allows businesses to stay connected to their customers via email, surveys and event marketing.', 'constant-contact'); ?>
				<?php _e('This service can send thousands of emails at one time and maintain status reports. Learn more about Constant Contact : http://www.constantcontact.com/', 'constant-contact'); ?>
			</p>	
			<p class="description">
				<?php _e('Check official website for more information and live demo', 'constant-contact'); ?>
				<a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/constant-contact/"><?php _e('click here', 'constant-contact'); ?></a>
			</p>
			<p class="description"></p>
			<?php
			$gcc_username = get_option('gcc_username');
			$gcc_password = get_option('gcc_password');
			$gcc_group = get_option('gcc_group');
			$gcc_title = get_option('gcc_title');
			$gcc_caption = get_option('gcc_caption');
			$gcc_adminemail = get_option('gcc_adminemail');
			$gcc_with_in_textbox = get_option('gcc_with_in_textbox');
			$gcc_button = get_option('gcc_button');
			$gcc_fromemail = get_option('gcc_fromemail');
			$gcc_adminmail = get_option('gcc_adminmail');
			$gcc_adminmail_subject = get_option('gcc_adminmail_subject');
			$gcc_adminmail_content = get_option('gcc_adminmail_content');
			$gcc_usermail = get_option('gcc_usermail');
			$gcc_usermail_subject = get_option('gcc_usermail_subject');
			$gcc_usermail_content = get_option('gcc_usermail_content');
			$gcc_homeurl = get_option('gcc_homeurl');
			
			if (isset($_POST['gcc_submit'])) 
			{	
				check_admin_referer('gcc_form_setting');
				
				$gcc_username = stripslashes(sanitize_text_field($_POST['gcc_username']));
				$gcc_password = stripslashes(sanitize_text_field($_POST['gcc_password']));
				$gcc_group = stripslashes(sanitize_text_field($_POST['gcc_group']));		
				$gcc_title = stripslashes(sanitize_text_field($_POST['gcc_title']));
				$gcc_caption = stripslashes(sanitize_text_field($_POST['gcc_caption']));
				$gcc_adminemail = stripslashes(sanitize_text_field($_POST['gcc_adminemail']));
				$gcc_with_in_textbox = stripslashes(sanitize_text_field($_POST['gcc_with_in_textbox']));
				$gcc_button = stripslashes(sanitize_text_field($_POST['gcc_button']));
				$gcc_fromemail = stripslashes(sanitize_text_field($_POST['gcc_fromemail']));
				$gcc_adminmail = stripslashes(sanitize_text_field($_POST['gcc_adminmail']));
				$gcc_adminmail_subject = stripslashes(wp_filter_post_kses($_POST['gcc_adminmail_subject']));
				$gcc_adminmail_content = stripslashes(wp_filter_post_kses($_POST['gcc_adminmail_content']));
				$gcc_usermail = stripslashes(wp_filter_post_kses($_POST['gcc_usermail']));
				$gcc_usermail_subject = stripslashes(wp_filter_post_kses($_POST['gcc_usermail_subject']));
				$gcc_usermail_content = stripslashes(wp_filter_post_kses($_POST['gcc_usermail_content']));
				$gcc_homeurl = stripslashes(sanitize_text_field($_POST['gcc_homeurl']));
				
				update_option('gcc_username', $gcc_username );
				update_option('gcc_password', $gcc_password );
				update_option('gcc_group', $gcc_group );
				update_option('gcc_title', $gcc_title );
				update_option('gcc_caption', $gcc_caption );
				update_option('gcc_adminemail', $gcc_adminemail );
				update_option('gcc_with_in_textbox', $gcc_with_in_textbox );
				update_option('gcc_fromemail', $gcc_fromemail );
				update_option('gcc_button', $gcc_button );
				update_option('gcc_adminmail', $gcc_adminmail );
				update_option('gcc_adminmail_subject', $gcc_adminmail_subject );
				update_option('gcc_adminmail_content', $gcc_adminmail_content );
				update_option('gcc_usermail', $gcc_usermail );
				update_option('gcc_usermail_subject', $gcc_usermail_subject );
				update_option('gcc_usermail_content', $gcc_usermail_content );
				update_option('gcc_homeurl', $gcc_homeurl );
				?>
				<div class="updated fade">
					<p><strong><?php _e('Details successfully updated.', 'constant-contact'); ?></strong></p>
				</div>
				<?php
			}
			
			?>
			<form name="gcc_form" method="post" action="">
					
				<h3><?php _e('Constant Contact Login', 'constant-contact'); ?></h3>
				
				<label for="tag-box"><?php _e('Constant contact username', 'constant-contact'); ?></label>
				<input name="gcc_username" type="text" value="<?php echo $gcc_username; ?>"  id="gcc_username" size="30" maxlength="100">
				<p><?php _e('Please enter your constant contact username', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Constant contact password', 'constant-contact'); ?></label>
				<input name="gcc_password" type="text" value="<?php echo $gcc_password; ?>"  id="gcc_password" size="30" maxlength="100">
				<p><?php _e('Please enter your constant contact password', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Constant contact group', 'constant-contact'); ?></label>
				<input name="gcc_group" type="text" value="<?php echo $gcc_group; ?>"  id="gcc_group" size="30" maxlength="100">
				<p><?php _e('Please enter your constant contact group', 'constant-contact'); ?></p>
						
				<h3><?php _e('Widget Setting', 'constant-contact'); ?></h3>
				
				<label for="tag-box"><?php _e('Widget title', 'constant-contact'); ?></label>
				<input name="gcc_title" type="text" value="<?php echo $gcc_title; ?>"  id="gcc_title" size="40" maxlength="100">
				<p><?php _e('Please enter your widget title', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Word within text box', 'constant-contact'); ?></label>
				<input name="gcc_with_in_textbox" type="text" value="<?php echo $gcc_with_in_textbox; ?>"  id="gcc_with_in_textbox" size="40" maxlength="100">
				<p><?php _e('Please enter text within text box', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Button caption', 'constant-contact'); ?></label>
				<input name="gcc_button" type="text" value="<?php echo $gcc_button; ?>"  id="gcc_button" size="40" maxlength="100">
				<p><?php _e('Please enter your button caption', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Short description', 'constant-contact'); ?></label>
				<input name="gcc_caption" type="text" value="<?php echo $gcc_caption; ?>"  id="gcc_caption" size="40" maxlength="500">
				<p><?php _e('Please enter your widget short description', 'constant-contact'); ?></p>
				
				<h3><?php _e('Email address Setting', 'constant-contact'); ?></h3>
						
				<label for="tag-box"><?php _e('From email address', 'constant-contact'); ?></label>
				<input name="gcc_fromemail" type="text" value="<?php echo $gcc_fromemail; ?>"  id="gcc_fromemail" size="40" maxlength="150">
				<p><?php _e('Please enter mail from email address', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Admin email address', 'constant-contact'); ?></label>
				<input name="gcc_adminemail" type="text" value="<?php echo $gcc_adminemail; ?>"  id="gcc_adminemail" size="40" maxlength="150">
				<p><?php _e('Please enter admin email address', 'constant-contact'); ?></p>
				
				
				<h3><?php _e('Admin email notification', 'constant-contact'); ?></h3>
				
				<label for="tag-box"><?php _e('Send mail to admin', 'constant-contact'); ?></label>
				<select name="gcc_adminmail" id="gcc_adminmail">
					<option value='YES' <?php if($gcc_usermail == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
					<option value='NO' <?php if($gcc_usermail == 'NO') { echo "selected='selected'" ; } ?>>No</option>
				</select>
				<p><?php _e('Select your option to receive admin mail', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Admin mail subject', 'constant-contact'); ?></label>
				<input name="gcc_adminmail_subject" type="text" value="<?php echo $gcc_adminmail_subject; ?>"  id="gcc_adminmail_subject" size="30" maxlength="100">
				<p><?php _e('Please enter admin mail subject', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Admin mail content', 'constant-contact'); ?></label>
				<textarea name="gcc_adminmail_content" rows="5" id="gcc_adminmail_content" style="width: 750px;"><?php echo $gcc_adminmail_content ?></textarea>
				<p><?php _e('Please enter admin mail content', 'constant-contact'); ?></p>
				
				<h3><?php _e('User email notification', 'constant-contact'); ?></h3>
				
				<label for="tag-box"><?php _e('Send mail to users', 'constant-contact'); ?></label>
				<select name="gcc_usermail" id="gcc_usermail">
					<option value='YES' <?php if($gcc_usermail == 'YES') { echo "selected='selected'" ; } ?>>Yes</option>
					<option value='NO' <?php if($gcc_usermail == 'NO') { echo "selected='selected'" ; } ?>>No</option>
				</select>
				<p><?php _e('Select your option to send user mail', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Users mail subject', 'constant-contact'); ?></label>
				<input name="gcc_usermail_subject" type="text" value="<?php echo $gcc_usermail_subject; ?>"  id="gcc_usermail_subject" size="30" maxlength="100">
				<p><?php _e('Please enter user mail subject', 'constant-contact'); ?></p>
				
				<label for="tag-box"><?php _e('Users mail content', 'constant-contact'); ?></label>
				<textarea name="gcc_usermail_content" rows="5" id="gcc_usermail_content" style="width: 750px;"><?php echo $gcc_usermail_content ?></textarea>
				<p><?php _e('Please enter users mail content', 'constant-contact'); ?></p>
				
				<h3><?php _e('Security Check (Spam Stopper)', 'constant-contact'); ?></h3>
				<label for="tag-width"><?php _e('Home URL', 'constant-contact'); ?></label>
				<input name="gcc_homeurl" type="text" value="<?php echo $gcc_homeurl; ?>"  id="gcc_homeurl" size="70" maxlength="500">
				<p><?php _e	('This home URL is for security check. We can submit the form only on this website. ', 'constant-contact'); ?></p>
		
				<p style="padding-top:8px;padding-bottom:8px;">
				<input id="gcc_submit" name="gcc_submit" lang="publish" class="button-primary" value="<?php _e('Update Setting', 'constant-contact'); ?>" type="Submit" />
				</p>
				 <?php wp_nonce_field('gcc_form_setting'); ?>
			</form>
		</div>
		<p class="description">
			<?php _e('Check official website for more information and live demo', 'constant-contact'); ?>
			<a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/constant-contact/"><?php _e('click here', 'constant-contact'); ?></a>
		</p>
	</div>
	<?php
}

function gcc_plugins_loaded()
{
	if(function_exists('wp_register_sidebar_widget')) 
	{
		wp_register_sidebar_widget( __('Constant contact form', 'constant-contact'), 
					__('Constant contact form', 'constant-contact'), 'gcc_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 
	{
		wp_register_widget_control( __('Constant contact form', 'constant-contact'), 
					array( __('Constant contact form', 'constant-contact'), 'widgets'), 'gcc_control');
	} 
}

function gcc_deactivate() 
{
	// No action required.
}

add_shortcode( 'constant-contact', 'gcc_constant_contact_form_shortcode' );

function gcc_constant_contact_form_shortcode( $atts ) 
{
	$ccf = "";
	//[constant-contact load="1"]
	if ( ! is_array( $atts ) )
	{
		return '';
	}
	$load = $atts['load'];
	
	$links = "'".plugins_url().'/constant-contact-form/class/'."'";
	//echo $links;
	$gcc_with_in_textbox = "'".get_option('gcc_with_in_textbox')."'";
	$gcc_button = get_option('gcc_button');
	$gcc_space = "''";
	$home_url = "'".home_url()."'";
	
	$ccf = $ccf . '<div>';
	$ccf = $ccf . '<div class="gcc_caption">';
	$ccf = $ccf . get_option('gcc_caption');
	$ccf = $ccf . '</div>';
	$ccf = $ccf . '<div class="gcc_msg">';
	$ccf = $ccf . '<span id="gcc_msg"></span>';
	$ccf = $ccf . '</div>';
	$ccf = $ccf . '<div class="gcc_textbox">';
	$ccf = $ccf . '<input class="gcc_textbox_class" name="gcc_txt_email" id="gcc_txt_email" ';
	$ccf = $ccf . 'onkeypress="if(event.keyCode==13) gcc_submit_form(this.parentNode, '.$home_url.')" ';
	$ccf = $ccf . 'onblur="if(this.value=='.$gcc_space.') this.value='.$gcc_with_in_textbox.';" ';
	$ccf = $ccf . 'onfocus="if(this.value=='.$gcc_with_in_textbox.') this.value='.$gcc_space.';" ';
	$ccf = $ccf . 'value='.$gcc_with_in_textbox.' maxlength="150" type="text">';
	$ccf = $ccf . '</div>';
	$ccf = $ccf . '<div class="gcc_button">';
	$ccf = $ccf . '<input class="gcc_textbox_button" type="button" name="gcc_txt_Button" onClick="return gcc_submit_form(this.parentNode, '.$home_url.')" id="gcc_txt_Button" value="'.$gcc_button.'">';
	$ccf = $ccf . '</div>';
	$ccf = $ccf . '</div>';
	return $ccf;
}

function gcc_add_to_menu() 
{
	add_options_page( __('Constant contact', 'constant-contact'), 
			__('Constant contact', 'constant-contact'), 'manage_options', 'constant-contact', 'gcc_admin_options' );
}

if (is_admin()) 
{
	add_action('admin_menu', 'gcc_add_to_menu');
}

function gcc_add_javascript_files() 
{
	if (!is_admin())
	{
		wp_enqueue_script( 'gcc_ajax', plugins_url().'/constant-contact/class/gcc_ajax.js');
		wp_enqueue_style( 'gcc_custom', plugins_url().'/constant-contact/class/gcc_custom.css','','','screen');
	}
}    

function gcc_textdomain() 
{
	load_plugin_textdomain( 'constant-contact', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


function gcc_plugin_query_vars($vars) 
{
	$vars[] = 'ccf';
	return $vars;
}

function gcc_plugin_parse_request($qstring)
{
	if (array_key_exists('ccf', $qstring->query_vars)) 
	{
		$page = $qstring->query_vars['ccf'];
		switch($page)
		{
			case 'constant-contact':
				$ToEmail = isset($_POST['gcc_email']) ? $_POST['gcc_email'] : '';
				if($ToEmail <> "")
				{
					if (!filter_var($ToEmail, FILTER_VALIDATE_EMAIL))
					{
						echo "invalid-email";
					}
					else
					{
						$homeurl = get_option('gcc_homeurl');
						if($homeurl == "")
						{
							$homeurl = home_url();
						}
						
						$samedomain = strpos($_SERVER['HTTP_REFERER'], $homeurl);
						if ( ($samedomain !== false) && ($samedomain < 5) ) 
						{
							$ConstantContact = new gConstantContact();
							$ConstantContact->setUsername(get_option('gcc_username')); 	/* set the constant contact username */
							$ConstantContact->setPassword(get_option('gcc_password')); 	/* set the constant contact password */
							$ConstantContact->setCategory(get_option('gcc_group')); 	/* set the constant contact interest category */
							if($ConstantContact->add($ToEmail))
							{
								$gcc_fromemail = get_option('gcc_fromemail');
								$gcc_adminmail = get_option('gcc_adminmail');
								$gcc_usermail = get_option('gcc_usermail');
	
								$headers = "MIME-Version: 1.0" . "\r\n";
								$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
								$headers .= "From: \"$gcc_fromemail\" <$gcc_fromemail>\n";
								
								if(trim($gcc_adminmail) == "YES")
								{
									$to_from = get_option('gcc_adminemail');
									$to_subject = get_option('gcc_adminmail_subject');
									$to_message = get_option('gcc_adminmail_content');
									$to_message = str_replace("\r\n", "<br />", $to_message);
									@wp_mail($to_from, $to_subject, $to_message, $headers);
								}
								
								if(trim($gcc_usermail) == "YES")
								{
									$to_from = $ToEmail;
									$to_subject = get_option('gcc_usermail_subject');
									$to_message = get_option('gcc_usermail_content');
									$to_message = str_replace("\r\n", "<br />", $to_message);
									@wp_mail($to_from, $to_subject, $to_message, $headers);
								}
								echo "mail-sent-successfully";
							}
							else
							{
								echo "username-password-error";
							}
						}
						else
						{
							echo "there-was-problem";
						}
					}
				}
				else
				{
					echo "empty-email";
				}
				die();
				break;
		}
	}
}

add_action('parse_request', 'gcc_plugin_parse_request');
add_filter('query_vars', 'gcc_plugin_query_vars');

add_action('plugins_loaded', 'gcc_textdomain');
add_action('init', 'gcc_add_javascript_files');
register_activation_hook(__FILE__, 'gcc_activation');
add_action("plugins_loaded", "gcc_plugins_loaded");
register_deactivation_hook( __FILE__, 'gcc_deactivate' );

class gConstantContact 
{
    var $add_subscriber_url = "http://ccprod.roving.com/roving/wdk/API_AddSiteVisitor.jsp";
    var $remove_subscriber_url = 'http://ccprod.roving.com/roving/wdk/API_UnsubscribeSiteVisitor.jsp';
    var $_username = '';
    var $_password = '';
    var $_category = '';
	
    function setUsername($username)
    {
        $this->username = $username;
    }
	
    function setPassword($password)
    {
        $this->password = $password;
    }
	
    function setCategory($category)
    {
        $this->category = $category;
    }
	
    function getUsername()
    {
        return urlencode($this->username);
    }
	
    function getPassword()
    {
        return urlencode($this->password);
    }
	
    function getCategory()
    {
        return urlencode($this->category);
    }
	
    function add($email, $extra_fields = array())
    {
        $email = urlencode(strip_tags($email));
        
        $data = 'loginName=' . $this->getUsername();
        $data .= '&loginPassword=' . $this->getPassword();
        $data .= '&ea=' . $email;
        $data .= '&ic=' . $this->getCategory();
		
		if(is_array($extra_fields)):
		    foreach($extra_fields as $k => $v):
                $data .= "&" . urlencode(strip_tags($k)) . "=" . urlencode(strip_tags($v));
		    endforeach;
        endif;
		
        return $this->_send($data, $this->add_subscriber_url);
    }
	
    function remove($email)
    {
        $email = urlencode(strip_tags($email));
        
        $data = 'loginName=' . $this->getUsername();
        $data .= '&loginPassword=' . $this->getPassword();
        $data .= '&ea=' . $email;
        
        return $this->_send($data, $this->remove_subscriber_url);
    }
	
    function _send($data, $url)
    {
        $handle = fopen("$url?$data", "rb");
        $contents = '';
		
        while (!feof($handle)) {
            $contents .= fread($handle, 192);
        }
		
        fclose($handle);
		
		if(trim($contents) == 0):
			return true;
		endif;
		
		return false;
    }
}
?>