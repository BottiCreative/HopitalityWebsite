<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php $ih = Loader::helper('concrete/interface'); ?>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t($title), false, false, false)?>


<div class="ccm-pane-body">
<?php 

if($this->controller->getTask() == 'update_area_coordinates') 
{
	
 ?>
<p><?php echo t('You can use this section to update areas with coordinate details.  These coordinates will be used to display the area on a map.');?></p>
<p><em><?php echo t('Google Maps'); ?></em> <?php echo t('is used to calculate the coordinates of each area'); ?></p>

<p>There are <?php echo $noOfAreasToUpdate; ?> areas that have no coordinates set.</p>

<?php echo $ih->button('Update Areas',$this->url('/dashboard/moomusic/areas/update_area_coordinates','update'),'left'); ?>




<?php 

}
elseif($this->controller->getTask() == 'update_area_borders') 
{
	
 ?>
<form id="form1" method="post" action="<?php echo $this->url('/dashboard/moomusic/areas/update_area_borders/update') ?>">
<p><?php echo t('You can use this section to update specific area borders based on a CSV.  These coordinates will be used to display the peimeter/outline of the area on a map.');?></p>
<p><em><?php echo t('Google Maps'); ?></em> <?php echo t('is used to calculate the coordinates of each area'); ?></p>
<p>This file must take the form <em>[PostCode],"[Coordinates]"</em>, where the coordinates represent a <strong>Comma delimited list of coordinates to represent the border for that given area.</strong></p>
<p>An example is below:<br />

<em>
BN42,"50.830376, -0.243043,50.831751, -0.243415,50.831814, -0.243588,50.833483, -0.243604,50.833494, -0.243088,50.834322, -0.242296,50.834629, -0.242189,50.834842, -0.242412,50.834976, -0.242945,50.8365, -0.243318,50.836595, -0.243374,50.837096, -0.243287,50.837636, -0.243515,50.837919, -0.241721,50.838938, -0.241772,50.839224, -0.242458,50.840136, -0.24242,50.840208, -0.242105,50.840453, -0.242101,50.8405, -0.242138,50.840811, -0.242282,50.841057, -0.241839,50.842161, -0.240229,50.842467, -0.240013,50.842626, -0.239988,50.842684, -0.240626,50.843218, -0.241455,50.843467, -0.241659,50.843637, -0.24129,50.844674, -0.241413,50.844842, -0.240884,50.850306, -0.239035,50.849515, -0.237785,50.849262, -0.23656,50.848838, -0.235046,50.848614, -0.231785,50.847928, -0.230641,50.847594, -0.230427,50.847503, -0.23041,50.847467, -0.230315,50.84678, -0.228661,50.84547, -0.228157,50.844771, -0.228055,50.844726, -0.227935,50.844632, -0.227317,50.844007, -0.22673,50.84381, -0.226594,50.84369, -0.225155,50.843401, -0.224561,50.84235, -0.224563,50.842347, -0.22393,50.841713, -0.223832,50.84109, -0.223318,50.840838, -0.223234,50.840753, -0.223241,50.840718, -0.223164,50.840362, -0.223189,50.840199, -0.223061,50.83957, -0.221623,50.839228, -0.221917,50.838547, -0.222237,50.838212, -0.222542,50.83756, -0.221812,50.836846, -0.221742,50.836833, -0.221128,50.836349, -0.220029,50.836277, -0.218686,50.835605, -0.21847,50.835624, -0.217911,50.834871, -0.217895,50.834779, -0.217951,50.834725, -0.217993,50.833902, -0.21989,50.833846, -0.220137,50.833735, -0.220479,50.833801, -0.22192,50.833448, -0.222557,50.832846, -0.224752,50.833599, -0.224879,50.833581, -0.224488,50.831823, -0.223999,50.831269, -0.222956,50.831331, -0.221688,50.831223, -0.221955,50.829925, -0.222853,50.82997, -0.222812,50.829924, -0.222848,50.8297, -0.222951,50.828022, -0.224072,50.82811, -0.226624,50.828239, -0.227348,50.828232, -0.230317,50.828205, -0.230901,50.828178, -0.231006,50.828175, -0.231058,50.828212, -0.232106,50.828705, -0.234686,50.829347, -0.236232,50.829517, -0.235521,50.829543, -0.236582,50.831169, -0.238306,50.831025, -0.239392,50.830852, -0.242591,50.83037, -0.243018"
</em>
	
</p>
<p>Where <strong>BN42</strong>=The area postcode, and the list of coordinates is inside double quotes.</p>

<p>
<?php 

echo $border_textarea;

?>
</p>

<?php

//echo $ih->button('Update Area Borders', $this->url('/dashboard/moomusic/areas/update_area_borders','update'),'left');
echo '<input type="submit" value="Update Area Borders" name="btnSubmit" id="btnSubmit" />';
echo '</form>';

}
else 
{

//view		
echo $ih->button('Update Area Coordinates',$this->url('/dashboard/moomusic/areas','update_area_coordinates'), 'left');
echo $ih->button('Update Area Borders',$this->url('/dashboard/moomusic/areas','update_area_borders'), 'left');

?>



<?php

}

?>
	
</div>

<?php echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false)?>