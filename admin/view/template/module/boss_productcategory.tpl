<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
					<div class="col-sm-10">
					  <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
					  <?php if ($error_name) { ?>
					  <div class="text-danger"><?php echo $error_name; ?></div>
					  <?php } ?>
					</div>
				</div> 
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
					<div class="col-sm-10">
					  <select name="status" id="input-status" class="form-control">
						<?php if ($status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_title; ?></label>
					<div class="col-sm-10">
					<?php foreach ($languages as $language) { ?>
						<div class="form-group">
						<div class="col-sm-11"><input class="form-control" name="title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($title[$language['language_id']]) ? $title[$language['language_id']] : ''; ?>" /></div>
						<div class="col-sm-1"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></div>
						</div>
					<?php } ?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-type"><?php echo 'Image Background'; ?></label>
					<div class="col-sm-10">
					  <a href="" id="thumb-bgimage" data-toggle="image" class="img-thumbnail"><img src="<?php echo isset($thumbbgimage)?$thumbbgimage:$bgplaceholder; ?>" alt="" title="" data-placeholder="<?php echo $bgplaceholder; ?>" /></a>
					  <input type="hidden" name="bgimage" value="<?php echo $bgimage; ?>" id="input-bgimage" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-type"><?php echo 'Image Product Width'; ?></label>
					<div class="col-sm-10">
						<input type="text" name="image_width" value="<?php echo $image_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-type"><?php echo 'Image Product Height'; ?></label>
					<div class="col-sm-10">
						<input type="text" name="image_height" value="<?php echo $image_height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-image">Limit</label>
					<div class="col-sm-10">
						<input class="form-control" name="limit" value="<?php echo isset($limit)?$limit : ''; ?>" />
					</div>
				</div>
				
				<div class="form-group">
				<table id="menucategory" class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
						  <td class="left"><?php echo 'Title'; ?></td>
						  <td class="left"><?php echo 'Icon'; ?></td>
						  <td class="left"><?php echo 'Category'; ?></td>
						  <td class="left"><?php echo 'Product/row'; ?></td>
						  <td class="left"><?php echo $entry_status; ?></td>
						  <td class="right"><?php echo $entry_sort_order; ?></td>
						  <td></td>
						</tr>
					</thead>
					<tbody class="boss_content">
						<?php foreach($menus as $menu){ ?>
						 <tr id="menu-row<?php echo $menu['key']; ?>">
							<td class="text-left"><?php foreach ($languages as $language) { ?>
							<table class="table table-striped table-hover">
								<tr><td>
								<input name="boss_productcategory_config[<?php echo $menu['key']; ?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($menu['title'][$language['language_id']]) ? $menu['title'][$language['language_id']] : ''; ?>" class="form-control" placeholder="Menu title" /></td>
								<td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>
							</table>
							<?php } ?></td>
							
							<td class="text-left"><a href="" id="thumb-image<?php echo $menu['key']; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo isset($menu['thumbicon'])?$menu['thumbicon']:$placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
							<input type="hidden" name="boss_productcategory_config[<?php echo $menu['key']; ?>][icon]" value="<?php echo $menu['icon']; ?>" id="input-image<?php echo $menu['key']; ?>" class="form-control" /></td>
							
							<td class="left"><select style="width:140px;" name="boss_productcategory_config[<?php echo $menu['key']; ?>][category_id]" class="form-control">
							  <?php foreach ($categories as $category) { ?>
							  <?php if ($category['category_id'] == $menu['category_id']) { ?>
							  <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
							  <?php } else { ?>
							  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
							  <?php } ?>
							  <?php } ?>
							</select></td>
							
							<td class="left">
								<select name="boss_productcategory_config[<?php echo $menu['key']; ?>][per_row]" class="form-control">
								<option value="1" <?php if (isset($menu['per_row']) && $menu['per_row']==1) { echo 'selected="selected"';} ?>>1</option>
								<option value="2" <?php if (isset($menu['per_row']) && $menu['per_row']==2) { echo 'selected="selected"';} ?>>2</option>
								<option value="3" <?php if (isset($menu['per_row']) && $menu['per_row']==3) { echo 'selected="selected"';} ?>>3</option>
								<option value="4" <?php if (isset($menu['per_row']) && $menu['per_row']==4) { echo 'selected="selected"';} ?>>4</option>
							</select></td>
							  
							<td class="left"><select name="boss_productcategory_config[<?php echo $menu['key']; ?>][status]" class="form-control">
							  <?php if ($menu['status']) { ?>
							  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							  <option value="0"><?php echo $text_disabled; ?></option>
							  <?php } else { ?>
							  <option value="1"><?php echo $text_enabled; ?></option>
							  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							  <?php } ?>
							</select></td>
							<td class="right"><input type="text" name="boss_productcategory_config[<?php echo $menu['key']; ?>][sort_order]" value="<?php echo $menu['sort_order']; ?>" size="3" class="form-control" /></td>
							
							<td class="text-left"><button type="button" onclick="$('#menu-row<?php echo $menu['key']; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
						</tr>
						<?php } ?>
					</tbody>
					<tfoot>
					  <tr>
						<td colspan="6"></td>
						<td class="text-left"><button type="button" onclick="addMenu();" data-toggle="tooltip" title="<?php echo $button_add_menu; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
					  </tr>
					</tfoot>
				</table>
				</div>
				
			</form>
		</div>
	</div>
</div>
<script type="text/javascript"><!--

function addMenu() {
	var token = Math.random().toString(36).substr(2);

	html  = '<tr id="menu-row' + token + '">';
	html += '    <td class="left">';
	<?php foreach ($languages as $language) { ?>
	html += ' <table class="table table-striped table-hover">';
	html += ' <tr><td>';
	html += '      <input name="boss_productcategory_config[' + token + '][title][<?php echo $language['language_id']; ?>]" placeholder="Menu Title" class="form-control" /></td>';
    html += '    <td>  <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr></table>';
    <?php } ?>
    html += '    </td>';
	
	html += '  <td class="text-left"><a href="" id="thumb-image' + token + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="boss_productcategory_config['+ token +'][icon]" value="" id="input-image' + token + '" /></td>';
	
	html += '    <td class="left"><select style="width:140px;" name="boss_productcategory_config[' + token + '][category_id]" class="form-control">';
	<?php foreach ($categories as $category) { ?>
    html += '      <option value="<?php echo $category['category_id']; ?>"><?php echo addslashes($category['name']); ?></option>';
	 <?php } ?>
    html += '    </select></td>';
	html += '<td class="left">';
	html += ' <select name="boss_productcategory_config[' + token + '][per_row]" class="form-control">';
	html += '<option value="1" selected="selected" >1</option>';
	html += '<option value="2">2</option>';
	html += '<option value="3">3</option>';
	html += '<option value="4">4</option>';
	html += '</select></td>';
	html += '    <td class="left"><select name="boss_productcategory_config[' + token + '][status]" class="form-control">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="boss_productcategory_config[' + token + '][sort_order]" value="0" size="3" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#menu-row' + token  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '  </tr>';
	
	$('.boss_content').append(html);
};
//--></script> 
<?php echo $footer; ?>