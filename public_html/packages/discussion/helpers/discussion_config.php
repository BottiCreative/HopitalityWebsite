<?php 
/**
 * class to deal with the interaction of global and discussion level configs 
 * @author Ryan Tyler <rtyler@concrete5.org>
 *
 */
class DiscussionConfigHelper {
	
	/**
	 * anonymous replies enabled for this discussion
	 * @param DiscussionModel $d
	 * @return boolean
	 */
	public function anonPostRepliesEnabled($d) {
		$pkg = Package::getByHandle('discussion'); 
		$anonReplies = $pkg->config('ENABLE_ANON_POSTING_REPLIES');
		
		if(is_object($d) && $d->getCollectionID() > 0) {
			$av = $d->getAttribute('discussion_anonymous_posting');
			if($av instanceof SelectAttributeTypeOptionList) {
				foreach($av as $opt) {
					$anonReplies = false;
					if($opt == t('Enable Anonymous Replies')) {
						$anonReplies = true;
						break;
					}
				}
	 		} elseif($av instanceof SelectAttributeTypeOption) {
	 			if($av == t('Enable Anonymous Replies')) {
	 				$anonReplies = true;
	 			}else {
	 				$anonReplies = false;	
	 			}
			}
		}
		return $anonReplies;
	}
	
	/**
	 * (top level) anonymous posts enabled for this discussion
	 * @param DiscussionModel $d
	 * @return boolean
	 */
	public function anonPostEnabled($d) {
		$pkg = Package::getByHandle('discussion');
			
		$anonPosting = $pkg->config('ENABLE_ANON_POSTING');
		if(is_object($d) && $d->getCollectionID() > 0) {
			$av = $d->getAttribute('discussion_anonymous_posting');
			if($av instanceof SelectAttributeTypeOptionList) {
				foreach($av as $opt) {
					$anonPosting = false;
					if($opt == t('Enable Anonymous Posting (new posts)')) {
						$anonPosting = true;
						break;
					}
				}
	 		} elseif($av instanceof SelectAttributeTypeOption) {
	 			if($av == t('Enable Anonymous Posting (new posts)')) {
	 				$anonPosting = true;
	 			}else {
	 				$anonPosting = false;	
	 			}
			}
		}
		return $anonPosting;
	}

	/**
	 * captcha required for anonymous posts & replies
	 * @param DiscussionModel $d
	 * @return boolean
	 */
	public function captchaRequired($d) {
		$pkg = Package::getByHandle('discussion');
		$captchaRequired = $pkg->config('ANON_POSTING_CAPTCHA_REQUIRED');
		if(is_object($d) && $d->getCollectionID() > 0) {
			$av = $d->getAttribute('discussion_anonymous_posting');
			if($av instanceof SelectAttributeTypeOptionList) {
				foreach($av as $opt) {
					$captchaRequired = false;
					if($opt == t('Solving Captcha is Required to Post')) {
						$captchaRequired = true;
						break;
					}
				}
	 		} elseif($av instanceof SelectAttributeTypeOption) {
	 			if($av == t('Solving Captcha is Required to Post')) {
	 				$captchaRequired = true;
	 			}else {
	 				$captchaRequired = false;	
	 			}
			}
		}
		return $captchaRequired;
	}
	
	/**
	 * returns the type of moderation for this discussion
	 * @param DiscussionModel $d
	 * @return string
	 */
	public function getModerationType($d) {
		$pkg = Package::getByHandle('discussion');
		$moderationType = $pkg->config('MODERATION_TYPE');
		if(is_object($d) && $d->getCollectionID() > 0) {
			$atv = $d->getAttribute('discussion_moderation_type');
			switch($atv) {
				case t('All Posts'):
					$moderationType = 'all';
				break;
				case t('Only Posts by Anonymous Users'):
					$moderationType = 'anon';
				break;
				case t("Don't Moderate Any Posts"):
					$moderationType = 'none';
				break;
			}
		}
		return $moderationType;	
	}
	
	/**
	 * attachements by anonymous users are allowed
	 * @param DiscussionModel $d
	 * @return boolean
	 */
	public function anonPostAttachmentsEnabled($d) {
		$pkg = Package::getByHandle('discussion');
		$attEnabled = $pkg->config('ANON_POSTING_ATTACHMENTS');
		if(is_object($d) && $d->getCollectionID() > 0) {
			$av = $d->getAttribute('discussion_anonymous_posting');
			if($av instanceof SelectAttributeTypeOptionList) {
				foreach($av as $opt) {
					$attEnabled = false;
					if($opt == t('Allow Anonymous Posters To Attach Files')) {
						$attEnabled = true;
						break;
					}
				}
	 		} elseif($av instanceof SelectAttributeTypeOption) {
	 			if($av == t('Allow Anonymous Posters To Attach Files')) {
	 				$attEnabled = true;
	 			}else {
	 				$attEnabled = false;	
	 			}
			}
		}
		return $attEnabled;	
		
	}
	
	
	/**
	 * true or false wether or not multilingual features have been enabled
	 * @return boolean
	*/
	public function isMultilingualEnabled() {
		$pkg = Package::getByHandle('discussion');
		if($pkg->config('DISCUSSION_MULTILINGUAL_ENABLED')) {
			if(self::isMultilingualInstalled()) {
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 * is a compatable version of the multilingual addon installed
	 * @return boolean
	*/
	public function isMultilingualInstalled() {
		$multPkg = Package::getByHandle('multilingual');
		if(isset($multPkg) && $multPkg) {
			if(version_compare($multPkg->getPackageVersion(), '1.1','>=')) {
				return true;
			}
		}
		return false;
	}
}
?>