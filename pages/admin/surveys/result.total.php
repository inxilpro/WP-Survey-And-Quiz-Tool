<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Survey Results</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	
	<?php if ( $sections == false ) { ?>
	
		<p>There are no results for this survey yet.</p>
	
	<?php } else { ?>
	
		<?php foreach ( $sections as $sectionKey => $secton ){
				foreach ( $secton['questions'] as $questonKey => $question ) {
			?> 
				<h3><?php echo $question['name']; ?></h3>
				
				<?php if ( $question['type'] == "Multiple Choice" ||
						   $question['type'] == "Dropdown" ) { 
							$googleChartUrl = 'http://chart.apis.google.com/chart?chs=293x185&cht=p';
							$valueArray    = array();
							$nameArray     = array();
						   foreach ( $question['answers'] as $answer ) {
						   		$nameArray[] = $answer['text'];
								$valueArray[] = $answer['count'];
						   }
			 
							$googleChartUrl .= '&chd=t:'.implode(',', $valueArray);
							$googleChartUrl .= '&chdl='.implode('|',$nameArray);
							$googleChartUrl .= '&chtt='.$question['name'];
							?>
			 
							<img src="<?php echo $googleChartUrl; ?>" alt="<?php echo $question['name']; ?>" />
					<?php } else if ($question['type'] == "Free Text") { 
					
							$i = 1; // Variable used to count answers - used later
							
							?> <em>All answers for this question</em> <?php
							
							foreach($uncachedresults as $uresult) {
								$usection = unserialize($uresult['sections']);
								
								foreach($usection as $result) {
									
									foreach($result['answers'] as $uanswerkey => $uanswer) {
										if($uanswerkey == $questonKey && in_array($uanswerkey, $freetextq)) {
											echo '<p>'.$i.') '.$uanswer['given'][0].'</p>';
											$i++;
										}
										
									}
								}
								
							}
						  } else {
								echo 'Something went really wrong, please report this bug to the forum. Here\'s a var dump which might make you feel better.<pre>'; var_dump($question); echo '</pre>';
						  } ?>	
				
		<?php }
		}
	} ?>	
	
</div>	
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>