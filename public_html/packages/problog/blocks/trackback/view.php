<?php       
Global $c;
?>
<a href="javascript:;" class="show_trackback"><?php      echo t('Add Pingback')?></a>
<link rel="pingback" href="<?php      echo $xmlrpc.'?cID='.$c->getCollectionID();?>" />
<div id="trackback" style="display: none;">
	<form id="trackback-form" action="trackback.html" method="post">
		<fieldset id="trackback">
			<input id="trackback-uri" name="trackback-uri" type="hidden" value="<?php       echo BASE_URL . Loader::helper('navigation')->getLinkToCollection($c);?>"/>
			<input id="post_cID" name="post_cID" type="hidden" value="<?php       echo $c->getCollectionID();?>"/>
			<input id="pingback" name="pingback" type="hidden" value="<?php       echo $xmlrpc;?>"/>
			<br/>
			<label for="post_url"><?php      echo t('Post URL')?>:</label>
			<input id="post_url" name="post_url" type="text" size="40"/>
			<label for="submit"></label>
			<input id="submit_trackback" name="submit" type="submit" value="<?php      echo t('Send Pingback Ping')?>" /> 
		</fieldset>
	</form>
</div>
<script type="text/javascript">
/* <![CDATA[ */
	$('#post_url').click(function(){
		$('#post_url').css('background-color','');
	});
	$('.show_trackback').click(function(){
		if($('#trackback').css('display') == 'none'){
			$('#trackback').show('slow');
		}else{
			$('#trackback').hide('slow');
		}
	});
	$('#submit_trackback').click(function(){
		$('#error_message').remove();
		post_url = $('#post_url').val();
		if(post_url.indexOf("http://") == -1){
			//$('#trackback').append('<span id="error_message">You must have \'http://\' in your url</span>');
			//return false;
		}
		data = $('#trackback-form').serialize();
		url = '<?php      echo $trackback_url?>';
		//alert(url);
		$.post(url,data,function(response){
			if(response.toLowerCase().indexOf("success") >= 0){
				//$('#trackback-form').hide('slow');
				$('#post_url').css('background-color','#e1ffda');
				$('#trackback').append('Your Trackback Ping was successful.');
			}else{
				$('#post_url').css('background-color','#ffcdca');
				$('#trackback').append('<span id="error_message">'+response+'</span>');
			}
		});
		return false;
	});
/* ]]> */
</script>