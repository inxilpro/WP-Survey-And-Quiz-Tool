<?php

/*
Plugin Name: WP Survey And Quiz Tool
Plugin URI: http://catn.com/2010/10/04/wp-survey-and-quiz-tool/
Description: A plugin to allow wordpress owners to create their own web based quizes.
Author: Fubra Limited
Author URI: http://www.catn.com
Version: 1.3.30
*/

/*
 * Copyright (C) 2010  Fubra Limited
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 */

// Global actions
global $wpdb;

// Define constants
define( 'WPSQT_QUIZ_TABLE'             , $wpdb->prefix.'wpsqt_quiz' );
define( 'WPSQT_SECTION_TABLE'          , $wpdb->prefix.'wpsqt_quiz_sections' );
define( 'WPSQT_QUESTION_TABLE'         , $wpdb->prefix.'wpsqt_questions' );
define( 'WPSQT_ANSWER_TABLE'           , $wpdb->prefix.'wpsqt_answer' );
define( 'WPSQT_FORM_TABLE'             , $wpdb->prefix.'wpsqt_forms' );
define( 'WPSQT_RESULTS_TABLE'          , $wpdb->prefix.'wpsqt_results' );
define( 'WPSQT_SURVEY_TABLE'           , $wpdb->prefix.'wpsqt_survey' );
define( 'WPSQT_SURVEY_SECTION_TABLE'   , $wpdb->prefix.'wpsqt_survey_sections' );
define( 'WPSQT_SURVEY_QUESTIONS_TABLE' , $wpdb->prefix.'wpsqt_survey_questions' );
define( 'WPSQT_SURVEY_ANSWERS_TABLE'   , $wpdb->prefix.'wpsqt_survey_questions_answers' );
define( 'WPSQT_SURVEY_RESULT_TABLE'    , $wpdb->prefix.'wpsqt_survey_results' );
define( 'WPSQT_SURVEY_SINGLE_TABLE'    , $wpdb->prefix.'wpsqt_survey_single_results');
// Page variable names.
// define as constants to allow for easy change of them.
define( 'WPSQT_PAGE_MAIN'            , 'wpsqt-menu' );
define( 'WPSQT_PAGE_QUIZ'            , 'wpsqt-menu-quiz' );
define( 'WPSQT_PAGE_QUESTIONS'       , 'wpsqt-menu-question' );
define( 'WPSQT_PAGE_QUIZ_RESULTS'    , 'wpsqt-menu-quiz-results' );
define( 'WPSQT_PAGE_OPTIONS'         , 'wpsqt-menu-options' ) ;
define( 'WPSQT_PAGE_CONTACT'         , 'wpsqt-menu-contact' );
define( 'WPSQT_PAGE_HELP'            , 'wpsqt-menu-help'    );
define( 'WPSQT_PAGE_SURVEY'          , 'wpsqt-menu-survey'  );
define( 'WPSQT_PAGE_CATN'            , 'wpsqt-catn' );
define( 'WPSQT_URL_MAIN'             , get_bloginfo('url').'/wp-admin/admin.php?page='.WPSQT_PAGE_MAIN );

define( 'WPSQT_CONTACT_EMAIL'        , 'support@catn.com' );
define( 'WPSQT_VERSION'              , '1.3.30' );
define( 'WPSQT_DIR'                  , dirname(__FILE__) );

// start a session
if ( !session_id() )
	session_start();


// To anyone reading this, sorry for the terrible, terrible design.	
register_activation_hook(__FILE__, 'wpsqt_main_install'); 
/**
 * Installation function creates all the
 * tables required for the plugin. 
 * 
 * @uses wpdb
 */	
