<?php 
	/**
	 * File to handle listing items.
	 * 
	 * @todo Complete over view
	 * @author Iain Cambridge
	 * @since 1.3
	 */

/**
 * Handles the displaying of the main list page.  
 * 
 * @param string $type
 * 
 * @uses wpdb
 * 
 * @since 1.3
 */

function wpsqt_list_admin_main($type){
	
	global $wpdb;
	
	
	
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$itemsPerPage = get_option('wpsqt_number_of_items');
	$currentPage = wpsqt_functions_pagenation_pagenumber();	
	$startNumber = ( ($currentPage - 1) * $itemsPerPage );	
	
	$quizResults = $wpdb->get_results("SELECT q.id,q.name,q.status,'quiz' as type,COUNT(r.id) as results 
									   FROM ".WPSQT_QUIZ_TABLE." as q 
									   LEFT JOIN ".WPSQT_RESULTS_TABLE." as r 
									   ON r.quizid = q.id 
									   GROUP BY q.id" , ARRAY_A);
	$surveyResults = $wpdb->get_results("SELECT s.id,s.name,s.status,'survey' as type ,COUNT(r.id) as results 
										 FROM ".WPSQT_SURVEY_TABLE." as s 
										 LEFT JOIN ".WPSQT_SURVEY_SINGLE_TABLE." as r 
										 ON r.surveyid = s.id 
										 GROUP BY s.id" , ARRAY_A);
	
	$quizNo   = sizeof($quizResults);
	$surveyNo = sizeof($surveyResults);
	$totalNo  = $quizNo + $surveyNo;
	
	switch ($type){
		
		case 'all':
			$results = array_merge($quizResults,$surveyResults);
			break;
		case 'quiz':
			$results = $quizResults;
			break;
		case 'survey':
			$results = $surveyResults;
			break;
		
	}
	
	
	$results = array_slice($results , $startNumber , $itemsPerPage );
	$numberOfPages = wpsqt_functions_pagenation_pagecount($totalNo, $itemsPerPage);
	
	
	if ( empty($results) && $type == 'all' ){		
		require_once wpsqt_page_display('admin/main/empty.php');
	} else {	
		require_once wpsqt_page_display('admin/main/list.php');
	}
	
}

?>