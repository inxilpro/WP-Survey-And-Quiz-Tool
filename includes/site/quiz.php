<?php

	/**
	 * Handles user interaction with a quiz.
	 * 
	 * @author Iain Cambridge
	 */

/**
 * Starting point for all user interactions with 
 * a quiz or survey. Checks to see which page 
 * should be displayed. Does simple autochecking 
 * for multiple choice questions.
 * 
 * @uses wpdb
 *  
 * @since 0.1
 */

function wpsqt_site_quiz_show($quizName){

	global $wpdb;
	
	if ( !isset($_SESSION['wpsqt'])  ){
		$_SESSION['wpsqt'] = array();
	}
	
	
	$step = ( isset($_REQUEST['step']) && ctype_digit($_REQUEST['step']) ) ? intval($_REQUEST['step']) : 0;	
	
	if ( $step == 0 ){		
		$_SESSION['wpsqt'][$quizName] = array();
		$_SESSION['wpsqt'][$quizName]['start'] = microtime(true);
		$_SESSION['wpsqt'][$quizName]['quiz_details'] = $wpdb->get_row( $wpdb->prepare('SELECT * FROM '.WPSQT_QUIZ_TABLE.' WHERE name like %s', array($quizName) ), ARRAY_A );
		$_SESSION['wpsqt'][$quizName]['quiz_sections'] = $wpdb->get_results('SELECT * FROM '.WPSQT_SECTION_TABLE.' WHERE quizid = '.$_SESSION['wpsqt'][$quizName]['quiz_details']['id'], ARRAY_A );	
		$_SESSION['wpsqt'][$quizName]['person'] = array();
		$_SESSION['wpsqt']['start'] = microtime(true);
	}
	
	$_SESSION['wpsqt']['current_step'] = $step;
	$_SESSION['wpsqt']['current_name'] = $quizName;
	 
	
	$sectionKey = ( $_SESSION['wpsqt'][$quizName]['quiz_details']['take_details'] == 'yes' ) ? $step - 1 : $step;
	
	
	if ( $_SESSION['wpsqt'][$quizName]['quiz_details']['take_details'] == 'yes' && $step == 0 ){		 
		 wpsqt_site_quiz_take_details(false);
		 return;
	} elseif ( $_SESSION['wpsqt'][$quizName]['quiz_details']['take_details'] == 'yes' && $step == 1 ){		 
		 if ( !wpsqt_site_quiz_take_details(true) ){
		 	return;
		 }	
	}
	
	$numberOfSectons = sizeof($_SESSION['wpsqt'][$quizName]['quiz_sections']);
	// Check to see if we have a step higher than is possible. 
	if ( $sectionKey > $numberOfSectons ){
		require_once WPSQT_DIR.'/pages/general/error.php';
		return;
	} else {
		// Handle marking previous sections questions
		
		if ( isset($_POST['answers']) ){
			$incorrect = 0;
			$correct = 0;
			$pastSectionKey = $sectionKey - 1;
			$_SESSION['wpsqt'][$quizName]['quiz_sections'][$pastSectionKey]['answers'] = array();
			
			foreach ( $_POST['answers'] as $questionKey => $givenAnswers ){
				$answerMarked = array();
				if ( $_SESSION['wpsqt'][$quizName]['quiz_sections'][$pastSectionKey]['type'] == 'multiple' ) {
				
					if ( !isset($_SESSION['wpsqt'][$quizName]['quiz_sections'][$pastSectionKey]['questions'][$questionKey]) ){
						$incorrect++;	
						continue;							
					}// END if isset question
					$subNumOfCorrect = 0;
					$subCorrect = 0;
					$subIncorrect = 0;
					foreach ( $_SESSION['wpsqt'][$quizName]['quiz_sections'][$pastSectionKey]['questions'][$questionKey]['answers'] as $rawAnswers ){
						$numberVarName = '';				
						if ($rawAnswers['correct'] == 'yes'){
							$numberVarName = 'subCorrect';
							$subNumOfCorrect++;
						} else {
							$numberVarName = 'subIncorrect';
						}
						
						if ( in_array($rawAnswers['id'], $givenAnswers) ){
							${$numberVarName}++;
						}							
					}
						
					if ( $subCorrect === $subNumOfCorrect && $subIncorrect === 0 ){
						$correct++;
						$answerMarked['mark'] = 'correct';
					}
					else {
						$incorrect++;
						$answerMarked['mark'] = 'incorrect';
					}
						
				}// END if section type == multiple
				
				$answerMarked['given'] = $givenAnswers;
				$_SESSION['wpsqt'][$quizName]['quiz_sections'][$pastSectionKey]['answers'][$questionKey] = $answerMarked;
				
			}// END foreach answer
			$_SESSION['wpsqt'][$quizName]['quiz_sections'][$pastSectionKey]['stats'] = array('correct' => $correct, 'incorrect' => $incorrect);
				
		}// END if isset($_POST['answers'])
		
		if ( $sectionKey == $numberOfSectons ){			
			$_SESSION['wpsqt'][$quizName]['finish'] = microtime(true);
			wpsqt_site_quiz_finish();
			return;	
		}
		
		if ( !isset($_SESSION['wpsqt'][$quizName]['quiz_sections'][$sectionKey]['questions']) ){
			$_SESSION['wpsqt'][$quizName]['quiz_sections'][$sectionKey]['questions'] = wpsqt_site_quiz_fetch_questions($sectionKey);
		}
		require_once WPSQT_DIR.'/pages/site/quiz/section.php';
	}
	
	return;
	
}

