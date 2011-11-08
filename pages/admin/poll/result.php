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
		$pollId = (int) $_GET['id'];
			
		// GETS ALL THE RESULTS FOR THIS POLL
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
			foreach($questions as $key => &$question) {
				$questionInfo = $wpdb->get_row("SELECT `name`, `meta` FROM `".WPSQT_TABLE_QUESTIONS."` WHERE `id` = '".$key."'", ARRAY_A);
				$question['name'] = $questionInfo['name'];
				$questionInfo = unserialize($questionInfo['meta']);
				foreach($question['answers'] as $key => &$answer) {
					$answer['text'] = $questionInfo['answers'][$key]['text'];
				}
			}
			echo '<pre>'; var_dump($questions); echo '</pre>';
		}
		?>
		
	</form>
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>