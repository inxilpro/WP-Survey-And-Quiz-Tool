<?php global $wpdb; ?>
<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Results</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>	
	
	<?php if ( isset($message) ) { ?>
	<div class="updated">
		<strong><?php echo $message; ?></strong>
	</div>
	<?php } ?>
	
	<form method="post" action="">
	
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		
		<?php
		$pollName = $quizName;
		if (isset($_SESSION['wpsqt'][$pollName])) {
			$pollId = $_SESSION['wpsqt'][$pollName]['details']['id'];
			
			// GETS ALL THE RESULTS FOR THIS POLL
			$results = $wpdb->get_results("SELECT * FROM `".WPSQT_TABLE_RESULTS."` WHERE `item_id` = '".$pollId."'", ARRAY_A);
		} else {
			echo "The WPSQT session variable has obviously not been set. Not sure why this could have happened...";
		}
		
		if (!isset($results) || empty($results)) {
			echo '<h2>No results yet</h2>';
		} else {
			foreach($_SESSION['wpsqt'][$pollName]['sections'] as $section) {
				foreach($section['questions'] as $question) {
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
					echo '<h3>'.$question['name'].'</h3>';
					echo <<< EOT
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
EOT;
						$total = 0;
						foreach ($question['answers'] as $answer) {
							if (!isset($answer['count']))
								$answer['count'] = '0';
							$total += $answer['count'];
						}
						foreach($question['answers'] as $answer) {
							if (isset($answer['count'])) {
								$percentage = $answer['count'] / $total * 100;
							} else {
								$percentage = '0';
							}
							echo '<tr>';
							echo '<td>'.$answer['text'].'</td>';
							if (isset($answer['count'])) {
								echo '<td>'.$answer['count'].'</td>';
							} else {
								echo '<td>0</td>';
							}
							echo '<td>'.round($percentage, 2).'%</td>';
							echo '</tr>';
						}
						echo <<< EOT
							<tr>
		
						</tbody>
					</table>
EOT;
		
				}

			}
		}
		?>
		
	</form>
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>