<?php

/**
 * Handles displaying the results for quizzes and surveys.
 * 
 * 
 * @author Iain Cambridge
 * @copyright Fubra Limited 2010-2011, all rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
 * @package WPSQT
 */
class Wpsqt_Page_Main_Results extends Wpsqt_Page {
	
	public function process(){
		
		global $wpdb;
		
		if ( !isset($_GET['id']) ){
			// do some redirection here.
			// TODO add redirect function in code.
		}
		if ( isset($_GET['marked']) && $_GET['marked'] == "true" ){
			$this->_pageVars['message'] = "Result successfully marked!";
		}	
		if ( isset($_GET['deleted']) && $_GET['deleted'] == "true" ){
			$this->_pageVars['message'] = "Result successfully deleted!";
		}
	
		
		$unviewed = $wpdb->get_results(
						$wpdb->prepare( "SELECT * 
						                 FROM `".WPSQT_TABLE_RESULTS."` 
						                 WHERE item_id = %d 
						                 AND LCASE(status) = 'unviewed'
						                 ORDER BY ID DESC" 
										, array($_GET['id']) )	, ARRAY_A	
										);
		$accepted = $wpdb->get_results(
						$wpdb->prepare( "SELECT * 
						                 FROM `".WPSQT_TABLE_RESULTS."` 
						                 WHERE item_id = %d 
						                 AND LCASE(status) = 'accepted'
						                 ORDER BY ID DESC" 
										, array($_GET['id']) )	, ARRAY_A	
										);
		$rejected = $wpdb->get_results(
						$wpdb->prepare( "SELECT * 
						                 FROM `".WPSQT_TABLE_RESULTS."` 
						                 WHERE item_id = %d 
						                 AND LCASE(status) = 'rejected'
						                 ORDER BY ID DESC" 
										, array($_GET['id']) )	, ARRAY_A	
										);
		if ( !isset($_GET['status']) || !isset(${$_GET['status']}) ) {								
			$rawResults = array_merge($unviewed,$accepted,$rejected);
		} else {
			$rawResults = ${$_GET['status']};
		}
		
		$itemsPerPage = get_option('wpsqt_number_of_items');
		$currentPage = Wpsqt_Core::getCurrentPageNumber();	
		$startNumber = ( ($currentPage - 1) * $itemsPerPage );
		
		$this->_pageVars['results'] = array_slice($rawResults , $startNumber , $itemsPerPage );
		$this->_pageVars['counts'] = array('unviewed_count' => sizeof($unviewed), 
										   'accepted_count' => sizeof($accepted),
										   'rejected_count' => sizeof($rejected));
		$this->_pageVars['numberOfPages'] = Wpsqt_Core::getPaginationCount(sizeof($rawResults), $itemsPerPage);
		$this->_pageVars['currentPage'] = Wpsqt_Core::getCurrentPageNumber();
				
		return false;
		
	}
	
}