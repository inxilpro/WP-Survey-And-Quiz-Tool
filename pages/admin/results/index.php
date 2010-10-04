<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Results</h2>
	
	<div class="tablenav">
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>
	</div>
	
	<table class="widefat">
		<thead>
			<tr>
				<th>ID</th>
				<th>Quiz</th>
				<th>Name</th>
				<th>IP</th>
				<th>Timestamp</th>
				<th>Current Status</th>
				<th>Mark</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>ID</th>
				<th>Quiz</th>
				<th>Name</th>
				<th>IP</th>
				<th>Timestamp</th>
				<th>Current Status</th>
				<th>Mark</th>
				<th>Delete</th>
			</tr>
		</tfoot>
		<tbody>
			<?php 
				if ( empty($results) ){
					?><tr>
						<td colspan="8"><center>No Results to view!</center></td>
					  </tr>
					<?php 
				}
				else{
					
					foreach($results as $result){ ?>
			<tr>
				<td><?php echo $result['id']; ?></td>
				<td><?php echo $result['name']; ?></td>
				<td><?php echo htmlentities($result['person_name']); ?></td>
				<td><?php echo $result['ipaddress']; ?></td>
				<td><?php echo $result['timestamp']; ?></td>
				<td><font color="<?php echo ($result['status'] != 'Unviewed') ? ($result['status'] == 'Accepted') ? '#00FF00' : '#FF0000' : '#000000'; ?>"><?php echo $result['status']; ?></font></td>
				<td valign="middle" align="center">
				<?php if ($result['status'] == 'Unviewed') {?>
				<a href="admin.php?page=<?php echo WPSQT_PAGE_QUIZ_RESULTS; ?>&action=mark&resultid=<?php echo $result['id']; ?>" class="button-secondary">Mark</a><?php }
				 else { ?> 
				<a href="admin.php?page=<?php echo WPSQT_PAGE_QUIZ_RESULTS; ?>&action=mark&resultid=<?php echo $result['id']; ?>"><?php echo $result['mark'].'/'.$result['total'];?></a>
				<?php  } ?>
				</td>
				<td valign="middle" align="center"><a href="admin.php?page=<?php echo WPSQT_PAGE_QUIZ_RESULTS; ?>&action=delete&resultid=<?php echo $result['id']; ?>" class="button-secondary">Delete</a></td>
			</tr>
			<?php 	}
				} ?>
		</tbody>
	</table>
	
	<div class="tablenav">
		<div class="tablenav-pages">
		   <?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>
		</div>
	</div>

</div>