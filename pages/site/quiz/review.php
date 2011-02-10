<?php 
$currentPoints = 0; 
$totalPoints = 0;

?>
	<?php foreach ( $_SESSION['wpsqt'][$quizName]['quiz_sections'] as $section ){ ?>
		<h3><?php echo $section['name']; ?></h3>
		
		<?php
			if (!isset($section['questions'])){
				continue;
			}
			foreach ($section['questions'] as $questionKey => $questionArray){ ?>
			<h4><?php print stripslashes($questionArray['text']); ?></h4>
			<?php if ($questionArray['section_type'] == 'multiple'){
					if ( isset($section['answers'][$questionKey]['mark']) && $section['answers'][$questionKey]['mark'] == 'correct' ){
						$currentPoints += $questionArray['value'];
					}
					$totalPoints += $questionArray['value'];	
				?>				
				<b><u>Mark</u></b> - <?php if (isset($section['answers'][$questionKey]['mark'])) { echo $section['answers'][$questionKey]['mark']; } else { echo 'Incorrect'; } ?><br />
				<b><u>Answers</u></b>
				<p class="answer_given">
					<ol>
						<?php 
						
							foreach ($questionArray['answers'] as $answer){
						?>
							  <li><font color="<?php echo ( $answer['correct'] != 'yes' ) ?  (isset($section['answers'][$questionKey]['given']) &&  in_array($answer['id'], $section['answers'][$questionKey]['given']) ) ? '#FF0000' :  '#000000' : '#00FF00' ; ?>"><?php echo stripslashes($answer['text']) ?></font><?php if (isset($section['answers'][$questionKey]['given']) && in_array($answer['id'], $section['answers'][$questionKey]['given']) ){ ?> - Given<?php }?></li>
						<?php } ?>
					</ol>
				</p>
			<?php } else { continue; } ?>
		<?php } ?>
	<?php } ?>
	<p><font size="+3">Total Points <span id="total_points"><?php echo $currentPoints; ?></span> out of <?php echo $totalPoints; ?></font></p>
	