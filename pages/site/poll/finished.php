<?php 
// Set up the token object
require_once WPSQT_DIR.'/lib/Wpsqt/Tokens.php';
$objTokens = Wpsqt_Tokens::getTokenObject();
$objTokens->setDefaultValues();

?>

<?php
	$pollName = ucwords($quizName);
	$pollId = $_SESSION['wpsqt'][$pollName]['details']['id'];
	
	if ($_SESSION['wpsqt'][$pollName]['details']['finish_display'] == 'Poll results') {
		// GETS ALL THE RESULTS FOR THIS POLL
		$results = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_RESULTS."` WHERE `item_id` = '".$pollId."'", ARRAY_A);
		
		foreach($_SESSION['wpsqt'][$pollName]['sections'][0]['questions'] as $question) {
			foreach ($results as $result) {
				$section = unserialize($result['sections']);
				$questionId = $question['id'];
				$questionAnswer = $section[0]['answers'][$questionId];
				$questionAnswer = $questionAnswer['given'][0];
				if (!isset($question['answers'][$questionAnswer]['count'])) {
					$question['answers'][$questionAnswer]['count'] = 1;
				} else {
					$question['answers'][$questionAnswer]['count'] += 1;
				}
			}
			echo '<h2>'.$question['name'].'</h2>';
			echo <<< EOT
			<table class="widefat post fixed" cellspacing="0">
				<thead>
					<tr>
						<th class="manage-column column-title" scope="col">Answer</th>
						<th scope="col" width="75">Votes</th>
						<th scope="col" width="90">Percentage</th>
					</tr>			
				</thead>
				<tbody>
EOT;
				$total = 0;
				foreach ($question['answers'] as $answer) {
					$total += $answer['count'];
				}
				foreach($question['answers'] as $answer) {
					$percentage = $answer['count'] / $total * 100;
					echo '<tr>';
					echo '<td>'.$answer['text'].'</td>';
					echo '<td>'.$answer['count'].'</td>';
					echo '<td>'.$percentage.'%</td>';
					echo '</tr>';
				}
				echo <<< EOT
					<tr>
				</tbody>
			</table>
EOT;
		}
	} else {
		echo '<h2>Thank you for taking the poll</h2>';
	}
?>