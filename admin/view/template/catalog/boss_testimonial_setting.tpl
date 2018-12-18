<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
 <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-boss-testimonial" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>  
  <?php } ?>
  <div class="panel panel-default">
    <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3> 	  
    </div>
  <div class="panel-body">
	<ul class="nav nav-tabs" id="module">
		<li><a href="<?php echo $module_testimonial_path; ?>"> <?php echo $text_module_testimonial; ?></a></li>
		<li  class="active"><a href="<?php echo $module_settings_path; ?>"> <?php echo $text_module_settings; ?></a></li>									
	</ul>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-testimonial-setting" class="form-horizontal">
		<div class="form-group">
            <label class="col-sm-2 control-label" ><?php echo $entry_admin_approved; ?></label>
            <div class="col-sm-10">
              <select name="testimonial_admin_approved" class="form-control">
                <?php if (isset($testimonial_admin_approved) && $testimonial_admin_approved) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
		<?php if (!isset($testimonial_default_rating)) $testimonial_default_rating = '3'; ?>
		<div class="form-group">
            <label class="col-sm-2 control-label" ><?php echo $entry_default_rating; ?></label>
            <div class="col-sm-10">
              <span><?php echo $entry_bad; ?></span>&nbsp;
        		<input type="radio" name="testimonial_default_rating" value="1" style="margin: 0;" <?php if ( $testimonial_default_rating == 1 ) echo 'checked="checked"';?> />
        		&nbsp;
        		<input type="radio" name="testimonial_default_rating" value="2" style="margin: 0;" <?php if ( $testimonial_default_rating == 2 ) echo 'checked="checked"';?> />
        		&nbsp;
        		<input type="radio" name="testimonial_default_rating" value="3" style="margin: 0;" <?php if ( $testimonial_default_rating == 3 ) echo 'checked="checked"';?> />
        		&nbsp;
        		<input type="radio" name="testimonial_default_rating" value="4" style="margin: 0;" <?php if ( $testimonial_default_rating == 4 ) echo 'checked="checked"';?> />
        		&nbsp;
        		<input type="radio" name="testimonial_default_rating" value="5" style="margin: 0;" <?php if ( $testimonial_default_rating == 5 ) echo 'checked="checked"';?> />
        		&nbsp; <span><?php echo $entry_good; ?></span>
            </div>
        </div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label" ><?php echo $entry_all_page_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="testimonial_all_page_limit" value="<?php echo isset($testimonial_all_page_limit)?$testimonial_all_page_limit:20; ?>" placeholder="<?php echo $entry_all_page_limit; ?>" class="form-control" />
              <?php if ($error_all_page_limit) { ?>
              <div class="text-danger"><?php echo $error_all_page_limit; ?></div>
              <?php } ?>
            </div>
		</div>
    </form>
    
  </div>
</div>
</div>
<?php echo $footer; ?>