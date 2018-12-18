<!--module boss - fillter product-->
<?php if(!empty($tabs)){ ?>
<div class="boss-filter-container">
<script type="text/javascript">
$(window).load(function(){
  
	initCarousel(<?php echo $use_tab; ?>,<?php echo $module; ?>,<?php echo $use_scrolling_panel; ?>,<?php echo $per_row; ?>,<?php echo $image_width; ?>);
	
	<?php if(!$use_tab) { ?>
		checkDevices(<?php echo $module; ?>);
	<?php } ?>

	$("a.head_tabs<?php echo $module;?>").click(function() {
	
		<?php if(!$use_tab) { ?>
			if(getWidthBrowser() > 767){
				return false;
			}
		<?php } ?>
		
		if(!$(this).parent().hasClass('active')) {
		
			$(".head_tabs<?php echo $module;?>").parent().removeClass("active");
			var $src_tab = $(this).attr("data-src");
			$($src_tab).parent().addClass("active");
			$(".content_tabs<?php echo $module;?>").hide();
			var $selected_tab = $(this).attr("href");
			$($selected_tab).fadeIn();
			
			<?php if ($use_scrolling_panel) { ?>
				var $selected_carousel = $(this).attr("data-crs");
				if($selected_carousel != ""){
					execCarousel($selected_carousel,<?php echo $per_row; ?>,<?php echo $image_width; ?>);
				}
			<?php } ?>
		}
		return false;
	});

	$(window).resize(function() {
		<?php if(!$use_tab) { ?>
			checkDevices(<?php echo $module; ?>);
		<?php } ?>
	});
});
</script>
<div id="boss_homefilter_tabs<?php echo $module; ?>" class="boss_homefilter_tabs">
  
  <div id="tabs_container<?php echo $module; ?>" class="hide-on-mobile tabs_container">
  <?php if($use_tab){ ?>
	<ul id="tabs<?php echo $module;?>" class="tabs-headings tabs">
	<?php foreach ($tabs as $numTab => $tab) { ?>
		 <li <?php if($numTab == 0) echo 'class="active"'; ?>><a class="head_tab<?php echo $numTab.$module; ?> head_tabs<?php echo $module;?>" href="#content_tab<?php echo $numTab.$module; ?>" data-src=".head_tab<?php echo $numTab.$module; ?>" data-crs="#carousel_tab<?php echo $numTab.$module; ?>"><?php if(isset($tab['icon'])&&$tab['icon']) { ?><img src="<?php echo $tab['icon'];?>" title="<?php echo $tab['title'];?>" alt="<?php echo $tab['title'];?>"/><?php } ?><?php echo $tab['title']; ?></a></li>
	<?php } ?>
	</ul>
  <?php } ?>
  </div>
  
  <div id="tabs_content_container<?php echo $module; ?>" class="home_filter_content tabs_content_container">
	<?php if(!$use_tab){ ?>
		<div class="box-heading title"><h1><?php echo $tabs[0]['title']; ?></h1></div>
	<?php } ?>
  <div class="box-content">
	<?php foreach ($tabs as $numTab => $tab) { ?>
	  <?php if($use_tab) { ?>
		<h3  class="<?php if($numTab == 0) echo 'active'; ?> <?php if($use_tab){ echo 'hide-on-desktop';} ?>"><a class="head_tab<?php echo $numTab.$module; ?> head_tabs<?php echo $module;?>" href="#content_tab<?php echo $numTab.$module; ?>" data-src=".head_tab<?php echo $numTab.$module; ?>" data-crs="#carousel_tab<?php echo $numTab.$module; ?>"><?php echo $tab['title']; ?></a></h3>
	  <?php } ?>
		
    <div id="content_tab<?php echo $numTab.$module; ?>" class="content_tabs<?php echo $module; ?> list_carousel responsive <?php echo $class_css;?>" style="display:<?php if($numTab == 0) echo 'block'; else echo 'none'; ?>">
      <?php if(!empty($tab['products'])){ ?>
		<?php $cols = 12/$per_row; ?>
		<ul id="carousel_tab<?php echo $numTab.$module; ?>" data-prev="#prev_tab<?php echo $numTab.$module; ?>" data-next="#next_tab<?php echo $numTab.$module; ?>" class="box-product"><?php $i = 0; $jj = 1;?> 
			<?php $k=0; foreach ($tab['products'] as $key => $product){?> <?php if(($i%$num_row)==0){ ?><li <?php echo ($use_scrolling_panel)?'':'class="col-lg-'.$cols.' col-md-'.$cols.' col-sm-'.$cols.' col-xs-12"'; ?>> <?php $jj = $jj+$i; } ?>
			<?php $i++; ?>
			<div class="product-thumb">
			<?php if ($product['thumb']) { ?>
				<div class="image">
					
				<a class="" data-id="<?php echo $product['product_id']; ?>"  href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a>
				
				<?php if($class_css == "column"){ ?><span><?php echo ++$k; ?></span><?php } ?>
				
				</div>
				<?php } ?>
				<div class="small_detail">
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
				<div class="price">
				  <?php if (!$product['special']) { ?>
				  <?php echo $product['price']; ?>
				  <?php } else { ?>
				  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
				  <?php } ?>
				</div>
				<?php } ?>
				<div class="button-group">
					<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>','<?php echo $product['minimum']; ?>');"><?php echo $button_cart; ?></button>
					<div class="wishlist-compare">
						<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
						<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
					</div>
				</div>
				</div>
				<div class="box_btn_icon">
				<div class="description"><p><?php echo $product['description']; ?></p></div>
				<div class="cart">
					<a class="btn btn-cart" title="<?php echo $button_cart; ?>" onclick="btadd.cart('<?php echo  $product['product_id'];  ?>','<?php echo $product['minimum']; ?>');"><span><?php echo $button_cart; ?></span></a>
					<a class="btn btn-shopping" title="<?php echo $button_detail; ?>" href="<?php echo $product['href']; ?>"><span><?php echo $button_detail; ?></span></a>
					
				</div>
				<div class="compare"><a class="action-button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo  $product['product_id'];  ?>');"><span><?php echo $button_compare; ?></span></a></div>
				<div class="wishlist"><a class="action-button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo  $product['product_id']; ?>');"><span><?php echo $button_wishlist; ?></span></a></div>
				</div>
			</div>
			<?php if((($i%$num_row)==0)||($i==count($tab['products']))){ ?> <div class="total"><?php echo $jj.' - '.$i; ?> (<?php echo count($tab['products']); ?>)</div> </li> <?php } ?>
			<?php } ?></ul>
		<div class="clearfix"></div>
		<?php if ($use_scrolling_panel) { ?>
			<a id="prev_tab<?php echo $numTab.$module; ?>" class="prev" href="javascript:void(0)"><i class="fa fa-angle-left"></i></a>
			<a id="next_tab<?php echo $numTab.$module; ?>" class="next" href="javascript:void(0)"><i class="fa fa-angle-right"></i></a>
		<?php } ?>
		<?php } ?>
    </div>
	<?php } ?>
  </div>
  </div>
</div>
</div>
<?php } ?>