<?php require_once(DIR_SYSTEM . 'library/btform.php'); $btform = new Btform();?>
<?php if(isset($columns['params'])){ 
	$params = json_decode($columns['params'], true);
		
}else{
	$params = array();
}?>

<div id="btnewmenucolumn">
	<table class="table table-striped table-bordered table-hover">
		<tr><td><?php echo $entry_num_column; ?></td>
			<td class="left"><?php echo $btform -> makeSelectHTML($arrcolumns, 'num_column','',isset($columns['num_column']) ? $columns['num_column'] : ''); ?></td></tr>
		<tr><td><?php echo $entry_sort_order; ?></td>
			<td><?php echo $btform -> textField('sort_order',isset($columns['sort_order'])?$columns['sort_order']:'',11); ?></td></tr>
		<tr><td><?php echo $entry_status; ?></td>
			<td class="left"><?php echo $btform -> makeSelectHTML($arrstatus, 'status','',isset($columns['status']) ? $columns['status'] : ''); ?></td></tr>
		<tr><td><?php echo $entry_type; ?></td>
			<td class="left"><?php echo $btform -> makeSelectHTML($arrtypes, 'type','menutype',isset($columns['type']) ? $columns['type'] : ''); ?></td></tr>
		<tr id="type-category" class="menutype">
		<td>Categories:</td><td>
			<div id="opt_category">
				<span><?php echo $text_choose_category; ?></span><div class="well well-sm" style="height: 150px; overflow: auto;">
					<div class="odd">
					<?php echo $btform -> radioField('params[category_id]',0,isset($params['category_id']) ? $params['category_id'] : '',$text_root_category); ?>					  
					</div>
					<?php $divclass = 'odd'; ?>
					<?php foreach ($categories as $category) { ?>
					  <?php $divclass = ($divclass == 'even' ? 'odd' : 'even'); ?>
					  <div class="<?php echo $divclass; ?>">					 
						<?php echo $btform -> radioField('params[category_id]',$category['category_id'],isset($params['category_id']) ? $params['category_id'] : '',$category['name']); ?>						
					  </div>
					<?php } ?>
				</div>
			</div>
		</td></tr>
		<tr id="type-product" class="menutype">
			<td>Products:</td><td>
				<div id="opt_product">						
					<p><span><?php echo $text_w_x_h; ?></span>
						<?php echo $btform -> textField('params[product_img_w]',isset($params['product_img_w']) ? $params['product_img_w'] : '',3); ?>						
						<?php echo $btform -> textField('params[product_img_h]',isset($params['product_img_h']) ? $params['product_img_h'] : '',3); ?>
						</p>
					<p><span>Autocomplete</span>
					<?php echo $btform -> textField('product_autocomplete','',20); ?>
					</p>
					<div class="well well-sm" style="height: 150px; overflow: auto;" id="product_list">						
						<?php if(isset($params['product_ids'])) { ?>
							<?php foreach ($params['product_ids'] as $product_id) { ?>
							  <div class="" id="product-item-<?php echo $product_id; ?>"><i class="fa fa-minus-circle"></i> <?php echo isset($products_name[$product_id])?$products_name[$product_id]:''; ?>
							   <?php echo $btform -> createFieldHidden('params[product_ids][]',$product_id); ?>
							  </div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</td></tr>
			<tr id="type-manufacturer" class="menutype">
			<td>Manufacturers</td><td>
				<p><span>Image size(WxH)</span>
						<?php echo $btform -> textField('params[manufacturer_img_w]',isset($params['manufacturer_img_w']) ? $params['manufacturer_img_w'] : '',3); ?>
						<?php echo $btform -> textField('params[manufacturer_img_h]',isset($params['manufacturer_img_h']) ? $params['manufacturer_img_h'] : '',3); ?>
						</p><br />
				<p><span>Show name</span>
				<?php echo $btform -> makeSelectHTML($arrstatus,'params[manufacturer_name]','',isset($params['manufacturer_name']) ? $params['manufacturer_name'] : ''); ?>
				</p> <br />
				<span>Select Manufacturers</span>
				<div class="well well-sm" style="height: 150px; overflow: auto;">
					
					<?php foreach ($manufacturers as $manufacturer) { ?>
						<?php  $id_manu = array();?>
						<div class="">
							<?php echo $btform -> checkboxField('params[manufacturer_id][]',$manufacturer['manufacturer_id'],isset($params['manufacturer_id'])?$params['manufacturer_id']:$id_manu);?>
								
							<?php echo $manufacturer['name']; ?>
						</div>
					<?php } ?>
				</div>
			</td></tr>
			<tr id="type-information" class="menutype">
			<td>Informations</td><td>
				<div id="opt_information">
					<p></p><span>Select Informations</span>
					<div class="well well-sm" style="height: 150px; overflow: auto;">
						<?php foreach ($informations as $information) { ?>
						<div class="">
							<?php $id_info = array(); echo $btform -> checkboxField('params[information_id][]',$information['information_id'],isset($params['information_id'])?$params['information_id']:$id_info);?>						  
						  <?php echo $information['title']; ?>
						  </div>
						<?php } ?>
					</div>
				</div>
			</td></tr>
		<tr id="type-html" class="menutype">
			<td>HTML</td><td>				
				<ul class="nav nav-tabs" id="language-html">
					<?php foreach ($languages as $language) { ?>
					<li><a href="#tab-language-html-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
					<?php } ?>
					</ul>
				<div class="tab-content">
					<?php foreach ($languages as $language) { ?>
					<div class="tab-pane" id="tab-language-html-<?php echo $language['language_id']; ?>">	
						<textarea name="content_text_<?php echo $language['language_id'] ?>" id="input-description<?php echo $language['language_id']?>" class="form-control" ><?php echo isset($params['content_text'][$language['language_id']])?$params['content_text'][$language['language_id']]:'' ?>
						</textarea>
					
					<br />
					<i>If menu content is HTML so all submenu of this menu will not be showed</i><?php //echo "<pre>"; print_r($params);echo "</pre>"; ?>
					</div>
					<?php } ?>
				</div>
			</td></tr>
		
	</table>
</div>
<script type="text/javascript"><!--
$('#language-html li:first-child a').tab('show');
$(".menutype").hide();
$("#type-"+ $("#menutype").val()).show();
$("#menutype").change( function(){
	$(".menutype").hide();
	$("#type-"+$(this).val()).show();
} );
<?php foreach ($languages as $language) { ?>
//$('#input-description<?php echo $language['language_id']; ?>').summernote({
//	height: 300
//});
<?php } ?>
$('input[name=\'product_autocomplete\']').autocomplete({
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
		$('#product-item-' + item['value']).remove();
		
		$('#product_list').append('<div id="product-item-' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="params[product_ids][]" value="' + item['value'] + '" /></div>');	
	
		data = $.map($('#product_list input'), function(element) {
			return $(element).attr('value');
		});
						
		$('input[name=\'params[product_ids]\']').attr('value', data.join());	
	}	
});

$('#product_list').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();

	data = $.map($('#product_list input'), function(element) {
		return $(element).attr('value');
	});
					
	$('input[name=\'params[product_ids]\']').attr('value', data.join());	
});

//--></script>