<div class="bt-tagcloud box">
    <div class="box-heading block-title">
	   <h1><?php echo $heading_title; ?></h1>
    </div>
		
    <div class="box-content" style="text-align:left;"> 
		<?php if($blogtagcloud) { ?>
			<?php echo $blogtagcloud; ?>
		<?php } else { ?>
			<?php echo $text_notags; ?>
		<?php } ?>
    </div>
</div>