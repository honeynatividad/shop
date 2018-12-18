<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-featured" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
		</div>
		<div class="panel-body">
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
					<div class="col-sm-10">
					  <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
					  <?php if ($error_name) { ?>
					  <div class="text-danger"><?php echo $error_name; ?></div>
					  <?php } ?>
					</div>
				</div> 				
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-article"><?php echo $text_get_article; ?></label>
					<div class="col-sm-10">
						<select name="filter_blog"  onchange="showCategoriesArticle(this)" class="form-control">
						  <?php if (isset($filter_blog) && $filter_blog == 'popular') { ?>
						  <option value="popular" selected="selected"><?php echo $text_popular_article; ?></option>
						  <?php } else { ?>
						  <option value="popular"><?php echo $text_popular_article; ?></option>
						  <?php } ?>				  
						  <?php if (isset($filter_blog) && $filter_blog == 'latest') { ?>
						  <option value="latest" selected="selected"><?php echo $text_latest_article; ?></option>
						  <?php } else { ?>
						  <option value="latest"><?php echo $text_latest_article; ?></option>
						  <?php } ?>						   
						 <?php if (isset($filter_blog) && $filter_blog == 'category') { ?>
						  <option value="category" selected="selected"><?php echo $text_category_article; ?></option>
						  <?php } else { ?>
						  <option value="category"><?php echo $text_category_article; ?></option>
						  <?php } ?>				  
						  <?php if (isset($filter_blog) && $filter_blog == 'article') { ?>
						  <option value="article" selected="selected"><?php echo $text_choose_article; ?></option>
						  <?php } else { ?>
						  <option value="article"><?php echo $text_choose_article; ?></option>
						  <?php } ?>
						</select>
						<?php if (isset($filter_blog) && $filter_blog == 'category') { ?>
						<?php if ($error_category) { ?>
						<div class="text-danger"><?php echo $error_category; ?></div>
						<?php } ?>
						<div class="well well-sm" style="height: 150px; overflow: auto;" id="scrollbox">
							<?php if(isset($categories)){ ?>
							<?php foreach ($categories as $category) { ?>
							<div class="">
							  <?php if (isset($filter_type_category) && $category['blog_category_id'] == $filter_type_category) { ?>
							  <input type="radio" name="filter_type_category" value="<?php echo $category['blog_category_id']; ?>" checked="checked" />
							  <?php echo $category['name']; ?>
							  <?php } else { ?>
							  <input type="radio" name="filter_type_category" value="<?php echo $category['blog_category_id']; ?>" />
							  <?php echo $category['name']; ?>
							  <?php } ?>
							</div>
							<?php } ?>
							<?php } ?>
						  </div>
						<?php } ?>
						<?php if(isset($filter_blog) && $filter_blog =="article"){  ?>
						<div class="well well-sm" style="height: 220px; overflow: auto;" id="scrollbox_product">
						<input type="text" name="article" value="" placeholder="<?php echo $entry_article; ?>" id="input-article" class="form-control" />
						  <div id="featured-article" class="well well-sm" style="height: 150px; overflow: auto;">
							<?php if(isset($articles) && !empty($articles)){ ?>
							<?php foreach ($articles as $article) { ?>
							<div id="featured-article<?php echo $article['articles_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $article['name']; ?>
							  <input type="hidden" name="article[]" value="<?php echo $article['articles_id']; ?>" />
							</div>
							<?php } ?>
							<?php } ?>
						  </div>
						</div>
					<?php } ?>
					</div>
				</div>				
				
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $entry_title; ?></label>
					<div class="col-sm-10">
						<?php foreach ($languages as $language) { ?>
							<div class="form-group">
								<div class="col-sm-11">
									<input name="title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($title[$language['language_id']]) ? $title[$language['language_id']] : ''; ?>" class="form-control" />
								</div>
								<div class="col-sm-1">
									<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
		
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-useslider"><?php echo $entry_use_slider; ?></label>
					<div class="col-sm-10">
					  <select name="useslider" id="input-useslider" class="form-control">
						<?php if (isset($useslider) && $useslider) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
					<div class="col-sm-10">
					  <input type="text" name="limit" value="<?php echo isset($limit)?$limit:4; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
					  <?php if ($error_limit) { ?>
					  <div class="text-danger"><?php echo $error_limit; ?></div>
					  <?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit_article; ?></label>
					<div class="col-sm-10">
					  <input type="text" name="limit_article" value="<?php echo isset($limit_article)?$limit_article:30; ?>" placeholder="<?php echo $entry_limit_article; ?>" id="input-limit" class="form-control" />
					  <?php if ($error_limit_article) { ?>
					  <div class="text-danger"><?php echo $error_limit_article; ?></div>
					  <?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit_des; ?></label>
					<div class="col-sm-10">
					  <input type="text" name="limit_des" value="<?php echo isset($limit_des)?$limit_des:50; ?>" placeholder="<?php echo $entry_limit_des; ?>" id="input-limit" class="form-control" />
					  <?php if ($error_limit_des) { ?>
					  <div class="text-danger"><?php echo $error_limit_des; ?></div>
					  <?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
					<div class="col-sm-10">
					  <input type="text" name="image_width" value="<?php echo $image_width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
					  <?php if ($error_width) { ?>
					  <div class="text-danger"><?php echo $error_width; ?></div>
					  <?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
					<div class="col-sm-10">
					  <input type="text" name="image_height" value="<?php echo $image_height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
					  <?php if ($error_height) { ?>
					  <div class="text-danger"><?php echo $error_height; ?></div>
					  <?php } ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
					<div class="col-sm-10">
					  <select name="status" id="input-status" class="form-control">
						<?php if ($status) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select>
					</div>
				</div>
				
			</form>
		</div>
	</div>
  </div>
</div>
<script type="text/javascript"><!--
function autoslectfeatured(){
$('input[name=\'article\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=module/boss_blogfeatured/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['article_id']
					}
				}));
			}
		});
	},
	select: function(item) {
		$('input[name=\'article\']').val('');
		
		$('#featured-article' + item['value']).remove();
		
		$('#featured-article').append('<div id="featured-article' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article[]" value="' + item['value'] + '" /></div>');	
	}
});
	
