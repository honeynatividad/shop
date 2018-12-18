<div class="box bt-recent-comments">
    <div class="box-heading block-title">
        <h1><?php echo $heading_title; ?></h1>
    </div>
    <div class="box-content">
        <?php if($articles){?>
        <ol>
            <?php foreach ($articles as $article) { ?>
            <li class="item recent-comment-item">
                <div class="">
				  <a class="article-title" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
				</div>
				
				<small class="time-stamp">
						<?php $date = new DateTime($article['date_added']);?>
						<?php echo $date->format('l, M j, Y');?>
				</small>
				
				<div class="item-content">
                    <?php echo $article['comment']; ?>
                </div>  
				
				<span class="comment-by"><?php echo $article['author']; ?></span>
              
            </li>
            <?php } ?>
        </ol>
        <?php } else {?>
        <?php echo 'There are no comments.'; ?>
        <?php } ?>
    </div>

</div>
