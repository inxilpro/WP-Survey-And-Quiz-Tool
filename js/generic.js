jQuery(document).ready( function(){

	jQuery('#add_section_quiz').click( function(){
		var rowCount = jQuery('#section_table tbody tr').length;
		var html = '';
		html += '<tr>';
		html += '<input type="hidden" name="sectionid['+rowCount+']" value="" />'
		html += '\t<td><input type="text" name="section_name['+rowCount+']" value="" size="30" id="name_'+rowCount+'" /></td>';
		html += '\t<td>';
		html += '\t\t<select name="difficulty['+rowCount+']" id="difficulty_'+rowCount+'">';
		html += '\t\t\t<option value="easy">Easy</option>';
		html += '\t\t\t<option value="medium" selected="selected">Medium</option>';
		html += '\t\t\t<option value="hard">Hard</option>';
		html += '\t\t\t<option value="mixed">Mixed</option>';
		html += '\t\t</select>';
		html += '\t</td>';
		html += '\t<td><input type="text" name="number['+rowCount+']" value="" size="10" id="number_'+rowCount+'" /></td>';
		html += '\t<td>';
		html += '\t\t<select name="order['+rowCount+']">';
		html += '\t\t\t<option value="random">Random</option>';
		html += '\t\t\t<option value="asc">Ascending</option>';
		html += '\t\t\t<option value="desc">Descending</option>';
		html += '\t\t</select>';
		html += '\t</td>';
		html += '\t<td>';
		html += '\t\t<input type="checkbox" name="delete['+rowCount+']" value="yes" size="10" id="delete_'+rowCount+'" />';
		html += '\t</td>';
		html += '</tr>';
		jQuery('#section_table tr:last').after(html);
		jQuery('#row_count').val(rowCount+1);
		
	});
	
	jQuery('#add_section_surveys').click( function(){
		var rowCount = jQuery('#section_table tbody tr').length;
		var html = '';
		html += '<tr>';
		html += '<input type="hidden" name="sectionid['+rowCount+']" value="" />'
		html += '\t<td><input type="text" name="section_name['+rowCount+']" value="" size="30" id="name_'+rowCount+'" /></td>';
		html += '\t<td><input type="text" name="number['+rowCount+']" value="" size="10" id="number_'+rowCount+'" /></td>';
		html += '\t<td>';
		html += '\t\t<select name="order['+rowCount+']">';
		html += '\t\t\t<option value="random">Random</option>';
		html += '\t\t\t<option value="asc">Ascending</option>';
		html += '\t\t\t<option value="desc">Descending</option>';
		html += '\t\t</select>';
		html += '\t</td>';
		html += '\t<td>';
		html += '\t\t<input type="checkbox" name="delete['+rowCount+']" value="yes" size="10" id="delete_'+rowCount+'" />';
		html += '\t</td>';
		html += '</tr>';
		jQuery('#section_table tr:last').after(html);
		jQuery('#row_count').val(rowCount+1);
		
	});	
	
	jQuery('#add_field').click( function(){
		var rowCount = jQuery('#multi_table tbody tr').length;
		var html = '';
		html += '<tr>';
		html += '<input type="hidden" name="formitemid['+rowCount+']" value="" />'
		html += '<td><input type="text" name="field_name['+rowCount+']" value="" /></td>';
		html += '<td><select name="type['+rowCount+']">';
		html += '<option value="text">Text</option>';
		html += '<option value="textarea">Textarea</option>';
		html += '</select></td>';
		html += '<td><select name="required['+rowCount+']">';
		html += '<option value="no">No</option>';
		html += '<option value="yes">Yes</option>';
		html += '</select></td>';
		html += '\t<td>';
		html += '<select name="validation['+rowCount+']">';
		jQuery('#validator_original option').each(function(item,object) {
			html += '<option>'+object.text+'</option>';
		});
		html += '</select>';
		html += '\t</td>';
		html += '\t<td>';
		html += '\t\t<input type="checkbox" name="delete['+rowCount+']" value="yes" size="10" id="delete_'+rowCount+'" />';
		html += '\t</td>';
		html += '</tr>';
		jQuery('#multi_table tbody tr:last').after(html);
		jQuery('#row_count').val(rowCount+1);
		
	});
	
	jQuery("#wpsqt_type").change( function(){ 
		
		questionType = jQuery('#wpsqt_type option:selected').val();
		
		// Quick hack to deal with two question types which are basically the same.
		if ( questionType.toLowerCase() == "single" ||
			 questionType.toLowerCase() == "dropdown" || 
			 questionType.toLowerCase() == "multiple choice" ) {
			questionType = "multiple";
		}
		
		jQuery('.sub_form').each(function() {
			jQuery(this).hide();	
		});
		
		jQuery("#sub_form_"+questionType.replace(" ", "").toLowerCase()).show();
		
	});
	
	jQuery('.sub_form').each(function() {
			var questionType = jQuery('#wpsqt_type option:selected').val();
			if ( questionType.toLowerCase() == "single" ||
			 questionType.toLowerCase() == "dropdown" || 
			 questionType.toLowerCase() == "multiple choice" ) {
				questionType = "multiple";
			}
			
			if ( jQuery(this).attr('id') != "sub_form_"+questionType.replace(" ", "").toLowerCase() ){ 
				jQuery(this).hide();	
			}
		});
	jQuery("#wsqt_multi_add").click( function(){
		var rowCount = jQuery('#sub_form_multiple tbody tr').length;
		var html = '';
		html += '<tr>';
		html += '<td><input type="text" name="multiple_name['+rowCount+']" value="" /></td>'; 
		html += '<td><input type="checkbox" name="multiple_correct['+rowCount+']"  value="yes" /></td>'; 
		html += '<td><input type="checkbox" name="multiple_delete['+rowCount+']" value="yes" /></td>';
		html += '</tr>';
		jQuery('#sub_form_multiple tbody tr:last').after(html);
		jQuery('#row_count').val(rowCount+1);
		return false;
	});
	
});



