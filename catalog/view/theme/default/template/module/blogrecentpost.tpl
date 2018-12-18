<div class="box block boss-recent-post">
    <div class="box-heading">
        <span><?php echo $heading_title; ?></span>
    </div>
    <div class="box-content block-content">
        <?php if($articles){?>
        <ol>
            <?php foreach ($articles as $article) { ?>
            <li class="item-recent-post">
				<div class="image">
                  <a class="article-title" href="<?php echo $article['href']; ?>"><img src="<?php echo $article['image']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>"/></a>
                </div>
				<div class="title">
				  <a class="article-title" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
				  <small class="time-stamp">
                    <?php $date = new DateTime($article['date_added']);?>
                    <?php echo $date->format('M j, Y');?>
				  </small>
				</div>
            </li>
            <?php } ?>
        </ol>
        <?php } else {?>
        <?php echo 'There are no Articles.'; ?>
        <?php } ?>
    </div>

</div>
