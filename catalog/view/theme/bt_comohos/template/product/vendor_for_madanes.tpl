<?php global $config;?>

<?php if($config->get('boss_manager')){
		$boss_manager = $config->get('boss_manager'); 
	}else{
		$boss_manager = '';
	} ?>
<?php 
	if(!empty($boss_manager)){
		$other = $boss_manager['other']; 
	}
	$refine_search = isset($boss_manager['other']['refine_search'])?$boss_manager['other']['refine_search']:false;
	$category_info = isset($boss_manager['other']['category_info'])?$boss_manager['other']['category_info']:1;
	
?>
<?php echo $header; ?>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','//connect.facebook.net/en_US/fbevents.js');
// Insert Your Facebook Pixel ID below. 
fbq('init', '1205313566253712');
fbq('track', 'PageView');
fbq('track', 'ViewContent');
</script>
<!-- Insert Your Facebook Pixel ID below. --> 
<noscript>

	<img height="1" width="1" src="https://www.facebook.com/tr?id=1205313566253712&ev=PageView&noscript=1"/>

</noscript>

<!-- End Facebook Pixel Code -->
<div class="container">
	
  <div class="row bt-breadcrumb">
    <!-- <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul> -->
  </div>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>">

    	<?php echo $content_top; ?>
	  <?php if ($other['category_info'] == 1) { ?>
      <div class="category-info">
	  <?php if ($thumb) { ?>
        <?php if ($thumb) { ?>
        <div class="image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
        <?php } ?>
		<?php } ?>
		<h3><?php echo $heading_title; ?></h3>
        <?php if ($description && $description != '<p><br></p>') { ?>
        <?php echo $description; ?>
        <?php } ?>
      </div>
      <?php } ?>
      
    
      <?php if ($products) { ?>
	  
		
		<?php 
			global $registry; 
			$loader = new Loader($registry);
			$loader->model('bossthemes/boss_refinesearch');
			$loader->model('tool/image');
			$b_model = $registry->get('model_bossthemes_boss_refinesearch');
			$image_model = $registry->get('model_tool_image');
			$b_f_setting = $config->get('boss_refinesearch_module');
			$b_f_status = $config->get('boss_refinesearch_status');
		  
		?>
		<div class="bt-featured-pro2">
			<div class="box-heading title">
				<h1>OUR PRODUCTS</h1>
			</div>
		</div>

		<div class="box-content bt-product-content">

		<div class="row">
        <?php foreach ($products as $product) { ?>

        <div class="product-layout product-grid col-lg col-xs-4 col-md-4">
          <div class="product-thumb">
            <div class="image">
			  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
			
			</div>
			<div style="text-align: center;">
				<div class="button-group">
					<a href="<?php echo $product['href']; ?>" class="btn btn-primary">VIEW</a>
					
				</div>
			</div>
			
            <div class="caption">
                <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
				
                <!-- <?php if ($product['price']) { ?>
                <div class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span> 
                  <?php } ?>
                </div>
                <?php } ?> -->
				<?php echo $product['description']; ?>
				<?php 
					if($b_f_status){  $b_filters = $b_model->getFilterByProductId($product['product_id']);
					
					//echo '<pre>';print_r($b_filters);echo '</pre>';
					if(!empty($b_filters)){ ?>
					<div class="b_filter">
					<?php
						foreach($b_filters as $b_filters){ 
							if(isset($b_f_setting[$b_filters['filter_group_id']]['display']) && isset($b_f_setting[$b_filters['filter_group_id']]['under']) && $b_f_setting[$b_filters['filter_group_id']]['display']=='text' && $b_f_setting[$b_filters['filter_group_id']]['under']){ ?>		
						<span><?php echo $b_filters['name'] ?></span>
						<?php } ?>
						<?php if(isset($b_f_setting[$b_filters['filter_group_id']]['display']) && isset($b_f_setting[$b_filters['filter_group_id']]['under']) && $b_f_setting[$b_filters['filter_group_id']]['display']=='image' && $b_f_setting[$b_filters['filter_group_id']]['under']){ ?>		
						<img src="<?php echo $image_model->resize($b_filters['image'],isset($b_f_setting['width'])?$b_f_setting['width']:34,isset($b_f_setting['height'])?$b_f_setting['height']:34); ?>" title="<?php echo $b_filters['name'] ?>" alt="<?php echo $b_filters['name'] ?>"></span>
						<?php } ?>
					<?php } ?>
					</div>
					<?php }
					} 
				?>
				
				<div class="description"><p><?php echo $product['description']; ?></p></div>
            </div>
			  
            <!-- <div class="button-group button-list">

				<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <?php echo $button_cart; ?></button>
				<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
				<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
			</div> -->
          </div>
        </div>
        <?php } ?>
		</div>
	</div>
		<!-- <div class="result-pagination">
		  <div class="results pull-left"><?php echo $results; ?></div>
          <div class="links"><?php echo $pagination; ?></div>
		</div> -->
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
	  <div id="tags-load"><i class="fa fa-spinner fa-pulse fa-2x"></i></div>
	  
    <?php echo $column_right; ?></div>
	

	<?php include( 'catalog/view/javascript/bossthemes/boss_changegridlist/boss.changegridlist.js.php');?>

</div>
<script>
	var slideIndex = 1;
	showDivs(slideIndex);

	function plusDivs(n) {
	  showDivs(slideIndex += n);
	}

	function currentDiv(n) {
	  showDivs(slideIndex = n);
	}

	function showDivs(n) {
	  var i;
	  var x = document.getElementsByClassName("mySlides");
	  var dots = document.getElementsByClassName("demo");
	  if (n > x.length) {slideIndex = 1}    
	  if (n < 1) {slideIndex = x.length}
	  for (i = 0; i < x.length; i++) {
	     x[i].style.display = "none";  
	  }
	  for (i = 0; i < dots.length; i++) {
	     dots[i].className = dots[i].className.replace(" w3-white", "");
	  }
	  x[slideIndex-1].style.display = "block";  
	  dots[slideIndex-1].className += " w3-white";
	}
</script>
<?php echo $footer; ?>