<?php

require_once WPSQT_DIR.'lib/Wpsqt/Page/Main/Results.php';

class Wpsqt_Page_Main_Results_Poll extends Wpsqt_Page_Main_Results {
	
	public function init(){
		$this->_pageView = 'admin/poll/result.php';
	}

	public function displayResults($pollId) {
		global $wpdb;

		$results = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_RESULTS."` WHERE `item_id` = '".$pollId."'", ARRAY_A);

		if (!isset($results) || empty($results)) {
			echo '<h2>No results yet</h2>';
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
				echo '<h3>'.$question['name'].'</h3>';
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
	}
	
}

?>