<?php

	/**
	 * Handles the upgrading of the plugin.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Maintenance_Upgrade extends Wpsqt_Page {

	public function process(){	
	
		global $wpdb;
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
			
			print "<h3>UPDATING</h3>".PHP_EOL;
			$oldVersion = get_option("wpsqt_old_version");
			$currentVersion = get_option("wpsqt_version");
			$needUpdate = get_option("wpsqt_update_required");
			if ($needUpdate == '1') {
				switch($oldVersion) {
					case '2.4.3':
					echo '<h4>Updating to 2.5</h4>';
					$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `pass` BOOLEAN NOT NULL");
					echo '<p>Added the `pass` column</p>';
					case '2.5':
					echo '<h4>Updating to 2.5.1</h4>';
					$wpdb->query("ALTER TABLE `".WPSQT_TABLE_QUIZ_SURVEYS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
					$wpdb->query("ALTER TABLE `".WPSQT_TABLE_SECTIONS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
					$wpdb->query("ALTER TABLE `".WPSQT_TABLE_QUESTIONS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
					$wpdb->query("ALTER TABLE `".WPSQT_TABLE_FORMS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
					$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
					$wpdb->query("ALTER TABLE `".WPSQT_TABLE_SURVEY_CACHE."` DEFAULT  CHARACTER SET utf8 COLLATE utf8_general_ci");
					$wpdb->query("ALTER TABLE  `".WPSQT_TABLE_QUIZ_SURVEYS."` CHANGE  `name`  `name` VARCHAR( 512 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
					case '2.5.1':
					echo '<h4>Updating to 2.5.2</h4>';
					$wpdb->query("ALTER TABLE `".WPSQT_TABLE_RESULTS."` ADD `datetaken` VARCHAR(255) NOT NULL AFTER `item_id`");
					echo '<p><strong>Updated. Return to the <a href="'.WPSQT_URL_MAIN.'">main page</a> to ensure the notice disappears</strong></p>';
					break;
				}
			} else {
				echo '<p>You are up to date.</p>';
			}
			update_option("wpsqt_update_required",false);
			exit;
			
		} 

		$this->_pageView = "admin/maintenance/upgrade.php";
			
	}
}