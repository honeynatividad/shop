<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">
 <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
		<a href="<?php echo $insert; ?>" data-toggle="tooltip" title="<?php echo $button_insert; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
		<button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-testimonial-list').submit() : false;"><i class="fa fa-trash-o"></i></button>		
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
  <div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>  
  <?php } ?>
  <div class="panel panel-default">
    <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3> 	  
    </div>
  <div class="panel-body">
	<ul class="nav nav-tabs" id="module">
		<li class="active"><a href="<?php echo $module_testimonial_path; ?>"> <?php echo $text_module_testimonial; ?></a></li>
		<li><a href="<?php echo $module_settings_path; ?>"> <?php echo $text_module_settings; ?></a></li>									
	</ul>
    <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-testimonial-list" class="form-horizontal">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <td style="width:1px" style="align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>

            <td class="text-left"><?php if ($sort == 'td.description') { ?>
              <a href="<?php echo $sort_description; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_description; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_description; ?>"><?php echo $column_description; ?></a>
              <?php } ?></td>


            <td class="text-left"><?php if ($sort == 'td.title') { ?>
              <a href="<?php echo $sort_title; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_title; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_title; ?>"><?php echo $column_title; ?></a>
              <?php } ?></td>
            <td class="text-left"><?php if ($sort == 't.name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
            <td class="text-right"><?php if ($sort == 't.date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="text-right"><?php if ($sort == 't.status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
              <?php } ?></td>
            <td class="text-right"><?php echo $column_action; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($testimonials) { ?>
          <?php foreach ($testimonials as $testimonial) { ?>
          <tr>
            <td style="align: center;"><?php if ($testimonial['selected']) { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $testimonial['testimonial_id']; ?>" checked="checked" />
              <?php } else { ?>
              <input type="checkbox" name="selected[]" value="<?php echo $testimonial['testimonial_id']; ?>" />
              <?php } ?></td>
            <td class="text-left"><?php echo $testimonial['description']; ?></td>
            <td class="text-left"><?php echo $testimonial['title']; ?></td>
            <td class="text-left"><?php echo $testimonial['name']; ?></td>
            <td class="text-right"><?php echo $testimonial['date_added']; ?></td>
            <td class="text-right"><?php echo $testimonial['status']; ?></td>
            <td class="text-right"><?php foreach ($testimonial['action'] as $action) { ?>
              [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
              <?php } ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="text-center" colspan="7"><?php if ($testimonial_total!=-1) echo $text_no_results; else echo $entry_install_first; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </form>
    <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
  </div>
</div>
</div>
<?php echo $footer; ?>