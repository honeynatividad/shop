<?php global $config; ?>
<?php
	$boss_manager = array(
		'option' => array(
			'bt_scroll_top' => true,
			'animation' 	=> true,			
		),
		'layout' => array(
			'mode_css'   => 'wide',
			'box_width' 	=> 1200,
			'h_mode_css'   => 'inherit',
			'h_box_width' 	=> 1200,
			'f_mode_css'   => 'inherit',
			'f_box_width' 	=> 1200
		),
		'status' => 1
	);
?>
<?php if($config->get('boss_manager')){
		$boss_manager = $config->get('boss_manager'); 
	}else{
		$boss_manager = $boss_manager;
	} 
	$header_link = isset($boss_manager['header_link'])?$boss_manager['header_link']:''; 
	$option = isset($boss_manager['option'])?$boss_manager['option']:''; 
?>
<?php 
	$bt_style = '';$h_style = ''; $status=0; $show_menu = 'default'; 
	if($config->get('boss_manager')){
		$boss_manager = $config->get('boss_manager'); 
	}else{
		$boss_manager = '';
	}
	if(!empty($boss_manager)){
		$layout = isset($boss_manager['layout'])?$boss_manager['layout']:''; 
		$status = isset($boss_manager['status'])?$boss_manager['status']:0; 
		$option = isset($boss_manager['option'])?$boss_manager['option']:''; 
		$other = isset($boss_manager['other'])?$boss_manager['other']:''; 
		$header_link = isset($boss_manager['header_link'])?$boss_manager['header_link']:''; 
	}
	if(isset($layout['mode_css']) && $layout['mode_css'] =='wide'){
		$mode_css = 'bt-wide';
	}else{
		$mode_css = 'bt-boxed';
		$bt_style = (!empty($layout['box_width']))?'style="max-width:'.$layout['box_width'].'px"':'';
	}
	if(isset($layout['h_mode_css']) && $layout['h_mode_css'] =='boxed'){
		$h_mode_css = 'bt-hboxed';
		$h_style = (!empty($layout['h_box_width']))?'style="max-width:'.$layout['h_box_width'].'px"':'';
	}else{
		$h_mode_css = '';
	}
	if(isset($other['stylesheet']) && $other['stylesheet']){
		$stylesheet = $other['stylesheet'];
	}else{
		$stylesheet=1;
	}
	//echo '<pre>'; print_r($boss_manager); echo '</pre>'; die();
?>

<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bossthemes/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bossthemes/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Raleway:400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic,300italic,300' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Courgette' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Quicksand:300,400,700" rel="stylesheet" type="text/css" />
<link href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Raleway:400,400italic,500,500italic,600,600italic,700,700italic,800,900,800italic,900italic' rel='stylesheet' type='text/css'>
<link href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/stylesheet.css" rel="stylesheet"/>
<?php $dir = ''; ?>
<?php if($direction == 'rtl'){ ?>
<link href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/stylesheet_rtl.css" rel="stylesheet"/>
<?php $dir = 'right-to-left'; ?>
<?php } ?>

<link href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/checkout_rtl.css" rel="stylesheet"/>
<link href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/menu_default.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/bossthemes/boss_megamenu.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/bossthemes/jquery.jgrowl.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/bossthemes/boss_alphabet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/bossthemes/responsive.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/bossthemes/boss_facecomments.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/bossthemes/loading.css" />
<?php if (isset($option['animation']) && $option['animation']) {  ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/<?php echo $config->get('config_theme'); ?>/stylesheet/bossthemes/cs.animate.css" />
<?php } ?>

<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/getwidthbrowser.js"></script>
<script src="catalog/view/javascript/bossthemes/cs.bossthemes.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bossthemes/common.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bossthemes/jquery.jgrowl.js" type="text/javascript"></script>
<script src="catalog/view/javascript/bossthemes/jquery.appear.js" type="text/javascript"></script>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<?php 
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$server = explode(" ", $user_agent);
//echo'<pre>';print_r($user_agent);die();echo'<pre>';
if($server[1] != '(Macintosh;') { ?>
<script src="catalog/view/javascript/bossthemes/jquery.smoothscroll.js" type="text/javascript"></script>
<?php } ?>

<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php if(isset($analytics) && !empty($analytics)) { ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } } ?>
<?php if(isset($this->request->get['route'])){$route1 = $this->request->get['route'];}else{$route1 ="";}
	if(isset($route1) && ($route1== "common/home" || $route1=="")){ ?>
		<script type="text/javascript"><!--
			window.onload = function() {
				$(".bt-loading").fadeOut("1500", function () {
					$('#bt_loading').css("display", "none");
				});
			};
		//--></script>
	<?php }else{ ?>
		<script type="text/javascript"><!--
		$(document).ready(function() {
		$('#bt_loading').css("display", "none");
		});
		//--></script>
	<?php } ?>
<style>
	#bt_loading{position:fixed; width:100%; height:100%; z-index:9999; background:#fff}
	.bt-loading{
		height: 128px;
		left: 50%;
		margin-left: -64px;
		margin-top: -64px;
		position: absolute;
		top:50%;
		width:128px;
		z-index: 9999;
	}
	.right-to-left .bt-loading{left:auto;right:50%; margin-left:0; margin-right: -64px;}
