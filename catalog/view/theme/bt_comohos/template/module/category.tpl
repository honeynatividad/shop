<div class="box bt-category not-animated" data-animate="fadeInLeft" data-delay="200">
<div class="box-heading"><h1><?php echo $heading_title; ?></h1></div>
<div class="box-content">
    <div class="box-category" id="boss-category">
	<ul class="box-category">
	<?php foreach ($categories as $category) { ?>
	<?php if ($category['category_id'] == $category_id) { ?>   
	<li class="<?php if ($category['children']) { echo "child"; }?> active">
		<a href="<?php echo $category['href']; ?>" class="list-group-item active"><span><i class="fa fa-angle-right"></i></span> <?php echo $category['name']; ?></a>
		<?php if ($category['children']) { ?>
			<ul class="item_child">
			  <?php foreach ($category['children'] as $child) { ?>
			  <?php if ($child['category_id'] == $child_id) { ?>
			  <li><a href="<?php echo $child['href']; ?>" class="list-group-item active"><?php echo $child['name']; ?></a></li>
			  <?php } else { ?>
			  <li><a href="<?php echo $child['href']; ?>" class="list-group-item"><?php echo $child['name']; ?></a></li>
			  <?php } ?>
			  <?php } ?>
			</ul>
		<?php } ?>
	</li>
	<?php } else { ?>
	<li <?php if ($category['children']) { echo "class='child'"; }?>>
		<a href="<?php echo $category['href']; ?>" class="list-group-item"><span><i class="fa fa-angle-right"></i></span> <?php echo $category['name']; ?></a>
		<?php if ($category['children']) { ?>
		<ul class="item_child">
		  <?php foreach ($category['children'] as $child) { ?>
		  <?php if ($child['category_id'] == $child_id) { ?>
		  <li><a href="<?php echo $child['href']; ?>" class="list-group-item active"><?php echo $child['name']; ?></a></li>
		  <?php } else { ?>
		  <li><a href="<?php echo $child['href']; ?>" class="list-group-item"><?php echo $child['name']; ?></a></li>
		  <?php } ?>
		  <?php } ?>
		</ul>
		<?php } ?>
	</li>
	<?php } ?>
	<?php } ?>
	</ul>
	</div>
</div>
</div>
