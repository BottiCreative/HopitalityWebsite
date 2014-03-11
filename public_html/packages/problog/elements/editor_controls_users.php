<?php       defined('C5_EXECUTE') or die("Access Denied."); ?> 
<div class="ccm-editor-controls-left-cap">
<div class="ccm-editor-controls-right-cap">
<div class="ccm-editor-controls">
<ul>
<li ccm-file-manager-field="rich-text-editor-image"><a class="ccm-file-manager-launch" onclick="ccm_editorCurrentAuxTool='image'; setBookMark();return false;" href="#"><?php       echo t('Add Image')?></a></li>
<li ccm-file-manager-field="rich-text-editor-image"><a class="ccm-embed-launch" onclick="setBookMark();ccmEmbedDialog();" href="#"><?php       echo t('Add Embed')?></a></li>
<li><a class="ccm-file-manager-launch" onclick="ccm_editorCurrentAuxTool='file'; setBookMark();return false;" href="#"><?php       echo t('Add File')?></a></li>

</ul>
</div>
</div>
</div>
<div id="rich-text-editor-image-fm-display">
<input type="hidden" name="fType" class="ccm-file-manager-filter" value="<?php       echo FileType::T_IMAGE?>" />
</div>
<?php      
$pkg = Package::getByHandle('problog');
$html = Loader::helper('concrete/urls');
$tools_path = $html->getToolsURL('embed','problog');
?>

<div class="ccm-spacer">&nbsp;</div>
<script type="text/javascript">
ccmEmbedDialog = function() {
    $.fn.dialog.open({
        title: 'Add Embed Code',
        href: '<?php      echo $tools_path?>',
        width: '300',
        modal: false,
        height: '180'
    });
};
</script>
<script type="text/javascript">
var bm; 
setBookMark = function () {
	tinyMCE.activeEditor.focus();
	bm = tinyMCE.activeEditor.selection.getBookmark();
}

function doEmbed() {
	var mceEd = tinyMCE.activeEditor;	
	mceEd.selection.moveToBookmark(bm);
	var selectedText = mceEd.selection.getContent();
	
	if (selectedText != '') {	
		var embedContent = $('textarea[name="embed_code"]').val();	
		mceEd.execCommand('mceInsertContent', false, embedContent, {skip_undo : 1}); 
		mceEd.dom.setAttribs('__mce_tmp', args);
		mceEd.dom.setAttrib('__mce_tmp', 'id', '');
		mceEd.undoManager.add();
	} else {
		var selectedText = $('textarea[name="embed_code"]').val();
		tinyMCE.execCommand('mceInsertRawHTML', false, selectedText, true); 
	}
	
}
function ccmEditorSitemapOverlay() {
    $.fn.dialog.open({
        title: 'Choose A Page',
        href: CCM_TOOLS_PATH + '/sitemap_overlay.php?sitemap_mode=select_page&callback=ccm_selectSitemapNode<?php       echo $GLOBALS['CCM_EDITOR_SITEMAP_NODE_NUM']?>',
        width: '550',
        modal: false,
        height: '400'
    });
};

$(function() {
	ccm_activateFileSelectors();
});
</script>