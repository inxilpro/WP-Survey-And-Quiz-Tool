<div class="wrap">

	<?php if ( isset($successMessage) ) {?>
		<div class='updated'><?php echo $successMessage; ?></div>
				
	<?php } ?>
	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Create Survey
	</h2>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="quiz_form">
		
		<input type="hidden" name="action" value="<?php echo htmlentities($_REQUEST['action']); ?>"  />
	
		<table class="form-table" id="question_form">
			<tbody>
				<tr>
					<th scope="row">Name</th>
					<td><input id="survey_name" maxlength="255" size="50" name="survey_name" value="<?php if ( isset($surveyDetails['name']) ) { echo stripcslashes($surveyDetails['name']); } ?>" /></td>
				</tr>
				<tr>
					<th scope="row">Status</th>
					<td>
						<select id="status" name="status">
							<option value="enabled"<?php if ( !isset($surveyDetails['status']) ||  $surveyDetails['status'] == 'enabled' ){?> selected="selected"<?php }?>>Enabled</option>
							<option value="disabled"<?php if ( isset($surveyDetails['status']) && $surveyDetails['status'] == 'disabled' ){?> selected="selected"<?php }?>>Disabled</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Contact Details Form</th>
					<td>
						<select id="take_details" name="take_details">
							<option value="no"<?php if ( !isset($surveyDetails['take_details']) ||  $surveyDetails['take_details'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($surveyDetails['take_details']) && $surveyDetails['take_details'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Send Notification Emails</th>
					<td>
						<select id="send_email" name="send_email">
							<option value="no"<?php if ( !isset($surveyDetails['"send_email"']) ||  $surveyDetails['"send_email"'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($surveyDetails['"send_email"']) && $surveyDetails['"send_email"'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row">Custom Email Template</th>
					<td><textarea rows="8" name="email_template" cols="40"><?php if ( isset($surveyDetails['email_template']) ) { echo $surveyDetails['email_template']; } ?></textarea></td>
					<td valign="top">The template of the email sent on notification. <Strong>If empty default one will be sent.</Strong>. <a href="#template_tokens">Click here</a> to see the tokens for replacement.</td>
				</tr>
			</tbody>
		</table>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Survey" id="submitbutton" />
		</p>
		
	</form>
	
</div>	
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>