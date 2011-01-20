<?php

	/**
	 * File for handling all admin side survey
	 * functionality.
	 * 
	 * @author Iain Cambridge
	 */

/**
 * Displays a list of surveys in the system.
 * With links to configure, edit questions and 
 * delete. 
 *  
 * @uses pages/admin/survey/index.php
 * @uses includes/functions.php
 * @uses wpdb
 * 
 * @since 1.1
 */
function wpsqt_admin_survey_list(){
	
	global $wpdb;
	
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$itemsPerPage = get_option('wpsqt_number_of_items');
	$currentPage = wpsqt_functions_pagenation_pagenumber();	
	$startNumber = ( ($currentPage - 1) * $itemsPerPage );	
	
	$rawSurveyList = $wpdb->get_results( 'SELECT id,name FROM '.WPSQT_SURVEY_TABLE.' ORDER BY id' , ARRAY_A );
	$surveyList = array_slice($rawSurveyList , $startNumber , $itemsPerPage );
	$numberOfItems = sizeof($rawSurveyList);
	$numberOfPages = wpsqt_functions_pagenation_pagecount($numberOfItems, $itemsPerPage);

	require_once wpsqt_page_display('admin/surveys/index.php');
	
}

/**
 * Allows users to create surveys
 *  
 * @uses wpdb
 * @uses pages/admin/survey/create.php
 * 
 * @since 1.1
 */
	
function wpsqt_admin_survey_create($edit = false){
	
	global $wpdb;
	
	if ( $edit == true ){
		if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){
			wpsqt_page_display('general/error.php');
			return;			
		}
		//
		$surveyId = (int) $_GET['id'];
	}
	
	if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
	
		wpsqt_nonce_check();
		
		$errorArray    = array();
		$surveyDetails = array();
		
		if ( !isset($_POST['survey_name']) || empty($_POST['survey_name']) ){
			$errorArray[] = 'Survey name must be supplied';
		} else {
			$surveyDetails['name'] = $_POST['survey_name'];
		}
		
		// check if there is any errors if not insert into table
		if ( empty($errorArray) ){
			if ( $edit === false ){
				if ( false !== $wpdb->query($wpdb->prepare('INSERT INTO '.WPSQT_SURVEY_TABLE.' (name,status,take_details,send_email,email_template) VALUES (%s,%s,%s,%s,%s) ',
											array($surveyDetails['name'],$_POST['status'],$_POST['take_details'],$_POST['send_email'],$_POST['email_template']))) ) {
					
							$successMessage = 'Survey successfully added';
				}
				$surveyId = $wpdb->insert_id;
			} else {
				
				$wpdb->query(
					$wpdb->prepare('UPDATE '.WPSQT_SURVEY_TABLE.' SET name=%s,status=%s,take_details=%s,send_email=%s,email_template=%s WHERE id  = %d',
									array($_POST['survey_name'],$_POST['status'],$_POST['take_details'],$_POST['send_email'],$_POST['email_template'],$surveyId) )
				);
				$successMessage = 'Survey successfully updated';
			}
		}
		
		
		
	}

	if ( isset($surveyId) ){	
		$surveyDetails = $wpdb->get_row( 'SELECT * FROM '.WPSQT_SURVEY_TABLE.' WHERE id = '. $surveyId , ARRAY_A);
	}	
	require_once wpsqt_page_display('admin/surveys/create.php');
}


/**
 * Allows users to delete surveys.
 * 
 * @uses wpdb
 * 
 * @since 1.1
 */
	
function wpsqt_admin_survey_delete(){
	
	global $wpdb;
	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){
		require_once wpsqt_page_display('general/error.php');
		return;
	}
	$surveyId = (int) $_GET['id'];
	
	if ( $_SERVER["REQUEST_METHOD"] !== "POST" ){
		// Make sure they mean it.
		$surveyName = $wpdb->get_var('SELECT name FROM '.WPSQT_SURVEY_TABLE.' WHERE id = '.$surveyId);
		require_once wpsqt_page_display('admin/surveys/delete.php');
		return;	
	} elseif ( isset($_POST['confirm']) && $_POST['confirm'] == 'Yes' ){
		
		wpsqt_nonce_check();
		$wpdb->query('DELETE FROM '.WPSQT_SURVEY_TABLE.' WHERE id = '.$surveyId);
		
		$message = 'Survey deleted successfully!';
		require_once wpsqt_page_display('general/message.php');
	}
	else {		
		require_once wpsqt_page_display('general/error.php');
	}
	
}

