<?php require_once(DIR_SYSTEM . 'library/btform.php'); $btform = new Btform(); global $config; ?>
<?php echo $header; ?><?php echo $column_left; ?>
<?php if(!empty($slides)){ ?>
<?php $slideset = json_decode($slides['slideset'], true);?>
<?php $captions = json_decode($slides['caption'], true);?>
<?php if(!empty($slider_settings)){$setting = json_decode($slider_settings['setting'], true);}?>
<?php } ?>

<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<button type="submit" form="form-sliderform" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sliderform" class="form-horizontal">
					<div class="slide-general-setting">
						<h3 class="bt-heading">General Slide Setting</h3>
						<div class="bt-noaccordion">
							<table class="table table-striped table-bordered table-hover">
								<tr><td><label><?php echo $entry_status; ?></label></td><td>
									<?php echo $btform -> makeSelectHTML($arrstatus, 'status','',isset($slides['status']) ? $slides['status'] : ''); ?></td></tr>
									
								<tr><td><label><?php echo 'Url';?></label></td><td>
									<input type="text" name="slideset[url]" size="30" value="<?php echo isset($slideset['url']) ? $slideset['url'] : '#'; ?>" class="form-control" /></td></tr>
								
								<tr><td><label><?php echo 'Sort Order';?></label></td><td>
									<?php echo $btform -> textField('sort_order',isset($slides['sort_order']) ? $slides['sort_order'] : '0',3); ?></td></tr>
								<tr><td><label><?php echo $text_enable_link; ?></label></td><td>
									<?php echo $btform -> makeSelectHTML($arrstatus, 'slideset[enablelink]','',isset($slideset['enablelink']) ? $slideset['enablelink'] : ''); ?></td></tr>
									
								<tr><td><?php echo $text_background; ?></td>
								<td class="left">
									<input type="radio" name="slideset[type_background]" value="image_bg" <?php if(isset($slideset['type_background']) && ($slideset['type_background'] == "image_bg")) echo "checked=checked";?> onclick="changeContentBackground('image_bg')"/><?php echo $text_image;?>
									<input type="radio" name="slideset[type_background]" value="color_bg" <?php if(isset($slideset['type_background']) &&($slideset['type_background'] == "color_bg")) echo "checked=checked";?> onclick="changeContentBackground('color_bg')"/><?php echo $text_color;?>
									<input type="radio" name="slideset[type_background]" value="transparent_bg" <?php if(isset($slideset['type_background']) &&($slideset['type_background'] == "transparent_bg")) echo "checked=checked";?> <?php echo isset($slideset['type_background'])?'':'checked'; ?> onclick="changeContentBackground('transparent_bg')"/><?php echo $text_transparent;?></td></tr>
									<tr id="tr_content_background">
									<?php if(isset($slideset['type_background'])&&($slideset['type_background'] == "image_bg")) { ?>
										<td><?php echo $text_image; ?><td class="text-left"><a href="" id="thumb" data-toggle="image" class="img-thumbnail"><img style="width:200px;height:100px;" src="<?php echo '../image/'.$slideset['background']; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a><input type="hidden" name="slideset[background]" value="<?php echo $slideset['background']; ?>" id="image" /><hr>
										<input class="btn btn-primary" type="button" onclick="addslideprev();" value="Apply background preview" /></td>
										
									<?php } ?>
									<?php if(isset($slideset['type_background'])&&($slideset['type_background'] == "color_bg")) { ?>
										<td><?php echo $text_color; ?></td><td class="left">
										<input id="color_bg"  type="text" name="slideset[background]" onfocus="colorEvent('color_bg');EYE.register(colorEvent, 'init');" value="<?php echo $slideset['background']?>" style="background-color:<?php echo $slideset['background'];?>"/></td>
									<?php } ?>
									<?php if(isset($slideset['type_background'])&&($slideset['type_background'] == "transparent_bg")) { ?>
										<input type="hidden" name="slideset[background]" value="<?php echo $slideset['background']?>"/>
									<?php } ?>
									</tr>
							</table>
						</div>
					</div>
					
					<div class="slide-animation-setting form-group">
						<h3 class="bt-heading">Animation Setting</h3>
						<div class="bt-noaccordion openNav">
							<table class="table table-striped table-bordered table-hover">
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_transition_des;?>" ><?php echo $text_transition;?></span></label></td><td><select name="slideset[transitions]">
									<?php foreach($transitions as $tran) {?>
										<option <?php echo (isset($slideset['transitions'])&&($slideset['transitions']==$tran))?'selected':''; ?> value="<?php echo $tran;?>"><?php echo $tran;?></option>
									<?php }?></td></tr>

								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_slot_amount_des;?>" ><?php echo $text_slot_amount;?></span></label></td><td>
									<?php echo $btform -> textField('slideset[slotamount]',isset($slideset['slotamount']) ? $slideset['slotamount'] : '7',20); ?></td></tr>
							  
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_master_speed_des;?>" ><?php echo $text_master_speed;?></span></label></td><td>
									<?php echo $btform -> textField('slideset[masterspeed]',isset($slideset['masterspeed']) ? $slideset['masterspeed'] : '500',20); ?></td></tr>
									
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_delay_des;?>" ><?php echo $text_delay;?></span></label></td><td>
									<?php echo $btform -> textField('slideset[delay]',isset($slideset['delay']) ? $slideset['delay'] : '5000',20); ?></td></tr>
			
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_target_des;?>" ><?php echo $text_target;?></span></label></td><td>
								<?php $target = array("_self" => "_self","_blank" => "_blank");?>
									<?php echo $btform -> makeSelectHTML($target, 'slideset[target]','',isset($slideset['target']) ? $slideset['target'] : ''); ?></td></tr>
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_target_des;?>" ><?php echo 'Kenburns';?></span></label></td><td>
								<?php $onoff = array("on" => "on","off" => "off");?>
									<?php echo $btform -> makeSelectHTML($onoff, 'slideset[kenburns]','',isset($slideset['kenburns']) ? $slideset['kenburns'] : ''); ?></td></tr>
								
							  
								<tr><td><label><?php echo $text_full_video; ?></label></td><td>
									<?php echo $btform -> makeSelectHTML($arrstatus, 'slideset[enablefullvideo]','',isset($slideset['enablefullvideo']) ? $slideset['enablefullvideo'] : ''); ?></td></tr>
							  
							</table>
						</div>
					</div>
					
					<div class="bt-slide-prev form-group" style="clear:both;">
						<h3 class="bt-heading">Slider Preview</h3>
						<div id="bt_slide_prev" class="bt-noaccordion" style="<?php if(isset($setting['slider_type'])&&($setting['slider_type'] == "fullscreen")) { ?>width:100%;<?php }else{ ?> width:<?php echo isset($setting['slider_width']) ? $setting['slider_width'] : '1200';?>px;<?php } ?>height:<?php echo isset($setting['slider_height']) ? $setting['slider_height'] : '500';?>px;<?php if(isset($slideset['type_background'])&&($slideset['type_background'] == "image_bg")) { ?>background-image:url('../image/<?php echo $slideset['background']; ?>');background-repeat: no-repeat;<?php } ?> <?php if(isset($slideset['type_background'])&&($slideset['type_background'] == "color_bg")) { ?> background:<?php echo $slideset['background']; ?>; <?php } ?> <?php if(isset($slideset['type_background'])&&($slideset['type_background'] == "transparent_bg")) { ?> background-image:url('../image/transparent.png');background-repeat: repeat; <?php } ?> background-size: cover;background-position: center top;">
							<?php $caption_main_row = 0;?>
							<?php if(isset($captions)){ foreach($captions as $caption){ ?>
								<div id="caption_<?php echo $caption_main_row; ?>" class="caption tp-caption <?php echo isset($caption['class_css']) ? $caption['class_css'] : 'big_white';?> ui-widget ui-draggable" onclick="showCaption(<?php echo $caption_main_row; ?>)" style="top:<?php echo isset($caption['datay']) ? $caption['datay'] : '100';?>px;left:<?php echo isset($caption['datax']) ? $caption['datax'] : '100';?>px;position:absolute;">
								<?php if(isset($caption['type_caption'])&&($caption['type_caption']=='image')){?>
								<img src="../image/<?php echo $caption['image_caption']; ?>" alt="" id="thumb_caption_image<?php echo $caption_main_row; ?>">
								<?php }elseif(isset($caption['type_caption'])&&($caption['type_caption']=='video')){?>
								<?php if($caption['type_capvideo']=='youtube'){ ?>
								<img src="http://img.youtube.com/vi/<?php echo $caption['video_id']; ?>/default.jpg" style="width: <?php echo $caption['video_width']; ?>px; height: <?php echo $caption['video_height']; ?>px;" alt="" id="thumb_caption_image<?php echo $caption_main_row; ?>">
								<?php }elseif($caption['type_capvideo']=='vimeo'){ ?>
								<?php $hash = unserialize(@file_get_contents("http://vimeo.com/api/v2/video/".$caption['video_id'].".php"));?>
								<img src="<?php echo isset($hash[0]['thumbnail_large'])?$hash[0]['thumbnail_medium']:$no_image; ?>" style="width: <?php echo $caption['video_width']; ?>px; height: <?php echo $caption['video_height']; ?>px;" alt="" id="thumb_caption_image<?php echo $caption_main_row; ?>">
								<?php } else{ ?>
								<img src="<?php echo $no_image; ?>" style="width: <?php echo $caption['video_width']; ?>px; height: <?php echo $caption['video_height']; ?>px;" alt="" id="thumb_caption_image<?php echo $caption_main_row; ?>">
								<?php } ?>
								<?php }else{?>
								<?php echo html_entity_decode(isset($caption['text_caption'][$config->get('config_language_id')]) ? $caption['text_caption'][$config->get('config_language_id')] : 'Text Example '.$caption_main_row,ENT_QUOTES, 'UTF-8');?>
								<?php } ?>
								</div>
							<?php $caption_main_row++; } } ?>
						</div>
					</div>
					<div class="bt-button form-group">
						<p><a class="btn btn-primary" onclick="addCaption('text');" >Add text caption</a> <a class="btn btn-info" onclick="addCaption('image');" >Add image caption</a> <a class="btn btn-success" onclick="addCaption('video');" >Add video caption</a> <a class="btn btn-danger" id="bt_delete_all" onclick="deleteAllCaption();" >Delete All Captions</a></p>
					</div>
					<?php $caption_row = 0;?>
					<?php if(isset($captions)){ foreach($captions as $caption){ ?>
					<div id="caption_detail_<?php echo $caption_row; ?>" class="caption-detail" style="display:none;">
						<div class="bt-caption-setting">
							<h3 class="bt-heading">Caption Setting</h3>
							<div class="bt-noaccordion">
								<table class="table table-striped table-bordered table-hover">
									
									
									<?php if(isset($caption['type_caption'])&&($caption['type_caption']=='image')){?>
									<tr><td><label class="control-label"><span><?php echo 'Image caption'; ?></span></label></td>
									<td class="left"><a href="" id="image_cpation_detail<?php echo $caption_row; ?>" data-toggle="image" class="img-thumbnail"><img style="width:100px; height:100px;" src="<?php echo '../image/'.$caption['image_caption']; ?>" alt="image caption" /></a>
									<input type="hidden" name="caption[<?php echo $caption_row; ?>][image_caption]" value="<?php echo $caption['image_caption']; ?>" id="caption_image<?php echo $caption_row; ?>"><hr><input class="btn btn-primary" type="button" onclick="addcaptionprev('caption_image<?php echo $caption_row; ?>','thumb_caption_image<?php echo $caption_row; ?>');" value="Apply caption preview">  </td></tr>
									<?php }elseif(isset($caption['type_caption'])&&($caption['type_caption']=='video')){?>
									<tr><td>Video type:</td>
									<td><input type="radio" <?php if(isset($caption['type_capvideo']) && ($caption['type_capvideo'] == "youtube")) echo "checked=checked";?> name="caption[<?php echo $caption_row; ?>][type_capvideo]" value="youtube" />Youtube<input type="radio" <?php if(isset($caption['type_capvideo']) && ($caption['type_capvideo'] == "vimeo")) echo "checked=checked";?> name="caption[<?php echo $caption_row; ?>][type_capvideo]" value="vimeo" />Vimeo <input type="radio" <?php if(isset($caption['type_capvideo']) && ($caption['type_capvideo'] == "video_url")) echo "checked=checked";?> name="caption[<?php echo $caption_row; ?>][type_capvideo]" value="video_url" />URL</td>
									</tr>
									<tr>
									<td>Video Id or URL:</td>
									<td><input class="form-control" oninput="" type="text" name="caption[<?php echo $caption_row; ?>][video_id]" value="<?php echo isset($caption['video_id']) ? $caption['video_id'] : 'xE0uUdoB_o4';?>"/><p class="help clear">Example: youtube: xE0uUdoB_o4 and Vimeo: 76127035</p></td>
									</tr>
									<tr>
									<td>Video size (Width x Height):</td>
									<td><input class="form-control" oninput="" type="text" name="caption[<?php echo $caption_row; ?>][video_width]" value="<?php echo isset($caption['video_width']) ? $caption['video_width'] : '200';?>" size=5 /> - <input class="form-control" oninput="" type="text" name="caption[<?php echo $caption_row; ?>][video_height]" value="<?php echo isset($caption['video_height']) ? $caption['video_height'] : '200';?>" size=5/></td>
									</tr>
									<?php }else{?>
									<tr><td><label><?php echo $text_text.'123'; ?></label></td><td class="left">
									<?php foreach ($languages as $language) { ?><textarea <?php if($config->get('config_language_id')==$language['language_id']){ ?> oninput="changeTextCaption(<?php echo $caption_row; ?>,this.value)" <?php } ?> style="width:90%; height:60px;" name="caption[<?php echo $caption_row; ?>][text_caption][<?php echo $language['language_id']; ?>]"><?php echo isset($caption['text_caption'][$language['language_id']]) ? $caption['text_caption'][$language['language_id']] : 'Text Example '.$caption_row;?></textarea> <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><br /><?php } ?>
									</td></tr>
									<?php } ?>
									
									
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_datax_des;?>" ><?php echo $text_datax;?></span></label></td><td class="left"><input class="form-control" oninput="changeDatax(<?php echo $caption_row; ?>,this.value)" type="text" name="caption[<?php echo $caption_row; ?>][datax]" value="<?php echo isset($caption['datax']) ? $caption['datax'] : '100';?>"/><input type="hidden" name="caption[<?php echo $caption_row; ?>][type_caption]" value="<?php echo isset($caption['type_caption']) ? $caption['type_caption'] : 'text';?>"></td></tr> 
										
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_datay_des;?>" ><?php echo $text_datay;?></span></label></td><td class="left"><input class="form-control" type="text" oninput="changeDatay(<?php echo $caption_row; ?>,this.value)" name="caption[<?php echo $caption_row; ?>][datay]" value="<?php echo isset($caption['datay']) ? $caption['datay'] : '100';?>"/></td></tr>
										
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_class_css_des;?>" ><?php echo $text_class_css;?></span></label></td><td class="left"><select onchange="changeClass(<?php echo $caption_row; ?>,this.value)" name="caption[<?php echo $caption_row; ?>][class_css]">
									  <?php foreach($class_css as $class) {?>
										<option value="<?php echo $class;?>" <?php echo ($caption['class_css']==$class)?'selected':'';?>><?php echo $class;?></option>
									  <?php } ?>
									  </select></td></tr> 
									 
									 <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_under_width_des;?>" ><?php echo $text_under_width;?></span></label></td><td class="left"><input class="form-control" type="checkbox" <?php echo isset($caption['hideunderwidth']) ? 'checked' : '';?> name="caption[<?php echo $caption_row; ?>][hideunderwidth]" value="<?php echo isset($caption['hideunderwidth']) ? $caption['hideunderwidth'] : '';?>" /></td></tr>
									 
								</table>
							</div>
						</div>
						
						
						<div class="bt-caption-sort">
							<h3 class="bt-heading">Caption List</h3>
							<div class="bt-noaccordion">
								<table class="table table-striped table-bordered table-hover">
									 <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_data_speed_des;?>" ><?php echo $text_data_speed;?></span></label></td><td class="left"><?php echo $btform -> textField('caption['.$caption_row.'][dataspeed]',isset($caption['dataspeed']) ? $caption['dataspeed'] : '500',20); ?></td></tr>
									  
									  <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_data_start_des;?>" ><?php echo $text_data_start;?></span></label></td><td class="left"><?php echo $btform -> textField('caption['.$caption_row.'][datastart]',isset($caption['datastart']) ? $caption['datastart'] : '0',20); ?></td></tr>
									  
									  <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_data_end_des;?>" ><?php echo $text_data_end;?></span></label></td><td class="left">
									  <?php echo $btform -> textField('caption['.$caption_row.'][dataend]',isset($caption['dataend']) ? $caption['dataend'] : '5000',20); ?></td></tr>
									  
									 <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_data_after_speed_des;?>" ><?php echo $text_data_after_speed;?></span></label></td><td class="left">
									 <?php echo $btform -> textField('caption['.$caption_row.'][dataafterspeed]',isset($caption['dataafterspeed']) ? $caption['dataafterspeed'] : '100',20); ?></td></tr>
									 
									 <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_incom_animation_des;?>" ><?php echo $text_incom_animation;?></span></label></td><td class="left">
										<?php echo $btform -> makeSelectHTML($incom_animation, 'caption['.$caption_row.'][incom_animation]','',isset($caption['incom_animation']) ? $caption['incom_animation'] : ''); ?></td></tr>
										
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_outgo_animation_des;?>" ><?php echo $text_outgo_animation;?></span></label></td><td class="left">
										<?php echo $btform -> makeSelectHTML($outgo_animation, 'caption['.$caption_row.'][outgo_animation]','',isset($caption['outgo_animation']) ? $caption['outgo_animation'] : ''); ?></td></tr> 
										  
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_easing_des;?>" ><?php echo $text_easing;?></span></label></td><td class="left">
										<select name="caption[<?php echo $caption_row; ?>][easing]" class="form-control">
										<?php foreach($easing as $e) {?>
											<option <?php echo ($e==$caption['easing'])?'selected':''; ?> value="<?php echo $e;?>"><?php echo $e;?></option>
										<?php } ?>
										</select></td></tr>
										  
									<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_endeasing_des;?>" ><?php echo $text_endeasing;?></span></label></td><td class="left">
										<select name="caption[<?php echo $caption_row; ?>][endeasing]" class="form-control">
										<?php foreach($easing as $e) {?>
										  <option <?php echo ($e==$caption['endeasing'])?'selected':''; ?> value="<?php echo $e;?>"><?php echo $e;?></option>
										  <?php } ?>
										</select></td></tr>
								</table>
							</div>
						</div>
					
					</div>
					
					<?php $caption_row++; }} ?>
					<div id="new_caption">&nbsp;</div>
				<div id="formdata" title="Add Video"></div>	
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--

