<h2>Exam Finished</h2>

<?php if ($_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Finish message'  ) { ?>
	<?php if ( isset($_SESSION['wpsqt'][$quizName]['details']['finish_message']) &&
			  !empty($_SESSION['wpsqt'][$quizName]['details']['finish_message'])) {
			echo $_SESSION['wpsqt'][$quizName]['details']['finish_message'];			  	
		} else { ?>
		Thank you for your time..
	<?php } ?>
		
<?php } elseif ($_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Quiz Review'){ 
	require_once wpsqt_page_display('site/quiz/review.php');	
} ?>