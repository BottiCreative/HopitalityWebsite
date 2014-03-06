ccmValidateBlockForm = function() {
	
	if ($('#field_1_textbox_text').val() == '') {
		ccm_addError('Missing required text: Partners Name');
	}

	if ($('input[name=field_2_link_cID]').val() == '' || $('input[name=field_2_link_cID]').val() == 0) {
		ccm_addError('Missing required link: Link To profile');
	}

	if ($('#field_3_image_fID-fm-value').val() == '' || $('#field_3_image_fID-fm-value').val() == 0) {
		ccm_addError('Missing required image: Partner Logo');
	}

	if ($('#field_4_textarea_text').val() == '') {
		ccm_addError('Missing required text: Partner Description');
	}


	return false;
}
