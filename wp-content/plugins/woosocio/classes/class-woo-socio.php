<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
include_once( 'facebook.php' );
/**
 * WooSocio Base Class
 *
 * All functionality pertaining to core functionality of the WooSocio plugin.
 *
 * @package WordPress
 * @subpackage WooSocio
 * @author qsheeraz
 * @since 0.0.1
 *
 * TABLE OF CONTENTS
 *
 * public $version
 * private $file
 *
 * private $token
 * private $prefix
 *
 * private $plugin_url
 * private $assets_url
 * private $plugin_path
 *
 * public $facebook
 * private $fb_user_profile
 * private $app_id
 * private $secret
 *
 * - __construct()
 * - init()
 * - woosocio_meta_box()
 * - woosocio_ajax_action()
 * - woosocio_admin_init()
 * - socialize_post()
 * - woosocio_admin_menu()
 * - woosocio_admin_styles()
 * - socio_settings()
 * - products_list()
 * - check_connection()
 * - save_app_info()
 * - update_page_info()
 *
 * - load_localisation()
 * - activation()
 * - register_plugin_version()
 */

class Woo_Socio {
	public $version;
	private $file;

	private $token;
	private $prefix;

	private $plugin_url;
	private $assets_url;
	private $plugin_path;
	
	public $facebook;
	public $fb_user_profile = array();
	public $fb_user_pages = array();
	
	private $fb_app_id;
	private $fb_secret;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct ( $file ) {
		$this->version = '';
		$this->file = $file;
		$this->prefix = 'woo_socio_';
		$this->fb_app_id = get_option( 'fb_app_id');
		$this->fb_secret = get_option( 'fb_app_secret');

		/* Plugin URL/path settings. */
		$this->plugin_url = str_replace( '/classes', '', plugins_url( plugin_basename( dirname( __FILE__ ) ) ) );
		$this->plugin_path = str_replace( 'classes', '', plugin_dir_path( __FILE__ ));
		$this->assets_url = $this->plugin_url . '/assets';
		
		//if ( $this->fb_app_id != '' and $this->fb_secret != '' )
		$this->facebook = new Facebook(array('appId'  	  => $this->fb_app_id,
											 'secret' 	  => $this->fb_secret,
											 'status' 	  => true,
											 'cookie' 	  => true,
											 'xfbml' 	  => true,
											 'fileUpload' => true ));
		
	} // End __construct()

