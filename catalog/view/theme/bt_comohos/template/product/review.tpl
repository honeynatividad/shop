<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<div class="box-review">
	<p><?php echo $review['text']; ?></p>
	<p class="author">by <span><?php echo $review['author']; ?></span> <?php echo $review['date_added']; ?></p>
</div>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
