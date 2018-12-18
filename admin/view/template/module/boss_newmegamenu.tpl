<?php require_once(DIR_SYSTEM . 'library/btform.php'); $btform = new Btform();?>
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
  <?php if (isset($error_warning)) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
  <?php if ($success) { ?>
	<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>
	<?php } ?>
  <div class="loading" style="position:fixed;top:50%;left:50%"></div>
  <div class="panel panel-default">
      <div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h3>          
    </div>
    <div class="panel-body">	
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-boss-megamenu" class="form-horizontal">		<div class="form-group">
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
				  <?php echo $btform -> makeSelectHTML($arrstatus, 'status','',isset($status) ? $status : ''); ?>
				</div>
			</div>	
			<?php if(isset($module_id) && $module_id) { ?>
			<ul class="nav nav-tabs" id="module">
				<li><a href="#menusetting" data-toggle="tab"><?php echo 'Menu Setting';?></a></li>
				<li><a href="#modulesetting" data-toggle="tab"><?php echo 'Module Setting';?></a></li>			
			</ul>
			<div class="tab-content">
            <div class="tab-pane active" id="menusetting">
				<div id="success" class="success"> </div>
				<ul class="ui-sortable" style="margin-left: -30px;">
					<?php if(!empty($menus)){ ?>
					<?php $item = 0;?>
					<?php foreach ($menus as $menu) { ?>
						<li id="menuorder_<?php echo $menu['menu_id'] ?>" class="parent">
							<div class="menu-title">
								<p class="bt-open"><strong><?php echo (!empty($menu['title']))?$menu['title']:$text_title_default; ?></strong></p>
								<p>Column: <?php echo $menu['num_column']; ?></p>
								<p>Link: <span <?php echo((strlen($menu['url']))>30)?'class="bthidden"':'' ;?>><?php echo $menu['url']; ?></span><?php if((strlen($menu['url']))>30){?><span class="box_hover"><?php echo $menu['url']; ?></span><?php } ?></p>
								<p>Label: <?php echo $menu['label']; ?></p>
								<p>Icon: <?php echo ($menu['icon_class_status'])?$menu['icon_class']:'<img src="'.$menu['icon'].'"'; ?></p>
								<div class="bt-quick-access">
									<span>Status: <strong><?php echo ($menu['status'])?'Enable':'Disable'; ?></strong> &nbsp;&nbsp;</span>
									<a onclick="addMenu('<?php echo $menu['menu_id'] ?>','<?php echo $module_id; ?>');"><i class="fa fa-pencil"></i></a>
									<i class="fa fa-minus-circle" onclick="deleteMenu('<?php echo $menu['menu_id'] ?>','<?php echo $module_id ?>');"></i>
								</div>
							</div>
							<div class="bt-sub-menu">
								<?php if(!empty($menu['menurow'])){ ?>
								<ul class="bt-menu-row" style="margin-left: -40px;">
									<?php $menurow = $menu['menurow']; ?>
									<?php foreach($menurow as $row){ ?>
										<li id="roworder_<?php echo $row['row_id'] ?>" class="sub-row">
											<div class="bt-sub-menu">
												<?php if(!empty($row['columns'])){ ?>
												<ul class="bt-menu-column" style="margin-left: -40px;">
													<?php $menucolumn = $row['columns']; ?>
													<?php foreach($menucolumn as $column){ ?>
													<li class="col-<?php echo $column['num_column']; ?>" id="columnorder_<?php echo $column['column_id'] ?>">
														<div class="column-desc">
															<p>Column: #<?php echo $column['column_id']; ?></p>
															<p>Status: <b><?php echo ($column['status'])?'Enable':'Disable'; ?></b></p>
															<p>Type: <?php echo $column['type']; ?></p>
															<p>Num Column: <?php echo $column['num_column']; ?></p>
														</div>
														<div class="bt-columnquick-access">
															<a onclick="addMenuColumn('<?php echo $row['row_id'] ?>','<?php echo $column['column_id'] ?>','<?php echo $module_id ?>');"><i class="fa fa-pencil"></i></a>
															
															<i class="fa fa-minus-circle" onclick="deleteMenuColumn('<?php echo $column['column_id'] ?>','<?php echo $module_id ?>');"></i>
															
														</div>
													</li>
													<?php } ?>
													<li id="rowid_<?php echo $column['row_id'] ?>" style="display:none;"></li>
												</ul>
												<?php } ?>
												<div class="bt-add" style="float: left;"><a onclick="addMenuColumn('<?php echo $row['row_id'] ?>','','<?php echo $module_id ?>');" class="btn btn-info"><?php echo $button_add_column; ?></a></div>
											</div>
											<div class="bt-rowquick-access">
												<span>Row: #<?php echo $row['row_id']; ?>&nbsp;&nbsp; Status: <strong><?php echo ($row['status'])?'Enable':'Disable'; ?></strong> &nbsp;&nbsp;</span>
												<a onclick="addMenuRow('<?php echo $menu['menu_id'] ?>','<?php echo $row['row_id'] ?>','<?php echo $module_id ?>');"><i class="fa fa-pencil"></i></a>
												<i class="fa fa-minus-circle" onclick="deleteMenuRow('<?php echo $row['row_id'] ?>','<?php echo $module_id ?>');"></i>
											</div>
										</li>
									<?php } ?>
									<li id="menuid_<?php echo $menu['menu_id'] ?>" style="display:none;"></li>
								</ul>
								<?php } ?>
								<div class="bt-add"><a onclick="addMenuRow('<?php echo $menu['menu_id'] ?>','','<?php echo $module_id ?>');" class="btn btn-success"><?php echo $button_add_row; ?></a></div>
							</div>
						</li>	
					<?php $item++;} ?>
					<?php } ?>
					<li><a onclick="addMenu('','<?php echo $module_id; ?>');" class="btn btn-primary"><?php echo $button_add_menu; ?></a></li>
				</ul>
				<div id="formdata" title="<?php echo $menu_form; ?>"></div>
			</div>
			
            <div class="tab-pane" id="modulesetting">
				<?php $module_row = 0;?>
				<table class="table table-striped table-bordered table-hover">
					<tr><td><?php echo $entry_menu_width; ?></td>
						<td><?php echo $btform -> textField('boss_newmegamenu_module[menu_width]',isset($module['menu_width']) ? $module['menu_width'] : '',3); ?></td></tr>
					<tr><td><?php echo $entry_num_column; ?></td>
						<td class="left"><?php echo $btform -> makeSelectHTML($arrcolumns, 'boss_newmegamenu_module[num_column]','',isset($module['num_column']) ? $module['num_column'] : ''); ?></td></tr>
					
						 <input type="hidden" name="boss_newmegamenu_module[module_id]" value="<?php echo isset($module_id) ? $module_id : ''?>" />
				</table>
			</div>
			</div>	
			<?php }else{ ?>
				<input type="hidden" name="boss_newmegamenu_module[menu_width]" value="" />
				<input type="hidden" name="boss_newmegamenu_module[num_column]" value="1" />
			<?php } ?>
		</form>
    </div>
  </div>
