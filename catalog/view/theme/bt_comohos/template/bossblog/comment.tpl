<div id="comments-header">
    <h1><?php echo $view_comment.' ('.$comment_total.')';?></h1>
</div>
<?php if ($comments) { ?>
<div id="allcomments">
    <?php foreach($comments as $comment){?>
        <div class="comment-item">
            <div class="comment-item-header">
                <span class="comment-by"><?php echo $text_comment_by;?>&nbsp;<span><?php echo $comment['author'];?></span></span>
				<small class="time-stamp">
					<?php $date = new DateTime($comment['date_added']);?>
					<?php echo $date-> format('l, M j Y, h:iA');?>
                </small>
			</div>	
			<div class="comment-body">
				<?php echo $comment['text'];?>
			</div>
        </div>
    <?php } ?>
</div>
<?php } else { ?>
<div class="allcomments"><?php echo $text_no_comments; ?></div>
<?php } ?>
<script type="text/javascript"><!--
$('#article-comments .pagination a').on('click', function() {
	$('#article-comments').fadeOut('slow');
		
	$('#article-comments').load(this.href);
	
	$('#article-comments').fadeIn('slow');
	
	return false;
});	
</script> 