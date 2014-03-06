<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));

class SwpDownloadsListBlockController extends BlockController {
	
	var $pobj;

	protected $btTable = 'btSwpDownloadsList';
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "260";
	protected $btCacheBlockOutput = false;
	protected $btCacheBlockOutputOnPost = false;
	protected $btCacheBlockOutputForRegisteredUsers = false;
	
	public $content = "";	
	
	protected $downloadsCount = array();
	
	public function getBlockTypeDescription() {
		return t("For adding list of download links from a certain file set.");
	}
	
	public function getBlockTypeName() {
		return t("Downloads List");
	}	 
	
	public function __construct($obj = null) {		
		parent::__construct($obj); 
	}
	
	public function getSearchableContent() {
		$downloads = $this->getDownloads();
		
		$content = '';
		if (!empty($downloads)) {
			foreach($downloads as $dl) {
				$fv = $dl->getVersion();
				
				$content .= ' '. $fv->getFileName();
				
				if (method_exists($fv, "getTitle")) {
					$title = $fv->getTitle();
					if (!empty($title))
						$content .= ' '. $title;
				}
				
				if (method_exists($fv, "getTags")) {
					$tags = $fv->getTags();
					if (!empty($tags))
						$content .= ' '. $tags;
				}
				
				if (method_exists($fv, "getDescription")) {
					$descr = $fv->getDescription();
					if (!empty($descr))
						$content .= ' '. $descr;
				}
				
			}
		}
		
		return trim($content);
	}
	
	public function on_page_view() {
		$html = Loader::helper("html");
		$this->addHeaderItem($html->css("block_view.css", "swp_downloads_list"));
	}
	
	public function view(){ 
		$this->set('downloads', $this->getDownloads());
		$this->set('display_columns', $this->display_columns);
		$this->set('display_date', $this->display_date);
		$this->set('display_downloads_count', $this->display_downloads_count);
		$this->set('display_filesize', $this->display_filesize);
		
		if ($this->paginate == "Y" && intval($this->items_per_page) > 0) {
			$this->set("paginate", "Y");
		} else {
			$this->set("paginate", "N");
		}
	} 
	
	public function save($data) { 
		$args = array();
		$args['fileset'] = intval($data["fileset"]);
		$args["display_columns"] = !empty($data["display_columns"]) ? "Y" : "N";
		$args["display_date"] = !empty($data["display_date"]) ? "Y" : "N";
		$args["display_downloads_count"] = !empty($data["display_downloads_count"]) ? "Y" : "N";
		$args["display_filesize"] = !empty($data["display_filesize"]) ? "Y" : "N";
		$args["all_files"] = !empty($data["all_files"]) ? "Y" : "N";
		$args["attr_filters"] = $this->implode_attr_filters($data["attr_filters"]);
		$args["sortBy"] = $this->processSortBy($data);
		$args["items_per_page"] = intval($data["items_per_page"]);
		$args["paginate"] = $data["paginate"] == "Y" ? "Y" : "N";
		parent::save($args);
	}
	
	function implode_attr_filters($attr_filters) {	
		$str = "";		
		$filters = array();
		
		if (!empty($attr_filters)) {
			foreach($attr_filters as $key => $value) {
				if (!empty($value)) { // checkbox ticked
					$filters[] = $key;
				}
			}
			
			$str .= implode(";", $filters);
		}
		return $str;	
	}
	
	function processSortBy($data) {
		if ($data["sortBy"] != "attribute")
			return $data["sortBy"];
		
		$arr = array(
			"attribute",
			$data["sort_attribute"],
			$data["sort_attribute_dir"],
		);
		
		return implode(";", $arr);
	}
	
	public function getSortAttribute($sortByImploded, $returnAttributeKey = false) {
		$a = explode(";", $sortByImploded);
		if (!$returnAttributeKey)
			return $a[1];
		return "ak_".$a[1];
	}
	
	public function getSortAttributeDirection($sortByImploded) {
		$a = explode(";", $sortByImploded);
		return $a[2];
	}
	
	public function getAttrFilters() {
		return explode(";", $this->attr_filters);
	}
	
	public function getFileSets() {
	
		Loader::model("file_set");
		$fs = new FileSet();
		return $fs->getMySets();
	
	}
	
	public function getDownloads() {
		Loader::model("file_list");
		Loader::model("file_set");
		$fl = new FileList();
		
		if ($this->all_files != "Y") {
			$fileset = FileSet::getByID($this->fileset);
			$fl->filterBySet($fileset);
			if ($this->sortBy == "default" && version_compare(APP_VERSION, "5.4.1", ">=")) {
				$fl->sortBy("fsDisplayOrder", "asc");
			}
		}
		
		if (!empty($this->attr_filters)) {
			foreach($this->getAttrFilters() as $atHandle) {
				$fl->filterByAttribute($atHandle, 1);
			}
		}
		
		if ($this->sortBy == "date_asc") {
			$fl->sortBy("fvDateAdded", "asc");
		} elseif ($this->sortBy == "date_desc") {
			$fl->sortBy("fvDateAdded", "desc");
		} elseif ($this->sortBy == "filename_asc") {
			$fl->sortBy("fvFilename", "asc");
		} elseif ($this->sortBy == "filesize_asc") {
			$fl->sortBy("fvSize", "asc");
		} elseif ($this->sortBy == "filesize_desc") {
			$fl->sortBy("fvSize", "desc");
		} elseif (strpos($this->sortBy, "attribute") === 0) {
			$fl->sortByAttributeKey($this->getSortAttribute($this->sortBy, true), $this->getSortAttributeDirection($this->sortBy));
		}
		
		$fl->setNameSpace('b' . $this->bID);
		
		if (intval($this->items_per_page) > 0) {
			$downloads = $fl->setItemsPerPage(intval($this->items_per_page));
			$downloads = $fl->getPage();
		} else {
			$downloads = $fl->get();
		}
		
		if (!empty($downloads) && $this->sortBy == "popularity_desc") {
			$this->sortByPopularity($downloads);
		}
		
		$this->set("fl", $fl);
		$this->set("pagination", $fl->getPagination());
		
		return $downloads;
	}
	
	function sortByPopularity(&$downloads) {
		for($i=0;$i<count($downloads);$i++) {
			for($j=$i;$j<count($downloads);$j++) {
				if ($this->getDownloadsCount( $downloads[$i]->getFileID() ) < $this->getDownloadsCount( $downloads[$j]->getFileID() )) {
					$tmp = $downloads[$i];
					$downloads[$i] = $downloads[$j];
					$downloads[$j] = $tmp;
					unset($tmp);
				}
			}
		}
	}
	
	function getDownloadsCount($fID) {
		$fID = intval($fID);
		if (isset($this->downloadsCount[$fID]))
			return $this->downloadsCount[$fID];
		$db = Loader::db();
		$this->downloadsCount[$fID] = $db->GetOne("SELECT COUNT(1) FROM DownloadStatistics WHERE fID = ?", array($fID));
		return $this->downloadsCount[$fID];
	}
	
	public function getFileAttributesList($boolean_only = true) {
		Loader::model('attribute/categories/file');
		$attribs = FileAttributeKey::getList();
		
		$checkboxes = array();
		
		if (!empty($attribs)) {
			foreach($attribs as $attr) {
				if ($attr->getAttributeType()->atHandle == "boolean" || !$boolean_only) {
					$checkboxes[] = $attr;
				}
			}
		}

		return $checkboxes;
	}
	
}