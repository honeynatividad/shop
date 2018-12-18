<?php
$style = '<style type="text/css">
    .bztable {margin:20px 0; width:100%; border:1px solid #dfdfdf; }
    .bztable tr {vertical-align:middle; border-bottom:1px solid #dfdfdf; padding:15px 5px; font-weight:bold; background:#fff; text-align:left; }
    .bztable th, .bztable td {vertical-align:middle; border-bottom:1px solid #dfdfdf; padding:10px 5px; background:#fff; }
    .bztable tr.black td, .bztable tr.black th {background:#f9f9f9; }
    .bztable tr.last td, .bztable tr.last th{border:none; }
	.bztable tbody  tr td img{margin-right:10px; vertical-align: middle !important;display:inline-block;}
	.bztable tbody tr td input, .bztable tbody tr td select, .bztable tbody tr td span{margin: 0 10px 0 10px; vertical-align: middle}
	.bztable tbody tr td span{margin: 0 0 0 10px; vertical-align: middle}
    .bztitle {font-size: 1.5em;font-weight: normal;margin: 1.7em 0 1em 0;}
	.bz_error{color: red; font-size: 12px; font-weight: normal;}
</style>';
$header = str_replace('</head>',$style.'</head>',$header);?>
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
    <div class="panel-body">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-boss_zoom" class="form-horizontal">
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
		</div>
		<h3 class="bztitle"><?php echo $text_information; ?></h3>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-thumb-image"><?php echo $text_image_thumb; ?></label>
            <div class="col-sm-10">
				<input type="number" name="boss_zoom_thumb_image_width" value="<?php echo $boss_zoom_thumb_image_width; ?>" size="3" class="form-control" /> 
				<input type="number" name="boss_zoom_thumb_image_heigth" value="<?php echo $boss_zoom_thumb_image_heigth; ?>" size="3" class="form-control" />
				<?php if (isset($error_thumb_image)) { ?>
                <span class="bz_error"><?php echo $error_thumb_image; ?></span>
                <?php } ?>
				
            </div>
        </div> 
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-addition-image"><?php echo $text_image_addition; ?></label>
            <div class="col-sm-10">
				<input type="number" name="boss_zoom_addition_image_width" value="<?php echo $boss_zoom_addition_image_width; ?>" size="3" class="form-control" />
				<input type="number" name="boss_zoom_addition_image_heigth" value="<?php echo $boss_zoom_addition_image_heigth; ?>" size="3" class="form-control" />
				<?php if (isset($error_addition_image)) { ?>
                <span class="bz_error"><?php echo $error_addition_image; ?></span>
                <?php } ?>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-zoom-image"><?php echo $text_image_zoom; ?></label>
            <div class="col-sm-10">
				<input type="number" name="boss_zoom_zoom_image_width" value="<?php echo $boss_zoom_zoom_image_width; ?>" size="3" class="form-control" />
				<input type="number" name="boss_zoom_zoom_image_heigth" value="<?php echo $boss_zoom_zoom_image_heigth; ?>" size="3" class="form-control" />
				<?php if (isset($error_zoom_image)) { ?>
                <span class="bz_error"><?php echo $error_zoom_image; ?></span>
                <?php } ?>
            </div>
        </div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-zoom-area"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_auto_size_area; ?>"><?php echo $text_area_zoom; ?></span></label>
            <div class="col-sm-10">
				<input type="number" name="boss_zoom_zoom_area_width" value="<?php echo $boss_zoom_zoom_area_width; ?>" size="3" class="form-control" /> 
				<input type="number" name="boss_zoom_zoom_area_heigth" value="<?php echo $boss_zoom_zoom_area_heigth; ?>" size="3" class="form-control" />
            </div>
        </div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-position-zoom"><?php echo $text_area_position; ?></label>
            <div class="col-sm-10">
				<select name="boss_zoom_position_zoom_area" id="input-status" onchange="changeZoomPosition(this.value)" class="form-control">
                <?php if ($boss_zoom_position_zoom_area == 'right' ) { ?>
                <option value="right" selected="selected"><?php echo $text_right; ?></option>
                <option value="inside"><?php echo $text_inner; ?></option>
                <?php } else { ?>
                <option value="right"><?php echo $text_right; ?></option>
                <option value="inside" selected="selected"><?php echo $text_inner; ?></option>
                <?php } ?>
              </select>
            </div>
        </div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-adjust"><span data-toggle="tooltip" title="" data-original-title="<?php echo $text_distance; ?>"><?php echo $text_adjust; ?></span></label>
            <div class="col-sm-10">
				<input id="adjustX" type="number" name="boss_zoom_adjustX" value="<?php echo $boss_zoom_adjustX; ?>" size="3" class="form-control" />
				<input id="adjustY" type="number" name="boss_zoom_adjustY" value="<?php echo $boss_zoom_adjustX; ?>" size="3" class="form-control" />
            </div>
        </div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-title-image"><?php echo $text_title; ?></label>
            <div class="col-sm-10">
				<select name="boss_zoom_title_image" id="input-status" class="form-control">
                <?php if ($boss_zoom_title_image) { ?>
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
			<label class="col-sm-2 control-label" for="input-title-opacity"><?php echo $text_title_opacity; ?></label>
			<div class="col-sm-10">
				<input type="number" name="boss_zoom_title_opacity" value="<?php echo $boss_zoom_title_opacity; ?>" size="3" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-tint"><?php echo $text_tint; ?></label>
			<div class="col-sm-10">
				<input type="text" name="boss_zoom_tint" value="<?php echo $boss_zoom_tint; ?>" size="10" class="form-control" />
			</div>
		</div>
		<div class="form-group">	
			<label class="col-sm-2 control-label" for="input-tint-opacity"><?php echo $text_tint_opacity; ?></label>
			<div class="col-sm-10">
				<input type="number" name="boss_zoom_tint_opacity" value="<?php echo $boss_zoom_tint_opacity; ?>" size="3" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-softFocus"><?php echo $text_soft_focus; ?></label>
            <div class="col-sm-10">				
				<select name="boss_zoom_softFocus" id="input-status" class="form-control">
                <?php if ($boss_zoom_softFocus) { ?>
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
			<label class="col-sm-2 control-label" for="input-lensOpacity"><?php echo $text_opacity_lens; ?></label>
            <div class="col-sm-10">
				<input type="number" name="boss_zoom_lensOpacity" value="<?php echo $boss_zoom_lensOpacity; ?>" size="3" class="form-control" />
            </div>
        </div>
		<div class="form-group">
			<label class="col-sm-2 control-label" for="input-smoothMove"><?php echo $text_smooth; ?></label>
            <div class="col-sm-10">
				<input type="number" name="boss_zoom_smoothMove" value="<?php echo $boss_zoom_smoothMove; ?>" size="3" class="form-control" />
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
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
      </form>
    </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function changeZoomPosition(value){
		if(value=='inside'){
			$('#adjustX').val("0"); 
			$('#adjustY').val("0");
		}
	}	
</script>
<?php echo $footer; ?>