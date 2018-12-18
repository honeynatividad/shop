<div class="box block boss_blog-cat">
  <div class="box-heading block-title">
    <div><h1><?php echo $heading_title; ?></h1></div>
  </div>
  <div class="box-content">
    <div class="box-category" id="boss-blog-category">
        <?php if($categories){?>
		<ul class="box-category">
			<?php foreach ($categories as $category) { ?>
			<?php $icon=0; ?>
			<li class="<?php if ($category['children']) {echo 'sub_child '; $icon=1; } 
					if ($category['blog_category_id'] == $blog_category_id){echo 'active'; if($icon==1){$icon=2;} }
					else { foreach ($category['children'] as $child) {
						if ($child['blog_category_id'] == $child_id) { echo 'active';if($icon==1){$icon=2;}  break;}}} ?>" >
			  
			  <?php if ($category['blog_category_id'] == $blog_category_id) { ?>
			  
			  <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?> <span><?php echo $category['total']; ?></span></a>
			  <?php } else { ?>
			  <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?> <span><?php echo $category['total']; ?></span></a>
			  <?php } ?>
			  <?php if ($category['children']) { ?>
			  <ul class="blog_child">
				<?php foreach ($category['children'] as $child) { ?>
				  <?php if ($child['blog_category_id'] == $child_id) { ?>
				  <li class="active"><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?> <span><?php echo $child['total']; ?></span></a></li>
				  <?php } else { ?>
				  <li><a href="<?php echo $child['href']; ?>"> <?php echo $child['name']; ?> <span><?php echo $child['total']; ?></span></a></li>
				  <?php } ?>
				<?php } ?>
			  </ul>
			  <?php } ?>
			</li>
			<?php } ?>
		</ul>
		<?php } else {?>
        <?php echo 'There are no Category.'; ?>
        <?php } ?>
    </div>
  </div>
</div>
<script type="text/javascript">
	$('document').ready(function(){			
		$('#boss-blog-category li.sub_child').prepend('');
		$('#boss-blog-category li.sub_child > p').click(function(){			
			if ($(this).text() == '+'){
				$(this).parent('li').children('ul.blog_child').slideDown(300);
				$(this).text('-');
			}else{
				$(this).parent('li').children('ul.blog_child').slideUp(300);
				$(this).text('+');
			}  
			
		});				
	});
</script>
