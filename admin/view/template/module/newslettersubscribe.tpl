<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<button type="submit" form="form-newslettersubscribe" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
			<form id="form-newslettersubscribe" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-featured" class="form-horizontal">
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
				<div>
					<table class="table table-striped table-bordered table-hover">
						<tr>
						  <td><label class="control-label"><?php echo $entry_title; ?></label></td>
						  <td><table class="table table-striped table-bordered table-hover"><?php foreach ($languages as $language) { ?>
							<tr><td><input class="form-control" size=50 name="title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($title[$language['language_id']]) ? $title[$language['language_id']] : ''; ?>" /></td><td>
							<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>
						   <?php } ?>
						   </table></td>
						</tr>
					</table>
				</div> 

				<div>
					<table class="table table-striped table-bordered table-hover">
						<tr>
						  <td><label class="control-label"><?php echo $entry_desc; ?></label></td>
						  <td><table class="table table-striped table-bordered table-hover"><?php foreach ($languages as $language) { ?>
							<tr><td><input class="form-control" size=50 name="sub_title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($sub_title[$language['language_id']]) ? $sub_title[$language['language_id']] : ''; ?>" /></td><td>
							<img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>
						   <?php } ?>
						   </table></td>
						</tr>
					</table>
				</div> 
				<table class="bt-form table table-striped table-bordered table-hover">
				<tr>
				  <td><label class="control-label"><?php echo $entry_unsubscribe; ?></label></td>
				  <td><select class="form-control" name="option_unsubscribe">
					  <?php if ($option_unsubscribe) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				<tr>
				  <td><label class="control-label"><?php echo $entry_mail; ?></label> </td>
				  <td><select class="form-control" name="newslettersubscribe_mail_status">
					  <?php if ($newslettersubscribe_mail_status) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select> </td>
				</tr>
				<tr>
				  <td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="Disable/Enable button scroll to top" class="help"><?php echo $entry_registered; ?></span></label></td>
				  <td><select class="form-control" name="newslettersubscribe_registered">
					  <?php if ($newslettersubscribe_registered) { ?>
					  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					  <option value="0"><?php echo $text_disabled; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $text_enabled; ?></option>
					  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					  <?php } ?>
					</select></td>
				</tr>
				
			  </table>
			</form>
		  </div>
		</div>
	</div>
</div>
<?php echo $footer; ?>