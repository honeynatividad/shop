//var isMobile = /iPhone|iPod|iPad|Phone|Mobile|Android|hpwos/i.test(navigator.userAgent);
//var isPhone = /iPhone|iPod|Phone|Android/i.test(navigator.userAgent);
/* SHARED VARS */
var touch = false;

jQuery(document).ready(function($) {
	$('#search input[name=\'search\']').parent().find('button').on('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('#search input[name=\'search\']').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		}

		location = url;
	});

	$('#search input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('#search input[name=\'search\']').parent().find('button').trigger('click');
		}
	});
});
// handles Animate
function dataAnimate(){
  $('[data-animate]').each(function(){
    
    var $toAnimateElement = $(this);
    
    var toAnimateDelay = $(this).attr('data-delay');
    
    var toAnimateDelayTime = 0;
    
    if( toAnimateDelay ) { toAnimateDelayTime = Number( toAnimateDelay ); } else { toAnimateDelayTime = 200; }
    
    if( !$toAnimateElement.hasClass('animated') ) {
      
      $toAnimateElement.addClass('not-animated');
      
      var elementAnimation = $toAnimateElement.attr('data-animate');
      
      $toAnimateElement.appear(function () {
        
        setTimeout(function() {
          $toAnimateElement.removeClass('not-animated').addClass( elementAnimation + ' animated');
        }, toAnimateDelayTime);
        
      },{accX: 0, accY: -80},'easeInCubic');
      
    }
    
  });
}
   
jQuery(document).ready(function($) {
  
  /* DETECT PLATFORM */
  $.support.touch = 'ontouchend' in document;
  
  if ($.support.touch) {
    touch = true;
    $('body').addClass('touch');
  }
  else{
	$('body').addClass('notouch');
  }
  
    // Product List
	$('#list-view').click(function() {
		$('#list-view').addClass('active');
		$('#grid-view').removeClass('active');
	});
	
	// Product Grid
	$('#grid-view').click(function() {
		$('#grid-view').addClass('active');
		$('#list-view').removeClass('active');
	});
  
	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
	} else {
		$('#grid-view').trigger('click');
	}
  
  /* Handle Animate */
  if(touch == false){
    dataAnimate();
  }
  
	$(".open-bt-mobile,.close-panel").click(function(){
		$('body').toggleClass('openNav');
	});
	$('.nav-pills li.parent > p').click(function(){

		if ($(this).text() == '+'){
			$(this).parent('li').children('.dropdown').slideDown(300);
			$(this).text('-');
			$(this).parent('li').addClass('active');
		}else{
			$(this).parent('li').children('.dropdown').slideUp(300);
			$(this).text('+');
			$(this).parent('li').removeClass('active');
		}  
		
	});
	
});

