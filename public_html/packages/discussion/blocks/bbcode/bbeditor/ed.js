/*****************************************/
// Name: Javascript Textarea BBCode Markup Editor
// Version: 1.3
// Author: Balakrishnan
// Last Modified Date: 25/jan/2009
// License: Free
// URL: http://www.corpocrat.com
/******************************************/

//var textarea;
//var content;
var bbeditorDir;
//document.write("<link href=\"bbeditor/styles.css\" rel=\"stylesheet\" type=\"text/css\">");

function edToolbar(obj) {
	if (typeof obj == 'string') {
		var textareaObj=$('#'+obj);
	} else if (typeof obj == 'object') {
		var textareaObj = obj;
	} else {
		throw "Invalid edToolbar() input.";
	}
	if( textareaObj.attr('hasBBEditor') ) return;
	//document.write( getBBEditorHTML(obj) );
	var buttonsDiv=$('<div/>');
	buttonsDiv.attr('id',"bbEditorButtons").append(getBBEditorHTML(textareaObj));

	textareaObj.before( buttonsDiv );
	textareaObj.attr('hasBBEditor',1);
	//document.write("<textarea id=\""+ obj +"\" name = \"" + obj + "\" cols=\"" + width + "\" rows=\"" + height + "\"></textarea>");
}

function getTE(me) {
	var cl = me;
	do {
		cl = cl.parent();
		te = cl.find('textarea');
	} while(te.length == 0);
	return te;
}

function getBBEditorHTML(obj){

	var bbCSSLink = document.createElement('link');
	bbCSSLink.setAttribute('rel', 'stylesheet');
	bbCSSLink.type = 'text/css';
	bbCSSLink.href = bbeditorDir+'bbeditor/styles.css';
	$('head').append(bbCSSLink);

	var html = $('<div/>').addClass('bbEditorToolbar')
	.append( // Bold
		getbbButton(bbeditorDir+'bbeditor/images/bold.gif','btnBold',function(){
			doAddTags('[b]','[/b]',getTE($(this)));
		},obj)
	).append( // italic
		getbbButton(bbeditorDir+'bbeditor/images/italic.gif','btnItalic',function(){
			doAddTags('[i]','[/i]',getTE($(this)));
		},obj)
	).append( // underline
		getbbButton(bbeditorDir+'bbeditor/images/underline.gif','btnUnderline',function(){
			doAddTags('[u]','[/u]',getTE($(this)));
		},obj)
	).append( // anchor
		getbbButton(bbeditorDir+'bbeditor/images/link.gif','btnLink',function(){
			doURL(getTE($(this)));
		},obj)
	).append( // image
		getbbButton(bbeditorDir+'bbeditor/images/picture.gif','btnPicture',function(){
			doImage(getTE($(this)));
		},obj)
	)/*.append( // ordered list
		getbbButton(bbeditorDir+'bbeditor/images/ordered.gif','btnOList',function(){
			doAddTags('[LIST=1]','[/LIST]',obj);
		})
	).append( // unordered list
		getbbButton(bbeditorDir+'bbeditor/images/unordered.gif','btnUList',function(){
			doAddTags('[LIST]','[/LIST]',obj);
		})
	)*/.append( // quote
		getbbButton(bbeditorDir+'bbeditor/images/quote.gif','btnQuote',function(){
			doAddTags('[quote]','[/quote]',getTE($(this)));
		},obj)
	).append( // emoticon
		getbbButton(bbeditorDir+'bbeditor/images/emoticon.gif','btnEmoticon',toggleEmoticonPanel,obj)
	).append( // emoticons
		$('<div/>').addClass('bbEditorEmoticonSelector').append(
			getbbEmoticon('smile','smile',':-)')
		).append(
			getbbEmoticon('grin','grin',':-D')
		).append(
			getbbEmoticon('sad','sad',':-(')
		).append(
			getbbEmoticon('bland','expressionless',':-|')
		).append(
			getbbEmoticon('shades','shades','8-)')
		).append(
			getbbEmoticon('angry','angry','>:-(')
		).append(
			getbbEmoticon('mischief','mischievous','>:-)')
		).append(
			getbbEmoticon('cry','crying',':\'-(')
		).append(
			getbbEmoticon('oface','surprise',':-0')
		).append(
			getbbEmoticon('wink','wink',';-)')
		).append(
			getbbEmoticon('tongue','tongue out',':-P')
		).append(
			getbbEmoticon('slant','awkward',':-/')
		).append(
			getbbEmoticon('confused','confused',':-S')
		)
	)
	return html;
}
function getbbButton(image,name,callback,obj) {
	return $('<img/>').addClass('bbEditorButton').attr('src',image).attr('name',name).click(callback).data('textarea',obj);
}
function getbbEmoticon(name,alt,input) {
	return $('<a/>').append($('<img/>').addClass('bbEditorEmoticon').attr('src',bbeditorDir+"bbeditor/images/emoticon_"+name+".png").attr('alt',alt)).click(function(){
		doAddEmoticon(getTE($(this)),input);
	})
}
function doImage(obj) {
	if (typeof obj == 'string') {
		var textarea = document.getElementById(obj);
	} else if (typeof obj == 'object') {
		var textarea = obj[0];
	}
	var url = prompt('Enter the Image URL:','http://');
	if (url == null) {
		return false;
	}

	var scrollTop = textarea.scrollTop;
	var scrollLeft = textarea.scrollLeft;

	if (document.selection) {
		textarea.focus();
		var sel = document.selection.createRange();
		sel.text = '[img]' + url + '[/img]';
	} else {
		var len = textarea.value.length;
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;

		var sel = textarea.value.substring(start, end);
		//alert(sel);
		var rep = '[img]' + url + '[/img]';
		textarea.value= textarea.value.substring(0,start) + rep + textarea.value.substring(end,len) ;


		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}

}

