<?php

	/**
	 * Handles the fetching and downloading of PDFs
	 * from DocRaptor. 
	 * 
	 * @author Iain Cambridge
	 * @copyright Fubra Limited 2010-2011 (c), all rights reserved.
	 * @license GPL v2
	 * @package WPSQT
	 */

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/wp-load.php';
require_once WPSQT_DIR.'/includes/docraptor.php';

$resultId = filter_input(INPUT_GET, 'id');
$quizId = filter_input(INPUT_GET,'quizid');
if ( !$_GET['quizid'] || !$_GET['id']  ){
	wp_die('No result id given');
}
global $wpdb;


					
if ( filter_input(INPUT_GET, 'html') ){
	
		echo $pdfTemplate;
	exit;
	
} else {
	$quizDetails = $wpdb->get_row(
						$wpdb->prepare("SELECT * FROM `".WPSQT_QUIZ_TABLE."` WHERE id = %d", array($_GET['quizid'])),
						ARRAY_A);
	$resultDetails = $wpdb->get_row(
						$wpdb->prepare("SELECT * FROM `".WPSQT_RESULTS_TABLE."` WHERE id = %d", array($_GET['id'])),
						ARRAY_A
						);
	$resultDetails['person'] = unserialize($resultDetails['person']);	
	$personName = ( isset($resultDetails['person']['user_name']) && !empty($resultDetails['person']['user_name']) ) ? $resultDetails['person']['user_name'] : 'Anonymous';
	$timestamp = strtotime($resultDetails['timestamp']);
	
	$pdfTemplate = (empty($quizDetails['pdf_template'])) ? get_option('wpsqt_pdf_template'):$quizDetails['pdf_template'];
	
	if ( empty($pdfTemplate) ){
		// default pdf template here.
	} 
	
	$pdfTemplate = str_ireplace( '%SCORE%'       , htmlentities($resultDetails['mark'].'/'.$resultDetails['total']), $pdfTemplate);
	$pdfTemplate = str_ireplace( '%QUIZ_NAME%'   , htmlentities($quizDetails['name']), $pdfTemplate);
	$pdfTemplate = str_ireplace( '%USER_NAME%'   , htmlentities($personName), $pdfTemplate);
	$pdfTemplate = str_ireplace( '%SURVEY_NAME%' , htmlentities($quizDetails['name']), $pdfTemplate);
	$pdfTemplate = str_ireplace( '%DATE_EU%'     , htmlentities(date('d-m-Y',$timestamp)),$pdfTemplate );
	$pdfTemplate = str_ireplace( '%DATE_US%'     , htmlentities(date('m-d-Y',$timestamp)),$pdfTemplate );
	$pdfTemplate = str_ireplace( '%DATETIME_EU%' , htmlentities(date('d-m-Y H:i:s',$timestamp)),$pdfTemplate );
	$pdfTemplate = str_ireplace( '%DATETIME_US%' , htmlentities(date('m-d-Y H:i:s',$timestamp)),$pdfTemplate );
	$pdfTemplate = str_ireplace( '%IP_ADDRESS%'  , htmlentities($resultDetails['ipaddress']), $pdfTemplate );
	$pdfTemplate = str_ireplace( '%HOSTNAME%'    , htmlentities(gethostbyaddr($resultDetails['ipaddress'])) , $pdfTemplate);
	$pdfTemplate = str_ireplace( '%USER_AGENT%'  , htmlentities($_SERVER['HTTP_USER_AGENT']), $pdfTemplate);
	$pdfTemplate = str_ireplace( '%USER_EMAIL%'  ,htmlentities(( isset($resultDetails['person']['email']) ) ? $resultDetails['person']['email'] : '') , $pdfTemplate );
	$resultUrl = htmlentities(get_bloginfo('url').'/wp-admin/admin.php?page=wpsqt-menu&type=quiz&action=results&id='.$quizId
					.'&subaction=mark&subid='.$resultDetails['id']);
	$pdfTemplate = str_ireplace('%RESULT_URL%', $resultUrl, $pdfTemplate);
	$url = plugins_url('pdf.php?html=true&id='.$_GET['id'].'&quizid='.$_GET['quizid'],__FILE__);
	$apiKey = get_option('wpsqt_docraptor_api');
	
	if ( !$apiKey ){
		print "No DocRaptor API key! Please alert the site owner to fix this!";
		exit;
	}
	
	$objDocraptor = new DocRaptor($apiKey);
	$objDocraptor->setDocumentType('pdf')
				 ->setName('PDF')
				 ->setTest(true)
				 ->setDocumentContent($pdfTemplate);
	header('Content-disposition: attachment; filename=document.pdf');
	header('Content-type: application/pdf');
	$objDocraptor->fetchDocument();
	
	
}