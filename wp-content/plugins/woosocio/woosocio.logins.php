<?php
global $woosocio, $is_IE;
if(isset($_GET['action']) && $_GET['action'] === 'logout'){
    $woosocio -> facebook -> destroySession();
    $_SESSION['facebook_access_token']='';
}

$facebook = $woosocio->ws_get_inst();
try {
  $helper = $facebook->getRedirectLoginHelper();
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  return;//exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  return;//exit;
}
if (isset($accessToken)) {
  $_SESSION['facebook_access_token'] = (string) $accessToken;
}

$fb_user = $woosocio -> facebook -> getUser();

if (isset($_SESSION['facebook_access_token']) && $_SESSION['facebook_access_token'] != '') {
	$next_url = array( 'next' => admin_url().'admin.php?page=woosocio&logout=yes&action=logout' );
  	$logoutUrl = admin_url().'admin.php?page=woosocio&logout=yes&action=logout';
	$user_profile = $facebook->get('/me', $_SESSION['facebook_access_token'] );
	$user_profile = $user_profile->getDecodedBody();
	$fb_user = $user_profile['id'];
	$user_pages = $facebook->get('/me/accounts', $_SESSION['facebook_access_token'] );
	$user_pages = $user_pages->getDecodedBody();
	$user_groups = $facebook->get('/me/groups', $_SESSION['facebook_access_token'] );
	$user_groups = $user_groups->getDecodedBody();
} else {
  	$statusUrl = $woosocio->facebook->getLoginStatusUrl();
  	$helper = $facebook->getRedirectLoginHelper();
	$permissions = ['manage_pages', 'publish_actions', 'publish_pages', 'user_managed_groups', 'user_photos']; // optional
  	$loginUrl = $helper->getLoginUrl( admin_url().'admin.php?page=woosocio', $permissions);
}

