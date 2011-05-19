<?php
require_once WPSQT_DIR.'lib/Wpsqt/Form.php';

	/**
	 * The create and edit form for surveys.
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011, all rights reserved.
  	 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
  	 * @package WPSQT
	 */

class Wpsqt_Form_Survey extends Wpsqt_Form {
	
	public function __construct( array $options = array() ){
		
		if ( empty($options) ){
			$options = array('name' => false,
							'notificaton_type' => false, 
							'status' => false, 
							'contact' => false,
							'use_wp' => false, 
							'notification_email' => false,
							'email_template' => false);
		}
		
		$this->addOption("wpsqt_name", "Name", "text", $options['name'], "The name of the survey" )
			 ->addOption("wpsqt_status", "Status", "select", $options['status'], "If the survey is enabled or disabled.", array("enabled","disabled"))
			 ->addOption("wpsqt_contact", "Take contact details", "yesno", $options['contact'] ,"This will show a form for users to enter their contact details before proceeding")
			 ->addOption("wpsqt_notificaton_type", "Complete Notification", "select", $options['notificaton_type'] , "Send a notification email of completion.",array('none','instant') )
			 ->addOption("wpsqt_use_wp", "Use WordPress user details", "yesno", $options['use_wp'], "This will allow you to have the Quiz to use the user details for signed in users of your blog. If enabled the contact form will not be shown if enabled.")
			 ->addOption("wpsqt_email_template", "Custom Email Template", "textarea", $options['email_template'], "The template of the email sent on notification. <strong>If empty the default one will be sent.</strong> <a href=\"#template_tokens\">Click Here</a> to see the tokens that can be used.", array(), false)
			 ->addOption("wpsqt_notification_email", "Notification Email", "text", $options['notification_email'], "The email address which is to be notified when the quiz is completed. Emails can be seperated by a comma. <strong>Will override plugin wide option.</strong>", false ) ;
		
		
		apply_filters("wpsqt_form_survey",$this);
	}
	
}