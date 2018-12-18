<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-filter" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
		<ul class="nav nav-tabs">
			<li ><a href="<?php echo $add_link;?>"> Add Filters</a></li>
			<li class="active"><a href="<?php echo $setting_link;?>"> Settings</a></li>										
		</ul>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-filter" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="boss_refinesearch_status" id="input-status" class="form-control">
                <?php if ($boss_refinesearch_status) { ?>
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
            <label class="col-sm-2 control-label" for="input-image-size"><?php echo 'Image Product Size(WxH)'; ?></label>
            <div class="col-sm-10">
              <input name="boss_refinesearch_module[width]" class="form-control" value="<?php echo isset($module['width'])?$module['width']:'' ?>" />
              <input name="boss_refinesearch_module[height]" class="form-control" value="<?php echo isset($module['height'])?$module['height']:'' ?>" />
			  <?php if($error_width){  ?>
			  <div class="text-danger"><?php echo $error_width;?> </div>
			  <?php } ?>
			  <?php if($error_height){  ?>
			  <div class="text-danger"><?php echo $error_height;?> </div>
			  <?php } ?>
            </div>
          </div>
		  <div class="form-group">
            <label class="col-sm-2 control-label" for="input-image-size"><?php echo 'Image Module Size(WxH)'; ?></label>
            <div class="col-sm-10">
              <input name="boss_refinesearch_module[image_width]" class="form-control" value="<?php echo isset($module['image_width'])?$module['image_width']:'' ?>" />
              <input name="boss_refinesearch_module[image_height]" class="form-control" value="<?php echo isset($module['image_height'])?$module['image_height']:'' ?>" />
			  <?php if($error_image_width){  ?>
			  <div class="text-danger"><?php echo $error_image_width;?> </div>
			  <?php } ?>
			  <?php if($error_image_height){  ?>
			  <div class="text-danger"><?php echo $error_image_height;?> </div>
			  <?php } ?>
            </div>
          </div>
		  <table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
				  <td class="left"><?php echo 'Filter Group Name'; ?></td>
				  <td class="left"><?php echo 'Display'; ?></td>
				  <td class="left"><?php echo 'Show under product'; ?></td><td></td>
				</tr>
			</thead>
			<tbody class="boss_content">
				<?php if(!empty($filters)){ ?>
				<?php foreach($filters as $filter){ ?>
				<tr>
				<td class="left"><?php echo $filter['name']; ?></td>
				<td class="left">
					<select name="boss_refinesearch_module[<?php echo $filter['filter_group_id'];?>][display]" class="form-control">
						<option value="text" <?php if(isset($module[$filter['filter_group_id']]['display']) && $module[$filter['filter_group_id']]['display'] == 'text') echo 'selected="selected"';?>>Text</option>
						<option value="image" <?php if(isset($module[$filter['filter_group_id']]['display']) && $module[$filter['filter_group_id']]['display'] == 'image') echo 'selected="selected"';?>>Image</option>
					</select>
				</td>
				<td class="left">
					<select name="boss_refinesearch_module[<?php echo $filter['filter_group_id'];?>][under]" class="form-control">
						<option value="0" <?php if(isset($module[$filter['filter_group_id']]['under']) && $module[$filter['filter_group_id']]['under'] == 0) echo 'selected="selected"';?>>Disable</option>
						<option value="1" <?php if(isset($module[$filter['filter_group_id']]['under']) && $module[$filter['filter_group_id']]['under'] == 1) echo 'selected="selected"';?>>Enable</option>
					</select>
				</td>
				
				</tr>
				<?php } ?>
				<?php } ?>
			</tbody>
			</table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
