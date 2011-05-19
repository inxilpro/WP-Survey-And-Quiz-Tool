<?php
require_once WPSQT_DIR.'lib/Wpsqt/Tokens.php';

	/**
	 * Handles editing the global options for the plugin.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Page_Options extends Wpsqt_Page {
	
	public function process(){
		
		if ( $_SERVER['REQUEST_METHOD'] == "POST" ){
			
			update_option("wpsqt_number_of_items",$_POST['wpsqt_items']);
			update_option("wpsqt_email_role",$_POST['wpsqt_email_role']);
			update_option("wpsqt_email_template",$_POST['wpsqt_email_template']);
			update_option("wpsqt_support_us",$_POST['wpsqt_support_us']);
			update_option("wpsqt_email_from",$_POST['wpsqt_from_email']);
			update_option("wpsqt_contact_email",$_POST['wpsqt_email']);
			update_option("wpsqt_docraptor_api",$_POST['wpsqt_docraptor_api']);
			update_option("wpsqt_pdf_template",$_POST['wpsqt_pdf_template']);
			
		}	
		
		$this->_pageVars['objTokens'] = Wpsqt_Tokens::getTokenObject();
		$this->_pageVars['numberOfItems'] = get_option("wpsqt_number_of_items");
		$this->_pageVars['emailRole'] = get_option("wpsqt_email_role");
		$this->_pageVars['emailTemplate'] = get_option("wpsqt_email_template");
		$this->_pageVars['supportUs'] = get_option("wpsqt_support_us");
		$this->_pageVars['fromEmail'] = get_option("wpsqt_email_from");
		$this->_pageVars['email'] = get_option("wpsqt_contact_email");
		$this->_pageVars['docraptorApi'] = get_option("wpsqt_docraptor_api");
		$this->_pageVars['pdfTemplate'] = get_option("wpsqt_pdf_template");
		$this->_pageView = "admin/misc/options.php";
		
	}
	
}