</style>
<?php 	
	if (isset($option['sticky_menu']) && $option['sticky_menu']) { ?>
	
	<script type="text/javascript"><!--
	$(window).scroll(function() {
			var height_header = $('#top').height() + $('header').height() + $('.boss_header').height()+10;			
			//var height_header_cate = $('#top').height() + $('header').height() + $('.boss_header').height() + $('#boss-menu-category .box-content').height();
			if($(window).scrollTop() > height_header) {
				$('.menu').addClass('boss_scroll');
				$('.boss_header').addClass('boss_scroll');
				$('.header_category').addClass('boss_scroll');
			} else {
				$('.boss_header').removeClass('boss_scroll');
				$('.menu').removeClass('boss_scroll');
				$('.header_category').removeClass('boss_scroll');
			}
			
			/*if($(window).scrollTop() > height_header_cate) {
				$('.header_category').addClass('boss_scroll');
			} else {
				$('.header_category').removeClass('boss_scroll');
			}*/
		});
	//--></script>
	<!--[if IE 8]> 
	<script type="text/javascript">
	$(window).scroll(function() {
			var height_header = $('#bt_header').height();  			
			if($('html').scrollTop() > height_header) {				
				$('header').addClass('boss_scroll');
			} else {
				$('header').removeClass('boss_scroll');
			}
		});
	</script>
	<![endif]-->
<?php } ?>
<?php if($status){
	include "catalog/view/theme/".$config->get('config_theme')."/template/bossthemes/boss_color_font_setting.php";
} ?>

<?php 
	if ($class == 'common-home') {
		$homepage = 'bt-home-page';
	}else {
		$homepage = 'bt-other-page';
	}
?>



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
</script>
<!-- Insert Your Facebook Pixel ID below. --> 
<noscript>

	<img height="1" width="1" src="https://www.facebook.com/tr?id=1205313566253712&ev=PageView&noscript=1"/>

</noscript>

<!-- End Facebook Pixel Code -->
</head>
<body class="<?php echo $homepage; ?> <?php echo $dir; ?> <?php echo($lang=='de'?'another-language':'');?>">
<?php if (isset($option['loading']) && $option['loading']) { ?>
<div id="bt_loading"><div class="bt-loading">
	<div id="circularG">
		<div id="circularG_1" class="circularG">
		</div>
		<div id="circularG_2" class="circularG">
		</div>
		<div id="circularG_3" class="circularG">
		</div>
		<div id="circularG_4" class="circularG">
		</div>
		<div id="circularG_5" class="circularG">
		</div>
		<div id="circularG_6" class="circularG">
		</div>
		<div id="circularG_7" class="circularG">
		</div>
		<div id="circularG_8" class="circularG">
		</div>
	</div>
	<?php }?>
</div></div>

<div id="bt_container" class="<?php echo $mode_css; ?>" <?php echo $bt_style; ?>>
<div id="bt_header" class="<?php echo $h_mode_css; ?>" <?php echo $h_style; ?>>
<nav id="top">
  <div class="container">
	<div class="row">
	<div id="left_top_links" class="nav pull-left">
	  <?php if(isset($header_link['phone']) && $header_link['phone']){ ?>
		<a href="<?php echo $contact; ?>"><i class="fa fa-phone"></i> <span>HOTLINE: <?php echo $telephone; ?></span></a>
	  <?php } ?>
	</div>
    <div id="right_top_links" class="nav pull-right">
	  <?php if(isset($header_link['language']) && $header_link['language']){echo $language;}?> 
	  <?php if(isset($header_link['currency']) && $header_link['currency']){echo $currency;}?>
      <ul class="list-inline">
		<?php if(isset($header_link['wishlist']) && $header_link['wishlist']){ ?>
        <li><a href="<?php echo $wishlist; ?>" id="wishlist-total" title="<?php echo $text_wishlist; ?>"><span><i class="fa fa-heart"></i> <?php echo $text_wishlist; ?></span></a></li>
		<?php } ?>
		
		<?php if(isset($header_link['my_account']) && $header_link['my_account']){ ?>
        <li class="dropdown"><a href="<?php echo $account; ?>" title="<?php echo $text_account; ?>" class="dropdown-toggle" data-toggle="dropdown"><span><i class="fa fa-user"></i><?php echo $text_account; ?></span><i class="fa fa-angle-down"></i></a>
          <ul class="dropdown-menu dropdown-menu-right">
            <?php if ($logged) { ?>
            <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
            <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
            <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
            <li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
            <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
            <?php } else { ?>
            <li><a href="<?php echo $register; ?>"><span><?php echo $text_register; ?></span><span><i class="fa fa-unlock-alt"></i></span></a></li>
            <li><a href="<?php echo $login; ?>"><span><?php echo $text_login; ?></span><span><i class="fa fa-user"></i></span></a></li>
            <?php } ?>
          </ul>
        </li>
		<?php } ?>
		
		<?php if(isset($header_link['shopping_cart']) && $header_link['shopping_cart']){ ?>
        <li><a href="<?php echo $shopping_cart; ?>" title="<?php echo $text_shopping_cart; ?>"><span><?php echo $text_shopping_cart; ?></span></a></li>
		<?php } ?>
		
		<?php if(isset($header_link['checkout']) && $header_link['checkout']){ ?>
        <li><a href="<?php echo $checkout; ?>" title="<?php echo $text_checkout; ?>"><span><?php echo $text_checkout; ?></span></a></li>
		<?php } ?>
      </ul>
	  
    </div>
	</div>
  </div>
