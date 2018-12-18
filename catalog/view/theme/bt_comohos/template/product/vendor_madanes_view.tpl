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

<?php if($config->get('boss_manager')){
    $boss_manager = $config->get('boss_manager'); 
  }else{
    $boss_manager = '';
  } ?>
<?php 
  if(!empty($boss_manager)){
    $other = $boss_manager['other']; 
  }
  
?>
<?php
  $grid_view = explode("_",$other['grid_view']);
  //print_r($grid_view);die();
?>
<?php echo $header; ?>
<div class="container">
<div class ="row bt-breadcrumb">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
  <div class="product-info">
    <div class="row">
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-8'; ?>
        <?php } ?>
    <?php if ($thumb || $images) { ?>
        <div class="<?php echo $class; ?> ">
          <div class="bt-product-zoom">
          <ul class="thumbnails">
            <?php if ($thumb) { ?>
            <li><a class="thumbnail" href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>"><img src="../image/<?php echo $madanes_image; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
            <?php } ?>
      </ul>
      <!-- <ul class="thumbnails" id="boss-image-additional">
            <?php if ($images) { ?>
            <?php foreach ($images as $image) { ?>
            <li class="image-additional"><a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>"> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
            <?php } ?>
            <?php } ?>
          </ul>
      <a id="prev_image_additional" class="prev nav_thumb" href="javascript:void(0)" style="display:block;" title="prev"><i data-original-title="Previous" class="fa fa-angle-left btooltip">&nbsp;</i></a>
      <a id="next_image_additional" class="next nav_thumb" href="javascript:void(0)" style="display:block;" title="next"><i data-original-title="Next" class="fa fa-angle-right btooltip">&nbsp;</i></a> -->
      </div>
        </div>
    <?php } ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-4'; ?>
        <?php } ?>
        <div class="<?php echo $class; ?> bayani-care">
          <h2 ><?php echo $heading_title; ?></h2>
      
      <div class="description">
      
      <h3>INFO</h3>
          <p><i><?php echo $custom_desc;?></i></p>
          
      </div>
      
      <?php if ($price) { ?>
      <div class="price_info madanes_info">
        <span class="price-new"><?php echo $new_price; ?></span>
        <br><i>Per year</i>
        <br><i>One - time payment</i>
        <!-- <?php if (!$special) { ?>
        <span class="price-old"><?php echo $price; ?></span>
        
      <?php } else { ?>
        <span class="price-old"><?php echo $price; ?></span>
        <span class="price-new"><?php echo $special; ?></span>
      <?php } ?> -->
        
        <?php if ($tax) { ?>
          <span class="price-tax"><b><i><?php echo 'Vat Inclusive' ?> </i><?php //echo $tax; ?></b></span>
        <?php } ?>   
   
  
      </div>
      <?php } ?>
      
      <div id="product" class="options">
            
        <div class="cart">
          <div class="quantily_info">
            <div class="title_text"><span><?php echo $entry_qty; ?></span></div>
            <div class="select_number">
              <input type="hidden" name="certno" id="certno" value="<?php echo $certno ?>">
              <input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $vendor_id ?>">
              <input type="hidden" name="vendor_code" id="vendor_code" value="<?php echo $vendor_code ?>">
              <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control" />
              <button onclick="changeQty(1); return false;" class="increase"><i class="fa fa-angle-up"></i></button>
              <button onclick="changeQty(0); return false;" class="decrease"><i class="fa fa-angle-down"></i></button>
            </div>
            <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
            <?php if ($minimum >1) { ?>
            <div class="minimum"><?php echo $text_minimum; ?></div>
            <?php } ?>
          </div>
        
          <div class="button-group2">
            <button type="button" id="button-cart"  data-loading-text="<?php echo $text_loading; ?>" class="btn-cart"><i class="fa fa-shopping-cart"></i><?php echo $button_cart; ?></button>
          </div>      
        </div>
      </div>
         
        </div>
      </div>
  </div>
  
  <div id="tabs" class="htabs">
      <ul>
        <li class="active"><a href="#tab_description" data-toggle="tab"><?php echo $tab_description; ?></a></li>
      
      </ul>
    </div>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_description"><?php echo $description; ?></div>
    
      <?php if ($attribute_groups) { ?>
        <div class="tab-pane" id="tab_specification">
              <table class="attribute">
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                <thead>
                  <tr>
                    <td colspan="2"><strong><?php echo $attribute_group['name']; ?></strong></td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                  <tr>
                    <td><?php echo $attribute['name']; ?></td>
                    <td><?php echo $attribute['text']; ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
                <?php } ?>
              </table>
        </div>
        <?php } ?>
    
    <?php if ($review_status) { ?>
    <div class="review-product tab-pane" id="tab_review">
    <div class="review-heading"><h1><?php echo $tab_review; ?></h1></div>
            <div id="bt_review">
              <form class="form-horizontal" id="form-review">
                <div id="review"></div>
                <h1><?php echo $text_write; ?></h1>
                <?php if ($review_guest) { ?>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-name"><b><?php echo $entry_name; ?></b></label>
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" />
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label" for="input-review"><b><?php echo $entry_review; ?></b></label>
                    <textarea name="text" rows="5" id="input-review" class="form-control"></textarea>
                    <div class="help-block"><?php echo $text_note; ?></div>
                  </div>
                </div>
                <div class="form-group required">
                  <div class="col-sm-12">
                    <label class="control-label"><b><?php echo $entry_rating; ?></b></label>
                    &nbsp;&nbsp;&nbsp; <?php echo $entry_bad; ?>&nbsp;
                    <input type="radio" name="rating" value="1" />
                    &nbsp;
                    <input type="radio" name="rating" value="2" />
                    &nbsp;
                    <input type="radio" name="rating" value="3" />
                    &nbsp;
                    <input type="radio" name="rating" value="4" />
                    &nbsp;
                    <input type="radio" name="rating" value="5" />
                    &nbsp;<?php echo $entry_good; ?></div>
                </div>
                <?php echo $captcha; ?>
                <div class="buttons">
                  <div class="pull-left">
                    <button type="button" id="button-review" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>
                  </div>
                </div>
                <?php } else { ?>
                <?php echo $text_login; ?>
                <?php } ?>
              </form>
            </div>        
  </div>
  <?php } ?>
     
  <?php if (!empty($boss_facecomments) && $status) { ?>
    <div class="face-comment tab-pane" id="tab_facecomments">
       <div class="bt-facecomments">
      <div class="row">
        <div class="col-sm-12">
        <div class="fb-comments" data-href="<?php echo $url_f; ?>" data-colorscheme="<?php echo $color_scheme; ?>" data-numposts="<?php echo $num_posts; ?>" data-order-by="<?php echo $order_by; ?>" ></div>
        </div>
      </div>

      <div id="fb-root"></div>
      
      </div>
    </div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3&appId=<?php echo $app_id; ?>";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
      
  <?php } ?>
    </div>
  
  <?php if ($products) { ?>
  <div class="product-related">
    <h1 class="box-title"><?php echo $text_related; ?> (<?php echo count($products); ?>)</h1>
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
          <button class="btn-cart" type="button" onclick="btadd.vendorcart('<?php echo $certno ?>','<?php echo $vendor_id ?>', '<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <?php echo $button_cart; ?></button>
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
  <?php echo $content_bottom; ?>
  </div>
  </div>
  <?php echo $column_right; ?>
</div>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/carouFredSel-6.2.1.js"></script>
<script type="text/javascript"><!--
$('.bt-image-option').click(function(){
  $('.bt-image-option').each(function(){
    $(this).removeClass('active');
  });
  $(this).addClass('active');
});
function changeQty(increase) {
    var qty = parseInt($('.select_number').find("input").val());
    if ( !isNaN(qty) ) {
        qty = increase ? qty+1 : (qty > <?php echo $minimum; ?> ? qty-1 : <?php echo $minimum; ?>);
        $('.select_number').find("input").val(qty);
    }else{
    $('.select_number').find("input").val(1);
  }
}
$(window).load(function(){
  
  $('#product_related').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
        prev: '#prev_related',
        next: '#next_related',
        swipe: {
        onTouch : false
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
  $('#boss-image-additional').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
        prev: '#prev_image_additional',
        next: '#next_image_additional',
        swipe: {
        onTouch : true
        },
        items: {
            width: 120,
            height: 'auto',
            visible: {
            min: 1,
            max: 3
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 500,   //  The duration of the transition.
        }
    });
});  
//--></script>
<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
  $.ajax({
    url: 'index.php?route=product/product/getRecurringDescription',
    type: 'post',
    data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
    dataType: 'json',
    beforeSend: function() {
      $('#recurring-description').html('');
    },
    success: function(json) {
      $('.alert, .text-danger').remove();
      
      if (json['success']) {
        $('#recurring-description').html(json['success']);
      }
    }
  });
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {

  $.ajax({
    url: 'index.php?route=bossthemes/boss_add/vendorcart',
    type: 'post',
    data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
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
        var vendor_id = $("#vendor_code").val();
        
        addCartProductMadanes(vendor_id,json['continue'], json['checkout'], json['title'], json['thumb'], json['success'], 'success');
        
        
        $('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);
        
        $('#cart > ul').load('index.php?route=common/cart/info ul li');
      }
    },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
  });
});
//--></script> 
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
          $(node).button('loading');
        },
        complete: function() {
          $(node).button('reset');
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
$('#review').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
  $.ajax({
    url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
    type: 'post',
    dataType: 'json',
    data: $("#form-review").serialize(),
    beforeSend: function() {
      $('#button-review').button('loading');
    },
    complete: function() {
      $('#button-review').button('reset');
    },
    success: function(json) {
      $('.alert-success, .alert-danger').remove();
      
      if (json['error']) {
        $('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
      }
      
      if (json['success']) {
        $('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
        
        $('input[name=\'name\']').val('');
        $('textarea[name=\'text\']').val('');
        $('input[name=\'rating\']:checked').prop('checked', false);
      }
    }
  });
});

$(document).ready(function() {
  $('.thumbnails').magnificPopup({
    type:'image',
    delegate: 'a',
    gallery: {
      enabled:true
    }
  });
});
function goToByScroll(id){
    $('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');   
}
//--></script> 

<?php echo $footer; ?>