<?php $caption_js_row = 0; ?>
<?php if(isset($captions)){ foreach($captions as $caption){ ?>
$('#caption_<?php echo $caption_js_row; ?>').draggable({
	drag: function(){
		var xPos = $(this).css("left");
		var yPos = $(this).css("top");
		xPos = xPos.replace(/\D/g, "");
		yPos = yPos.replace(/\D/g, "");
		$('input[name=\'caption[<?php echo $caption_js_row; ?>][datax]\']').val(xPos);
		$('input[name=\'caption[<?php echo $caption_js_row; ?>][datay]\']').val(yPos);
	}
});
<?php $caption_js_row++; } } ?>
	


var caption_row = <?php echo (isset($captions))?count($captions):0; ?>;
function addCaption(type){
	$('.caption-detail').css("display",'none');
	
	var html = '<div id="caption_detail_'+caption_row+'" class="caption-detail">';
		html +=' <div class="bt-caption-setting">';
		html +=' <h3 class="bt-heading">Caption Setting</h3>';
		html +='  <div class="bt-noaccordion">';
		html +='	<table class="table table-striped table-bordered table-hover">';
		if(type=='text'){
		html += '  <tr><td><label><?php echo $text_text; ?></label></td><td class="left"><?php foreach ($languages as $language) { ?><textarea <?php if($config->get('config_language_id')==$language['language_id']){ ?> oninput="changeTextCaption('+caption_row+',this.value)" <?php } ?> style="width:90%; height:60px;" name="caption['+caption_row+'][text_caption][<?php echo $language['language_id']; ?>]">Text Example '+caption_row+'</textarea> <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><br /><?php } ?></td></tr> ';
		}else if(type=='image'){
		html += '  <tr><td><label><?php echo $text_text; ?></label></td><td class="left">';
		
		html += '  <a href="" id="image_cpation_detail'+caption_row+'" data-toggle="image" class="img-thumbnail"><img src="<?php echo $no_image; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a><input type="hidden" name="caption['+caption_row+'][image_caption]" value="" id="caption_image'+caption_row+'" /><hr><input class="btn btn-primary" type="button" onclick="addcaptionprev(\'caption_image'+caption_row+'\',\'thumb_caption_image'+caption_row+'\');" value="Apply caption preview" />';
		html += '  </td></tr> ';
		}else if(type=='video'){
		html += '<tr><td>Video type:</td>';
		html += '<td><input type="radio" checked name="caption['+caption_row+'][type_capvideo]" value="youtube" />Youtube<input type="radio" name="caption['+caption_row+'][type_capvideo]" value="vimeo" />Vimeo <input type="radio" name="caption['+caption_row+'][type_capvideo]" value="video_url" class="form-control" />URL</td>';
		html += '</tr>';
		html += '<tr>';
		html += '<td>Video Id or URL:</td>';
		html += '<td><input oninput="" type="text" name="caption['+caption_row+'][video_id]" value="xE0uUdoB_o4" class="form-control" /><p class="help clear">Example: xE0uUdoB_o4</p></td>';
		html += '</tr>';
		html += '<tr>';
		html += '<td>Video size (Width x Height):</td>';
		html += '<td><input class="form-control" oninput="" type="text" name="caption['+caption_row+'][video_width]" value="" size=5 /> - <input oninput="" type="text" name="caption['+caption_row+'][video_height]" value="" size=5 class="form-control" /></td>';
		html += '</tr>';
		}
		html +='    <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_datax_des;?>" ><?php echo $text_datax;?></span></label></td><td class="left"><input type="text" oninput="changeDatax('+caption_row+',this.value)" name="caption['+caption_row+'][datax]" value="100" class="form-control" />';
		html += '  <input type="hidden" name="caption['+caption_row+'][type_caption]" value="'+type+'"/>';
		html +='	</td></tr>';
								
		html +='	<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_datay_des;?>" ><?php echo $text_datay;?></span></label></td><td class="left"><input oninput="changeDatay('+caption_row+',this.value)" type="text" name="caption['+caption_row+'][datay]" value="100" class="form-control" />';
		html +='	</td></tr>';
								
		html +='	<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_class_css_des;?>" ><?php echo $text_class_css;?></span></label></td><td class="left"><select onchange="changeClass('+caption_row+',this.value)" name="caption['+caption_row+'][class_css]" class="form-control" >';
			<?php foreach($class_css as $class) {?>
		html +='<option value="<?php echo $class;?>"><?php echo $class;?></option>';
			<?php } ?>
		html +='    </select></td></tr>';
							 
		html +='    <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_under_width_des;?>" ><?php echo $text_under_width;?></span></label></td><td class="left"><input type="checkbox" name="caption['+caption_row+'][hideunderwidth]" value="100" class="form-control" /></td></tr>';
		html +='     </table>';
		html +='    </div>';
		html +='</div>';
				
				
		html +='<div class="bt-caption-sort">';
		html +=' <h3 class="bt-heading">Caption Animation</h3>';
		html +='   <div class="bt-noaccordion">';
		html +='  <table class="table table-striped table-bordered table-hover">';
		html +='  <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_data_speed_des;?>" ><?php echo $text_data_speed;?></span></label></td><td class="left"><input type="text" name="caption['+caption_row+'][dataspeed]" value="100" class="form-control" /></td></tr>';
							  
		html +=' <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_data_start_des;?>" ><?php echo $text_data_start;?></span></label></td><td class="left"><input type="text" name="caption['+caption_row+'][datastart]" value="100" class="form-control" /></td></tr>';
							  
		html +=' <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_data_end_des;?>" ><?php echo $text_data_end;?></span></label></td><td class="left"><input type="text" name="caption['+caption_row+'][dataend]" value="100" class="form-control" /></td></tr>';
							  
		html +=' <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_data_after_speed_des;?>" ><?php echo $text_data_after_speed;?></span></label></td><td class="left"><input type="text" name="caption['+caption_row+'][dataafterspeed]" value="100" class="form-control" /></td></tr>';
		
		html +='		<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_incom_animation_des;?>" ><?php echo $text_incom_animation;?></span></label></td><td class="left"><select name="caption['+caption_row+'][incom_animation]" class="form-control">';
			<?php foreach($incom_animation as $key=>$value) {?>
		html +='        <option value="<?php echo $key;?>"><?php echo $value;?></option>';
			<?php } ?>
		html +='        </select></td></tr>';
								
		html +=' 	<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_outgo_animation_des;?>" ><?php echo $text_outgo_animation;?></span></label></td><td class="left"><select name="caption['+caption_row+'][outgo_animation]" class="form-control">';
			<?php foreach($outgo_animation as $key=>$value) {?>
		html +='     <option value="<?php echo $key;?>"><?php echo $value;?></option>';
			<?php } ?>
		html +='    </select></td></tr> ';
								  
		html +='    <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_easing_des;?>" ><?php echo $text_easing;?></span></label></td><td class="left"><select name="caption['+caption_row+'][easing]" class="form-control">';
			<?php foreach($easing as $e) {?>
		html +='    <option value="<?php echo $e;?>"><?php echo $e;?></option>';
			<?php } ?>
		html +='    </select></td></tr>';
								  
		html +='    <tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_endeasing_des;?>" ><?php echo $text_endeasing;?></span></label></td><td class="left"><select name="caption['+caption_row+'][endeasing]" class="form-control">';
			<?php foreach($easing as $e) {?>
		html +='   <option value="<?php echo $e;?>"><?php echo $e;?></option>';
			<?php } ?>
		html +='   </select></td></tr>';
							 
		html +=' </table>';
		html +='</div>';
		html +='</div>';
			
		html +='</div>';
	
	$('#new_caption').before(html);
	
	if(type=='text'){
	var caption = '<div id="caption_'+caption_row+'" class="caption tp-caption big_white ui-widget" onclick="showCaption('+caption_row+')" style="top:100px;left:100px;position:absolute;">Text Example '+caption_row+'</div>';
	
	}else if(type=='image'){
	var caption = '<div id="caption_'+caption_row+'" class="caption tp-caption big_white ui-widget" onclick="showCaption('+caption_row+')" style="top:100px;left:100px;position:absolute;"><img alt="image" src="<?php echo $no_image; ?>" id="thumb_caption_image'+caption_row+'"/></div>';
	}else if(type=='video'){
	var caption = '<div id="caption_'+caption_row+'" class="caption tp-caption big_white ui-widget" onclick="showCaption('+caption_row+')" style="top:100px;left:100px;position:absolute;"><img src="https://i.ytimg.com/vi/xE0uUdoB_o4/mqdefault.jpg" /></div>';
	//addVideo();
	}
	
	$('#bt_slide_prev').append(caption);
	
	caption_new = caption_row;
	
	caption_row++;
	
	$('#caption_'+caption_new).draggable({
		drag: function(){
			var xPos = $(this).css("left");
			var yPos = $(this).css("top");
			xPos = xPos.replace(/\D/g, "");
			yPos = yPos.replace(/\D/g, "");
			$('input[name=\'caption['+caption_new+'][datax]\']').val(xPos);
			$('input[name=\'caption['+caption_new+'][datay]\']').val(yPos);
		}
	});
}

