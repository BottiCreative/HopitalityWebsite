/**
	* @ concrete5 package AutonavPro
	* @copyright  Copyright (c) 2013 Hostco. (http://www.hostco.com)  	
*/
$(function() {
		$('.drop_a_custompro').click(function(e) {
			e.preventDefault();
			var dropParent = $(this).parent();
			$(dropParent).toggleClass('open');
			//remove 'open' class from childrens on nav close
			if($(dropParent).hasClass('open')==false){
				$(dropParent).find('li').removeClass('open');
				$(dropParent).siblings('.nav-dropdown').removeClass('open');
				$(dropParent).siblings('.nav-dropdown').find('li').removeClass('open');				
			}
			else{
				$(dropParent).siblings('.nav-dropdown').removeClass('open');
				$(dropParent).siblings('.nav-dropdown').find('li').removeClass('open');
				}
			});	
				
		$(".pronav_btn_navbar").click(function(e) {
		e.preventDefault();
		var pronavCollapseParent = $(this).parent();
		$(pronavCollapseParent).find('.pronav_collapse').toggle("slow");
		e.stopPropagation();	
		});	
	
	});
