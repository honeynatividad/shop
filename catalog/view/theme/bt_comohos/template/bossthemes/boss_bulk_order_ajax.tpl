	<div class="b_bulk_table">
	<table class="table table-bordered">
		<thead>
          <tr>
		  <td class="text-center"><?php echo $entry_image; ?></td>
		  <?php if($search_product){ ?><td class="text-left"><?php echo $entry_name; ?></td><?php } ?>
		  <?php if($search_model){ ?><td class="text-left"><?php echo $entry_model; ?></td> <?php } ?>
		  <?php if($search_price){ ?><td class="text-left"><?php echo $entry_price; ?></td><?php } ?>
		 <?php if(!empty($option_id_show)){ ?>
		 <?php foreach($option_id_show as $option_show){ ?>
			<td><?php echo $option_show['option_name'];?></td>
		  <?php } } ?>
		  <td class="text-left"></td>
		  </tr>
		</thead> 
		<tbody>
		<?php if(!empty($products)) { ?>
		<?php foreach($products as $product) { ?>
		<tr id="add_to_cart<?php echo $product['product_id'] ?>">
			<td class="text-center"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb'] ?>" title="<?php echo $product['name'] ?>" alt="<?php echo $product['name'] ?>" /></a></td>
			<?php if($search_product){ ?><td class="text-left name"><a title="<?php echo $product['name'] ?>" href="<?php echo $product['href']; ?>"><?php echo $product['name'] ?></a></td><?php } ?>
			<?php if($search_model){ ?><td class="text-left"><?php echo $product['model'] ?></td><?php } ?>
			<?php if($search_price){ ?><td><?php if ($product['price']) {  ?>
                <div class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                  <?php } ?>
                  <?php if ($product['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                  <?php } ?>
                </div>
                <?php } ?></td>	
				<?php } ?>
			<?php if(!empty($option_id_show)) { 
					$flag_array = array();
					$flag_count = count($product['options']);
					foreach($option_id_show as $key => $option_show){ 
						$flag = 0;						
			?>
				<td>
						<?php while($flag < $flag_count){
						$option = isset($product['options'][$flag])?$product['options'][$flag]:''; 
						if(!empty($option) && $option['option_id'] == $option_show['option_id'] && !in_array($option['option_id'], $flag_array)) {
							$flag_array[] = $option['option_id'];  
							$flag = $flag_count;
						?>
						<?php if ($option['type'] == 'select') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control selectpicker">
							<option value=""><?php echo $text_select; ?></option>
							<?php foreach ($option['product_option_value'] as $option_value) { ?>
							<option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
							<?php if ($option_value['price']) { ?>
							(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
							<?php } ?>
							</option>
							<?php } ?>
						  </select>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'radio') { ?>
						<div class="row">
						<div class="col-sm-6 col-xs-12 form-group-tab form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <div id="input-option<?php echo $option['product_option_id']; ?>">
							<?php foreach ($option['product_option_value'] as $option_value) { ?>
							<div class="radio">
							  <label>
								<input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
								<?php echo $option_value['name']; ?>
								<?php if ($option_value['price']) { ?>
								(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
								<?php } ?>
							  </label>
							</div>
							<?php } ?>
						  </div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'checkbox') { ?>
						<div class="col-sm-6 col-xs-12 form-group-tab form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <div id="input-option<?php echo $option['product_option_id']; ?>">
							<?php foreach ($option['product_option_value'] as $option_value) { ?>
							<div class="checkbox">
							  <label>
								<input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
								<?php echo $option_value['name']; ?>
								<?php if ($option_value['price']) { ?>
								(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
								<?php } ?>
							  </label>
							</div>
							<?php } ?>
						  </div>
						</div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'image') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <div id="input-option<?php echo $option['product_option_id']; ?>">
							<?php foreach ($option['product_option_value'] as $option_value) { ?>
							<div class="radio bt-image-option">
							  <label>
								<input class="hidden" type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
								<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /> <?php echo $option_value['name']; ?>
								<?php if ($option_value['price']) { ?>
								(<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
								<?php } ?>
							  </label>
							</div>
							<?php } ?>
						  </div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'text') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'textarea') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'file') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block btn-upload"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
						  <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'date') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <div class="input-group date">
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
							<span class="input-group-btn">
							<button class="btn-default" type="button"><i class="fa fa-calendar"></i></button>
							</span></div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'datetime') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <div class="input-group datetime">
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
							<span class="input-group-btn">
							<button type="button" class="btn-default"><i class="fa fa-calendar"></i></button>
							</span></div>
						</div>
						<?php } ?>
						<?php if ($option['type'] == 'time') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <div class="input-group time">
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
							<span class="input-group-btn">
							<button type="button" class="btn-default"><i class="fa fa-calendar"></i></button>
							</span></div>
						</div>
						<?php } ?>
					<?php } $flag++; } ?>
				</td>				
			<?php  }} ?>
			
			<td>
				<div class="input-group btn-block" style="max-width: 100px;">
				    <button onclick="changeQty('<?php echo 'select-number'.$product['product_id'];?>',0,'<?php echo $product['minimum']; ?>'); return false;" class="decrease"><i class="fa fa-minus"></i></button>
					
                    <input id="select-number<?php echo $product['product_id']; ?>" type="text" name="quantity" value="<?php echo $product['minimum']; ?>" size="1" class="form-control" />
					
					<button onclick="changeQty('<?php echo 'select-number'.$product['product_id'];?>',1,'<?php echo $product['minimum']; ?>'); return false;" class="increase"><i class="fa fa-plus"></i></button>
                </div>
				
                
				<div class="cart"><button type="button" onclick="addto('select-number<?php echo $product['product_id']; ?>', '<?php echo $product['product_id']; ?>');" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></button></div>
				<input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
			</td>
		</tr>
		
		<?php }} ?>
		</tbody>
	  </table>
	</div>
	  <?php if(!empty($pagination)){?>
      <div class="result-pagination">
		  <div class="results pull-left"><?php echo $results; ?></div>
          <div class="links"><?php echo $pagination; ?></div>
		</div>
	  <?php } ?>
      <?php if (!$products) { ?>
		<div class="content_bg">
			<p><?php echo $text_empty; ?></p>			
		</div>
      <?php } ?>
<script src="catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/jquery/magnific/magnific-popup.css" rel="stylesheet" type="text/css">
<link href="catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					//$(node).button('loading');
				},
				complete: function() {
					//$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script> 