</div>
</div>

<script type="text/javascript"><!--
$('#module li:first-child a').tab('show');
$(document).ready(function(){ 
	
	$('#menusetting > ul li.parent p ').click(function(){
		$(this).parent().parent().toggleClass('openMenu');
	});
	
    $("#success").hide();
	
	$(function() {
		$("#menusetting ul").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&update=update'; 
			$.post("index.php?route=module/boss_newmegamenu/updateSortMenu&token=<?php echo $token; ?>", order, function(theResponse){
				$("#success").html(theResponse);
				$("#success").slideDown('slow');
				slideout();
			});
		}});
		
		$("#menusetting ul ul.bt-menu-row").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			var roworder = $(this).sortable("serialize") + '&update=update'; 
			$.post("index.php?route=module/boss_newmegamenu/updateSortRow&token=<?php echo $token; ?>", roworder, function(theResponse){
				$("#success").html(theResponse);
				$("#success").slideDown('slow');
				slideout();
			});
		}});
		
		$("#menusetting ul ul.bt-menu-column").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			var columnorder = $(this).sortable("serialize") + '&update=update'; 
			$.post("index.php?route=module/boss_newmegamenu/updateSortColumn&token=<?php echo $token; ?>", columnorder, function(theResponse){
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

function addMenu(id,module_id){	
	$.ajax({
		url: 'index.php?route=module/boss_newmegamenu/addMenu&token=<?php echo $token; ?>&module_id='+module_id+'&menu_id='+id,		
		dataType: 'json',
		beforeSend: function() {
			$('.loading').html('<span class="wait">&nbsp;<img src="../admin/view/image/loading.gif" alt="" /></span>');
		},		
		complete: function() {
			$('.wait').remove();
			
		},
		
		success: function(json) { 
			if (json['output']) {		
				$( "#formdata" ).html(json['output']);
				$( "#formdata" ).dialog({ 					
					width: 790 , 
					buttons:[{ text: "Save",
								click: function() {saveMenu(id,module_id);}
							 },
							 {  text: "Cancel",
								click: function() { $(this).dialog("close");}
							}]
				});	
				$( ".ui-dialog" ).css({'z-index': '1050', });
			}
		}
	});
}

function addMenuRow(menu_id,row_id,module_id){
	$.ajax({
		url: 'index.php?route=module/boss_newmegamenu/addMenuRow&token=<?php echo $token; ?>&module_id='+module_id+'&row_id='+row_id,
		dataType: 'json',
		beforeSend: function() {
			$('.loading').html('<span class="wait">&nbsp;<img src="../admin/view/image/loading.gif" alt="" /></span>');
		},		
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) {
			if (json['output']) {		
				$( "#formdata" ).html(json['output']);
				var initLayout = function() {
					$('#colorSelector').ColorPicker({
						onSubmit: function(hsb, hex, rgb, el) {
							$(el).val(hex);
							$(el).ColorPickerHide();
						},
						onBeforeShow: function () {
							$(this).ColorPickerSetColor(this.value);
						}
					})
					.bind('keyup', function(){
						$(this).ColorPickerSetColor(this.value);
					});
				};
				EYE.register(initLayout, 'init');
				
				$( "#formdata" ).dialog({ 
					width: 790 , 
					buttons:[{ text: "Save",
								click: function() {saveMenuRow(menu_id,row_id,module_id);}
							 },
							 {  text: "Cancel",
								click: function() { $(this).dialog("close");}
							}]
				});
			}
		}
	});
}

function addMenuColumn(row_id,column_id,module_id){
	$.ajax({
		url: 'index.php?route=module/boss_newmegamenu/addMenuColumn&token=<?php echo $token; ?>&module_id='+module_id+'&column_id='+column_id+'&row_id='+row_id,
		dataType: 'json',
		beforeSend: function() {
			$('.loading').html('<span class="wait">&nbsp;<img src="../admin/view/image/loading.gif" alt="" /></span>');
		},		
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) { 
			if (json['output']) {		
				$( "#formdata" ).html(json['output']);
				<?php foreach ($languages as $language) { ?>
				var element = '#input-description<?php echo $language['language_id']; ?>';
				$(element).summernote({
					disableDragAndDrop: true,
					height: 300,
					toolbar: [
						['style', ['style']],
						['font', ['bold', 'underline', 'clear']],
						['fontname', ['fontname']],
						['color', ['color']],
						['para', ['ul', 'ol', 'paragraph']],
						['table', ['table']],
						['insert', ['link', 'image', 'video']],
						['view', ['fullscreen', 'codeview', 'help']]
					],
					buttons: {
						image: function() {
							var ui = $.summernote.ui;

							// create button
							var button = ui.button({
								contents: '<i class="fa fa-image" />',
								tooltip: $.summernote.lang[$.summernote.options.lang].image.image,
								click: function () {
									$('#modal-image').remove();
								
									$.ajax({
										url: 'index.php?route=common/filemanager&token=' + getURLVar('token'),
										dataType: 'html',
										beforeSend: function() {
											$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
											$('#button-image').prop('disabled', true);
										},
										complete: function() {
											$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
											$('#button-image').prop('disabled', false);
										},
										success: function(html) {
											$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
											
											$('#modal-image').modal('show');
											
											$('#modal-image').delegate('a.thumbnail', 'click', function(e) {
												e.preventDefault();
												
												$(element).summernote('insertImage', $(this).attr('href'));
																			
												$('#modal-image').modal('hide');
											});
										}
									});						
								}
							});
						
							return button.render();
						}
					}
				});
				<?php } ?>
				$( "#formdata" ).dialog({ 
					width: 790 , 
					buttons:[{ text: "Save",
								click: function() {saveMenuColumn(row_id,column_id,module_id);}
							 },
							 {  text: "Cancel",
								click: function() { $(this).dialog("close");}
							}]
				});
				$( ".ui-dialog" ).css({'z-index': '1050', });	
			}
		}
	});
}

