<?php global $config, $url;?>
<!-- Facebook comments data -->
<?php 
	if($config->get('boss_facecomments')){
		$boss_facecomments = $config->get('boss_facecomments'); 
	}else{
		$boss_facecomments = array();
	}
	
	if (!empty($boss_facecomments)) {
		$status = $boss_facecomments['status'];
		$app_id = $boss_facecomments['app_id'];
		$color_scheme = $boss_facecomments['color_scheme'];
		$num_posts = $boss_facecomments['num_posts'];
		$order_by = $boss_facecomments['order_by'];
	}else {
		$status = 0;
		$app_id = '1679538022274729';
		$color_scheme = 'light';
		$num_posts = 5;
		$order_by = 'reverse_time';
	}
	
	$url_f = '';
		
		if (isset($this->request->get['route'])) {
			$route = $this->request->get['route'];
		} else {
			$route = 'common/home';
		}
		
		if ($route == 'common/home') {
			$url_f = $url->link('common/home');
		} elseif ($route == 'product/product' && isset($this->request->get['product_id'])) {
			$url_f = $url->link('product/product', 'product_id=' . $this->request->get['product_id']);
		} elseif ($route == 'product/category' && isset($this->request->get['path'])) {
			$url_f = $url->link('product/category', 'path=' . $this->request->get['path']);
		} elseif ($route == 'information/information' && isset($this->request->get['information_id'])) {
			$url_f = $url->link('information/information', 'information_id=' . $this->request->get['information_id']);
		} else {
			if ($this->request->server['HTTPS']) {
				$url_f = $this->config->get('config_ssl');
			} else {
				$url_f = $this->config->get('config_url');
			}
			
			$url_f .= $this->request->server["REQUEST_URI"];
		}
?>
<?php echo $header; ?>
<div class="bt-breadcrumb">
<div class="container">
  <div class="row">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
  </div>
</div>
<div class="container">
<div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
	<div class="boss_article-item boss_article-detail">
	  <div class="content_bg">
		<div class="article-title">
			<img src="<?php echo $thumb; ?>" alt="<?php echo $name;?>" title="<?php echo $name;?>"/>
			<h1 class="article-title-boss"><?php echo $heading_title; ?></h1>
			<div class="date-post">
				<small class="time-stamp time-article">
					<?php $date = new DateTime($date_modified);?>
					<?php echo $date->format('l, M j, Y');?>
				</small>
				<span class="comment-count"><span><?php echo $comments; ?></span> <?php echo $text_comments;?></span>
			</div>
		</div>
		<div class="article-content">
			<p><?php echo $title;?></p>
			<?php echo $content;?>
		</div>
		<div class="boss_article-action">
			<?php if ($tags && !empty($tags)) { ?>
			  <div class="tags"><span><?php echo $text_tags; ?> </span>
			  <ul>
				<?php for ($i = 0; $i < count($tags); $i++) { ?>
				<?php if ($i < (count($tags) - 1)) { ?>
				<li class="item"><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a></li>
				<?php } else { ?>
				<li class="item"><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a></li>
				<?php } ?>
				<?php } ?>
			  </ul>
			  </div>
			<?php } ?>
			<div class="article-share"><!-- AddThis Button BEGIN -->
			  <div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share;?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a></div>
			  <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
			  <!-- AddThis Button END --> 
			</div>	
		</div>
	</div>
	<?php if(!empty($articles)) { ?>
		<div class="article-related">
			<h1 class="box-title"><?php echo $text_article_related; ?> (<?php echo count($articles); ?>)</h1>
			<div class="carousel-button">
				<a id="prev_art_related" class="prev nav_thumb" href="javascript:void(0)" style="display:inline-block;" title="prev"><i class="fa fa-angle-left"></i></a>
				<a id="next_art_related" class="next nav_thumb" href="javascript:void(0)" style="display:inline-block;" title="next"><i class="fa fa-angle-right"></i></a>
			</div>
			<div class="list_carousel responsive" >
				<ul id="article_related" class="content-articles">
					<?php foreach ($articles as $article) { ?>
					<li>
					<div class="relt-article">
						<div class="image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a></div>
				
						<div class="caption">
						  <div class="name"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></div>
						  <div class="date-comments">
							  <small class="time-stamp">
								<?php $date = new DateTime($article['date_added']);?>
								<?php echo $date->format('M j, Y');?>
							  </small>
							  <span class="comment-count"><a href="<?php echo $article['href']; ?>"><?php echo $comments; ?> <?php echo $text_comments;?></a></span>
						  </div>

						  <div class="title">
							<p><?php echo $article['title']; ?></p>
						  </div>
						  
						  <a class ="btn-readmore" href="<?php echo $article['href']; ?>"><?php echo $text_readmore; ?></a>
						</div>
					</div>
					</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	<?php } ?>
	
	<?php if (!empty($products)) { ?>
	<div class="product-related">
	  <h1 class="box-title"><?php echo $text_product_related; ?> (<?php echo count($products); ?>)</h1>
	  <div class="carousel-button">
			<a id="prev_related" class="prev nav_thumb" href="javascript:void(0)" style="display:inline-block;" title="prev"><i class="fa fa-angle-left"></i></a>
			<a id="next_related" class="next nav_thumb" href="javascript:void(0)" style="display:inline-block;" title="next"><i class="fa fa-angle-right"></i></a>
	  </div>
	  <div class="list_carousel responsive" >
			<ul id="product_related" class="content-products"><?php foreach ($products as $product) { ?><li>				
			<div class="relt_product">
            <div class="image">
				<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
				<div class="button-group button-grid">
					<button class="btn-cart" type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>');"><i class="fa fa-shopping-cart"></i> <?php echo $button_cart; ?></button>
					<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
					<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
				</div>
			</div>
			
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
              <div class="price">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
				<span class="price-old"><?php echo $product['price']; ?></span>
                <span class="price-new"><?php echo $product['special']; ?></span> 
                <?php } ?>
              </div>
              <?php } ?>
              
            </div>
          </div>
        </li><?php } ?></ul>    
      </div>
    </div>
	<?php } ?> 
	<?php if ($allow_comment!=0) { ?>
		<?php if ($comment_status==1||$allow_comment==1) { ?>
	<div class="comments">                
		<div id="article-comments"></div> 
		<div class="form-comment-container">
			<div id="new">
				<h1><?php echo $text_comment; ?> </h1>
			</div>       
			<div id="0_comment_box" class="form-comment content_bg">
				  <?php if(!$login){?>
					  <div class="field" id="username">
						  <label class="" for="name"><?php echo $text_username; ?><em>*</em></label>
						  <div class="input-box">
							  <input type="text" class="form-control required-entry" value="" title="Name" id="name" name="username">
						  </div>
					  </div>                    
					  <div class="field" id="email">
						  <label class="" for="email"><?php echo $text_email; ?><em>*</em></label>
						  <div class="input-box">
							  <input type="text" class="form-control required-entry validate-email" value="" title="Email" id="email" name="email_blog">
						  </div>
					  </div>
				  <?php } else{?>
						<input type="hidden" class="form-control required-entry" value="<?php echo $username; ?>" title="Name" id="name" name="username">
						<input type="hidden" class="form-control required-entry validate-email" value="<?php echo $email; ?>" title="Email" id="email" name="email_blog">
				  <?php } ?>
				  <div class="input-box-comment">
					  <label class="tt_input" for="comment"><?php echo $entry_comment; ?><em>*</em></label>
					  <textarea rows="2" cols="10" class="required-entry form-control" style="height:200px" title="Comment" id="comment" name="comment_content"></textarea>
				  </div>
				  
				  <?php if ($site_key) { ?>
					<div class="form-group">
					  <div class="col-sm-offset-2 col-sm-10">
						<div class="g-recaptcha" data-sitekey="<?php echo $site_key; ?>"></div>
						<?php if ($error_captcha) { ?>
						  <div class="text-danger"><?php echo $error_captcha; ?></div>
						<?php } ?>
					  </div>
					</div>
				  <?php } ?>
				  <div class="submit-button">
					<div class="left"><a id="button-comment" class="btn btn-submit"><?php echo $button_continue; ?></a></div>
				  </div>
			</div>
		</div>                   
	 </div>
	 <?php } } ?>   
			
    </div>
	<?php if (!empty($boss_facecomments) && $status) { ?>
		   <div class="bt-facecomments">
			<div class="row">
			  <div class="col-sm-12">
				<div class="fb-comments" data-href="<?php echo $url_f; ?>" data-colorscheme="<?php echo $color_scheme; ?>" data-numposts="<?php echo $num_posts; ?>" data-order-by="<?php echo $order_by; ?>" ></div>
			  </div>
			</div>

			<div id="fb-root"></div>
			
			</div>
		
		<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=<?php echo $app_id; ?>";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
	<?php } ?>
  <?php echo $content_bottom; ?></div>
  <?php echo $column_right; ?>
  </div>
 </div>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js"></script> 
