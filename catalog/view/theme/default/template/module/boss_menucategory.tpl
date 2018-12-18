<div class="header_category">
<div id="boss-menu-category" class="box">
  <div class="boss_heading"><div class="box-heading"><h1><?php echo $heading_title; ?></h1></div></div>
  <div class="box-content">
    <ul class="box-category boss-menu-cate">
	<?php if(isset($menus) && !empty($menus)){ ?>
      <?php $i=1; foreach($menus as $menu){ ?>
		<li <?php if($i>$alway_show) echo 'class="b_menucategory_hidde"';?>>
			<div class="nav_title">
				<?php if(isset($menu['icon'])&&$menu['icon']) { ?><img alt="<?php echo $menu['title']; ?>" src="<?php echo $menu['icon']; ?>" /><?php } ?>
				<a class="title" href="<?php echo $menu['href']; ?>"><?php echo $menu['title']; ?><?php if ($menu['categories']){ ?><span><i class="fa fa-angle-right"></i></span><?php } ?></a>
			</div><?php if ($menu['categories']){ ?>
			<div class="nav_submenu" style="<?php if($menu['bgimage']){ ?>background-image: url(<?php echo $menu['bgimage']; ?>); background-position: top right;background-repeat: no-repeat; <?php } ?> ">
			<div class="nav_submenu_inner" style="width:<?php echo $menu['sub_width']; ?>px;">	
				<a title="<?php echo $menu['title']; ?>" href="<?php echo $menu['href']; ?>"></a>
				<?php $sub_column = ($menu['sub_width'])/$menu['column']; ?>
				<div class="nav_sub_submenu">
					<ul>
						<?php foreach($menu['categories'] as $category){ ?>
						<li <?php if ($category['children']) echo 'class="nav_cat_parent"'; ?> <?php if (!$category['children']) echo 'class="nav_cat_child"'; ?> style="width:<?php echo $sub_column; ?>px;">
							<a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
							<?php if ($category['children']){ ?>
							<div class="sub_cat_child">
								<ul>
								<?php foreach($category['children'] as $cat_child){ ?>
									<li><a href="<?php echo $cat_child['href']; ?>"><?php echo $cat_child['name']; ?></a></li>
								<?php } ?>
								</ul>
							</div>
							<?php } ?>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>	
			</div><?php } ?>
		</li>
	  <?php $i++; } ?>
	  <?php } ?>
		<?php if(count($menus) > $alway_show){ ?>
		<li class="menu_loadmore">
		<div class="nav_title">			
			<a class="more title" href="javascript:void(0)"><?php echo $text_more_category;?><i class="fa fa-plus-square-o"></i></a>
		</div>
		</li>
		<li class="menu_loadmore_hidden">
		<div class="nav_title">			
			<a class="more title" href="javascript:void(0)"><?php echo $text_more_category_hidden;?><i class="fa fa-minus-square-o"></i></a>
		</div>
		</li> 
		<?php } ?>
    </ul>
  </div>
  <script type="text/javascript"><!--
	jQuery(document).ready(function($) {
		loadtopmenu();
	});
	$("#boss-menu-category .boss_heading").click(function(){
		$('#boss-menu-category').toggleClass('opencate');
		loadtopmenu();
	});
	function loadtopmenu(){
		var menuheight = $('#boss-menu-category .box-content').outerHeight();
		var topcate = $('#boss-menu-category').offset().top;
		$('#boss-menu-category .boss-menu-cate .nav_title').each(function(index, element) {
			var liheight = $(this).outerHeight();
			var subheight = $(this).next('.nav_submenu').outerHeight();
			var topheight = $(this).offset().top - topcate -55;
			/*if((subheight < menuheight)&&(subheight < topheight)){
				var bottomh = topheight - subheight + liheight + 14;
				$(this).next('.nav_submenu').css('top', bottomh + 'px');
			}else{
				$(this).next('.nav_submenu').css('top', '-1px');
			}*/
		});
	}
	$('#boss-menu-category .b_menucategory_hidde,#boss-menu-category  .menu_loadmore_hidden').hide();
	$('#boss-menu-category .menu_loadmore').click(function(){
		$('#boss-menu-category .b_menucategory_hidde' ).slideToggle( "normal", function() {
			$('#boss-menu-category .menu_loadmore').hide();
			$('#boss-menu-category .menu_loadmore_hidden').show();
		});
		
	});
	$('#boss-menu-category .menu_loadmore_hidden').click(function(){
		$('#boss-menu-category .b_menucategory_hidde' ).slideToggle( "normal", function() {
			$('#boss-menu-category .menu_loadmore').show();
			$('#boss-menu-category .menu_loadmore_hidden').hide();
		});
		
	});
	

  //--></script>
</div>
</div>
