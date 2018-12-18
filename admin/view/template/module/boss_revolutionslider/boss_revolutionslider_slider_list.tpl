<?php require_once(DIR_SYSTEM . 'library/btform.php'); $btform = new Btform(); global $loader; ?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
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
		<?php if ($success) { ?>
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i><?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-sliderlist" class="form-horizontal">
					<h3 class="bt-heading">Slides List</h3>
					<div id="success" class="alert alert-success"> </div>
					<table class="table table-striped table-bordered table-hover" id="bt_slide_list">
						<thead>
							<tr>
								<td width="50px">#id</td>
								<td width="20%px">Name</td>
								<td width="100px">Status</td>
								<td width="300px">Background</td>
								<td width="25%">Action</td>
								<td width="100px"></td>
							</tr>
						</thead>
						<tbody class="ui-sortable">
							<?php if(!empty($slides)){ ?>
							<?php foreach($slides as $slide){ ?>
							<tr id="slideorder_<?php echo $slide['slide_id'] ?>">
								<td><?php echo $slide['slide_id']; ?></td>
								<td>Slider (<?php echo isset($slide['slideset']['background'])?$slide['slideset']['background']:'';?>)</td>
								<td><?php echo ($slide['status'])?'Enable':'Disable'; ?></td>
								<td><?php if($slide['slideset']['type_background'] =='color_bg'){ ?><img style="border: 1px solid #ddd; width:250px;height:100px; background:<?php echo $slide['slideset']['background']; ?>" src="../image/catalog/transparent.png" alt="slider1.png" /><?php }else{ ?><img style="border: 1px solid #ddd; width:250px;height:100px;" src="<?php echo isset($slide['slideset']['background'])?'../image/'.$slide['slideset']['background']:'../image/transparent.png'; ?>" alt="slider1.png" /><?php } ?></td>
								<td><p><a class="btn btn-primary" href="<?php echo $slide['edit_link']; ?>" >Edit</a> <a class="btn btn-danger " onclick="deleteSlide(<?php echo $slide['slide_id']; ?>,<?php echo $slide['slider_id']; ?>,<?php echo $slide['module_id']; ?>);" >Delete</a> <a class="btn btn-default " onclick="copySlide(<?php echo $slide['slide_id']; ?>,<?php echo $slide['slider_id']; ?>,<?php echo $slide['module_id']; ?>);" >Copy</a> </p></td>
								<td><div class="bt-drag"><span class="bt-icon ui-icon ui-icon-arrowthick-2-n-s">&nbsp;</span></div></td>
							</tr>
							<?php } ?>
							<?php }else{ ?>
								<tr><td colspan="6"><?php echo 'No slide'; ?></td></tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="bt-button bt-right">
						<p><a class="btn btn-warning" href="<?php echo $modulesetting; ?>" >Slider Setting</a> <a class="btn btn-success " href="<?php echo $new_slide; ?>" >Add New Slide</a></p>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function(){ 

    $("#success").hide();
	
	$(function() {
		$("#bt_slide_list tbody").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&update=update'; 
			$.post("index.php?route=module/boss_revolutionslider/updateSortSlide&token=<?php echo $token; ?>", order, function(theResponse){
				$("#success").html(theResponse);
				$("#success").slideDown('slow');
				slideout();
			});
		}});
		
	});

});

function slideout(){
	setTimeout(function(){
		$("#success").slideUp("slow", function () {});

	}, 3000);
}

function deleteSlide(id,slider_id,module_id){
	if (!confirm('<?php echo $text_confirm; ?>')) {
		return false;
	}else{
		$.ajax({
			url: 'index.php?route=module/boss_revolutionslider/deleteSlide&token=<?php echo $token; ?>&slide_id='+id+'&slider_id='+slider_id+'&module_id='+module_id,
			async:false,
			type: 'post',
			dataType: 'json',
			success: function(json) {
				location = json['redirect'];
			}
		});
	}
}

function copySlide(id,slider_id,module_id){
	$.ajax({
		url: 'index.php?route=module/boss_revolutionslider/copySlide&token=<?php echo $token; ?>&slide_id='+id+'&slider_id='+slider_id+'&module_id='+module_id,
		async:false,
		type: 'post',
		dataType: 'json',
		success: function(json) {
			location = json['redirect'];
		}
	});
}
//--></script>
<?php echo $footer; ?>