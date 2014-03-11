<?php   
defined('C5_EXECUTE') or die(_("Access Denied."));
/**
	* @ concrete5 package AutonavPro
	* @copyright  Copyright (c) 2013 Hostco. (http://www.hostco.com)  	
*/

$fm = Loader::helper('form');  
?>
<?php   
echo Loader::helper('concrete/dashboard')->getDashboardPaneHeaderWrapper(t('Font Awesome Generator'));
?>
<style>
.fontawesome-icon-list{margin-top:22px}
.fontawesome-icon-list .anp-icon-hover a{display:block;color:#222;line-height:32px;height:32px;padding-left:10px;border-radius:4px}
.fontawesome-icon-list .anp-icon-hover a i{width:32px;font-size:14px;display:inline-block;text-align:right;margin-right:10px}
.fontawesome-icon-list .anp-icon-hover a:hover,.fontawesome-icon-list .anp-icon-hover a.active{background-color:#1d9d74;color:#fff;text-decoration:none}
.fontawesome-icon-list .anp-icon-hover a:hover i,.fontawesome-icon-list .anp-icon-hover a.active i{font-size:28px;vertical-align:-6px}
.ccm-ui .panel.panel-default.active h4.panel-title a{color:#1d9d74}
#AnpLlinkTitle{height:34px}
</style>
<div class="ccm-pane-body">
<div class="ccm-summary-selected-item">
<div>
<p><strong><?php    echo t('Select Icon');?></strong></p>	
<div class="panel-group" id="font-accordion">
	<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-1">
         11 New Icons in 4.0
        </a>
      </h4>
    </div>
    <div id="font-collapse-1" class="panel-collapse collapse">
      <div class="panel-body">
        <div class="row fontawesome-icon-list">
    

    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rub"><i class=" anp-icon-rub"></i> anp-icon-rub</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rub"><i class=" anp-icon-ruble"></i> anp-icon-ruble <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rub"><i class=" anp-icon-rouble"></i> anp-icon-rouble <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pagelines"><i class=" anp-icon-pagelines"></i> anp-icon-pagelines</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-stack-exchange"><i class=" anp-icon-stack-exchange"></i> anp-icon-stack-exchange</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-o-right"><i class=" anp-icon-arrow-circle-o-right"></i> anp-icon-arrow-circle-o-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-o-left"><i class=" anp-icon-arrow-circle-o-left"></i> anp-icon-arrow-circle-o-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-left"><i class=" anp-icon-caret-square-o-left"></i> anp-icon-caret-square-o-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-left"><i class=" anp-icon-toggle-left"></i> anp-icon-toggle-left <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-dot-circle-o"><i class=" anp-icon-dot-circle-o"></i> anp-icon-dot-circle-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-wheelchair"><i class=" anp-icon-wheelchair"></i> anp-icon-wheelchair</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-vimeo-square"><i class=" anp-icon-vimeo-square"></i> anp-icon-vimeo-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-try"><i class=" anp-icon-try"></i> anp-icon-try</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-try"><i class=" anp-icon-turkish-lira"></i> anp-icon-turkish-lira <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plus-square-o"><i class=" anp-icon-plus-square-o"></i> anp-icon-plus-square-o</a></div>
    
  </div>

      </div>
    </div>
  </div>
    <div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-2">
			Web Application Icons
			</a>
		  </h4>
		</div>
		<div id="font-collapse-2" class="panel-collapse collapse">
		  <div class="panel-body">
			<div class="row fontawesome-icon-list">
    

    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-adjust"><i class=" anp-icon-adjust"></i> anp-icon-adjust</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-anchor"><i class=" anp-icon-anchor"></i> anp-icon-anchor</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-archive"><i class=" anp-icon-archive"></i> anp-icon-archive</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrows"><i class=" anp-icon-arrows"></i> anp-icon-arrows</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrows-h"><i class=" anp-icon-arrows-h"></i> anp-icon-arrows-h</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrows-v"><i class=" anp-icon-arrows-v"></i> anp-icon-arrows-v</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-asterisk"><i class=" anp-icon-asterisk"></i> anp-icon-asterisk</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-ban"><i class=" anp-icon-ban"></i> anp-icon-ban</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bar-chart-o"><i class=" anp-icon-bar-chart-o"></i> anp-icon-bar-chart-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-barcode"><i class=" anp-icon-barcode"></i> anp-icon-barcode</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bars"><i class=" anp-icon-bars"></i> anp-icon-bars</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-beer"><i class=" anp-icon-beer"></i> anp-icon-beer</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bell"><i class=" anp-icon-bell"></i> anp-icon-bell</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bell-o"><i class=" anp-icon-bell-o"></i> anp-icon-bell-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bolt"><i class=" anp-icon-bolt"></i> anp-icon-bolt</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-book"><i class=" anp-icon-book"></i> anp-icon-book</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bookmark"><i class=" anp-icon-bookmark"></i> anp-icon-bookmark</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bookmark-o"><i class=" anp-icon-bookmark-o"></i> anp-icon-bookmark-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-briefcase"><i class=" anp-icon-briefcase"></i> anp-icon-briefcase</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bug"><i class=" anp-icon-bug"></i> anp-icon-bug</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-building-o"><i class=" anp-icon-building-o"></i> anp-icon-building-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bullhorn"><i class=" anp-icon-bullhorn"></i> anp-icon-bullhorn</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bullseye"><i class=" anp-icon-bullseye"></i> anp-icon-bullseye</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-calendar"><i class=" anp-icon-calendar"></i> anp-icon-calendar</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-calendar-o"><i class=" anp-icon-calendar-o"></i> anp-icon-calendar-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-camera"><i class=" anp-icon-camera"></i> anp-icon-camera</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-camera-retro"><i class=" anp-icon-camera-retro"></i> anp-icon-camera-retro</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-down"><i class=" anp-icon-caret-square-o-down"></i> anp-icon-caret-square-o-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-left"><i class=" anp-icon-caret-square-o-left"></i> anp-icon-caret-square-o-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-right"><i class=" anp-icon-caret-square-o-right"></i> anp-icon-caret-square-o-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-up"><i class=" anp-icon-caret-square-o-up"></i> anp-icon-caret-square-o-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-certificate"><i class=" anp-icon-certificate"></i> anp-icon-certificate</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-check"><i class=" anp-icon-check"></i> anp-icon-check</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-check-circle"><i class=" anp-icon-check-circle"></i> anp-icon-check-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-check-circle-o"><i class=" anp-icon-check-circle-o"></i> anp-icon-check-circle-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-check-square"><i class=" anp-icon-check-square"></i> anp-icon-check-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-check-square-o"><i class=" anp-icon-check-square-o"></i> anp-icon-check-square-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-circle"><i class=" anp-icon-circle"></i> anp-icon-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-circle-o"><i class=" anp-icon-circle-o"></i> anp-icon-circle-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-clock-o"><i class=" anp-icon-clock-o"></i> anp-icon-clock-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-cloud"><i class=" anp-icon-cloud"></i> anp-icon-cloud</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-cloud-download"><i class=" anp-icon-cloud-download"></i> anp-icon-cloud-download</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-cloud-upload"><i class=" anp-icon-cloud-upload"></i> anp-icon-cloud-upload</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-code"><i class=" anp-icon-code"></i> anp-icon-code</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-code-fork"><i class=" anp-icon-code-fork"></i> anp-icon-code-fork</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-coffee"><i class=" anp-icon-coffee"></i> anp-icon-coffee</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-cog"><i class=" anp-icon-cog"></i> anp-icon-cog</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-cogs"><i class=" anp-icon-cogs"></i> anp-icon-cogs</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-comment"><i class=" anp-icon-comment"></i> anp-icon-comment</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-comment-o"><i class=" anp-icon-comment-o"></i> anp-icon-comment-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-comments"><i class=" anp-icon-comments"></i> anp-icon-comments</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-comments-o"><i class=" anp-icon-comments-o"></i> anp-icon-comments-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-compass"><i class=" anp-icon-compass"></i> anp-icon-compass</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-credit-card"><i class=" anp-icon-credit-card"></i> anp-icon-credit-card</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-crop"><i class=" anp-icon-crop"></i> anp-icon-crop</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-crosshairs"><i class=" anp-icon-crosshairs"></i> anp-icon-crosshairs</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-cutlery"><i class=" anp-icon-cutlery"></i> anp-icon-cutlery</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tachometer"><i class=" anp-icon-dashboard"></i> anp-icon-dashboard <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-desktop"><i class=" anp-icon-desktop"></i> anp-icon-desktop</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-dot-circle-o"><i class=" anp-icon-dot-circle-o"></i> anp-icon-dot-circle-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-download"><i class=" anp-icon-download"></i> anp-icon-download</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pencil-square-o"><i class=" anp-icon-edit"></i> anp-icon-edit <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-ellipsis-h"><i class=" anp-icon-ellipsis-h"></i> anp-icon-ellipsis-h</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-ellipsis-v"><i class=" anp-icon-ellipsis-v"></i> anp-icon-ellipsis-v</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-envelope"><i class=" anp-icon-envelope"></i> anp-icon-envelope</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-envelope-o"><i class=" anp-icon-envelope-o"></i> anp-icon-envelope-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-eraser"><i class=" anp-icon-eraser"></i> anp-icon-eraser</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-exchange"><i class=" anp-icon-exchange"></i> anp-icon-exchange</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-exclamation"><i class=" anp-icon-exclamation"></i> anp-icon-exclamation</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-exclamation-circle"><i class=" anp-icon-exclamation-circle"></i> anp-icon-exclamation-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-exclamation-triangle"><i class=" anp-icon-exclamation-triangle"></i> anp-icon-exclamation-triangle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-external-link"><i class=" anp-icon-external-link"></i> anp-icon-external-link</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-external-link-square"><i class=" anp-icon-external-link-square"></i> anp-icon-external-link-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-eye"><i class=" anp-icon-eye"></i> anp-icon-eye</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-eye-slash"><i class=" anp-icon-eye-slash"></i> anp-icon-eye-slash</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-female"><i class=" anp-icon-female"></i> anp-icon-female</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-fighter-jet"><i class=" anp-icon-fighter-jet"></i> anp-icon-fighter-jet</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-film"><i class=" anp-icon-film"></i> anp-icon-film</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-filter"><i class=" anp-icon-filter"></i> anp-icon-filter</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-fire"><i class=" anp-icon-fire"></i> anp-icon-fire</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-fire-extinguisher"><i class=" anp-icon-fire-extinguisher"></i> anp-icon-fire-extinguisher</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-flag"><i class=" anp-icon-flag"></i> anp-icon-flag</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-flag-checkered"><i class=" anp-icon-flag-checkered"></i> anp-icon-flag-checkered</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-flag-o"><i class=" anp-icon-flag-o"></i> anp-icon-flag-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bolt"><i class=" anp-icon-flash"></i> anp-icon-flash <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-flask"><i class=" anp-icon-flask"></i> anp-icon-flask</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-folder"><i class=" anp-icon-folder"></i> anp-icon-folder</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-folder-o"><i class=" anp-icon-folder-o"></i> anp-icon-folder-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-folder-open"><i class=" anp-icon-folder-open"></i> anp-icon-folder-open</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-folder-open-o"><i class=" anp-icon-folder-open-o"></i> anp-icon-folder-open-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-frown-o"><i class=" anp-icon-frown-o"></i> anp-icon-frown-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-gamepad"><i class=" anp-icon-gamepad"></i> anp-icon-gamepad</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-gavel"><i class=" anp-icon-gavel"></i> anp-icon-gavel</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-cog"><i class=" anp-icon-gear"></i> anp-icon-gear <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-cogs"><i class=" anp-icon-gears"></i> anp-icon-gears <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-gift"><i class=" anp-icon-gift"></i> anp-icon-gift</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-glass"><i class=" anp-icon-glass"></i> anp-icon-glass</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-globe"><i class=" anp-icon-globe"></i> anp-icon-globe</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-users"><i class=" anp-icon-group"></i> anp-icon-group <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-hdd-o"><i class=" anp-icon-hdd-o"></i> anp-icon-hdd-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-headphones"><i class=" anp-icon-headphones"></i> anp-icon-headphones</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-heart"><i class=" anp-icon-heart"></i> anp-icon-heart</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-heart-o"><i class=" anp-icon-heart-o"></i> anp-icon-heart-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-home"><i class=" anp-icon-home"></i> anp-icon-home</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-inbox"><i class=" anp-icon-inbox"></i> anp-icon-inbox</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-info"><i class=" anp-icon-info"></i> anp-icon-info</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-info-circle"><i class=" anp-icon-info-circle"></i> anp-icon-info-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-key"><i class=" anp-icon-key"></i> anp-icon-key</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-keyboard-o"><i class=" anp-icon-keyboard-o"></i> anp-icon-keyboard-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-laptop"><i class=" anp-icon-laptop"></i> anp-icon-laptop</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-leaf"><i class=" anp-icon-leaf"></i> anp-icon-leaf</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-gavel"><i class=" anp-icon-legal"></i> anp-icon-legal <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-lemon-o"><i class=" anp-icon-lemon-o"></i> anp-icon-lemon-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-level-down"><i class=" anp-icon-level-down"></i> anp-icon-level-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-level-up"><i class=" anp-icon-level-up"></i> anp-icon-level-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-lightbulb-o"><i class=" anp-icon-lightbulb-o"></i> anp-icon-lightbulb-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-location-arrow"><i class=" anp-icon-location-arrow"></i> anp-icon-location-arrow</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-lock"><i class=" anp-icon-lock"></i> anp-icon-lock</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-magic"><i class=" anp-icon-magic"></i> anp-icon-magic</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-magnet"><i class=" anp-icon-magnet"></i> anp-icon-magnet</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-share"><i class=" anp-icon-mail-forward"></i> anp-icon-mail-forward <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-reply"><i class=" anp-icon-mail-reply"></i> anp-icon-mail-reply <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-mail-reply-all"><i class=" anp-icon-mail-reply-all"></i> anp-icon-mail-reply-all</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-male"><i class=" anp-icon-male"></i> anp-icon-male</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-map-marker"><i class=" anp-icon-map-marker"></i> anp-icon-map-marker</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-meh-o"><i class=" anp-icon-meh-o"></i> anp-icon-meh-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-microphone"><i class=" anp-icon-microphone"></i> anp-icon-microphone</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-microphone-slash"><i class=" anp-icon-microphone-slash"></i> anp-icon-microphone-slash</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-minus"><i class=" anp-icon-minus"></i> anp-icon-minus</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-minus-circle"><i class=" anp-icon-minus-circle"></i> anp-icon-minus-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-minus-square"><i class=" anp-icon-minus-square"></i> anp-icon-minus-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-minus-square-o"><i class=" anp-icon-minus-square-o"></i> anp-icon-minus-square-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-mobile"><i class=" anp-icon-mobile"></i> anp-icon-mobile</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-mobile"><i class=" anp-icon-mobile-phone"></i> anp-icon-mobile-phone <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-money"><i class=" anp-icon-money"></i> anp-icon-money</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-moon-o"><i class=" anp-icon-moon-o"></i> anp-icon-moon-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-music"><i class=" anp-icon-music"></i> anp-icon-music</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pencil"><i class=" anp-icon-pencil"></i> anp-icon-pencil</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pencil-square"><i class=" anp-icon-pencil-square"></i> anp-icon-pencil-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pencil-square-o"><i class=" anp-icon-pencil-square-o"></i> anp-icon-pencil-square-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-phone"><i class=" anp-icon-phone"></i> anp-icon-phone</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-phone-square"><i class=" anp-icon-phone-square"></i> anp-icon-phone-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-picture-o"><i class=" anp-icon-picture-o"></i> anp-icon-picture-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plane"><i class=" anp-icon-plane"></i> anp-icon-plane</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plus"><i class=" anp-icon-plus"></i> anp-icon-plus</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plus-circle"><i class=" anp-icon-plus-circle"></i> anp-icon-plus-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plus-square"><i class=" anp-icon-plus-square"></i> anp-icon-plus-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plus-square-o"><i class=" anp-icon-plus-square-o"></i> anp-icon-plus-square-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-power-off"><i class=" anp-icon-power-off"></i> anp-icon-power-off</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-print"><i class=" anp-icon-print"></i> anp-icon-print</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-puzzle-piece"><i class=" anp-icon-puzzle-piece"></i> anp-icon-puzzle-piece</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-qrcode"><i class=" anp-icon-qrcode"></i> anp-icon-qrcode</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-question"><i class=" anp-icon-question"></i> anp-icon-question</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-question-circle"><i class=" anp-icon-question-circle"></i> anp-icon-question-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-quote-left"><i class=" anp-icon-quote-left"></i> anp-icon-quote-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-quote-right"><i class=" anp-icon-quote-right"></i> anp-icon-quote-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-random"><i class=" anp-icon-random"></i> anp-icon-random</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-refresh"><i class=" anp-icon-refresh"></i> anp-icon-refresh</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-reply"><i class=" anp-icon-reply"></i> anp-icon-reply</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-reply-all"><i class=" anp-icon-reply-all"></i> anp-icon-reply-all</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-retweet"><i class=" anp-icon-retweet"></i> anp-icon-retweet</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-road"><i class=" anp-icon-road"></i> anp-icon-road</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rocket"><i class=" anp-icon-rocket"></i> anp-icon-rocket</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rss"><i class=" anp-icon-rss"></i> anp-icon-rss</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rss-square"><i class=" anp-icon-rss-square"></i> anp-icon-rss-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-search"><i class=" anp-icon-search"></i> anp-icon-search</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-search-minus"><i class=" anp-icon-search-minus"></i> anp-icon-search-minus</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-search-plus"><i class=" anp-icon-search-plus"></i> anp-icon-search-plus</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-share"><i class=" anp-icon-share"></i> anp-icon-share</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-share-square"><i class=" anp-icon-share-square"></i> anp-icon-share-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-share-square-o"><i class=" anp-icon-share-square-o"></i> anp-icon-share-square-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-shield"><i class=" anp-icon-shield"></i> anp-icon-shield</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-shopping-cart"><i class=" anp-icon-shopping-cart"></i> anp-icon-shopping-cart</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sign-in"><i class=" anp-icon-sign-in"></i> anp-icon-sign-in</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sign-out"><i class=" anp-icon-sign-out"></i> anp-icon-sign-out</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-signal"><i class=" anp-icon-signal"></i> anp-icon-signal</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sitemap"><i class=" anp-icon-sitemap"></i> anp-icon-sitemap</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-smile-o"><i class=" anp-icon-smile-o"></i> anp-icon-smile-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort"><i class=" anp-icon-sort"></i> anp-icon-sort</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-alpha-asc"><i class=" anp-icon-sort-alpha-asc"></i> anp-icon-sort-alpha-asc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-alpha-desc"><i class=" anp-icon-sort-alpha-desc"></i> anp-icon-sort-alpha-desc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-amount-asc"><i class=" anp-icon-sort-amount-asc"></i> anp-icon-sort-amount-asc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-amount-desc"><i class=" anp-icon-sort-amount-desc"></i> anp-icon-sort-amount-desc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-asc"><i class=" anp-icon-sort-asc"></i> anp-icon-sort-asc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-desc"><i class=" anp-icon-sort-desc"></i> anp-icon-sort-desc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-asc"><i class=" anp-icon-sort-down"></i> anp-icon-sort-down <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-numeric-asc"><i class=" anp-icon-sort-numeric-asc"></i> anp-icon-sort-numeric-asc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-numeric-desc"><i class=" anp-icon-sort-numeric-desc"></i> anp-icon-sort-numeric-desc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort-desc"><i class=" anp-icon-sort-up"></i> anp-icon-sort-up <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-spinner"><i class=" anp-icon-spinner"></i> anp-icon-spinner</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-square"><i class=" anp-icon-square"></i> anp-icon-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-square-o"><i class=" anp-icon-square-o"></i> anp-icon-square-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-star"><i class=" anp-icon-star"></i> anp-icon-star</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-star-half"><i class=" anp-icon-star-half"></i> anp-icon-star-half</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-star-half-o"><i class=" anp-icon-star-half-empty"></i> anp-icon-star-half-empty <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-star-half-o"><i class=" anp-icon-star-half-full"></i> anp-icon-star-half-full <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-star-half-o"><i class=" anp-icon-star-half-o"></i> anp-icon-star-half-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-star-o"><i class=" anp-icon-star-o"></i> anp-icon-star-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-subscript"><i class=" anp-icon-subscript"></i> anp-icon-subscript</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-suitcase"><i class=" anp-icon-suitcase"></i> anp-icon-suitcase</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sun-o"><i class=" anp-icon-sun-o"></i> anp-icon-sun-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-superscript"><i class=" anp-icon-superscript"></i> anp-icon-superscript</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tablet"><i class=" anp-icon-tablet"></i> anp-icon-tablet</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tachometer"><i class=" anp-icon-tachometer"></i> anp-icon-tachometer</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tag"><i class=" anp-icon-tag"></i> anp-icon-tag</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tags"><i class=" anp-icon-tags"></i> anp-icon-tags</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tasks"><i class=" anp-icon-tasks"></i> anp-icon-tasks</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-terminal"><i class=" anp-icon-terminal"></i> anp-icon-terminal</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-thumb-tack"><i class=" anp-icon-thumb-tack"></i> anp-icon-thumb-tack</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-thumbs-down"><i class=" anp-icon-thumbs-down"></i> anp-icon-thumbs-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-thumbs-o-down"><i class=" anp-icon-thumbs-o-down"></i> anp-icon-thumbs-o-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-thumbs-o-up"><i class=" anp-icon-thumbs-o-up"></i> anp-icon-thumbs-o-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-thumbs-up"><i class=" anp-icon-thumbs-up"></i> anp-icon-thumbs-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-ticket"><i class=" anp-icon-ticket"></i> anp-icon-ticket</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-times"><i class=" anp-icon-times"></i> anp-icon-times</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-times-circle"><i class=" anp-icon-times-circle"></i> anp-icon-times-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-times-circle-o"><i class=" anp-icon-times-circle-o"></i> anp-icon-times-circle-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tint"><i class=" anp-icon-tint"></i> anp-icon-tint</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-down"><i class=" anp-icon-toggle-down"></i> anp-icon-toggle-down <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-left"><i class=" anp-icon-toggle-left"></i> anp-icon-toggle-left <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-right"><i class=" anp-icon-toggle-right"></i> anp-icon-toggle-right <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-up"><i class=" anp-icon-toggle-up"></i> anp-icon-toggle-up <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-trash-o"><i class=" anp-icon-trash-o"></i> anp-icon-trash-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-trophy"><i class=" anp-icon-trophy"></i> anp-icon-trophy</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-truck"><i class=" anp-icon-truck"></i> anp-icon-truck</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-umbrella"><i class=" anp-icon-umbrella"></i> anp-icon-umbrella</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-unlock"><i class=" anp-icon-unlock"></i> anp-icon-unlock</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-unlock-alt"><i class=" anp-icon-unlock-alt"></i> anp-icon-unlock-alt</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-sort"><i class=" anp-icon-unsorted"></i> anp-icon-unsorted <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-upload"><i class=" anp-icon-upload"></i> anp-icon-upload</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-user"><i class=" anp-icon-user"></i> anp-icon-user</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-users"><i class=" anp-icon-users"></i> anp-icon-users</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-video-camera"><i class=" anp-icon-video-camera"></i> anp-icon-video-camera</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-volume-down"><i class=" anp-icon-volume-down"></i> anp-icon-volume-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-volume-off"><i class=" anp-icon-volume-off"></i> anp-icon-volume-off</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-volume-up"><i class=" anp-icon-volume-up"></i> anp-icon-volume-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-exclamation-triangle"><i class=" anp-icon-warning"></i> anp-icon-warning <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-wheelchair"><i class=" anp-icon-wheelchair"></i> anp-icon-wheelchair</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-wrench"><i class=" anp-icon-wrench"></i> anp-icon-wrench</a></div>
    
  </div>

		  </div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-3">
			 Form Control Icons
			</a>
		  </h4>
		</div>
		<div id="font-collapse-3" class="panel-collapse collapse">
		  <div class="panel-body">
			  <div class="row fontawesome-icon-list">  

				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-check-square"><i class=" anp-icon-check-square"></i> anp-icon-check-square</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-check-square-o"><i class=" anp-icon-check-square-o"></i> anp-icon-check-square-o</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-circle"><i class=" anp-icon-circle"></i> anp-icon-circle</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-circle-o"><i class=" anp-icon-circle-o"></i> anp-icon-circle-o</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-dot-circle-o"><i class=" anp-icon-dot-circle-o"></i> anp-icon-dot-circle-o</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-minus-square"><i class=" anp-icon-minus-square"></i> anp-icon-minus-square</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-minus-square-o"><i class=" anp-icon-minus-square-o"></i> anp-icon-minus-square-o</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plus-square"><i class=" anp-icon-plus-square"></i> anp-icon-plus-square</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plus-square-o"><i class=" anp-icon-plus-square-o"></i> anp-icon-plus-square-o</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-square"><i class=" anp-icon-square"></i> anp-icon-square</a></div>
				
				  <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-square-o"><i class=" anp-icon-square-o"></i> anp-icon-square-o</a></div>
				
			  </div>
		  </div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-4">
			Currency Icons
			</a>
		  </h4>
		</div>
		<div id="font-collapse-4" class="panel-collapse collapse">
		  <div class="panel-body">
			
  <div class="row fontawesome-icon-list">
    

    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-btc"><i class=" anp-icon-bitcoin"></i> anp-icon-bitcoin <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-btc"><i class=" anp-icon-btc"></i> anp-icon-btc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-jpy"><i class=" anp-icon-cny"></i> anp-icon-cny <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-usd"><i class=" anp-icon-dollar"></i> anp-icon-dollar <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-eur"><i class=" anp-icon-eur"></i> anp-icon-eur</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-eur"><i class=" anp-icon-euro"></i> anp-icon-euro <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-gbp"><i class=" anp-icon-gbp"></i> anp-icon-gbp</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-inr"><i class=" anp-icon-inr"></i> anp-icon-inr</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-jpy"><i class=" anp-icon-jpy"></i> anp-icon-jpy</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-krw"><i class=" anp-icon-krw"></i> anp-icon-krw</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-money"><i class=" anp-icon-money"></i> anp-icon-money</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-jpy"><i class=" anp-icon-rmb"></i> anp-icon-rmb <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rub"><i class=" anp-icon-rouble"></i> anp-icon-rouble <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rub"><i class=" anp-icon-rub"></i> anp-icon-rub</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-rub"><i class=" anp-icon-ruble"></i> anp-icon-ruble <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-inr"><i class=" anp-icon-rupee"></i> anp-icon-rupee <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-try"><i class=" anp-icon-try"></i> anp-icon-try</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-try"><i class=" anp-icon-turkish-lira"></i> anp-icon-turkish-lira <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-usd"><i class=" anp-icon-usd"></i> anp-icon-usd</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-krw"><i class=" anp-icon-won"></i> anp-icon-won <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-jpy"><i class=" anp-icon-yen"></i> anp-icon-yen <span class="text-muted">(alias)</span></a></div>
    
  </div>
	
		  </div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-5">
			 Text Editor Icons
			</a>
		  </h4>
		</div>
		<div id="font-collapse-5" class="panel-collapse collapse">
		  <div class="panel-body">
			<div class="row fontawesome-icon-list">
    

    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-align-center"><i class=" anp-icon-align-center"></i> anp-icon-align-center</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-align-justify"><i class=" anp-icon-align-justify"></i> anp-icon-align-justify</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-align-left"><i class=" anp-icon-align-left"></i> anp-icon-align-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-align-right"><i class=" anp-icon-align-right"></i> anp-icon-align-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bold"><i class=" anp-icon-bold"></i> anp-icon-bold</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-link"><i class=" anp-icon-chain"></i> anp-icon-chain <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chain-broken"><i class=" anp-icon-chain-broken"></i> anp-icon-chain-broken</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-clipboard"><i class=" anp-icon-clipboard"></i> anp-icon-clipboard</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-columns"><i class=" anp-icon-columns"></i> anp-icon-columns</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-files-o"><i class=" anp-icon-copy"></i> anp-icon-copy <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-scissors"><i class=" anp-icon-cut"></i> anp-icon-cut <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-outdent"><i class=" anp-icon-dedent"></i> anp-icon-dedent <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-eraser"><i class=" anp-icon-eraser"></i> anp-icon-eraser</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-file"><i class=" anp-icon-file"></i> anp-icon-file</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-file-o"><i class=" anp-icon-file-o"></i> anp-icon-file-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-file-text"><i class=" anp-icon-file-text"></i> anp-icon-file-text</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-file-text-o"><i class=" anp-icon-file-text-o"></i> anp-icon-file-text-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-files-o"><i class=" anp-icon-files-o"></i> anp-icon-files-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-floppy-o"><i class=" anp-icon-floppy-o"></i> anp-icon-floppy-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-font"><i class=" anp-icon-font"></i> anp-icon-font</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-indent"><i class=" anp-icon-indent"></i> anp-icon-indent</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-italic"><i class=" anp-icon-italic"></i> anp-icon-italic</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-link"><i class=" anp-icon-link"></i> anp-icon-link</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-list"><i class=" anp-icon-list"></i> anp-icon-list</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-list-alt"><i class=" anp-icon-list-alt"></i> anp-icon-list-alt</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-list-ol"><i class=" anp-icon-list-ol"></i> anp-icon-list-ol</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-list-ul"><i class=" anp-icon-list-ul"></i> anp-icon-list-ul</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-outdent"><i class=" anp-icon-outdent"></i> anp-icon-outdent</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-paperclip"><i class=" anp-icon-paperclip"></i> anp-icon-paperclip</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-clipboard"><i class=" anp-icon-paste"></i> anp-icon-paste <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-repeat"><i class=" anp-icon-repeat"></i> anp-icon-repeat</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-undo"><i class=" anp-icon-rotate-left"></i> anp-icon-rotate-left <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-repeat"><i class=" anp-icon-rotate-right"></i> anp-icon-rotate-right <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-floppy-o"><i class=" anp-icon-save"></i> anp-icon-save <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-scissors"><i class=" anp-icon-scissors"></i> anp-icon-scissors</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-strikethrough"><i class=" anp-icon-strikethrough"></i> anp-icon-strikethrough</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-table"><i class=" anp-icon-table"></i> anp-icon-table</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-text-height"><i class=" anp-icon-text-height"></i> anp-icon-text-height</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-text-width"><i class=" anp-icon-text-width"></i> anp-icon-text-width</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-th"><i class=" anp-icon-th"></i> anp-icon-th</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-th-large"><i class=" anp-icon-th-large"></i> anp-icon-th-large</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-th-list"><i class=" anp-icon-th-list"></i> anp-icon-th-list</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-underline"><i class=" anp-icon-underline"></i> anp-icon-underline</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-undo"><i class=" anp-icon-undo"></i> anp-icon-undo</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chain-broken"><i class=" anp-icon-unlink"></i> anp-icon-unlink <span class="text-muted">(alias)</span></a></div>
    
  </div>

		  </div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-6">
			 Directional Icons
			</a>
		  </h4>
		</div>
		<div id="font-collapse-6" class="panel-collapse collapse">
		  <div class="panel-body">
			
  <div class="row fontawesome-icon-list">
    

    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-angle-double-down"><i class=" anp-icon-angle-double-down"></i> anp-icon-angle-double-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-angle-double-left"><i class=" anp-icon-angle-double-left"></i> anp-icon-angle-double-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-angle-double-right"><i class=" anp-icon-angle-double-right"></i> anp-icon-angle-double-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-angle-double-up"><i class=" anp-icon-angle-double-up"></i> anp-icon-angle-double-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-angle-down"><i class=" anp-icon-angle-down"></i> anp-icon-angle-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-angle-left"><i class=" anp-icon-angle-left"></i> anp-icon-angle-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-angle-right"><i class=" anp-icon-angle-right"></i> anp-icon-angle-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-angle-up"><i class=" anp-icon-angle-up"></i> anp-icon-angle-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-down"><i class=" anp-icon-arrow-circle-down"></i> anp-icon-arrow-circle-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-left"><i class=" anp-icon-arrow-circle-left"></i> anp-icon-arrow-circle-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-o-down"><i class=" anp-icon-arrow-circle-o-down"></i> anp-icon-arrow-circle-o-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-o-left"><i class=" anp-icon-arrow-circle-o-left"></i> anp-icon-arrow-circle-o-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-o-right"><i class=" anp-icon-arrow-circle-o-right"></i> anp-icon-arrow-circle-o-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-o-up"><i class=" anp-icon-arrow-circle-o-up"></i> anp-icon-arrow-circle-o-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-right"><i class=" anp-icon-arrow-circle-right"></i> anp-icon-arrow-circle-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-circle-up"><i class=" anp-icon-arrow-circle-up"></i> anp-icon-arrow-circle-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-down"><i class=" anp-icon-arrow-down"></i> anp-icon-arrow-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-left"><i class=" anp-icon-arrow-left"></i> anp-icon-arrow-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-right"><i class=" anp-icon-arrow-right"></i> anp-icon-arrow-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrow-up"><i class=" anp-icon-arrow-up"></i> anp-icon-arrow-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrows"><i class=" anp-icon-arrows"></i> anp-icon-arrows</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrows-alt"><i class=" anp-icon-arrows-alt"></i> anp-icon-arrows-alt</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrows-h"><i class=" anp-icon-arrows-h"></i> anp-icon-arrows-h</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrows-v"><i class=" anp-icon-arrows-v"></i> anp-icon-arrows-v</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-down"><i class=" anp-icon-caret-down"></i> anp-icon-caret-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-left"><i class=" anp-icon-caret-left"></i> anp-icon-caret-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-right"><i class=" anp-icon-caret-right"></i> anp-icon-caret-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-down"><i class=" anp-icon-caret-square-o-down"></i> anp-icon-caret-square-o-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-left"><i class=" anp-icon-caret-square-o-left"></i> anp-icon-caret-square-o-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-right"><i class=" anp-icon-caret-square-o-right"></i> anp-icon-caret-square-o-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-up"><i class=" anp-icon-caret-square-o-up"></i> anp-icon-caret-square-o-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-up"><i class=" anp-icon-caret-up"></i> anp-icon-caret-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chevron-circle-down"><i class=" anp-icon-chevron-circle-down"></i> anp-icon-chevron-circle-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chevron-circle-left"><i class=" anp-icon-chevron-circle-left"></i> anp-icon-chevron-circle-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chevron-circle-right"><i class=" anp-icon-chevron-circle-right"></i> anp-icon-chevron-circle-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chevron-circle-up"><i class=" anp-icon-chevron-circle-up"></i> anp-icon-chevron-circle-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chevron-down"><i class=" anp-icon-chevron-down"></i> anp-icon-chevron-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chevron-left"><i class=" anp-icon-chevron-left"></i> anp-icon-chevron-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chevron-right"><i class=" anp-icon-chevron-right"></i> anp-icon-chevron-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-chevron-up"><i class=" anp-icon-chevron-up"></i> anp-icon-chevron-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-hand-o-down"><i class=" anp-icon-hand-o-down"></i> anp-icon-hand-o-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-hand-o-left"><i class=" anp-icon-hand-o-left"></i> anp-icon-hand-o-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-hand-o-right"><i class=" anp-icon-hand-o-right"></i> anp-icon-hand-o-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-hand-o-up"><i class=" anp-icon-hand-o-up"></i> anp-icon-hand-o-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-long-arrow-down"><i class=" anp-icon-long-arrow-down"></i> anp-icon-long-arrow-down</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-long-arrow-left"><i class=" anp-icon-long-arrow-left"></i> anp-icon-long-arrow-left</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-long-arrow-right"><i class=" anp-icon-long-arrow-right"></i> anp-icon-long-arrow-right</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-long-arrow-up"><i class=" anp-icon-long-arrow-up"></i> anp-icon-long-arrow-up</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-down"><i class=" anp-icon-toggle-down"></i> anp-icon-toggle-down <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-left"><i class=" anp-icon-toggle-left"></i> anp-icon-toggle-left <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-right"><i class=" anp-icon-toggle-right"></i> anp-icon-toggle-right <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-caret-square-o-up"><i class=" anp-icon-toggle-up"></i> anp-icon-toggle-up <span class="text-muted">(alias)</span></a></div>
    
  </div>
	
		  </div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-7">
			Video Player Icons
			</a>
		  </h4>
		</div>
		<div id="font-collapse-7" class="panel-collapse collapse">
		  <div class="panel-body">
			 <div class="row fontawesome-icon-list">
    

    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-arrows-alt"><i class=" anp-icon-arrows-alt"></i> anp-icon-arrows-alt</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-backward"><i class=" anp-icon-backward"></i> anp-icon-backward</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-compress"><i class=" anp-icon-compress"></i> anp-icon-compress</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-eject"><i class=" anp-icon-eject"></i> anp-icon-eject</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-expand"><i class=" anp-icon-expand"></i> anp-icon-expand</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-fast-backward"><i class=" anp-icon-fast-backward"></i> anp-icon-fast-backward</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-fast-forward"><i class=" anp-icon-fast-forward"></i> anp-icon-fast-forward</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-forward"><i class=" anp-icon-forward"></i> anp-icon-forward</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pause"><i class=" anp-icon-pause"></i> anp-icon-pause</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-play"><i class=" anp-icon-play"></i> anp-icon-play</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-play-circle"><i class=" anp-icon-play-circle"></i> anp-icon-play-circle</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-play-circle-o"><i class=" anp-icon-play-circle-o"></i> anp-icon-play-circle-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-step-backward"><i class=" anp-icon-step-backward"></i> anp-icon-step-backward</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-step-forward"><i class=" anp-icon-step-forward"></i> anp-icon-step-forward</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-stop"><i class=" anp-icon-stop"></i> anp-icon-stop</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-youtube-play"><i class=" anp-icon-youtube-play"></i> anp-icon-youtube-play</a></div>
    
  </div>

		  </div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-8">
			 Brand Icons
			</a>
		  </h4>
		</div>
		<div id="font-collapse-8" class="panel-collapse collapse">
		  <div class="panel-body">
			<div class="row fontawesome-icon-list">
    

    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-adn"><i class=" anp-icon-adn"></i> anp-icon-adn</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-android"><i class=" anp-icon-android"></i> anp-icon-android</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-apple"><i class=" anp-icon-apple"></i> anp-icon-apple</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bitbucket"><i class=" anp-icon-bitbucket"></i> anp-icon-bitbucket</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-bitbucket-square"><i class=" anp-icon-bitbucket-square"></i> anp-icon-bitbucket-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-btc"><i class=" anp-icon-bitcoin"></i> anp-icon-bitcoin <span class="text-muted">(alias)</span></a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-btc"><i class=" anp-icon-btc"></i> anp-icon-btc</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-css3"><i class=" anp-icon-css3"></i> anp-icon-css3</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-dribbble"><i class=" anp-icon-dribbble"></i> anp-icon-dribbble</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-dropbox"><i class=" anp-icon-dropbox"></i> anp-icon-dropbox</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-facebook"><i class=" anp-icon-facebook"></i> anp-icon-facebook</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-facebook-square"><i class=" anp-icon-facebook-square"></i> anp-icon-facebook-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-flickr"><i class=" anp-icon-flickr"></i> anp-icon-flickr</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-foursquare"><i class=" anp-icon-foursquare"></i> anp-icon-foursquare</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-github"><i class=" anp-icon-github"></i> anp-icon-github</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-github-alt"><i class=" anp-icon-github-alt"></i> anp-icon-github-alt</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-github-square"><i class=" anp-icon-github-square"></i> anp-icon-github-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-gittip"><i class=" anp-icon-gittip"></i> anp-icon-gittip</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-google-plus"><i class=" anp-icon-google-plus"></i> anp-icon-google-plus</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-google-plus-square"><i class=" anp-icon-google-plus-square"></i> anp-icon-google-plus-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-html5"><i class=" anp-icon-html5"></i> anp-icon-html5</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-instagram"><i class=" anp-icon-instagram"></i> anp-icon-instagram</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-linkedin"><i class=" anp-icon-linkedin"></i> anp-icon-linkedin</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-linkedin-square"><i class=" anp-icon-linkedin-square"></i> anp-icon-linkedin-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-linux"><i class=" anp-icon-linux"></i> anp-icon-linux</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-maxcdn"><i class=" anp-icon-maxcdn"></i> anp-icon-maxcdn</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pagelines"><i class=" anp-icon-pagelines"></i> anp-icon-pagelines</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pinterest"><i class=" anp-icon-pinterest"></i> anp-icon-pinterest</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-pinterest-square"><i class=" anp-icon-pinterest-square"></i> anp-icon-pinterest-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-renren"><i class=" anp-icon-renren"></i> anp-icon-renren</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-skype"><i class=" anp-icon-skype"></i> anp-icon-skype</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-stack-exchange"><i class=" anp-icon-stack-exchange"></i> anp-icon-stack-exchange</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-stack-overflow"><i class=" anp-icon-stack-overflow"></i> anp-icon-stack-overflow</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-trello"><i class=" anp-icon-trello"></i> anp-icon-trello</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tumblr"><i class=" anp-icon-tumblr"></i> anp-icon-tumblr</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-tumblr-square"><i class=" anp-icon-tumblr-square"></i> anp-icon-tumblr-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-twitter"><i class=" anp-icon-twitter"></i> anp-icon-twitter</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-twitter-square"><i class=" anp-icon-twitter-square"></i> anp-icon-twitter-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-vimeo-square"><i class=" anp-icon-vimeo-square"></i> anp-icon-vimeo-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-vk"><i class=" anp-icon-vk"></i> anp-icon-vk</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-weibo"><i class=" anp-icon-weibo"></i> anp-icon-weibo</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-windows"><i class=" anp-icon-windows"></i> anp-icon-windows</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-xing"><i class=" anp-icon-xing"></i> anp-icon-xing</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-xing-square"><i class=" anp-icon-xing-square"></i> anp-icon-xing-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-youtube"><i class=" anp-icon-youtube"></i> anp-icon-youtube</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-youtube-play"><i class=" anp-icon-youtube-play"></i> anp-icon-youtube-play</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-youtube-square"><i class=" anp-icon-youtube-square"></i> anp-icon-youtube-square</a></div>
    
  </div>

		  </div>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
		  <h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#font-accordion" href="#font-collapse-9">
			 Medical Icons
			</a>
		  </h4>
		</div>
		<div id="font-collapse-9" class="panel-collapse collapse">
		  <div class="panel-body">
			  <div class="row fontawesome-icon-list">
    

    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-ambulance"><i class=" anp-icon-ambulance"></i> anp-icon-ambulance</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-h-square"><i class=" anp-icon-h-square"></i> anp-icon-h-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-hospital-o"><i class=" anp-icon-hospital-o"></i> anp-icon-hospital-o</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-medkit"><i class=" anp-icon-medkit"></i> anp-icon-medkit</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-plus-square"><i class=" anp-icon-plus-square"></i> anp-icon-plus-square</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-stethoscope"><i class=" anp-icon-stethoscope"></i> anp-icon-stethoscope</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-user-md"><i class=" anp-icon-user-md"></i> anp-icon-user-md</a></div>
    
      <div class="anp-icon-hover col-md-4  col-sm-4"><a href="#" class="font-icon-picker" data-icon="anp-icon-wheelchair"><i class=" anp-icon-wheelchair"></i> anp-icon-wheelchair</a></div>
    
  </div>
		  </div>
		</div>
	</div>
</div>  

<input type="hidden" name="AnpIconGen" id="AnpIconGen" value="" />
<br/>
<p><strong><?php    echo t('Link Title');?></strong></p>
<input type="text" name="AnpLlinkTitle" id="AnpLlinkTitle" value="title" class="form-control"/>
<br/><br/>
<p><strong><?php    echo t('Position Of Icon');?></strong></p>
<div id="AnpIconPosition">
<select name="AnpIconPosition" class="AnpIconPosition">

<option value="left">left</option>
<option value="right">right</option>
<option value="none">none</option>
</select>
</div>
<br/>
<a href="#" id="AnpIconMake" class="btn btn-primary"><?php    echo t('Generate HTML');?></a>
</div>
<div style="clear:both;width:100%;height:1px"></div>
<br/><br/>
<textarea id="AnpIconOutput" style="width:95%" name="AnpIconOutput"></textarea>
</div>

	</div>
<script type="text/javascript">
function AnpIconMake() {
			var AnpIconGen=$("#AnpIconGen").val();
			var AnpLlinkTitle=$("#AnpLlinkTitle").val();
			var AnpIconPosition=$("#AnpIconPosition select[name=AnpIconPosition]").val();
			var AnpIconHtml;
			if(AnpIconPosition=="none"){AnpIconHtml=AnpLlinkTitle;}
			else if(AnpIconPosition=="left"){
			AnpIconHtml='<i class="'+ AnpIconGen+'"></i>'  + AnpLlinkTitle;
			}
			else if(AnpIconPosition=="right"){
			AnpIconHtml= AnpLlinkTitle + '<i class="'+ AnpIconGen+'"></i>';
			}

			$('#AnpIconOutput').val(AnpIconHtml);
			
			//focus 
			var textareaOutput=document.getElementById('AnpIconOutput');
			textareaOutput.focus()
			textareaOutput.select();
}

$(function() {
AnpIconMake();
});


$(".font-icon-picker").click(function(event) {
event.preventDefault();
$(".font-icon-picker").removeClass("active");
$(this).addClass("active");
var currentVal=$(this).attr("data-icon");
$("#AnpIconGen").val(currentVal);
$( ".panel-default" ).removeClass("active");
$(this).parent().parent().parent().parent().parent( ".panel-default" ).addClass("active");

});

$("#AnpIconMake").click(function(event) {
event.preventDefault();
AnpIconMake();});
$("select").change(function() {
AnpIconMake();
});
$("input").change(function() {
AnpIconMake();
});

</script>
<?php    echo Loader::helper('concrete/dashboard')->getDashboardPaneFooterWrapper(false);?>
