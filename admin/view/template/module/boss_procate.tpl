<?php require_once(DIR_SYSTEM . 'library/btform.php');?>
<?php 
$btform = new Btform();
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-bestseller" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-boss_procate" class="form-horizontal">
		<div id="moduletab">
			<table class="table table-striped table-bordered table-hover">
				
				<tr><td><label class="control-label" for="input-name"><?php echo $entry_name; ?></label></td><td>
				<input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
				  <?php if ($error_name) { ?>
				  <div class="text-danger"><?php echo $error_name; ?></div>
				  <?php } ?>
				</td></tr>
			
				<tr><td><label class="control-label" for="input-name"><?php echo $entry_title; ?></label></td>
				<td>
					<table class="table table-striped table-bordered table-hover">
					<?php foreach ($languages as $language) { ?>
					<tr>
						<td><input type="text" name="title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($title[$language['language_id']])?$title[$language['language_id']]:''; ?>" placeholder="<?php echo $entry_title; ?>" id="input-name" class="form-control" /></td>
						<td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td>
					</tr>
					<?php } ?>
					</table>
				</td></tr>
				
				<tr><td class="left"><?php echo $tab_get_product; ?></td><td class="left">
					<div class="well well-sm" style="height: 150px; overflow: auto;" id="scrollbox">
						<?php echo $btform -> checkBoxHTML($categories, 'category_id[]',isset($category_id) ? $category_id : ''); ?>
					</div>
					<?php if ($error_category) { ?>
				  <div class="text-danger"><?php echo $error_category; ?></div>
				  <?php } ?>
				</td></tr>
				
				<tr><td><?php echo $entry_image; ?></td><td class="left"><table class="table table-striped table-bordered table-hover"><tr><td>
					<?php echo $btform -> textField('image_width',isset($image_width) ? $image_width : '',3,'class="form-control"'); ?> 
					<?php if ($error_width) { ?>
					  <div class="text-danger"><?php echo $error_width; ?></div>
					<?php } ?>
					</td><td>
					<?php echo $btform -> textField('image_height',isset($image_height) ? $image_height : '',3,'class="form-control"'); ?>
					
					<?php if ($error_height) { ?>
					  <div class="text-danger"><?php echo $error_height; ?></div>
					<?php } ?></td></tr></table>
				</td></tr>
				
				<tr><td><?php echo $entry_limit; ?></td><td class="left">
					<?php echo $btform -> textField('limit',isset($limit) ? $limit : '',3,'class="form-control"'); ?>
					<?php if (isset($error_numproduct)) { ?>
						<span class="error"><?php echo $error_numproduct; ?></span>
					<?php } ?>
				</td></tr>
				
				<tr><td><?php echo 'Type Display:'; ?></td><td class="left">
				<?php echo $btform -> makeSelectHTML($arrtypes, 'type_display','',isset($type_display) ? $type_display : '','class="form-control"'); ?></td></tr>
				
				<tr><td><?php echo $entry_scrolling; ?></td><td class="left">
				<table class="table table-striped table-bordered table-hover">
				<tr><td>Show slider</td>
				<td><?php echo $btform -> makeSelectHTML($arrstatus, 'show_slider','',isset($show_slider) ? $show_slider : '','class="form-control"'); ?></td></tr>
				
				<tr><td><?php echo $entry_row; ?></td>
				
				<td><?php echo $btform -> textField('num_row',isset($num_row) ? $num_row : '',3,'class="form-control"'); ?></td>
				<?php if (isset($error_numproduct)) { ?>
					<span class="error"><?php echo $error_numproduct; ?></span>
				<?php } ?>
				</tr>
				
				<tr><td><?php echo $entry_properrow; ?></td>
				
				<td><?php echo $btform -> textField('per_row',isset($per_row) ? $per_row : '',3,'class="form-control"'); ?></td>
				
				<?php if (isset($error_numproduct)) { ?>
				<span class="error"><?php echo $error_numproduct; ?></span>
				<?php } ?></tr></table></td></tr>
				
				<tr><td><?php echo $entry_nav; ?></td><td class="left">
				
				<?php echo $btform -> makeSelectHTML($arrstatus, 'nav_type','',isset($nav_type) ? $nav_type : '','class="form-control"'); ?></td></tr>
				
				<tr><td><?php echo $entry_prolarge; ?></td><td class="left">
				<table class="table table-striped table-bordered table-hover">
				<tr>
				<td><?php echo $entry_show_prolarge; ?>:</td>
				
				<td><?php echo $btform -> makeSelectHTML($arrstatus, 'show_pro_large',"",isset($show_pro_large)?$show_pro_large:true,'class="form-control"'); ?>
				
				</td></tr> 
				<tr><td><?php echo $entry_img_large; ?></td>
				
				<td><?php echo $btform -> textField('img_width',isset($img_width) ? $img_width : '380',3,'class="form-control"'); ?>
				
				<?php echo $btform -> textField('img_height',isset($img_height) ? $img_height : '380',3,'class="form-control"'); ?>
				</td>
				</tr></table></td></tr>
				
				<tr><td><?php echo $entry_status; ?></td><td class="left">
				
				<?php echo $btform -> makeSelectHTML($arrstatus, 'status','',isset($status) ? $status : '','class="form-control"'); ?></td></tr>
				
			</table>
		</div>
	</form>
	</div>
</div>
</div>
</div>
<?php echo $footer; ?>