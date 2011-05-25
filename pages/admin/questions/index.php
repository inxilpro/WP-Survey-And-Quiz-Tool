<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Questions</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	
	<?php if ( isset($_GET['new']) &&  $_GET['new'] == "true" ) { ?>
	<div class="updated">
		<strong>Question successfully added.</strong>
	</div>
	<?php } ?>
	
	<?php if ( isset($_GET['edit']) &&  $_GET['edit'] == "true" ) { ?>
	<div class="updated">
		<strong>Question successfully edited.</strong>
	</div>
	<?php } ?>
	
	<?php if ( isset($_GET['delete']) &&  $_GET['delete'] == "true" ) { ?>
	<div class="updated">
		<strong>Question successfully deleted.</strong>
	</div>
	<?php } ?>
	<ul class="subsubsub">
		<?php foreach ( $question_types as $type ){ 
				$friendlyType = str_replace(' ', '', $type);
			?>			
			<li>
				<a href="<?php echo WPSQT_URL_MAIN; ?>&section=questions&subsection=<?php echo urlencode($_GET['subsection']); ?>&type=<?php echo $type; ?>" <?php if (isset($_GET['type']) && $type == $_GET['type']) { ?>  class="current"<?php } ?>><?php echo $type; ?> <span class="count">(<?php echo $question_counts[$friendlyType.'_count']; ?>)</span></a>
			</li>
		<?php } ?>
	</ul>
	<div class="tablenav">
	
		
	
		<?php if ( isset($_GET['id']) ){ ?>
		<div class="alignleft">
			<a href="<?php echo WPSQT_URL_MAIN; ?>&section=questionadd&subsection=<?php esc_html_e($_GET['subsection']); ?>&id=<?php esc_html_e($_GET['id']); ?>" class="button-secondary" title="Add New Question">Add New Question</a>
		</div>
		<?php } ?>		
		<div class="tablenav-pages">
		   <?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages);  ?>
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
				  	$count = 0;
					foreach ($questions as $rawQuestion) { 
						$count++;
						$question = Wpsqt_System::unserializeQuestion($rawQuestion, $_GET['subsection']);
						?>
			<tr class="<?php echo ( $count % 2 ) ?  'wpsqt-odd' : 'wpsqt-even'; ?>">
				<td><?php echo $question['id']; ?></td>
				<td><?php echo stripslashes($question['name']); ?></td>
				<td><?php echo ucfirst( stripslashes($question['type']) ); ?></td>
				<td><a href="<?php echo WPSQT_URL_MAIN; ?>&section=questionedit&subsection=<?php esc_html_e($_GET['subsection']); ?>&id=<?php esc_html_e($_GET['id']); ?>&questionid=<?php esc_html_e($question['id']); ?>" class="button-secondary" title="Edit Question">Edit</a></td>
				<td><a href="<?php echo WPSQT_URL_MAIN; ?>&section=questiondelete&subsection=<?php esc_html_e($_GET['subsection']); ?>&id=<?php esc_html_e($_GET['id']); ?>&questionid=<?php esc_html_e($question['id']); ?>" class="button-secondary" title="Delete Question">Delete</a></td>
			</tr>
			<?php } 
				 }?>
		</tbody>
	</table>

	<div class="tablenav">
		<?php if ( isset($_GET['id']) ){ ?>
		<div class="alignleft">
			<a href="<?php echo WPSQT_URL_MAIN; ?>&section=questionadd&subsection=<?php esc_html_e($_GET['subsection']); ?>&id=<?php esc_html_e($_GET['id']); ?>" class="button-secondary" title="Add New Question">Add New Question</a>
		</div>
		<?php } ?>		
		<div class="tablenav-pages">
		   <?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>
		</div>		
	</div>

</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>