$('#featured-article').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
}

function showCategoriesArticle(select) {
  if (select.options[select.selectedIndex].value == 'category') {
	$('#scrollbox_product').slideUp("normal", function() { $(this).remove(); } );
	html  = '<div class="well well-sm" style="height: 150px; overflow: auto;" id="scrollbox">';
	<?php if(isset($categories)){ ?>
	<?php foreach ($categories as $category) { ?>
	  html += '<div class="">';
	  html += '<input type="radio" name="filter_type_category" value="<?php echo $category['blog_category_id']; ?>" />';
	  html += '<?php echo addslashes($category['name']); ?>'
	  html += '</div>';
	<?php } ?>
	<?php } ?>
	html += '</div>';		  
	$(select).after(html);
  } else if (select.options[select.selectedIndex].value == 'article') {
	$('#scrollbox').slideUp("normal", function() { $(this).remove(); } );		
	html = '<div class="well well-sm" style="height: 220px; overflow: auto;" id="scrollbox_product">';
	html += '<input type="text" name="article" value="" placeholder="<?php echo $entry_article; ?>" id="input-article" class="form-control" />';
	html += '<div id="featured-article" class="well well-sm" style="height: 150px; overflow: auto;">';	
	html += ' </div>';
	html += '</div>';		
	$(select).after(html);
	autoslectfeatured();
  }
  else {
	$('#scrollbox').slideUp("normal", function() { $(this).remove(); } );		
	$('#scrollbox_product').slideUp("normal", function() { $(this).remove(); } );		
  }
  
}
autoslectfeatured();
  //--></script>
<?php echo $footer; ?>