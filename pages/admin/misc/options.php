<div class="wrap">
	
	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Options</h2>	
	
	<?php if ( isset($successMessage) ){ ?>
		<div class="updated" id="question_added"><?php echo $successMessage; ?></div>
	<?php } ?>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	
	<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<table class="form-table">
			<tr>
				<th scope="row">Items Per Page</th>
				<td><select name="items">
						<option value="5" <?php if ($numberOfItems == 5){?> selected="yes"<?php }?>>5</option>
						<option value="10" <?php if ($numberOfItems == 10){?> selected="yes"<?php }?>>10</option>
						<option value="25" <?php if ($numberOfItems == 25){?> selected="yes"<?php }?>>25</option>
						<option value="100" <?php if ($numberOfItems == 100){?> selected="yes"<?php }?>>100</option>
				</select></td>
				<td>This is the number of items displayed on a page list.</td>
			</tr>
			<tr>
				<th scope="row">Notification Group</th>
				<td><select name="email_role">
						<option value="none" <?php if ( !isset($emailRole) || empty($emailRole) || $emailRole == 'none') { ?> selected="yes"<?php }?>>None</option>
						<?php foreach($wp_roles->role_names as $role => $name){ ?>
						<option value="<?php echo $role; ?>" <?php if ($emailRole == $role) { ?> selected="yes"<?php }?>><?php echo $name; ?></option>
						<?php } ?>
				</select></td>
				<td>This is the group of users you wish to send notification emails to. <b>If selected notification email is not used.</b></td>
			</tr>
			<tr>
				<th scope="row">Notification Email</th>
				<td><input type="text" name="email" value="<?php echo $email; ?>" size="30" /></td>
				<td>This is the email that notifications will be sent to, seperate by commas to have more than one. <b>Notification Group will be used instead of it is selected.</b></td>
			</tr>
			<tr>
				<th scope="row">From Email</th>
				<td><input type="text" name="from_email" value="<?php echo $fromEmail; ?>" size="30" /></td>
				<td>This is the email from address that is used by the plugin anytime it sends an email..</td>
			</tr>
			<tr>
				<th scope="row">Custom Email Template</th>
				<td><textarea rows="8" name="email_template" cols="40"><?php echo $emailTemplate; ?></textarea></td>
				<td valign="top">The template of the email sent on notification. <Strong>If empty default one will be sent.</Strong>. <a href="#template_tokens">Click here</a> to see the tokens for replacement.</td>
			</tr>
			<tr>
				<th scope="row">Support Us!</th>
				<td><input type="radio" name="support_us" value="yes" id="support_yes" <?php if ($supportUs == 'yes'){ ?> checked="yes"<?php }?>> <label for="support_yes"><strong>Yes!</strong></label>
					<input type="radio" name="support_us" value="no" id="support_no" <?php if ($supportUs == 'no'){ ?> checked="yes"<?php }?>> <label for="support_no">No</label></td>
				<td valign="top">This will add a text link to the bottom of your pages.</td>
			</tr>
		</table>
	
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Quiz" id="submitbutton" />
		</p>
		
		<h3>Replacement Token</h3>
		
		<ul>
			<li><strong>%USER_NAME%</strong> - Name of the user who has taken the quiz/survey.</li>
			<li><strong>%QUIZ_NAME%</strong> - Name of the quiz that has been taken. <strong>Same as %SURVEY_NAME%</strong></li>
			<li><strong>%SURVEY_NAME%</strong> - Name of the survey that has been taken. <strong>Same as %QUIZ_NAME%</strong></li>
			<li><strong>%DATE_EU%</strong> - Date the quiz/survey was taken in EU format.</li>
			<li><strong>%DATE_US%</strong> - Date the quiz/survey was taken in US format.</li>
			<li><strong>%SCORE%</strong> - Score gained in quiz (only works if automarking is enabled)</li>
			<li><strong>%RESULT_URL%</strong> - The URL to view the quiz/survey result.</li>
			<li><strong>%DATETIME_EU%</strong> - Datetime the quiz/survey was taken in EU format.</li>
			<li><strong>%DATETIME_US%</strong> - Datetime the quiz/survey was taken in US format.</li>
			<li><strong>%USERMETA_{METANAME}%</strong> - The value of usermeta which matches the replacement for "{METANAME}" for the user who taken the quiz/survey.</li>
			<li><strong>%IP_ADDRESS%</strong> - The IP address of the user who has taken quiz/survey.</li>
			<li><strong>%HOSTNAME%</strong> - Hostname of the IP address of the user who has taken the quiz/survey.</li>
			<li><strong>%USER_AGENT%</strong> - User agent of the user who has taken the quiz/survey.</li>
		</ul>
		
	</form>
	
</div>	
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>