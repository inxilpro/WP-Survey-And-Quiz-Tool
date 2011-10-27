			<select name="answers[<?php echo $questionKey; ?>][]">
			<?php foreach ( $question['answers'] as $answerKey => $answer ){ ?>				
				<option value="<?php echo $answerKey; ?>" <?php if ( in_array($answerKey,$givenAnswer) ) { ?> selected="selected" <?php } ?>><?php echo stripslashes($answer['text']); ?></option>
			<?php } ?>
			</select><br /><br />