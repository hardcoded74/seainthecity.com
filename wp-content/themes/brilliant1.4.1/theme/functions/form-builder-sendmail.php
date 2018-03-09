<?php
/**
 * @package WordPress
 * @subpackage Brilliant
 * @since Brilliant 1.0
 * 
 * Form Builder Send Mail
 * Created by CMSMasters
 * 
 */


require('../../../../../wp-load.php');

global $wpdb, $shortname;


if (isset($_REQUEST['formname']) && isset($_REQUEST['contactemail'])) {
    $formname = $_REQUEST['formname'];
    $mailString = base64_decode($_REQUEST['contactemail']);
	
    $mail = explode('|', $mailString);
    
    if ($wpdb->get_var("SELECT id FROM " . $wpdb->prefix . $shortname . "_forms WHERE type = 'form' AND slug = '" . $formname . "'") != '') {
        $results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . $shortname . "_forms WHERE parent_slug='" . $formname . "' ORDER BY number ASC");
		
        $headers = "MIME-Version: 1.0\r\n Content-type: text/plain; charset=utf-8\r\n";
        
        foreach ($results as $form_result) {
            if ($form_result->type == 'form') {
                $subjects = unserialize($form_result->description);
                $msg = unserialize($form_result->value);
				
                $subject = $subjects[0];
            }
        }
        
        foreach ($results as $result) {
            if ($result->type != 'form') {
                $field_label = $result->label;
                $field_name = $result->slug;
                
                if (isset($_REQUEST[$field_name])) {
                    $subject = str_replace('[%' . $field_label . '%]', $_REQUEST[$field_name], $subject);
                    $msg = str_replace('[%' . $field_label . '%]', $_REQUEST[$field_name], $msg);
                }
            }
        }
        
        foreach ($results as $result) {
            if ($result->type == 'email') {
                $headers_from = "From: " . $_REQUEST[$result->slug] . " <" . $_REQUEST[$result->slug] . ">\r\nReply-To: " . $_REQUEST[$result->slug] . " <" . $_REQUEST[$result->slug] . ">\r\n";
            }
        }
        
        if ($headers_from == '') {
            $headers_from = "From: Example <email@example.com>\r\nReply-To: Emample <email@example.com>\r\n";
        }
        
        $headers .= $headers_from . 'X-Mailer: PHP/' . phpversion();
		
        if ($mail[0] == $formname && $mail[2] == $formname) {
            $mailTo = explode(',', $mail[1]);
			
			$count = false;
			$out = '';
			$number = 0;
            
            foreach ($mailTo as $mailAddress) {
                wp_mail(trim($mailAddress), $subject, $msg, $headers);
				
				if (!$count) { 
					$count = true;
					
					$out = 'ok';
				}
				
				$number++;
            }
			
			if ($out == '' || $number == 0) { 
				_e('Error!!!', 'cmsmasters');
			} elseif ($out == 'ok' && $number == 1) { 
				echo __('Letter was sent', 'cmsmasters') . '.';
			} elseif ($out == 'ok' && $number > 1) { 
				echo $number . ' ' . __('letters have been sent', 'cmsmasters') . '.';
			}
        }
    } else {
        _e('Error!!!', 'cmsmasters');
    }
}

?>