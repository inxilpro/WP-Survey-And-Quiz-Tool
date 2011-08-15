<?php 
// Set up the token object
require_once WPSQT_DIR.'/lib/Wpsqt/Tokens.php';
$objTokens = Wpsqt_Tokens::getTokenObject();
$objTokens->setDefaultValues();

?>

<h1><?php echo $_SESSION["wpsqt"][$quizName]["details"]["name"]; ?></h1>

<?php if ($_SESSION['wpsqt'][$quizName]['details']['finish_display'] == 'Custom finish message'  ) { ?>
	<?php if ( isset($_SESSION['wpsqt'][$quizName]['details']['finish_message']) &&
			  !empty($_SESSION['wpsqt'][$quizName]['details']['finish_message'])) {
			// PARSE TOKENS
			$string = $objTokens->doReplacement($_SESSION['wpsqt'][$quizName]['details']['finish_message']);
			echo nl2br($string);
		} else { ?>
		Thank you for your time..
	<?php } ?>
<?php } else { ?>

<p>Thank you for completing our survey!</p>

<?php } ?>