<?php

	/**
	 *  File containing functions used by both the quiz 
	 *  and survey sections. Created soley to comply 
	 *  with DRY.
	 * 
	 * @author Iain Cambridge
	 */


/**
 * Simply function to  display contact and to
 * take and check data to ensure it is provided.
 * 
 * @param boolean $collectDetails
 * 
 * @uses pages/site/quiz/contact.php
 * 
 * @return boolean True if collectDetails is true and there is no errors. Else returns false and displays the contact page.
 * 
 * @since 0.1
 */

function wpsqt_site_shared_take_details($collectDetails = true){
	
	global $wpdb;
	$quizName = $_SESSION['wpsqt']['current_name'];

	if ($_SESSION['wpsqt']['current_type'] == 'quiz'){			
		$quizId = $_SESSION['wpsqt'][$quizName]['quiz_details']['id'];
		$surveyId = 0;		
	} else {		
		$surveyId = $_SESSION['wpsqt'][$quizName]['survey_details']['id'];
		$quizId = 0;
	}
	
	$fields = $wpdb->get_results("SELECT * FROM `".WPSQT_FORM_TABLE."` WHERE quizid = ".$quizId."  AND surveyid = ".$surveyId, ARRAY_A);
	
	if ( !empty($fields) ){
		return wpsqt_site_shared_custom_form($fields);
	}
	
	if ($collectDetails == true ){

		$errors = array();
		if ( !isset($_POST['user_name']) || empty($_POST['user_name']) ){
			$errors[] = 'Name required';
		}	
		if ( !isset($_POST['email']) || !is_email($_POST['email']) ){
			$errors[] = 'Valid email required';
		}	
		if ( !isset($_POST['phone']) || empty($_POST['phone']) ){
			$errors[] = 'Phone required';
		}		
		if ( !isset($_POST['address']) || empty($_POST['address']) ){
			$errors[] = 'Address required';
		}
		if ( !isset($_POST['notes']) || empty($_POST['notes']) ){
			$errors[] = 'Experience required';
		}
			
		if ( empty($errors) ){
			$_SESSION['wpsqt'][$quizName]['person'] = $_POST;
			unset($_SESSION['wpsqt'][$quizName]['person']['step']);
			return true;
		}
	}
	
	require_once wpsqt_page_display('site/shared/contact.php');
	return false;
}


/**
 * Handles the processing of the custom form fields.
 * 
 * @uses wpdb
 * 
 * @param array $fields
 * 
 * @since 1.2
 */

function wpsqt_site_shared_custom_form($fields){
	
	global $wpdb;
	$quizName = $_SESSION['wpsqt']['current_name'];
	
	if ( !empty($_POST) ){
		
		foreach ( $fields as $field ){
			if ($field['required'] == 'yes'){
				$fieldName = preg_replace('~[^a-z0-9]~i','',$field['name']);
				if ( !isset($_POST["Custom_".$fieldName]) || empty($_POST["Custom_".$fieldName]) ){
					$errors[] = $field['name'].' is required';
				}
			}
		}
		
		if ( empty($errors) ){
			$_SESSION['wpsqt'][$quizName]['person'] = $_POST;
			unset($_SESSION['wpsqt'][$quizName]['person']['step']);
			return true;
		}
		
	}
	
	require_once wpsqt_page_display('site/shared/custom-form.php');
	return false;
}

/**
 * Handles sending notification emails for the plugin.
 * 
 * @uses wpdb
 * 
 * @since 1.3.0
 */