</nav>
<div class="container">
	<div class="row">
		<div class="bt-content-menu" style="float: left; width: 100%; clear: both; height: 1px;"></div>
	</div>
</div>
<a class="open-bt-mobile"><i class="fa fa-bars"></i></a>
  <div class="bt-mobile">
		<div class="menu_mobile">	
			<a class="close-panel"><i class="fa fa-times-circle"></i></a>
			<?php if(isset($header_link['language']) && $header_link['language']){echo $language;}?> 
			<?php if(isset($header_link['currency']) && $header_link['currency']){echo $currency;}?>
			<div class="logged-link">
				<?php if ($logged) { ?>
					<a href="<?php echo $logout; ?>"><i class="fa fa-user"></i><span>Sign Out</span></a>
				<?php }else{?>
					<a href="<?php echo $login; ?>"><i class="fa fa-sign-in"></i><span>Sign In</span></a>
					<a href="<?php echo $register; ?>"><i class="fa fa-hand-o-up"></i><span>Join for Free</span></a>
				<?php } ?>
			</div>
			<?php if(isset($option['use_menu']) && $option['use_menu'] == 'megamenu'){
				echo isset($btmainmenu)?$btmainmenu:''; 
			}else{ ?>
			<?php if ($categories) { ?>	
			  <nav id="menu1" class="navbar">
				<div class="navbar-header">
				  <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
				  <span id="category" class="visible-xs"><?php echo $text_category; ?></span>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
				  <ul class="nav navbar-nav">
					<?php foreach ($categories as $category) { ?>
					<?php if ($category['children']) { ?>
					<li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
					  <div class="dropdown-menu">
						<div class="dropdown-inner">
						  <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
						  <ul class="list-unstyled">
							<?php foreach ($children as $child) { ?>
							<li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
							<?php } ?>
						  </ul>
						  <?php } ?>
						</div>
						<a href="<?php echo $category['href']; ?>" class="see-all"><?php echo $text_all; ?> <?php echo $category['name']; ?></a> </div>
					</li>
					<?php } else { ?>
					<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
					<?php } ?>
					<?php } ?>
				  </ul>
				</div>
			  </nav>
	
			<?php } } ?>
		</div>
  </div>
<header>
  <div class="container">
    <div class="row">
        <div id="logo">
		  <?php if(isset($header_link['logo']) && $header_link['logo']){ ?>
			<?php if ($logo) { ?>
			<a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
			<?php } else { ?>
			<h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
			<?php } ?>
          <?php } ?>
        </div>
	   <?php if(isset($header_link['cart_mini']) && $header_link['cart_mini']){echo $cart;}?>
	   <?php if(isset($header_link['search']) && $header_link['search']){ echo $boss_search; }?>
	   
    </div>
  </div>
</header>
<div class="boss-new-position">
	<div class="boss_header">
		<div class="container">
		<div class="row">
			<div class="menu">				
				<?php if(isset($option['use_menu']) && $option['use_menu'] == 'megamenu'){ ?>
					<!-- Load menu -->
					<?php echo isset($btmainmenu)?$btmainmenu:''; ?>
				  <?php }else{?>
					<?php if ($categories) { ?>	
					  <nav id="menu" class="navbar">
						<div class="navbar-header">
						  <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
						  <span id="category" class="visible-xs"><?php echo $text_category; ?></span>
						</div>
						<div class="collapse navbar-collapse navbar-ex1-collapse">
						  <ul class="nav navbar-nav">
							<?php foreach ($categories as $category) { ?>
							<?php if ($category['children']) { ?>
							<li class="dropdown"><a href="<?php echo $category['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $category['name']; ?></a>
							  <div class="dropdown-menu">
								<div class="dropdown-inner">
								  <?php foreach (array_chunk($category['children'], ceil(count($category['children']) / $category['column'])) as $children) { ?>
								  <ul class="list-unstyled">
									<?php foreach ($children as $child) { ?>
									<li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
									<?php } ?>
								  </ul>
								  <?php } ?>
								</div>
								<a href="<?php echo $category['href']; ?>" class="see-all"><?php echo $text_all; ?> <?php echo $category['name']; ?></a> </div>
							</li>
							<?php } else { ?>
							<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
							<?php } ?>
							<?php } ?>
						  </ul>
						</div>
					  </nav>
				<?php } } ?>
			</div>
		</div>
	</div>
	</div>
	<?php echo isset($btslideshow)?$btslideshow:''; ?>
	<div class="container">
		<div class="menu_custom row">
			<?php echo isset($btheader)?$btheader:''; ?>
		</div>
	</div>
</div>
</div>
