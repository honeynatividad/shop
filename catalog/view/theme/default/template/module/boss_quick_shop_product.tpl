<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" title="<?php echo $text_hover_remove; ?>" data-dismiss="modal" aria-hidden="true">&times;</button>
</div>
<div class="modal-body">
<div id="notification"></div>
<?php global $config; ?>
<?php 
	$pro_des ='use_tab';
	if($config->get('boss_manager')){
		$boss_manager = $config->get('boss_manager'); 
	}else{
		$boss_manager = '';
	}
	if(!empty($boss_manager)){			
		$pro_des = $boss_manager['other']['pro_tab']; 		
	}
?>
<div id="content">
  <div class="product-info-qs product-info">
      <div class="row">
        <div class="col-md-6 col-xs-12">
          <div class="bt-product-zoom">
          <?php if ($thumb || $images) { ?>
			<?php if ($thumb) { ?>
			<div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="cloud-zoom" id='zoomqs' rel=""><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>			
			</div>
			<?php } ?>
		<?php } ?>
		  </div>
        </div>
		
        <div class="col-md-6 col-xs-12">
          <div class="product-name">
			<h1><?php echo $heading_title; ?></h1>
		  </div>
		  
		  <div class="description">
			<?php echo $description; ?>
		  </div>
		  
		  <?php if ($price) { ?>
			  <div class="price_info">
				<?php if (!$special) { ?>
				<span class="price"><?php echo $price; ?></span>
				<?php } else { ?>
				<span class="price-old"><?php echo $price; ?></span>
				<span class="price-new"><?php echo $special; ?></span>
				<?php } ?>
			  </div>
			<?php } ?>
			
			<div class="button-group">
				<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $product_id; ?>');"><?php echo $button_cart; ?></button>
				<div class="wishlist-compare">
				<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $product_id; ?>');"><i class="fa fa-heart"></i> </button>
				<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $product_id; ?>');"><i class="fa fa-retweet"></i></button>
				</div>
			</div>
			
			<div class="viewdetail">
				<a href="<?php echo $product_href; ?>"><?php echo $button_viewdetail; ?></a>
			</div>
        </div>
		<div class="col-xs-12">
			<?php if ($images) { ?>
			<div class="image-additional">
				<ul id="boss_image_additional">
				<?php foreach ($images as $image) { ?>
					<li ><a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="cloud-zoom-gallery" rel="useZoom: 'zoomqs', smallImage: '<?php echo $image['thumb']; ?>' "><img src="<?php echo $image['addition']; ?>"  title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
				<?php } ?>
				</ul>
			</div>	
			<?php } ?>
		</div>
        </div>
	  </div>
</div>


<script type="text/javascript" src="catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js"></script>
<script type="text/javascript"><!--
jQuery(document).ready(function($) {
	$.fn.CloudZoom.defaults = {
		adjustX: 0,
		adjustY: 0,
		tint: '#FFF',
		tintOpacity: 0.5,
		softFocus: 0,
		lensOpacity: 0.7,
		zoomWidth: '450',
		zoomHeight: '552',
		position: 'inside',
		showTitle: 0,
		titleOpacity: 0.5,
		smoothMove: '3'
	};
});

$('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
	
$('.product-info-qs select[name="profile_id"], .product-info-qs input[name="quantity-qs"]').change(function(){
    $.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('.product-info-qs input[name="product_id"], .product-info-qs input[name="quantity-qs"], .product-info-qs select[name="profile_id"]'),
		dataType: 'json',
        beforeSend: function() {
            $('.product-info-qs #profile-description').html('');
        },
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
            
			if (json['success']) {
                $('.product-info-qs #profile-description').html(json['success']);
			}	
		}
	});
});
//--></script>
</div>
</div>
</div>