function doURL(obj){
	if (typeof obj == 'string') {
		var textarea = document.getElementById(obj);
	} else if (typeof obj == 'object') {
		var textarea = obj[0];
	}
	var url = prompt('Enter the URL:','http://');
	if (url == null) {
		return false;
	}
	var scrollTop = textarea.scrollTop;
	var scrollLeft = textarea.scrollLeft;

	if (document.selection) {
		textarea.focus();
		var sel = document.selection.createRange();

		if(sel.text==""){
			// no [url] because we have autolink on
			sel.text = url;
		} else {
			sel.text = '[url=' + url + ']' + sel.text + '[/url]';
		}


	} else {
		var len = textarea.value.length;
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;

		var sel = textarea.value.substring(start, end);

		if(sel==""){
			var rep = url;
		} else {
			var rep = '[url=' + url + ']' + sel + '[/url]';
		}
		//alert(sel);

		textarea.value= textarea.value.substring(0,start) + rep + textarea.value.substring(end,len) ;


		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
}

function doAddTags(tag1,tag2,obj){

	if (typeof obj == 'string') {
		textarea = document.getElementById(obj);
	} else if (typeof obj == 'object') {
		textarea = obj[0];
	}

	textareaObj = $(textarea);

	// Code for IE
	if (document.selection) {
		textarea.focus();
		var sel = document.selection.createRange();
		//alert(sel.text);
		sel.text = tag1 + sel.text + tag2;

	} else{  // Code for Mozilla Firefox

		var len = textarea.value.length;
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;

		var scrollTop = textarea.scrollTop;
		var scrollLeft = textarea.scrollLeft;

		var sel = textarea.value.substring(start, end);
		//alert(sel);
		var rep = tag1 + sel + tag2;
		textarea.value= textarea.value.substring(0,start) + rep + textarea.value.substring(end,len)  ;

		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;

	}
}


function toggleEmoticonPanel(){
	$('.bbEditorEmoticonSelector').each(function(i,el){
		if(el.style.display=='block')
			el.style.display='none';
		else el.style.display='block';
		clearTimeout(el.hovrTmr);
		el.onmouseover=function(){
			clearTimeout(this.hovrTmr)
		}
		el.onmouseout=function(){
			this.hovrTmr=setTimeout("$('.bbEditorEmoticonSelector').css('display','none')",3000)
		}
	});
}


function doAddEmoticon( obj, newEmoticon ){

	if(!newEmoticon) return false;

	if( newEmoticon.substring(newEmoticon.length-1) )
		newEmoticon=newEmoticon+' ';

	if (typeof obj == 'string') {
		var textarea = document.getElementById(obj);
	} else if (typeof obj == 'object') {
		var textarea = obj[0];
	}

	var scrollTop = textarea.scrollTop;
	var scrollLeft = textarea.scrollLeft;

	if (document.selection){
		textarea.focus();
		var sel = document.selection.createRange();

		if(sel.text==""){
			sel.text = newEmoticon;
		} else {
			sel.text = sel.text + newEmoticon;
		}
		//alert(sel.text);

	} else {

		var len = textarea.value.length;
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;

		var sel = textarea.value.substring(start, end);

		if(sel==""){
			var rep = newEmoticon;
		} else {
			var rep = sel + newEmoticon;
		}
		//alert(sel);

		textarea.value= textarea.value.substring(0,start) + rep + textarea.value.substring(end,len) ;

		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}

	toggleEmoticonPanel();
}


function doList(tag1,tag2,obj){
	if (typeof obj == 'string') {
		var textarea = $(document.getElementById(obj));
	} else if (typeof obj == 'object') {
		var textarea = obj[0];
	}
	if (document.selection) { // Code for IE
		textarea.focus();
		var sel = document.selection.createRange();
		var list = sel.text.split('\n');

		for(i=0;i<list.length;i++) list[i] = '[*]' + list[i];
		sel.text = tag1 + '\n' + list.join("\n") + '\n' + tag2;
	} else { // Code for Firefox
		var len = textarea.value.length;
		var start = textarea.selectionStart;
		var end = textarea.selectionEnd;
		var i;

		var scrollTop = textarea.scrollTop;
		var scrollLeft = textarea.scrollLeft;


		var sel = textarea.value.substring(start, end);
		//alert(sel);

		var list = sel.split('\n');

		for(i=0;i<list.length;i++)
		{
		list[i] = '[*]' + list[i];
		}
		//alert(list.join("<br>"));


		var rep = tag1 + '\n' + list.join("\n") + '\n' +tag2;
		textarea.value= textarea.value.substring(0,start) + rep + textarea.value.substring(end,len) ;

		textarea.scrollTop = scrollTop;
		textarea.scrollLeft = scrollLeft;
	}
}