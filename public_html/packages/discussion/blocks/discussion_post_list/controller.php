<?php 

	defined('C5_EXECUTE') or die(_("Access Denied."));
	class DiscussionPostListBlockController extends BlockController {

		protected $btTable = 'btDiscussionPostList';
		protected $btInterfaceWidth = "500";
		protected $btInterfaceHeight = "350";
		public $postCtHandle = 'discussion_post';
		protected $parentIDList = array();
		protected $ctID = NULL;
		public $helpers = array('form', 'form/page_selector', 'json');

		/**
		 * Used for localization. If we want to localize the name/description we have to include this
		 */
		public function getBlockTypeDescription() {
			return t("List Discussion posts and replies.");
		}

		public function getBlockTypeName() {
			return t("Discussion Post List");
		}

		public function on_page_view() {
			$html = Loader::helper('html');
			$this->addHeaderItem($html->css('discussion.css', 'discussion'));
		}

		protected function setPostTypeCtID() {
			$ct = CollectionType::getByHandle('discussion_post');
			$this->ctID = $ct->getCollectionTypeID();
			return $this->ctID;
		}


		function getPosts($query = null) {
			Loader::model('page_list');
			Loader::model('discussion_post','discussion');
			Loader::model('discussion_post_list','discussion');
			$db = Loader::db();
			$bID = $this->bID;
			if ($this->bID) {
				$q = "select num, cParentID, cThis, orderBy, displayAliases, tagFilter, tagValues from btDiscussionPostList where bID = '$bID'";
				$r = $db->query($q);
				if ($r) {
					$row = $r->fetchRow();
				}
			} else {
				$row['num'] = $this->num;
				$row['cParentID'] = $this->cParentID;
				$row['cThis'] = $this->cThis;
				$row['orderBy'] = $this->orderBy;
				$row['tagFilter'] = $this->tagFilter;
			}

			$this->setPostTypeCtID();
			$row['ctID'] = $this->ctID;

			$pl = new DiscussionPostList();
			$pl->setNameSpace('b' . $this->bID);

			$cArray = array();

			switch($row['orderBy']) {
				case 'display_asc':
					$pl->sortByDisplayOrder();
					break;
				case 'display_desc':
					$pl->sortByDisplayOrderDescending();
					break;
				case 'chrono_asc':
					$pl->sortByPublicDate();
					break;
				case 'alpha_asc':
					$pl->sortByName();
					break;
				case 'alpha_desc':
					$pl->sortByNameDescending();
					break;
				default:
					$pl->sortByPublicDateDescending();
					break;
			}

			$num = (int) $row['num'];

			if ($num > 0) {
				$pl->setItemsPerPage($num);
			}

			$c = Page::getCurrentPage();
			if (is_object($c)) {
				$this->cID = $c->getCollectionID();
			}
			$cParentID = ($row['cThis']) ? $this->cID : $row['cParentID'];

			Loader::model('attribute/categories/collection');
			if ($this->displayFeaturedOnly == 1) {
				$cak = CollectionAttributeKey::getByHandle('is_featured');
				if (is_object($cak)) {
					$pl->filterByIsFeatured(1);
				}
			}
			if (!$row['displayAliases']) {
				$pl->filterByIsAlias(0);
			}
			$pl->filter('cvName', '', '!=');
/*
			if ($row['ctID']) {
				$pl->filterByCollectionTypeID($row['ctID']);
			}
*/
			/*
			$columns = $db->MetaColumns(CollectionAttributeKey::getIndexedSearchTable());
			if (isset($columns['AK_EXCLUDE_PAGE_LIST'])) {
				$pl->filter(false, '(ak_exclude_page_list = 0 or ak_exclude_page_list is null)');
			}
			*/

			if ( intval($row['cParentID']) != 0) {
				$pl->filterByPath(Page::getByID($cParentID)->getCollectionPath(),true);
			}

	//		$pl->filter(false, '(ak_discussion_post_not_displayed = 0 or ak_discussion_post_not_displayed is null)');
			//this is the tag stuff from the c5discussion list
			$tagArray = array();

			switch($row['tagFilter']) {
				case 'page':
					if(is_object($c)) {
						$tagArray = $c->getCollectionAttributeValue(DISCUSSION_POST_TAG_HANDLE);
					} else {
						$c = Page::getByID($this->cID);
						$tagArray = $c->getCollectionAttributeValue(DISCUSSION_POST_TAG_HANDLE);
					}
				break;
				case 'specific':
					$tagArray = Loader::helper('json')->decode($row['tagValues']);
				break;
				case 'none':
				default:
					break;
			}
			if((is_array($tagArray) && count($tagArray)) || (is_object($tagArray) && $tagArray->count())) {
				// must have all tags
				foreach($tagArray as $tag) {
					$tag = trim((string) $tag);
					if(strlen($tag)) {
						$pl->filterByAttribute(DISCUSSION_POST_TAG_HANDLE, "%\n" . (string) $tag . "\n%", "like");
					}
				}
			}

			if ($num > 0) {
				$pages = $pl->getPage();
			} else {
				$pages = $pl->get();
			}
			$this->set('pl', $pl);
			return $pages;
		}

		/**
		 * recursively queries the discussion posts under the current post for a list of cIDs
		 * @param int $cParentID
		 * @return array of int
		 */
		protected function buildParentIDList($cParentID) {
			if(!is_numeric($cParentID) && $cParentID <= 0) {
				return false;
			}
			$this->parentIDList[] = $cParentID;
			$db = Loader::db();
			$rows = $db->getCol("SELECT cID FROM Pages WHERE ctID = ? AND cParentID = ?",array($this->ctID, $cParentID));
			if(is_array($rows) && count($rows)) {
				$this->parentIDList = array_unique(array_merge($this->parentIDList,$rows));
				foreach($rows as $cID) {
					$this->buildParentIDList($cID);
				}
			}
		}


		public function view() {
			$cArray = $this->getPosts();
			$nh = Loader::helper('navigation');
			$this->set('nh', $nh);
			$this->set('cArray', $cArray);
		}

		public function add() {
			Loader::model("collection_types");
			$c = Page::getCurrentPage();
			$uh = Loader::helper('concrete/urls');
			//	echo $rssUrl;
			$this->set('c', $c);
			$this->set('uh', $uh);
			$this->set('bt', BlockType::getByHandle('discussion_post_list'));
			$this->set('displayAliases', true);
		}

		public function edit() {
			$b = $this->getBlockObject();
			$bCID = $b->getBlockCollectionID();
			$bID=$b->getBlockID();
			$this->set('bID', $bID);
			$c = Page::getCurrentPage();
			if ($c->getCollectionID() != $this->cParentID && (!$this->cThis) && ($this->cParentID != 0)) {
				$isOtherPage = true;
				$this->set('isOtherPage', true);
			}
			$uh = Loader::helper('concrete/urls');


			$this->set('uh', $uh);
			$this->set('bt', BlockType::getByHandle('discussion_post_list'));
		}

		function save($args) {
			// If we've gotten to the process() function for this class, we assume that we're in
			// the clear, as far as permissions are concerned (since we check permissions at several
			// points within the dispatcher)
			$db = Loader::db();

			$bID = $this->bID;

			/*
			 * Tags..
			 * Since blocks don't support attributes we're using the collection attribute in the front end so we can get the auto-complete
			 * functionality, then we're just going to store the text strings json encoded in the block's table instead of allowing the
			 * attribute to store these on it's own.
			 *
			*/
			Loader::model('attribute/categories/collection');
			$tags = CollectionAttributeKey::getByHandle(DISCUSSION_POST_TAG_HANDLE);
			if($tags instanceof AttributeKey && is_array($args['akID'][$tags->akID]['atSelectNewOption'])) {
				$json = Loader::helper('json');
				$args['tagValues'] = $json->encode(array_unique($args['akID'][$tags->akID]['atSelectNewOption']));
			}
			$args['num'] = ($args['num'] > 0) ? $args['num'] : 0;
			$args['cThis'] = ($args['cParentID'] == $this->cID) ? '1' : '0';
			$args['cParentID'] = ($args['cParentID'] == 'OTHER') ? $args['cParentIDValue'] : $args['cParentID'];
			$args['truncateSummaries'] = ($args['truncateSummaries']) ? '1' : '0';
			$args['postInfo'] = ($args['postInfo']) ? '1' : '0';
			$args['displayFeaturedOnly'] = ($args['displayFeaturedOnly']) ? '1' : '0';
			$args['displayAliases'] = ($args['displayAliases']) ? '1' : '0';
			$args['truncateChars'] = intval($args['truncateChars']);
			$args['paginate'] = intval($args['paginate']);
			$args['postToCID'] = intval($args['postToCID']);

			if(!$args['enablePosting']) { $args['postToCID'] = 0; }

			parent::save($args);

		}
	}

?>
