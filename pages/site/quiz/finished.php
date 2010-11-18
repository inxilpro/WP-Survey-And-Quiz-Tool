<h2>Exam Finished</h2>

<?php if ($_SESSION['wpsqt'][$quizName]['quiz_details']['display_result'] == 'no' && $_SESSION['wpsqt'][$quizName]['quiz_details']['display_review'] == 'no' ) { ?>
Thank you for your time..
<?php } elseif ($canAutoMark !== true) { ?>
Can't auto mark this.
<?php } elseif ($_SESSION['wpsqt'][$quizName]['quiz_details']['display_result'] == 'yes') { ?>
You got <?php echo $correctAnswers; ?> correct out of <?php echo $totalQuestions; ?>. 
<?php } elseif ($_SESSION['wpsqt'][$quizName]['quiz_details']['display_review'] == 'yes'){ 
	require_once require_once wpsqt_page_display('site/quiz/review.php');	
} ?>