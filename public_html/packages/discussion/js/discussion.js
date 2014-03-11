var ccmDiscussion = {
	wrapper: $('<div/>'),
	totalAttachments: 0,
	cantSubmit:false,
	activeDialog:$('<div/>'),
	submit: function(form) {
		// Replace old method, it didn't work well.
		if (this.cantSubmit) {
			return false;
		}
		if(!$('input#subject').val()) {
			$('#ccm-discussion-post-errors .ccm-discussion-subject-error').show();
			return false;
		} else {
			$('#ccm-discussion-post-errors .ccm-discussion-subject-error').hide();
		}
		if(!$('textarea#message').val()) {
			$('#ccm-discussion-post-errors .ccm-discussion-message-error').show();
			return false;
		} else {
			$('#ccm-discussion-post-errors .ccm-discussion-message-error').hide();
		}
		this.cantSubmit = true;
		this.submittedForm = form;
		ccmDiscussion.showLoading();
		$("div#ccm-discussion-post-errors").html("");
		$(form).ajaxSubmit({
			success:function() {
				$.fn.dialog.closeTop();
				ccmDiscussion.reload();
			}
		});
		return false;
	},

	reload: function() {
		return ccmDiscussion.redirect();
	},

	response: function(data) {
		resp = eval("(" + data + ")");
		if (resp.errors) {
			ccmDiscussion.hideLoading();
			for(i = 0; i < resp.errors.length; i++) {
				$("div#ccm-discussion-post-errors").append(resp.errors[i] + '<br>');
			}

			if(resp.newCaptcha) {
				$('.ccm-captcha-image').attr('src',resp.newCaptcha);
				$('.ccm-input-captcha').val('');
			}

			this.cantSubmit=false;
		} else if (resp.redirect) {
			ccmDiscussion.redirect(resp.redirect);
		} else if (resp.pending) {
			$('form#discussion-post-form-form').hide();
			$('div#ccm-discussion-post-pending').show();
		}
	},

	init: function() {
		var ccd = $('#ccm-discussion-post-form-wrapper');
		ccmDiscussion.wrapper = ccd.clone(1,1);
		ccmDiscussion.bindTagSelect(ccmDiscussion.wrapper);
		ccd.empty();
	},

	redirect: function(redir) {
		if (redir == window.location.href || redir === undefined) {
			return window.location.reload();
		}
		window.location.href = redir;
	},

	bindTagSelect: function(ob) {
		var sel = ob.find('div.ccm-discussion-tags').find('input.ccm-attribute-type-select-autocomplete-text');
		if (sel.length == 0) return false;
		var id = sel.attr('name').replace(/\D+/,'');
		sel.keydown(function(e){
			if (e.keyCode == 13 || e.keyCode == 188) {
				e.preventDefault();
				e.stopPropagation();
				if($(this).val().length > 0) {
					window["ccmAttributeTypeSelectTagHelper"+id].add($(this).val());
					$(this).val('');
					$("#newAttrValueRows<?php echo $this->attributeKey->getAttributeKeyID()?>").autocomplete( "close" );
				}
				return false;
			}
		});
		return true;
	},

	postForm: function(cID) {
		this.cantSubmit=false;
		var wrapper = $('#ccm-discussion-post-form-wrapper').replaceWith(ccmDiscussion.wrapper.clone(1,1).show()).show();
		if (parseInt(cID) > 0) {
			$("input[name=cDiscussionPostParentID]").val(cID);
		}
		ccmDiscussion.bindTagSelect(wrapper);
		edToolbar(wrapper.find('textarea'));

		setTimeout(function() {
			window.location.hash = '#ccm-discussion-post-anchor';
		}, 100);

	},

	postOverlay: function(cID,uID,url,type) {
		this.cantSubmit=false;
		var wrapper = ccmDiscussion.wrapper.clone(1,1);
		var title = (type!=1?"Add Reply":"Add Discussion");
		$.get(url,{'cID':cID,'uID':uID,'type':type},function(form){
			wrapper.empty().html(form);
			ccmDiscussion.bindTagSelect(wrapper);
			edToolbar(wrapper.find('textarea#message'));
			dialog = wrapper.find('#ccm-discussion-post-form');
			ccmDiscussion.activeDialog = wrapper;
			$.fn.dialog.open({
				title: title,
				element: dialog,
				width: 550,
				modal: false,
				onClose: function() { ccmDiscussion.activeDialog = $('<div/>'); },
				height: 470
			});
			if (parseInt(cID) > 0) {
				$("input[name=cDiscussionPostParentID]").val(cID);
			}	
		});

	},

	clearPostForm: function() {
		var form = $("div#ccm-discussion-post-form");
		form.find("input#subject").val('');
		form.find("textarea#message").val("").text('');
		//$("div#ccm-discussion-post-form input#subject").get(0).focus();
		form.find("div.ccm-discussion-attachments-wrapper").html('');
		form.find("input[name=track]").attr('checked', true);
		form.find("input[name=cDiscussionPostID]").val(0);
	},

	showLoading: function() {
		ccmDiscussion.cantSubmit = true;
		$("#ccm-discussion-post-form .ccm-input-submit").get(0).disabled = true;
		$("div.ccm-discussion-post-loader").show();
	},

	hideLoading: function() {
		ccmDiscussion.canSubmit = true;
		$("#ccm-discussion-post-form .ccm-input-submit").get(0).disabled = false;
		$("div.ccm-discussion-post-loader").hide();
	},


	addAttachment: function() {
		ccmDiscussion.totalAttachments++;
		$(".ccm-discussion-add-attachment").html("Attach another file");
		var html = $(".ccm-discussion-attachments-selector").html();
		$(".ccm-discussion-attachments-wrapper").append(html);
	},

	removeAttachment: function(link) {
		ccmDiscussion.totalAttachments--;
		var p = $(link).parent();
		p.remove();

		if (ccmDiscussion.totalAttachments == 0) {
			$(".ccm-discussion-add-attachment").html("Attach a file");
		}
	},

	downloadAttachments: function(action) {
		$.fn.dialog.open({
			title: "Attachments",
			href: action,
			width: 400,
			modal: false,
			onClose: function() {
				$('#ccm-discussion-files-content').html('');
			},
			height: 300
		});
	},

	editReply: function(url, useOverlay) {
		this.cantSubmit=false;
		$.get(url, false, function(r) {
			var wrapper = ccmDiscussion.wrapper.clone(1,1);
			wrapper.empty().html(r);
			ccmDiscussion.bindTagSelect(wrapper);
			edToolbar(wrapper.find('textarea#message'));
			var dialog = wrapper.find("#ccm-discussion-post-form");
			if (useOverlay) {
				ccmDiscussion.activeDialog = wrapper;
				$.fn.dialog.open({
					title: "Edit",
					element: dialog,
					width: 550,
					modal: false,
					onClose: function() { ccmDiscussion.activeDialog = $('<div/>'); },
					height: 470
				},'html');
			} else {
				var wrapper = $('#ccm-discussion-post-form-wrapper').empty().html(r).show();
				ccmDiscussion.bindTagSelect(wrapper);
				edToolbar(wrapper.find('textarea'));
				setTimeout(function() {
					window.location.hash = '#ccm-discussion-post-anchor';
				}, 100);
			}
		});
	},

	changePostToPage: function(url) {
		$.fn.dialog.open({
			title: "Change Post to Page",
			replace: true,
			href: url,
			width: 500,
			modal: false,
			height: 400
		});

	},

	deletePost: function(url) {
		$.fn.dialog.open({
			title: "Delete",
			href: url,
			width: 300,
			modal: false,
			height: 200
		});
	}
}

