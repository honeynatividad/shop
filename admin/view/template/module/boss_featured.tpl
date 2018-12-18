<?php require_once(DIR_SYSTEM . 'library/btform.php');?>
<?php 
$btform = new Btform();
?>
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
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-boss_featured" class="form-horizontal">	
		<table class="table table-striped table-bordered table-hover">
			<tbody >
			<tr><td><?php echo $entry_name; ?></td><td class="text-left">
				<input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
			</td></tr>
			
			<tr id="tableMoldue">
				<td class="text-left"><?php echo $text_title; ?></td>
				<td class="text-left">
				<table class="table table-striped table-bordered table-hover">
				<?php foreach ($languages as $language) { ?>
				<tr><td>
				  <input type="text" name="title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($title[$language['language_id']]) ? $title[$language['language_id']] : ''; ?>" id="input-title" class="form-control" />
				  </td><td>
				  <img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>
				<?php } ?>
				</table>
			</td></tr>
			
			<tr><td class="text-left"><?php echo $tab_get_product; ?></td><td class="text-left">
				<?php echo $btform -> makeSelectHTML($filter_types, 'type_product',"",isset($type_product)?$type_product:'',"onchange=\"showtypeproduct(this)\" class=\"form-control\""); ?>
				
				<?php if(isset($type_product)){ ?>

				<?php if ($type_product == 'featured') { ?><div id="bt_featured">
					<input type="text" name="featured" value="" placeholder="<?php echo $entry_product; ?>" id="input-product-featured" class="form-control" />
					  <div id="product-featured" class="well well-sm" style="height: 150px; overflow: auto;">
						<?php foreach ($products as $product) { ?>
						<div id="product-featured<?php echo $product['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product['name']; ?>
						  <input type="hidden" name="product_featured[]" value="<?php echo $product['product_id']; ?>" />
						</div>
						<?php } ?>
					</div></div>
				<?php } ?>
				
				<?php if ($type_product == 'category') { ?><div id="bt_category">
				  <input type="text" name="category" value="<?php echo $category_name; ?>" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />
                  <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" /></div>
				<?php } ?>
				<?php } ?>
			</td></tr>
			
			<tr><td><?php echo $entry_image; ?></td><td class="text-left"><table class="table table-striped table-bordered table-hover"><tr><td>
				<?php echo $btform -> textField('image_width',isset($image_width) ? $image_width : '',3,"class=\"form-control\""); ?><?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?></td><td>							
				<?php echo $btform -> textField('image_height',isset($image_height) ? $image_height : '',3,"class=\"form-control\""); ?><?php if ($error_height) { ?>
              <div class="text-danger"><?php echo $error_height; ?></div>
              <?php } ?></td><tr>
			</table></td></tr>
			
			<tr><td><?php echo $entry_class; ?></td><td class="text-left">
				<input type="text" name="class_css" value="<?php echo isset($class_css) ? $class_css : ''; ?>" placeholder="<?php echo $entry_class; ?>" id="input-class" class="form-control" />
			</td></tr>
			
			<tr><td><?php echo $entry_limit; ?></td><td class="text-left">
				<?php echo $btform -> textField('limit',isset($limit) ? $limit : '',3,"class=\"form-control\""); ?>
			</td></tr>
			
			<tr><td>Show Slider</td>
			<td><?php echo $btform -> makeSelectHTML($arrstatus, 'show_slider','',isset($show_slider) ? $show_slider : '',"class=\"form-control\""); ?>
			</td></tr>
			
			<tr><td colspan="2"><table class="table table-striped table-bordered table-hover"><tr><td><?php echo $entry_row; ?></td><td>
			<?php echo $btform -> textField('num_row',isset($num_row) ? $num_row : '',9,"class=\"form-control\""); ?>
			</td><td class="text-right"><?php echo $entry_properrow; ?> </td><td>
			<?php echo $btform -> textField('per_row',isset($per_row) ? $per_row : '',10,"class=\"form-control\""); ?></td></tr></table>
			</td></tr>
			
			<tr><td><?php echo $entry_nav; ?></td><td class="text-left" colspan="3">
			<?php echo $btform -> makeSelectHTML($arrstatus, 'nav_type','',isset($nav_type) ? $nav_type : '',"class=\"form-control\""); ?></td></tr>
			
			<tr>
				<td><?php echo $entry_prolarge; ?></td>
				<td class="text-left">
					<table class="table table-striped table-bordered table-hover">
					<tr>
					<td><?php echo $entry_show_prolarge; ?>: </td>
					
					<td><?php echo $btform -> makeSelectHTML($arrstatus, 'show_pro_large',"",isset($show_pro_large)?$show_pro_large:true,"class=\"form-control\""); ?>
					</td></tr>
					<tr><td><?php echo $entry_get_prolarge; ?>:&nbsp;&nbsp;</td>
					<td><input type="text" name="product_name" value="<?php echo $product_name; ?>" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
					<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" /></td></tr> 
					<tr><td>
					<?php echo $entry_img_large; ?>&nbsp;&nbsp;
					</td>
					<td><table class="table table-striped table-bordered table-hover"><tr><td><?php echo $btform -> textField('img_width',isset($img_width) ? $img_width : '380',3,"class=\"form-control\""); ?></td>
					<td><?php echo $btform -> textField('img_height',isset($img_height) ? $img_height : '380',3,"class=\"form-control\""); ?></td></tr>
					</table></td></tr>
					</table>
				</td>
			</tr>
			
			<tr><td><?php echo $entry_status; ?></td><td class="text-left" colspan="3">
			<?php echo $btform -> makeSelectHTML($arrstatus, 'status','',isset($status) ? $status : '',"class=\"form-control\""); ?></td></tr>
			
			</tbody>
		</table>
	</form>
	</div>
