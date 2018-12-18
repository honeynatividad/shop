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
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_add_blog_comment; ?></h3>
			</div>
			<div class="panel-body">
				
				<ul class="nav nav-tabs" id="module">
					<li><a href="<?php echo $boss_category; ?>" data-toggle="tab"> <?php echo $text_boss_category; ?></a></li>
					<li><a href="<?php echo $boss_articles; ?>"> <?php echo $text_boss_articles; ?></a></li>
					<li class="active"><a href="<?php echo $boss_comments; ?>"> <?php echo $text_boss_comments; ?></a></li>							
					<li><a href="<?php echo $boss_settings; ?>"> <?php echo $text_boss_settings; ?></a></li>							
				</ul>
				<div class="tab-content"><div class="tab-pane active">	
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog-comment-add" class="form-horizontal">
					<div class="form-group required">
					<label class="col-sm-2 control-label" for="input-article"><?php echo $entry_article; ?></label>
					<div class="col-sm-10">
						<input type="text" name="article" value="<?php echo $article; ?>" class="form-control" />
						<input type="hidden" name="blog_article_id" value="<?php echo $blog_article_id; ?>" />				  
					  <?php if (isset($error_article) && $error_article!='') { ?>
					  <div class="text-danger"><?php echo $error_article; ?></div>
					  <?php } ?>
					</div>
				  </div>
				  <div class="form-group required">
					<label class="col-sm-2 control-label" for="input-author"><?php echo $entry_author; ?></label>
					<div class="col-sm-10">
						<input type="text" name="author" value="<?php echo $author; ?>" placeholder="<?php echo $author; ?>" class="form-control" />
						<?php if (isset($error_author) && $error_author!='' ) { ?>
					  <div class="text-danger"><?php echo $error_author; ?></div>
					  <?php } ?>
					</div>
				  </div>
				  <div class="form-group required">
					<label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
					<div class="col-sm-10">
						<input type="text" name="email" value="<?php echo $email; ?>" placeholder="<?php echo $email; ?>" class="form-control" />
						<?php if (isset($error_email) && $error_email!='') { ?>
					  <div class="text-danger"><?php echo $error_email; ?></div>
					  <?php } ?>
					</div>
				  </div>
				  <div class="form-group required">
					<label class="col-sm-2 control-label" for="input-comment"><?php echo $entry_comment; ?></label>
					<div class="col-sm-10">
						<textarea name="text" rows="8" placeholder="<?php echo $entry_comment; ?>" class="form-control"><?php echo $text; ?></textarea>
						<?php if (isset($error_text) && $error_text!='') { ?>
					  <div class="text-danger"><?php echo $error_text; ?></div>
					  <?php } ?>
					</div>
				  </div>
				  <div class="form-group required">
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
					</form>
				</div></div>
				
			  
			</div>
		</div>
	</div>
</div>
 
<script type="text/javascript"><!--
$('input[name=\'article\']').autocomplete({	
	source: function(request, response) {
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
	select: function(item) {
		$('input[name=\'article\']').val(item.label);
		$('input[name=\'blog_article_id\']').val(item.value);
		
		return false;
	},
	focus: function(item) {
      	return false;
   	}
});

//--></script> 
<?php echo $footer; ?>