function saveMenu(id,module_id){
	$.ajax({
		url: 'index.php?route=module/boss_newmegamenu/saveMenu&token=<?php echo $token; ?>&module_id='+module_id+'&menu_id='+id,
		type: 'post',
		data: $('#btnewmenu input[type=\'text\'], #btnewmenu input[type=\'hidden\'], #btnewmenu select'),
		dataType: 'json',
		success: function(json) {
			$( "#formdata" ).dialog("close");
			location = json['redirect'];
			
		}
	});
}

function saveMenuRow(menu_id,row_id,module_id){
	$.ajax({
		url: 'index.php?route=module/boss_newmegamenu/saveMenuRow&token=<?php echo $token; ?>&module_id='+module_id+'&menu_id='+menu_id+'&row_id='+row_id,
		type: 'post',
		data: $('#btnewmenurow input[type=\'text\'], #btnewmenurow input[type=\'hidden\'], #btnewmenurow select'),
		dataType: 'json',
		success: function(json) {
			$( "#formdata" ).dialog("close");
			location = json['redirect'];
			
		}
	});
}

function saveMenuColumn(row_id,column_id,module_id){
	$.ajax({
		url: 'index.php?route=module/boss_newmegamenu/saveMenuColumn&token=<?php echo $token; ?>&module_id='+module_id+'&row_id='+row_id+'&column_id='+column_id,
		type: 'post',
		data: $('#btnewmenucolumn input[type=\'text\'], #btnewmenucolumn input[type=\'checkbox\']:checked,#btnewmenucolumn textarea, #btnewmenucolumn input[type=\'radio\']:checked, #btnewmenucolumn input[type=\'hidden\'], #btnewmenucolumn select'),
		dataType: 'json',
		success: function(json) { //alert(json['test']['content_text'][1]);
			$( "#formdata" ).dialog("close");
			location = json['redirect'];
			
		}
	});
}

