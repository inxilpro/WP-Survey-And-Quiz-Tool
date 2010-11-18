<?php 
if ( !isset($rowCount) ){ 
	$rowCount = 1;
}
?>
<script type="text/javascript" src="<?php echo bloginfo('wpurl'); ?>/wp-content/plugins/wp-survey-and-quiz-tool/javascript/question_form.php?rowcount=<?php echo $rowCount; ?>"></script>

<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Questions</h2>
	
	<?php if ( isset($successMessage) ){ ?>
		<div class="updated" id="question_added"><?php echo $successMessage; ?></div>
	<?php } ?>
	
	<?php if ( !empty($errorArray) ){ ?>
		<div class="error">
			<ul>
				<?php foreach ( $errorArray as $error ) { ?>
					<li><?php echo $error; ?></li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	
	<?php if ( empty($sections) ){ ?>	
		<div class="error">You need to add sections before adding questions. <a href="<?php echo WPSQT_URL_MAIN;?>&type=<?php echo $result['type']; ?>&action=sections&id=<?php echo htmlentities($_GET['id']); ?>">Click here to add sections</a>.</div>
	<?php } ?>	
	
	<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="question_form">
		
		<input type="hidden" name="action" value="<?php echo htmlentities($_REQUEST['action']); ?>"  />
	
		<table class="form-table" id="question_form">
			<tbody>
				<tr>
					<th scope="row">Question</th>
					<td valign="top" colspan="2"><input <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> type="text" id="question" maxlength="255" size="50" name="question" value="<?php echo stripcslashes($questionText); ?>" /></td>
					
				</tr>
				<tr>
					<th scope="row">Question Type</th>
					<td valign="top">
						<select <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> name="type" id="type">
							<option value="textarea"<?php if ( !isset($questionType) ||  $questionType == 'textarea' ){?> selected="selected"<?php }?>>Free text</option>
							<option value="single"<?php if ( isset($questionType) &&  $questionType == 'single' ){?> selected="selected"<?php }?>>Single Choice</option>
							<option value="multiple"<?php if ( isset($questionType) && $questionType == 'multiple' ){?> selected="selected"<?php }?>>Multiple Choice</option>
						</select>
					</td>
					<td>
						<ul>
							<li><strong>Single Choice</strong> - A multiple choice question, where there is only one correct answer. <em>Automarking abled</em>.</li>
							<li><strong>Multiple Choice</strong> - A multiple choice question, where there can be more than one correct answer. <em>Automarking abled</em>.</li>
							<li><strong>Free Text</strong> - A question where the user is required to type an answer. <em>Can't be automarked</em>.</li>
						</ul>
					</td>					
				</tr>
				<tr>
					<th scope="row">Points</th>
					<td valign="top">
						<select <?php if ( empty($sections) ){ ?> disabled="disabled"<?php }?> name="points">
							<option value="1"<?php if ( !isset($questionValue) || $questionValue == 1){?> selected="yes"<?php }?>>1</option>
							<option value="2"<?php if ( isset($questionValue) && $questionValue == 2){?> selected="yes"<?php }?>>2</option>
							<option value="3"<?php if ( isset($questionValue) && $questionValue == 3){?> selected="yes"<?php }?>>3</option>
							<option value="4"<?php if ( isset($questionValue) && $questionValue == 4){?> selected="yes"<?php }?>>4</option>
							<option value="5"<?php if ( isset($questionValue) && $questionValue == 5){?> selected="yes"<?php }?>>5</option>
						</select>
					</td>
					<td>Number of points a question is worth.</td>
				</tr>
				<tr>
					<th scope="row">Difficulty</th>
					<td valign="top" colspan="2">
						<select <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> name="difficulty">
							<option value="easy"<?php if ( isset($questionDifficulty) && $questionDifficulty == 'easy'){?> selected="yes"<?php }?>>Easy</option>
							<option value="medium"<?php if ( isset($questionDifficulty) && $questionDifficulty == 'medium'){?> selected="yes"<?php }?>>Medium</option>
							<option value="hard"<?php if ( isset($questionDifficulty) && $questionDifficulty == 'hard'){?> selected="yes"<?php }?>>Hard</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Section</th>
					<td valign="top" colspan="2"><select <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> name="section">
							<?php foreach($sections as $section) {?>
							<option value="<?php echo $section['id']; ?>" <?php if ( isset($sectionId) && $sectionId == $section['id']) { ?> selected="yes"<?php } ?>><?php echo $section['name']; ?></option>
							<?php } ?>
					</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Additional Text</th>
					<td valign="top">
						<textarea <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> name="additional" cols="40" rows="6"><?php if ( isset($questionAdditional) ){ echo $questionAdditional; } ?></textarea>
					</td>
					<td>An optional section of text where more detail can be given. HTML can be used in this area.</td>
				</tr>
				<tr class="additional"<?php if ( isset($answers) ) { ?> style="display: none;"<?php } ?>>
					<th scope="row">Answer Hint</th>
					<td valign="top">
						<textarea <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> name="hint" cols="40" rows="6"><?php if ( isset($questionHint) ){  echo $questionHint; } ?></textarea>
					</td>
					<td>An optional section of text that is only displayed to users in wp-admin upon marking an exam.</td>
				</tr>
			</tbody>
		</table>
		
		<div id="multi_form"<?php if ( !isset($answers) ) { ?> style="display: none;"<?php } ?>>
		
		<h3>Choices</h3>
		
			<table border="0" >
				<thead>
					<tr>
						<th>Answer</th>
						<th>Correct</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( !isset($answers)  ) { ?>
					<tr>
						<td><input <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> type="text" name="answer[0]" value="" size="90" id="answer_1" /></td>
						<td>
							<select <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> name="correct[0]" id="correct_1">
								<option></option>
								<option value="no">No</option>
								<option value="yes">Yes</option>
							</select>
						</td>
					</tr>								
					<?php
						}
						else{ 
						 	foreach( $answers as $row => $answer ) { ?>
					<tr>
						<td><input <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> type="text" name="answer[<?php echo $row; ?>]" value="<?php echo stripslashes($answer['text']); ?>" size="90" id="answer_1" /></td>
						<td>
							<select <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> name="correct[<?php echo $row; ?>]" id="correct_1">
								<option></option>
								<option value="no"<?php if ($answer['correct'] == "no"){ ?> selected="selected"<?php } ?>>No</option>
								<option value="yes"<?php if ($answer['correct'] == "yes"){ ?> selected="selected"<?php } ?>>Yes</option>
							</select>
						</td>
					</tr>
						<?php							
						 	}
						} ?>
				</tbody>
			</table>
			
			<p><a href="#" class="button-secondary" title="Add New Answer" id="add_answer">Add New Answer</a></p>
			
		</div>
	
		<p class="submit">
			<input <?php if (empty($sections)){ ?> disabled="disabled"<?php }?> class="button-primary" type="submit" name="Save" value="Save Question" id="submitbutton" />
		</p>
		
	</form>	
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>