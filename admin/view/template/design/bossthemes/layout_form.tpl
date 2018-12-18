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
		
		<div class="message"></div>
		<div class="panel panel-default">
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-buildlayout" class="form-horizontal">
					<input type="hidden" name="layout_id" value="<?php echo $layout_id;?>" />
			
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-name"><?php echo $entry_layout; ?></label>
						<div class="col-sm-4">
						  <select type="text" name="change_layouts" id="change_layouts" class="form-control" onchange="window.location.href=this.options [this.selectedIndex].value">
						  <?php foreach($layouts as $layout){?>
						  <option value="<?php echo $layout['edit'];?>" <?php if($layout['layout_id']==$layout_id){?>selected="selected"<?php } ?>><?php echo $layout['name'];?> </option>
						  <?php } ?> 
						  </select>
						</div>
						<div class="col-sm-3">
						<a onclick="Layout.apply()" class="btn btn-success pull-right">Save Setting</a>
						</div>
					</div>
         
                  
				   <div class="row layout-builder" id="layout-builder">
					
					<div class="col-md-3 col-sm-5 hidden-xs pull-right">
					<div class="block_relative">
						<div id="module_list" class="module_list" data-text-confirm="<?php echo $text_confirm;?>" data-text-edit="<?php echo $text_edit_module;?>">   
						
							<div class="heading-bar"><?php echo $text_module_list;?>
								<div class="btn-group pull-right">
									<a class="btn" href="<?php echo $repair; ?>" data-toggle="tooltip" title="<?php echo 'Refresh Installed Modules'; ?>"><i class="fa fa-refresh"></i></a>
									<a class="btn" href="<?php echo $module_manager; ?>" data-toggle="tooltip" title="<?php echo $text_all_module; ?>" target="_blank"><i class="fa fa-external-link"></i></a>
								</div>
							</div>
							
							<div class="bt-module-accordion bt-accordion">
								<?php foreach ($modules as $module) { ?>
								<div class="ds_heading"><?php echo strip_tags($module['name']); ?>
									<div class="btn-group"><a class="btn btn-xs btn-edit" href="<?php echo $module['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($module['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a></div>
								</div>
								
								<div class="ds_content bt-drag">
									<?php foreach ($module['module'] as $module) { ?>       
										<div class="module-block" data-code="<?php echo $module['code']; ?>">
											<i class="fa fa-puzzle-piece bt-enable"></i> <?php echo strip_tags($module['name']); ?>    
											<a class="btn btn-sm btn-edit" href="<?php echo $module['edit']; ?>"><i class="fa fa-edit" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"></i></a>   
										</div>                 
									<?php } ?>    
								</div><!--ds_content --> 
								
								<?php } ?>                
							</div><!--//ds_accordion --> 
							
						</div><!--//module_list --> 
						
					</div><!--//block_relative --> 
					
					</div><!--//col-md-3 --> 
          
					<div class="col-md-9  col-sm-7">
						<div class="bt-layout-content">
							<div class="container-fluid">
								<div class="row colsliders">
									<div class="col-md-12 position">
										<div class="bt-header fill_bg">
										<span><?php echo $text_header;?></span>
										</div>
									</div>
								</div>
								<div class="row colsliders bt-slideshow">
									<div class="col-md-12 position">
										<div class="bt-header fill_bg">
										<span>Slideshow</span>
										</div>
									</div>
									<?php $module_row = 0; ?>
									<?php foreach ($layout_modules as $layout_module) { ?>
										<?php if ($layout_module['position'] == 'btslideshow') { ?>			
											<input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
											<input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="btslideshow">
											<input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
										
										<?php } ?>
										
									<?php $module_row++; ?>
									<?php } ?>
								</div>
  
								<div class="row colsliders"><div class="bt-wrap">
									<div class="col-md-3 position sidebar_column bt-left">
        
										<div class="dashed bt-placeholder" data-position="column_left" data-placeholder="<?php echo $text_column_left; ?>">
										<?php $module_row = 0; ?>
										<?php foreach ($layout_modules as $layout_module) { ?>
											<?php if ($layout_module['position'] == 'column_left') { ?>
											<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
												<div class="bt-module-label"><i class="fa fa-puzzle-piece bt-enable"></i> <?php echo $layout_module['name']; ?></div>              
												<div class="btn-group">
													<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>"><?php echo $text_edit_module; ?></a>
													<a class="btn btn-xs btn-remove" onclick="confirm('<?php echo addslashes($text_confirm); ?>')?$(this).parents('.mblock').remove():false;">Remove</a>
												</div>
												
												<input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
												<input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="column_left">
												<input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
											</div>
											<?php } ?>
											
										<?php $module_row++; ?>
										<?php } ?>
										
										</div>
										
									</div>
									
									<div class="col-md-6 bt-center"><div class="row">
										<div class="col-md-12 position column-content column-content-top">
											<div class="dashed bt-placeholder" data-position="content_top" data-placeholder="<?php echo $text_content_top; ?>">
												<?php $module_row = 0; ?>
												<?php foreach ($layout_modules as $layout_module) { ?>
													<?php if ($layout_module['position'] == 'content_top') { ?>
													<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
														<div class="bt-module-label"><i class="fa fa-puzzle-piece bt-enable"></i> <?php echo $layout_module['name']; ?></div> <div class="btn-group">
															<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>"><?php echo $text_edit_module; ?></a>
															<a class="btn btn-xs btn-remove" onclick="confirm('<?php echo addslashes($text_confirm); ?>')?$(this).parents('.mblock').remove():false;">Remove</a>
														</div>
													
														<input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">   
														<input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="content_top">
														<input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
													</div>
													<?php } ?>
													
												<?php $module_row++; ?>
												<?php } ?>
												</div>
												
										</div>
		
										<div class="col-md-12 position column-content">
										<div class="dashed bt-placeholder" data-position="content_bottom" data-placeholder="<?php echo $text_content_bottom; ?>">
											<?php $module_row = 0; ?>
											<?php foreach ($layout_modules as $layout_module) { ?>
												<?php if ($layout_module['position'] == 'content_bottom') { ?>
												<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
													<div class="bt-module-label"><i class="fa fa-puzzle-piece bt-enable"></i> <?php echo $layout_module['name']; ?></div>    <div class="btn-group">
														<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>"><?php echo $text_edit_module; ?></a>
														<a class="btn btn-xs btn-remove" onclick="confirm('<?php echo addslashes($text_confirm); ?>')?$(this).parents('.mblock').remove():false;">Remove</a>
													</div>
													
													<input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">  
													<input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="content_bottom">
													<input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
												</div>
												<?php } ?>
												
											<?php $module_row++; ?>
											<?php } ?>
        
										</div>
										
										</div>
									
									</div><!--//row --> </div>
									
									<div class="col-md-3 position sidebar_column bt-right">
										<div class="dashed bt-placeholder" data-position="column_right" data-placeholder="<?php echo $text_column_right; ?>">
											<?php $module_row = 0; ?>
											<?php foreach ($layout_modules as $layout_module) { ?>
												<?php if ($layout_module['position'] == 'column_right') { ?>
												<div class="mblock" data-code="<?php echo $layout_module['code'];?>">
													<div class="bt-module-label"><i class="fa fa-puzzle-piece bt-enable"></i> <?php echo $layout_module['name']; ?></div> 
													<div class="btn-group">
														<a class="btn btn-xs btn-edit" href="<?php echo $layout_module['href']; ?>"><?php echo $text_edit_module; ?></a>
														<a class="btn btn-xs btn-remove" onclick="confirm('<?php echo addslashes($text_confirm); ?>')?$(this).parents('.mblock').remove():false;">Remove</a>
													</div>
													
													<input type="hidden" name="layout_module[<?php echo $module_row; ?>][code]" value="<?php echo $layout_module['code']; ?>">   
													<input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" class="layout_position" value="column_right">
													<input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" class="sort">
												</div>
												<?php } ?>
												
											<?php $module_row++; ?>
											<?php } ?>
										</div>
										
									</div>
									
								</div></div><!--//row --> 
   
								<div class="row colsliders bt-footer">
									<div class="col-md-12 position">
										<div class="bt-header fill_bg">
											<span><?php echo $text_footer;?></span>
										</div>
										
									</div>
									
								</div>
    
							</div><!-- container-fluid--> 
							
						</div><!--//bt-layout-content --> 
						
					</div><!--//col --> 
          
				   </div><!--//row --> 
         
					<div id="data_index" data-index="<?php echo count($layout_modules);?>"></div>
				</form>
				
			</div>
			
		</div>
		
	</div>
	
</div>

<script type="text/javascript"><!--
	$(document).ready(function() {	
		Layout.init();
		$.lockfixed(".module_accordion",{offset: {top: 10, bottom: 200}});
	});
	if(typeof(console)=='undefined' || console==null) { console={}; console.log=function(){}}
//--></script>

<div id="module-modal" class="modal-box modal fade">
    <div class="modal-dialog modal-fw">
        <div class="modal-content">
            <div class="modal-body">
                <iframe id="modal-iframe" class="modal-iframe" frameborder="0" allowtransparency="true" seamless></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal"><?php echo $button_close;?></button>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>