<div class="wrap">

	<div id="icon-tools" class="icon32"></div>
	<h2>WP Survey And Quiz Tool - Survey Results</h2>
		
	<?php require WPSQT_DIR.'pages/admin/misc/navbar.php'; ?>
	
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
				<?php } else { ?>
						<?php var_dump($question); ?>
				<?php } ?>	
			
	<?php }
	} ?>	
	
</div>	
<?php require_once WPSQT_DIR.'/pages/admin/shared/image.php'; ?>