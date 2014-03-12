function PlayMusic(fileLink)
{
	
	var musicFile = jQuery(fileLink);
	
	window.open(musicFile.attr('href'),'Moo Music','height=300,width=500');
	return false;
	
	
	//Lets explore this at a later date.
	/*alert('hello world');
		return false;
		var musicPlayer = jQuery('#musicplayer');
		alert('hello world');
		return false;
		var musicDialog = jQuery('#musicplayer').load(jQuery(this).attr('href')).dialog({
			autoOpen: false,
			title: 'Moo Music',
			width: 500,
			height: 300
		});
		
		musicDialog.dialog('open');
		return false;
	*/

}



function DownloadFile(ajaxUrl,appendToElement)
{
	
	

}