/**
 * Allows users to add/edit/delete survey sections.
 * 
 * @uses wpdb
 * @uses pages/general/error.php
 * @uses pages/admin/surveys/sections.php
 * 
 * @since 1.1
 */

function wpsqt_admin_survey_sections(){
	
	global $wpdb;
	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){		
		wpsqt_page_display('general/error.php');
		return;
	} 
	
	if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
		
		wpsqt_nonce_check();
		$validData = array();
		    
		for ( $i = 0; $i < sizeof($_POST['section_name']); $i++ ){
			// You may regonize this bit from elsewhere... I broke DRY..
			// Check and make sure all data required is given
			// aswell as ensuring data is correct type. If not
			// we'll just skip to the next one.
			// Here comes a massive if statement...
		   	if (!isset($_POST['section_name'][$i]) || empty($_POST['section_name'][$i]) ){
		      	$status = 'delete';
		     } else {
		     	$status = 'input';
		     }
		     
		     $type = (isset($_POST['type'][$i])) ? $_POST['type'][$i] : 'multiple';
		     $number = (isset($_POST['number'][$i])) ? $_POST['number'][$i] : 10;
		     $order = (isset($_POST['order'][$i])) ? $_POST['order'][$i] : 'asc';
		     
		     $sectionId = (isset($_POST['sectionid'][$i])) ? intval($_POST['sectionid'][$i]) : NULL;
		   	 // All that, just for this...
		   	 $validData[] = array( 'name'        => $_POST['section_name'][$i],
		    	 				   'number'      => $number,
		    	 				   'type'        => $type,
		    	 				   'order'       => $order,
		   	 					   'id'          => $sectionId,
		   	 					   'status'      => $status);
		}
		
		if ( !empty($validData) ){
		    // Generate SQL query
			$insertSql = 'INSERT INTO `'.WPSQT_SURVEY_SECTION_TABLE.'` (surveyid,name,type,number,orderby) VALUES ';
			$insertSqlParts = array();
			$insert = false;
			foreach ($validData as $key => $data) {
				if ($data['status'] == 'input'){
					if ( isset($data['id']) && !empty($data['id']) ){
				    		$wpdb->query( $wpdb->prepare('UPDATE '.WPSQT_SURVEY_SECTION_TABLE.'
				    									  SET name=%s,
				    									  type=%s,
				    									  number=%d,
				    									  orderby=%s
				    									  WHERE id = %d',
				    		array($data['name'],$data['type'],$data['number'],$data['order'],$data['id'])) );
				    		continue;
				    } 
				    $insert = true;					
					$insertSqlParts[] = "(". $wpdb->escape($_GET['id']) .",'".
					   				 		 $wpdb->escape($data['name']) ."','".
					   				  		 $wpdb->escape($data['type']) ."','".
					   				 		 $wpdb->escape($data['number'])."','".
					   				 		 $wpdb->escape($data['order']) ."')" ;
				} else {				
				    // Delete it and questions related to it.
				    if ( isset($data['id']) ){			    		
				    	$wpdb->query('DELETE FROM '.WPSQT_SURVEY_SECTION_TABLE.' WHERE id = '.$data['id']);
				    	$wpdb->query('DELETE FROM '.WPSQT_SURVEY_QUESTIONS_TABLE.' WHERE sectionid = '.$data['id']);			    		
				    }
				}
			}
			    
			if ( $insert == true ){
				$insertSql .= implode(',',$insertSqlParts);			
				$wpdb->query($insertSql);
			}
			$successMessage = 'Sections updated!';
		}
		
	} 
	
	$validData = $wpdb->get_results('SELECT * FROM '.WPSQT_SURVEY_SECTION_TABLE.' WHERE surveyid = '.$wpdb->escape($_GET['id']) , ARRAY_A );
	
	require_once wpsqt_page_display('admin/surveys/sections.php');
	
	return;
}

