<?php 
	class DiscussionContentBlockController extends BlockController {
		
		var $pobj;
		
		protected $btDescription = "Content for Discussion Posts and Replies.";
		protected $btName = "Discussion Content";
		protected $btTable = 'btContentLocal';
		protected $btInterfaceWidth = "500";
		protected $btInterfaceHeight = "400";
		
		public function getContent() {
			return html_entity_decode($this->content);
		}
		
		public function getHTMLContent() {
			$dt = Loader::helper('discussion_text', 'discussion');
			return $dt->outputForDiscussion($this->content);	
		}
		
		public function getTextContent() {
			$dt = Loader::helper('discussion_text', 'discussion');
			return $dt->outputForEmail($this->content);	
		}
		
		
		public function save($args) {
			$dt = Loader::helper('discussion_text', 'discussion');
			$args['content'] = $dt->makeniceForDiscussion($args['content']);
			
			return parent::save($args);
		}
		
	}
	
?>