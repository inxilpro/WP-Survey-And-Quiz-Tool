<?php
if ($question['likertscale'] != "Agree/Disagree") {
	$scale = (int) $question['likertscale'];
	for ( $i = 1; $i <= $scale; $i++){ ?>
		<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php echo $i; ?>" <?php if ( in_array($i, $givenAnswer) ) { ?> checked="checked" <?php } ?> id="answer_<?php echo $question['id']; ?>_<?php echo $i; ?>" /> <label for="answer_<?php echo $question['id']; ?>_<?php echo $i; ?>"><?php echo $i; ?></label></span>
	<?php }
} else {
	?>
	<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="stronglydisagree" id="answer_<?php echo $question['id']; ?>_stronglydisagree" /> <label for="answer_<?php echo $question['id']; ?>_stronglydisagree">Strongly Disagree</label></span>
	<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="disagree" id="answer_<?php echo $question['id']; ?>_disagree" /> <label for="answer_<?php echo $question['id']; ?>_disagree">Disagree</label></span>
	<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="meh" id="answer_<?php echo $question['id']; ?>_meh" /> <label for="answer_<?php echo $question['id']; ?>_meh">No Opinion</label></span>
	<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="agree" id="answer_<?php echo $question['id']; ?>_agree" /> <label for="answer_<?php echo $question['id']; ?>_agree">Agree</label></span>
	<span class="wpsqt_likert_answer"><input type="radio" name="answers[<?php echo $questionKey; ?>]" value="stronglyagree" id="answer_<?php echo $question['id']; ?>_stronglyagree" /> <label for="answer_<?php echo $question['id']; ?>_stronglyagree">Strongly Agree</label></span>
<?php } ?>
<br /><br />