/**
 * Displays the list of questions.
 * 
 * @uses wpdb
 * @uses includes/functions.php
 * @uses pages/admin/surveys/question.list.php
 * 
 * @since 1.1
 */

function wpsqt_admin_survey_question_list(){
	
	global $wpdb;

	require_once WPSQT_DIR.'/includes/functions.php';
	
	$itemsPerPage = get_option('wpsqt_number_of_items');
	$currentPage = wpsqt_functions_pagenation_pagenumber();	
	$startNumber = ( ($currentPage - 1) * $itemsPerPage );	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){
		$rawQuestions = $wpdb->get_results('SELECT id,text,type,surveyid FROM '.WPSQT_SURVEY_QUESTIONS_TABLE.' ORDER BY id ASC', ARRAY_A);
	} else {
		$rawQuestions = $wpdb->get_results('SELECT id,text,type,surveyid FROM '.WPSQT_SURVEY_QUESTIONS_TABLE.' WHERE surveyid = '.$wpdb->escape($_GET['id']).' ORDER BY id ASC', ARRAY_A);
	}
	$questions = array_slice($rawQuestions , $startNumber , $itemsPerPage );
	$numberOfItems = sizeof($rawQuestions);
	$numberOfPages = wpsqt_functions_pagenation_pagecount($numberOfItems, $itemsPerPage);
	
	require_once wpsqt_page_display('admin/surveys/question.list.php');
	
}


/**
 * Allows for the creation
 * 
 * @uses wpdb
 * @uses pages/general/error.php
 * @uses pages/admin/surveys/question.create.php
 * 
 * @param boolean $edit Tells if a new question or just editing
 * 
 * @since 1.1
 */

function wpsqt_admin_survey_question_create($edit = false){
	
	global $wpdb;
	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){
		require_once wpsqt_page_display('general/error.php');
		return;		
	}

	$surveyId = (int)$_GET['id'];
		
	$sections = $wpdb->get_results('SELECT name,id FROM '.WPSQT_SURVEY_SECTION_TABLE.' WHERE surveyid = '.$surveyId , ARRAY_A );
		
	if ( $_SERVER["REQUEST_METHOD"] == "POST" ){
		wpsqt_nonce_check();
		
		$errorArray = array();
		
		if ( !isset($_POST['question']) || empty($_POST['question']) ){
			$errorArray[] = 'Question text is required.';
		}
		
		if ( !isset($_POST['type']) || empty($_POST['type']) ){
			$errorArray[] = 'Question type is requred';
		}
		
		if ( !isset($_POST['section']) || !ctype_digit($_POST['section']) ){
			$errorArray[] = 'Section is required';
		}
		
		if ( empty($errorArray) ){
			$sectionId = (int) $_POST['section'];
			
			$questionOther = ( isset($_POST['question_other']) && $_POST['question_other'] == 'yes' ) ? 'yes' : 'no';
			
			if ( $edit === false ){
				$wpdb->query(
					 $wpdb->prepare('INSERT INTO `'.WPSQT_SURVEY_QUESTIONS_TABLE.'` (surveyid,text,type,sectionid,include_other) VALUES (%d,%s,%s,%d,%s)' ,
									 array($surveyId,$_POST['question'],$_POST['type'],$sectionId,$questionOther) )
				);
				
				$questionId = $wpdb->insert_id;
				
				$successMessage = 'Question succesfully added!';
			} else {
				
				$questionId = (int) $_GET['questionid'];

				$wpdb->query(
					$wpdb->prepare( 'UPDATE `'.WPSQT_SURVEY_QUESTIONS_TABLE.'` SET text=%s,type=%s,include_other=%s,sectionid=%d WHERE id = %d' ,
									array($_POST['question'], $_POST['type'],$questionOther,$sectionId,$questionId) )
				);
								
				$wpdb->query( 'DELETE FROM `'.WPSQT_SURVEY_ANSWERS_TABLE.'` WHERE questionid = '.$questionId);
				
				$successMessage = 'Question succesfully updated!';
			}
			
			// Since it's used by both edit and new.
			if ( $_POST['type'] != 'scale' ){
					$validAnswers = array();
					$answerInsertSql = 'INSERT INTO `'.WPSQT_SURVEY_ANSWERS_TABLE.'` (questionid,text) VALUES ';
					
					foreach ( $_POST['answer'] as $answer ){
						if ( !empty($answer) ){
							$validAnswers[] = "(".$questionId.",'".$wpdb->escape($answer)."')";
						}
					}
					$answerInsertSql .= implode(',', $validAnswers);
					$wpdb->query( $answerInsertSql );
				}
		}
		
	} elseif ( $edit !== false ){
		$questionId = (int)$_GET['questionid'];
		list($questionText,$questionType,$sectionId,$questionOther) = $wpdb->get_row('SELECT text,type,sectionid,include_other FROM '.WPSQT_SURVEY_QUESTIONS_TABLE.' WHERE id = '.$questionId , ARRAY_N);
		if ( $questionType != 'scale' ){
			$answers = $wpdb->get_results('SELECT text FROM '.WPSQT_SURVEY_ANSWERS_TABLE.' WHERE questionid = '.$questionId, ARRAY_A);
		}
	}
	
	require_once wpsqt_page_display('admin/surveys/question.create.php');	
	
}

