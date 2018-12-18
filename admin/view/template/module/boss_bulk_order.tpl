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
              <select name="boss_bulk_order[status]" id="input-status" class="form-control">
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
		  <ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#generalsetting"><?php echo $setting_general; ?></a></li>
			<li><a data-toggle="tab" href="#optionsetting"><?php echo $setting_option; ?></a></li>
		  </ul>
		  <div class="tab-content">
			<div id="generalsetting" class="tab-pane active">
		    <!-- #option setting-->
		    <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-num-products"><span data-toggle="tooltip" title="<?php echo $help_num_products; ?>"><?php echo $entry_num_products; ?></span></label>
            <div class="col-sm-10">
				<input type="text" name="boss_bulk_order[num_products]" value="<?php echo $num_products; ?>" placeholder="<?php echo $entry_num_products; ?>" id="input-num-products" class="form-control" />
                <?php if ($error_num_products) { ?>
                <div class="text-danger"><?php echo $error_num_products; ?></div>
                <?php } ?>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-num-record"><span data-toggle="tooltip" title="<?php echo $help_num_record; ?>"><?php echo $entry_num_record; ?></span></label>
            <div class="col-sm-10">
				<input type="text" name="boss_bulk_order[num_record]" value="<?php echo $num_record; ?>" placeholder="<?php echo $entry_num_record; ?>" id="input-num-record" class="form-control" />
                <?php if ($error_num_record) { ?>
                <div class="text-danger"><?php echo $error_num_record; ?></div>
                <?php } ?>
            </div>
          </div>
		  
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-order-by"><?php echo $entry_search_type; ?></label>
            <div class="col-sm-10">
				<table class="table table-striped table-bordered table-hover">
					<tr>
						<td><?php echo $text_search_product; ?></td>
						<td><select name="boss_bulk_order[search_product]" class="form-control">
							<?php if ($search_product) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						  </select></td>	
					</tr>
					<tr>
						<td><?php echo $text_search_category; ?></td>
						<td><select name="boss_bulk_order[search_category]" class="form-control">
							<?php if ($search_category) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						  </select></td>	
					</tr>
					<tr>
						<td><?php echo $text_search_model; ?></td>
						<td><select name="boss_bulk_order[search_model]" class="form-control">
							<?php if ($search_model) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						  </select></td>	
					</tr>
					<tr>
						<td><?php echo $text_search_tags; ?></td>
						<td><select name="boss_bulk_order[search_tags]" class="form-control">
							<?php if ($search_tags) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						  </select></td>	
					</tr>
					<tr>
						<td><?php echo $text_search_price; ?></td>
						<td>
						<table class="table table-striped table-bordered table-hover">
							<tr>
								<td><?php echo $display_status; ?></td>
								<td><select name="boss_bulk_order[search_price]" class="form-control">
								<?php if ($search_price) { ?>
								<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								<option value="0"><?php echo $text_disabled; ?></option>
								<?php } else { ?>
								<option value="1"><?php echo $text_enabled; ?></option>
								<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								<?php } ?>
							  </select></td>
							</tr>
							<tr>
								<td><?php echo $text_price_min; ?></td>
								<td><input type="text" name="boss_bulk_order[price_min]" value="<?php echo isset($price_min)?$price_min:1; ?>"  class="form-control" /></td>
							</tr>
							<tr>
								<td><?php echo $text_price_max; ?></td>
								<td><input type="text" name="boss_bulk_order[price_max]" value="<?php echo isset($price_max)?$price_max:1200; ?>" class="form-control" /></td>
							</tr>
						</table>
						</td>	
					</tr>
				</table>
            </div>
          </div>
		  
		  <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-image-size"><?php echo $entry_image_size; ?></label>
            <div class="col-sm-10">
				<table class="table table-striped table-bordered table-hover">
					<tr>
						<td><?php echo $text_image_width; ?></td>
						<td><input type="text" name="boss_bulk_order[image_width]" value="<?php echo $image_width; ?>" placeholder="<?php echo $text_image_width; ?>" class="form-control" />
						<?php if ($error_image_width) { ?>
						<div class="text-danger"><?php echo $error_image_width; ?></div>
						<?php } ?></td>
					</tr>
					<tr>
						<td><?php echo $text_image_height; ?></td>
						<td><input type="text" name="boss_bulk_order[image_height]" value="<?php echo $image_height; ?>" placeholder="<?php echo $text_image_height; ?>" class="form-control" />
						<?php if ($error_image_height) { ?>
						<div class="text-danger"><?php echo $error_image_height; ?></div>
						<?php } ?></td>
					</tr>
				</table>
            </div>
          </div>
          </div>
		  
		  <div id="optionsetting" class="tab-pane">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_option; ?></label>
				<div class="col-sm-10">
				  <table class="table table-striped table-bordered table-hover">
					<tr>
						<td><b><?php echo $option_name; ?></b></td>
						<td><b><?php echo $option_show; ?></b></td>
					</tr>
				  <?php if(isset($options) && !empty($options)) { ?>
					<?php foreach($options as $option) { ?>
					  <tr>
						<td><?php echo $option['name']; ?></td>
						<td>
							<?php if ($option['selected']) { ?>
							<input class="form-control" type="checkbox" name="boss_bulk_order[option][<?php echo $option['option_id']; ?>]" value="<?php echo $option['option_id']; ?>" checked="checked" />
							<?php } else { ?>
							<input class="form-control" type="checkbox" name="boss_bulk_order[option][<?php echo $option['option_id']; ?>]" value="<?php echo $option['option_id']; ?>" />
							<?php } ?>
						</td>
					  </tr>
					<?php } ?>
				  <?php } ?>
				  <table>
				</div>
			</div>
		  </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>