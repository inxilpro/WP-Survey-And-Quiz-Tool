<?php 
	
	/**
	 * Shared functions for both quiz and survey sections.
	 * 
	 * @author Iain Cambridge
	 */


/**
 * Handles the forms
 *
 * @uses wpdb
 *
 * @since 1.1.5
 */

function wpsqt_admin_shared_forms(){
	
	global $wpdb;
	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) )  {
		require_once wpsqt_page_display('general/error.php');
		return;
	}
	
	$quizId = ( $_GET['type'] == 'quiz' ) ? $_GET['id'] : 0;
	$surveyId = ( $_GET['type'] == 'survey' ) ? $_GET['id'] : 0;
	
	if (  $_SERVER["REQUEST_METHOD"] == "POST"  && ( isset($_POST['field_name']) && !empty($_POST['field_name']) ) ){
	
		wpsqt_nonce_check();	
				
		$vaildFields = array();
		
		foreach ( $_POST['field_name'] as $key => $fieldName ){
						
			$fieldType = $_POST['field_type'][$key];
			$fieldRequired = $_POST['field_required'][$key];
			
			if ( empty($fieldName) || empty($fieldType) || empty($fieldRequired) ){
				continue;
			}
			
			$vaildFields[] = "('".$wpdb->escape($fieldName)."','".$wpdb->escape($fieldType)."','".$wpdb->escape($fieldRequired)."',".$quizId.",".$surveyId.")";
			
		}
		$wpdb->query("DELETE FROM `".WPSQT_FORM_TABLE."` WHERE quizid = ".$quizId."  AND surveyid = ".$surveyId);
		
		if ( !empty($vaildFields) ){
			$insertSql = "INSERT INTO `".WPSQT_FORM_TABLE."` (name,type,required,quizid,surveyid) VALUES ".implode(",", $vaildFields);
		}
		$wpdb->query($insertSql);
		
		if ( $quizId !== 0){
			// Get quiz details
			$wpdb->query("UPDATE ".WPSQT_QUIZ_TABLE." SET take_details='yes' WHERE id = ".$quizId);		
		} else {
			// Get survey details
			$wpdb->query("UPDATE ".WPSQT_SURVEY_TABLE." SET take_details='yes' WHERE id = ".$surveyId);	
		}
		$enabled = 'yes';
		
	} else {
	
		if ( $quizId !== 0){
			// Get quiz details
			$enabled = $wpdb->get_var('SELECT take_details FROM '.WPSQT_QUIZ_TABLE.' WHERE id = '.$quizId);		
		} else {
			// Get survey details
			$enabled = $wpdb->get_var('SELECT take_details FROM '.WPSQT_SURVEY_TABLE.' WHERE id = '.$surveyId);		
		}
		
	}
	
	$fields = $wpdb->get_results('SELECT * FROM '.WPSQT_FORM_TABLE.' WHERE quizid = '.$quizId.' AND surveyid = '.$surveyId,ARRAY_A);
	
	if (empty($fields)){
		$fields = array(
					array('name' => '','type' => '','required' => '')
		);
	}
	
	require_once wpsqt_page_display('admin/shared/form.php');
}

?>