/**
 * Allows the user to delete questions in the survey.
 * 
 * @uses wpdb
 * @uses pages/general/error.php
 * @uses pages/general/message
 * @uses pages/admin/surveys/question.delete.php
 * 
 * @since 1.1
 */

function wpsqt_admin_survey_question_delete(){
	
	global $wpdb;
	
	if ( !isset($_GET['subid']) || !ctype_digit($_GET['subid']) ){
		require_once wpsqt_page_display('general/error.php');
		return;
	}
		
	$questionId = (int) $_GET['questionid'];
	
	if ( $_SERVER["REQUEST_METHOD"] !== "POST" ){
		// Make sure they mean it.
		$questionText = $wpdb->get_var('SELECT text FROM '.WPSQT_SURVEY_QUESTIONS_TABLE.' WHERE id = '.$questionId);
		require_once wpsqt_page_display('admin/surveys/question.delete.php');
		return;	
	} else {
		wpsqt_nonce_check();
		$wpdb->query( 'DELETE FROM '.WPSQT_SURVEY_QUESTIONS_TABLE.' WHERE id = '.$questionId );
		$message = 'Question successfully deleted!';
		require_once wpsqt_page_display('general/message.php');
	}
	
	
}

/**
 * Displays a list of single results.
 * 
 * 
 * @uses wpdb
 * @uses pages/general/error.php
 * @uses includes/functions.php
 * @uses pages/admin/surveys/result.list.php
 * 
 * @since 1.1
 */

function wpsqt_admin_survey_result_list(){
	
	global $wpdb;
	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){
		require_once wpsqt_page_display('general/error.php');
		return;		
	}
	
	require_once WPSQT_DIR.'/includes/functions.php';
	$surveyId = (int)$_GET['id'];
	$itemsPerPage = get_option('wpsqt_number_of_items');
	$currentPage = wpsqt_functions_pagenation_pagenumber();	
	$startNumber = ( ($currentPage - 1) * $itemsPerPage );	
	$rawResults = $wpdb->get_results('SELECT id,name as person_name,ipaddress FROM '.WPSQT_SURVEY_SINGLE_TABLE.' WHERE surveyid = '.$surveyId.' ORDER BY id DESC', ARRAY_A);
	$results = array_slice( $rawResults , $startNumber , $itemsPerPage );
	$numberOfItems = sizeof( $rawResults );
	$numberOfPages = wpsqt_functions_pagenation_pagecount($numberOfItems, $itemsPerPage);
	$showingResultsFor = $wpdb->get_var( 'SELECT name FROM '.WPSQT_SURVEY_TABLE.' WHERE id = '.$surveyId );
	
	
	define('WPSQT_RESULT_URL', get_bloginfo('url').'/wp-admin/admin.php?page='.WPSQT_PAGE_MAIN.'&type=survey&action=results&id='.$surveyId );
	
	
	require_once wpsqt_page_display('admin/surveys/result.list.php');
}