function wpsqt_main_install(){    
if ( !session_id() )
	session_start();
	
   
	global $wpdb;
	
	$oldVersion = get_option('wpsqt_version');
	
	update_option('wpsqt_version',WPSQT_VERSION);
	if ( !get_option('wpsqt_number_of_items') ){
		update_option('wpsqt_number_of_items',5);
	}
	// Simple way of checking if an it's an update or not.
	if ( !empty($oldVersion) && $oldVersion != WPSQT_VERSION ){
		wpsqt_main_db_upgrade($oldVersion);
	}
	
	// Results table
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_RESULTS_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `timetaken` int(11) NOT NULL,
				  `person` text,
				  `sections` LONGTEXT NOT NULL,
				  `status` varchar(255) NOT NULL DEFAULT 'Unviewed',
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  `quizid` int(11) NOT NULL,
				  `person_name` varchar(255) NOT NULL,
				  `ipaddress` varchar(255) NOT NULL,
				  `mark` int(11) NOT NULL DEFAULT '0',
				  `total` int(11) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SECTION_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `quizid` int(11) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `number` int(11) NOT NULL,
				  `difficulty` varchar(11) NOT NULL,
				  `orderby` varchar(255) NOT NULL DEFAULT 'random',
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_QUIZ_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `display_result` varchar(255) NOT NULL DEFAULT 'no',
				  `type` varchar(255) NOT NULL DEFAULT 'quiz',
				  `status` varchar(255) NOT NULL DEFAULT 'disabled',
				  `notification_type` varchar(255) NOT NULL DEFAULT 'none',
				  `take_details` varchar(3) NOT NULL DEFAULT 'no',
 				  `use_wp_user` varchar(3) NOT NULL DEFAULT 'no',
 				  `display_review` VARCHAR( 3 ) NOT NULL DEFAULT 'no',
 				  `email_template` TEXT NULL DEFAULT NULL ,
 				  `email_wp_user` VARCHAR( 3 ) NOT NULL 
DEFAULT 'no',
 				  `limit_one` VARCHAR( 3 ) NOT NULL DEFAULT 'no',				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_QUESTION_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `type` varchar(30) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  `additional` LONGTEXT NOT NULL,
				  `value` int(11) NOT NULL DEFAULT '1',
				  `quizid` int(11) NOT NULL,
				  `hint` text NOT NULL,
				  `difficulty` varchar(255) NOT NULL,
				  `section_type` varchar(255) NOT NULL DEFAULT 'multiple',
				  `sectionid` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_ANSWER_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `questionid` int(11) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  `correct` varchar(3) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `questionid` (`questionid`)
				  ) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `take_details` varchar(11) NOT NULL,
				  `status` varchar(11) NOT NULL,
				  `email_template` TEXT NULL DEFAULT NULL,
				  `send_email` VARCHAR( 3 ) NOT NULL DEFAULT 'no',
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_QUESTIONS_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `surveyid` int(11) NOT NULL,
				  `sectionid` int(11) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  `type` varchar(10) NOT NULL,
				  `include_other` VARCHAR( 3 ) NOT NULL DEFAULT 'no',
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_ANSWERS_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `questionid` int(11) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_RESULT_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `surveyid` int(11) NOT NULL,
				  `questionid` int(11) NOT NULL,
				  `answerid` int(11) DEFAULT NULL,
				  `other` text NOT NULL,
				  `type` varchar(10) DEFAULT 'multiple',
				  `value` int(11) DEFAULT NULL,
				  PRIMARY KEY (`id`),
				  UNIQUE KEY `id` (`id`)
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_SECTION_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `surveyid` int(11) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(10) NOT NULL,
				  `number` int(11) NOT NULL,
				  `orderby` varchar(255) NOT NULL DEFAULT 'random',
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_SINGLE_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `surveyid` int(11) NOT NULL,
				  `person` text NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `results` text NOT NULL,
				  `ipaddress` varchar(255) NOT NULL,
				  `user_agent` varchar(255) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_FORM_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `required` varchar(255) NOT NULL,
				  `quizid` int(11) NOT NULL,
				  `surveyid` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci");
	
}


/**
 * Adds a custom menus to the admin page.
 * Layout
 *   Quizzes/Survey
 *  	-> Options
 *  	-> Contact
 *  	-> Help
 *  	-> CatN PHP Experts
 */

function wpsqt_main_admin_menu(){
	
	wp_enqueue_script('jquery');
	add_menu_page( 'Quizzes/Surveys', 'Quizzes/Surveys', 'manage_options', WPSQT_PAGE_MAIN , 'wpsqt_main_admin_main_page') ;
	add_submenu_page( WPSQT_PAGE_MAIN , 'Options', 'Options', 'manage_options', WPSQT_PAGE_OPTIONS, 'wpsqt_main_admin_options_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'Contact' , 'Contact' , 'manage_options' , WPSQT_PAGE_CONTACT , 'wpsqt_main_admin_contact_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'Help' , 'Help' , 'manage_options' , WPSQT_PAGE_HELP, 'wpsqt_main_admin_help_page' );
	add_submenu_page( WPSQT_PAGE_MAIN , 'CatN PHP Experts' , 'CatN' , 'manage_options' , WPSQT_PAGE_CATN, 'wpsqt_main_catn' );
	
}