ccmDiscussionTrack = {

	viewTrackOverlay: function(url, dotrackurl, removetrackurl) {
		if ($('.ui-widget').length > 0) {
			$("#ccm-dialog-content1").load(url);
		} else {
			var h = 'trackaction=' + encodeURIComponent(dotrackurl) + '&removetrackaction=' + encodeURIComponent(removetrackurl);
			var url = (url.indexOf('?') > -1) ? url + '&' + h : url + '?' + h;

			$.fn.dialog.open({
				title: "Monitor",
				replace: true,
				href: url,
				width: 300,
				modal: false,
				height: 260
			});
		}
	}
}

function showNextProfileOverlay(elem) {
	elem.next('.profile-preview-overlay').show();
}




ccmDiscussionBadges = {

	init : function () {
		$('a.ccm-show-badges-trigger').hover(
			function () { ccmDiscussionBadges.show($(this).attr('rel'),$(this))},
			function () { ccmDiscussionBadges.startHideTmr() }
		);
	},

	userInfoData:[{url:'',html:''}],
	show : function (url,linkElem) {

		ccmDiscussionBadges.clearHideTmr();
		linkElem.animate({opacity: 1.0}, 10,function() {

			ccmDiscussionBadges.clearHideTmr();

			var overLayWidth = 268;
			var de = document.documentElement;
			var w = self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
			var hasArea = w - (ccmDiscussionBadges.getAbsoluteLeft(linkElem) + ccmDiscussionBadges.getElementWidth(linkElem) + 30);
			var clickElementy = ccmDiscussionBadges.getAbsoluteTop(linkElem) - 50; //set y position

			if(hasArea > overLayWidth) {
				var clickElementx = ccmDiscussionBadges.getAbsoluteLeft(linkElem) + (ccmDiscussionBadges.getElementWidth(linkElem) + 5);
			} else {
				var clickElementx = ccmDiscussionBadges.getAbsoluteLeft(linkElem) - (overLayWidth + 5);
			}

			if(!$('#profile-preview-overlay').length) {
				$("body").append('<div class="profile-preview-overlay" id="profile-preview-overlay">'+
					'<div class="profile-preview-overlay-top"></div>'+
					'<div class="profile-preview-overlay-center" id="profile-preview-overlay-center-content">'+
						'<div id="profile-overlay-loader"></div>'+
					'</div>'+
					'<div class="profile-preview-overlay-bottom"></div>'+
					'</div>');
			}

			$('#profile-preview-overlay').css({left: clickElementx+"px", top: clickElementy+"px"});
				//$('#profile-preview-overlay').show();
			$('#profile-preview-overlay-center-content').html('Loading');//load(url);
			var userHTML;
			for(var i=0;i<ccmDiscussionBadges.userInfoData.length;i++){
				if(ccmDiscussionBadges.userInfoData[i].url==url){
					userHTML=ccmDiscussionBadges.userInfoData[i].userHTML;
					break;
				}
			}

			if(userHTML){
				$('#profile-preview-overlay-center-content').html(userHTML);
			}else{
				ccmDiscussionBadges.lastUserBadgeURL=url;
				$.get(url, '', function(r){
					$('#profile-preview-overlay-center-content').html(r);
					ccmDiscussionBadges.userInfoData.push({url:ccmDiscussionBadges.lastUserBadgeURL,userHTML:r})
				}, "HTML");
			}

			$('#profile-preview-overlay').mouseover(function(){ccmDiscussionBadges.clearHideTmr();});
			$('#profile-preview-overlay').mouseout(function(){ccmDiscussionBadges.startHideTmr();});
		});

	},

	hide : function () {
		if($('#profile-preview-overlay').length) {
			//$('div#profile-preview-overlay').animate({opacity: 1.0}, 2500,function() { // hack for setTimeout
				$('div#profile-preview-overlay').remove();
			//});
		}
	},

	clearHideTmr:function(){
		clearTimeout(ccmDiscussionBadges.popupTmr);
	},

	startHideTmr:function(){
		if($('#profile-preview-overlay-center-content').html()=='Loading')
			 setTimeout('ccmDiscussionBadges.startHideTmr()',3000);
		else ccmDiscussionBadges.popupTmr=setTimeout('ccmDiscussionBadges.hide()',1000);
	},

	getElementWidth : function(elem) {
		x = elem.get(0);
		return x.offsetWidth;
	},


	getAbsoluteLeft : function(linkElem) {
		// Get an object left position from the upper left viewport corner
		o = linkElem.get(0);
		oLeft = o.offsetLeft            // Get left position from the parent object
		 while(o.offsetParent!=null) {  // Parse the parent hierarchy up to the document element
			oParent = o.offsetParent    // Get parent object reference
			oLeft += oParent.offsetLeft // Add parent left position
			o = oParent
		}
		return oLeft
	},

	getAbsoluteTop : function(linkElem) {
		// Get an object top position from the upper left viewport corner
		//o = document.getElementById(objectId)
		o = linkElem.get(0);
		oTop = o.offsetTop           // Get top position from the parent object
		while(o.offsetParent!=null) { // Parse the parent hierarchy up to the document element
			oParent = o.offsetParent  // Get parent object reference
			oTop += oParent.offsetTop // Add parent top position
			o = oParent
		}
		return oTop
	},

	manage : function(url){
		$.fn.dialog.open({
			title: '',
			href: url,
			width: 550,
			modal: false,
			height: 400
		});
	},

	saveBadges : function(f){
		var url=f.action;
		var data=$(f).serialize();;
		$.post(url, data, function(r){
			$('#ccm-dialog-content0').html(r);
			window.location.reload(true);
		}, "HTML");
		return false;
	}
}
$(document).ready(function () { ccmDiscussion.init(); ccmDiscussionBadges.init() } );
