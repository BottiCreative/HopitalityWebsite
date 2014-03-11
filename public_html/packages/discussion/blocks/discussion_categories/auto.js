var discussionWrapper ={

	init:function() {
		this.blockForm=document.forms['ccm-block-form'];
		this.cThisRadios=this.blockForm.cThis;
		for(var i=0;i<this.cThisRadios.length;i++){
			this.cThisRadios[i].onclick  = function(){ discussionWrapper.locationOtherShown(); }
		}
		
	},	

	locationOtherShown:function(){
		for(var i=0;i<this.cThisRadios.length;i++){
			if( this.cThisRadios[i].checked && this.cThisRadios[i].value=='0' ){
				$('#ccm-discussion-selected-page-wrapper').css('display','block');
				return; 
			}
		}
		$('#ccm-discussion-selected-page-wrapper').css('display','none');
		$('#ccm-discussion-selected-user-wrapper').css('display','none');
	}

};

ccm_selectSitemapNode = function(cID, cName) {
	$("#ccm-discussion-underCName").html(cName);
	$("#ccm-discussion-cValueField").val(cID);
}

ccm_triggerSelectUser = function(uID, uName) {
	$("#ccm-discussion-underUName").html(uName);
	$("#ccm-discussion-userValueField").val(uID);
}


/*
ccm_selectSitemapNode = function(cID, cName) {
	$("#ccm-discussion-underCName").html(cName);
	$("#ccm-discussion-cValueField").val(cID);
}
*/


$(function() { discussionWrapper.init(); });