/**
 * Displays the result of the survey from a single person.
 * 
 * @uses wpdb
 * @uses pages/general/error.php
 * @uses pages/admin/surveys/result.single.php
 * 
 * @since 1.1
 */

function wpsqt_admin_survey_result_single(){
	
	global $wpdb;
	
	if ( !isset($_GET['subid']) || !ctype_digit($_GET['subid']) ){
		wpsqt_page_display('general/error.php');
		return;		
	}
	
	$resultId = (int) $_GET['subid'];
	
	$result = $wpdb->get_row("SELECT surveyid,person,name,results,ipaddress,user_agent 
							  FROM `".WPSQT_SURVEY_SINGLE_TABLE."`
							  WHERE id = ".$resultId , ARRAY_A );
	$result['person'] = unserialize($result['person']);
	$result['results'] = unserialize($result['results']);
	require_once wpsqt_page_display('admin/surveys/result.single.php');
	
}

/**
 * Shows the total result from the survey. Shows 
 * nice pie graphs using google charts.
 * 
 * @uses wpdb
 * @uses pages/general/error.php
 * @uses pages/admin/surveys/result.total.php
 * 
 * @since 1.1
 */

function wpsqt_admin_survey_result_total(){
	
	global $wpdb;
	
	if ( !isset($_GET['id']) || !ctype_digit($_GET['id']) ){
		require_once wpsqt_page_display('general/error.php');
		return;		
	}
	
	$surveyId = (int) $_GET['id'];
	// Fetch multiple choice items
	$results = $wpdb->get_results( 'SELECT sq.id,sq.text AS question,sqa.text AS answer, COUNT(sr.id) AS total,sr.type
									FROM `'.WPSQT_SURVEY_QUESTIONS_TABLE.'` as sq
									INNER JOIN `'.WPSQT_SURVEY_ANSWERS_TABLE.'` as sqa ON sqa.questionid = sq.id
									LEFT JOIN `'.WPSQT_SURVEY_RESULT_TABLE.'` as sr ON sr.questionid = sq.id AND sr.answerid = sqa.id
									WHERE sq.surveyid = '.$surveyId.' AND sq.type = \'multiple\'
									GROUP BY sq.id, sqa.id' , ARRAY_A );
	$surveyArray = array();	
	foreach ( $results as $result ){
		$surveyArray[$result['type']][$result['id']][] = $result;
	}
	// Fetch the others
	if ( isset($surveyArray['multiple']) && is_array($surveyArray['multiple']) ){
		foreach( $surveyArray['multiple'] as $questionId => $result){
			$surveyArray['multiple'][$questionId][] = 
				$wpdb->get_row('SELECT COUNT(sr.id) AS total,\'Other\' as answer 
								FROM `'.WPSQT_SURVEY_RESULT_TABLE.'` AS sr 
								WHERE sr.surveyid = '.$surveyId.' 
								AND sr.questionid = '.$questionId.' 
								AND sr.answerid = 0' , ARRAY_A );
		}
	}
	// Fetch scale items
	$results = $wpdb->get_results( 'SELECT sq.id,sq.text AS question,sq.type,COUNT(sr.value) as count,
									(SUM(sr.value) / COUNT(sr.value) ) AS total
									FROM `'.WPSQT_SURVEY_QUESTIONS_TABLE.'` as sq
									LEFT JOIN `'.WPSQT_SURVEY_RESULT_TABLE.'` as sr ON sr.questionid = sq.id
									WHERE sq.surveyid = '.$surveyId.' AND sq.type = \'scale\'
									GROUP BY sq.id' , ARRAY_A );
	
	foreach ( $results as $result ){		
		$surveyArray[$result['type']][$result['id']] = $result;
	}
	
	require_once wpsqt_page_display('admin/surveys/result.total.php');
}
?>