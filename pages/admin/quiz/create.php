<?php global $blog_id; ?>
<div class="wrap">

	<?php if ( isset($successMessage) ) {?>
		<div class='updated'><?php echo $successMessage; ?></div>
				
	<?php } ?>
	<div id="icon-tools" class="icon32"></div>
	<h2>
		WP Survey And Quiz Tool - Create Quiz
	</h2>
	
	<?php if ( isset($errorArray) && !empty($errorArray) ) { ?>
		<ul class="error">
			<?php foreach($errorArray as $error ){ ?>
				<li><?php echo $error; ?></li>
			<?php } ?>
		</ul>
	<?php } ?>
	<form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="quiz_form">
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />		
		<input type="hidden" name="action" value="<?php echo htmlentities($_REQUEST['action']); ?>"  />
	
		<table class="form-table" id="question_form">
			<tbody>
				<tr>
					<th scope="row">Name</th>
					<td valign="top"><input id="quiz_name" maxlength="255" size="50" name="quiz_name" value="<?php if ( isset($quizDetails['name']) ) { echo stripcslashes($quizDetails['name']); } ?>" /></td>
					<td>What you would like the quiz to be called.</td>
				</tr>
				<tr>
					<th scope="row">Complete Notification</th>
					<td valign="top">
						<select id="notification_type" name="notification_type">
							<option value="instant"<?php if ( isset($quizDetails['notification_type']) &&  $quizDetails['notification_type'] == 'instant' ){?> selected="selected"<?php }?>>Instant</option>
							<option value="instant-100"<?php if ( isset($quizDetails['notification_type']) &&   $quizDetails['notification_type'] == 'instant-100' ){?> selected="selected"<?php }?>>Instant if 100% correct</option>
							<option value="instant-75"<?php if ( isset($quizDetails['notification_type']) &&   $quizDetails['notification_type'] == 'instant-75' ){?> selected="selected"<?php }?>>Instant if 75% correct</option>
							<option value="instant-50"<?php if ( isset($quizDetails['notification_type']) &&   $quizDetails['notification_type'] == 'instant-50' ){?> selected="selected"<?php }?>>Instant if 50% correct</option>
							<option value="hourly"<?php if ( isset($quizDetails['notification_type']) &&  $quizDetails['notification_type'] == 'hourly' ){?> selected="selected"<?php }?>>Batched - Hourly</option>
							<option value="daily"<?php if ( isset($quizDetails['notification_type']) &&  $quizDetails['notification_type'] == 'daily' ){?> selected="selected"<?php }?>>Batched - Daily</option>
							<option value="none"<?php if ( !isset($quizDetails['notification_type']) ||  $quizDetails['notification_type'] == 'none' ){?> selected="selected"<?php }?>>None</option>
						</select>
					</td>
					<td>Send a notification email of completion.</td>
				</tr>
				<tr>
					<th scope="row">Limit To One Submission</th>
					<td valign="top">
						<input type="radio" name="limit_submission" value="no" <?php if ( !isset($quizDetails['limit_submission']) || $quizDetails['limit_submission'] == 'no' ){ ?> selected="selected"<?php } ?> id="limit_submission_no" />
						<label for="limit_submission_no">No</label>
						<input type="radio" name="limit_submission" value="yes" <?php if ( isset($quizDetails['limit_submission']) && $quizDetails['limit_submission'] == 'yes' ) {?> selected="selected"<?php } ?> id="limit_submission_yes" />
						<label for="limit_submission_yes">Yes</label>
					</td>
				<tr>
					<th scope="row">Display Result On Completion</th>
					<td valign="top">
						<select id="display_result" name="display_result">
							<option value="no"<?php if ( !isset($quizDetails['display_result']) ||  $quizDetails['display_result'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($quizDetails['display_result']) &&  $quizDetails['display_result'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
					<td>Display the results of the quiz upon the user completing the quiz.</td>
				</tr>
				<tr>
					<th scope="row">Display Review of Results On Completion</th>
					<td valign="top">
						<select id="display_result" name="display_review">
							<option value="no"<?php if ( !isset($quizDetails['display_review']) ||  $quizDetails['display_review'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($quizDetails['display_review']) &&  $quizDetails['display_review'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
					<td>Display the review results of the quiz upon the user completing the quiz, requires automarking. Will show the user what answers they gave aswell as what answers are correct. <b>NOTE : If the above setting is yes, this will not be shown as it takes precedent.</b></td>
				</tr>
				<tr>
					<th scope="row">Status</th>
					<td valign="top">
						<select id="status" name="status">
							<option value="enabled"<?php if ( !isset($quizDetails['status']) ||  $quizDetails['status'] == 'enabled' ){?> selected="selected"<?php }?>>Enabled</option>
							<option value="disabled"<?php if ( isset($quizDetails['status']) && $quizDetails['status'] == 'disabled' ){?> selected="selected"<?php }?>>Disabled</option>
						</select>
					</td>
					<td>Status of the quiz ethier enabled where users can take it or disabled where users can't.</td>
				</tr>
				<tr>
					<th scope="row">Contact Details Form</th>
					<td valign="top">
						<select id="take_details" name="take_details">
							<option value="no"<?php if ( !isset($quizDetails['take_details']) ||  $quizDetails['take_details'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($quizDetails['take_details']) && $quizDetails['take_details'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
					<td>This will show a form for users to enter their contact details before proceeding</td>
				</tr>
				<tr>
					<th scope="row">Use Wordpress User Details</th>
					<td valign="top">
						<select id="use_wp_user" name="use_wp_user">
							<option value="no"<?php if ( !isset($quizDetails['use_wp_user']) ||  $quizDetails['use_wp_user'] == 'no' ){?> selected="selected"<?php }?>>No</option>
							<option value="yes"<?php if ( isset($quizDetails['use_wp_user']) && $quizDetails['use_wp_user'] == 'yes' ){?> selected="selected"<?php }?>>Yes</option>
						</select>
					</td>
					<td>This will allow you to have the Quiz to use the user details for signed in users of your blog. If enabled the contact form will not be shown if enabled.</td>
				</tr>
				<?php if ( isset($quizId) ){ ?>
				<tr>
					<th scope="row">Custom Pages Directory</th>
					<td valign="top"><span style="background-color : #F2F5A9 ;"><?php echo WPSQT_DIR; ?>/pages/custom/<?php echo $blog_id; ?>/quiz-<?php echo $quizId; ?>/</span></td>
					<td>This is were you can place new page views to replace the default page view.</td>
				</tr>
				<?php } ?>
			<tr>
				<th scope="row">Custom Email Template</th>
				<td><textarea rows="8" name="email_template" cols="40"><?php if ( isset($quizDetails['email_template']) ) { echo $quizDetails['email_template']; } ?></textarea></td>
				<td valign="top">The template of the email sent on notification. <Strong>If empty default one will be sent.</Strong>. <a href="#template_tokens">Click here</a> to see the tokens for replacement.</td>
			</tr>
			</tbody>
		</table>
		
		<p class="submit">
			<input class="button-primary" type="submit" name="Save" value="Save Quiz" id="submitbutton" />
		</p>
		
	</form>
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
		
	
</div>	
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>