function changeContentBackground(type_background) {
	if(type_background == 'image_bg'){
		$("#bt_slide_prev").css('background', "none");
		html = '  <td><?php echo $text_image; ?></td><td class="text-left"><a href="" id="thumb" data-toggle="image" class="img-thumbnail"><img src="<?php echo $no_image; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a><input type="hidden" name="slideset[background]" value="" id="image" /><hr><input class="btn btn-primary" type="button" onclick="addslideprev();" value="Apply background preview" /></td>';
	}else if (type_background == 'color_bg'){
		$("#bt_slide_prev").css('background-image', "none");
		html = '<td><?php echo $text_color; ?></td><td><input id="color_bg"  type="text" name="slideset[background]" onfocus="colorEvent(\'color_bg\');EYE.register(colorEvent, \'init\');"/></td>';
	}else{
		html = '<input type="hidden" name="slideset[background]" value="catalog/transparent.png"/>';
		$("#bt_slide_prev").css('background-image', "url(../image/catalog/transparent.png)");
		$("#bt_slide_prev").css('background-repeat', "repeat");
		$("#bt_slide_prev").css('background-color', "transparent");
	}
	$('#tr_content_background').html(html);
}

function addVideo(){
	$.ajax({
		url: 'index.php?route=module/boss_revolutionslider/addVideo&token=<?php echo $token; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('.loading').html('<span class="wait">&nbsp;<img src="../admin/view/image/loading.gif" alt="" /></span>');
		},		
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			if (json['output']) {		
				$( "#formdata" ).html(json['output']);
				$( "#formdata" ).dialog({ 
					width: 790 , 
					buttons:[{ text: "Save",
								click: function() {saveVideo(id);}
							 },
							 {  text: "Cancel",
								click: function() { $(this).dialog("close");}
							}]
				});	
			}
		}
	});
}

