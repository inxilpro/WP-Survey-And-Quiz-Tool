<?php

	/**
	 * Handles all result related requests. Such as listing,
	 * marking, deleting.
	 * @author Iain Cambridge
	 */

/**
 * Selects result id, timestamp, status person name, ip address
 * mark from the results table and quiz name from the quiz table
 * inner joining on the result table quiz id and quiz table id.
 * 
 * @uses pages/admin/results/index.php
 * @uses wpdb
 * 
 * @since 1.0
 */
function wpsqt_admin_results_show_list(){
	
	global $wpdb;
	
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$itemsPerPage = get_option('wpsqt_number_of_items');
	$currentPage = wpsqt_functions_pagenation_pagenumber();	
	$startNumber = ( ($currentPage - 1) * $itemsPerPage );
	$quizId = (int) $_GET['id'];
	$numbers = array('total' => 0);
	$filter = (isset($_GET['status'])) ? $_GET['status'] : 'all';
	
	if ( $filter == 'all' ){
		$rawResults = $wpdb->get_results('SELECT r.id,r.timestamp,r.status,r.person,r.person_name,r.mark,r.total,r.ipaddress,q.name FROM '.WPSQT_RESULTS_TABLE.' AS r INNER JOIN '.WPSQT_QUIZ_TABLE.' as q ON q.id = r.quizid WHERE r.quizid = '.$quizId.' ORDER BY r.id DESC',ARRAY_A);
	} else {
		$rawResults = $wpdb->get_results(
									$wpdb->prepare('SELECT r.id,r.timestamp,r.status,r.person,r.person_name,r.mark,r.total,r.ipaddress,q.name FROM '.WPSQT_RESULTS_TABLE.' AS r INNER JOIN '.WPSQT_QUIZ_TABLE.' as q ON q.id = r.quizid WHERE r.quizid = '.$quizId.' AND LCASE(r.status) = LCASE(\'%s\') ORDER BY r.id DESC', array($filter))
											);
		
	}
	foreach( array('Unviewed','Rejected','Accepted') as $status ){
		$numbers[strtolower($status)] = $wpdb->get_var("SELECT COUNT(status) as count FROM ".WPSQT_RESULTS_TABLE." WHERE status = '".$status."' and quizid = ".$quizId);
		$numbers['total'] += $numbers[strtolower($status)];
	}
	
	$showingResultsFor = $wpdb->get_var('SELECT name FROM '.WPSQT_QUIZ_TABLE.' WHERE id = '.$quizId);
	$results = array_slice($rawResults , $startNumber , $itemsPerPage );
	$numberOfItems = sizeof($rawResults);
	$numberOfPages = wpsqt_functions_pagenation_pagecount($numberOfItems, $itemsPerPage);
	
	define('WPSQT_RESULT_URL', get_bloginfo('url').'/wp-admin/admin.php?page='.WPSQT_PAGE_MAIN.'&type=quiz&action=results&id='.$quizId );
	
	require_once wpsqt_page_display('admin/results/index.php');
}

/**
 * Fetches person serialized array, sections serialized array,
 * ipaddress,status,timestamp,timetaken from results where id 
 * equals the get variable resultid with an inner join on quiz
 * where quiz table id equals result table quizid.
 * 
 * If a post method then updates mark and comment for each 
 * non-multiple choice question. Then executes a UPDATE sql query
 * to update status,person serialized array, sections serialized
 * array and mark. 
 * 
 * @uses pages/general/error.php
 * @uses pages /admin/results/mark.php
 * @uses wpdb
 * 
 * @since 0.1
 */

function wpsqt_admin_results_quiz_mark(){
	
	global $wpdb;
	
	if ( !isset($_GET['subid']) || !ctype_digit($_GET['subid']) ){
		require_once wpsqt_page_display('general/error.php');
	}
	
	$resultId = (int) $_GET['subid'];
	
	$result = $wpdb->get_row( 'SELECT r.person,r.ipaddress,r.sections,r.status,r.timestamp,r.timetaken,q.name FROM '.WPSQT_RESULTS_TABLE.' as r INNER JOIN '.WPSQT_QUIZ_TABLE.' as q ON q.id = r.quizid WHERE r.id = '.$resultId, ARRAY_A );
	
	$result['person'] = unserialize($result['person']);
	$result['sections'] = unserialize($result['sections']);
	
	if ( !empty($_POST) ){
	
		wpsqt_nonce_check();
		
		$overallMark = (int)$_POST['overall_mark'];	
		$totalMark = (int)$_POST['total_mark'];
		foreach ( $result['sections'] as $sectionKey => $section ){
			
			foreach ( $section['questions'] as $questionKey => $question ){
				
				if ( isset($_POST['mark'][$questionKey]) ){					
					$result['sections'][$sectionKey]['questions'][$questionKey]['mark'] = (int)$_POST['mark'][$questionKey];
				}
				if ( isset($_POST['comment'][$questionKey]) ){
					$result['sections'][$sectionKey]['questions'][$questionKey]['comment'] = $_POST['comment'][$questionKey];
				}
			}
			
		}
		
		$wpdb->query( $wpdb->prepare('UPDATE '.WPSQT_RESULTS_TABLE.' SET sections=%s,status=%s,mark=%d,total=%d WHERE id = %d', array( serialize($result['sections']),$_POST['status'],$overallMark,$totalMark,$resultId) ) );
		$successMessage = 'Result has successfully been updated!';
	}
	
	$timeTaken = "";
	
	$seconds = $result['timetaken'] % 60;
	$minutes = intval($result['timetaken'] / 60);
	$hours = intval($minutes / 60);
	$minutes = $minutes % 60;
	$days = intval($hours / 24);
	$hours = $hours % 24;
	
	if ($days != 0){
		$timeTaken .= $days.' Days ';
	}
    if ($hours != 0){
    	$timeTaken .= $hours.' Hours ';
    }
    if ($minutes != 0){
    	$timeTaken .= $minutes.' Minutes ';
    }
    if ($seconds != 0){
    	$timeTaken .= $seconds.' Seconds';
    }
    $timeTaken = trim($timeTaken);
    
   require_once wpsqt_page_display('admin/results/mark.php');
	
}

/**
 * Allows you to delete a result, has a confirm page to decrease accidental
 * deletion.
 * 
 * @uses wpdb
 * @uses pages/general/error.php
 * @uses pages/general/message.php
 * @uses pages/admin/results/delete.php
 * 
 * @since 0.1
 */

function wpsqt_admin_results_delete_result(){
	
	global $wpdb;
	
	if ( !isset($_GET['subid']) || !ctype_digit($_GET['subid']) ){  
	    require_once wpsqt_page_display('general/error.php');
	}
	
	$resultId = (int)$_GET['subid'];
	
	if ( empty($_POST) ){
		$personName = $wpdb->get_var('SELECT person_name FROM '.WPSQT_RESULTS_TABLE.' WHERE id = '.$resultId);  
	    require_once wpsqt_page_display('admin/results/delete.php');
	}
	elseif ( isset($_POST['confirm']) && $_POST['confirm'] == 'Yes' ){
	
		wpsqt_nonce_check();
		
		$wpdb->query('DELETE FROM '.WPSQT_RESULTS_TABLE.' WHERE id = '.$resultId);
		$message = 'Result succesfully deleted';  
	    require_once wpsqt_page_display('general/message.php');
	}
	
}

?>