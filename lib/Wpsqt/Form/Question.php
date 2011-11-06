<?php
require_once WPSQT_DIR.'lib/Wpsqt/Form.php';


/**
 * The form for adding new questions, should be usable 
 * by both quiz and surveys.
 * 
 * @author Iain Cambridge
 * @copyright Fubra Limited 2010-2011, all rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html GPL v3 
 * @package WPSQT
 */

class Wpsqt_Form_Question extends Wpsqt_Form {
	
	/**
	 * Builds the question form.
	 * 
	 * @param array $questionTypes The array of question types, should have the name of the type as the key and the description of the question type as the value.
	 * @param array $sections The array of sections. Values as the values for this one.
	 * @param array $options The array of values for the fields in the form. If it's empty we'll build a basic one to avoid undefined indexes all over the place.
	 */
	public function __construct( $questionTypes, $sections, $options = array() ){
		if ( empty($options) ) {
			$options = array('question' => false,
							 'type' => false,
							 'points' => false,
							 'difficulty' => false,
							 'section' => false,
							 'add_text' => false,
							 'required' => false,
					 		 'image' => false,
					 		 'likertscale' => false);
		}
		$typeHelpText = "";
		foreach ( $questionTypes as $type => $text ){
			$typeHelpText .= "<strong>".$type."</strong> ".$text."<br />";
		}
		
		
		$this->addOption("wpsqt_name", "Question", "text", $options['question'], "The text for the question (the actual question)." )
			 ->addOption("wpsqt_type", "Type", "select", $options['type'], $typeHelpText, array_keys($questionTypes) );
			 
		if(array_key_exists('Likert', $questionTypes)) {
			$this->addOption("wpsqt_likertscale", "Likert Scale", "select", $options['likertscale'], "What should the likert display to?", array('10', '5', '3', 'Agree/Disagree') );
		}
			 
		$this->addOption("wpsqt_points", "Points", "select", $options['points'], "How many points the question is worth.", range(1,10))
			 ->addOption("wpsqt_difficulty", "Difficulty", "select", $options['difficulty'], "The difficulty of the question.", array('Easy','Medium','Hard'))
			 ->addOption("wpsqt_section", "Section", "select", $options['section'], "The section/page this question should be in/on.", $sections)
			 ->addOption("wpsqt_required", "Required", "yesno", $options['required'], "Should the user be forced to answer the question to progress to the next step?")
			 ->addOption("wpsqt_add_text", "Additional Text", "textarea", $options['add_text'], "Additional text/html for questions, good for using html to display images.",array(),false)
			 ->addOption("wpsqt_image", "Image", "image", $options['image'], "The image that is to be associated with the question.", array(),  false );
			
		$this->options = $options;
		apply_filters("wpsqt_form_question", $this);
		
	}
	
}