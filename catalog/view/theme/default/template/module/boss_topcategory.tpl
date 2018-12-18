<?php if(!empty($categories)){ ?>
<div class="col-xs-12">
  <div class="popular-cate">
	<div class="box-heading">
		<h1><?php echo $heading_title; ?></h1>
	</div>
	<div class="row">
	  <?php if(!$show_slider) { ?>
		<?php foreach ($categories as $category) { ?>
		<div class="box-content col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="cate-image"><a title="<?php echo $category['title']; ?>" href="<?php echo $category['href']; ?>"><img alt="<?php echo $category['title']; ?>" src="<?php echo $category['image']; ?>" /></a></div>
			<div class="cate-name"><h3><?php echo $category['title']; ?></h3></div>
			<div class="sub_cat">
				<?php foreach ($category['children_data'] as $children) { ?>
					<div class="sub_item">
						<a title="<?php echo $children['name']; ?>" href="<?php echo $children['href']; ?>"><?php echo $children['name']; ?></a>
					</div>
				<?php } ?>
			</div>
		</div>
		<?php } ?>
	  <?php }else { ?>
		<section class="box-content">
		  <div id="boss_categories<?php echo $module; ?>" class="carousel-content">
		  <?php foreach ($categories as $category) { ?>
			<div class="cate-item">
			  <div class="cate-image">
				<a title="<?php echo $category['title']; ?>" href="<?php echo $category['href']; ?>"><img alt="<?php echo $category['title']; ?>" src="<?php echo $category['image']; ?>" /><span><?php echo $category['title']; ?></span></a>
			  </div>
			  <div class="cate-detail">
				<ul>
				<?php $children_data = $category['children_data']; ?>
			  	  <?php foreach ($children_data as $cate_chil) { ?>
					<li><a title="<?php echo $cate_chil['name']; ?>" href="<?php echo $cate_chil['href']; ?>"><?php echo $cate_chil['name']; ?></a></li>
				  <?php } ?>
				</ul>
				<a title="View all" href="<?php echo $category['href']; ?>">View All</a>
			  </div>
			</div>
		  <?php } ?>
		  </div>
		  <a id="next_top_cate_<?php echo $module; ?>" class="prev nav_thumb" href="javascript:void(0)" title="prev"><i class="fa fa-angle-left"></i></a>
		  <a id="prev_top_cate_<?php echo $module; ?>" class="next nav_thumb" href="javascript:void(0)" title="next"><i class="fa fa-angle-right"></i></a>
		</section>
	  <?php } ?>
	</div>
  </div>
</div>
<?php if($show_slider){ ?>
<script type="text/javascript"><!--
$(window).load(function(){
	if ($(window).width() > 768) {
		var image_width = <?php echo $image_width; ?>;
	}else{
		var image_width = 300;
	}
	per_row = <?php echo $per_row; ?>;
	
	
    $('#boss_categories<?php echo $module; ?>').carouFredSel({
        auto: {
			play: true,
			timeoutDuration: 4000,
		},
        responsive: true,
        width: '100%',
		height: 'variable',
        prev: '#next_top_cate_<?php echo $module; ?>',
        next: '#prev_top_cate_<?php echo $module; ?>',
        swipe: {
        onTouch : true
        },
        items: {
            width: image_width,
            height: 'variable',
            visible: {
				min: 1,
				max: per_row,
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1500,   //  The duration of the transition.
        }
    });
});
//--></script>
<?php } ?>
<?php } ?>
