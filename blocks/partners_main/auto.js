ccmValidateBlockForm = function() {
	
	if ($('#field_1_image_fID-fm-value').val() == '' || $('#field_1_image_fID-fm-value').val() == 0) {
		ccm_addError('Missing required image: Partner Logo');
	}

	if ($('#field_2_textbox_text').val() == '') {
		ccm_addError('Missing required text: Partner Name');
	}

	if ($('input[name=field_5_link_cID]').val() == '' || $('input[name=field_5_link_cID]').val() == 0) {
		ccm_addError('Missing required link: Link to Profile');
	}


	return false;
}
