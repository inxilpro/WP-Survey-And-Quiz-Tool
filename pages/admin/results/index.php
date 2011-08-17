<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Results</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>	
	
	<?php if ( isset($message) ) { ?>
	<div class="updated">
		<strong><?php echo $message; ?></strong>
	</div>
	<?php } ?>
	
	<form method="post" action="">
	
		<input type="hidden" name="wpsqt_nonce" value="<?php echo WPSQT_NONCE_CURRENT; ?>" />
		<div class="tablenav">
	
			<ul class="subsubsub">
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>" <?php if (isset($filter) && $filter == 'all') { ?>  class="current"<?php } ?> id="all_link">All <span class="count">(<?php echo $counts['unviewed_count'] + $counts['accepted_count'] + $counts['rejected_count']; ?>)</span></a> |			
				</li> 
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&status=unviewed" <?php if (isset($filter) && $filter == 'unviewed') { ?>  class="current"<?php } ?> id="quiz_link">Unviewed <span class="count">(<?php echo $counts['unviewed_count']; ?>)</span></a> |			
				</li> 
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&status=accepted" <?php if (isset($filter) && $filter == 'accepted') { ?>  class="current"<?php } ?>  id="survey_link">Accepted <span class="count">(<?php echo $counts['accepted_count']; ?>)</span></a> |		
				</li> 
				<li>
					<a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&status=rejected" <?php if (isset($filter) && $filter == 'rejected') { ?>  class="current"<?php } ?>  id="survey_link">Rejected <span class="count">(<?php echo $counts['rejected_count']; ?>)</span></a>			
				</li> 
			</ul>
			
			<div class="tablenav-pages">
		   		<?php echo Wpsqt_Core::getPaginationLinks($currentPage, $numberOfPages); ?>	
		   	</div>
		</div>
		
		
		<table class="widefat post fixed" cellspacing="0">
			<thead>
				<tr>
					<th class="manage-column" scope="col" width="35">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
					<th scope="col" width="75">Score</th>
					<th scope="col" width="90">Percentage</th>
					<th scope="col" width="75">Pass/Fail</th>
					<th scope="col" width="75">Status</th>
					<th scope="col" width="75">Date</th>
				</tr>			
			</thead>
			<tfoot>
				<tr>
					<th class="manage-column" scope="col" width="25">ID</th>
					<th class="manage-column column-title" scope="col">Title</th>
					<th scope="col" width="75">Score</th>
					<th scope="col" width="90">Percentage</th>
					<th scope="col" width="75">Pass/Fail</th>
					<th scope="col" width="75">Status</th>
					<th scope="col" width="75">Date</th>
				</tr>			
			</tfoot>
			<tbody>
				<?php foreach( $results as $result ){ ?>
				<tr>
					<th scope="row"><?php echo $result['id']; ?></th>
					<td class="column-title">
						<strong>
							<a class="row-title" href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>"><?php echo esc_html(wp_kses_stripslashes($result['person_name']));  if (isset($person['email'])){ ?> - <?php echo $person['email']; }  if (isset($result['ipaddress'])) { ?> - <?php  echo $result['ipaddress']; } ?></a>
						</strong>
						<div class="row-actions">
							<span class="mark"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=results&subsection=mark&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>">Mark</a> | </span>
							<span class="delete"><a href="<?php echo WPSQT_URL_MAIN; ?>&section=resultsdelete&subsection=quiz&id=<?php echo urlencode($_GET['id']); ?>&resultid=<?php echo $result['id']; ?>">Delete</a></span>
						</div>
					</td>
					<td><?php if($result['total'] == 0) {echo "Unable to auto mark";} else {echo $result['score']."/".$result['total'];} ?></td>
					<td><?php if($result['total'] == 0) {echo "Unable to auto mark";} else {echo $result['percentage']."%";} ?></td>
					<td><font color="<?php if ($result['pass'] == 1) {echo "green";} else {echo "#FF0000";} ?>"><?php if ($result['pass'] == 1) {echo "Pass";} else {echo "Fail";} ?></font></td>
					<td><font color="<?php if ( ucfirst($result['status']) == 'Unviewed' ) {?>#000000<?php } elseif ( $result['status'] == 'Accepted' ){ ?>green<?php } else { ?>#FF0000<?php } ?>"><?php echo ucfirst($result['status']); ?></font></td>
					<td><?php if (!empty($result['datetaken'])) { echo date('d-m-y G:i:s',$result['datetaken']); } else { echo '-'; } ?>
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