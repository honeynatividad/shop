<?php require_once(DIR_SYSTEM . 'library/btform.php'); $btform = new Btform();?>
<div id="btnewmenurow">
	<table class="table table-striped table-bordered table-hover">
		<?php if(isset($rows['menu_id'])){ ?>
		<tr><td class="left"><?php echo $text_menu_parent; ?></td>
			<td class="left"><?php echo $btform -> makeSelectHTML($arrmenuid, 'menu_id','', $rows['menu_id']); ?></td></tr>
		<?php } ?>
		<tr><td><?php echo $entry_height; ?></td>
			<td><?php echo $btform -> textField('height',isset($rows['height'])?$rows['height']:'',11,'class="form-control"'); ?></td></tr>
		<tr><td><?php echo $entry_sort_order; ?></td>
			<td><?php echo $btform -> textField('sort_order',isset($rows['sort_order'])?$rows['sort_order']:'',11,'class="form-control"'); ?></td></tr>
		<tr><td><?php echo $entry_status; ?></td>
			<td class="left"><?php echo $btform -> makeSelectHTML($arrstatus, 'status','',isset($rows['status']) ? $rows['status'] : '','class="form-control"'); ?></td></tr>
		<tr><td><?php echo $entry_bg_color; ?></td>
			<td><?php echo $btform -> textField('bg_color',isset($rows['bg_color'])?$rows['bg_color']:'',11,'class="form-control"'); ?>
				<br />				
			<span class="help">Get color code at<a target="_blank" href="http://www.colorpicker.com/"> here</a></span>
			</td>
		<tr><td><?php echo $entry_bg_image; ?></td>
			<td class="left"><div class="image">			
			<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo isset($rows['thumb'])?$rows['thumb']:$no_image; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a>
			<input type="hidden" name="bg_image" value="<?php echo isset($rows['bg_image'])?$rows['bg_image']:''; ?>" id="input-image" />
            </div></td>
	</table>
</div>
<style>
.colorpicker{z-index:9999;}
.ui-dialog, .ui-dialog-content, .ui-widget-content{
	overflow: visible;
}
</style>