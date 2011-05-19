<?php

	/**
	 * Handles the creation and management of questions.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Question extends Wpsqt_Page {
	
	/**
	 * (non-PHPdoc)
	 * @see Wpsqt_Page::process()
	 */
	public function process(){
		
		global $wpdb;
		
		$questions = Wpsqt_System::getQuizQuestionTypes();		
		
		// Builds the query for the question counts.
		
		$sql = "SELECT count(id) as `all_count`,";		
		$questionCounts = array();
		$questionTypes = array('all');
		$itemId = $wpdb->prepare("%d",array($_GET['id']));
		
		foreach ( $questions as $questionType => $description ){
			// Part of the query which fetches the query count for the singl
			$sqlFriendlyType = str_replace(' ', '', $questionType);
			$questionCounts[] = " (SELECT count(id) FROM ".WPSQT_TABLE_QUESTIONS." WHERE item_id = ".$itemId.
								" and type = '".$questionType."') as `".$sqlFriendlyType."_count` ";
			
			$questionTypes[] = $questionType;
		}
		// Finishes off the query for the question counts.
		$sql .= implode(',',$questionCounts);		
		$sql .= "FROM ".WPSQT_TABLE_QUESTIONS." WHERE item_id = ".$itemId;
		
		
		$itemsPerPage = get_option('wpsqt_number_of_items');
		$questions = $wpdb->get_results(
							$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_QUESTIONS."` WHERE item_id = %d",array($_GET['id']) ),ARRAY_A
						);
		$questions = apply_filters("wpsqt_list_questions",$questions);
		$currentPage = Wpsqt_Core::getCurrentPageNumber();
		$startNumber = ( ($currentPage - 1) * $itemsPerPage );			
		$pageQuestions = array_slice($questions , $startNumber , $itemsPerPage );
		
		$this->_pageVars['questions'] = $pageQuestions;
		$this->_pageVars['currentPage'] = $currentPage;
		$this->_pageVars['numberOfPages'] = Wpsqt_Core::getPaginationCount(sizeof($questions),$itemsPerPage);
		$this->_pageVars['question_counts'] = $wpdb->get_row($sql,ARRAY_A);
		$this->_pageVars['question_types'] = $questionTypes;
		
		$this->_pageView = "admin/questions/index.php";
		
	}	
}	