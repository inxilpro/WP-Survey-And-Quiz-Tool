<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Results</h2>
	
	
	
	<form method="post" action="">
	
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<div class="tablenav">
	
			<ul class="subsubsub">
				<li>
					<a href="<?php echo WPSQT_RESULT_URL; ?>" <?php if (isset($filter) && $filter == 'all') { ?>  class="current"<?php } ?> id="all_link">All <span class="count">(<?php echo $numbers['total']; ?>)</span></a> |			
				</li> 
				<li>
					<a href="<?php echo WPSQT_RESULT_URL; ?>&status=unviewed" <?php if (isset($filter) && $filter == 'unviewed') { ?>  class="current"<?php } ?> id="quiz_link">Unviewed <span class="count">(<?php echo $numbers['unviewed']; ?>)</span></a> |			
				</li> 
				<li>
					<a href="<?php echo WPSQT_RESULT_URL; ?>&status=accepted" <?php if (isset($filter) && $filter == 'accepted') { ?>  class="current"<?php } ?>  id="survey_link">Accepted <span class="count">(<?php echo $numbers['accepted']; ?>)</span></a> |		
				</li> 
				<li>
					<a href="<?php echo WPSQT_RESULT_URL; ?>&status=rejected" <?php if (isset($filter) && $filter == 'rejected') { ?>  class="current"<?php } ?>  id="survey_link">Rejected <span class="count">(<?php echo $numbers['rejected']; ?>)</span></a>			
				</li> 
			</ul>
			
			<div class="tablenav-pages">
		   		<?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>	
		   	</div>
		</div>
		
		
		<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th class="manage-column" scope="col" width="25">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
					<th scope="col" width="75">Status</th>
				</tr>			
			</thead>
			<tfoot>
				<tr>
					<th class="manage-column" scope="col" width="25">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
					<th scope="col" width="75">Status</th>
				</tr>			
			</tfoot>
			<tbody>
				<?php foreach( $results as $result ){ ?>			
				<tr>
					<th scope="row"><?php echo $result['id']; ?></th>
					<td class="column-title">
						<strong>
							<a class="row-title" href="<?php echo WPSQT_RESULT_URL;?>&subaction=mark&subid=<?php echo $result['id']; ?>"><?php echo htmlentities($result['person_name']); ?></a>
						</strong>
						<div class="row-actions">
							<span class="mark"><a href="<?php echo WPSQT_RESULT_URL;?>&subaction=mark&subid=<?php echo $result['id']; ?>">Mark</a> | </span>
							<span class="delete"><a href="<?php echo WPSQT_RESULT_URL;?>&subaction=delete&subid=<?php echo $result['id']; ?>">Delete</a></span>
						</div>
					</td>
					<td><font color="<?php if ( $result['status'] == 'Unviewed' ) {?>#000000<?php } elseif ( $result['status'] == 'Accepted' ){ ?>#00FF00<?php } else { ?>#FF0000<?php } ?>"><?php echo ucfirst($result['status']); ?></font></td>
					
				</tr>				
				<?php } ?>
			</tbody>
		</table>
		
		<div class="tablenav">
		
			<div class="tablenav-pages">			   
		   		<?php echo wpsqt_functions_pagenation_display($currentPage, $numberOfPages); ?>	
			</div>
		</div>
		
	</form>
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>