</div>
</div>
</div>
<script type="text/javascript"><!--
function showtypeproduct(select) {
	if (select.options[select.selectedIndex].value == 'category') {
		$('#bt_featured').slideUp("normal", function() { $(this).remove(); } );
		html  = '<input type="text" name="category" value="" placeholder="<?php echo $entry_category; ?>" id="input-category" class="form-control" />';
        html += '<input type="hidden" name="category_id" value="" /></div>';
		nhtml = html.replace(/bt_row_replace/gi);
		$(select).after(nhtml);
		autoslectcategory();
	}else if (select.options[select.selectedIndex].value == 'featured') {
		$('#bt_category').slideUp("normal", function() { $(this).remove(); } );
		
		html = '<div id="bt_featured"><input type="text" name="featured" value="" placeholder="<?php echo $entry_product; ?>" id="input-product-featured" class="form-control" />';
		html += ' <div id="product-featured" class="well well-sm" style="height: 150px; overflow: auto;">';
		html += '</div></div>';
		
		nhtml = html.replace(/bt_row_replace/gi);
		$(select).after(nhtml);
		autoslectfeatured();
	}else {
		$('#bt_featured').slideUp("normal", function() { $(this).remove(); } );
		$('#bt_category').slideUp("normal", function() { $(this).remove(); } );
	}
}
//--></script>

<script type="text/javascript"><!--
function autoslectfeatured(){
	$('input[name=\'featured\']').autocomplete({
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
			$('input[name=\'product-featured\']').val('');
			
			$('#product-featured' + item['value']).remove();
			
			$('#product-featured').append('<div id="product-featured' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_featured[]" value="' + item['value'] + '" /></div>');	
		}	
	});
	
	$('#product-featured').delegate('.fa-minus-circle', 'click', function() {
		$(this).parent().remove();
	});

};

// Category
function autoslectcategory(){
	$('input[name=\'category\']').autocomplete({
		'source': function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {
					json.unshift({
						category_id: 0,
						name: '<?php echo $text_none; ?>'
					});

					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['category_id']
						}
					}));
				}
			});
		},
		'select': function(item) {
			$('input[name=\'category\']').val(item['label']);
			$('input[name=\'category_id\']').val(item['value']);
		}
	});
}

// Related
$('input[name=\'product_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					product_id: 0,
					name: '<?php echo $text_none; ?>'
				});

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
		$('input[name=\'product_name\']').val(item['label']);
		$('input[name=\'product_id\']').val(item['value']);
	}
});
autoslectfeatured();
autoslectcategory();
//--></script> 

<?php echo $footer; ?>

