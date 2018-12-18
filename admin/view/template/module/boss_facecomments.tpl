<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-face-comments" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-face-comments" class="form-horizontal">
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="boss_facecomments[status]" id="input-status" class="form-control">
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
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-app-id"><span data-toggle="tooltip" title="<?php echo $help_app_id; ?>"><?php echo $entry_app_id; ?></span></label>
            <div class="col-sm-10">
			    <div class="input-group">
					<span class="input-group-addon"><i class="fa fa-facebook"></i></span>
					<input type="text" name="boss_facecomments[app_id]" value="<?php echo $app_id; ?>" placeholder="<?php echo $entry_app_id; ?>" id="input-app-id" class="form-control" />
				</div>	
                <?php if ($error_app_id) { ?>
                <div class="text-danger"><?php echo $error_app_id; ?></div>
                <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-color-scheme"><span data-toggle="tooltip" title="<?php echo $help_color_scheme; ?>"><?php echo $entry_color_scheme; ?></span></label>
            <div class="col-sm-10">
              <select name="boss_facecomments[color_scheme]" id="input-color-scheme" class="form-control">
				  <?php if ($color_scheme == 'dark') { ?>
				  <option value="dark" selected="selected"><?php echo $text_dark; ?></option>
				  <option value="light"><?php echo $text_light; ?></option>
				  <?php } else { ?>
				  <option value="dark"><?php echo $text_dark; ?></option>
				  <option value="light" selected="selected"><?php echo $text_light; ?></option>			  
				  <?php } ?>
              </select>
            </div>
          </div> 	
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-num-posts"><span data-toggle="tooltip" title="<?php echo $help_num_posts; ?>"><?php echo $entry_num_posts; ?></span></label>
            <div class="col-sm-10">
				<input type="text" name="boss_facecomments[num_posts]" value="<?php echo $num_posts; ?>" placeholder="<?php echo $entry_num_posts; ?>" id="input-num-posts" class="form-control" />
                <?php if ($error_num_posts) { ?>
                <div class="text-danger"><?php echo $error_num_posts; ?></div>
                <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-by"><span data-toggle="tooltip" title="<?php echo $help_order_by; ?>"><?php echo $entry_order_by; ?></span></label>
            <div class="col-sm-10">
				<div class="input-group">
				  <span class="input-group-addon"><i class="fa fa-sort-alpha-asc"></i></span>
				  <select name="boss_facecomments[order_by]" id="input-order-by" class="form-control">
					  <?php if ($order_by == 'time') { ?>
					  <option value="social"><?php echo $text_social; ?></option>
					  <option value="reverse_time" selected="selected"><?php echo $text_reverse_time; ?></option>		  
					  <option value="time" selected="selected"><?php echo $text_time; ?></option>	  
					  <?php } elseif ($order_by == 'reverse_time') { ?>
					  <option value="social"><?php echo $text_social; ?></option>
					  <option value="reverse_time" selected="selected"><?php echo $text_reverse_time; ?></option>		  
					  <option value="time"><?php echo $text_time; ?></option>
					  <?php } else { ?>
					  <option value="social" selected="selected"><?php echo $text_social; ?></option>
					  <option value="reverse_time"><?php echo $text_reverse_time; ?></option>		  
					  <option value="time"><?php echo $text_time; ?></option>					  
					  <?php } ?>
				  </select>
				</div>  
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>