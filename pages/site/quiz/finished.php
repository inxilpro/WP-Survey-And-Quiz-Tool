<h2>Exam Finished</h2>

<?php if ($_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Finish message'  ) { ?>
	<?php if ( isset($_SESSION['wpsqt'][$quizName]['details']['finish_message']) &&
			  !empty($_SESSION['wpsqt'][$quizName]['details']['finish_message'])) {
			echo $_SESSION['wpsqt'][$quizName]['details']['finish_message'];			  	
		} else { ?>
		Thank you for your time..
	<?php } ?>
		
<?php } elseif ($_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Quiz Review'){ 
	require_once Wpsqt_Core::pageView('site/quiz/review.php');	
} 

	if ( $_SESSION['wpsqt'][$quizName]['details']['use_pdf'] == "yes" ){
		?>
		<a href="<?php echo plugins_url('pdf.php?quizid='.$_SESSION['wpsqt'][$quizName]['details']['id'].'&id='.$_SESSION['wpsqt']['result_id'],WPSQT_FILE); ?>">Download certification</a>
		<?php 
	}
?>