/**
 * Simply function to  display contact and to
 * take and check data to ensure it is provided.
 * 
 * @param boolean $collectDetails
 *
 * @uses pages/site/quiz/contact.php
 * 
 * @return boolean True if collectDetails is true and there is no errors. Else returns false and displays the contact page.
 * 
 * @since 0.1
 */

function wpsqt_site_quiz_take_details($collectDetails = false){
	
	$quizName = $_SESSION['wpsqt']['current_name'];
	
	if ($collectDetails == true ){

		$errors = array();
		if ( !isset($_POST['user_name']) || empty($_POST['user_name']) ){
			$errors[] = 'Name required';
		}	
		if ( !isset($_POST['email']) || !is_email($_POST['email']) ){
			$errors[] = 'Valid email required';
		}	
		if ( !isset($_POST['phone']) || empty($_POST['phone']) ){
			$errors[] = 'Phone required';
		}		
		if ( !isset($_POST['address']) || empty($_POST['address']) ){
			$errors[] = 'Address required';
		}
		if ( !isset($_POST['notes']) || empty($_POST['notes']) ){
			$errors[] = 'Experience required';
		}
			
		if ( empty($errors) ){
			$_SESSION['wpsqt'][$quizName]['person']['name']    = (string) $_POST['user_name'];
			$_SESSION['wpsqt'][$quizName]['person']['email']   = (string) $_POST['email'];
			$_SESSION['wpsqt'][$quizName]['person']['phone']   = (string) $_POST['phone'];
			$_SESSION['wpsqt'][$quizName]['person']['address'] = (string) $_POST['address'];
			$_SESSION['wpsqt'][$quizName]['person']['notes']   = (string) $_POST['notes'];
			$_SESSION['wpsqt'][$quizName]['person']['heard']   = (string) $_POST['heard'];
			return true;
		}
	}
	
	require_once WPSQT_DIR.'/pages/site/quiz/contact.php';
	return false;
}

/**
 * Fetches questions for a section, does simple checks to 
 * ensure right number of questions are provided and there
 * are no duplicates.
 * 
 * @param integer $sectionKey the key for the section in quiz_sections
 * 
 * @since 0.1
 */

function wpsqt_site_quiz_fetch_questions($sectionKey){
	
	global $wpdb;
	
	// Set variables
	$quizName = $_SESSION['wpsqt']['current_name'];
	$quizId   = $_SESSION['wpsqt'][$quizName]['quiz_details']['id'];
	$section  = $_SESSION['wpsqt'][$quizName]['quiz_sections'][$sectionKey];
	$moreQuestions = 0;
	$questions = array();
	
	if ( $section['difficulty'] == "mixed" ){
		// If mixed them select an equal number of each difficulty,
		// unless the number of questions can't be divided by three.
		// At which point randomly fetch more of one difficulty to make up. 
		$reminder  = $section['number'] % 3;
		$eachLimit = intval( $section['number'] / 3 );
		$randomized = intval(mt_rand(1, 3));
		
		$i = 1;
		foreach ( array('easy','medium','hard') as $difficulty){
			$thisLimit = $eachLimit;	
			if ($i == $randomized){
				$thisLimit += $reminder;	
			}
			$difficultyQuestions = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.WPSQT_QUESTION_TABLE.' WHERE difficulty = %s AND quizid = %d AND section_type = %s ORDER BY RAND() LIMIT 0,%d',array($difficulty,$quizId,$section['type'],$thisLimit)), ARRAY_A );
			$moreQuestions += $thisLimit - sizeof($difficulty);
			$questions = array_merge($questions,$difficultyQuestions);
		}	
			
	} else {
		$difficultyQuestions = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.WPSQT_QUESTION_TABLE.' WHERE difficulty = %s AND quizid = %d AND section_type = %s ORDER BY RAND() LIMIT 0,%d',array($section['difficulty'],$quizId,$section['type'],$section['number'] )), ARRAY_A );
		$moreQuestions = $section['number'] - sizeof($difficultyQuestions);	
		$questions = array_merge($questions,$moreQuestions);
	}
	
	if ( $moreQuestions ){		
		$difficultyQuestions = $wpdb->get_results( $wpdb->prepare('SELECT * FROM '.WPSQT_QUESTION_TABLE.' WHERE quizid = %d AND section_type = %s ORDER BY RAND() LIMIT 0,%d',array( $quizId , $section['type'] , $moreQuestions )), ARRAY_A );
		$moreQuestions = $section['number'] - sizeof($difficultyQuestions);	
		$questions = array_merge($questions,$difficultyQuestions);
	}
	
	$questionDetails = array();
	$questionDetails['output'] = array();
	$questionDetails['section_type'] = $section['type'];
	$questionDetails['count'] = 0;
	
	foreach ( $questions as $question ){
		wpsqt_site_quiz_question_sort($question, $questionDetails);
	}
	
	return $questionDetails['output'];
}


