<?php 
// Set up the token object
require_once WPSQT_DIR.'/lib/Wpsqt/Tokens.php';
$objTokens = Wpsqt_Tokens::getTokenObject();
$objTokens->setDefaultValues();

?>

<?php
	$pollName = $quizName;
	$pollId = $_SESSION['wpsqt'][$pollName]['details']['id'];
	
	if ($_SESSION['wpsqt'][$pollName]['details']['finish_display'] == 'Poll results') {
		$results = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_RESULTS."` WHERE `item_id` = '".$pollId."'", ARRAY_A);

		if (!isset($results) || empty($results)) {
			echo '<h2>Apprantly there is no results, but you\'ve just submitted the poll.... Obviously something\'s gone wrong.  Please report this to the website admin quoting "There was an error with WPSQT, error code 55. Please report this to the Issues Tracker https://github.com/fubralimited/WP-Survey-And-Quiz-Tool/issues?sort=created&direction=desc&state=open"</h2>';
		} else {
			$questions = array();
			foreach($results as $result) {
				$sections = unserialize($result['sections']);
				foreach($sections as $section) {
					$answers = $section['answers'];
					foreach($answers as $key => $answer) {
						if (!isset($questions[$key]))
							$questions[$key] = array();
						$givenAnswer = (int) $answer['given'][0];
						if (!isset($questions[$key]['answers'][$givenAnswer]['count'])) {
							$questions[$key]['answers'][$givenAnswer]['count'] = 1;
						} else {
							$questions[$key]['answers'][$givenAnswer]['count']++;
						}
					}
				}
			}

			// Calculate totals for each answer
			// Has to be done in seperate array otherwise stupid referencing issues occur later
			$answerTotals = array();
			foreach($questions as $questionKey => $question) {
				foreach ($question['answers'] as $key => $answer) {
					if(!isset($answerTotals[$questionKey])) {
						$answerTotals[$questionKey] = $answer['count'];
					} else {
						$answerTotals[$questionKey] = $answerTotals[$questionKey] + $answer['count'];
					}
				}
			}

			foreach($questions as $key => &$question) {
				$questionInfo = $wpdb->get_row("SELECT `name`, `meta` FROM `".WPSQT_TABLE_QUESTIONS."` WHERE `id` = '".$key."'", ARRAY_A);
				$question['name'] = $questionInfo['name'];
				$questionInfo = unserialize($questionInfo['meta']);
				echo '<h2>'.$question['name'].'</h2>';
				?>
				<table class="widefat post fixed" cellspacing="0">
					<thead>
						<tr>
							<th class="manage-column column-title" scope="col">Answer</th>
							<th scope="col" width="75">Votes</th>
							<th scope="col" width="90">Percentage</th>
						</tr>			
					</thead>
					<tfoot>
						<tr>
							<th class="manage-column column-title" scope="col">Answer</th>
							<th scope="col" width="75">Votes</th>
							<th scope="col" width="90">Percentage</th>
						</tr>			
					</tfoot>
					<tbody>
				
					<?php
					foreach($question['answers'] as $answerKey => &$answer) {
						echo '<tr>';
							echo '<td>'.$questionInfo['answers'][$answerKey]['text'].'</td>';
							echo '<td>'.$answer['count'].'</td>';
							echo '<td>'.round(($answer['count'] / $answerTotals[$key]) * 100, 2) .'%</td>';
						echo '</tr>';
					}

				?></table><?php
			}
		}
	} else {
		echo '<h2>Thank you for taking the poll</h2>';
	}
?>