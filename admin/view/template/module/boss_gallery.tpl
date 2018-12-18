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

<div class="panel panel-default">
	<div class="panel-heading">  		
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>
	</div>
	<div class="panel-body">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-boss-gallery" class="form-horizontal">
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
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_title; ?></label>
            <div class="col-sm-10">
				<?php foreach ($languages as $language) { ?>
					<div class="form-group">
					<div class="col-sm-11"><input name="boss_gallery_title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($boss_gallery_title[$language['language_id']]) ? $boss_gallery_title[$language['language_id']] : ''; ?>" class="form-control" /></div>
					<label class="col-sm-1 control-label"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></label>
					</div>
				<?php } ?>
            </div>
        </div>
		<div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control large">
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
		<table id="images" class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
			  <td class="text-right">#</td>
              <td class="left"><?php echo $entry_title; ?></td>
              <td class="left"><?php echo $entry_link; ?></td>
              <td class="left"><?php echo $entry_image; ?></td>
			  <td class="left"><?php echo $entry_class; ?></td>
              <td></td>
            </tr>
          </thead>
          
          <tbody class="boss_content">
		  <?php $image_row = 0; ?>
          <?php foreach ($boss_gallery_images as $boss_gallery_image) { ?>
            <tr id="image-row<?php echo $image_row; ?>">
			  <td class="text-right"><?php echo $image_row+1; ?></td>
              <td class="text-left">
				<table class="table table-striped table-bordered table-hover">
			  <?php foreach ($languages as $language) { ?>
                <tr><td><input type="text" name="boss_gallery_image[<?php echo $image_row; ?>][gallery_image_description][<?php echo $language['language_id']; ?>]" value="<?php echo isset($boss_gallery_image['gallery_image_description'][$language['language_id']]) ? $boss_gallery_image['gallery_image_description'][$language['language_id']] : ''; ?>" class="form-control" /></td>
                <td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>
                <?php if (isset($error_gallery_image[$image_row][$language['language_id']])) { ?>
                <div class="text-danger"><?php echo $error_gallery_image[$image_row][$language['language_id']]; ?></div>
                <?php } ?>
                <?php } ?></table></td>
              <td class="left"><input type="text" name="boss_gallery_image[<?php echo $image_row; ?>][link]" value="<?php echo isset($boss_gallery_image['link'])?$boss_gallery_image['link']:''; ?>" class="form-control" /></td>
              <td class="left"><div class="image">
				  <a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo isset($boss_gallery_image['thumb'])?$boss_gallery_image['thumb']:$placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="boss_gallery_image[<?php echo $image_row; ?>][image]" value="<?php echo isset($boss_gallery_image['image'])?$boss_gallery_image['image']:''; ?>" id="input-image<?php echo $image_row; ?>" />
                  </div></td>
			  <td class="left"><input type="text" name="boss_gallery_image[<?php echo $image_row; ?>][class]" value="<?php echo isset($boss_gallery_image['class'])?$boss_gallery_image['class']:''; ?>" class="form-control" /></td>              
			   <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
            </tr>
			<?php $image_row++; ?>
          <?php } ?>
          </tbody>
          
          <tfoot>
            <tr>
              <td colspan="5"></td>              
			   <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_add_banner; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
            </tr>
          </tfoot>
        </table>		        
      </form>
    </div>
  </div>
</div>
</div>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row+1; ?>;

function addImage() {
    
	html = '<tr id="image-row' + image_row + '">';
	html += '<td class="text-right">' + image_row + '</td>';
    html += '<td class="text-left">';
	html += '<table class="table table-striped table-bordered table-hover">';
	<?php foreach ($languages as $language) { ?>
	html += '<tr><td><input type="text" name="boss_gallery_image[' + image_row + '][gallery_image_description][<?php echo $language['language_id']; ?>]" class="form-control" value="" /></td> <td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>';
    <?php } ?>
	html += '</table></td>';	
	html += '<td class="text-left"><input type="text" name="boss_gallery_image[' + image_row + '][link]" value="" class="form-control" /></td>';	
	html += '<td class="text-left"><div class="image">';
	html += '<a href="" id="thumb-image' + image_row + '" data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>';
    html += '<input type="hidden" name="boss_gallery_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" />';
	
	html +'</div></td>';
	html +=' <td class="left"><input type="text" name="boss_gallery_image[' + image_row + '][class]" value="" class="form-control" /></td>';
	html += '    <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';		
	
	$('.boss_content').append(html);
	
	image_row++;
}
//--></script>

<?php echo $footer; ?>