<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); ?>  
 
<script type="text/javascript" src="<?php echo $this->getBlockURL() ?>/bbeditor/ed.js"></script>

<style>
#bbCodeReferenceToggle{font-size:11px}
#bbCodeReference.noDisplay{display:none}
#bbCodeReference ul{ list-style:none; padding-left:0px; margin-left:0px; }
#bbEditorButtons{text-align:left; margin-bottom:4px; }
#bbEditorButtons img{margin-right:4px; }
</style>

<div id="ccm-bbcodeContentWrap" style="text-align: center" >
<textarea id="ccm-bbcodeContent" name="content" style="width:98%; margin:auto; height:160px;"><?php echo $controllerObj->content ?></textarea>
</div>
<script>
bbeditorDir="<?php echo $this->getBlockURL() ?>/";
edToolbar('ccm-bbcodeContent'); 
</script>  

<div id="bbCodeReferenceToggle"><a onclick="$('#bbCodeReference').toggleClass('noDisplay')"><?php echo t('Show BB Tags Reference')?></a></div>
<div id="bbCodeReference" class="noDisplay">

	<ul>
		<li>[b]<?php echo t('Bold Text')?>[/b]</li>
		<li>[i]<?php echo t('Italic Text')?>[/i]</li>
		<li>[u]<?php echo t('Underlined Text')?>[/u]</li>
		<li>[s]<?php echo t('Strike through text')?>[/s]</li>
		<li>[quote]<?php echo t('Blockquote')?>[/quote]</li>
		<li>[list]<?php echo t('list')?>[/list]</li>
		<li>[*]<?php echo t('List Item')?>[/*]</li>
		<li>[url=http://concrete5.org]<?php echo t('Concrete5')?>[/url]</li>
		<li>[img]<?php echo t('Image')?>.jpg[/img]</li>
		<li>[color=red]<?php echo t('font color')?>[/color]</li>
		<li>[size=15]<?php echo t('font size')?>[/size]</li>
	</ul>
</div>