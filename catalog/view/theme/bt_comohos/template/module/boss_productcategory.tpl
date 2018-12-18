<?php if (!$image) { ?>
<div class="container">
<div class="row">
<?php } ?>
<div id="bt_product_category<?php echo $module; ?>" class="bt-product-category <?php echo $image?'bg-image':''; ?>" <?php if($image) { ?> style="background-image:url(<?php echo $image; ?>);"<?php } ?>>
<?php if ($image) { ?>
	<div class="container">
	<div class="row">
<?php } ?>
  <div class="box-heading title"><h1><?php echo $heading_title; ?></h1></div>
  <div class="box-content">
	<div class="htabs cate-tabs">
		<ul class="nav nav-tabs">
		<?php if(!empty($menus)){ ?>
		  <?php foreach($menus as $key_m => $menu){ ?>
		  	<?php
		  	if($menu['title'] == "Individual Comprehensive Plan"){
		  	?>
		  	<li><a href="https://shop.philcare.com.ph/individual-comprehensive-plan" ><?php if($menu['icon']) { ?><img src="<?php echo $menu['icon']; ?>" alt="<?php echo $menu['title']?>" > <?php } ?><?php echo $menu['title']?><i class="fa fa-angle-right"></i></a></li>
		  	<?php
		  	}elseif($menu['title'] == "Corporate Programs"){
		  	?>
		  	<li><a href="https://shop.philcare.com.ph/corporate-programs" ><?php if($menu['icon']) { ?><img src="<?php echo $menu['icon']; ?>" alt="<?php echo $menu['title']?>" > <?php } ?><?php echo $menu['title']?><i class="fa fa-angle-right"></i></a></li>
		  	<?php
		  	}else{
		  	?>

			<li><a href="#menu_<?php echo $module.'_'.$key_m; ?>" data-toggle="tab"><?php if($menu['icon']) { ?><img src="<?php echo $menu['icon']; ?>" alt="<?php echo $menu['title']?>" > <?php } ?><?php echo $menu['title']?><i class="fa fa-angle-right"></i></a></li>
			<?php
		  	}
		  	?>

		  <?php } ?>
		<?php } ?>
		</ul>
	</div>
	<div class="tab-content cate-tab-content">
		<?php if(!empty($menus)){ ?>
		  <?php foreach($menus as $key_m => $menu){ ?>
			<div class="tab-pane" id="menu_<?php echo $module.'_'.$key_m; ?>">
				<div class="row">
				<?php if(!empty($menu['products'])) { ?>
					<?php $col = 12/(int)$menu['per_row'];?>
					<?php foreach($menu['products'] as $key => $product){ ?>
					<div class="product-list col-sm-<?php echo $col;?> col-xs-12">
					<div class="product-thumb">
					  <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
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
						<?php if ($product['description']) { ?>
						<!-- REMOVE by HCN
						<div class="description">
						  <p><?php echo $product['description']; ?></p>
						</div>!-->
						<?php } ?>
						<p class="price">
						  <?php if (!$product['special']) { ?>
							<?php echo $product['price']; ?>
							<?php } else { ?>
							<span class="price-deal"><?php echo $product['special']; ?></span>
							<?php } ?>
						  
						</p>
						<div class="button-group button-list">
							<button type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>');" class="btn-cart"><i class="fa fa-shopping-cart"></i><?php echo $button_cart; ?></button>
							<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
							<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
						</div>
					  </div>
					</div>
					</div>
					<?php } ?>
				<?php } ?>
				</div>
			</div>
		  <?php } ?>
		<?php } ?>
	</div>
  </div>
  <?php if ($image) { ?>
	</div>
	</div>
 <?php } ?>
</div>
<?php if (!$image) { ?>
	</div>
</div>
<?php } ?>
<script type="text/javascript"><!--
$(window).load(function(){
	$('.htabs .nav-tabs >li:first').addClass('active');
	$('.tab-content >div:first').addClass('active');
});
//--></script>