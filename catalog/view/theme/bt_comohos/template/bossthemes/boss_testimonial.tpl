<?php echo $header; ?>

<div class="bt-breadcrumb">
<div class="container">
  <ul class="breadcrumb">
  <h2><?php echo $heading_title; ?></h2>
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
</div>
<div class="container">
  <div class="row"><?php echo $column_left; ?><?php echo $column_right; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
    <?php if (true/*$testimonials*/) { ?>    
		<?php foreach ($testimonials as $testimonial) { ?>
		<div class="list-testimonials">
			<div class="image">
				<img src="image/catalog/bt_claudine/user.png"/>
			</div>
			<div class="title"><?php echo $testimonial['title']; ?></div>
			<div class="average">
                <?php // echo $text_average; ?>
				<div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
				  <?php if ($testimonial['rating'] < $i) { ?>
				  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
				  <?php } else { ?>
				  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
				  <?php } ?>
                  <?php } ?>
				</div>  
				-&nbsp;<i><?php echo $testimonial['name'].' '.$testimonial['city'].' '.$testimonial['date_added']; ?></i>
             </div>
			<div class="description">
                <?php echo $testimonial['description']; ?>
            </div>
		</div>
		<?php } ?>
    	<?php if ( isset($pagination)) { ?>
			<div class="bt_pagination">
				<?php if(!empty($pagination)){?><div class="links"><?php echo $pagination; ?></div> <?php } ?>
				<div class="results"><?php echo $results; ?></div>
			</div>    		
    		<div class="buttons" align="right"><a class="btn" href="<?php echo $write_url;?>" title="<?php echo $write;?>"><span><?php echo $write;?></span></a></div>
    	<?php }?>

    	<?php if (isset($showall_url)) { ?>
    		<div class="buttons" align="right"><a class="btn" href="<?php echo $write_url;?>" title="<?php echo $write;?>"><span><?php echo $write;?></span></a> &nbsp;<a class="btn" href="<?php echo $showall_url;?>" title="<?php echo $showall;?>"><span><?php echo $showall;?></span></a></div>
    	<?php }?>
    <?php } ?>    
      <?php echo $content_bottom; ?></div>
    </div>	
</div>

<?php echo $footer; ?>





