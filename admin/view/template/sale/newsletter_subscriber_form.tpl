<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<button type="submit" form="form-newsletter" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
			<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-newsletter">
      <table class="table table-bordered table-hover">
        <tr>
          <td><span class="required"></span> <?php echo $entry_name; ?></td>
          <td><input class="form-control" type="text" name="email_name" value="<?php echo isset($email_name)?$email_name:""; ?>" />
            </td>
        </tr>
        <tr>
          <td valign="top" style="padding-top:20px;"><span class="required">*</span> <?php echo $entry_code; ?></td>
          <td>
          <input class="form-control" type="text" name="email_id" id="email_id" value="<?php echo isset($email_id)?$email_id:''; ?>" >
          </textarea> 
          	<?php if (isset($error_email_name)) { ?>
            <span class="error"><?php echo $error_email_name; ?></span>
            <?php  } ?>
			<?php if (isset($error_email_exist)) { ?>
            <span class="error"><?php echo $error_email_exist; ?></span>
            <?php  } ?>
            
            </td>
        </tr>
      </table>
    </form>
  </div>
  </div>
  </div>
</div>
<?php echo $footer; ?>