// Js smartresize
(function($,sr){
  // debouncing function from John Hann
  // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
  var debounce = function (func, threshold, execAsap) {
      var timeout;

      return function debounced () {
          var obj = this, args = arguments;
          function delayed () {
              if (!execAsap)
                  func.apply(obj, args);
              timeout = null; 
          };

          if (timeout)
              clearTimeout(timeout);
          else if (execAsap)
              func.apply(obj, args);

          timeout = setTimeout(delayed, threshold || 100); 
      };
  }
// smartresize 
 jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');

var TO = false;
$(window).smartresize(function(){
if(TO !== false)
    clearTimeout(TO);
 TO = setTimeout(resizeWidth, 400); //400 is time in miliseconds
});

function handleMenu(){
  // Listener for header
  var scrollTop = $(this).scrollTop();
  var heightHeader = $('#header').outerHeight();
  var heightNav = $('#bt_menu').outerHeight();
  var heighttotal = (heightHeader+heightNav);
  
  if(getWidthBrowser() > 1024){
    if(scrollTop > heighttotal){
      if(!$('#bt_menu').hasClass('show')){
        $('<div style="min-height:'+heightNav+'px"></div>').insertBefore('#bt_menu');
        $('#bt_menu').addClass('show').addClass('fadeInDown animated');
      }
    }else{
      if($('#bt_menu').hasClass('show')){
        $('#bt_menu').prev().remove();
        $('#bt_menu').removeClass('show').removeClass('fadeInDown animated');
      }
    }
  }
};
$(window).load(function(){
	resizeWidth();
});
function resizeWidth(){
	var currentWidth = $(".bt-content-menu").outerWidth();	
	$('.mega-menu ul > li.parent > div').each(function(index, element) {		
		var menu = $('.bt-content-menu').offset();
		var dropdown = $(this).parent().offset();
		
		i = (dropdown.left + $(this).outerWidth()) - (menu.left + currentWidth);
		if (i > 0) {
			$(this).css('margin-left', '-' + (i)+ 'px');
		}
		else
			$(this).css('margin-left', '0px');
	});
}
$.fn.bttabs = function() {
	var selector = this;
	
	this.each(function() {
		var obj = $(this); 
		
		$(obj.attr('href')).hide();
		
		obj.click(function() {
			$(selector).removeClass('selected');
			
			$(this).addClass('selected');
			
			$($(this).attr('href')).fadeIn();
			
			var tabmodule = $(this).attr('data-crs');
			loadslider(tabmodule);
			
			$(selector).not(this).each(function(i, element) {
				$($(element).attr('href')).hide();
			});
			
			return false;
		});
	});

	$(this).show();
	
	$(this).first().click();
};

var btadd = {
	//added by hanna

	'viewmore': function(product_id, url) {
		//alert("TEST");
		//window.location = "http://shop.philcare.com.ph/testsite/index.php?route='product/vendor/view&product_id="+product_id+"&name="+url;
	},
	'vendorcart': function(certno,vendor_id,product_id,quantity) {
		//alert(vendor_id + " - " + certno + " : " + product_id + " - " + quantity);
		$.ajax({
			url: 'index.php?route=bossthemes/boss_add/vendorcart/',
			type: 'post',
			data: 'certno=' + certno + 'vendor_id=' + vendor_id + '&product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					//alert("VENDORCARDT "+json['url']);
					addCartProductNoticeVendor(json['continue'], json['checkout'], json['title'], json['thumb'], json['success'], 'success',json['url']);
					$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);
				
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'madanescart': function(certno,vendor_id,product_id,quantity,vendor_code) {
		//alert(vendor_id + " - " + certno + " : " + product_id + " - " + quantity+"="+vendor_code);
		$.ajax({
			url: 'index.php?route=bossthemes/boss_add/vendorcart/',
			type: 'post',
			data: 'certno=' + certno + 'vendor_id=' + vendor_id + '&product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					//alert("VENDORCARDT "+json['url']);
					addCartProductMadanes(vendor_code,json['continue'], json['checkout'], json['title'], json['thumb'], json['success'], 'success',json['url']);
					$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);
				
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'cart': function(product_id,quantity) {

		$.ajax({
			url: 'index.php?route=bossthemes/boss_add/cart/',
			type: 'post',
			data: 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				if (json['redirect']) {
					location = json['redirect'];
				}

				if (json['success']) {
					
					addCartProductNotice(json['continue'], json['checkout'], json['title'], json['thumb'], json['success'], 'success');
					$('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);
				
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'wishlist': function(product_id) {
		$.ajax({
			url: 'index.php?route=bossthemes/boss_add/wishlist/',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					addWishlistProductNotice(json['continue'], json['wishlist'], json['title'], json['thumb'], json['success'], 'success');
					$('#wishlist-total span').html(json['total']);
					$('#wishlist-total').attr('title', json['total']);
				}else{
					addWishlistProductNotice(json['continue'], json['wishlist'], json['title'],'', json['info']);
					$('#wishlist-total span').html(json['total']);
					$('#wishlist-total').attr('title', json['total']);
				}
			}
		});
	},
	'compare': function(product_id) {
		$.ajax({
			url: 'index.php?route=bossthemes/boss_add/compare',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				if (json['success']) {
					addCompareProductNotice(json['continue'], json['compare'], json['title'], json['thumb'], json['success'], 'success');
					$('#compare-total').html(json['total']);
				}
			}
		});
	}
	
};

function addCartProductMadanes(vendor,conti, check, title, thumb, text, type) {
	//alert("We are currently doing some testing. Please do not continue.");
	$.jGrowl.defaults.closer = true;
	var tpl = thumb + '<h3>'+text+'</h3>';
	$.jGrowl(tpl, {		
		life: 36000000,
		btnGroup: '<div class="buttons"><div id="madanes"><a class="btn btn-primary" href="'+vendor+'">'+conti+'</a><a class="btn btn-primary" href="index.php?route=checkout/checkout">'+check+'</a></div></div>',
		header: title,
		speed: 'slow'
	});
}

function addCartProductNotice(conti, check, title, thumb, text, type) {
	$.jGrowl.defaults.closer = true;
	var tpl = thumb + '<h3>'+text+'</h3>';
	$.jGrowl(tpl, {		
		life: 36000000,
		btnGroup: '<div class="buttons"><a class="btn btn-primary" href="index.php?route=common/home">'+conti+'</a><a class="btn btn-primary" href="index.php?route=checkout/checkout">'+check+'</a></div>',
		header: title,
		speed: 'slow'
	});
}

function addCartProductNoticeVendor(conti, check, title, thumb, text, type,url) {
	//alert("Please do not proceed. We are currently doing a maintenance checkup.");
	$.jGrowl.defaults.closer = true;
	var tpl = thumb + '<h3>'+text+'</h3>';
	$.jGrowl(tpl, {		
		life: 36000000,
		btnGroup: '<div class="buttons"><div id="madanes"><a class="btn btn-primary" href="index.php?route=common/home">'+conti+'</a><a class="btn btn-primary" href="index.php?route=checkout/checkout">'+check+'</a></div></div>',
		header: title,
		speed: 'slow'
	});
}

function addCompareProductNotice(conti, comp, title, thumb, text, type) {
	$.jGrowl.defaults.closer = true;
	var tpl = thumb + '<h3>'+text+'</h3>';
	$.jGrowl(tpl, {		
		life: 36000000,
		btnGroup: '<div class="buttons"><a type="button" class="btn btn-primary" href="index.php?route=common/home">'+conti+'</a><a type="button" class="btn btn-primary" href="index.php?route=product/compare">'+comp+'</a></div>',
		header: title,
		speed: 'slow'
	});
	
}

function addWishlistProductNotice(conti, wish, title, thumb, text, type) {
	$.jGrowl.defaults.closer = true;
	var tpl = thumb + '<h3>'+text+'</h3>';
	$.jGrowl(tpl, {		
		life: 36000000,
		btnGroup: '<div class="buttons"><a type="button" class="btn btn-primary" href="index.php?route=common/home">'+conti+'</a><a type="button" class="btn btn-primary" href="index.php?route=account/wishlist">'+wish+'</a></div>',
		header: title,
		speed: 'slow'
	});
}