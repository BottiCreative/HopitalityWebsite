ccmValidateBlockForm = function() {
	
	if ($('#field_1_textbox_text').val() == '') {
		ccm_addError('Missing required text: Testimonial Name');
	}

	if ($('#field_5_textarea_text').val() == '') {
		ccm_addError('Missing required text: Testimonial Body');
	}


	return false;
}
