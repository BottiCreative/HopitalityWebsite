var postList ={
	servicesDir: $("input[name=postListToolsDir]").val(),
	init:function(){
		this.blockForm=document.forms['ccm-block-form'];
		this.cParentIDRadios=this.blockForm.cParentID;
		for(var i=0;i<this.cParentIDRadios.length;i++){
			this.cParentIDRadios[i].onclick  = function(){ postList.locationOtherShown(); }
			this.cParentIDRadios[i].onchange = function(){ postList.locationOtherShown(); }			
		}
		
		this.truncateSwitch=$('#ccm-discussion-postlist-truncateSummariesOn');
		this.truncateSwitch.click(function(){ postList.truncationShown(this); });
		this.truncateSwitch.change(function(){ postList.truncationShown(this); });
		
		$('input[name="tagFilter"]').change(function() {
			if($(this).val() == 'specific') {
				$('#tag-selector-form').show();
			} else {
				$('#tag-selector-form').hide();
			}
		});
		
		if($('#tagFilter3').attr('checked')) { $('#tag-selector-form').show(); }
		
		this.tabSetup();
		this.loadPreview();
	},	
	
	tabSetup: function(){
		$('ul#ccm-discussion-postlist-tabs li a').each( function(num,el){ 
			el.onclick=function(){
				var pane=this.id.replace('ccm-discussion-postlist-tab-','');
				postList.showPane(pane);
			}
		});		
	},
	
	truncationShown:function(cb){ 
		var truncateTxt=$('#ccm-discussion-postlist-truncateTxt');
		var f=$('#ccm-discussion-postlist-truncateChars');
		if(cb.checked){
			truncateTxt.removeClass('faintText');
			f.attr('disabled',false);
		}else{
			truncateTxt.addClass('faintText');
			f.attr('disabled',true);
		}
	},
	
	showPane:function(pane){
		$('ul#ccm-discussion-postlist-tabs li').each(function(num,el){ $(el).removeClass('ccm-nav-active'); });
		$(document.getElementById('ccm-discussion-postlist-tab-'+pane).parentNode).addClass('ccm-nav-active');
		$('div.ccm-discussion-postlistPane').each(function(num,el){ el.style.display='none'; });
		$('#ccm-discussion-postlistPane-'+pane).css('display','block');
		if(pane=='preview') this.loadPreview();
	},
	locationOtherShown:function(){
		for(var i=0;i<this.cParentIDRadios.length;i++){
			if( this.cParentIDRadios[i].checked && this.cParentIDRadios[i].value=='OTHER' ){
				$('div.ccm-post-list-page-other').css('display','block');
				return; 
			}				
		}
		$('div.ccm-post-list-page-other').css('display','none');
	},
	loadPreview:function(){
		var loaderHTML = '<div style="padding: 20px; text-align: center"><img src="' + CCM_IMAGE_PATH + '/throbber_white_32.gif"></div>';
		$('#ccm-discussion-postlistPane-preview').html(loaderHTML);
		var qStr=$(this.blockForm).formSerialize();
		$.ajax({ 
			url: this.servicesDir+'preview_pane.php?'+qStr,
			success: function(msg){ $('#ccm-discussion-postlistPane-preview').html(msg); }
		});
	},
	validate:function(){
			// no validation as of yet
			var failed=0;
			if(failed){
				ccm_isBlockError=1;
				return false;
			}
			return true;
	}	
};

$(function(){ postList.init();} );

ccmValidateBlockForm = function() { return postList.validate(); }