var downloadsList = {
	tabSetup: function(){
		$('ul#ccm-downloadsblock-tabs li a').each( function(num,el){ 
			el.onclick=function(){
				var pane=this.id.replace('ccm-downloadsblock-tab-','');
				downloadsList.showPane(pane);
			}
		});		
	},
	showPane:function(pane){
		$('ul#ccm-downloadsblock-tabs li').each(function(num,el){ $(el).removeClass('ccm-nav-active') });
		$(document.getElementById('ccm-downloadsblock-tab-'+pane).parentNode).addClass('ccm-nav-active');
		$('div.ccm-downloadsBlockPane').each(function(num,el){ el.style.display='none'; });
		$('#ccm-downloadsBlockPane-'+pane).css('display','block');
	}
}
function init_fileset_selector() {
	if ($('#all_files_checkbox').attr("checked")) {
		$('.swp-downloads-list-filesets').hide();
		$('.swp-downloads-list-all-files-alert').show();
	} else {
		$('.swp-downloads-list-filesets').show();
		$('.swp-downloads-list-all-files-alert').hide();
	}
}
function init_sortby_attr_selector() {
	if ($('#swp-dl-sortBySelector').val() == "attribute") {
		$('.swp-downloads-list-sortby-attrs').show();
	} else {
		$('.swp-downloads-list-sortby-attrs').hide();
	}
}
$(function() {
	downloadsList.tabSetup();
	$('#all_files_checkbox').click(init_fileset_selector);
	init_fileset_selector();
	$('#swp-dl-sortBySelector').change(init_sortby_attr_selector);
	init_sortby_attr_selector();
});