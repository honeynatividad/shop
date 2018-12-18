<?php echo $header; ?>
<?php global $config; ?>
<div class="bt-breadcrumb">
<div class="container">
  <ul class="breadcrumb">
	<li class="b_breadcrumb"><?php echo $heading_title; ?></li>
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
</div>
<div class="container">
  <div class="row"><?php echo $column_left; ?><?php echo $column_right; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">
	<div id="tags-load"></div>	
	<?php echo $content_top; ?>
	<form id="boss_bulk_order">
	<?php if($search_category){ ?>
	<div class="col-sm-3 search-category">
		<div class="form-group">
		<label class="control-label" for="input-price"><?php echo $entry_category; ?></label>
		<select name="fc" class="form-control selectpicker">
            <option value="0"><?php echo $text_category; ?></option>
            <?php foreach ($categories as $category_1) { ?>          
            <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>            
            <?php foreach ($category_1['children'] as $category_2) { ?>
            <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
            <?php foreach ($category_2['children'] as $category_3) { ?>
            <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
            <?php } ?>
            <?php } ?>
            <?php } ?>
       </select>
	   </div>
	</div>
	<?php } ?>
	<?php if($search_product){ ?>
	<div class="col-sm-3 search-product">
	  <div class="form-group">
		<label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
		<input type="text" name="fn" value="<?php echo isset($filter_name)?$filter_name:''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
	  </div>	 
	</div>
	<?php } ?>
	<?php if($search_tags){ ?>
	<div class="col-sm-3 search-tags">
	  <div class="form-group">
		<label class="control-label" for="input-tag"><?php echo $entry_tag; ?></label>
		<input type="text" name="ft" value="<?php echo isset($filter_tag)?$filter_tag:''; ?>" placeholder="<?php echo $entry_tag; ?>" id="input-tag" class="form-control" />
	  </div>	 
	</div>
	<?php } ?>
	
	<?php if($search_model){ ?>
	<div class="col-sm-3 search-model">
		 <div class="form-group">
		<label class="control-label" for="input-model"><?php echo $entry_model; ?></label>
		<input type="text" name="fm" value="<?php echo isset($filter_model)?$filter_model:''; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />
	  </div>
	</div>
	<?php } ?>
	<?php if($search_price){ ?>
	<div class="col-sm-3 search-price">
	  <div class="form-group">
		<p>
		<label for="amount"><?php echo $text_price_range;?></label>
		<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
		</p>
		<input type="hidden" id="b_filter_price_min" name="fmin" min="<?php echo !empty($b_filter_price_min)?$b_filter_price_min:1;?>" max="<?php echo !empty($b_filter_price_max)?$b_filter_price_max:1200;?>" step="1" value="<?php echo !empty($b_filter_price_min)?$b_filter_price_min:1;?>" />
		<input type="hidden" id="b_filter_price_max" name="fmax" value="<?php echo !empty($b_filter_price_max)?$b_filter_price_max:1200;?>" />
		<div id="slider-range"></div>
	  </div>	 
	</div>
	<?php } ?>
	</form>
	 <div class="form-group">
		<button type="button" id="button-filter" class="btn btn-primary pull-left"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
	  </div>
	  <div id="bulk-load" style="display:none"></div>
      <div class="b_bulk_order_ajax">
	  <div class="b_bulk_table">
	  <table class="table">
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
			<?php if($search_product){ ?><td><a title="<?php echo $product['name'] ?>" href="<?php echo $product['href']; ?>"><?php echo $product['name'] ?></a></td><?php } ?>
			<?php if($search_model){ ?><td><?php echo $product['model'] ?></td><?php } ?>
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
						  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
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
						<div class="form-group-tab form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <label class="control-label"><?php echo $option['name']; ?></label>
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
						<div class="form-group-tab form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <label class="control-label"><?php echo $option['name']; ?></label>
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
						<?php } ?>
						
						<?php if ($option['type'] == 'image') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <label class="control-label"><?php echo $option['name']; ?></label>
						  <div id="input-option<?php echo $option['product_option_id']; ?>">
							<?php foreach ($option['product_option_value'] as $option_value) { ?>
							<div class="radio bt-image-option">
							  <label>
								<input class="hidden" type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" />
								<img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" class="img-thumbnail" /> <?php echo $option_value['name']; ?>
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
						  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
						  <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
						</div>
						<?php } ?>
						
						<?php if ($option['type'] == 'textarea') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
						  <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
						</div>
						<?php } ?>
						
						<?php if ($option['type'] == 'file') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <label class="control-label"><?php echo $option['name']; ?></label>
						  <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block btn-upload"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
						  <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
						</div>
						<?php } ?>
						
						<?php if ($option['type'] == 'date') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
						  <div class="input-group date">
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
							<span class="input-group-btn">
							<button class="btn-default" type="button"><i class="fa fa-calendar"></i></button>
							</span></div>
						</div>
						<?php } ?>
						
						<?php if ($option['type'] == 'datetime') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
						  <div class="input-group datetime">
							<input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
							<span class="input-group-btn">
							<button type="button" class="btn-default"><i class="fa fa-calendar"></i></button>
							</span></div>
						</div>
						<?php } ?>
						
						<?php if ($option['type'] == 'time') { ?>
						<div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?>">
						  <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?></label>
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
				
                
				<div class="cart"><input type="button" value="<?php echo $button_cart;?>" onclick="addto('select-number<?php echo $product['product_id']; ?>', '<?php echo $product['product_id']; ?>');" class="btn btn-primary"></div>
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
	</div>
	</div>
      <?php echo $content_bottom; ?></div>
</div>	

<style>
.radio label > input:checked + img {
  border: 2px solid #F00;
}
</style>
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
 <script type="text/javascript"><!--
 // Autocomplete 
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();
	
			$.extend(this, option);
	
			$(this).attr('autocomplete', 'off');
			
			// Focus
			$(this).on('focus', function() {
				this.request();
			});
			
			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);				
			});
			
			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}				
			});
			
			// Click
			this.click = function(event) {
				event.preventDefault();
	
				value = $(event.target).parent().attr('data-value');
	
				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}
			
			// Show
			this.show = function() {
				var pos = $(this).position();
	
				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});
	
				$(this).siblings('ul.dropdown-menu').show();
			}
			
			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}		
			
			// Request
			this.request = function() {
				clearTimeout(this.timer);
		
				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}
			
			// Response
			this.response = function(json) {
				html = '';
	
				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}
	
					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}
	
					// Get all the ones with a categories
					var category = new Array();
	
					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}
	
							category[json[i]['category']]['item'].push(json[i]);
						}
					}
	
					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';
	
						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}
	
				if (html) {
					this.show();
				} else {
					this.hide();
				}
	
				$(this).siblings('ul.dropdown-menu').html(html);
			}
			
			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));	
			
		});
	}
})(window.jQuery);
$('input[name=\'fn\']').autocomplete({ 
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=bossthemes/boss_bulk_order/autocomplete&filter_name=' +  encodeURIComponent(request),
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
		$('input[name=\'fn\']').val(item['label']);
	}
});

