<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Results</h2>
	
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	
	
	
	<form method="post" action="">
	
		<div class="tablenav">
	
			<ul class="subsubsub">
				<li>
					<a href="<?php echo WPSQT_RESULT_URL; ?>" <?php if (isset($filter) && $filter == 'all') { ?>  class="current"<?php } ?> id="all_link">All <span class="count">(<?php echo $counts['unviewed_count']; ?>)</span></a>		
				</li> 
			</ul>
			
			<div class="tablenav-pages">			   
		   		<?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>	
			</div>
			
		</div>
		
		
		<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th class="manage-column" scope="col" width="25">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
				</tr>			
			</thead>
			<tfoot>
				<tr>
					<th class="manage-column" scope="col" width="25">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
				</tr>			
			</tfoot>
			<tbody>
				<?php foreach( $results as $result ){ ?>			
				<tr>
					<th scope="row"><?php echo $result['id']; ?></th>
					<td class="column-title">
						<strong>
							<a class="row-title" href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>"><?php echo htmlentities($result['person_name']); ?></a>
						</strong>
						<div class="row-actions">
							<span class="mark"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=view&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>">Mark</a> | </span>
							<span class="delete"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=resultsdelete&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>">Delete</a></span>
						</div>
					</td>
				</tr>				
				<?php } ?>
			</tbody>
		</table>
		
		<div class="tablenav">
		
			<div class="tablenav-pages">			   
		   		<?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>	
			</div>
		</div>
				
	</form>
</div>
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>