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
	<div class="panel-body">					
		<div class="panel-heading">
			<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
		</div>
		<ul class="nav nav-tabs">
			<li><a href="<?php echo $boss_category; ?>"> <?php echo $text_boss_category; ?></a></li>
			<li><a href="<?php echo $boss_articles; ?>"> <?php echo $text_boss_articles; ?></a></li>
			<li><a href="<?php echo $boss_comments; ?>"> <?php echo $text_boss_comments; ?></a></li>							
			<li class="active"><a href="<?php echo $boss_settings; ?>"> <?php echo $text_boss_settings; ?></a></li>							
		</ul>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-blog-setting" class="form-horizontal">		
		<ul class="nav nav-tabs" id="module">
			<li><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
			<li><a href="#tab-option" data-toggle="tab"><?php echo $tab_option; ?></a></li>
			<li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>			
		</ul>
		<div class="tab-content">
            <div class="tab-pane active" id="tab-general">
				<div class="form-group required">
                    <label class="col-sm-3 control-label" for="input-blog-name"><?php echo $entry_name; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="config_bossblog_name" value="<?php echo isset($config_bossblog_name) ? $config_bossblog_name : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
                      <?php if (isset($error_blog_name) && $error_blog_name!='') { ?>
                      <div class="text-danger"><?php echo $error_blog_name; ?></div>
                      <?php } ?>
                    </div>
                </div>
				<div class="form-group">
                    <label class="col-sm-3 control-label" for="input-blog-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                    <div class="col-sm-9">
                      <input type="text" name="config_bossblog_keyword" value="<?php echo isset($config_bossblog_keyword) ? $config_bossblog_keyword : ''; ?>" placeholder="<?php echo $entry_keyword; ?>" class="form-control" />
                    </div>
                </div>				
			</div>
			<div class="tab-pane" id="tab-option">
				<fieldset>
                <legend><?php echo $text_items; ?></legend>
                <div class="form-group required">
                  <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $help_bossblog_limit; ?>"><?php echo $entry_bossblog_limit; ?></span></label>
                  <div class="col-sm-9">
						<input type="text" name="config_bossblog_limit" value="<?php echo $config_bossblog_limit; ?>" class="form-control" />
                        <?php if ($error_bossblog_limit) { ?>
                        <div class="text-danger"><?php echo $error_bossblog_limit; ?></div>
                        <?php } ?>
                  </div>
                </div>
                <div class="form-group required">
                  <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $help_blog_admin_limit; ?>"><?php echo $entry_blog_admin_limit; ?></span></label>
                  <div class="col-sm-9">
						<input type="text" name="config_bossblog_admin_limit" value="<?php echo $config_bossblog_admin_limit; ?>" class="form-control" />
                        <?php if ($error_blog_admin_limit) { ?>
                        <div class="text-danger"><?php echo $error_blog_admin_limit; ?></div>
                        <?php } ?>
                  </div>
                </div>                
              </fieldset>
			   <fieldset>
                <legend><?php echo $text_article; ?></legend>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $help_comment; ?>"><?php echo $entry_comment; ?></span></label>
                  <div class="col-sm-9">
                    <label class="radio-inline">
                      <?php if ($config_bossblog_comment_status) { ?>
                      <input type="radio" name="config_bossblog_comment_status" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_bossblog_comment_status" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_bossblog_comment_status) { ?>
                      <input type="radio" name="config_bossblog_comment_status" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_bossblog_comment_status" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>
				<div class="form-group">
                  <label class="col-sm-3 control-label"><span data-toggle="tooltip" title="<?php echo $help_approval; ?>"><?php echo $entry_approval; ?></span></label>
                  <div class="col-sm-9">
                    <label class="radio-inline">
                      <?php if ($config_bossblog_approval_status) { ?>
                      <input type="radio" name="config_bossblog_approval_status" value="1" checked="checked" />
                      <?php echo $text_yes; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_bossblog_approval_status" value="1" />
                      <?php echo $text_yes; ?>
                      <?php } ?>
                    </label>
                    <label class="radio-inline">
                      <?php if (!$config_bossblog_approval_status) { ?>
                      <input type="radio" name="config_bossblog_approval_status" value="0" checked="checked" />
                      <?php echo $text_no; ?>
                      <?php } else { ?>
                      <input type="radio" name="config_bossblog_approval_status" value="0" />
                      <?php echo $text_no; ?>
                      <?php } ?>
                    </label>
                  </div>
                </div>                                
              </fieldset>
			</div>
			<div class="tab-pane" id="tab-image">
				<div class="form-group required">
                    <label class="col-sm-3 control-label" for="input-blog-image-category"><?php echo $entry_image_category; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="config_bossblog_image_category_width" value="<?php echo isset($config_bossblog_image_category_width) ? $config_bossblog_image_category_width : ''; ?>" class="form-control" />
                      <input type="text" name="config_bossblog_image_category_height" value="<?php echo isset($config_bossblog_image_category_height) ? $config_bossblog_image_category_height : ''; ?>" class="form-control" />
                      <?php if (isset($error_blog_image_category) && $error_blog_image_category!='') { ?>
                      <div class="text-danger"><?php echo $error_blog_image_category; ?></div>
                      <?php } ?>
                    </div>
                </div>
				<div class="form-group required">
                    <label class="col-sm-3 control-label" for="input-blog-image-article"><?php echo $entry_image_article; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="config_bossblog_image_article_width" value="<?php echo isset($config_bossblog_image_article_width) ? $config_bossblog_image_article_width : ''; ?>" class="form-control" />
                      <input type="text" name="config_bossblog_image_article_height" value="<?php echo isset($config_bossblog_image_article_height) ? $config_bossblog_image_article_height : ''; ?>" class="form-control" />
                      <?php if (isset($error_blog_image_article) && $error_blog_image_article!='') { ?>
                      <div class="text-danger"><?php echo $error_blog_image_article; ?></div>
                      <?php } ?>
                    </div>
                </div>
				
				<div class="form-group required">
                    <label class="col-sm-3 control-label" for="input-blog-image-title"><?php echo $entry_image_title; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="config_bossblog_image_title_width" value="<?php echo isset($config_bossblog_image_title_width) ? $config_bossblog_image_title_width : ''; ?>" class="form-control" />
                      <input type="text" name="config_bossblog_image_title_height" value="<?php echo isset($config_bossblog_image_title_height) ? $config_bossblog_image_title_height : ''; ?>" class="form-control" />
                      <?php if (isset($error_blog_image_title) && $error_blog_image_title!='') { ?>
                      <div class="text-danger"><?php echo $error_blog_image_title; ?></div>
                      <?php } ?>
                    </div>
                </div>
				
				<div class="form-group required">
                    <label class="col-sm-3 control-label" for="input-blog-image-related"><?php echo $entry_image_related; ?></label>
                    <div class="col-sm-9">
                      <input type="text" name="config_bossblog_image_related_width" value="<?php echo isset($config_bossblog_image_related_width) ? $config_bossblog_image_related_width : ''; ?>" class="form-control" />
                      <input type="text" name="config_bossblog_image_related_height" value="<?php echo isset($config_bossblog_image_related_height) ? $config_bossblog_image_related_height : ''; ?>" class="form-control" />
                      <?php if (isset($error_blog_image_related) && $error_blog_image_related!='') { ?>
                      <div class="text-danger"><?php echo $error_blog_image_related; ?></div>
                      <?php } ?>
                    </div>
                </div>
			</div>
		</div>
		</form>
	</div>
	</div>
  </div>
</div>
<script type="text/javascript"><!--
$('#module li:first-child a').tab('show');
//--></script>
<?php echo $footer; ?>