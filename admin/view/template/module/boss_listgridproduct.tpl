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
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
	</div>
	<div class="panel-body">	
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-boss_listgridproduct" class="form-horizontal">
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
			<label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
			<div class="col-sm-5">
			  <input type="text" name="image_width" value="<?php echo $image_width; ?>" class="form-control" />
			  <?php if ($error_width) { ?>
				<div class="text-danger"><?php echo $error_width; ?></div>
			  <?php } ?>
			</div>
			<div class="col-sm-5">
			  <input type="text" name="image_height" value="<?php echo $image_height; ?>" class="form-control" />
			  <?php if ($error_height) { ?>
				<div class="text-danger"><?php echo $error_height; ?></div>
			  <?php } ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="limit" id="input-limit" value="<?php echo $limit?$limit:4; ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-per-row"><?php echo $entry_properrow; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="per_row" id="input-per-row" value="<?php echo $per_row?$per_row:2; ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-num-row"><?php echo $entry_numrow; ?></label>
			<div class="col-sm-10">
			  <input type="text" name="num_row" id="input-num-row" value="<?php echo $num_row?$num_row:2; ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-column"><?php echo $entry_column; ?></label>
			<div class="col-sm-10">
				<select name="column" id="input-column" class="form-control large">
					<?php if ($column) { ?>
					<option value="12" selected="selected"><?php echo $column_full; ?></option>
					<option value="6"><?php echo $column_half; ?></option>
					<?php } else { ?>
					<option value="12"><?php echo $column_full; ?></option>
					<option value="6" selected="selected"><?php echo $column_half; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-list-grid"><?php echo $entry_list_grid; ?></label>
			<div class="col-sm-10">
				<select name="list_grid" id="input-list-grid" class="form-control large">
					<?php if ($list_grid) { ?>
					<option value="1" selected="selected"><?php echo $type_grid; ?></option>
					<option value="0"><?php echo $type_list; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $type_grid; ?></option>
					<option value="0" selected="selected"><?php echo $type_list; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
			<div class="col-sm-10">
				<select name="status" id="input-status" class="form-control large">
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
		<div class="row">
			<div class="col-sm-12">
				<table id="tableMoldue" class="table table-striped table-bordered table-hover">
					<thead><tr>
						<td class="left"><?php echo $tab_stt; ?></td>
						<td class="left"><?php echo $tab_title; ?></td>
						<td class="left"><?php echo $tab_sub_title; ?></td>
						<td class="left"><?php echo $tab_get_product; ?></td>
						<td></td></tr>
					</thead>
					<?php $tab_row = 0;?>
					<?php if(isset($module)) { ?>
					<?php foreach($module as $tab) { ?>
					<tbody id="moduletab-row<?php echo $tab_row;?>">
					<tr>
						<td class="left"><?php $tab_stt;?> <b>#<?php echo $tab_row + 1; ?></b></td>
						
						<td class="left">
						  <table class="table table-striped table-bordered table-hover">
							<?php foreach ($languages as $language) { ?>
							<tr><td>
							  <input name="boss_listgridproduct_module[<?php echo $tab_row;?>][title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($tab['title'][$language['language_id']]) ? $tab['title'][$language['language_id']] : ''; ?>" class="form-control" /></td>
							  <td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><br />
							</td></tr>
							<?php } ?>
						  </table>
						</td>
						
						<td class="left">
						  <table class="table table-striped table-bordered table-hover">
							<?php foreach ($languages as $language) { ?>
							<tr><td>
							  <input name="boss_listgridproduct_module[<?php echo $tab_row;?>][sub_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($tab['sub_title'][$language['language_id']]) ? $tab['sub_title'][$language['language_id']] : ''; ?>" class="form-control" /></td>
							  <td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /><br />
							</td></tr>
							<?php } ?>
						  </table>
						</td>
						
						<td class="text-left">
							<select name="boss_listgridproduct_module[<?php echo $tab_row;?>][type_product]" onchange="showCategories(this,<?php echo $tab_row; ?>)" class="form-control">
							<?php foreach($product_types as $key_type=>$text){ ?>
								<option value="<?php echo $key_type;?>" <?php if($tab['type_product'] == $key_type) echo "selected=selected";?>><?php echo $text;?></option>
							<?php } ?>
							</select>

							<?php if ($tab['type_product']  == 'featured') { ?>
								<div id="bt_featured<?php echo $tab_row;?>">
									<input type="text" name="boss_listgridproduct_module[<?php echo $tab_row;?>][listgrid_type_featured]" value="" placeholder="<?php echo $entry_product; ?>" id="input-product-featured" class="form-control" />
									<div id="product-featured-<?php echo $tab_row; ?>" class="well well-sm" style="height: 150px; overflow: auto;">
										<?php foreach ($products as $product) { ?>
											<div id="product-featured-<?php echo $tab_row; ?><?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
											  <input type="hidden" name="boss_listgridproduct_module[<?php echo $tab_row;?>][product_featured][]" value="<?php echo $product['product_id']; ?>" />
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
							
							<?php if ($tab['type_product'] == 'category') { ?>
							  <?php if (isset($error_category[$tab_row])) { ?>
								<div class="text-danger"><?php echo $error_category[$tab_row]; ?></div>
							  <?php } ?>
							  <div class="well well-sm" style="height: 150px; overflow: auto;" id="scrollbox<?php echo $tab_row; ?>">
								<?php foreach ($categories as $category) { ?>
								  <div class="">
									<?php if (isset($tab['listgrid_type_category']) && $category['category_id'] == $tab['listgrid_type_category']) { ?>
									  <input type="radio" name="boss_listgridproduct_module[<?php echo $tab_row;?>][listgrid_type_category]" value="<?php echo $category['category_id']; ?>" checked="checked" />
									  <?php echo $category['name']; ?>
									<?php } else { ?>
									  <input type="radio" name="boss_listgridproduct_module[<?php echo $tab_row;?>][listgrid_type_category]" value="<?php echo $category['category_id']; ?>" />
									  <?php echo $category['name']; ?>
									<?php } ?>
								  </div>
								<?php } ?>
							  </div>
							<?php } ?>
						</td>
						<td class="text-left"><button type="button" onclick="$('#moduletab-row<?php echo $tab_row;?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
					</tr>
					</tbody>
					<?php $tab_row++;?>
					<?php } ?>
					<?php } ?>
					<tfoot><tr><td colspan="4"></td>
					<td class="text-left"><button type="button" onclick="addTab(this,<?php echo $tab_row;?>);" data-toggle="tooltip" title="<?php echo $button_add_tab; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
					</tr></tfoot></table>
			</div>
		</div>
	</form>
	</div>
</div>
</div>
</div>
<script type="text/javascript"><!--
function addTab(btnAddTab,tab_row) {
      html  = '<tbody id="moduletab-row'+tab_row+'">';
      html += '<tr>';
      html += '<td class="left"><b>#' + (tab_row+1) + '</b></td><td class="left">';
	  html += '<table class="table table-striped table-bordered table-hover">';
	  <?php foreach ($languages as $language) { ?>
	  html += '<tr><td>';
	  html += '<input type="input" name="boss_listgridproduct_module[' + tab_row + '][title][<?php echo $language['language_id'];?>]" class="form-control"/></td>';
	  html += '<td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>';
		<?php }?>
	  html += '</table>';
	  html += '</td>';
	  html += '<td class="left">';
	  html += '<table class="table table-striped table-bordered table-hover">';
	  <?php foreach ($languages as $language) { ?>
	  html += '<tr><td>';
	  html += '<input type="input" name="boss_listgridproduct_module[' + tab_row + '][sub_title][<?php echo $language['language_id'];?>]" class="form-control"/></td>';
	  html += '<td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>';
		<?php }?>
	  html += '</table>';
	  html += '</td>';
	  html += '<td class="left">';
	  html += '<select name="boss_listgridproduct_module[' + tab_row + '][type_product]" onchange="showCategories(this,' + tab_row + ')" class="form-control">';
	  <?php foreach($product_types as $key=>$text){ ?>
		html += '<option value="<?php echo $key;?>"><?php echo $text;?></option>';
	  <?php } ?>
	  html += '</select></td>';    
	 
	  html += '<td class="text-left"><button type="button" onclick="$(\'#moduletab-row' + tab_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	  html += '</tr></tbody>';
	 
	  $('#tableMoldue tfoot').before(html);	 
	 
	  $(btnAddTab).replaceWith('<button type="button" onclick="addTab(this, '+ (tab_row + 1)+ ');" data-toggle="tooltip" title="<?php echo $button_add_tab; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button>');
	 
}
function showCategories(select, row) {
	  if (select.options[select.selectedIndex].value == 'category') {
		$('#bt_featured'+row).slideUp("normal", function() { $(this).remove(); } );
		divclass = 'odd';
		html  = '<div class="well well-sm" style="height: 150px; overflow: auto;" id="scrollbox' + row + '">';
		<?php foreach ($categories as $category) { ?>
		  divclass = divclass == 'even' ? 'odd' : 'even';
		  html += '<div class="' + divclass + '">';
		  html += '<input type="radio" name="boss_listgridproduct_module[' + row + '][listgrid_type_category]" value="<?php echo $category['category_id']; ?>" />';
		  html += '<?php echo addslashes($category['name']); ?>'
		  html += '</div>';
		<?php } ?>
		html += '</div>';
		  
		$(select).after(html);
	  }else if (select.options[select.selectedIndex].value == 'featured') {
		$('#scrollbox' + row).slideUp("normal", function() { $(this).remove(); } );
		
		html = '<div id="bt_featured'+row+'"><input type="text" name="boss_listgridproduct_module[' + row + '][listgrid_type_featured]" value="" placeholder="<?php echo $entry_product; ?>" id="input-product-featured-'+row+'" class="form-control" />';
		html += ' <div id="product-featured-'+row+'" class="well well-sm" style="height: 150px; overflow: auto;">';
		html += '</div></div>';
		
		nhtml = html.replace(/bt_row_replace/gi);
		$(select).after(nhtml);
		autoslectfeatured(row);
	}else {
		$('#bt_featured'+row).slideUp("normal", function() { $(this).remove(); } );
		$('#scrollbox' + row).slideUp("normal", function() { $(this).remove(); } );
	  }
    }
//--></script>

<script type="text/javascript"><!--
function autoslectfeatured(key){
	$('input[name=\'boss_listgridproduct_module[' + key + '][listgrid_type_featured]\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',			
				success: function(json) {
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['product_id']
						}
					}));
				}
			});
		},
		'select': function(item) {
			$('input[name=\'boss_listgridproduct_module[' + key + '][listgrid_type_featured]\']').val('');
			
			$('#product-featured-'+key + item['value']).remove();
			
			$('#product-featured-'+key).append('<div id="product-featured-'+key + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="boss_listgridproduct_module[' + key + '][product_featured][]" value="' + item['value'] + '" /></div>');	
		}	
	});
	
	$('#product-featured-'+key).delegate('.fa-minus-circle', 'click', function() {
		$(this).parent().remove();
	});

};
<?php if(isset($module)) {?>
<?php $tab_key = 0;?>
<?php foreach($module as $tab) {?>
<?php if($tab['type_product'] == 'featured'){ ?>
autoslectfeatured('<?php echo $tab_key; ?>');
<?php } ?>
<?php $tab_key++; } } ?>
//--></script> 
<?php echo $footer; ?>