?>
<!doctype html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <title><?php _e( 'WooSocio Options', 'woosocio' ) ?></title>
</head>
<body>
<div class="woosocio_wrap">
  <h1><?php _e( 'WooSocio Logins', 'woosocio' ) ?></h1>
  <p>
  <?php esc_html_e( 'Connect your site to social networking sites and automatically share new products with your friends.', 'woosocio' ) ?>
  </p>
  <p style="font-size:12px">
  <?php esc_html_e( "You can use like/share buttons without connecting or App ID", 'woosocio' ) ?>
  </p>
  <?php 
	if ($is_IE){
	  echo "<p style='font-size:18px; color:#F00;'>" . __( 'Important Notice:', 'woosocio') . "</p>";
	  echo "<p style='font-size:16px; color:#F00;'>" . 
	  		__( 'You are using Internet Explorer. This plugin may not work properly with IE. Please use any other browser.', 'woosocio') . "</p>";
	  echo "<p style='font-size:16px; color:#F00;'>" . __( 'Recommended: Google Chrome.', 'woosocio') . "</p>";
	}
  ?>
  <div id="woosocio-services-block">
	<img src="<?php echo $woosocio->assets_url.'/facebook-logo.png' ?>" alt="Facebook Logo">
	<div class="woosocio-service-entry" >
		<div id="facebook" class="woosocio-service-left">
			<a href="https://www.facebook.com" id="service-link-facebook" target="_top">Facebook</a><br>
		</div>
		<div class="woosocio-service-right">
			<?php if($fb_user!==0):?>
            <?php _e( 'Connected as:', 'woosocio') ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a class="woosocio-profile-link" href="https://www.facebook.com" target="_top">
			<img src="http://graph.facebook.com/<?php echo $user_profile['id'] ?>/picture" alt="No Image">
			<?php echo $user_profile['name'] ?></a><br>
            <a id="pub-disconnect-button1" class="woosocio-add-connection button" href="<?php echo $logoutUrl; ?>" target="_top"><?php _e('Disconnect', 'woosocio')?></a><br>
            <?php else: ?>
            <!--Not Connected...&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
            <a id="facebook" class="woosocio-add-connection button" href="<?php echo esc_url( $loginUrl ); ?>" target="_top"><?php _e('Connect', 'woosocio')?></a>
            <img id="working" src="<?php echo $woosocio->assets_url.'/spinner.gif' ?>" alt="Wait..." height="22" width="22" style="display: none;"><br>
            <?php endif; ?>

            <?php 
			if (get_option( 'fb_app_id' ) && get_option( 'fb_app_secret' )): 
			    echo '<a id="app-details" href="javascript:">' . __('Show App Details', 'woosocio') . '</a>';
				echo '<div id="app-info" style="display: none;">';
			else:            
            	echo '<div id="app-info">';
			endif;
			?>
            <table class="form-table">
            <tr valign="top">
	  			<th scope="row"><label><?php _e('Your App ID:', 'woosocio') ?></label></th>
	  			<td>
	  				<input type="text" name="app_id" id="fb-app-id" placeholder="<?php _e('App ID', 'woosocio') ?>" value="<?php echo get_option( 'fb_app_id' ); ?>"><br>
                    <p style="font-size:10px"><?php _e("Don't have an app? You can get from ", 'woosocio') ?>
                    <a href="https://developers.facebook.com/apps" target="_new" style="font-size:10px">developers.facebook.com/apps</a>
                    <!--<p><a href="https://www.youtube.com/watch?v=hfFkOZ9USeA"><?php //_e("Video: How to create Facebook app for WooSocio", 'woosocio') ?></a>-->
	  			</td>
	  		</tr>
            <tr valign="top">
	  			<th scope="row"><label><?php _e('Your App Secret:', 'woosocio') ?></label></th>
	  			<td>
	  				<input type="text" name="app_secret" id="fb-app-secret" placeholder="<?php _e('App Secret', 'woosocio') ?>" value="<?php echo get_option( 'fb_app_secret' ); ?>"><br>
                    <p style="font-size:11px"><?php _e('Need more help? ', 'woosocio') ?>
                    <a href="https://developers.facebook.com/docs/opengraph/getting-started/#create-app" target="_new" style="font-size:11px"><?php _e('Click here', 'woosocio') ?></a>
	  			</td>
	  		</tr>
            <tr valign="top">
     	  		<th scope="row"></th>
	  			<td>
                	<a id="btn-save" class="button-primary button" href="javascript:"><?php _e('Save', 'woosocio') ?></a>
	  			</td>
	  		</tr>
            </table>
			<iframe 
            	src="https://www.youtube.com/embed/tfM5RvrIBrg" 
                width="560" 
            	height="315" 
                frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen>
            </iframe> 
			<p>
            	<a href="https://www.youtube.com/watch?v=tfM5RvrIBrg" target="_new"><?php _e('How to create Facebook App v2.8 for WooSocio', 'woosocio') ?></a>
                <?php _e('from', 'woosocio') ?> <a href="http://genialsouls.com/" target="_new">GenialSouls</a>
                <?php _e('on', 'woosocio') ?> <a href="https://www.youtube.com/channel/UC1z3dGUdG5JJEIsEpaDnG5w" target="_new">YouTube</a>.
            </p>            
            
            </div>
		</div>
	
		<?php
        if($fb_user!==0){
			$me_ac = $_SESSION['facebook_access_token'];
			$user_sign = $user_profile['id'].'_fb_page_id';
			//echo get_option( $user_sign);
			//$fb_page_value = get_option( $user_sign, array('id' => $user_profile['id']) );
			$fb_page_value = get_option( $user_sign, array('id' => '') );
			//$this->pa($user_groups);
            echo "<h4>" . __( 'Post to:', 'woosocio' ) . "</h4>";
			echo "<h3>" . __( 'Pages:', 'woosocio' ) . "</h3>";
        	?>  
        	<label for="<?php echo $user_profile['id'] ?>">
            <img src="http://graph.facebook.com/<?php echo $user_profile['id'] ?>/picture" alt="No Image"></label>
            <input type="radio" name="pages" id="<?php echo $user_profile['id'] ?>" value="<?php echo $user_profile['id'] ?>" <?php echo ($fb_page_value['id'] == $user_profile['id'])?'checked':''?>>
			<label for="<?php echo $user_profile['id'] ?>"><?php _e('Personal Page (Wall)', 'woosocio') ?></label> <br>
            <input type="hidden" id="<?php echo 'fb_type'.$user_profile['id'] ?>" value="me">
            <input type="hidden" id="<?php echo 'fb_ac_'.$user_profile['id'] ?>" value="<?php echo $me_ac ?>">

        	<?php
	        $page_names = $user_pages['data'];
	        foreach($page_names as $key => $page)
	        {
				$page_ac = $page['access_token'];
	        ?>
	        	<label for="<?php echo $page['id'] ?>">
	            <img src="http://graph.facebook.com/<?php echo $page['id'] ?>/picture" alt="No Image"></label>
	            <input type="radio" name="pages" id="<?php echo $page['id'] ?>" value="<?php echo $page['id'] ?>" <?php echo ($fb_page_value['id'] == $page['id']) ? 'checked':''?>>
				<label for="<?php echo $page['id'] ?>"><?php echo $page['name'] ?></label><br>
	            <input type="hidden" id="<?php echo 'fb_type'.$page['id'] ?>" value="page">
	            <input type="hidden" id="<?php echo 'fb_ac_'.$page['id'] ?>" value="<?php echo $page_ac ?>">
	        <?php
	        }	//$woosocio->pa($user_profile);		 
			echo "<h3>" . __( 'Groups:', 'woosocio' ) . "</h3>";
	        $group_names = $user_groups['data'];
	        foreach($group_names as $key => $group)
	        {
	        	$me_ac = $_SESSION['facebook_access_token'];
			?>
	        	<label for="<?php echo $group['id'] ?>">
	            <img src="http://graph.facebook.com/<?php echo $group['id'] ?>/picture" alt="No Image"></label>
	            <input type="radio" name="pages" id="<?php echo $group['id'] ?>" value="<?php echo $group['id'] ?>" <?php echo ($fb_page_value['id'] == $group['id']) ? 'checked':''?>>
				<label for="<?php echo $group['id'] ?>"><?php echo $group['name'] ?></label><br>
	            <input type="hidden" id="<?php echo 'fb_type'.$group['id'] ?>" value="group">
	            <input type="hidden" id="<?php echo 'fb_ac_'.$group['id'] ?>" value="<?php echo $me_ac ?>">
	        <?php
	        }
			$other_groups = get_option( 'woosocio_settings' );
			if ( isset ( $other_groups['woosocio_groups_txtarea'] ) && $other_groups['woosocio_groups_txtarea'] != '' ){
				$arr_other_groups = explode( ',', $other_groups['woosocio_groups_txtarea'] );
	    	    foreach($arr_other_groups as $group)
		        {
					$group_info = $woosocio->facebook->api('/'.$group);
					$me_ac = $_SESSION['facebook_access_token'];
				?>
	            	<label for="<?php echo $group ?>">
					<img src="http://graph.facebook.com/<?php echo $group ?>/picture" alt="No Image"></label>
		            <input type="radio" name="pages" id="<?php echo $group ?>" value="<?php echo $group ?>" <?php echo ($fb_page_value['id'] == $group) ? 'checked':''?>>
					<label for="<?php echo $group ?>"><?php echo $group_info['name'] ?></label><br>
	    	        <input type="hidden" id="<?php echo 'fb_type'.$group ?>" value="group">
	    	        <input type="hidden" id="<?php echo 'fb_ac_'.$group ?>" value="<?php echo $me_ac ?>">

				<?php

				}

			}		
		}//$woosocio->pa($user_profile);	
		?>
        <img id="working-page" src="<?php echo $woosocio->assets_url.'/spinner.gif' ?>" alt="Wait..." height="15" width="15" style="display: none;"><br>
	</div>        
    
    
    <?php
	$fb_saved_con = get_option( get_current_user_id().'_fb_page_id' );
	if ($fb_user == 0 && $fb_saved_con){

		echo '<div class="woosocio-service-entry" style="font-size:18px;">';
			_e( 'Connected as: ', 'woosocio'); echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			
			?><img src="http://graph.facebook.com/<?php echo $fb_saved_con['id'] ?>/picture" alt="No Image"></label><?php
			$page_info = json_decode(file_get_contents("https://graph.facebook.com/".$fb_saved_con['id']."?fields=name&access_token=".$fb_saved_con['ac']));
			echo '&nbsp;&nbsp;<img src="'.$woosocio->assets_url.'/connected.gif" alt="Connected ">&nbsp;&nbsp;';
			echo $page_info->name;
			echo '&nbsp;&nbsp;<a id="ws_delete_connection" href="javascript:;"><img src="'.$woosocio->assets_url.'/no.png" alt="Delete" height="20" title="'.__( 'Delete connection!', 'woosocio').'"></a>';
			
		//$woosocio->pa($fb_saved_con);
		echo '</div>';
		
	}
	if ($fb_user!== 0){
		echo '<div class="woosocio-service-entry" style="font-size:18px;">';
		/*
			Check permissions
		*/
		$arr_permissions = $facebook->get('/me/permissions', $_SESSION['facebook_access_token'] );
		$arr_permissions = $arr_permissions->getDecodedBody();

		//$this->pa($arr_permissions['data']);
		echo "<h4>" . __( 'App Permissions:', 'woosocio' ) . "</h4>";
		echo '<table>';
		
		foreach ( $arr_permissions['data'] as $permission ) {
			echo '<tr>';
			echo '<td>' . $permission['permission'] . '</td>';
			echo '<td>' . $permission['status']     . '</td>';
			echo '</tr>';
		}
		echo '</table>';
    	echo '</div>';
	}
	?>

    <div class="woosocio-service-entry" style="font-size:18px; color:#03C">
        <div class="woosocio-service-left">
            <a href="https://wordpress.org/plugins/wootweet/" target="_top">
            <img src="<?php echo $woosocio->assets_url.'/wootweet_icon.jpg' ?>" alt="WooTweet">
            </a>
        </div>
        <div class="woosocio-service-right">
            <div align="left">
            <?php
                echo '<a href="https://wordpress.org/plugins/wootweet/" target="_top">'.__('* WooTweet Free *', 'woosocio').'</a>';
                echo "</br></br>";
                _e('* Post product to Twitter', 'woosocio'); echo "</br>";
                _e('* Post products multiple times (on every update)', 'woosocio'); echo "</br>";
                _e('* And many more to come...', 'woosocio'); echo "</br>";
            ?>
            </div>
        </div>
    </div>
    <div class="woosocio-service-entry" style="font-size:18px; color:#03D">
        <div class="woosocio-service-left">
            <a href="http://genialsouls.com/product/woosocio-pro/" target="_top">
            <img src="<?php echo $woosocio->assets_url.'/woosocio_icon.jpg' ?>" alt="WooSocio Pro" height="128">
            </a>
        </div>
        <div class="woosocio-service-right">
            <div align="left">
            <?php
				echo '<a href="http://genialsouls.com/product/woosocio-pro/" target="_top">'.__('* WooSocio Pro version *', 'woosocio').'</a></br>';
				_e('* product gallery images as Facebook gallery', 'woosocio'); echo "</br>";
				_e('* post to multiple pages and/or groups at once', 'woosocio'); echo "</br>";
				_e('* Optional time delay between posting', 'woosocio'); echo "</br>";
				_e('* Bulk posts to pages, groups', 'woosocio'); echo "</br>";
				_e('* Multi user ready', 'woosocio'); echo "</br>";
				_e('* Bulk like/share button on/off option', 'woosocio'); echo "</br>";
				_e('* And many more...', 'woosocio'); echo "</br>";
            ?>
            </div>
        </div>
    </div>
    <div class="woosocio-service-entry" style="font-size:18px; color:#03D">
        <div class="woosocio-service-left">
            <a href="http://genialsouls.com/file-manager/" target="_top">
            <img src="<?php echo $woosocio->assets_url.'/filemanager_icon.png' ?>" alt="File Manager Pro">
            </a>
        </div>
        <div class="woosocio-service-right">
            <div align="left">
            <?php
				echo '<a href="http://genialsouls.com/file-manager/" target="_top">'.__('* File Manager *', 'woosocio').'</a></br>';
				_e('* BuddyPress Group File Share.', 'woosocio'); echo "</br>";
				_e('* Create Download Area.', 'woosocio'); echo "</br>";
				_e('* Group file sharing.', 'woosocio'); echo "</br>";
				_e('* Seven types of input fields.', 'woosocio'); echo "</br>";
				_e('* FTP files upload for Users by Admin ( v 9.3+ )', 'woosocio'); echo "</br>";
				_e('* Front end File Searching and Pagination.', 'woosocio'); echo "</br>";
				_e('* And many more...', 'woosocio'); echo "</br>";
            ?>
            </div>
        </div>
    </div>
  </div>
    <!-- Right Area Widgets -->  
    <?php 
		include_once 'right_area.php';
	 ?>
    <!-- Right Area Widgets -->  
