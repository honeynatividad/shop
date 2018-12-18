<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
		<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-newsletter').submit() : false;"><i class="fa fa-trash-o"></i></button>
		<button type="button" data-toggle="tooltip" title="<?php echo $text_export; ?>" class="btn btn-default" onclick="location = '<?php echo $export; ?>'"><i class="fa fa-share"></i></button>
        </div>
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
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-newsletter">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="text-left"><?php echo $column_name; ?></td>
            <td class="text-left"><?php echo $column_email; ?></td>
            <td class="text-right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($emails) { ?>
          <?php foreach ($emails as $email) { ?>
          <tr>
            <td class="text-center">
              <input type="checkbox" name="selected[]" value="<?php echo $email['id']; ?>"/>
             </td>
            <td class="text-left"><?php echo $email['name']; ?></td>
            <td class="text-left"><?php echo $email['email']; ?></td>
            <td class="text-right"><?php foreach ($email['action'] as $action) { ?>
              <a href="<?php echo $action['href']; ?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
  <div class="pagination"><?php echo $pagination; ?></div>
  </div>
  
  </div>
  </div>
</div>
<?php echo $footer; ?>
