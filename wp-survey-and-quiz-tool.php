<?php
/*
Plugin Name: WP Survey And Quiz Tool
Plugin URI: http://catn.com/2010/10/04/wp-survey-and-quiz-tool/
Description: Allows wordpress owners to create their own web based quizes.
Author: Fubra Limited
Author URI: http://www.catn.com
Version: 2.0-beta

WP Survey And Quiz Tool
Copyright (C) 2011  Fubra Limited

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your H) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

global $wpdb;

if ( !session_id() )
	session_start();

define( 'WPSQT_PAGE_MAIN'            , 'wpsqt-menu' );
define( 'WPSQT_PAGE_QUIZ'            , 'wpsqt-menu-quiz' );
define( 'WPSQT_PAGE_QUESTIONS'       , 'wpsqt-menu-question' );
define( 'WPSQT_PAGE_QUIZ_RESULTS'    , 'wpsqt-menu-quiz-results' );
define( 'WPSQT_PAGE_OPTIONS'         , 'wpsqt-menu-options' ) ;
define( 'WPSQT_PAGE_CONTACT'         , 'wpsqt-menu-contact' );
define( 'WPSQT_PAGE_HELP'            , 'wpsqt-menu-help'    );
define( 'WPSQT_PAGE_SURVEY'          , 'wpsqt-menu-survey'  );
define( 'WPSQT_PAGE_CATN'            , 'wpsqt-menu-catn' );
define( 'WPSQT_PAGE_MAINTENANCE'     , 'wpsqt-menu-maintenance' );

define( 'WPSQT_TABLE_QUIZ_SURVEYS'   , $wpdb->get_blog_prefix().'wpsqt_quiz_surveys' );
define( 'WPSQT_TABLE_SECTIONS'       , $wpdb->get_blog_prefix().'wpsqt_sections' );
define( 'WPSQT_TABLE_QUESTIONS'      , $wpdb->get_blog_prefix().'wpsqt_all_questions' );
define( 'WPSQT_TABLE_FORMS'          , $wpdb->get_blog_prefix().'wpsqt_custom_forms' );
define( 'WPSQT_TABLE_RESULTS'        , $wpdb->get_blog_prefix().'wpsqt_all_results' );
define( 'WPSQT_TABLE_SURVEY_CACHE'   , $wpdb->get_blog_prefix().'wpsqt_survey_cache_results' );

define( 'WPSQT_URL_MAIN'             , admin_url('admin.php?page='.WPSQT_PAGE_MAIN) );
define( 'WPSQT_URL_MAINENTANCE'      , admin_url('admin.php?page='.WPSQT_PAGE_MAINTENANCE) );
define( 'WPSQT_CONTACT_EMAIL'        , 'support@catn.com' );
define( 'WPSQT_VERSION'              , '2.0.0' );
define( 'WPSQT_DIR'                  , dirname(__FILE__).'/' );
define( 'WPSQT_FILE'     , __FILE__ );

require_once WPSQT_DIR.'lib/Wpsqt/Core.php';
require_once WPSQT_DIR.'lib/Wpsqt/System.php';

// Call Wpsqt_Installer Class to write in WPSQT tables on activation 
register_activation_hook ( __FILE__, 'wpsqt_main_install' );

/**
 * Class for Installing plugin on activation.
 *
 * @since 2
 */
function wpsqt_main_install(){
	
	global $wpdb;
	
	$oldVersion = get_option('wpsqt_version');
	
	update_option('wpsqt_version',WPSQT_VERSION);
	if ( !get_option('wpsqt_number_of_items') ){
		update_option('wpsqt_number_of_items',25);
	}
	// Simple way of checking if an it's an update or not.
	if ( !empty($oldVersion) && $oldVersion != WPSQT_VERSION ){
		update_option('wpsqt_update_required',true);
		return ;
	}
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_QUESTIONS."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `item_id` int(11) NOT NULL,
				  `section_id` int(11) NOT NULL,
				  `difficulty` varchar(255) NOT NULL,
				  `meta` longtext NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_RESULTS."`(
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `item_id` int(11) NOT NULL,
				  `timetaken` int(11) NOT NULL,
				  `person` longtext NOT NULL,
				  `sections` longtext NOT NULL,
				  `person_name` varchar(255) NOT NULL,
				  `ipaddress` varchar(255) NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
				  `status` varchar(255) NOT NULL DEFAULT 'unviewed',
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_FORMS."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `item_id` int(11) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `type` varchar(255) NOT NULL,
				  `required` varchar(255) NOT NULL,
				  `validation` varchar(355) NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	");
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_QUIZ_SURVEYS."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `name` varchar(255) NOT NULL,
				  `settings` longtext NOT NULL,
				  `type` varchar(266) NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");	

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_SECTIONS."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `item_id` int(11) NOT NULL,
				  `name` varchar(255) NOT NULL,
				  `limit` varchar(255) NOT NULL,
				  `order` varchar(11) NOT NULL,
				  `difficulty` varchar(255) NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  UNIQUE KEY `id` (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	");

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".WPSQT_TABLE_SURVEY_CACHE."` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `sections` longtext NOT NULL,
				  `total` int(11) NOT NULL,
				  `item_id` int(11) NOT NULL,
				  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	");

}

if ( is_admin() ){
	require_once WPSQT_DIR.'lib/Wpsqt/Admin.php';
	$objWpsqtPlugin = new Wpsqt_Admin();
} else {
	$objWpsqtPlugin = new Wpsqt_Core();
}