</div>
  </body>
</html>
<script type="text/javascript">
jQuery(document).ready(function($){
		//$("#app-info").hide();
		
	$("#btn-save").click(function(){
		$("#working").show();
		
		var data = {
			action: 'save_app_info',
			fb_app_id: $("#fb-app-id").val(),
			fb_app_secret: $("#fb-app-secret").val()
		};
		
		$.post(ajaxurl, data, function(response) {
			console.log('Got this from the server: ' + response);
		location.reload();
		});	
		
		$("#app-info").hide(2000);
	});

	$("input:radio[name=pages]").click(function() {
		$("#working-page").show();

		var data = {
			action: 'update_page_info',
			fb_page_id: $(this).val(),
			fb_page_ac: $("#fb_ac_"+$(this).val()).val(),
			fb_type: $("#fb_type"+$(this).val()).val()
		};

		$.post(ajaxurl, data, function(response) {
			console.log('Got this from the server: ' + response);
			$("#working-page").hide();
			alert(response);
		});
	});
	
	$("#app-details").click(function(){
		$("#app-info").toggle(1000);
	});

	$("#ws_delete_connection").click(function(){

		var data = {
			action: 'ws_delete_connection',
		};

		$.post(ajaxurl, data, function(response) {
			console.log('Got this from the server: ' + response);
			if (response=='Deleted') {
				location.reload();
			} else {
				alert(response);
			};
		});		
	});

});
</script>