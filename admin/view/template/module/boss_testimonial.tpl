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
  <div class="panel panel-default">
    <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>       
    </div>
    <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-boss-testimonial" class="form-horizontal">
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
            <label class="col-sm-2 control-label"><?php echo $entry_status; ?></label>
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
		
		<div class="form-group">
            <label class="col-sm-2 control-label" ><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
			  <?php foreach ($languages as $language) { ?>
			  <div class="form-group">
			  <div class="col-sm-11">
				<input type="text" name="boss_testimonial_module[title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($modules['title'][$language['language_id']])?$modules['title'][$language['language_id']]:''; ?>" placeholder="<?php echo $entry_title; ?>"  class="form-control" />
			  </div>
			  <div class="col-sm-1">
				<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" />
			  </div>
			   </div>
			  <?php } ?>
             </div>
		</div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label" ><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="boss_testimonial_module[limit]" value="<?php echo isset($modules['limit'])?$modules['limit']:20; ?>" placeholder="<?php echo $entry_limit; ?>" class="form-control" />
              <?php if ($error_limit) { ?>
              <div class="text-danger"><?php echo $error_limit; ?></div>
              <?php } ?>
            </div>
		</div>
		
		<div class="form-group">
            <label class="col-sm-2 control-label" ><?php echo $entry_character_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="boss_testimonial_module[limit_character]" value="<?php echo isset($modules['limit_character'])?$modules['limit_character']:20; ?>" placeholder="<?php echo $entry_character_limit; ?>" class="form-control" />
              <?php if ($error_limit_character) { ?>
              <div class="text-danger"><?php echo $error_limit_character; ?></div>
              <?php } ?>
            </div>
		</div>
		<div class="form-group">
            <label class="col-sm-2 control-label" >Random</label>
            <div class="col-sm-10">
               <select name="boss_testimonial_module[random]" class="form-control">
                <?php if (isset($modules['random']) && $modules['random']) { ?>
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
            <label class="col-sm-2 control-label" >Auto Scroll</label>
            <div class="col-sm-10">
               <select name="boss_testimonial_module[auto_scroll]" class="form-control">
                <?php if (isset($modules['auto_scroll']) && $modules['auto_scroll']) { ?>
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
            <label class="col-sm-2 control-label">Show name</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_name]" class="form-control">
                <?php if (isset($modules['show_name']) && $modules['show_name']) { ?>
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
            <label class="col-sm-2 control-label">Show Subject</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_subject]" class="form-control">
                <?php if (isset($modules['show_subject']) && $modules['show_subject']) { ?>
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
            <label class="col-sm-2 control-label">Show Message</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_message]" class="form-control">
                <?php if (isset($modules['show_message']) && $modules['show_message']) { ?>
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
            <label class="col-sm-2 control-label">Show City</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_city]" class="form-control">
                <?php if (isset($modules['show_city']) && $modules['show_city']) { ?>
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
            <label class="col-sm-2 control-label">Show Rating</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_rating]" class="form-control">
                <?php if (isset($modules['show_rating']) && $modules['show_rating']) { ?>
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
            <label class="col-sm-2 control-label">Show Date</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_date]" class="form-control">
                <?php if (isset($modules['show_date']) && $modules['show_date']) { ?>
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
            <label class="col-sm-2 control-label">Show Image</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_image]" class="form-control">
                <?php if (isset($modules['show_image']) && $modules['show_image']) { ?>
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
            <label class="col-sm-2 control-label">Link "Show All"</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_all]" class="form-control">
                <?php if (isset($modules['show_all']) && $modules['show_all']) { ?>
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
            <label class="col-sm-2 control-label">Link "Write Testimonial"</label>
            <div class="col-sm-10">
              <select name="boss_testimonial_module[show_write]" class="form-control">
                <?php if (isset($modules['show_write']) && $modules['show_write']) { ?>
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
<?php echo $footer; ?>