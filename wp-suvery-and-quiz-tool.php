<?php

/*
Plugin Name: WP Survey And Quiz Tool
Plugin URI: 
Description: A plugin to allow wordpress owners to create their own web based quizes.
Author: Fubra Limited
Author URI: http://www.catn.com
Version: 1.0.1
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
define('WPSQT_DIR'                 , dirname(__FILE__) );
define('WPSQT_QUIZ_TABLE'          , $wpdb->prefix.'wpsqt_quiz' );
define('WPSQT_SECTION_TABLE'       , $wpdb->prefix.'wpsqt_quiz_sections' );
define('WPSQT_QUESTION_TABLE'      , $wpdb->prefix.'wpsqt_questions' );
define('WPSQT_ANSWER_TABLE'        , $wpdb->prefix.'wpsqt_answer' );
define('WPSQT_RESULTS_TABLE'       , $wpdb->prefix.'wpsqt_results' );

// Page variable names.
// define as constants to allow for easy change of them.
define( 'WPSQT_PAGE_MAIN'          , 'wpsqt-menu' );
define( 'WPSQT_PAGE_QUIZ'          , 'wpsqt-menu-quiz' );
define( 'WPSQT_PAGE_QUESTIONS'     , 'wpsqt-menu-question' );
define( 'WPSQT_PAGE_QUIZ_RESULTS'  , 'wpsqt-menu-quiz-results' );
define( 'WPSQT_PAGE_OPTIONS'       , 'wpsqt-menu-options' ) ;
define( 'WPSQT_PAGE_CONTACT'       , 'wpsqt-menu-contact' );
define( 'WPSQT_PAGE_HELP'          , 'wpsqt-menu-help' );

define( 'WPSQT_CONTACT_EMAIL'      , 'iain.cambridge@fubra.com' );
define( 'WPSQT_FROM_EMAIL'         , 'wpst-no-reply@fubra.com' );

// start a session
if (!session_id())
	session_start();

	
/**
 * Installation function creates all the
 * tables required for the plugin. 
 * 
 * @uses wpdb
 */	
function wpsqt_install(){    
    
	global $wpdb;
	
	set_option('wpsqt_version','1.0.1');
	if ( !get_option('wpsqt_number_of_items') ){
		set_option('wpsqt_number_of_items',5);
	}
	// Results table
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_RESULTS_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `timetaken` int(11) NOT NULL,
				  `person` text,
				  `sections` text NOT NULL,
				  `status` varchar(255) NOT NULL DEFAULT 'Unviewed',
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  `quizid` int(11) NOT NULL,
				  `person_name` varchar(255) NOT NULL,
				  `ipaddress` varchar(255) NOT NULL,
				  `mark` int(11) NOT NULL DEFAULT '0',
				  `total` int(11) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM;");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_SECTION_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `quizid` int(11) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `number` int(11) NOT NULL,
				  `difficulty` varchar(11) NOT NULL,
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_QUIZ_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `display_result` varchar(255) NOT NULL DEFAULT 'no',
				  `type` varchar(255) NOT NULL DEFAULT 'quiz',
				  `status` varchar(255) NOT NULL DEFAULT 'disabled',
				  `notification_type` varchar(255) NOT NULL DEFAULT 'none',
				  `take_details` varchar(3) NOT NULL DEFAULT 'no',
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_QUESTION_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `type` varchar(30) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  `additional` text NOT NULL,
				  `value` int(11) NOT NULL DEFAULT '1',
				  `quizid` int(11) NOT NULL,
				  `hint` text NOT NULL,
				  `difficulty` varchar(255) NOT NULL,
				  `section_type` varchar(255) NOT NULL DEFAULT 'multiple',
				  `sectionid` int(11) NOT NULL,
				  PRIMARY KEY (`id`)
				  ) ENGINE=MyISAM;");
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_ANSWER_TABLE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `questionid` int(11) NOT NULL,
				  `text` varchar(255) NOT NULL,
				  `correct` varchar(3) NOT NULL,
				  PRIMARY KEY (`id`),
				  KEY `questionid` (`questionid`)
				  ) ENGINE=MyISAM");
	
}

register_activation_hook(__FILE__, 'wpsqt_install'); 


/**
 * Adds a custom menus to the admin page.
 * Layout
 *   WP Survey And Quiz Tool
 *   -> Quiz/Surveys
 *   -> Questions
 *   -> Results
 *   -> Options
 */

function wpsqt_main_admin_menu(){
	
	wp_enqueue_script('jquery');
	add_menu_page('WP Survey And Quiz Tool', 'WP Survey And Quiz Tool', 'manage_options', WPSQT_PAGE_MAIN , 'wpsqt_main_admin_main_page');
	add_submenu_page( 'wpsqt-menu' , 'Quiz/Surveys', 'Quiz/Surveys', 'manage_options', WPSQT_PAGE_QUIZ , 'wpsqt_main_admin_quiz_page');
	add_submenu_page( 'wpsqt-menu' , 'Questions', 'Questions', 'manage_options', WPSQT_PAGE_QUESTIONS, 'wpsqt_main_admin_questions_page');
	add_submenu_page( 'wpsqt-menu' , 'Quiz Results', 'Quiz Results', 'manage_options', WPSQT_PAGE_QUIZ_RESULTS , 'wpsqt_main_admin_quiz_results_page');
	add_submenu_page( 'wpsqt-menu' , 'Options', 'Options', 'manage_options', WPSQT_PAGE_OPTIONS, 'wpsqt_main_admin_options_page');
	add_submenu_page( 'wpsqt-menu' , 'Contact' , 'Contact' , 'manage_options' , WPSQT_PAGE_CONTACT , 'wpsqt_main_admin_contact_page');
	add_submenu_page( 'wpsqt-menu' , 'Help' , 'Help' , 'manage_options' , WPSQT_PAGE_HELP, 'wpsqt_main_admin_help_page');
	
}

