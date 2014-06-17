<?php  defined('C5_EXECUTE') or die("Access Denied.");

class PartnersMainBlockController extends BlockController {
	
	protected $btName = 'Partners Main';
	protected $btDescription = '';
	protected $btTable = 'btDCPartnersMain';
	
	protected $btInterfaceWidth = "700";
	protected $btInterfaceHeight = "450";
	
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	protected $btCacheBlockOutputLifetime = CACHE_LIFETIME;
	
	public function getSearchableContent() {
		$content = array();
		$content[] = $this->field_2_textbox_text;
		$content[] = $this->field_3_textbox_text;
		$content[] = $this->field_4_textarea_text;
		return implode(' - ', $content);
	}

	public function view() {
		$this->set('field_1_image', (empty($this->field_1_image_fID) ? null : $this->get_image_object($this->field_1_image_fID, 600, 600, true)));
	}


	public function edit() {
		$this->set('field_1_image', (empty($this->field_1_image_fID) ? null : File::getByID($this->field_1_image_fID)));
	}

	public function save($args) {
		$args['field_1_image_fID'] = empty($args['field_1_image_fID']) ? 0 : $args['field_1_image_fID'];
		$args['field_1_image_internalLinkCID'] = empty($args['field_1_image_internalLinkCID']) ? 0 : $args['field_1_image_internalLinkCID'];
		$args['field_5_link_cID'] = empty($args['field_5_link_cID']) ? 0 : $args['field_5_link_cID'];
		parent::save($args);
	}

	//Helper function for image fields
	private function get_image_object($fID, $width = 0, $height = 0, $crop = false) {
		if (empty($fID)) {
			$image = null;
		} else if (empty($width) && empty($height)) {
			//Show image at full size (do not generate a thumbnail)
			$file = File::getByID($fID);
			$image = new stdClass;
			$image->src = $file->getRelativePath();
			$image->width = $file->getAttribute('width');
			$image->height = $file->getAttribute('height');
		} else {
			//Generate a thumbnail
			$width = empty($width) ? 9999 : $width;
			$height = empty($height) ? 9999 : $height;
			$file = File::getByID($fID);
			$ih = Loader::helper('image');
			$image = $ih->getThumbnail($file, $width, $height, $crop);
		}
	
		return $image;
	}
	


}
