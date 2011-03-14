<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Questions</h2>
	
	<div class="tablenav">
		<?php if ( isset($_GET["id"]) ){ ?>
		<div class="alignleft">
			<a href="<?php echo WPSQT_URL_MAIN; ?>&type=quiz&action=question-add&id=<?php echo esc_html($_GET["id"]); ?>" class="button-secondary" title="Add New Question">Add New Question</a>
		</div>
		<?php } ?>		
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>
	</div>
	
	<table class="widefat">
		<thead>
			<tr>
				<th>ID</th>
				<th>Question</th>
				<th>Type</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Question</th>
				<th>Type</th>
				<th>Edit</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
			<?php if ( empty($questions) ) { ?>			
				<tr>
					<td colspan="5"><div style="text-align: center;">No questions yet!</div></td>
				</tr>
			<?php }
				  else {
				  	
					foreach ($questions as $question) { ?>
			<tr>
				<td><?php echo $question["id"]; ?></td>
				<td><?php echo stripslashes($question["text"]); ?></td>
				<td><?php echo ucfirst( stripslashes($question["type"]) ); ?></td>
				<td><a href="<?php echo WPSQT_URL_MAIN; ?>&type=quiz&action=question-edit&id=<?php echo $question["quizid"]; ?>&questionid=<?php echo $question["id"]; ?>" class="button-secondary" title="Edit Question">Edit</a></td>
				<td><a href="<?php echo WPSQT_URL_MAIN; ?>&type=quiz&action=question-delete&id=<?php echo $question["quizid"]; ?>&questionid=<?php echo $question["id"]; ?>" class="button-secondary" title="Delete Question">Delete</a></td>
			</tr>
			<?php } 
				 }?>
		</tbody>
	</table>

	<div class="tablenav">
		<?php if ( isset($_GET["id"]) ){ ?>
		<div class="alignleft">
			<a href="<?php echo WPSQT_URL_MAIN; ?>&type=quiz&action=question-add&id=<?php echo esc_html($_GET["id"]); ?>" class="button-secondary" title="Add New Question">Add New Question</a>
		</div>
		<?php } ?>		
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>		
	</div>

</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>