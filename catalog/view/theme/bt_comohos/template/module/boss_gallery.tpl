<?php if(!empty($gallery_images)){ ?>
<div class="col-xs-12 col-sm-12 col-md-12">
	<div class="boss_gallery">
		<?php if(!empty($heading_title)){ ?>
		<div class="gallery-title"><h3><?php echo $heading_title; ?></h3></div>
		<?php } ?>
		<div id="gallery" class="isotope variable-sizes clearfix">
			<?php foreach ($gallery_images as $gallery_image) { ?>
				<div class="item <?php echo $gallery_image['class']; ?>">
				<a title="<?php echo $gallery_image['gallery_image_description']; ?>" href="<?php echo $gallery_image['link']; ?>" class="swipebox">
					<img src="<?php echo $gallery_image['image']; ?>" alt="<?php echo $gallery_image['gallery_image_description']; ?>">
				</a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
<?php } ?>