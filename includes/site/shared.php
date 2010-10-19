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
	
	$quizName = $_SESSION['wpsqt']['current_name'];
	
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
			$_SESSION['wpsqt'][$quizName]['person']['name']    = (string) $_POST['user_name'];
			$_SESSION['wpsqt'][$quizName]['person']['email']   = (string) $_POST['email'];
			$_SESSION['wpsqt'][$quizName]['person']['phone']   = (string) $_POST['phone'];
			$_SESSION['wpsqt'][$quizName]['person']['address'] = (string) $_POST['address'];
			$_SESSION['wpsqt'][$quizName]['person']['notes']   = (string) $_POST['notes'];
			$_SESSION['wpsqt'][$quizName]['person']['heard']   = (string) $_POST['heard'];
			return true;
		}
	}
	
	require_once wpsqt_page_display('site/shared/contact.php');
	return false;
}

?>