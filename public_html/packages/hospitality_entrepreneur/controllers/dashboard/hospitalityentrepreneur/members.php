<?php


class DashboardMooMusicMembersController extends Controller {
		
	private $packageHandle = 'moo_music';		
	private $coreCommerceHandle = 'core_commerce';

	public function view()
	{
		$this->set('title','Manage Members');	
			
		Loader::helper('concrete/interface/menu');
		$adminMenu = new ConcreteInterfaceMenuHelper();
		
		$adminMenu->addPageHeaderMenuItem(0,"Configure Customer Email", 0,null,'moo_music');
		$this->set('adminMenu',$adminMenu);
		
		
		
		
	}
	
	public function update_member_email($updated = '')
	{
		$this->set('title','Update Member Email ' . $updated );
		
		$pkg = Package::getByHandle($this->packageHandle);
		
		
		if($pkg->config('MOO_MUSIC_MEMBER_EMAIL') == null || $pkg->config('MOO_MUSIC_MEMBER_EMAIL') == '' )
		{
			$pkg->saveConfig('MOO_MUSIC_MEMBER_EMAIL',<<<USEREMAIL
		
		<p>Congratulations... and thank you for joining the Moo Music family and taking the first step in this new chapter of your life. Give yourself a pat on the back!</p> 
		<p>To log in to your Farmers Market, please go to [loginlink].  Your login details are below:</p>
		<ul>
		<li>Username: <strong>[username]</strong></li>
		<li>Password: <strong>[password]</strong></li>
		</ul>
		<p>You should soon receive another email with your purchase details.  Further below is your license.  A copy of your license is also available in the Farmers Market.</p>
		<p>Thanks for joining us!</p>
		
		
USEREMAIL
);
		
		}
		
	
		if($updated == 'update')
		{
			if(isset($_REQUEST['content']))
			{
				$pkg->saveConfig('MOO_MUSIC_MEMBER_EMAIL', $_REQUEST['content']);
		
			}
				
		}
		
			
		$this->set('member_email',$pkg->config('MOO_MUSIC_MEMBER_EMAIL'));
	
	}

	public function update_license($updated = '')
	{
		$this->set('title','Update Member License ' . $updated );
		
		$pkg = Package::getByHandle($this->packageHandle);
		
		
		if($pkg->config('MOO_MUSIC_LICENSE') == null || $pkg->config('MOO_MUSIC_LICENSE') == '' )
		{
			$pkg->saveConfig('MOO_MUSIC_LICENSE',<<<LICENSE
		
		Moo Music&#8482; Limited grants a licence (the "Licence") to [name] of [address] (the "Licensee") starting on the [orderday] day of [ordermonth] [orderyear] for 

a period of 12 months. Such Licence, as detailed further in the Terms and Conditions, allows the Licensee to run Moo 

Music&#8482; sessions within the postcode districts of [areas] (the "Territory"). 

The Licence also grants the right to the Licensee to broadcast any Moo Music&#8482; songs, notwithstanding that the venue 

being used may not have a pre-recorded music, PRS for music or a PPL music licence.
		
		
LICENSE
);
		
		}
		
	
		if($updated == 'update')
		{
			if(isset($_REQUEST['content']))
			{
				$pkg->saveConfig('MOO_MUSIC_LICENSE', $_REQUEST['content']);
		
			}
				
		}
		
			
		$this->set('member_license',$pkg->config('MOO_MUSIC_LICENSE'));
	
	}

	

}

?>