/**
 * Sorts questions to ensure there are no
 * duplicates. If multiple chocie it also
 * fetches the answers.
 * 
 * @param array $orgiQuestion the orignal question array
 * @param array $questionDetails the output array, given by refrence due to orginal attempt to execute this via array_walk
 * 
 * @since 0.1
 */
function wpsqt_site_quiz_question_sort($origQuestion,&$questionDetails){

	global $wpdb;
	
	if ( array_key_exists( $origQuestion['id'] , $questionDetails['output'] )){
		return;
	}
	
	if ($questionDetails['section_type'] == 'multiple'){		
		$answers = $wpdb->get_results( $wpdb->prepare('SELECT id,text,correct FROM '.WPSQT_ANSWER_TABLE.' WHERE questionid  = %d', array($origQuestion['id']) ), ARRAY_A);
		$origQuestion['answers'] = array();
		foreach( $answers as $answer ){
			$origQuestion['answers'][$answer['id']] = $answer;
		}
	}
	$questionDetails['count']++;
	$questionDetails['output'][$origQuestion['id']] = $origQuestion;

	return;
}

/**
 * Does the final sorting of data with quick 
 * tallying of results incase they are to be 
 * displayed. Also inserts data into result 
 * table. 
 * 
 * @uses pages/site/quiz/finished.php
 * 
 * @since 0.1
 */

function wpsqt_site_quiz_finish(){
	
	global $wpdb;
	
	$quizName =$_SESSION['wpsqt']['current_name'];
	$timeTaken = $_SESSION['wpsqt'][$quizName]['finish'] - $_SESSION['wpsqt']['start'];
	$wpdb->query( $wpdb->prepare('INSERT INTO `'.WPSQT_RESULTS_TABLE.'` (person_name,ipaddress,person,sections,timetaken,quizid) VALUES (%s,%s,%s,%s,%d,%d)', 
	array($_SESSION['wpsqt'][$quizName]['person']['name'],$_SERVER['REMOTE_ADDR'],serialize($_SESSION['wpsqt'][$quizName]['person']),serialize($_SESSION['wpsqt'][$quizName]['quiz_sections']),$timeTaken,$_SESSION['wpsqt'][$quizName]['quiz_details']['id']) ) );
	
	$totalQuestions = 0;
	$correctAnswers = 0;
	$canAutoMark = true;
	
	foreach ($_SESSION['wpsqt'][$quizName]['quiz_sections'] as $quizSection){		
		
		if ( $quizSection['type'] == 'textarea' ){
			$canAutoMark = false;
			break;
		}
		
		if ( isset($quizSection['stats']['correct']) ){		
			$correctAnswers + $quizSection['stats']['correct'];
			$totalQuestions += ($quizSection['stats']['correct'] + $quizSection['stats']['incorrect']);
		}
		
	}
	$emailAddress = get_option('wpsqt_contact_email');
	
	if ( $_SESSION['wpsqt'][$quizName]['quiz_details']['notification_type'] == 'instant' && is_email($emailAddress) ){
	
		$emailSubject  = 'There is a new quiz to be marked';
		$emailMessage  = 'There is a new quiz to be marked'.PHP_EOL.PHP_EOL;
		$emailMessage .= 'Person Name :'.$_SESSION['wpsqt'][$quizName]['person']['name'].PHP_EOL;
		$emailMessage .= 'IP Address :'.$_SERVER['REMOTE_ADDR'].PHP_EOL;
				
		$headers = 'From: WPSQT Bot <'.WPSQT_FROM_EMAIL.'>' . "\r\n";
	   	wp_mail($emailAddress,'WPSQT Notification',$emailMessage,$headers);
	}
	
	require_once WPSQT_DIR.'/pages/site/quiz/finished.php';
	
}

?>