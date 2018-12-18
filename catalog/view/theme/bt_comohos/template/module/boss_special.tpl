<div class="bt-box box-special">
	<div class="box-heading"><h1><?php echo $heading_title; ?></h1></div>
	<div class="box-content">
		<div class="list-product" id="product_special_<?php echo $module; ?>">
		<?php foreach ($products as $key => $product) { ?>
			<div class="item product-thumb">
				<div class="image">
					<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
					<?php if ($product['percent_save']) { ?>
					<div class="label-discount">
					  <span><?php echo $product['percent_save']; ?>%</span>
					</div>
					<?php } ?>
				</div>
				
				<div class="caption">
					<div class="name"><a title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
						
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
						
					<p class="price">
						<?php if ($product['date_end'] == '0000-00-00') { ?>
						  <?php echo $product['price']; ?>
						<?php }else{ ?>
						<?php if (!$product['special']) { ?>
						<?php echo $product['price']; ?>
						<?php } else { ?>
						<span class="price-old"><?php echo $product['price']; ?></span><span class="price-new"><?php echo $product['special']; ?></span> 
						<?php } ?>
					  <?php } ?>
					</p>
					
					<?php if(isset($show_closed) && $show_closed) { ?><div class="datetime<?php echo $module.$key; ?> remain-time"></div><?php } ?>
					
					<div class="button-group">
						<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>','<?php echo $product['minimum']; ?>');"><!--<i class="fa fa-shopping-cart"></i>--><?php echo $button_cart; ?></button>
						<!--<div class="wishlist-compare">
							<button class="btn-wishlist" type="button" title="<?php //echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php //echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
							<button class="btn-compare" type="button" title="<?php //echo $button_compare; ?>" onclick="btadd.compare('<?php //echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
						</div>-->
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
		<div class="carousel-button">
			<a id="prev_special_<?php echo $module; ?>" class="prev nav_thumb" href="javascript:void(0)" title="prev"><i class="fa fa-angle-left"></i></a>
			<a id="next_special_<?php echo $module; ?>" class="next nav_thumb" href="javascript:void(0)" title="next"><i class="fa fa-angle-right"></i></a>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
var myVar=setInterval(function(){Deal<?php echo $module; ?>()},1000);
function Deal<?php echo $module; ?>(){
	var i = 0;
	<?php foreach ($products as $key => $product) { ?>
	
		var today = new Date();
		
		var dateStr = "<?php echo $product['date_end']; ?>";
		//alert(dateStr);
		if (dateStr != "0000-00-00") {
		var date = dateStr.split("-");
		
		var date_end = new Date(date[0],(date[1]-1),date[2]);
		
		var deal = new Date();
		
		deal.setTime(date_end - today);
		
		//alert(deal);
		
		if(date_end >= today){
		
		var month = new Date(deal.getMonth(), deal.getMonth(), 0).getDate();
		
		
		var d = deal.getDate() + (month*deal.getMonth());
		var h = deal.getHours() + (d * 24);
		var m = deal.getMinutes();
		var s = deal.getSeconds();
		h = checkTime(h);
		m = checkTime(m);
		s = checkTime(s);
		
		$(".datetime<?php echo $module.$key; ?>").html('<div class="sep"></div><div><span class="number">'+h+'</span><span><?php echo $text_hours; ?></span></div><div class="sep"></div><div><span class="number">'+m+'</span><span><?php echo $text_minutes; ?></span></div><div class="sep"></div><div><span class="number">'+s+'</span><span><?php echo $text_seconds; ?></span></div>');
		}
		}
	<?php } ?>
}
function checkTime(j){
	if (j<10){
	  j="0" + j;
	}
	return j;
}
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
setTimeout(function(){
	$('#product_special_<?php echo $module; ?>').carouFredSel({
        auto: {
			play: true,
			timeoutDuration: 3800,
		},
        responsive: true,
        width: '100%',
		height: 'variable',
        prev: '#prev_special_<?php echo $module; ?>',
        next: '#next_special_<?php echo $module; ?>',
        swipe: {
        onTouch : true
        },
        items: {
            width: 230,
			height: 'variable',
            visible: {
				min: 1,
				max: 1,
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1200,   //  The duration of the transition.
			items: 1,
        },
		/*onCreate: function () {
			$(window).smartresize(function(){
				$('#product_special_<?php echo $module; ?> div.item').css("height",'');	
				$('#product_special_<?php echo $module; ?> div.item').css("height",getMaxHeight('#product_special_<?php echo $module; ?> div.item'));	
			});
		}*/
    });
	
	/*$('#product_special_<?php echo $module; ?> div.item').css("height",getMaxHeight('#product_special_<?php echo $module; ?> div.item'));*/
	},200);
});

//--></script>