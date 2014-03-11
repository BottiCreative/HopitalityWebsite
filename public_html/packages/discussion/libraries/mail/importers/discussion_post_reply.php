<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class DiscussionPostReplyMailImporter extends MailImporter {
	
	public function process($mail) {
		// now that we're here, we know that we're validated and that this is an email
		// coming from someone proper.
		
		// We need to know what to do with it, now. We check the "data" column, which stores
		// a serialized PHP object that contains relevant information about what this item needs to respond to, post to, etc...
		$do = $mail->getDataObject();
		
		Loader::model('discussion_post', 'discussion');
		Loader::model('discussion_track', 'discussion');
		Loader::model('discussion', 'discussion');


		Loader::model('user_private_message');
		if ($do->cID > 0) {
			$upm = UserInfo::getByID($do->toUID);
			if (is_object($upm)) {
				$dpm2 = DiscussionPostModel::getByID($do->cID);
				$uo = $upm->getUserObject();
				$dpm = $dpm2->addPostReply($mail->getSubject(), $mail->getProcessedBody(), array(), true, $uo);
			}			
		}
	}
	

}