/**
 * Main page for when people click on the WP Survey And Quiz Tool.
 * Simply selects the lastest quiz results and the lastest quizes.
 * 
 * @uses wpdb
 */
function wpsqt_main_admin_main_page(){
	
	global $wpdb;
	
	$type = (!isset($_GET['type'])) ? 'all' : $_GET['type'];
	$action = (!isset($_GET['action'])) ? 'list' : $_GET['action'];
	
	// Show main page.
	if ( $action == 'list' ){
		require_once WPSQT_DIR.'/includes/admin/list.php';
		wpsqt_list_admin_main($type);
		return;
	} elseif ( $action == 'form' ){
		// To avoid including redunant code, tiny optimization.
		require_once WPSQT_DIR.'/includes/admin/shared.php';		
		wpsqt_admin_shared_forms();		
		return;
	}
	
	// Show quiz page 
	if ( $type == 'quiz' ){	
	
		// Nasty hack to implement DRY and require uneeded files.
		if ( $action == 'results' ){
			
			require_once WPSQT_DIR.'/includes/admin/results.php';

			if ( !isset($_GET['subaction']) ){					
				wpsqt_admin_results_show_list();
			} elseif ( $_GET['subaction'] == 'mark' ){
				wpsqt_admin_results_quiz_mark();
			} elseif ( $_GET['subaction'] == 'delete' ){
				wpsqt_admin_results_delete_result();
			} 
				
			
			return;
		}	
		
		require_once WPSQT_DIR.'/includes/admin/quiz.php';		
		if ($action == 'edit'){
			wpsqt_admin_quiz_form(true);
		} elseif ( $action == 'sections' ){
			wpsqt_admin_quiz_sections();
		} elseif ( $action == 'addnew' ){
			wpsqt_admin_quiz_form();
		}  elseif ( $action == 'delete' ){
			wpsqt_admin_quiz_delete();
		} elseif ( $action == 'questions' ){
			wpsqt_admin_questions_show_list();
		} elseif ( $action == 'question-edit' ){
			wpsqt_admin_questions_edit();
		} elseif ( $action == 'question-add' ){
			wpsqt_admin_questions_addnew();
		} elseif ( $action == 'question-delete' ){
			wpsqt_admin_questions_delete();
		} 		
		
	} elseif ( $type == 'survey' ){ 
		
		require_once WPSQT_DIR.'/includes/admin/survey.php';	
		
		if ( $action == 'delete' ) {
			wpsqt_admin_survey_delete();
		} elseif ( $action == 'sections' ) {			
			wpsqt_admin_survey_sections();
		} elseif ( $action == 'addnew' ) {			
			wpsqt_admin_survey_create();
		} elseif ( $action == 'questions'){
			wpsqt_admin_survey_question_list();
		} elseif ( $action == 'edit' ){
			wpsqt_admin_survey_create(true);
		} elseif ( $action == 'results' ){
			if ( !isset($_GET['subaction']) ){					
				wpsqt_admin_survey_result_list();
			} elseif ( $_GET['subaction'] == 'view' ){
				wpsqt_admin_survey_result_single();
			} 
		} elseif ( $action == 'totalresults'){
			wpsqt_admin_survey_result_total();
		} elseif ( $action == 'view-single' ){
			wpsqt_admin_survey_result_single();
		} elseif ( $_REQUEST['action'] == 'question-create' ){
			wpsqt_admin_survey_question_create();
		} elseif ( $_REQUEST['action'] == 'question-delete' ){
			wpsqt_admin_survey_question_delete();
		} elseif ( $_REQUEST['action'] == 'question-edit' ){
			wpsqt_admin_survey_question_create(true);
		} 
		
	}	
	
	return;
}

/**
 * Shows the option page which allows the
 * user to edit and save options which 
 * apply to the plugin.
 * 
 * @uses includes/admin/misc.php
 */