	/**
	 * init function.
	 *
	 * @access public
	 * @return void
	 */
	public function init () {
		add_action( 'init', array( $this, 'load_localisation' ) );

		add_action( 'admin_init', array( $this, 'woosocio_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'woosocio_admin_menu' ) );
		add_action( 'post_submitbox_misc_actions', array( $this, 'woosocio_meta_box' ) );
		//add_action( 'save_post', array( $this, 'clear_cache' ));
		add_action( 'save_post', array( $this, 'socialize_post' ));
		add_action( 'wp_ajax_my_action', array( $this, 'woosocio_ajax_action' ));
		add_action( 'wp_ajax_save_app_info', array( $this, 'save_app_info' ));
		add_action( 'wp_ajax_update_page_info', array( $this, 'update_page_info' ));
		add_action( 'wp_ajax_ws_delete_connection', array( $this, 'ws_delete_connection' ));
		add_action( 'woocommerce_single_product_summary', array( $this, 'show_sharing_buttons'), 50, 2  );
		add_filter( 'manage_edit-product_columns', array($this, 'woosocio_columns'), 998);
		//add_filter( 'manage_product_posts_columns' , array($this, 'woosocio_columns'),9990,1);
		add_action( 'manage_product_posts_custom_column', array($this, 'woosocio_custom_product_columns') );
		add_action( 'admin_footer', array($this, 'jquery_change_url') );
		add_action( 'restrict_manage_posts', array($this, 'add_list_woosocio') );
		//add_filter( 'manage_post_posts_columns' , array($this, 'woosocio_columns'),9990);
		add_action( 'widgets_init', array( $this, 'register_ws_widget' ) );
		

		// Run this on activation.
		register_activation_hook( $this->file, array( $this, 'activation' ) );
	} // End init()
	
	function pa($arr){

		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}


	/**
	 * register widget
	 *
	 * @return void
	 * @author 
	 **/
	function register_ws_widget() {
		register_widget( 'WS_Widget' );
	}

	/**
	 * woosocio_columns function.
	 *
	 * @access public
	 * @return columns
	 */
	function woosocio_columns($columns) {
		if ( isset( $_REQUEST['list'] ) && $_REQUEST['list'] == 'woosocio' ) {
		    $columns = array();
			$columns["cb"] = "<input type=\"checkbox\" />";
			$columns['thumb'] = '<span class="wc-image tips" data-tip="' . __( 'Image', 'woosocio' ) . '">' . __( 'Image', 'woosocio' ) . '</span>';
			$columns["name"] = __( 'Name', 'woosocio' );
			$columns["like_btn"] = __('Like/ Share Button?', 'woosocio');
			$columns["fb_post"] = __('Posted to Facebook?', 'woosocio');
			$columns["custom_msg"] = __('Custom Message', 'woosocio');

			return $columns;
		}
		else
			return $columns;
	}
		
	/**
	 * woosocio_custom_product_columns function.
	 *
	 * @access public
	 * @return void
	 */
	function woosocio_custom_product_columns( $column ) {
	global $post, $woocommerce, $the_product;

	if ( empty( $the_product ) || $the_product->id != $post->ID )
		$the_product = get_product( $post );

	switch ($column) {
		case "like_btn" :
			$woo_like_fb = metadata_exists('post', $post -> ID, '_woosocio_like_facebook') ? get_post_meta( $post -> ID, '_woosocio_like_facebook', true ) : 'No';
			echo $woo_like_fb == 'checked' ? '<img src="'.$this->assets_url.'/yes.png" alt="Yes" width="25">' : '<img src="'.$this->assets_url.'/no.png" alt="No" width="25">';
		break;
		case "fb_post" :
			$woo_post_fb = metadata_exists('post', $post -> ID, '_woosocio_facebook') ? get_post_meta( $post -> ID, '_woosocio_facebook', true ) : 'No';
			echo $woo_post_fb == 'checked' ? '<img src="'.$this->assets_url.'/yes.png" alt="Yes" width="25">' : '<img src="'.$this->assets_url.'/no.png" alt="No" width="25">';			
		break;
		case "custom_msg" :
			echo get_post_meta( $post -> ID, '_woosocio_msg', true );
		break;
	}
}

	/**
	 * show_sharing_buttons function.
	 *
	 * @access public
	 * @return void
	 */
	public function show_sharing_buttons() {
		$post_id = get_the_ID();
		$socio_link = get_permalink( $post_id );
		$fb_like = metadata_exists('post', $post_id, '_woosocio_like_facebook') ? get_post_meta( $post_id, '_woosocio_like_facebook', true ) : 'checked';
		if ($fb_like) {
			if($this->fb_app_id)
				$fb_appid_option = '&appId='.$this->fb_app_id;
		  ?>
		  <div class="fb-like" data-href="<?php echo $socio_link; ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
		  <div id="fb-root"></div>
		  <script><!--
		  (function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1<?php echo $fb_appid_option; ?>";
			fjs.parentNode.insertBefore(js, fjs);
		  }(document, 'script', 'facebook-jssdk'));//-->
          </script> 
		  <?php
		}
	}

	/**
	 * woosocio_meta_box function.
	 *
	 * @access public
	 * @return void
	 */
	public function woosocio_meta_box() {
		global $post;
		global $post_type;
		$post_id = get_the_ID();
		
		if ( $post_type == 'product' )
		{
			?>

		<div id="woosocio" class="misc-pub-section misc-pub-section-last">
			<?php
			$content = '';

			_e( 'WooSocio:', 'woosocio' );
			//metadata_exists('post', $post_id, '_woosocio_facebook');
			$like_chkbox_val = metadata_exists('post', $post_id, '_woosocio_like_facebook') ? get_post_meta( $post_id, '_woosocio_like_facebook', true ) : 'checked';
			$chkbox_val = metadata_exists('post', $post_id, '_woosocio_facebook') ? get_post_meta( $post_id, '_woosocio_facebook', true ) : 'checked';
			$saved_msg = ( get_post_meta( $post_id, '_woosocio_msg', true ) ? get_post_meta( $post_id, '_woosocio_msg', true ) : $post->title );
			if ( $this->check_connection() ): 
				echo '&nbsp;<img src="'.$this->assets_url.'/connected.gif" alt="Connected "> as: '."<b>".$this->fb_user_profile['name']."</b>";
				//echo "&nbsp;" . __( 'Connected as: '."<b>".$this->fb_user_profile['name']."</b>", 'woosocio' );
			else:
				$fb_saved_con = get_option( get_current_user_id().'_fb_page_id' );
				if ( !empty( $fb_saved_con ) ):
					$page_info = json_decode(file_get_contents("https://graph.facebook.com/".$fb_saved_con['id']."?fields=name&access_token=".$fb_saved_con['ac']));
					echo '&nbsp;<img src="'.$this->assets_url.'/connected.gif" alt="Connected "> as: '."<b>".$page_info->name."</b>";
				else:
					echo "&nbsp;<b>" . __( 'Not Connected', 'woosocio' )."</b>";
					?>&nbsp;<a href="<?php echo admin_url( 'options-general.php?page=woosocio' ); ?>" target="_blank"><?php _e( 'Connect', 'woosocio' ); ?></a>
				
			<?php endif; endif; ?>
			<div id="woosocio-form" style="display: none;">
            	<br />
                <input type="checkbox" name="like_facebook" id="like-facebook" <?php echo $like_chkbox_val; ?> />
                <label for="like-facebook"><b><?php _e( 'Show Like/Share buttons?', 'woosocio' ); ?></b></label><br />
                <input type="checkbox" name="chk_facebook" id="chk-facebook" <?php echo $chkbox_val; ?> />
                <label for="chk-facebook"><b><?php _e( 'Post to Facebook?', 'woosocio' ); ?></b></label><br />
				<label for="woosocio-custom-msg"><?php _e( 'Custom Message: (No html tags)', 'woosocio' ); ?></label>
				<textarea name="woosocio_custom_msg" id="woosocio-custom-msg"><?php echo $saved_msg; ?></textarea>
				<a href="#" id="woosocio-form-ok" class="button"><?php _e( 'Save', 'woosocio' ); ?></a>
				<a href="#" id="woosocio-form-hide"><?php _e( 'Cancel', 'woosocio' ); ?></a>
                <input type="hidden" name="postid" id="postid" value="<?php echo get_the_ID()?>" />
			</div>
             &nbsp; <a href="#" id="woosocio-form-edit"><?php _e( 'Edit', 'woosocio' ); ?></a>
		</div> 
        
		<script type="text/javascript"><!--
        jQuery(document).ready(function($){
                $("#woosocio-form").hide();
                
            $("#woosocio-form-edit").click(function(){
				$("#woosocio-form-edit").hide();
                $("#woosocio-form").show(1000);
            });
            
            $("#woosocio-form-hide").click(function(){
                $("#woosocio-form").hide(1000);
				$("#woosocio-form-edit").show();
            });
           
		    $("#woosocio-form-ok").click(function(){
				var custom_msg;
       			custom_msg = $("#woosocio-custom-msg").val();
				var data = {
					action: 'my_action',
					text1: custom_msg,
					postid: $("#postid").val(),
					chk_facebook: $("#chk-facebook").attr("checked"),
					like_facebook: $("#like-facebook").attr("checked")
				};
				$.post(ajaxurl, data, function(response) {
					console.log('Got this from the server: ' + response);
				});
                $("#woosocio-form").hide(1000);
				$("#woosocio-form-edit").show();
            });

        });
		//-->
        </script>
		<?php 
		}
	}

	/**
	 * woosocio_ajax_action function.
	 *
	 * @access public
	 * @return void
	 */	
	public function woosocio_ajax_action($post) {
		//global $post;
		//$post_id = get_the_ID();
		if ( ! update_post_meta ($_POST['postid'], '_woosocio_msg', 
								 $_POST['text1'] ) ) 
			   add_post_meta(    $_POST['postid'], '_woosocio_msg', 
			   				     $_POST['text1'], true );
		if ( ! update_post_meta ($_POST['postid'], '_woosocio_facebook', 
								 $_POST['chk_facebook'] ) ) 
			   add_post_meta(    $_POST['postid'], '_woosocio_facebook', 
			   				     $_POST['chk_facebook'], true );
	    if ( ! update_post_meta ($_POST['postid'], '_woosocio_like_facebook', 
								 $_POST['like_facebook'] ) ) 
			   add_post_meta(    $_POST['postid'], '_woosocio_like_facebook', 
			   				     $_POST['like_facebook'], true );

		//echo $_POST['text1'].$_POST['postid'];
		die(0);
		//die(); // this is required to return a proper result
	}
	
	/**
	 * woosocio_admin_init function.
	 *
	 * @access public
	 * @return void
	 */		
	public function woosocio_admin_init() {
       /* Register stylesheet. */
        wp_register_style( 'woosocioStylesheet', $this->assets_url.'/woosocio.css' );
		
		register_setting( 'woosocio_options', 'woosocio_settings' );
	
		add_settings_section(
			'woosocio_options_section', 
			__( 'WooSocio Options', 'woosocio' ), 
			array($this, 'woosocio_settings_section_callback'), 
			'woosocio_options'
		);
	
		add_settings_field( 
			'woosocio_checkbox_post_update', 
			__( 'Post to Facebook every time on product update?', 'woosocio' ), 
			array($this, 'woosocio_checkbox_post_update'), 
			'woosocio_options', 
			'woosocio_options_section' 
		);
	
		add_settings_field( 
			'woosocio_checkbox_notifications', 
			__( 'Get error notifications by email?', 'woosocio' ), 
			array($this, 'woosocio_checkbox_notifications'), 
			'woosocio_options', 
			'woosocio_options_section' 
		);

		add_settings_field( 
			'woosocio_option_posting_type', 
			__( 'Post product as ', 'woosocio' ), 
			array($this, 'woosocio_option_posting_type'), 
			'woosocio_options', 
			'woosocio_options_section' 
		);

		add_settings_field( 
			'woosocio_groups_txtarea', 
			__( 'Enter group IDs, separated by comma!', 'woosocio' ), 
			array($this, 'woosocio_groups_txtarea'), 
			'woosocio_options', 
			'woosocio_options_section' 
		);
    }

	/**
	 * woosocio_options function.
	 *
	 * @access public
	 * @return void
	 */		
	public function woosocio_options () {
		
	?>
	<form action='options.php' method='post'>
		
		<h2>woosocio</h2>
		
		<?php
		settings_fields( 'woosocio_options' );
		do_settings_sections( 'woosocio_options' );
		submit_button();
		?>
		
	</form>
	<?php

	}

	function woosocio_checkbox_post_update(  ) { 
		$options = get_option( 'woosocio_settings' );
		if ( !isset ( $options['woosocio_checkbox_post_update'] ) )
			$options['woosocio_checkbox_post_update'] = 0;
		?>
		<input type='checkbox' name='woosocio_settings[woosocio_checkbox_post_update]' <?php checked( $options['woosocio_checkbox_post_update'], 1 ); ?> value='1'>
		<?php
	
	}
	
	
	function woosocio_checkbox_notifications(  ) { 
		$options = get_option( 'woosocio_settings' );
		if ( !isset ( $options['woosocio_checkbox_notifications'] ) )
			$options['woosocio_checkbox_notifications'] = 0;
		?>
		<input type='checkbox' name='woosocio_settings[woosocio_checkbox_notifications]' <?php checked( $options['woosocio_checkbox_notifications'], 1 ); ?> value='1'>
		<?php
	
	}

	function woosocio_option_posting_type(  ) { 
		$options = get_option( 'woosocio_settings' );
		if ( !isset ( $options['woosocio_option_posting_type'] ) )
			$options['woosocio_option_posting_type'] = 'link';
		?>
		<input type="radio" name='woosocio_settings[woosocio_option_posting_type]' value='link' 
				<?php echo ($options['woosocio_option_posting_type'] == 'link') ? 'checked' : '' ?> > 
				<?php echo __( 'Link', 'woosocio' ) ?><br/>
		<input type="radio" name='woosocio_settings[woosocio_option_posting_type]' value='pic'
        		<?php echo ($options['woosocio_option_posting_type'] == 'pic') ? 'checked' : '' ?> > 
		        <?php echo __( 'Picture', 'woosocio' ) ?>
		<?php
	
	}

	function woosocio_groups_txtarea(  ) { 
		$options = get_option( 'woosocio_settings' );
		if ( !isset ( $options['woosocio_groups_txtarea'] ) )
			$options['woosocio_groups_txtarea'] = '';
		//echo "<span>";
		echo "<textarea rows='5' cols='52' placeholder='Enter group IDs here. Like 1111111111111111,2222222222222222' name='woosocio_settings[woosocio_groups_txtarea]'>";
		echo $options['woosocio_groups_txtarea'];
		echo "</textarea>";
		//echo "</span>";
		
		echo "<div class='woosocio-infobox'>";
		_e( 'This option provide you the ability to post on the groups you don\'t manage. ', 'woosocio' );
		_e( 'But you should be the member of the group to post! ', 'woosocio' );
		_e( 'Need to find group ID? ', 'woosocio' );
		echo "<a href='http://genialsouls.com/find-facebook-group-id/' target='_new' >".__('Click here!', 'woosocio')."</a>";
		echo "</div>";
	}

	function woosocio_settings_section_callback(  ) { 
	
		echo __( 'Settings', 'woosocio' );
	
	}

	/**
	 * socialize_post function.
	 *
	 * @access public
	 * @return void
	 */		
	public function socialize_post($post_id){

		if( get_post_type( $post_id ) == "product" and get_post_status($post_id) == "publish" ){
			
			$fb_post = metadata_exists('post', $post_id, '_woosocio_facebook') ? get_post_meta( $post_id, '_woosocio_facebook', true ) : 'checked';
			$fb_posted = metadata_exists('post', $post_id, '_woosocio_fb_posted') ? get_post_meta( $post_id, '_woosocio_fb_posted', true ) : '';
			$options = get_option( 'woosocio_settings' );
			$repost = !$fb_posted ? true : $options['woosocio_checkbox_post_update'];

			if ( $fb_post && $repost) {
		
				if ( $this->check_connection() )
					$fb_page_value = get_option( $this->fb_user_profile['id'].'_fb_page_id', array('id' => $this->fb_user_profile['id'],
																								   'ac' => $this->facebook->getAccessToken() ));
				else
					$fb_page_value = get_option( get_current_user_id().'_fb_page_id', array('id' => '',
																							'ac' => '' ));
				if ($fb_page_value['id'] != ''){
				$message = get_the_title($post_id);
				$message.= metadata_exists('post', $post_id, '_woosocio_msg') ? " - ".get_post_meta( $post_id, '_woosocio_msg', true ) : '';

				if ( !isset ( $options['woosocio_option_posting_type'] ) )
					$options['woosocio_option_posting_type'] = 'pic';
				
				if ( $options['woosocio_option_posting_type'] == 'link' ){

					$socio_link = get_permalink( $post_id );
					//$this -> facebook -> api('/','POST',array('id'=>$socio_link, 'scrape'=>'true'));
					$post_arr = array(  'access_token'  => $fb_page_value['ac'],
										'link' 			=> $socio_link,
	                                    'message'		=> html_entity_decode($message, ENT_COMPAT, "UTF-8"),
									 );
					$node = '/feed';
					wp_remote_post("https://graph.facebook.com?id=".get_permalink($post_id)."&scrape=true");
		
				} else {
		
					$_pf = new WC_Product_Factory();  
					$_product = $_pf->get_product($post_id);

					$post_desc = strip_tags( get_post_field( 'post_content', $post_id ) );
					$curr_symb = get_woocommerce_currency_symbol();
					$message.= "\n" . __( 'Price: ', 'woosocio') 
							. html_entity_decode($curr_symb, ENT_COMPAT, "UTF-8") 
							. $_product->get_price() . "\n" 
							. $post_desc . "\n" . __( 'Link: ', 'woosocio') 
							. get_permalink( $post_id );

					$post_arr = array(	'access_token'  => $fb_page_value['ac'],
			  							'message'		=> html_entity_decode($message, ENT_COMPAT, "UTF-8"),
										'url'			=> wp_get_attachment_url(get_post_thumbnail_id( $post_id ) ),
		   							 );
					$node = '/photos';
				}

				try {

					$ret_obj = $this -> facebook -> api('/'.$fb_page_value['id'].$node, 'POST', $post_arr);
					
					if ( $node == '/feed' ){
						$this -> facebook -> api('/','POST',array('id'=>$socio_link, 'scrape'=>'true'));
						wp_remote_post("https://graph.facebook.com?id=".get_permalink($post_id)."&scrape=true");
					}

					if ($ret_obj) {
						if ( ! update_post_meta ($post_id, '_woosocio_fb_posted', 'checked' ) ) 
							   add_post_meta(    $post_id, '_woosocio_fb_posted', 'checked', true );
					}

					if ( ! update_post_meta ($post_id, '_woosocio_facebook', 'checked' ) ) 
				   		   add_post_meta(    $post_id, '_woosocio_facebook', 'checked', true );
	      		} 
				catch(FacebookApiException $e) {
					if ( $options['woosocio_checkbox_notifications'] ){
						$admin_email = get_option( 'admin_email' );
						if ( empty( $admin_email ) ) {
							$current_user = wp_get_current_user();
							$admin_email = $current_user->user_email;
						}
						
						$msg = __('Dear user,', 'woosocio') . "\r\n";
						$msg.= __('Your product ID ', 'woosocio') . $socio_post->ID . __(' not posted on Facebook due to following reason.', 'woosocio') . "\r\n";
						$msg.= $e->getMessage();
						
						wp_mail($admin_email, __('WooSocio - Notification', 'woosocio'), $msg, $this->woosocio_headers());
					}
					return false;
					//console.log($e->getType());
	      		}}
	      	}
		}
	}

	/**
	 * clear cache function.
	 *
	 * @access public
	 * @return void
	 */		
	function clear_cache( $postid ){
		if(get_post_type( $postid ) == "product" and get_post_status($postid) == "publish"){
			wp_remote_post("https://graph.facebook.com?id=".get_permalink($postid)."&scrape=true");
		}
	}

	/**
	 * woosocio_admin_menu function.
	 *
	 * @access public
	 * @return void
	 */		
	public function woosocio_admin_menu () {
		add_menu_page( 'WooSocio', 'WooSocio', 'manage_woocommerce', 'woosocio', '', $this->assets_url.'/menu_icon_wc.png', 51 );
		$page_logins   = add_submenu_page( 'woosocio', 'WooSocio Logins', 'WooSocio Logins', 'manage_woocommerce', 'woosocio', array( $this, 'socio_settings' ) );
		$page_products = add_submenu_page( 'woosocio', 'WooSocio Products', 'WooSocio Products', 'manage_woocommerce', 'products_list', array( $this, 'products_list' ) );
		$page_options  = add_submenu_page( 'woosocio', 'WooSocio Options', 'WooSocio Options', 'manage_woocommerce', 'woosocio_options', array( $this, 'woosocio_options' ) );
		/*$page = add_options_page( 'Socio Logins', 'WooSocio Options', 'manage_options', 'woosocio', array( $this, 'socio_settings' ) );*/
		add_action( 'admin_print_styles-' . $page_logins, array( $this, 'woosocio_admin_styles' ) );
		add_action( 'admin_print_styles-' . $page_products, array( $this, 'woosocio_admin_styles' ) );
		add_action( 'admin_print_styles-' . $page_options, array( $this, 'woosocio_admin_styles' ) );
	}

	/**
	 * woosocio_admin_styles function.
	 *
	 * @access public
	 * @return void
	 */			
	public function woosocio_admin_styles() {
       /*
        * It will be called only on plugin admin page, enqueue stylesheet here
        */
       wp_enqueue_style( 'woosocioStylesheet' );
   }

	/**
	 * add list function.
	 *
	 * @access public
	 */	
	function add_list_woosocio(){
		if ( isset($_REQUEST['list']) && $_REQUEST['list'] == 'woosocio') 
		{
			echo '<input type="hidden" name="list" value="woosocio">';
		}
	}

	/**
	 * change url function.
	 *
	 * @access public
	 * @return columns
	 */
	function jquery_change_url(){
		if ( isset($_REQUEST['list']) && $_REQUEST['list'] == 'woosocio'){
			?>
			<script type="text/javascript"><!--
			jQuery(function(){
				jQuery(".all a").attr('href', function() {
					return this.href + '&list=woosocio';
				});
				
				jQuery(".publish a").attr('href', function() {
					return this.href + '&list=woosocio';
				});
				
				jQuery(".trash a").attr('href', function() {
					return this.href + '&list=woosocio';
				});
			});
			//-->
			</script>
			<?php
		}
	}

	/**
	 * socio_settings function.
	 *
	 * @access public
	 * @return void
	 */		
	public function socio_settings () {
		
		$filepath = $this->plugin_path.'woosocio.logins.php';
		if (file_exists($filepath))
			include_once($filepath);
		else
			die('Could not load file '.$filepath);
	}

	/**
	 * products_list function.
	 *
	 * @access public
	 * @return void
	 */		
	public function products_list () {
		
		?>
		<script type="text/javascript"><!--
			url = '<?php echo add_query_arg( array('post_type' => 'product',
											   	   'list'	   => 'woosocio'), admin_url('edit.php')) ?>';
			window.location.replace(url);//-->
		</script>
        <?php
	}


	/**
	 * creating email headers.
	 *
	 * @access public
	 */
	public function woosocio_headers(){
		$admin_email = get_option( 'admin_email' );
		if ( empty( $admin_email ) ) {
			$admin_email = 'support@' . $_SERVER['SERVER_NAME'];
		}

		$from_name = get_option( 'blogname' );

		$header = "From: \"{$from_name}\" <{$admin_email}>\n";
		$header.= "MIME-Version: 1.0\r\n"; 
		$header.= "Content-Type: text/plain; charset=\"" . get_option( 'blog_charset' ) . "\"\n";
		$header.= "X-Priority: 1\r\n"; 

		return $header;
	}

	/**
	 * check connection function.
	 *
	 * @access public
	 */
	public function check_connection() {

 		if ( $this->fb_app_id != '' && $this->fb_secret != '' ) {
	 		try {
		  	  $fb = $this->ws_get_inst();
			  if ( isset( $_SESSION['facebook_access_token'] ) ) {
			  	$user_profile = $fb->get('/me', $_SESSION['facebook_access_token'] );
			    $this->fb_user_profile = $user_profile->getDecodedBody();
              }
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  return false;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  return false;
			}
		 	return $this->fb_user_profile;
		}
		else
			return false;
	}

	/**
	 * get new facebook instance
	 *
	 * @access public
	 */
	function ws_get_inst(){

		$fb_appid = $this->fb_app_id != '' ? $this->fb_app_id : '111';
		$fbsecret = $this->fb_secret != '' ? $this->fb_secret : 'abc';

		try {
			$fb = new Facebook\Facebook([
			'app_id' => $fb_appid,
	  		'app_secret' => $fbsecret,
	  		'default_graph_version' => 'v2.5',
			]);
			return $fb;
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		  return false;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		  return false;
		}
	}

	/**
	 * save facebook app id and secret function.
	 *
	 * @access public
	 */
	public function save_app_info() {
		update_option( 'fb_app_id', $_POST['fb_app_id'] );
		update_option( 'fb_app_secret', $_POST['fb_app_secret'] );
 	}

	/**
	 * update facebook page id function.
	 *
	 * @access public
	 */
	public function update_page_info() {
		$this->check_connection();
		$fb_user_sign = $this->fb_user_profile['id'].'_fb_page_id';
		$wp_user_sign = get_current_user_id().'_fb_page_id';
		//update_option( $fb_user_sign, array($_POST['fb_type'] => $_POST['fb_page_id']) );
		update_option( $fb_user_sign, array('id'		=> $_POST['fb_page_id'],
											'type'		=> $_POST['fb_type'],
											'ac'		=> $_POST['fb_page_ac']) );
		if(update_option( $wp_user_sign, array('id'		=> $_POST['fb_page_id'],
											   'type'	=> $_POST['fb_type'],
											   'ac'		=> $_POST['fb_page_ac']) ))
			_e( 'Page Info Updated!', 'woosocio');
		else
			_e( 'Unable to update page info! Please try again.', 'woosocio');
		die(0);
		//update_option( 'fb_app_secret', $_POST['fb_app_secret'] );
 	}

	/**
	 * delete saved connection
	 *
	 * @access public
	 */
	public function ws_delete_connection() {
		
		$user_sign = get_current_user_id().'_fb_page_id';
		if( delete_option( $user_sign ) )
			_e( 'Deleted', 'woosocio');
		else
			_e( 'Error deleting connection! Please try later!', 'woosocio');

		die(0);
 	}

	/**
	 * load_localisation function.
	 *
	 * @access public
	 * @return void
	 */
	public function load_localisation () {
		$lang_dir = trailingslashit( str_replace( 'classes', 'lang', plugin_basename( dirname(__FILE__) ) ) );
		load_plugin_textdomain( 'woosocio', false, $lang_dir );
	} // End load_localisation()

	/**
	 * activation function.
	 *
	 * @access public
	 * @return void
	 */
	public function activation () {
		$this->register_plugin_version();
	} // End activation()

	/**
	 * register_plugin_version function.
	 *
	 * @access public
	 * @return void
	 */
	public function register_plugin_version () {
		if ( $this->version != '' ) {
			update_option( 'woosocio' . '-version', $this->version );
		}
	} // End register_plugin_version()
} // End Class
?>