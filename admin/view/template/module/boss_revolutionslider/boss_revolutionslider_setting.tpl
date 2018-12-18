<?php require_once(DIR_SYSTEM . 'library/btform.php'); $btform = new Btform();?>
<?php echo $header; ?><?php echo $column_left; ?>
<?php if(!empty($slider_settings)){$setting = json_decode($slider_settings['setting'], true);}?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<button type="submit" form="form-slidersetting" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
			<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
		  <h1><?php echo $heading_title; ?></h1>
		  <ul class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
			<?php } ?>
		  </ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if ($error_warning) { ?>
		<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-slidersetting" class="form-horizontal">
					<div class="module-setting bt-box">
						<h3 class="bt-mheading">Module Setting</h3>
						<div class="bt-maccordion">
							<?php $module_row = $slider_id;?>
							<table class="table table-striped table-bordered table-hover">
								<tr>
									<tr><td><label class="col-sm-2 control-label" for="input-name"><?php echo 'Name'; ?></label></td>
									<td><input type="text" name="module[name]" value="<?php echo isset($module['name'])?$module['name']:''; ?>" placeholder="<?php echo 'Name'; ?>" id="input-name" class="form-control" />
									<?php if ($error_name) { ?>
									  <div class="text-danger"><?php echo $error_name; ?></div>
									<?php } ?>
									</td>
								</tr> 
								<tr><td><label><?php echo $entry_status; ?></label></td>
									<td><?php echo $btform -> makeSelectHTML($arrstatus, 'module[status]','',isset($module['status']) ? $module['status'] : ''); ?></td></tr>
								<tr><td><label><?php echo 'Slider Layout:';?></label></td><td>
									<div class="radio_inner_wrapper">
										<input type="radio" id="slider_type_2" value="custom" <?php echo (isset($setting['slider_type'])&&($setting['slider_type'] == 'custom')) ?'checked=checked' : '';?> name="setting[slider_type]">
										<label for="slider_type_2" style="cursor:pointer;">Custom</label>
									</div>
									<div class="radio_inner_wrapper">
										<input type="radio" id="slider_type_4" value="fullscreen" <?php echo (isset($setting['slider_type'])&&($setting['slider_type'] == 'fullscreen')) ?'checked=checked' : '';?> name="setting[slider_type]">
										<label for="slider_type_4" style="cursor:pointer;">Full Width</label>
									</div></td></tr>
									
								<tr> <td><label><?php echo 'Slider Width';?></label></td><td>
									<?php echo $btform -> textField('setting[slider_width]',isset($setting['slider_width']) ? $setting['slider_width'] : '1200',10); ?><?php if ($error_width) { ?>
									  <div class="text-danger"><?php echo $error_width; ?></div>
									<?php } ?></td></tr>
									
								<tr> <td><label><?php echo 'Slider Height';?></label></td><td>
									<?php echo $btform -> textField('setting[slider_height]',isset($setting['slider_height']) ? $setting['slider_height'] : '500',10); ?><?php if ($error_height) { ?>
									  <div class="text-danger"><?php echo $error_height; ?></div>
									<?php } ?></td></tr>
								<tr><td colspan="2"><input type="hidden" name="module[slider_id]" value="<?php echo $slider_id; ?>" /></td></tr>
								
							</table>
						</div>
						<div id="bt-show" class="lp-fullscreen" style="display: block;">
							<h3 class="bt-mheading">Layout Example</h3>
							<div class="clear">&nbsp;</div>
							<div id="bt-show-page">
									<div class="layout-preshow-text">BROWSER</div>
								<div id="bt-show-theme">
										<div class="layout-preshow-text">PAGE</div>
								</div>
								<div id="bt-show-slider">
										<div class="layout-preshow-text">SLIDER</div>
								</div>
							</div>
						</div>
					</div>
					<div class="slider-setting">
						<div class="general-setting bt-box">
							<h3 class="bt-heading openNav"><div class="bt-arrow"></div>General Setting</h3>
							<div class="bt-accordion openNav">
								<table class="table table-striped table-bordered table-hover"><tbody>
									<tr> <td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_delay_option_des;?>" ><?php echo $text_delay;?></span></label></td><td>
										<?php echo $btform -> textField('setting[delay]',isset($setting['delay']) ? $setting['delay'] : '5000',30); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_startWithSlide_des;?>" ><?php echo $text_startWithSlide;?></span></label></td><td>
										<?php echo $btform -> textField('setting[startWithSlide]',isset($setting['startWithSlide']) ? $setting['startWithSlide'] : '0',30); ?></td></tr>
									
									<tr> <td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_touchenabled_des;?>" ><?php echo 'Stop Slider:';?></span></label></td><td>
										<?php echo $btform -> makeSelectHTML($arronoff, 'setting[stopslider]','',isset($setting['stopslider']) ? $setting['stopslider'] : ''); ?></td></tr>
									
									<tr> <td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_startwidth_option_des;?>" ><?php echo 'Stop After Loops';?></span></label></td><td>
										<?php echo $btform -> textField('setting[stopafterloops]',isset($setting['stopafterloops']) ? $setting['stopafterloops'] : '-1',30); ?></td></tr>
									
									<tr> <td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_startheight_option_des;?>" ><?php echo 'Stop At Slide';?></span></label></td><td>
										<?php echo $btform -> textField('setting[stopatslide]',isset($setting['stopatslide']) ? $setting['stopatslide'] : '-1',30); ?></td></tr>
									
									<tr> <td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_touchenabled_des;?>" ><?php echo $text_touchenabled;?></span></label></td><td>
										<?php echo $btform -> makeSelectHTML($arronoff, 'setting[touchenabled]','',isset($setting['touchenabled']) ? $setting['touchenabled'] : ''); ?></td></tr>
										
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_onhoverstop_des;?>" ><?php echo $text_onhoverstop;?></span></label></td><td>
										<?php echo $btform -> makeSelectHTML($arronoff, 'setting[onhoverstop]','',isset($setting['onhoverstop']) ? $setting['onhoverstop'] : ''); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_timeline_des;?>" ><?php echo $text_timeline;?></span></label></td><td>
										<?php $timestatus = array( 'on'=>'Enable','of'=>'Disabled'); ?>
										<?php echo $btform -> makeSelectHTML($timestatus, 'setting[timeline]','',isset($setting['timeline']) ? $setting['timeline'] : ''); ?></td></tr>
									
									<tr> <td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_timerlineposition_des;?>" ><?php echo $text_timerlineposition;?></span></label></td><td>
										<?php $timerlineposition = array("top"=>"Top","bottom"=>"Bottom"); ?>
										<?php echo $btform -> makeSelectHTML($timerlineposition, 'setting[timerlineposition]','',isset($setting['timerlineposition']) ? $setting['timerlineposition'] : ''); ?></td></tr>
									
									<tr> <td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_shadow_des;?>" ><?php echo $text_shadow;?></span></label></td><td>
										<?php $shadow = array("0"=>0,"1"=>1,"2"=>2,"3"=>3); ?>
										<?php echo $btform -> makeSelectHTML($shadow, 'setting[shadow]','',isset($setting['shadow']) ? $setting['shadow'] : ''); ?></td></tr>
								</tbody></table>
							</div>
						</div>
						<div class="nav-setting bt-box">
							<h3 class="bt-heading"><div class="bt-arrow"></div>Navigation Setting</h3>
							<div class="bt-accordion">
								<table class="table table-striped table-bordered table-hover">
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_navigation_type_des;?>" ><?php echo $text_navigation_type;?></span></label></td><td>
										<?php $navigationtypes = array( 'bullet'=>'bullet','thumb'=>'thumb', 'none'=>'none'); ?>
										<?php echo $btform -> makeSelectHTML($navigationtypes, 'setting[navigationtype]','',isset($setting['navigationtype']) ? $setting['navigationtype'] : ''); ?>
										</td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_navigation_arrow_des;?>" ><?php echo $text_navigation_arrow;?></span></label></td><td>
										<?php $navigationarrows = array( 'nexttobullets'=>'nexttobullets','solo'=>'solo'); ?>
										<?php echo $btform -> makeSelectHTML($navigationarrows, 'setting[navigationarrow]','',isset($setting['navigationarrow']) ? $setting['navigationarrow'] : ''); ?>
										</td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_navigation_style_des;?>" ><?php echo $text_navigation_style;?></span></label></td><td>
										<?php $navigationstyles = array("preview1"=>"preview1", "preview2"=>"preview2","preview3"=>"preview3","preview4"=>"preview4","round"=>"round", "square"=>"square", "round-old"=>"round-old", "square-old"=>"square-old", "navbar-old"=>"navbar-old"); ?>
										<?php echo $btform -> makeSelectHTML($navigationstyles, 'setting[navigationstyle]','',isset($setting['navigationstyle']) ? $setting['navigationstyle'] : ''); ?>
										</td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_navigationhalign_des;?>" ><?php echo $text_navigationhalign;?></span></label></td><td>
										<?php $navigationhaligns = array( 'left'=>'left','center'=>'center','right'=>'right'); ?>
										<?php echo $btform -> makeSelectHTML($navigationhaligns, 'setting[navigationhalign]','',isset($setting['navigationhalign']) ? $setting['navigationhalign'] : ''); ?>
										</td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_navigationvalign_des;?>" ><?php echo $text_navigationvalign;?></span></label></td><td>
										<?php $navigationvaligns = array( 'top'=>'top','center'=>'center','bottom'=>'bottom'); ?>
										<?php echo $btform -> makeSelectHTML($navigationvaligns, 'setting[navigationvalign]','',isset($setting['navigationvalign']) ? $setting['navigationvalign'] : ''); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_navigationhoffset_des;?>" ><?php echo $text_navigationhoffset;?></span></label></td><td>
										<?php echo $btform -> textField('setting[navigationhoffset]',isset($setting['navigationhoffset']) ? $setting['navigationhoffset'] : '0',30); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_navigationvoffset_des;?>" ><?php echo $text_navigationvoffset;?></span></label></td><td>
										<?php echo $btform -> textField('setting[navigationvoffset]',isset($setting['navigationvoffset']) ? $setting['navigationvoffset'] : '0',30); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_soloarrowlefthalign_des;?>" ><?php echo $text_soloarrowlefthalign;?></span></label></td><td>
										<?php echo $btform -> makeSelectHTML($navigationhaligns, 'setting[soloarrowlefthalign]','',isset($setting['soloarrowlefthalign']) ? $setting['soloarrowlefthalign'] : ''); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_soloarrowleftvalign_des;?>" ><?php echo $text_soloarrowleftvalign;?></span></label></td><td>
										<?php echo $btform -> makeSelectHTML($navigationvaligns, 'setting[soloarrowleftvalign]','',isset($setting['soloarrowleftvalign']) ? $setting['soloarrowleftvalign'] : ''); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_soloarrowlefthoffset_des;?>" ><?php echo $text_soloarrowlefthoffset;?></span></label></td><td>
										<?php echo $btform -> textField('setting[soloarrowlefthoffset]',isset($setting['soloarrowlefthoffset']) ? $setting['soloarrowlefthoffset'] : '0',30); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_soloarrowleftvoffset_des;?>" ><?php echo $text_soloarrowleftvoffset;?></span></label></td><td>
										<?php echo $btform -> textField('setting[soloarrowleftvoffset]',isset($setting['soloarrowleftvoffset']) ? $setting['soloarrowleftvoffset'] : '0',30); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_soloarrowrighthalign_des;?>" ><?php echo $text_soloarrowrighthalign;?></span></label></td><td>
										<?php echo $btform -> makeSelectHTML($navigationhaligns, 'setting[soloarrowrighthalign]','',isset($setting['soloarrowrighthalign']) ? $setting['soloarrowrighthalign'] : ''); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_soloarrowrightvalign_des;?>" ><?php echo $text_soloarrowrightvalign;?></span></label></td><td>
										<?php echo $btform -> makeSelectHTML($navigationvaligns, 'setting[soloarrowrightvalign]','',isset($setting['soloarrowrightvalign']) ? $setting['soloarrowrightvalign'] : ''); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_soloarrowrighthoffset_des;?>" ><?php echo $text_soloarrowrighthoffset;?></span></label></td><td>
										<?php echo $btform -> textField('setting[soloarrowrighthoffset]',isset($setting['soloarrowrighthoffset']) ? $setting['soloarrowrighthoffset'] : '0',30); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_soloarrowrightvoffset_des;?>" ><?php echo $text_soloarrowrightvoffset;?></span></label></td><td>
										<?php echo $btform -> textField('setting[soloarrowrightvoffset]',isset($setting['soloarrowrightvoffset']) ? $setting['soloarrowrightvoffset'] : '0',30); ?></td></tr>
								</table>
							</div>
						</div>
						<div class="thumb-setting bt-box">
							<h3 class="bt-heading"><div class="bt-arrow"></div>Thumbnails Setting</h3>
							<div class="bt-accordion">
								<table class="table table-striped table-bordered table-hover">
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_timehidethumbnail_des;?>" ><?php echo $text_timehidethumbnail;?></span></label></td><td>
										<?php echo $btform -> textField('setting[timehidethumbnail]',isset($setting['timehidethumbnail']) ? $setting['timehidethumbnail'] : '0',30); ?></td></tr>
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_thumbnailwidth_des;?>" ><?php echo $text_thumbnailwidth;?></span></label></td><td>
										<?php echo $btform -> textField('setting[thumbnailwidth]',isset($setting['thumbnailwidth']) ? $setting['thumbnailwidth'] : '0',30); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_thumbnailheight_des;?>" ><?php echo $text_thumbnailheight;?></span></label></td><td>
										<?php echo $btform -> textField('setting[thumbnailheight]',isset($setting['thumbnailheight']) ? $setting['thumbnailheight'] : '0',30); ?></td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_thumbamount_des;?>" ><?php echo $text_thumbamount;?></span></label></td><td>
										<?php echo $btform -> textField('setting[thumbamount]',isset($setting['thumbamount']) ? $setting['thumbamount'] : '0',30); ?></td></tr>
								</table>
							</div>
						</div>
						<div class="mobile-setting bt-box">
							<h3 class="bt-heading"><div class="bt-arrow"></div>Mobile Setting</h3>
							<div class="bt-accordion">
								<table class="table table-striped table-bordered table-hover">
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_hidecapptionatlimit_des;?>" ><?php echo $text_hidecapptionatlimit;?></span></label></td><td>
										<?php echo $btform -> textField('setting[hidecapptionatlimit]',isset($setting['hidecapptionatlimit']) ? $setting['hidecapptionatlimit'] : '0',30); ?>
										</td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_hideallcapptionatlimit_des;?>" ><?php echo $text_hideallcapptionatlimit;?></span></label></td><td>
										<?php echo $btform -> textField('setting[hideallcapptionatlimit]',isset($setting['hideallcapptionatlimit']) ? $setting['hideallcapptionatlimit'] : '0',30); ?>
										</td></tr>
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_hideslideratlimit_des;?>" ><?php echo $text_hideslideratlimit;?></span></label></td><td>
										<?php echo $btform -> textField('setting[hideslideratlimit]',isset($setting['hideslideratlimit']) ? $setting['hideslideratlimit'] : '0',30); ?></td></tr>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(".bt-heading").click(function(){
	$(this).toggleClass('openNav');
	$(this).next('.bt-accordion').toggleClass('openNav');
});
//--></script>
<?php echo $footer; ?>