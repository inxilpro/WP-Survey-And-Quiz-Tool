<div class="wrap">
	<script type="text/javascript" src="<?php echo bloginfo('wpurl'); ?>/wp-content/plugins/wp-survey-and-quiz-tool/javascript/shared_form.php?rowcount=0&random=<?php echo $rowCount; ?>"></script>

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Form</h2>

	<?php if ( $enabled == 'no' ){ ?>
		<div class="error">This quiz/survey doesn't currently have a contact form enabled. This form will enable the contact form on the quiz/survey.</div>
	<?php } ?>
	
	<p>This provides the ability to create a contact form with custom fields with the ability to define which information is required and what information isn't for your quiz or survey. Using this feature will totally override the default form so if you wish to have the same fields you will need to enter them again.</p>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		
	<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<table id="multi_table" class="form-table">
			<thead>			
				<tr>
					<th>Name</th>
					<th>Type</th>
					<th>Required</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($fields as $field){ ?>
				<tr>
					<td><input type="text" name="field_name[]" value="<?php echo $field['name']; ?>" /></td>
					<td><select name="field_type[]"/>
							<option value="text" <?php if ($field['type'] == 'type'){ ?> selected="selected"<?php }?>>Text</option>
							<option value="textarea" <?php if ($field['type'] == 'textarea'){ ?> selected="selected"<?php }?>>Textarea</option>
						</select></td>
					<td><select name="field_required[]">
							<option value="no" <?php if ($field['required'] == 'no'){ ?> selected="selected"<?php }?>>No</option>
							<option value="yes" <?php if ($field['required'] == 'yes'){ ?> selected="selected"<?php }?>>Yes</option>
						</select></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<a href="#" class="button-secondary" id="add_field">Add Field</a>
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Question" id="submitbutton" />
		</p>
	</form>
	
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>