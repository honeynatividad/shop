<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-testimonial-form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
		<h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
    </div>
    <div class="panel-body">
		<ul class="nav nav-tabs" id="module">
		<li class="active"><a href="<?php echo $module_testimonial_path; ?>"> <?php echo $text_module_testimonial; ?></a></li>
		<li><a href="<?php echo $module_settings_path; ?>"> <?php echo $text_module_settings; ?></a></li>									
	</ul>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-testimonial-form" class="form-horizontal">
		<div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
			  <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_title; ?></label>
						<div class="col-sm-10">
						  <input type="text" name="testimonial_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($testimonial_description[$language['language_id']]) ? $testimonial_description[$language['language_id']]['title'] : ''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />                      
						</div>
                  </div>
				  
				  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="testimonial_description[<?php echo $language['language_id']; ?>][description]" id="input-description<?php echo $language['language_id']; ?>" placeholder="<?php echo $entry_description; ?>" rows="5" class="form-control"><?php echo isset($testimonial_description[$language['language_id']]) ? $testimonial_description[$language['language_id']]['description'] : ''; ?></textarea>
					  <?php if (isset($error_description[$language['language_id']])) { ?>
					  <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>					  
					  <?php } ?>
                    </div>
                  </div> 
				</div>
				  <?php } ?>
				<div class="form-group required">
                    <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" placeholder="<?php echo $entry_name; ?>"  class="form-control" />  
						<?php if ($error_name) { ?>
							<div class="text-danger"><?php echo $error_name; ?></div>				             
			              <?php } ?>
                    </div>					
                  </div>
				  
				  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_city; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="city" value="<?php echo isset($city) ? $city : ''; ?>" placeholder="<?php echo $entry_city; ?>"  class="form-control" />  						
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_email; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="email" value="<?php echo isset($email) ? $email : ''; ?>" placeholder="<?php echo $entry_email; ?>"  class="form-control" />  						
                    </div>
                  </div>
				  
				   <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
                    <div class="col-sm-10">
                      <select name="status" class="form-control">
					  <?php if (isset($status) && $status) { ?>
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
                    <label class="col-sm-2 control-label"><?php echo $entry_date_added; ?></label>
                    
					<div class="col-sm-3">
						<div class="input-group datetime">
						<input type="text" name="date_added" value="<?php echo isset($date_added) ? $date_added : ''; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-date-added" class="form-control" />
						<span class="input-group-btn">
							<button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
						</span>
						</div>
					</div>
                  </div>
				  
				  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $entry_rating; ?></label>
                    <div class="col-sm-10">
                      <span><?php echo $entry_bad; ?></span>&nbsp;
						<input type="radio" name="rating" value="1" style="margin: 0;" <?php if ( $rating == 1 ) echo 'checked="checked"';?> />
						&nbsp;
						<input type="radio" name="rating" value="2" style="margin: 0;" <?php if ( $rating == 2 ) echo 'checked="checked"';?> />
						&nbsp;
						<input type="radio" name="rating" value="3" style="margin: 0;" <?php if ( $rating == 3 ) echo 'checked="checked"';?> />
						&nbsp;
						<input type="radio" name="rating" value="4" style="margin: 0;" <?php if ( $rating == 4 ) echo 'checked="checked"';?> />
						&nbsp;
						<input type="radio" name="rating" value="5" style="margin: 0;" <?php if ( $rating == 5 ) echo 'checked="checked"';?> />
						&nbsp; <span><?php echo $entry_good; ?></span>  						
                    </div>
                  </div>
				  
			 </div>
			</div>
		</div>      
      </form>
    </div>
  </div>
</div>
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
$('#language a:first').tab('show');
//--></script>
<?php echo $footer; ?>