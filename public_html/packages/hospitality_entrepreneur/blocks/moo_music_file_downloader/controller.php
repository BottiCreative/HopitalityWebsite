<?php defined('C5_EXECUTE') or die('Access Denied');

class MooMusicFileDownloaderBlockController extends BlockController {
	
	protected $btTable = 'btMooMusicFileDownloader';
	protected $packageName = 'moo_music';
	
	public function on_page_view()
	{
		$this->set('packageName',$this->packageName);
		
		//add the maps js to activate google maps.
		$html = Loader::helper('html');
			
		
		$this->addHeaderItem($html->css('jquery.ui.css'));
   		$this->addHeaderItem($html->css('ccm.dialog.css'));
   		$this->addHeaderItem($html->javascript('jquery.ui.js'));
   		$this->addHeaderItem($html->javascript('ccm.dialog.js'));
			
		
	}
	
	public function getBlockTypeDescription() {
		
		return t('Enables the moo music file downloads to be available on the page for selection');
		
	}
	
	public function getBlockTypeName()
	{
		
		return t('Moo Music File Downloader');
	}
	
	
	
	public function view() {
		
		if(!empty($this->displayTypeID))
		{
			$this->set('attributeID', $this->displayTypeID);
			
			//get the attribute key
			$chosenAttributeKey = AttributeKey::getInstanceByID($this->displayTypeID);
			
			$this->set('attributeHandle',$chosenAttributeKey->getKeyHandle()  );
			
			//now get the files.
			Loader::model('file_list');
			
			$list = new FileList();
			
			//filter by the attribute type.
			$list->filterByAttribute($chosenAttributeKey->getKeyHandle(),true);
			
			$this->set('fileList',$list);
			
			if(isset($_GET['hdFileID']))
			{
				Loader::model('file');	
				Loader::helper('file');
				$fileHelper = new FileHelper();
				
				$fileToDownload = new File();
				$fileObj = $fileToDownload->getByID($_GET['hdFileID']);
				$fileObj->trackDownload();
				$fileHelper->forceDownload($fileObj->getRecentVersion()->getPath());				
				
			}
			
			
		}
		
		
		
		
	}
	
	
	public function save($data)
	{
		//var_dump($data);	
		parent::save($data);
		
	}
	
}

 final class FileDisplayType
{
	 const map = 0;
	const form = 1;
	const mapForm = 2;
	
	
}