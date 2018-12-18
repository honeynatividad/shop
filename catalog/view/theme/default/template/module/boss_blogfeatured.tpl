<div class="boss-blog-featured">
  <div class="container">
   <div class="row">
	 <div class="box-heading"><h1><?php echo $heading_title; ?></h1></div>
		<div class="box-content">
			<div class="box-article">
				<?php if($use_slider){ ?>
				<ul id="slider-article<?php echo $module; ?>">
					<?php foreach ($articles as $article) { ?>
					<li><div class="article_content"><div class="row">
						<?php if ($article['thumb']) { ?>
						<div class="col-sm-5 col-xs-12">
						<div class="image">
							<a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" /></a>
							<?php $date = new DateTime($article['date_added']);?>
							<div class="time-stamp">
							<small class="time-date">
							
							<?php echo $date->format('j');?></small> 
							<small class="time-month">
							
							<?php echo $date->format('M');?></small> 
							</div>
						
						</div>
						</div>
						<?php } ?>
						
						<div class="col-sm-7 col-xs-12">
							<div class="article-detail">
								<div class="article-name"><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></div>
								<div class="description"><p><?php echo $article['content']; ?></p></div>
								<a href="<?php echo $article['href']; ?>">Read more <i class="fa fa-caret-right"></i></a>
							</div>
						</div>
					</div></div></li>
					<?php } ?>
				</ul>
				<a id="article_next<?php echo $module; ?>" class="prev nav_thumb" href="javascript:void(0)" title="prev">Prev</a>
				<a id="article_prev<?php echo $module; ?>" class="next nav_thumb" href="javascript:void(0)" title="next">Next</a>
				<?php }else{ ?>
				  <?php $class = 'even'; ?>
					<?php foreach ($articles as $article) { ?>
					<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					<div class="article-items <?php echo $class; ?> col-sm-6 col-xs-12">
					<div class="article_content">
						<?php if ($article['thumb']) { ?>
						<div class="image">
							<a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" /></a>
						</div>
						<?php } ?>
						<div class="article-detail">
							<div class="article-name">
							  <a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
							</div>
							<div class="more-info">
								<small class="time-stamp">
								  <?php $date = new DateTime($article['date_added']);?>
								  <?php echo $date->format('M j, Y');?>
								  <span class="comment-count">|</span>
								  <a href="<?php echo $article['href']; ?>"><?php echo $article['comment']; ?> Comments</a>
								</small>
							</div>
							<div class="description">
							  <p><?php echo $article['content']; ?></p>
							</div>
							<a href="<?php echo $article['href']; ?>">Read more <i class="fa fa-caret-right"></i></a>
						</div>
					</div>
					</div>
					<?php } ?>
				<?php } ?>
			</div>
			<!--<div class="box-viewmore">
				<a href="index.php?route=bossblog/bossblog"><?php //echo $text_read_more; ?></a>
			</div>-->
		</div>
	</div>
  </div>
</div>
<?php if($use_slider){ ?>
<script type="text/javascript"><!--
$(window).load(function(){
    $('#slider-article<?php echo $module; ?>').carouFredSel({
        auto: false,
        responsive: true,
        width: '100%',
        prev: '#article_next<?php echo $module; ?>',
        next: '#article_prev<?php echo $module; ?>',
        swipe: {
        onTouch : true
        },
        items: {
            width: 500,
            height: 'auto',
            visible: {
            min: 1,
            max: 2
            }
        },
        scroll: {
            direction : 'left',    //  The direction of the transition.
            duration  : 1000   //  The duration of the transition.
        }
    });
});
//--></script>
<?php } ?>