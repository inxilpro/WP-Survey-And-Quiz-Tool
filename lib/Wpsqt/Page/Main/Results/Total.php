<?php

	/**
	 * Handles displaying the MySQL cached results.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Main_Results_Total extends Wpsqt_Page {
	
	public function process(){
		
		global $wpdb;
		
		$result = $wpdb->get_row(
					$wpdb->prepare("SELECT * FROM `".WPSQT_TABLE_SURVEY_CACHE."` WHERE item_id = %d",
								   array($_GET['id'])), ARRAY_A
								);
		$this->_pageVars['sections'] = unserialize($result['sections']);
		$this->_pageView = "admin/surveys/result.total.php";
		
	}	
	
}	