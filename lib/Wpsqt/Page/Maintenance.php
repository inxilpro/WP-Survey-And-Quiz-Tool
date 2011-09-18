<?php

	/**
	 * Handles complete uninstalling of the plugin. Also handles 
	 * upgrades and imports/exports.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Maintenance extends Wpsqt_Page {

	public function process(){
		$ch = curl_init("http://wordpress.org/extend/plugins/wp-survey-and-quiz-tool/");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$html = curl_exec($ch);
		preg_match_all('$download\sversion\s((\d|\.)*)$i', $html, $version);
		$this->_pageVars['version'] = $version[1][0];
		curl_close($ch);
		
		if(get_option('wpsqt_update_required') == '1') {
			$update = true;
			$this->_pageVars['update'] = true;
		}
		$this->_pageView = "admin/maintenance/index.php";
			
	}

}