function wpsqt_main_admin_options_page(){	
	require_once WPSQT_DIR.'/includes/admin/misc.php';
	
	wpsqt_admin_options_main();
}

/**
 * Shows the contact page which allows 
 * the users to send emails the me. Hopefully
 * should increase bug reports.
 * 
 * @uses includes/admin/misc.php
 */
function wpsqt_main_admin_contact_page(){	
	require_once WPSQT_DIR.'/includes/admin/misc.php';
	
	wpsqt_admin_misc_contact_main();
}

add_action('admin_menu', 'wpsqt_main_admin_menu');



/**
 * Handles the displaying of quizes on pages.
 * All the hardwork is handled else where.
 * 
 * @uses pages/general/error.php
 * @uses includes/site/quiz.php
 */
function wpsqt_main_site_quiz_page($atts) {
		
	extract( shortcode_atts( array(
					'name' => false
	), $atts) );
	
	if ( !$name ){
		require_once WPSQT_DIR.'/pages/general/error.php';
	}
	
	require_once WPSQT_DIR.'/includes/site/quiz.php';
	ob_start();
	wpsqt_site_quiz_show($name);
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode( 'wpsqt_page' , 'wpsqt_main_site_quiz_page' );// Deprecated and will be removed
add_shortcode( 'wpsqt_quiz' , 'wpsqt_main_site_quiz_page' );

/**
 * Handles the displaying of quizes on pages.
 * All the hardwork is handled else where.
 * 
 * @uses pages/general/error.php
 * @uses includes/site/quiz.php
 */
function wpsqt_main_site_survey_page($atts) {
		
	extract( shortcode_atts( array(
					'name' => false
	), $atts) );
	
	if ( !$name ){
		require_once WPSQT_DIR.'/pages/general/error.php';
	}
	
	require_once WPSQT_DIR.'/includes/site/survey.php';
	ob_start();
	wpsqt_site_survey_show($name);
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}

add_shortcode( 'wpsqt_survey' , 'wpsqt_main_site_survey_page' );

/**
 * Does a SQL query to select results from the last 24 hours.
 * 
 * @uses includes/functions.php
 */
function wpsqt_daily_mail() {
	
	global $wpdb;
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$results = $wpdb->get_result('SELECT * 
								  FROM `'.WPSQT_RESULTS_TABLE.'` 
								  WHERE timestamp >= TIMESTAMPADD(DAY,-1,NOW())',ARRAY_A);
	
	wpsqt_functions_send_mail($results);
	
}
add_action( 'daily_mail' , 'wpsqt_daily_mail' );

/**
 * Does a SQL query to select from the last hour.
 * 
 * @uses includes/functions.php
 */
function wpsqt_hourly_mail() {
	
	global $wpdb;
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$results = $wpdb->get_result(  'SELECT * 
									FROM `'.WPSQT_RESULTS_TABLE.'` 
									WHERE timestamp >= TIMESTAMPADD(HOUR,-1,NOW())',ARRAY_A);
	
	wpsqt_functions_send_mail($results);
}

add_action('hourly_mail', 'wpsqt_hourly_mail');


/**
 * Displays help nothing else nothing more.
 * 
 * @uses pages/admin/misc/help.php
 */
function wpsqt_main_admin_help_page(){
	
	require_once WPSQT_DIR.'/pages/admin/misc/help.php';
	
}

/**
 * Fall back function to check if the plugin 
 * was activated properly.
 * 
 * @uses wpdb
 * 
 * @since 1.0.2
 */
function wpsqt_check_tables($oldVersion){
	
	global $wpdb;
	
	if ( !$wpdb->get_var("SHOW TABLES LIKE '".WPSQT_RESULTS_TABLE."'") 
	  || !$wpdb->get_var("SHOW TABLES LIKE '".WPSQT_SURVEY_TABLE."'")
	  || !$wpdb->get_var("SHOW TABLES LIKE '".WPSQT_FORM_TABLE."'") ){
		wpsqt_main_install();
		return;
	}
	
	$oldVersion = get_option('wpsqt_version');
	
	// Simple way of checking if an it's an update or not.
	if ( !empty($oldVersion) && $oldVersion != WPSQT_VERSION ){
		wpsqt_main_db_upgrade($oldVersion);
	}
	
}

add_action('plugins_loaded','wpsqt_check_tables');

/**
 * Allows users to use custom page views to change layouts and user interaction.
 * 
 * @param $file
 *  
 * @uses wpdb
 * 
 * @since 1.1.1
 */

function wpsqt_page_display($file){
	
	global $blog_id;
	
	
	$quizPath = ( isset($_SESSION['wpsqt']['current_id'])
				 && ctype_digit($_SESSION['wpsqt']['current_id']) ) ?
				  $blog_id.'/'.$_SESSION['wpsqt']['current_type'].'-'.$_SESSION['wpsqt']['current_id'].'/' : '';
			
	if ( file_exists(WPSQT_DIR.'/pages/custom/'.$quizPath.$file) ){
		return WPSQT_DIR.'/pages/custom/'.$quizPath.$file;
	}
	return WPSQT_DIR.'/pages/'.$file;
	
}

/**
 * Adds the print.css to the admin section.
 * 
 * @since 1.1.4
 */

function wpsqt_admin_css() {
	$siteurl = get_option('siteurl');
	$url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/print.css';
	echo "<link rel='stylesheet' type='text/css' media='print' href='$url' />\n";
}
add_action('admin_head', 'wpsqt_admin_css');

/**
 * Exports results to CSV 
 * 
 * @uses wpdb
 * 
 * @since 1.2.0
 */

function wpsqt_csv_export(){
	
	global $wpdb;
	
	
	if ( !isset($_GET['quiz_csv']) && !isset($_GET['survey_csv']) ){
		return;
	}
	
	if ( isset($_GET['quiz_csv']) ){
		$quizId = (int)$_GET['id'];	
		$results = $wpdb->get_results( 'SELECT * FROM '.WPSQT_RESULTS_TABLE.' WHERE quizid = '.$quizId , ARRAY_A );
	} else {
		$surveyId = (int)$_GET['id'];
		$results = $wpdb->get_results( 'SELECT * FROM '.WPSQT_SURVEY_RESULT_TABLE.' WHERE surveyid = '.$surveyId, ARRAY_A );	
	}
	
	$csvFile = tmpfile();
	foreach ( $results as $result ){
		
		if ($_GET['people'] == 'yes'){
			// If just contact details
			$people = unserialize($result['person']);
			if (!empty($people)){
				fputcsv($csvFile, $people);
			}
			
		} else {
			fputcsv($csvFile,$result);				
		}	
	}
	fseek($csvFile ,0);
	// Print out the data
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=file.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	print stream_get_contents($csvFile);
	
	exit; // Because we don't want the rest to load.
	
}
add_action('init', 'wpsqt_csv_export');

/**
 * Function to comply with DRY for 
 * upgrading the mysql tables.
 * 
 * @uses wpdb
 * 
 * @since 1.2.1
 */

function wpsqt_main_db_upgrade($oldVersion){
	
	global $wpdb;

	if ( $oldVersion <= "1.3" ){
		$wpdb->query("ALTER TABLE `".WPSQT_QUIZ_TABLE."` ADD `use_wp_user` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
		$wpdb->query("ALTER TABLE `".WPSQT_SECTION_TABLE."` ADD `orderby` VARCHAR( 255 ) NOT NULL DEFAULT 'random'");
		$wpdb->query("ALTER TABLE `".WPSQT_SURVEY_SECTION_TABLE."` ADD `orderby` VARCHAR( 255 ) NOT NULL DEFAULT 'random'");
		$wpdb->query("ALTER TABLE `".WPSQT_QUIZ_TABLE."` DROP `type` ");
		// 1.3	
		$wpdb->query("ALTER TABLE `".WPSQT_SURVEY_TABLE."` ADD `send_email` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
		$wpdb->query("ALTER TABLE `".WPSQT_QUIZ_TABLE."` ADD `email_template` TEXT NULL DEFAULT NULL ");
		$wpdb->query("ALTER TABLE `".WPSQT_SURVEY_TABLE."` ADD `email_template` TEXT NULL DEFAULT NULL ");
	}
	
	if ( $oldVersion <= "1.3.1" ){
		// 1.3.1
		$wpdb->query("ALTER TABLE `".WPSQT_SURVEY_QUESTIONS_TABLE."` ADD `include_other` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
	}
	
	if ( $oldVersion <= "1.3.2" ){
		// 1.3.2
		$wpdb->query("ALTER TABLE `".WPSQT_QUIZ_TABLE."` ADD `display_review` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
	}
	
	if ( $oldVersion <= "1.3.16" ){
		// 1.3.16
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SURVEY_SINGLE_TABLE."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `surveyid` int(11) NOT NULL,
					  `person` text NOT NULL,
					  `name` varchar(255) NOT NULL,
					  `results` text NOT NULL,
					  `ipaddress` varchar(255) NOT NULL,
					  `user_agent` varchar(255) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1;");
	}
	
	if ( $oldVersion <= "1.3.21" ){
		// 1.3.21
		
		foreach (array(  WPSQT_QUIZ_TABLE,WPSQT_SECTION_TABLE,WPSQT_QUESTION_TABLE,
						 WPSQT_ANSWER_TABLE,WPSQT_FORM_TABLE,WPSQT_RESULTS_TABLE,
						 WPSQT_SURVEY_TABLE,WPSQT_SURVEY_SECTION_TABLE,
						 WPSQT_SURVEY_QUESTIONS_TABLE,WPSQT_SURVEY_ANSWERS_TABLE,
						 WPSQT_SURVEY_RESULT_TABLE,WPSQT_SURVEY_SINGLE_TABLE ) as $tableName){
			
			$wpdb->query("ALTER TABLE  `".$tableName."` CHARACTER SET utf8 COLLATE utf8_general_ci");
		}
		
		$wpdb->query("ALTER TABLE  `".WPSQT_QUESTION_TABLE."` 
					  CHANGE  `hint`  `hint` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `difficulty`  `difficulty` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `type`  `type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `text`  `text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `section_type`  `section_type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'multiple'");
		$wpdb->query("ALTER TABLE  `".WPSQT_ANSWER_TABLE."` 
					  CHANGE  `text`  `text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `correct`  `correct` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		$wpdb->query("ALTER TABLE  `".WPSQT_FORM_TABLE."` 
					  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `type`  `type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `required`  `required` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");	
		$wpdb->query("ALTER TABLE  `".WPSQT_QUIZ_TABLE."` CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `display_result`  `display_result` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no',
					  CHANGE  `status`  `status` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'disabled',
					  CHANGE  `notification_type`  `notification_type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'none',
					  CHANGE  `take_details`  `take_details` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no',
					  CHANGE  `use_wp_user`  `use_wp_user` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no',
					  CHANGE  `email_template`  `email_template` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
					  CHANGE  `display_review`  `display_review` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no'");
		$wpdb->query("ALTER TABLE  `".WPSQT_SECTION_TABLE."` 
					  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `type`  `type` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `difficulty`  `difficulty` VARCHAR( 11 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `orderby`  `orderby` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'random'");
		$wpdb->query("ALTER TABLE  `".WPSQT_SECTION_TABLE."` 
					  CHANGE  `person`  `person` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
					  CHANGE  `sections`  `sections` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `status`  `status` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'Unviewed',
					  CHANGE  `person_name`  `person_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `ipaddress`  `ipaddress` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		$wpdb->query("ALTER TABLE  `".WPSQT_SURVEY_TABLE."` 
					  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `take_details`  `take_details` VARCHAR( 11 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `status`  `status` VARCHAR( 11 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `send_email`  `send_email` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no',
					  CHANGE  `email_template`  `email_template` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
		$wpdb->query("ALTER TABLE  `".WPSQT_SURVEY_QUESTIONS_TABLE."` CHANGE  `text`  `text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `type`  `type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `include_other`  `include_other` VARCHAR( 3 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'no'");
		$wpdb->query("ALTER TABLE  `".WPSQT_SURVEY_ANSWERS_TABLE."` 
					  CHANGE  `text`  `text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		$wpdb->query("ALTER TABLE  `".WPSQT_SURVEY_RESULT_TABLE."` 
					  CHANGE  `other`  `other` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `type`  `type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT  'multiple'");
		$wpdb->query("ALTER TABLE  `".WPSQT_SURVEY_SECTION_TABLE."` 
					  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `type`  `type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `orderby`  `orderby` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		$wpdb->query("ALTER TABLE  `".WPSQT_SURVEY_SINGLE_TABLE."` 
					  CHANGE  `person`  `person` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `name`  `name` VARCHAR( 255 ) CHARACTER SET ucs2 COLLATE ucs2_general_ci NOT NULL ,
					  CHANGE  `results`  `results` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `ipaddress`  `ipaddress` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
					  CHANGE  `user_agent`  `user_agent` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
	}
	
	if ( $oldVersion <= "1.3.22" ){
		// 1.3.22
		$wpdb->query("ALTER TABLE `".WPSQT_RESULTS_TABLE."` CHANGE `sections` `sections` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
	}
	
	if ( $oldVersion <= "1.3.23" ){
		// 1.3.23
		$wpdb->query("ALTER TABLE `".WPSQT_QUIZ_TABLE."` ADD `email_wp_user` VARCHAR( 3 ) NOT NULL DEFAULT 'no'");
	}

	if ( $oldVersion <= "1.3.24" ){
		$wpdb->query("ALTER TABLE `".WPSQT_QUIZ_TABLE."` CHANGE  `additional` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");		  
	}
	
	if ( $oldVersion <= "1.3.27" ){
		$wpdb->query("ALTER TABLE  `".WPSQT_QUIZ_TABLE."` ADD  `limit_one` VARCHAR( 255 ) NULL DEFAULT NULL");		  
	}
	
	
	
	return;
}

/**
 * Shows them a CatN advertisement page.
 * 
 * @since 1.3.0
 */

function wpsqt_main_catn(){
	
	require_once WPSQT_DIR.'/pages/admin/misc/catn.php';
}

/**
 * Checks to see if the system requirments are met. If not text
 * it displays a error div in the admin section linking 
 * them to the CatN advertisement. 
 * 
 * @since 1.3.0
 */

function wpsqt_main_requirements(){
	
	global $systemRequirments;
	$systemRequirements = true;

	if ( !extension_loaded('session') ){
		$systemRequirements = false;
	} elseif ( !session_id() ){
		// May be redunant as this code runs at the top of the script.		
		if ( !session_start() ){
			$systemRequirements = false;
		}
	} elseif ( !extension_loaded('pcre') ){
		$systemRequirements = false;
	} elseif ( !preg_match('~^5.~',PHP_VERSION) ){
		$systemRequirements = false;
	} elseif ( $systemRequirements == false ){
		echo '<div class="error">Your hosting doesn\'t meet the mimium requirements of this plugin. <a href="'. get_bloginfo('url').'/wp-admin/admin.php?page='.WPSQT_PAGE_CATN.'">Click here</a> to find out about high quality hosting.</div>';		
	}
		
}

add_action('admin_head', 'wpsqt_main_requirements');
/**
 * Adds the link if the user has agreed to it!
 * 
 * @since 1.3.0
 */

function wpsqt_main_support(){
	
	echo '<!--- WP Survey And Quiz Tool '.WPSQT_VERSION.' Developed by iain.cambridge at fubra.com --->';
	
	$supportUs = get_option('wpsqt_support_us');
	
	if ( $supportUs == 'yes'){
		echo '<p style="text-align: center;"><a href="http://catn.com/">Get Cloud PHP Hosting on CatN</a></p>';
	}
	
}

add_action('wp_footer', 'wpsqt_main_support');

/**
 * Creates a nonce field and checks nonce to ensure 
 * againist cross site request forgies.
 * 
 * @since 1.3.22
 */

function wpsqt_nonce(){
	
	if ( isset($_REQUEST["wpsqt_nonce"]) ){
		$validNonce = wp_verify_nonce($_REQUEST["wpsqt_nonce"],'wpsqt_nonce');
	} else {
		$validNonce = false;
	}
	
	define( "WPSQT_NONCE_VALID" , $validNonce );
	define( "WPSQT_NONCE_CURRENT" , wp_create_nonce('wpsqt_nonce') ); // using a different 
}

/**
 * Done here as not every page request will be requiring a nonce.
 * 
 * @since 1.3.22
 */
function wpsqt_nonce_check(){
	
	if ( WPSQT_NONCE_VALID != true ){
		wp_die("Invalid WP Survey And Quiz Tool referrer response");
	}
	
}

add_action("init","wpsqt_nonce");