function deleteCaption(caption_id){
	if (!confirm('<?php echo $text_confirm; ?>')) {
		return false;
	}else{
		$('#caption_'+caption_id).remove();
		$('#caption_detail_'+caption_id).remove();
		$('#bt_delete'+caption_id).remove();
	}
}
function deleteAllCaption(){
	if (!confirm('<?php echo $text_confirm; ?>')) {
		return false;
	}else{
		$('.tp-caption').remove();
		$('.caption-detail').remove();
		$('.delete-caption').remove();
		$('#bt_delete_all').remove();
	}
}

//--></script>
<script type="text/javascript"><!--
function addslideprev() {
	$("#bt_slide_prev").css('background-image', "url(../image/"+$('#image').attr('value')+")");
	$("#bt_slide_prev").css('background-repeat', "no-repeat");
}

function addcaptionprev($id,thumb){
	$('#' + thumb).replaceWith('<img src="../image/'+$('#' + $id).attr('value')+'" alt="" id="' + thumb + '" />');
}

function image_upload_caption(field, thumb,thumb2) {
    $('#dialog').remove();
	
    $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
    $('#dialog').dialog({
        title: '<?php echo $text_image_manager; ?>',
        close: function (event, ui) {
          if ($('#' + field).attr('value')) {
            $.ajax({
              url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
              dataType: 'text',
              success: function(data) {
                $('#' + thumb).replaceWith('<img src="../image/'+$('#' + field).attr('value')+'" alt="" id="' + thumb + '" />');
				$('#' + thumb2).replaceWith('<img src="' + data + '" alt="" id="' + thumb2 + '" />');
              }
            });
          }
        },	
        bgiframe: false,
        width: 700,
        height: 400,
        resizable: false,
        modal: false
    });
};
//--></script> 
<?php echo $footer; ?>