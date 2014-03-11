var relatedPages ={
	servicesDir: $("input[name=relatedPagesToolsDir]").val(),
	init:function(){
		this.blockForm=document.forms['ccm-block-form'];
		this.cParentIDRadios=this.blockForm.cParentID;
		for(var i=0;i<this.cParentIDRadios.length;i++){
			this.cParentIDRadios[i].onclick  = function(){ relatedPages.locationOtherShown(); }
			this.cParentIDRadios[i].onchange = function(){ relatedPages.locationOtherShown(); }			
		}
		
		this.truncateSwitch=$('#ccm-relatedpages-truncateSummariesOn');
		this.truncateSwitch.click(function(){ relatedPages.truncationShown(this); });
		this.truncateSwitch.change(function(){ relatedPages.truncationShown(this); });
		
		this.tabSetup();
	},	
	tabSetup: function(){
		$('ul#ccm-relatedpages-tabs li a').each( function(num,el){ 
			el.onclick=function(){
				var pane=this.id.replace('ccm-relatedpages-tab-','');
				relatedPages.showPane(pane);
			}
		});		
	},
	truncationShown:function(cb){ 
		var truncateTxt=$('#ccm-relatedpages-truncateTxt');
		var f=$('#ccm-relatedpages-truncateChars');
		if(cb.checked){
			truncateTxt.removeClass('faintText');
			f.attr('disabled',false);
		}else{
			truncateTxt.addClass('faintText');
			f.attr('disabled',true);
		}
	},
	showPane:function(pane){
		$('ul#ccm-relatedpages-tabs li').each(function(num,el){ $(el).removeClass('ccm-nav-active') });
		$(document.getElementById('ccm-relatedpages-tab-'+pane).parentNode).addClass('ccm-nav-active');
		$('div.ccm-relatedpagesPane').each(function(num,el){ el.style.display='none'; });
		$('#ccm-relatedpagesPane-'+pane).css('display','block');
		if(pane=='preview') this.loadPreview();
	},
	locationOtherShown:function(){
		for(var i=0;i<this.cParentIDRadios.length;i++){
			if( this.cParentIDRadios[i].checked && this.cParentIDRadios[i].value=='OTHER' ){
				$('div.ccm-page-list-page-other').css('display','block');
				return; 
			}				
		}
		$('div.ccm-page-list-page-other').css('display','none');
	},
	loadPreview:function(){
		var loaderHTML = '<div style="padding: 20px; text-align: center"><img src="' + CCM_IMAGE_PATH + '/throbber_white_32.gif"></div>';
		$('#ccm-relatedpagesPane-preview').html(loaderHTML);
		var qStr=$(this.blockForm).formSerialize();
		$.ajax({ 
			url: this.servicesDir+'preview_pane.php?'+qStr,
			success: function(msg){ $('#ccm-relatedpagesPane-preview').html(msg); }
		});
	},
	validate:function(){
			var failed=0;
			
			var rssOn=$('#ccm-relatedpages-rssSelectorOn');
			var rssTitle=$('#ccm-relatedpages-rssTitle');
			if( rssOn && rssOn.attr('checked') && rssTitle && rssTitle.val().length==0 ){
				alert(ccm_t('feed-name'));
				rssTitle.focus();
				failed=1;
			}
			
			if(failed){
				ccm_isBlockError=1;
				return false;
			}
			return true;
	}	
}
$(function(){ relatedPages.init(); });

ccmValidateBlockForm = function() { return relatedPages.validate(); }