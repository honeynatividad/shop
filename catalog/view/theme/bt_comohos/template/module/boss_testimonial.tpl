<?php global $config; ?>
<div class="boss-testimonial" id="boss_testimonial_min_height_<?php echo $module; ?>">
	<?php if(isset($testimonial_title) && $testimonial_title!=''){?>
		<div class="box-heading title"><h1><?php echo $testimonial_title; ?></h1></div>
	<?php } ?>
	<div class="box-content">
	  <div class="testimonial-content" id="testimonial-content<?php echo $module; ?>">
		<div id="boss_testimonial_<?php echo $module; ?>">		
		<?php foreach ($testimonials as $key => $testimonial) { ?>
			<div class="testimonial-item">
			<?php if(isset($show_image) && $show_image){ ?>
			<div class="testimonial-image">
				<img alt="author" src="image/catalog/<?php echo $config->get('config_theme'); ?>/author_<?php echo ($key%2)+1; ?>.jpg"/>
			</div>
			<?php } ?>
			<?php if(isset($show_date) && $show_date){ ?>
			<div class="testimonial-date">				
				<span class="time-stamp">
					<?php $date = new DateTime($testimonial['date_added']);?>
					<small><?php echo $date->format('M d, Y');?></small>
				</span>
			</div>
			<?php } ?>
			<?php if(isset($show_subject) && $show_subject){ ?>
			<div class="testimonial-subject">
				<?php echo $testimonial['title']; ?>
			</div>
			<?php } ?>
			<?php if(isset($show_message) && $show_message){ ?>
			<div class="testimonial-message">
				<p><?php echo $testimonial['description']; ?></p>
			</div>
			<?php } ?>
			<?php if(isset($show_name) && $show_name){ ?>
			<div class="testimonial-name">
				<?php echo $testimonial['name']; ?>
			</div>
			<?php } ?>
			<?php if(isset($show_city) && $show_city){ ?>
			<div class="testimonial-city">
				<?php echo $testimonial['city']; ?>
			</div>
			<?php } ?>
			<?php if(isset($show_rating) && $show_rating){ ?>
			<div class="rating">				
				<?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($testimonial['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
			</div>
			<?php } ?>	
			</div>
		<?php } ?>
		
		</div>
		<?php if(isset($show_all_link) && $show_all_link){ ?>
			<div class="testimonial-show-all-url">
				<a href="<?php echo $showall_url;?>" title="<?php echo $show_all; ?>"><?php echo $show_all; ?></a>
			</div>
		<?php } ?>
		<?php if(isset($show_write) && $show_write){ ?>
			<div class="testimonial-show-write">
				<a href="<?php echo $isitesti; ?>" title="<?php echo $isi_testimonial; ?>"><?php echo $isi_testimonial; ?></a>
			</div>
		<?php } ?>
	  </div>
		<a id="prev_testimonial_<?php echo $module; ?>" class="btn-nav-center prev nav_thumb" href="javascript:void(0)" title="prev"><i class="fa fa-angle-left"></i></a>
		<a id="next_testimonial_<?php echo $module; ?>" class="btn-nav-center next nav_thumb" href="javascript:void(0)" title="next"><i class="fa fa-angle-right"></i></a>
	</div>
</div>

<script type="text/javascript"><!--
$(window).load(function(){
	$('#boss_testimonial_<?php echo $module; ?>').carouFredSel({
        auto : {
			<?php if($auto_scroll){ ?> play: true, <?php }else{?> play: false, <?php } ?>
			timeoutDuration: 4500,
		},
        responsive: true,
        width: '100%',
		height: 'variable',
        prev: '#prev_testimonial_<?php echo $module; ?>',
        next: '#next_testimonial_<?php echo $module; ?>',
		
        swipe: {
			onTouch : false
        },
        items: {
            /*width: image_width,*/
            height: 'variable',
            visible: {
				min: 1,
				max: 1
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000   //  The duration of the transition.
        },
		onCreate: function () {
			$(window).smartresize(function(){
				$('#boss_testimonial_<?php echo $module; ?> div.testimonial-item').css("height",getMaxHeight('#boss_testimonial_<?php echo $module; ?> div.testimonial-item'));
				$('#boss_testimonial_min_height_<?php echo $module; ?> div.caroufredsel_wrapper').css("width",'100%');
				$('#boss_testimonial_min_height_<?php echo $module; ?> div.caroufredsel_wrapper #boss_testimonial_<?php echo $module; ?>').css("width",'100%');
			});
		}
		
    });
	
	$('#boss_testimonial_<?php echo $module; ?> div.testimonial-item').css("height",getMaxHeight('#boss_testimonial_<?php echo $module; ?> div.testimonial-item'));	
	$('#boss_testimonial_min_height_<?php echo $module; ?> div.caroufredsel_wrapper').css("min-height",getMaxHeight('#boss_testimonial_<?php echo $module; ?> div.testimonial-item'));	
});
function getMaxHeight($elms) {
	var maxHeight = 0;
	$($elms).each(function () { 
		var height = $(this).outerHeight();	
		if (height > maxHeight) {
			maxHeight = height; 
		}
	});
	return maxHeight;
};
//--></script>

