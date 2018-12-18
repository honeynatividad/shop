<?php if(!empty($product_data)){ ?>

<?php if($show_slider){ $row = $num_row; $sliderclass = 'slider'; }else {$row = 1; $sliderclass = 'nslider';} ?>
<?php (!empty($product_data['mainproduct']))? $prolarge = 'prolarge': $prolarge = 'nprolarge'; ?>
<?php (!empty($column))?$class_css = '.bt-column':$class_css = 'bt-'.$prolarge.'-'.$sliderclass; ?>

<div class="bt-featured-pro <?php echo $class_css; ?> <?php echo $box_class_css; ?>" id="bt_fea_pro_<?php echo $module; ?>">
	<div class="box-heading title"><h1><?php echo $title; ?></h1></div>
	<div class="box-content bt-product-content">
	<?php if(!empty($product_data['mainproduct'])){ ?>
	<?php $mainproduct = $product_data['mainproduct'];?>
	<div class ="row">
	  <div class="bt-product-large product-layout col-sm-4 col-xs-12">
		<section class="bt-item-large product-thumb">
			<?php if ($images) { ?>
			<label class="label-most-popular"><?php echo $text_most_popular; ?></label>
			<ul id="boss-big-product">
				<?php foreach ($images as $image) { ?>
				<li class="image image-item"><a class="thumbnail" href="<?php echo $mainproduct['href']; ?>" title="<?php echo $mainproduct['name']; ?>"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $mainproduct['name']; ?>" alt="<?php echo $mainproduct['name']; ?>" /></a>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
			  <a id="prev_big_product" class="prev nav_thumb" href="javascript:void(0)" title="prev"><i class="fa fa-angle-left"></i></a>
			  <a id="next_big_product" class="next nav_thumb" href="javascript:void(0)" title="next"><i class="fa fa-angle-right"></i></a>
			<div class="caption">			
				<div class="name"><a href="<?php echo $mainproduct['href']; ?>"><?php echo $mainproduct['name']; ?></a></div>
				<!--<p class="description"><?php //echo $mainproduct['description']; ?></p>-->
				<?php if ($mainproduct['rating']) { ?>
				<div class="rating">
				  <?php for ($i = 1; $i <= 5; $i++) { ?>
				  <?php if ($mainproduct['rating'] < $i) { ?>
				  <span class="fa fa-stack fa-hidden"><i class="fa fa-star fa-stack-2x"></i></span>
				  <?php } else { ?>
				  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
				  <?php } ?>
				  <?php } ?>
				</div>
				<?php } ?>
				<?php if ($mainproduct['price']) { ?>
				<p class="price">
				  <?php if (!$mainproduct['special']) { ?>
				  <?php echo $mainproduct['price']; ?>
				  <?php } else { ?>
				  <span class="price-old"><?php echo $mainproduct['price']; ?></span>
				  <span class="price-new"><?php echo $mainproduct['special']; ?></span>
				  <?php } ?>
				</p>
				<?php } ?>
				<div class="button-group button-list">
					<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $mainproduct['product_id']; ?>','<?php echo $mainproduct['minimum']; ?>');"><i class="fa fa-shopping-cart"></i><?php echo $button_cart; ?></button>
					<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $mainproduct['product_id']; ?>');"><i class="fa fa-heart"></i></button>
					<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $mainproduct['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
				</div>
			
			</div>
		</section>
		</div>
	<?php } ?>
	
	<?php if(!empty($product_data['products'])){ ?>
	<?php $products = $product_data['products'];?>
	<?php //echo '<pre>'; print_r($products);die();echo '</pre>';?>
	<div class="bt-items bt-product-grid col-sm-8 col-xs-12">
		<div id="boss_featured_<?php echo $module; ?>">
			<div class="row">
			<?php $i = 0; //$k = 1;?>
			<?php $class="even";?>
			<?php foreach($products as $product){ ?>
			<?php $class=="odd"?$class="even":$class="odd";?>
			<?php if(($i%$row)==0){ ?>
			 <div class="bt-item-extra product-layout <?php echo $class; ?> element-<?php echo $per_row; ?>">
			<?php } ?>
			<?php $i++; ?>
			<section class="product-thumb bt-item transition">
				<?php if ($product['thumb']) { ?>
				<div class="image">
				  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
				  <?php if ($product['percent']) { ?>
					<div class="label-discount">
					  <span><?php echo $product['percent']; ?>%</span>
					</div>
					<?php } ?>
				  <!--<span><?php //echo ++$k; ?></span>-->
				</div>
				<?php } ?>
					<div class="caption">
						<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
						
						<?php if ($product['rating']) { ?>
						<div class="rating">
						  <?php for ($i = 1; $i <= 5; $i++) { ?>
						  <?php if ($product['rating'] < $i) { ?>
						  <span class="fa fa-stack fa-hidden"><i class="fa fa-star-o fa-stack-2x"></i></span>
						  <?php } else { ?>
						  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
						  <?php } ?>
						  <?php } ?>
						</div>
						<?php } ?>
						<?php if ($product['price']) { ?>
						<p class="price">
						  <?php if (!$product['special']) { ?>
						  <?php echo $product['price']; ?>
						  <?php } else { ?>
						  <span class="price-old"><?php echo $product['price']; ?></span>
						  <span class="price-new"><?php echo $product['special']; ?></span>
						  <?php } ?>
						</p>
						<?php } ?>
						
						<div class="button-group button-list">
							<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>','<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i><?php echo $button_cart; ?></button>
								<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
								<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
						</div>
					</div>
			</section>
			<?php if((($i%$row)==0)||($i==count($products))){ ?> </div> <?php } ?>
			<?php } ?>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php if($show_slider){ ?>
			<a id="prev_featured_<?php echo $module; ?>" class="prev nav_thumb" href="javascript:void(0)" title="prev"><i class="fa fa-angle-left"></i></a>
			<a id="next_featured_<?php echo $module; ?>" class="next nav_thumb" href="javascript:void(0)" title="next"><i class="fa fa-angle-right"></i></a>
			<?php if($nav_type){ ?>
			<div id="bt_pag_<?php echo $module; ?>" class="bt-pag"></div>
			<?php } ?>
		<?php } ?>
	</div>
	<?php } ?>
	</div>
</div>
<?php if($show_slider){ ?>
<script type="text/javascript"><!--
function getMaxHeight($elms) {
	var maxHeight = 0;
	$($elms).each(function () {
	
		var height = $(this).outerHeight();
		if (height > maxHeight) {
			maxHeight = height;
		}
	});
	return maxHeight;
};
$(window).load(function(){
	//var image_width = <?php echo $image_width; ?>;
	if ($(window).width() > 768) {
		var image_width = <?php echo $image_width; ?>;
		var per_row = <?php echo $per_row; ?>;
		if ($(window).width() <= 1023) {
			per_row = 3;
		}
	}else{
		if ($(window).width() < 480) {
			per_row = 1;
		}else{
			per_row = 2;
		}
		var image_width = 200;
	}
    $('#boss_featured_<?php echo $module; ?>').carouFredSel({
        auto: {
			play: false,
			timeoutDuration: 4200,
		},
        responsive: true,
        width: '100%',
		height: 'auto',
        prev: '#prev_featured_<?php echo $module; ?>',
        next: '#next_featured_<?php echo $module; ?>',
		pagination: '#bt_pag_<?php echo $module; ?>',
        swipe: {
        onTouch : true
        },
        items: {
            width: image_width,
            height: 'auto',
            visible: {
				min: 1,
				max: per_row,
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000   //  The duration of the transition.
        },
		onCreate: function () {
			$('#bt_fea_pro_<?php echo $module; ?> .box-content .caroufredsel_wrapper').css("height",getMaxHeight('#boss_featured_<?php echo $module; ?> section.bt-item')+10);
			$(window).smartresize(function(){
				if ($(window).width() > 768) {
					var image_width = <?php echo $image_width; ?>;
					var per_row = <?php echo $per_row; ?>;
					if ($(window).width() <= 1023) {
						per_row = 3;
					}
				}else{
					if ($(window).width() < 480) {
						per_row = 1;
					}else{
						per_row = 2;
					}
					var image_width = 200;
				}
				$('#boss_featured_<?php echo $module; ?>').carouFredSel({
					auto: false,
					responsive: true,
					width: '100%',
					height: 'auto',
					prev: '#prev_featured_<?php echo $module; ?>',
					next: '#next_featured_<?php echo $module; ?>',
					pagination: '#bt_pag_<?php echo $module; ?>',
					swipe: {
					onTouch : true
					},
					items: {
						width: image_width,
						height: 'auto',
						visible: {
							min: 1,
							max: per_row,
						}
					},
					scroll: {
						direction : 'left',    //  The direction of the transition.
						duration  : 1000   //  The duration of the transition.
					},
				});
				$('#bt_fea_pro_<?php echo $module; ?> .box-content .caroufredsel_wrapper').css("height",getMaxHeight('#boss_featured_<?php echo $module; ?> section.bt-item')+10);
			});
		},
    });
	$('#bt_fea_pro_<?php echo $module; ?> .box-content .caroufredsel_wrapper').css("height",getMaxHeight('#boss_featured_<?php echo $module; ?> section.bt-item')+10);
});
//--></script>
<?php } ?>
<?php if(!empty($product_data['mainproduct'])){ ?>
<script>
$(window).load(function(){
	//var image_width = <?php echo $image_width; ?>;
	if ($(window).width() > 768) {
		var image_width = <?php echo $image_width; ?>;
	}else{
		var image_width = 300;
	}
	$('#boss-big-product').carouFredSel({ 
        auto: {
			play: false,
			timeoutDuration: 4200,
		},
        responsive: true,
        width: '100%',
		height: 'variable',
        prev: '#prev_big_product',
        next: '#next_big_product',
        swipe: {
        onTouch : true
        },
        items: {
            width: image_width,
            height: 'variable',
            visible: {
				min: 1,
				max: 1
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1100,   //  The duration of the transition.
			item: 1
        },
		
    });
});
</script>
<?php } ?>
</div>
<?php } ?>