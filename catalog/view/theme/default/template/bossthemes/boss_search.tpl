<div id="boss-search" class="fourteen columns omega">
<div class="choose-select">
	<div class="input_cat">
    <select name="filter_category_id" id="boss_filter_search">
        <?php if (0 == $filter_category_id) { ?>
			<option value="0" selected="selected"><?php echo $text_category; ?></option>
		<?php } else { ?>
			<option value="0"><?php echo $text_category; ?></option>
		<?php } ?>
        <?php foreach ($categories as $category_1) { ?>
			<?php if ($category_1['category_id'] == $filter_category_id) { ?>
			<option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
			<?php } ?>
			<?php foreach ($category_1['children'] as $category_2) { ?>
				<?php if ($category_2['category_id'] == $filter_category_id) { ?>
				<option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
				<?php } ?>
				<?php foreach ($category_2['children'] as $category_3) { ?>
					<?php if ($category_3['category_id'] == $filter_category_id) { ?>
					<option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
					<?php } ?>
				<?php } ?>
			<?php } ?>
        <?php } ?>
	</select>
	</div>
	<div class="search-form">
	<div id="search" class="input-group">
	  <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $entry_search; ?>" class="form-control input-lg" />
	  <span class="input-group-btn">
		<button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
	  </span>
	</div>
	</div>
</div>
<script type="text/javascript">
$(function () {
	$("#boss_filter_search").selectbox();
});
</script>
</div>