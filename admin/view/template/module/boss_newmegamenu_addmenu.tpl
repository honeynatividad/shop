<?php require_once(DIR_SYSTEM . 'library/btform.php'); $btform = new Btform();?>
<div id="btnewmenu">
	<table class="table table-striped table-bordered table-hover">
		<tr><td class="text-left"><?php echo $text_menu_title; ?></td>
			<td class="text-left">
			<table class="table table-striped table-bordered table-hover">
			<?php foreach ($languages as $language) { ?>
				<tr><td>
				<?php echo $btform -> textField('menudes['.$language['language_id'].'][title]',isset($menu_description[$language['language_id']]['title'])?$menu_description[$language['language_id']]['title']:'',50,'class="form-control" placeholder="'.$text_title_default.'"'); ?></td>
				<td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>
			<?php } ?></table></td></tr>
			
		<tr><td><?php echo $entry_num_column; ?></td>
			<td class="left"><?php echo $btform -> makeSelectHTML($arrcolumns, 'num_column','',isset($menus['num_column']) ? $menus['num_column'] : ''); ?></td></tr>
			
		<tr><td><?php echo $entry_url; ?></td>
			<td><input type="text" value="<?php echo isset($menus['url'])?$menus['url']:'#'; ?>" name="url" class="form-control" placeholder="<?php echo $entry_url; ?>" /></td></tr>
		<tr><td><?php echo $entry_sort_order; ?></td>
			<td><?php echo $btform -> textField('sort_order',isset($menus['sort_order'])?$menus['sort_order']:'',11); ?></td></tr>
		<tr><td><?php echo $entry_status; ?></td>
			<td class="left"><?php echo $btform -> makeSelectHTML($arrstatus, 'status','',isset($menus['status']) ? $menus['status'] : ''); ?></td></tr>
		<tr><td class="left"><?php echo $text_menu_label; ?></td>
			<td class="left">
			<table class="table table-striped table-bordered table-hover">
			<?php foreach ($languages as $language) { ?>
				<tr><td><?php echo $btform -> textField('menudes['.$language['language_id'].'][label]',isset($menu_description[$language['language_id']]['label'])?$menu_description[$language['language_id']]['label']:'',50); ?></td>
				<td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>
			<?php } ?></table></td></tr>
		<tr><td><?php echo $entry_label_color; ?></td>
			<td><?php echo $btform -> textField('label_color',isset($menus['label_color'])?$menus['label_color']:'',11); ?><br />
			<span class="help">Get color code at<a target="_blank" href="http://www.colorpicker.com/"> here</a></span></td></tr>
		<tr><td><?php echo $entry_icon; ?></td>
			<td class="left"><div class="image">			
			<a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo isset($menus['thumb'])?$menus['thumb']:$no_image; ?>" alt="" title="" data-placeholder="<?php echo $no_image; ?>" /></a>
			<input type="hidden" name="icon" value="<?php echo isset($menus['icon'])?$menus['icon']:''; ?>" id="input-image" />
            </div></td></tr>
		<tr><td><?php echo $entry_icon_class; ?></td>
			<td class="left">
			<table class="table table-striped table-bordered table-hover">
			<tr><td>Show</td>
			<td><?php echo $btform -> makeSelectHTML($arrstatus, 'icon_class_status','',isset($menus['icon_class_status']) ? $menus['icon_class_status'] : ''); ?></td></tr>
			<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="Add class icon bootstrap ...exp: glyphicon glyphicon-search"><?php echo $icon_class_css; ?></span><label><br />Link icon: <a target="_blank" href=" http://getbootstrap.com/components/">Bootstrap icon</a></td>
			<td><?php echo $btform -> textField('icon_class',isset($menus['icon_class'])?$menus['icon_class']:'',50); ?></td>			
			</tr></table></td>
	</table>
</div>