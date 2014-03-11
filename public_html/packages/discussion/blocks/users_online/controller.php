<?php 
	defined('C5_EXECUTE') or die(_("Access Denied."));
	class UsersOnlineBlockController extends BlockController {
		
		var $pobj;

		const DEFAULT_MINUTES_ONLINE = 15;		
		const DEFAULT_MAX_USERS 	 = 5;				
		
		protected $btDescription = "A block to show who's currently online";
		protected $btName = "Users Online";
		protected $btTable = 'btUsersOnline';
		protected $btInterfaceWidth = "350";
		protected $btInterfaceHeight = "300";
		
		public function __construct($obj = null) {		
			parent::__construct($obj); 
			//create an array of userID/Value pairs
			$this->users = $this->getArrayOfRecentUsers($this->minutesSinceLastOnline*60,$this->maxUsersToShow);
			$this->updateAndSetMostUsersOnline();
		}		

		protected function updateAndSetMostUsersOnline(){
			$most = Config::get('discussion_most_users_online');
			$timestamp = Config::get('discussion_most_users_online_timestamp');
			if (!$most) {						
				$most = count($this->users);
				$this->configSetMostUsersOnline($most,time());
			} else if (count($this->users) > $most) {
				$most = count($this->users);
				$this->configSetMostUsersOnline($most,time());
			}
			
			$this->most 			= $most;	
			$this->most_timestamp 	= $timestamp;
		}
		
		protected function configSetMostUsersOnline($num,$timestamp){
			Config::save('discussion_most_users_online', $num);				
			Config::save('discussion_most_users_online_timestamp',$timestamp);						
		}
		
		protected function getArrayOfRecentUsers($since_in_seconds,$number_of_users){
		
			$q = 'SELECT uID, uName '
			. 'FROM Users ' 
			. 'WHERE ' 			
			. 'uLastOnline > ? '
			. 'ORDER BY uLastOnline DESC';
			$v = Array(time()-$since_in_seconds);			
			$db = Loader::db();			
			$rs = $db->SelectLimit($q,$number_of_users,-1,$v);
			$users = array();
			while ($row = $rs->fetchRow()) {
				$users[($row['uID'])]  = $row['uName'];
			}
			
			return $users;
		}
		
		function view(){
			$this->set('users',$this->users);
			$this->set('most',$this->most);
			$this->set('most_timestamp',$this->most_timestamp);
		}
		
		public function save($args){	
			//force numeric
			$args['minutesSinceLastOnline'] = is_numeric($args['minutesSinceLastOnline']) ? trim($args['minutesSinceLastOnline']) : self::DEFAULT_MINUTES_ONLINE;
			$args['maxUsersToShow']			= is_numeric($args['maxUsersToShow']) ? trim($args['maxUsersToShow']) : self::DEFAULT_MAX_USERS;
			parent::save($args);
		}
	}