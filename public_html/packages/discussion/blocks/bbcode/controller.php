<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::block('library_file');

class BbcodeBlockController extends BlockController {
	
	var $pobj;

	protected $btTable = 'btContentLocal';
	protected $btInterfaceWidth = "400";
	protected $btInterfaceHeight = "230";
	
	public $content = "";	
	
	public function getBlockTypeName() {
		return t("BBCode");
	}	 
	
	public function getBlockTypeDescription() {
		return t("A text area that supports Bulletin Board tags.");
	}	
	
	public function __construct($obj = null) {		
		parent::__construct($obj); 
	}
	
	public function view(){ 
		$this->set('content', $this->getHTMLContent() ); 
	} 
	
	public function save($data) { 
		$args['content'] = isset($data['content']) ? $data['content'] : '';
		parent::save($args);
	}
	
	public function getTextContent(){ return $this->content; }	
	
	public function getHTMLContent(){ 
		Loader::library('3rdparty/bbcode');
		$bb = new Simple_BB_Code(true, true, false); 
		$html = BbcodeBlockController::addEmoticons( $bb->parse($this->content) );
		$html = BbcodeBlockController::autolink($html);
		
		return str_ireplace("javascript:","",$html);
	}

	public function export(SimpleXMLElement $blockNode) {		
		$data = $blockNode->addChild('data');
		$data->addAttribute('table', $this->btTable);
		$record = $data->addChild('record');
		$content = $this->content;
		$cnode = $record->addChild('content');
		$node = dom_import_simplexml($cnode);
		$no = $node->ownerDocument;
		$node->appendChild($no->createCDataSection($content));
	}
			
	static public function addEmoticons($content=''){
		$uh = Loader::helper('concrete/urls');
		$bt = BlockType::getByHandle('bbcode');
		$bbcodeFolderPath=$uh->getBlockTypeAssetsURL($bt, ''); 
		$content=str_replace(array('>:-)','>:)'),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_mischief.png" alt="mischievous" />',$content);	
		$content=str_replace(array('>:-(','>:('),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_angry.png" alt="angry" />',$content);
		$content=str_replace(array(':)',':-)'),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_smile.png" alt="smiling" />',$content);
		$content=str_replace(array(':(',':-('),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_sad.png" alt="sad" />',$content);
		$content=str_replace(array(':-0',':-o',':-O'),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_oface.png" alt="surprised" />',$content);
		$content=str_replace(':-|','<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_bland.png" alt="expressionless" />',$content);
		$content=str_replace(array(';-)',';-)'),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_wink.png" alt="wink" />',$content);
		$content=str_replace( array(':-s',':-S'),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_confused.png" alt="confused" />',$content);
		
		$content=str_replace(":'-(",'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_cry.png" alt="crying" />',$content);
		$content=str_replace(array(':D',':-D'),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_grin.png" alt="grin" />',$content);
		$content=str_replace(array(':P',':-P',':-p'),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_tongue.png" alt="tongue out" />',$content);			
		$content=str_replace('8-)','<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_shades.png" alt="shades" />',$content);		
		$content=str_replace( array(":-\\",":-/"),'<img src="'.$bbcodeFolderPath.'/bbeditor/images/emoticon_slant.png" alt="awkward" />',$content);	
		return $content;
	}

	/** 
	 * Scans passed text and automatically hyperlinks any URL inside it
	 * @param string $input
	 * @return string $output
	*/
	public static function autolink($input) {
		$output = preg_replace_callback("/[\s| ](http:\/\/|https:\/\/|(www\.))(([^\s<]{4,60})[^\s<]*)/",
			create_function(
				'$matches',
				'return "<a href=\"http://".$matches[2].$matches[3]."\" title=\"http://".$matches[2].$matches[3]."\" rel=\"nofollow\">".
						(strlen("http://".$matches[2].$matches[4])>30?"http://".$matches[2].$matches[4]."...":"http://".$matches[2].$matches[4])."</a>";'
			), $input);

		return $output;
	}
	
}

?>