/**
 * Main page for when people click on the WP Survey And Quiz Tool.
 * Simply selects the lastest quiz results and the lastest quizes.
 * 
 * @uses wpdb
 */
function wpsqt_main_admin_main_page(){
	
	global $wpdb;
	
	$results = $wpdb->get_results( 'SELECT r.id,r.timestamp,r.status,r.person_name,r.mark,r.ipaddress,q.name
									FROM '.WPSQT_RESULTS_TABLE.' AS r 
									INNER JOIN '.WPSQT_QUIZ_TABLE.' as q ON q.id = r.quizid 
									WHERE r.status = "Unviewed" 
									ORDER BY r.id ASC 
									LIMIT 0,10',ARRAY_A);
	$quizList = $wpdb->get_results( 'SELECT id,name,status,type 
									 FROM '.WPSQT_QUIZ_TABLE.' 
									 ORDER BY id DESC 
									 LIMIT 0,5' , ARRAY_A );
	require_once WPSQT_DIR.'/pages/admin/main/index.php';
	
}


/**
 * Handles requests for admin pages for the
 * quiz section. The page to be shown is 
 * dictated by the $_GET action variable with
 * the functions being held in a seperate file.
 * 
 * @uses includes/admin/quiz.php
 */

function wpsqt_main_admin_quiz_page(){
	
	require_once WPSQT_DIR.'/includes/admin/quiz.php';
	
	if ( !isset($_REQUEST['action']) || $_REQUEST['action'] == 'list' ){
		wpsqt_admin_quiz_list();
	}
	elseif ( $_REQUEST['action'] == 'create' ){
		wpsqt_admin_quiz_form();		
	}
	elseif ( $_REQUEST['action'] == 'sections' ){
		wpsqt_admin_quiz_sections();
	}	
	elseif ( $_REQUEST['action'] == 'delete' ){
		wpsqt_admin_quiz_delete();
	}
	elseif ( $_REQUEST['action'] == 'configure' ){
		wpsqt_admin_quiz_form(true);
	}	
	else {
		require_once WPSQT_DIR.'/pages/general/error.php';
	}	
	
}

/**
 * Handles requests for admin pages for the
 * question section. The page to be shown is 
 * dictated by the $_GET action variable with
 * the functions being held in a seperate file.
 * 
 * @uses includes/admin/questions.php
 */

function wpsqt_main_admin_questions_page(){	
	require_once WPSQT_DIR.'/includes/admin/questions.php';		
	if ( !isset($_REQUEST['action'])  || $_REQUEST['action'] == 'list' ){
			wpsqt_admin_questions_show_list();
	}
	elseif ( $_REQUEST['action'] == 'addnew' ){
		wpsqt_admin_questions_addnew();		
	}
	elseif ( $_REQUEST['action'] == 'edit' ){
		wpsqt_admin_questions_edit();
	}
	elseif ( $_REQUEST['action'] == 'delete' ){
		wpsqt_admin_questions_delete();
	}
}


/**
 * Handles requests for admin pages for the
 * results section. The page to be shown is 
 * dictated by the $_GET action variable with
 * the functions being held in a seperate file.
 * 
 * @uses includes/admin/results.php
 */

function wpsqt_main_admin_quiz_results_page(){	
	require_once WPSQT_DIR.'/includes/admin/results.php';

	if ( !isset($_REQUEST['action'])  || $_REQUEST['action'] == 'list' ){
			wpsqt_admin_results_show_list();
	} elseif ( $_REQUEST['action'] == 'mark' ){
			wpsqt_admin_results_quiz_mark();
	} elseif ( $_REQUEST['action'] == 'delete' ){
			wpsqt_admin_results_delete_result();
	}
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
function wpsqt_main_site_quiz_page($atts){
	extract( shortcode_atts( array(
					'name' => false
	), $atts) );
	
	if ( !$name ){
		require_once WPSQT_DIR.'/pages/general/error.php';
	}
	
	require_once WPSQT_DIR.'/includes/site/quiz.php';
	wpsqt_site_quiz_show($name);
}

add_shortcode( 'wpsqt_page' , 'wpsqt_main_site_quiz_page' );


/**
 * Does a SQL query to select results from the last 24 hours.
 * 
 * @uses includes/functions.php
 */
function wpsqt_daily_mail(){
	
	global $wpdb;
	require_once WPSQT_DIR.'/includes/functions.php';
	
	$results = $wpdb->get_result('SELECT * 
								  FROM `'.WPSQT_RESULTS_TABLE.'` 
								  WHERE timestamp >= TIMESTAMPADD(DAY,-1,NOW())',ARRAY_A);
	
	wpsqt_functions_send_mail($results);
	
}
add_action('daily_mail', 'wpsqt_daily_mail');

/**
 * Does a SQL query to select from the last hour.
 * 
 * @uses includes/functions.php
 */
function wpsqt_hourly_mail(){
	
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
?>