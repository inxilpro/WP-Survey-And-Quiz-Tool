<?php

class Wpsqt_Top_Widget extends WP_Widget {

	var $opts;
	
	function Wpsqt_Top_Widget() {
		$widget_ops = array('classname' => 'Wpsqt_Top_Widget', 'description' => 'Top Scores');
		$this->WP_Widget('Wpsqt_Top_Widget', 'Top Scores', $widget_ops);
	}
	
	function form($instance) {
		$instance = wp_parse_args((array) $instance, array('title' => '', 'quiz_id' => '3'));
		$title = $instance['title'];
		$quiz_id = $instance['quiz_id'];
?>
	<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
	<p><label for="<?php echo $this->get_field_id('quiz_id'); ?>">Quiz ID: <input class="widefat" id="<?php echo $this->get_field_id('quiz_id'); ?>" name="<?php echo $this->get_field_name('quiz_id'); ?>" type="text" value="<?php echo attribute_escape($quiz_id); ?>" /></label></p>
<?php
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['quiz_id'] = $new_instance['quiz_id'];
		return $instance;
	}
	
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		
		if (!empty($title))
			echo $before_title.$title.$after_title;
			
		echo 'Top scores for the quiz with id: '.$instance['quiz_id'];
		// Rest of widgety stuff
		
		echo $after_widget;
	}
}

