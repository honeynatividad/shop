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
	<ul class="nav nav-tabs">
		<li><a href="<?php echo $boss_category; ?>"> <?php echo $text_boss_category; ?></a></li>
		<li class="active"><a href="<?php echo $boss_articles; ?>"> <?php echo $text_boss_articles; ?></a></li>
		<li><a href="<?php echo $boss_comments; ?>"> <?php echo $text_boss_comments; ?></a></li>							
		<li><a href="<?php echo $boss_settings; ?>"> <?php echo $text_boss_settings; ?></a></li>							
	</ul>	
	<div class="panel panel-default">
	<div class="panel-body">					
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_add_blog_article; ?></h3>
		</div>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-update-article" class="form-horizontal">		
		<ul class="nav nav-tabs" id="module">
			<li><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
			<li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
			<li><a href="#tab-meta" data-toggle="tab"><?php echo $tab_meta; ?></a></li>
			<li><a href="#tab-related" data-toggle="tab"><?php echo $tab_related; ?></a></li>
			<li><a href="#tab-related-product" data-toggle="tab"><?php echo $tab_related_product; ?></a></li>
			<li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
		</ul>
		<div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
				<div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="article_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="article_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_content; ?></label>
                    <div class="col-sm-10">
                      <textarea name="article_description[<?php echo $language['language_id']; ?>][content]" placeholder="<?php echo $entry_content; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['content'] : ''; ?></textarea>
                    </div>
                  </div>                  
                  
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_tag; ?></label>
                    <div class="col-sm-10">
						<input type="text" name="article_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['tag'] : ''; ?>" class="form-control" />                      
                    </div>
                  </div>                  
                </div>
                <?php } ?>
				<div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_author; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="author" value="<?php echo $author; ?>" class="form-control" />
                    <?php if ($error_author) { ?>
						<div class="text-danger"><?php echo $error_author; ?></div>
                    
                    <?php } ?></td>
                    </div>
                  </div>
				</div>
            </div>
			
			<div class="tab-pane" id="tab-data">									
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_category; ?></label>
					<div class="col-sm-10">
					<div class="well well-sm" style="height: 150px; overflow: auto;">
					  <?php $class = 'odd'; ?>
					  <?php foreach ($article_categories as $blog_category) { ?>
					  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
					  <div class="">
						<?php if (in_array($blog_category['blog_category_id'], $article_category)) { ?>
						<input type="checkbox" name="article_category[]" value="<?php echo $blog_category['blog_category_id']; ?>" checked="checked" />
						<?php echo $blog_category['name']; ?>
						<?php } else { ?>
						<input type="checkbox" name="article_category[]" value="<?php echo $blog_category['blog_category_id']; ?>" />
						<?php echo $blog_category['name']; ?>
						<?php } ?>
					</div>
					  <?php } ?>
					</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
					<div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
						<input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
					</div>				
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
					<div class="col-sm-10">
						<input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
					</div>
				</div>
				<div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $article_store)) { ?><input type="checkbox" name="article_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="article_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $article_store)) { ?>
                        <input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="article_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
				</div>
              </div>
			  
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
					<div class="col-sm-3">
						<div class="input-group date">
						<input type="text" name="date_modified" value="<?php echo $date_modified; ?>" placeholder="<?php echo $date_modified; ?>" data-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
						<span class="input-group-btn">
							<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
						</div>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-allow-comment"><?php echo $entry_allow_comment; ?></label>
					<div class="col-sm-10">
						<select name="allow_comment" class="form-control">
						  <?php if ($allow_comment==2) { ?>
						  <option value="2" selected="selected"><?php echo $text_inherited; ?></option>
						  <option value="1"><?php echo $text_enabled; ?></option>
						  <option value="0"><?php echo $text_disabled; ?></option>
						  <?php } else if ($allow_comment==1) { ?>
						  <option value="2" ><?php echo $text_inherited; ?></option>
						  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						  <option value="0" ><?php echo $text_disabled; ?></option>
						  <?php } else {?>
						  <option value="2" ><?php echo $text_inherited; ?></option>
						  <option value="1"><?php echo $text_enabled; ?></option>
						  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						  <?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-need-approval"><?php echo $entry_need_approval; ?></label>
					<div class="col-sm-10">
						<select name="need_approval" class="form-control">
						  <?php if ($need_approval==2) { ?>
						  <option value="2" selected="selected"><?php echo $text_inherited; ?></option>
						  <option value="1"><?php echo $text_enabled; ?></option>
						  <option value="0"><?php echo $text_disabled; ?></option>
						  <?php } else  if ($need_approval==1){ ?>
						  <option value="2" ><?php echo $text_inherited; ?></option>
						  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						  <option value="0" ><?php echo $text_disabled; ?></option>
						  <?php } else{?>
						  <option value="2" ><?php echo $text_inherited; ?></option>
						  <option value="1"><?php echo $text_enabled; ?></option>
						  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						  <?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
					<div class="col-sm-10">
						<select name="status" class="form-control">
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
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
					<div class="col-sm-10">
						<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $sort_order; ?>" class="form-control" id="input-date-modified" />
					</div>
				</div>				
            
			</div>
			
			<div class="tab-pane" id="tab-meta">
              <ul class="nav nav-tabs" id="language-meta">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language-meta<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
				<div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language-meta<?php echo $language['language_id']; ?>">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="article_description[<?php echo $language['language_id']; ?>][meta_description]" placeholder="<?php echo $entry_meta_description; ?>" rows="5" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                    <div class="col-sm-10">
                      <textarea name="article_description[<?php echo $language['language_id']; ?>][meta_keyword]" placeholder="<?php echo $entry_meta_keyword; ?>" rows="5" class="form-control"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>                      
             
					  
                </div>
                <?php } ?>
				</div>
			</div>
			<div class="tab-pane" id="tab-related">              
			  <div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $entry_related; ?></label>
				<div class="col-sm-10">
					<input type="text" name="related_article" value="" class="form-control" />
					<div id="article-related" class="well well-sm" style="height: 150px; overflow: auto;">					  
					  <?php foreach ($article_relateds as $article_related) { ?>
					  <div id="article-related<?php echo $article_related['blog_article_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $article_related['name']; ?>
                      <input type="hidden" name="article_related[]" value="<?php echo $article_related['blog_article_id']; ?>" />
                    </div>
					  <?php } ?>
					</div>
				</div>
			  </div> 
			</div>
			<div class="tab-pane" id="tab-related-product">              
			  <div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $entry_related_product; ?></label>
				<div class="col-sm-10">
					<input type="text" name="related_product" value="" class="form-control" />
					<div id="product-related" class="well well-sm" style="height: 150px; overflow: auto;">					  
					  <?php foreach ($product_relateds as $product_related) { ?>
					  <div id="product-related<?php echo $product_related['product_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $product_related['name']; ?>
                      <input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
                    </div>
                  <?php } ?>
                </div>
				</div>
			  </div> 
			</div>
			<div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="article_layout[0]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($article_layout[0]) && $article_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>					
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
						  <td class="text-left"><select name="article_layout[<?php echo $article_store['store_id']; ?>][layout_id]" class="form-control">
						<option value=""></option>
						
						
						<?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($article_layout[$store['store_id']]) && $article_layout[$store['store_id']] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
						
					  </select></td>
                    </tr>
                    <?php } ?>					 
                  </tbody>
                </table>
              </div>
            </div>						
		</div>
		</form>
	</div>		
	</div>
	</div>
</div>
		  

<script type="text/javascript"><!--

$('input[name=\'related_article\']').autocomplete({
	'source': function(request, response) {
		$.ajax({						
			url: 'index.php?route=bossblog/articles/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['blog_article_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'related_article\']').val('');
		
		$('#article-related' + item['value']).remove();
		
		$('#article-related').append('<div id="article-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="article_related[]" value="' + item['value'] + '" /></div>');	
	}	
});

$('#article-related').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script> 

<script type="text/javascript"><!--
// Related Product
$('input[name=\'related_product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({			
			url: 'index.php?route=bossblog/articles/productauto&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'related_product\']').val('');
		
		$('#product-related' + item['value']).remove();
		
		$('#product-related').append('<div id="product-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product_related[]" value="' + item['value'] + '" /></div>');	
	}	
});

$('#product-related').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script> 


<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
$('.time').datetimepicker({
	pickDate: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});
//--></script> 

<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300});
<?php } ?>
//--></script> 
<script type="text/javascript"><!--
$('#module li:first-child a').tab('show');
$('#language a:first').tab('show');
$('#language-meta a:first').tab('show');
//--></script>
<?php echo $footer; ?>