function wpsqt_site_shared_email(){
	
	global $wpdb;
	
	$quizName = $_SESSION['wpsqt']['current_name'];
	$quizId = $_SESSION['wpsqt']['current_id'];
	$quizDetails = ($_SESSION['wpsqt']['current_type'] == 'quiz') ? $_SESSION['wpsqt'][$quizName]['quiz_details'] : $_SESSION['wpsqt'][$quizName]['survey_details'];
	$emailTemplate = (empty($quizDetails['email_template'])) ? get_option('wpsqt_email_template'):$quizDetails['email_template'];
	$fromEmail = ( get_option('wpsqt_from_email') ) ? get_option('wpsqt_from_email') : get_option('admin_email');	
	$role = get_option('wpsqt_email_role');
	$personName = ( isset($_SESSION['wpsqt'][$quizName]['person']['user_name']) && !empty($_SESSION['wpsqt'][$quizName]['person']['user_name']) ) ? $_SESSION['wpsqt'][$quizName]['person']['user_name'] : 'Anonymous';
	
	if ( !empty($role) && $role != 'none' ){
		$this_role = "'[[:<:]]".$role."[[:>:]]'";
  		$query = "SELECT * FROM $wpdb->users WHERE ID = ANY (SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'wp_capabilities' AND meta_value RLIKE $this_role) ORDER BY user_nicename ASC LIMIT 10000";
  		$users = $wpdb->get_results($query,ARRAY_A);
  		$emailList = array();
  		foreach($users as $user){
  			$emailList[] = $user['user_email'];
  		}
	}
	
	if ( !isset($emailList) || empty($emailList) ){
		$emailAddress = get_option('wpsqt_contact_email');
		$emailList = explode(',', $emailAddress);
	}
	
	
	if ( empty($emailTemplate) ){
		
		$emailMessage  = 'There is a new result to view'.PHP_EOL.PHP_EOL;
		$emailMessage .= 'Person Name :'.$personName.PHP_EOL;
		$emailMessage .= 'IP Address :'.$_SERVER['REMOTE_ADDR'].PHP_EOL;
					
	} else {
		
		$emailMessage = str_ireplace( '%USER_NAME%'   , $personName, $emailTemplate);
		$emailMessage = str_ireplace( '%QUIZ_NAME%'   , $quizName, $emailMessage);
		$emailMessage = str_ireplace( '%SURVEY_NAME%' , $quizName, $emailMessage);
		$emailMessage = str_ireplace( '%DATE_EU%'     , date('d-m-Y'),$emailMessage );
		$emailMessage = str_ireplace( '%DATE_US%'     , date('m-d-Y'),$emailMessage );
		$emailMessage = str_ireplace( '%DATETIME_EU%' , date('d-m-Y H:i:s'),$emailMessage );
		$emailMessage = str_ireplace( '%DATETIME_US%' , date('m-d-Y H:i:s'),$emailMessage );
		$emailMessage = str_ireplace( '%IP_ADDRESS%'   , $_SERVER['REMOTE_ADDR'], $emailMessage );
		$emailMessage = str_ireplace( '%HOSTNAME%'    , gethostbyaddr($_SERVER['REMOTE_ADDR']) , $emailMessage);
		$emailMessage = str_ireplace( '%USER_AGENT%'  , $_SERVER['HTTP_USER_AGENT'], $emailMessage);
		
		if ( preg_match_all('~%USERMETA_(.*)%~isU',$emailMessage,$matches) ){			
			foreach( $matches[1] as $match ){				
				if ( $userMeta = get_user_meta($match) ){
					$emailMessage = str_replace('%USERMETA_'.$match.'%', $userMeta, $emailMessage);
				}				
			}			
		}
		$resultUrl = get_bloginfo('url').'/wp-admin/admin.php?page=wpsqt-menu&type='.
					$_SESSION['wpsqt']['current_type'].'&action=results&id='.$quizId
					.'&subaction=';
		$resultUrl .= ($_SESSION['wpsqt']['current_type'] == 'quiz') ? 'mark' : 'view';
		if ( isset($_SESSION['wpsqt']['result_id']) ){
			$resultUrl .= '&subid='.$_SESSION['wpsqt']['result_id'];
		}
		$emailMessage = str_ireplace('%RESULT_URL%', $resultUrl, $emailMessage);
	}
	
	
	$emailSubject  = 'There is a new result!';
	$headers = 'From: WPSQT Bot <'.$fromEmail.'>' . "\r\n";

	foreach( $emailList  as $emailAddress ){
		wp_mail($emailAddress,'WPSQT Notification',$emailMessage,$headers);
	}
		
}

/**
 * Handles sending custom notification emails.
 * 
 * @uses wpdb
 * 
 * @since 1.3.0
 */
function wpsqt_site_shared_custom(){
	
	
	$fromEmail = ( get_option('wpsqt_from_email') ) ? get_option('wpsqt_from_email') : get_option('admin_email');
	
}

?>