function deleteMenu(id,module_id){
	if (!confirm('<?php echo $text_confirm; ?>')) {
		return false;
	}else{
		$.ajax({
			url: 'index.php?route=module/boss_newmegamenu/deleteMenu&token=<?php echo $token; ?>&module_id='+module_id+'&menu_id='+id,
			async:false,
			type: 'post',
			dataType: 'json',
			success: function(json) {
				location = json['redirect'];
			}
		});
	}
}

function deleteMenuRow(id,module_id){
	if (!confirm('<?php echo $text_confirm; ?>')) {
		return false;
	}else{
		$.ajax({
			url: 'index.php?route=module/boss_newmegamenu/deleteMenuRow&token=<?php echo $token; ?>&module_id='+module_id+'&row_id='+id,
			async:false,
			type: 'post',
			dataType: 'json',
			success: function(json) {
				location = json['redirect'];
			}
		});
	}
}

function deleteMenuColumn(id,module_id){
	if (!confirm('<?php echo $text_confirm; ?>')) {
		return false;
	}else{
		$.ajax({
			url: 'index.php?route=module/boss_newmegamenu/deleteMenuColumn&token=<?php echo $token; ?>&module_id='+module_id+'&column_id='+id,
			async:false,
			type: 'post',
			dataType: 'json',
			success: function(json) {
				location = json['redirect'];
			}
		});
	}
}
//--></script> 

<?php echo $footer; ?>