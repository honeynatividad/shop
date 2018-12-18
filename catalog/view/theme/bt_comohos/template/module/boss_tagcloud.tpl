<div class="bt-tagcloud box not-animated" data-animate="fadeInLeft" data-delay="200">
    <div class="box-heading">
	   <h1><?php echo $heading_title; ?></h1>
    </div>
		
    <div class="box-content" style="text-align:left;"> 
		<?php if($boss_tagcloud) { ?>
		  <?php echo $boss_tagcloud; ?>
		<?php } else { ?>
		  <?php echo $text_notags; ?>
		<?php } ?>
    </div>
</div>
