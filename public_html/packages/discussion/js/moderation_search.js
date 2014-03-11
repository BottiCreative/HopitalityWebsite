ccm_DiscussionModerationSearch = {

init:function() {
	// uncheck recheck all
	$('#ccm-discussion-list-cb-all').click(function() {
		if ($(this).attr('checked') == 'checked') {
			$('.ccm-list-record input[type=checkbox]').attr('checked',true);
			$('#ccm-discussion-list-multiple-operations').attr('disabled',false);
		} else {
			$('.ccm-list-record input[type=checkbox]').attr('checked',false);
			$('#ccm-discussion-list-multiple-operations').attr('disabled',true);
		}
	});
	
	
	$("#ccm-discussion-moderation input[type=checkbox]").click(function(e) {
		if ($("#ccm-discussion-moderation input[type=checkbox]:checked").length > 0) {
			$('#ccm-discussion-list-multiple-operations').attr('disabled',false);
		} else {
			$('#ccm-discussion-list-multiple-operations').attr('disabled',true);
		}
	});
	
	$('#ccm-discussion-list-multiple-operations').change(function(){
		if(confirm(confirm_action)) {
			$('#ccm-discussion-moderation').submit();
		}
	});
}

};

$(document).ready(function() {
	ccm_DiscussionModerationSearch.init();
}); 