<script type="text/javascript"><!--
$('#article-comments').load('index.php?route=bossblog/article/comment&blog_article_id=<?php echo $blog_article_id; ?>');
$('#button-comment').bind('click', function() { 
	$.ajax({
		url: 'index.php?route=bossblog/article/write&blog_article_id=<?php echo $blog_article_id; ?>&need_approval=<?php echo $need_approval; ?>&approval_status=<?php echo $approval_status; ?>',
		type: 'post',
		dataType: 'json',
		data: 'username=' + encodeURIComponent($('input[name=\'username\']').val()) + '&comment_content=' + encodeURIComponent($('textarea[name=\'comment_content\']').val()) + '&email=' + encodeURIComponent($('input[name=\'email_blog\']').val()) + '&g-recaptcha-response=' + encodeURIComponent($('textarea[name=\'g-recaptcha-response\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-comment').attr('disabled', true);
			$('#new').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() { 
			$('#button-comment').attr('disabled', false);
			$('#captcha').attr('src', 'index.php?route=tool/captcha#'+new Date().getTime());
			$('.attention').remove();
			$('input[name=\'captcha\']').val('');
		},		
		success: function(json) { 
			if (json['error']) {
				$('#new').after('<div class="warning">' + json['error'] + '</div>');
			}
			
			if (json['success']) {
				$('#new').after('<div class="success">' + json['success'] + '</div>');
				$('#article-comments').load('index.php?route=bossblog/article/comment&blog_article_id=<?php echo $blog_article_id; ?>');				
				$('input[name=\'username\']').val('');
				$('textarea[name=\'comment_content\']').val('');
				$('input[name=\'email_blog\']').val('');
                $('input[name=\'captcha\']').val('');
			}
		}
	});
});
$(window).load(function(){
	$('#product_related').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
        prev: '#prev_related',
        next: '#next_related',
        swipe: {
        onTouch : true
        },
        items: {
            width: 370,
			height: 470,
            visible: {
            min: 1,
            max: 3
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000   //  The duration of the transition.
        }
	});
	$('#article_related').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
        prev: '#prev_art_related',
        next: '#next_art_related',
        swipe: {
        onTouch : true
        },
        items: {
            width: 272,
			height: 'auto',
            visible: {
            min: 1,
            max: 3
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000   //  The duration of the transition.
        }
	});
});  
//--></script> 
<?php echo $footer; ?>