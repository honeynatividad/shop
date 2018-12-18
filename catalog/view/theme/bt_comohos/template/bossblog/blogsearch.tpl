<?php echo $header; ?>
<div class="container">
	<ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
<div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
	<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
	  <label class="control-label" for="input-search"><?php echo $entry_search; ?></label>
      <div class="boss-blog-search">
       
          <input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-search" class="form-control" />
		  <br />
       
        
          <select class="form-control selectpicker" name="filter_category_id">
			<option value="0"><?php echo $text_category; ?></option>
			<?php foreach ($categories as $category_1) { ?>
			<?php if ($category_1['blog_category_id'] == $filter_category_id) { ?>
			<option value="<?php echo $category_1['blog_category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $category_1['blog_category_id']; ?>"><?php echo $category_1['name']; ?></option>
			<?php } ?>
			<?php foreach ($category_1['children'] as $category_2) { ?>
			<?php if ($category_2['blog_category_id'] == $filter_category_id) { ?>
			<option value="<?php echo $category_2['blog_category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $category_2['blog_category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
			<?php } ?>
			<?php foreach ($category_2['children'] as $category_3) { ?>
			<?php if ($category_3['blog_category_id'] == $filter_category_id) { ?>
			<option value="<?php echo $category_3['blog_category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $category_3['blog_category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
			<?php } ?>
			<?php } ?>
			<?php } ?>
			<?php } ?>
		  </select>
		<div style="margin-bottom:10px;">&nbsp;</div>
        
          <label class="checkbox-inline">
            <?php if ($filter_sub_category) { ?>
            <input type="checkbox" name="filter_sub_category" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="filter_sub_category" value="1" />
            <?php } ?>
            <?php echo $text_sub_category; ?></label>
       
      </div>
      <p>
        <label class="checkbox-inline">
          <?php if ($filter_content) { ?>
          <input type="checkbox" name="filter_content" value="1" id="description" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="filter_content" value="1" id="description" />
          <?php } ?>
          <?php echo $entry_description; ?></label>
      </p>
	  <input style="margin-bottom:40px;" type="button" value="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary" />
		<br />
	  <?php if ($articles) { ?>
		<div class="article-filter">
		  <div class="display hidden-xs">
            <button type="button" id="list-view" class="btn-list" data-toggle="tooltip" title="<?php echo $text_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn-grid" data-toggle="tooltip" title="<?php echo $text_grid; ?>"><i class="fa fa-th-large"></i></button>
          </div>
		  <div class ="limit-sort hidden-xs">
			<div class="box_sort">
			  <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
			  <label>
			  <select id="input-sort" class="form-control" onchange="location = this.value;">
				<?php foreach ($sorts as $sorts) { ?>
				<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
				<option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
				<?php } ?>
				<?php } ?>
			  </select>
			  </label>
			</div>
		  
			<div class="box_limit">
			  <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
			  <label>
			  <select id="input-limit" class="form-control" onchange="location = this.value;">
				<?php foreach ($limits as $limits) { ?>
				<?php if ($limits['value'] == $limit) { ?>
				<option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
				<?php } else { ?>
				<option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
				<?php } ?>
				<?php } ?>
			  </select>
			  </label>
			</div>
		  </div>
	    </div>
	  
	  <div class="row">
        <?php foreach ($articles as $article) { ?>
         <div class="article-layout article-list col-xs-12">
          <div class="content-bg">
            <div class="article-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" alt="<?php echo $article['name']; ?>" title="<?php echo $article['name']; ?>" class="img-responsive" /></a></div>
           
				<div class="article_dt">
					<div class="article-name"><h2><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h2></div>
					<div class="time-stamp">
						<?php $date = new DateTime($article['date_modified']);?>
						<small><?php echo $date->format('l, M j, Y');?></small>
					</div>
					<div class="article-content"><?php echo $article['title']; ?></div>
					
					<a class ="btn-readmore" href="<?php echo $article['href']; ?>"><?php echo $text_readmore; ?></a>
				</div>
            </div>
          
        </div>
        <?php } ?>
      </div>
      <div class="result-pagination blog-pagination">
		  <div class="results pull-left"><?php echo $results; ?></div>
          <div class="links"><?php echo $pagination; ?></div>
	  </div>
      <?php }else{ ?>
	  <p><?php echo $text_empty; ?></p>
	  <?php } ?>
	<?php echo $content_bottom; ?></div>	
    <?php echo $column_right; ?>
</div>
</div>  
<script type="text/javascript"><!--

$('#content input[name=\'filter_name\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('#button-search').bind('click', function() { 
	url = 'index.php?route=bossblog/blogsearch';
	
	var filter_name = $('#content input[name=\'filter_name\']').val();
	
	if (filter_name) { 
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_category_id = $('#content select[name=\'filter_category_id\']').val();
	
	if (filter_category_id > 0) {
		url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
	}
	
	var filter_sub_category = $('#content input[name=\'filter_sub_category\']:checked').val();
	
	if (filter_sub_category) {
		url += '&filter_sub_category=true';
	}
		
	var filter_content = $('#content input[name=\'filter_content\']:checked').val();
	
	if (filter_content) {
		url += '&filter_content=true';
	}	
	location = url;
});
//--></script>    
<script type="text/javascript"><!--
$(document).ready(function() {
	// Article List
	$('#list-view').click(function() {
		$('#content .article-layout').attr('class', 'article-layout article-list col-xs-12');

		localStorage.setItem('display', 'list');
	});

	// Article Grid
	$('#grid-view').click(function() {
		// What a shame bootstrap does not take into account dynamically loaded columns
		cols = $('#column-right, #column-left').length;

		if (cols == 2) {
			$('#content .article-layout').attr('class', 'article-layout article-grid col-md-6 col-xs-12');
		} else if (cols == 1) {
			$('#content .article-layout').attr('class', 'article-layout article-grid col-md-4 col-sm-6 col-xs-12');
		} else {
			$('#content .article-layout').attr('class', 'article-layout article-grid col-md-3 col-sm-4 col-xs-12');
		}

		localStorage.setItem('display', 'grid');
	});
	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
	} else {
		$('#grid-view').trigger('click');
	}
});
//--></script>
    
<?php echo $footer; ?>