$('input[name=\'fm\']').autocomplete({ 
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=bossthemes/boss_bulk_order/autocomplete&filter_model=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['model'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'fm\']').val(item['label']);
	}
});
$('#button-filter').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=bossthemes/boss_bulk_order/filter',
		dataType: 'json',
		data:$("#boss_bulk_order").serialize(),
		beforeSend: function() {
			$("#bulk-load").show();		
		},	
		complete: function() {
			$("#bulk-load").hide();			
		},		
		success: function(json) {
			if (json['error']) {
				
			}				
			if (json['success']) { 
				$('.b_bulk_order_ajax').html(json['output']);
				history.pushState({
					page: json['url']
				}, json['url'], json['url']); 
			}
		}	
	}); 
} ); 
function ajaxPage(page){
	$.ajax({
		type: 'get',
		url: 'index.php?route=bossthemes/boss_bulk_order/filter&p='+page,
		dataType: 'json',
		data:$("#boss_bulk_order").serialize(),
		beforeSend: function() {
			$("#bulk-load").show();		
		},	
		complete: function() {
			$("#bulk-load").hide();				
		},		
		success: function(json) { 
			if (json['error']) {
				
			}				
			if (json['success']) { 
				$('.b_bulk_order_ajax').html(json['output']);
				history.pushState({
					page: json['url']
				}, json['url'], json['url']);
			}
		}	
	}); 
}	

$(function() {
	$( "#slider-range" ).slider({
      range: true,
      min: <?php echo !empty($b_filter_price_min_d)?$b_filter_price_min_d:1;?>,
      max: <?php echo !empty($b_filter_price_max_d)?$b_filter_price_max_d:1200;?>,
      values: [ <?php echo !empty($b_filter_price_min)?$b_filter_price_min:1;?>, <?php echo !empty($b_filter_price_max)?$b_filter_price_max:1200;?> ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        $( "#b_filter_price_min" ).val( ui.values[ 0 ]);
        $( "#b_filter_price_max" ).val( ui.values[ 1 ]);		
      },
	  
    });
	<?php if(!empty($symbolLeft)){ ?>
    $( "#amount" ).val( "<?php echo $symbolLeft;?>" + $( "#slider-range" ).slider( "values", 0 ) +
      " - <?php echo $symbolLeft;?>" + $( "#slider-range" ).slider( "values", 1 ) );
	<?php }else{ ?>
	 $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
      "<?php echo $symbolRight;?> - " + $( "#slider-range" ).slider( "values", 1 ) +"<?php echo $symbolRight;?>" );
	<?php } ?>
  });
function addto(id,product_id) {
	var quantity = $('#' + id+'').val();
	$('#' + id+'').val(quantity);
	//btadd.cart(product_id,quantity);
	$.ajax({
		url: 'index.php?route=bossthemes/boss_add/cart',
		type: 'post',
		/*data:$("#add_to_cart"+product_id).serialize(),*/
		data: $('#add_to_cart'+product_id+' input[type=\'text\'],#add_to_cart'+product_id+' input[type=\'hidden\'], #add_to_cart'+product_id+' input[type=\'radio\']:checked, #add_to_cart'+product_id+' input[type=\'checkbox\']:checked, #add_to_cart'+product_id+' select, #add_to_cart'+product_id+' textarea'),
		dataType: 'json',
		beforeSend: function() {
			//$('#button-cart').button('loading');
		},
		complete: function() {
			//$('#button-cart').button('reset');
		},
		success: function(json) { 
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');
			if (json['redirect']) {
					location = json['redirect'];
				}
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));
						
						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}
				
				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}
				
				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}
			
			if (json['success']) {
				addCartProductNotice(json['continue'], json['checkout'], json['title'], json['thumb'], json['success'], 'success');
				
				$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);
				
				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		}
	});
}  
function changeQty(id,increase,minimum) {	
    var qty = parseInt($('#' + id+'').val());	
    if ( !isNaN(qty) ) {
        qty = increase ? qty+1 : (qty > minimum ? qty-1 : minimum);
        $('#' + id+'').val(qty);
    }else{
		$('#' + id+'').val(1);
	}
	
}

//--></script>
<?php echo $footer; ?>