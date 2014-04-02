(function($){  
	$.fn.watermark = function() {  
		var defaults = {  
			color: '#777'
		};       
	   var options = $.extend(defaults, options);  
		return this.each(function() {  
			var obj = $(this);
			obj.attr('baseColor', obj.css('color'));
			if(obj.attr('type')=='password') obj.val('password');
			if(!obj.attr('base')) obj.attr('base', obj.val());
			obj.attr('isWatermark', 1);
			obj.css('color', options.color);
			obj.bind('focus', function(){
				var o = $(this);
				if(o.val() != o.attr('base') && o.val() != ''){
					o.attr("isWatermark", 0);
				}
				if(o.attr('isWatermark') == 1){
					o.val('');
					o.attr('isWatermark', 0);
					o.css('color', o.attr('baseColor'));
				}
			}).bind('blur', function(){
				var o = $(this);
				if(o.val() != o.attr('base') && o.val() != ''){
					o.attr('isWatermark', 1);
				}
				if(o.attr('isWatermark') == 0){
					o.css("color",options.color);
					if(o.val() == ''){
						o.attr('isWatermark', 1);
						o.val(o.attr('base'));
					}
				}
			});
		});  
	};  
})(jQuery);


(function($) {
	var map=new Array();
	$.Watermark = {
		ShowAll:function(){
			for (var i=0;i<map.length;i++){
				if(map[i].obj.val()==""){
					map[i].obj.val(map[i].text);					
					map[i].obj.css("color",map[i].WatermarkColor);
				}else{
				    map[i].obj.css("color",map[i].DefaultColor);
				}
			}
		},
		HideAll:function(){
			for (var i=0;i<map.length;i++){
				if(map[i].obj.val()==map[i].text)
					map[i].obj.val("");					
			}
		}
	}
	
	$.fn.Watermark = function(text,color) {
		if(!color)
			color="#aaa";
		return this.each(
			function(){		
				var input=$(this);
				var defaultColor=input.css("color");
				map[map.length]={text:text,obj:input,DefaultColor:defaultColor,WatermarkColor:color};
				function clearMessage(){
					if(input.val()==text)
						input.val("");
					input.css("color",defaultColor);
				}

				function insertMessage(){
					if(input.val().length==0 || input.val()==text){
						input.val(text);
						input.css("color",color);	
					}else
						input.css("color",defaultColor);				
				}

				input.focus(clearMessage);
				input.blur(insertMessage);								
				input.change(insertMessage);
				
				insertMessage();
			}
		);
	};
})(jQuery);