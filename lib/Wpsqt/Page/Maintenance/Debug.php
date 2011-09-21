<?php

	/**
	 * Handles the complete uninstalling of the plugin.
	 * 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Maintenance_Debug extends Wpsqt_Page {
	
		
	public function process(){	
	
		global $wpdb;
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ) {
			
			print "<h3>Running all upgrades</h3>".PHP_EOL;
			require_once WPSQT_DIR.'lib/Wpsqt/Upgrade.php';
			$objUpgrade = new Wpsqt_Upgrade;
			$objUpgrade->getUpdate(0);
			$objUpgrade->execute();
			echo '<p>You are up to date.</p>';
			exit;
			
		} 

		
		$this->_pageView = "admin/maintenance/debug.php";
	}
		
}