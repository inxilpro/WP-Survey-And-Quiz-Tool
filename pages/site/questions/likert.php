<?php for ( $i = 1; $i <= 10; $i++){ ?>
	<input type="radio" name="answers[<?php echo $questionKey; ?>]" value="<?php echo $i; ?>" <?php if ( in_array($i, $givenAnswer) ) { ?> checked="checked" <?php } ?> id="answer_<?php echo $question['id']; ?>_<?php echo $i; ?>" /> <label for="answer_<?php echo $question['id']; ?>_<?php echo $i; ?>"><?php echo $i; ?></label>
<?php }?>