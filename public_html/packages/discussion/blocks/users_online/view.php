<div class="ccm-users-online">
	<h2><?php echo t('Who is Online')?></h2>
	<?php  if (count($users) == 0) { ?>
		<div><?php echo t('No registered users are currently online.');?></div>
	<?php  } else { ?>
		<div><?php echo t('The following registered users are online')?>: 
		<?php  
			$user_list = '';
			foreach ($users as $id=>$name) {
				$user_list .= '<a href="' . $this->url('/profile',$id) . '"> ' . $name . '</a>,';
			}		
			$user_list = substr ($user_list, 0, strlen($user_list) - 1);		
		?>
		<?php echo $user_list?>
		</div>
	<?php  } ?>
	<br/>
	<div><?php echo t('Most users ever online was')?> <?php echo $most?> <?php echo t('on')?> <?php echo date(DATE_APP_GENERIC_MDY_FULL,$most_timestamp)?>.</div>
</div>
