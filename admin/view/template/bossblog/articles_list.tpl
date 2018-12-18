<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
 <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a> <a href="<?php echo $repair; ?>" data-toggle="tooltip" title="<?php echo $button_rebuild; ?>" class="btn btn-default"><i class="fa fa-refresh"></i></a>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-blog-article').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
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
		<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
		  </div>
		  <div class="panel-body">							
			<ul class="nav nav-tabs" id="module">
				<li><a href="<?php echo $boss_category; ?>"> <?php echo $text_boss_category; ?></a></li>
				<li class="active"><a href="<?php echo $boss_articles; ?>"> <?php echo $text_boss_articles; ?></a></li>
				<li><a href="<?php echo $boss_comments; ?>"> <?php echo $text_boss_comments; ?></a></li>							
				<li><a href="<?php echo $boss_settings; ?>"> <?php echo $text_boss_settings; ?></a></li>							
			</ul>
			<div class="well">
				<div class="row">				
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label" for="input-name"><?php echo $column_name; ?></label>
						<input type="text" name="filter_name" value="<?php echo $filter_name; ?>" placeholder="<?php echo $column_name; ?>" id="input-name" class="form-control" />
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label" for="input-status"><?php echo $column_status; ?></label>
						<select name="filter_status" id="input-status" class="form-control">
						  <option value="*"></option>
						  <?php if ($filter_status) { ?>
						  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						  <?php } else { ?>
						  <option value="1"><?php echo $text_enabled; ?></option>
						  <?php } ?>
						  <?php if (($filter_status !== null) && !$filter_status) { ?>
						  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						  <?php } else { ?>
						  <option value="0"><?php echo $text_disabled; ?></option>
						  <?php } ?>
						</select>
					</div>
					<button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>																
				</div>
				</div>
			</div>
			<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-blog-article" class="form-horizontal">
				<div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-center"><?php echo $column_image; ?></td>
                  <td class="text-left"><?php if ($sort == 'pd.name') { ?>
                    <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'ba.date_added') { ?>
                    <a href="<?php echo isset($sort_date_added)?$sort_date_added:''; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo isset($sort_date_added)?$sort_date_added:''; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'ba.date_modified') { ?>
                    <a href="<?php echo isset($sort_date_modified)?$sort_date_modified:''; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo isset($sort_date_modified)?$sort_date_modified:''; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>					
                  <td class="text-right"><?php if ($sort == 'ba.sort_order') { ?>
                    <a href="<?php echo isset($sort_sort_order)?$sort_sort_order:''; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_oder; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo isset($sort_sort_order)?$sort_sort_order:''; ?>"><?php echo $column_sort_oder; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'p.status') { ?>
                    <a href="<?php echo isset($sort_status)?$sort_status:''; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo isset($sort_status)?$sort_status:''; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>					
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                 <?php if ($articles) { ?>
				<?php foreach ($articles as $article) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($article['blog_article_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $article['blog_article_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $article['blog_article_id']; ?>" />
                    <?php } ?></td>
					<td class="text-center"><?php if ($article['image']) { ?>
                    <img src="<?php echo $article['image']; ?>" alt="<?php echo $article['name']; ?>" class="img-thumbnail" />
                    <?php } else { ?>
                    <span class="img-thumbnail list"><i class="fa fa-camera fa-2x"></i></span>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $article['name']; ?></td>
                  <td class="text-left"><?php echo $article['date_added']; ?></td>
                  <td class="text-left"><?php echo $article['date_modified']; ?></td>
                  <td class="text-left"><?php echo $article['sort_order']; ?></td>
				  <td class="text-left"><?php echo $article['status']; ?></td>
                  <td class="text-right"><a href="<?php echo $article['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
			</form>
			<div class="row">
			  <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
			  <div class="col-sm-6 text-right"><?php echo $text_pagination; ?></div>
			</div>
		  </div>
		</div>
	</div>      
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=bossblog/articles&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	location = url;
}
//--></script> 

 <script type="text/javascript"><!--
$('#button-filter').on('click', function() {		
	var url = 'index.php?route=bossblog/articles&token=<?php echo $token; ?>';
	var filter_name = $('input[name=\'filter_name\']').val();

	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	var filter_status = $('select[name=\'filter_status\']').val();

	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}

	location = url;	
	
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	'source': function(request, response) {
		$.ajax({			
			url: 'index.php?route=bossblog/articles/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
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
		$('input[name=\'filter_name\']').val(item['label']);
	}
});
//--></script>
<?php echo $footer; ?>