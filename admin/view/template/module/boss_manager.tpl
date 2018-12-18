<?php require_once(DIR_SYSTEM . 'library/btform.php');?>
<?php 
$btform = new Btform();
?>
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
		<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $success; ?>
			<button type="button" class="close" data-dismiss="alert">&times;</button>
		</div>
		<?php } ?>
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			
			<div class="panel-body">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-manufacturer" class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
						<div class="col-sm-10">
						  <select name="boss_manager[status]" id="input-status" class="form-control">
							<?php if (isset($status) && $status) { ?>
							<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
							<option value="0"><?php echo $text_disabled; ?></option>
							<?php } else { ?>
							<option value="1"><?php echo $text_enabled; ?></option>
							<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
							<?php } ?>
						  </select>
						</div>
					</div>
					
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#optionsetting"><?php echo 'Option Setting'; ?></a></li>
						<li><a data-toggle="tab" href="#layoutsetting"><?php echo 'Layout Setting'; ?></a></li>
						<li><a data-toggle="tab" href="#headersetting"><?php echo 'Header Setting'; ?></a></li>
						<li><a data-toggle="tab" href="#footersetting"><?php echo 'Footer Setting'; ?></a></li>
						<li><a data-toggle="tab" href="#colorsetting"><?php echo 'Color Setting'; ?></a></li>
						<li><a data-toggle="tab" href="#fontsetting"><?php echo 'Font Setting'; ?></a></li>
						<li><a data-toggle="tab" href="#othersetting"><?php echo 'Other Setting'; ?></a></li>
						<li><a data-toggle="tab" href="#sampledata"><?php echo 'Sample Data'; ?></a></li>	
					</ul>
					
					<div class="tab-content">						
						<!-- #option setting-->
						<div id="optionsetting" class="tab-pane active">
							<table class="table table-striped table-bordered table-hover">
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="Disable/Enable button scroll to top" class="help"><?php echo 'Display button scroll top:'; ?></span></label></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrstatus, 'boss_manager[option][bt_scroll_top]','',isset($option['bt_scroll_top']) ? $option['bt_scroll_top'] : false); ?></td></tr>
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="Disable/Enable navigation menu sticky on the page top when the header goes out of display area" class="help"><?php echo 'Display sitcky menu:'; ?></span></label></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrstatus, 'boss_manager[option][sticky_menu]','',isset($option['sticky_menu']) ? $option['sticky_menu'] : false); ?></td></tr>
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="Disable/Enable loading site when start." class="help"><?php echo 'Display loading page:'; ?></span></label></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrloading, 'boss_manager[option][loading]','',isset($option['loading']) ? $option['loading'] : false); ?></td></tr>
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="User Default menu of opencart or the menu of Bossthemes" class="help"><?php echo 'Show Menu:'; ?></span></label></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrusemenu, 'boss_manager[option][use_menu]','',isset($option['use_menu']) ? $option['use_menu'] : false); ?></td></tr>
								
								<tr><td><label class="control-label"><span data-toggle="tooltip" title="" data-original-title="Disable/Enable all the animations when load page" class="help"><?php echo 'Animation:'; ?></span></label></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrstatus, 'boss_manager[option][animation]','',isset($option['animation']) ? $option['animation'] : false); ?></td></tr>
							</table>
						</div>
						<!-- End #option setting-->
						
						<!-- #option setting-->
						<div id="layoutsetting" class="tab-pane">
							<table class="table table-striped table-bordered table-hover">
							<tr><td><?php echo 'Mode css:'; ?></td>
							<td class="left"><table class="table table-striped table-bordered table-hover">
								<tr><td colspan="4"><?php echo $btform -> radioField('boss_manager[layout][mode_css]','wide',isset($layout['mode_css'])?$layout['mode_css']:'','Wide'); ?></td></tr>
								<tr><td>
								<?php echo $btform -> radioField('boss_manager[layout][mode_css]','boxed',isset($layout['mode_css'])?$layout['mode_css']:'','Boxed'); ?></td><td> - Box Width: </td><td><?php echo $btform -> textField('boss_manager[layout][box_width]',isset($layout['box_width']) ? $layout['box_width'] : '1200',10); ?></td><td>px</td></tr></table>
							</td>
							</tr>
							</table>
						</div>
						<!-- End #option setting-->
						
						<!-- #option setting-->
						<div id="headersetting" class="tab-pane">
							<div class="col-sm-2">
							<ul class="nav nav-pills nav-stacked" id="btfooter">
								<li class="active"><a href="#tab_header_layout" data-toggle="tab" ><?php echo 'Header Layout'; ?></a></li>
								<li><a href="#tab_header_link" data-toggle="tab" ><?php echo 'Link Default'; ?></a></li>								
							</ul>
							</div>
							<div class="col-sm-10">
							 <div class="tab-content">
								<div id="tab_header_layout" class="tab-pane active">
									<table class="table table-striped table-bordered table-hover">
									<tr><td><?php echo 'Header Mode css:'; ?></td>
									<td class="left"><table class="table table-striped table-bordered table-hover">
										<tr><td colspan="4"><?php echo $btform -> radioField('boss_manager[layout][h_mode_css]','inherit',isset($layout['h_mode_css'])?$layout['h_mode_css']:'','Inherit'); ?></td></tr>
										<tr><td>
										<?php echo $btform -> radioField('boss_manager[layout][h_mode_css]','boxed',isset($layout['h_mode_css'])?$layout['h_mode_css']:'','Boxed'); ?></td><td> - Box Width: </td><td><?php echo $btform -> textField('boss_manager[layout][h_box_width]',isset($layout['h_box_width']) ? $layout['h_box_width'] : '1200',10); ?></td><td>px</td></tr></table>
									</td>
									</tr>
									</table>
								</div>
								<div id="tab_header_link" class="tab-pane">
									<div class="form-group">
										<label class="col-sm-2 control-label">Language</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['language']) && $boss_manager['header_link']['language'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][language]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][language]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][language]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][language]" value="0"> No </label>
											
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Currency</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['currency']) && $boss_manager['header_link']['currency'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][currency]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][currency]" value="0" checked="checked"> No </label>
											
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][currency]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][currency]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Phone</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['phone']) && $boss_manager['header_link']['phone'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][phone]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][phone]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][phone]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][phone]" value="0"> No </label>
											
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">My Account</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['my_account']) && $boss_manager['header_link']['my_account'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][my_account]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][my_account]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][my_account]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][my_account]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Wishlist</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['wishlist']) && $boss_manager['header_link']['wishlist'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][wishlist]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][wishlist]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][wishlist]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][wishlist]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Shopping Cart</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['shopping_cart']) && $boss_manager['header_link']['shopping_cart'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][shopping_cart]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][shopping_cart]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][shopping_cart]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][shopping_cart]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Checkout</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['checkout']) && $boss_manager['header_link']['checkout'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][checkout]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][checkout]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][checkout]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][checkout]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Logo</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['logo']) && $boss_manager['header_link']['logo'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][logo]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][logo]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][logo]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][logo]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Search</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['search']) && $boss_manager['header_link']['search'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][search]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][search]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][search]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][search]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Cart Mini</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['header_link']['cart_mini']) && $boss_manager['header_link']['cart_mini'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][cart_mini]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][cart_mini]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][cart_mini]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[header_link][cart_mini]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
								</div>
							 </div>
							</div>
							
						</div>
						<!-- End #option setting-->
						
						<!-- #option setting-->
						<div id="footersetting" class="tab-pane">
							<div class="col-sm-2">
							<ul class="nav nav-pills nav-stacked" id="btfooter">
								<li class="active"><a href="#tab_footer_mode" data-toggle="tab" ><?php echo 'Layout'; ?></a></li>
								<li><a href="#tab_free_shipping" data-toggle="tab" ><?php echo 'Free Shipping'; ?></a></li>
								<li><a href="#tab_footer_1" data-toggle="tab" ><?php echo 'About us'; ?></a></li>
								<li><a href="#tab_footer_2" data-toggle="tab"><?php echo 'Contact us'; ?></a></li>
								<li><a href="#tab_footer_7" data-toggle="tab"><?php echo 'Follow us'; ?></a></li>
								<li><a href="#tab_footer_5" data-toggle="tab"><?php echo 'Payment link'; ?></a></li>
								<li><a href="#tab_footer_6" data-toggle="tab"><?php echo 'Powered by'; ?></a></li>
								<li><a href="#tab_footer_link" data-toggle="tab"><?php echo 'Link Default'; ?></a></li>
							</ul>
							</div>
							<div class="col-sm-10">
							 <div class="tab-content">
								<div id="tab_footer_mode" class="tab-pane active">
									<table class="table table-striped table-bordered table-hover">
									<tr><td><?php echo 'Footer Mode css:'; ?></td>
									<td class="left"><table class="table table-striped table-bordered table-hover">
										<tr><td colspan="4"><?php echo $btform -> radioField('boss_manager[layout][f_mode_css]','inherit',isset($layout['f_mode_css'])?$layout['f_mode_css']:'','Inherit'); ?></td></tr>
										<tr><td>
										<?php echo $btform -> radioField('boss_manager[layout][f_mode_css]','fboxed',isset($layout['f_mode_css'])?$layout['f_mode_css']:'','Boxed'); ?></td><td> - Box Width: </td><td><?php echo $btform -> textField('boss_manager[layout][f_box_width]',isset($layout['f_box_width']) ? $layout['f_box_width'] : '1200',10); ?></td><td>px</td></tr></table>
									</td>
									</tr>
									</table>
								</div>
								
								<div id="tab_free_shipping" class="tab-pane">
									<table class="table table-striped table-bordered table-hover">
										<tr>
											<td><?php echo 'Status:'; ?></td>
											<td><select class="form-control" name="boss_manager_footer_shipping[status]">
												<?php if (isset($footer_shipping['status']) && $footer_shipping['status']) { ?>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
													<option value="1"><?php echo $text_enabled; ?></option>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
											</select></td>
										</tr>
									</table>
									<ul id="shipping_language" class="nav nav-tabs">
										<?php foreach ($languages as $language) { ?>
										<li><a data-toggle="tab" href="#tab-free-shipping-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
									<?php foreach ($languages as $language) { ?>
									<div id="tab-free-shipping-<?php echo $language['language_id']; ?>" class="tab-pane">
										<table class="form">
										<tbody>
											<tr>
												<td><?php echo 'Title:'; ?></td>
												<td>
													<input class="form-control" type="text" name="boss_manager_footer_contact[contact_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($footer_shipping['contact_title'][$language['language_id']])?$footer_shipping['contact_title'][$language['language_id']]:''; ?>">
												</td>
											</tr>
											<tr>
												<td><?php echo 'Content:'; ?></td>
												<td><textarea class="form-control" name="boss_manager_footer_shipping[contact_content][<?php echo $language['language_id']; ?>]" id="bt_shipping_content<?php echo $language['language_id']; ?>" rows="10" cols="50" ><?php echo isset($footer_shipping['contact_content'][$language['language_id']])?$footer_shipping['contact_content'][$language['language_id']]:''; ?></textarea></td>
											</tr>
										</tbody>
										</table>
									</div>
									<?php } ?></div>
								</div>
								
								
								<div id="tab_footer_1" class="tab-pane">
									<table class="table table-striped table-bordered table-hover">
										<tr>
											<td><?php echo 'Status:'; ?></td>
											<td><select class="form-control" name="boss_manager_footer_about[status]">
												<?php if (isset($footer_about['status']) && $footer_about['status']) { ?>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
													<option value="1"><?php echo $text_enabled; ?></option>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
											</select></td>
										</tr>
										<tr>
											<td><?php echo 'Image'; ?></td>
											<td><select class="form-control" name="boss_manager_footer_about[image_status]">
												<?php if (isset($footer_about['image_status']) && $footer_about['image_status']) { ?>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
													<option value="1"><?php echo $text_enabled; ?></option>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
											</select><br /><br />
											<a href="" id="thumb-aboutimage" data-toggle="image" class="img-thumbnail"><img src="<?php echo $about_image; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
											<input type="hidden" name="boss_manager_footer_about[image_link]" value="<?php echo isset($footer_about['image_link'])?$footer_about['image_link']:''; ?>" id="input-aboutimage" />
											</td>	
										</tr>
										<tr>
											<td><?php echo 'Image Link'; ?></td>
											<td>
												<input class="form-control" type="text" name="boss_manager_footer_about[image_url]" value="<?php echo isset($footer_about['image_url'])?$footer_about['image_url']:'#'; ?>" />
											</td>
										</tr>
									</table>
									<ul id="about_language" class="nav nav-tabs">
										<?php foreach ($languages as $language) { ?>
										<li><a data-toggle="tab" href="#tab-aboutus-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									
									<div class="tab-content">
									<?php foreach ($languages as $language) { ?>
									<div id="tab-aboutus-<?php echo $language['language_id']; ?>" class="tab-pane">
										<table class="table table-striped table-bordered table-hover">
										<tbody>
											<tr>
												<td><?php echo 'About Store Title:'; ?></td>
												<td>
													<input type="text" name="boss_manager_footer_about[about_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($footer_about['about_title'][$language['language_id']])?$footer_about['about_title'][$language['language_id']]:'About Us Title'; ?>" class="form-control">
												</td>
											</tr>
											<tr>
												<td><?php echo 'About Store Content:'; ?></td>
												<td><textarea name="boss_manager_footer_about[about_content][<?php echo $language['language_id']; ?>]" id="bt_about_content<?php echo $language['language_id']; ?>" rows="10" cols="50" ><?php echo isset($footer_about['about_content'][$language['language_id']])?$footer_about['about_content'][$language['language_id']]:''; ?></textarea></td>
											</tr>
										</tbody>
										</table>
									</div>
									<?php } ?></div>
								</div>
								
								<div id="tab_footer_2" class="tab-pane">
									<table class="table table-striped table-bordered table-hover">
										<tr>
											<td><?php echo 'Status:'; ?></td>
											<td><select class="form-control" name="boss_manager_footer_contact[status]">
												<?php if (isset($footer_contact['status']) && $footer_contact['status']) { ?>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
													<option value="1"><?php echo $text_enabled; ?></option>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
											</select></td>
										</tr>
									</table>
									<ul id="contact_language123" class="nav nav-tabs">
										<?php foreach ($languages as $language) { ?>
										<li><a data-toggle="tab" href="#tab-contactus-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
									<?php foreach ($languages as $language) { ?>
									<div id="tab-contactus-<?php echo $language['language_id']; ?>" class="tab-pane">
										<table class="form">
										<tbody>
											<tr>
												<td><?php echo 'About Store Title:'; ?></td>
												<td>
													<input class="form-control" type="text" name="boss_manager_footer_contact[contact_title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($footer_contact['contact_title'][$language['language_id']])?$footer_contact['contact_title'][$language['language_id']]:'About Us Title'; ?>">
												</td>
											</tr>
											<tr>
												<td><?php echo 'About Store Content:'; ?></td>
												<td><textarea class="form-control" name="boss_manager_footer_contact[contact_content][<?php echo $language['language_id']; ?>]" id="bt_contact_content<?php echo $language['language_id']; ?>" rows="10" cols="50" ><?php echo isset($footer_contact['contact_content'][$language['language_id']])?$footer_contact['contact_content'][$language['language_id']]:''; ?></textarea></td>
											</tr>
										</tbody>
										</table>
									</div>
									<?php } ?></div>
								</div>
																
								<div id="tab_footer_7" class="tab-pane">
									<table class="table table-striped table-bordered table-hover">
										<tbody>
										<tr>
											<td><?php echo 'Social Status:'; ?></td>
											<td><select class="form-control" name="boss_manager_footer_social[status]">
												<?php if (isset($footer_social['status']) && $footer_social['status']) { ?>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
													<option value="1"><?php echo $text_enabled; ?></option>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
											</select></td>
										</tr>
										<tr>
											<td><?php echo 'Title:'; ?></td>
											<td><table class="table table-striped table-bordered table-hover">
											<?php foreach ($languages as $language) { ?><tr><td>
											<input class="form-control" size=50 type="text" name="boss_manager_footer_social[title][<?php echo $language['language_id']; ?>]" value="<?php echo isset($footer_social['title'][$language['language_id']])?$footer_social['title'][$language['language_id']]:''; ?>"/></td><td><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></td></tr>
											<?php } ?>
											</table></td>
										</tr>
										<tr>
											<td><?php echo 'Facebook'; ?></td>
											<td>
											<table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_social[face_status]" <?php echo (isset($footer_social['face_status'])&&$footer_social['face_status'])?'checked="checked"':'';?> /></td><td>
											
											Link:<input class="form-control" type="text" name="boss_manager_footer_social[face_url]" value="<?php echo isset($footer_social['face_url'])?$footer_social['face_url']:''; ?>"/>
											</td></tr></table>
											</td>
										</tr>
										
										<tr>
											<td><?php echo 'Pinterest'; ?></td>
											<td>
											<table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_social[pinterest_status]" <?php echo (isset($footer_social['pinterest_status'])&&$footer_social['pinterest_status'])?'checked="checked"':'';?> /></td><td>
											
											Link:<input class="form-control" type="text" name="boss_manager_footer_social[pinterest_url]" value="<?php echo isset($footer_social['pinterest_url'])?$footer_social['pinterest_url']:''; ?>"/>
											</td></tr></table>
											</td>
										</tr>
										<tr>
											<td><?php echo 'Twitter'; ?></td>
											<td>
											<table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_social[twitter_status]" <?php echo (isset($footer_social['twitter_status'])&&$footer_social['twitter_status'])?'checked="checked"':'';?> /></td><td>
											
											Link:<input class="form-control" type="text" name="boss_manager_footer_social[twitter_url]" value="<?php echo isset($footer_social['twitter_url'])?$footer_social['twitter_url']:''; ?>"/>
											</td></tr></table>
											</td>
										</tr>
										<tr>
											<td><?php echo 'Googleplus'; ?></td>
											<td>
											<table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_social[googleplus_status]" <?php echo (isset($footer_social['googleplus_status'])&&$footer_social['googleplus_status'])?'checked="checked"':'';?> /></td><td>
											
											Link:<input class="form-control" type="text" name="boss_manager_footer_social[googleplus_url]" value="<?php echo isset($footer_social['googleplus_url'])?$footer_social['googleplus_url']:''; ?>"/>
											</td></tr></table>
											</td>
										</tr>
										<tr>
											<td><?php echo 'Rss Feed'; ?></td>
											<td>
											<table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_social[rss_status]" <?php echo (isset($footer_social['rss_status'])&&$footer_social['rss_status'])?'checked="checked"':'';?> /></td><td>
											
											Link:<input class="form-control" type="text" name="boss_manager_footer_social[rss_url]" value="<?php echo isset($footer_social['rss_url'])?$footer_social['rss_url']:''; ?>"/>
											</td></tr></table></td>
										</tr>
										<tr>
											<td><?php echo 'Youtube'; ?></td>
											<td>
											<table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_social[youtube_status]" <?php echo (isset($footer_social['youtube_status'])&&$footer_social['youtube_status'])?'checked="checked"':'';?> /></td><td>
											
											Link:<input class="form-control" type="text" name="boss_manager_footer_social[youtube_url]" value="<?php echo isset($footer_social['youtube_url'])?$footer_social['youtube_url']:''; ?>"/>
											</td></tr></table>
											</td>
										</tr>
										
										</tbody>
									</table>
								</div>
								
								<div id="tab_footer_5" class="tab-pane">
									<?php $text_url = 'Url:'; ?>
									<table class="table table-striped table-bordered table-hover">
										<tr>
											<td><?php echo 'Payment Status:'; ?></td>
											<td><select class="form-control" name="boss_manager_footer_payment[status]">
												<?php if (isset($footer_payment['status']) && $footer_payment['status']) { ?>
													<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
													<option value="0"><?php echo $text_disabled; ?></option>
												<?php } else { ?>
													<option value="1"><?php echo $text_enabled; ?></option>
													<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
												<?php } ?>
											</select></td>
										</tr>
										<tr>
											<td><?php echo 'Visa'; ?></td>
											<td><table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_payment[visa_status]" <?php echo (isset($footer_payment['visa_status'])&&$footer_payment['visa_status'])?'checked="checked"':'';?> /></td><td>
											
											<?php echo $text_url; ?><input class="form-control" type="text" name="boss_manager_footer_payment[visa_link]" value="<?php echo isset($footer_payment['visa_link'])?$footer_payment['visa_link']:''; ?>" /></td></tr></table></td>
										</tr>
										<tr>
											<td><?php echo 'Master Card'; ?></td>
											<td><table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_payment[master_status]" <?php echo (isset($footer_payment['master_status'])&&$footer_payment['master_status'])?'checked="checked"':'';?> />
											
											</td><td><?php echo $text_url; ?><input class="form-control" type="text" name="boss_manager_footer_payment[master_link]" value="<?php echo isset($footer_payment['master_link'])?$footer_payment['master_link']:''; ?>" /></td></tr></table></td>
										</tr>
										<tr>
											<td><?php echo 'American Express'; ?></td>
											<td><table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_payment[merican_status]" <?php echo (isset($footer_payment['merican_status'])&&$footer_payment['merican_status'])?'checked="checked"':'';?> /></td><td>
											
											<?php echo $text_url; ?><input class="form-control" type="text" name="boss_manager_footer_payment[merican_link]" value="<?php echo isset($footer_payment['merican_link'])?$footer_payment['merican_link']:''; ?>" /></td></tr></table></td>
										</tr>
										<tr>
											<td><?php echo 'Paypal'; ?></td>
											<td><table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_payment[paypal_status]" <?php echo (isset($footer_payment['paypal_status'])&&$footer_payment['visa_status'])?'checked="checked"':'';?> /></td><td>
											
											<?php echo $text_url; ?><input class="form-control" type="text" name="boss_manager_footer_payment[paypal_link]" value="<?php echo isset($footer_payment['paypal_link'])?$footer_payment['paypal_link']:''; ?>" /></td></tr></table></td>
										</tr>
										
										<tr>
											<td><?php echo 'DHL'; ?></td>
											<td><table class="table table-striped table-bordered table-hover"><tr><td>Show<input class="form-control" type="checkbox" name="boss_manager_footer_payment[dhl_status]" <?php echo (isset($footer_payment['dhl_status'])&&$footer_payment['dhl_status'])?'checked="checked"':'';?> /></td><td>
											
											<?php echo $text_url; ?><input class="form-control" type="text" name="boss_manager_footer_payment[dhl_link]" value="<?php echo isset($footer_payment['dhl_link'])?$footer_payment['dhl_link']:''; ?>" /></td></tr></table></td>
										</tr>
									</table>
								</div>
								
								<div id="tab_footer_6" class="tab-pane">
									<ul id="powered_language" class="nav nav-tabs">
										<?php foreach ($languages as $language) { ?>
										<li><a data-toggle="tab" href="#tab-powered-<?php echo $language['language_id']; ?>"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
										<?php } ?>
									</ul>
									<div class="tab-content">
									<?php foreach ($languages as $language) { ?>
									<div id="tab-powered-<?php echo $language['language_id']; ?>" class="tab-pane">
										<table class="table table-striped table-bordered table-hover">
										<tbody>
											<tr>
												<td><?php echo 'Powered Content:'; ?></td>
												<td><textarea name="boss_manager_footer_powered[<?php echo $language['language_id']; ?>]" id="bt_powered<?php echo $language['language_id']; ?>" rows="10" cols="50" ><?php echo isset($footer_powered[$language['language_id']])?$footer_powered[$language['language_id']]:''; ?></textarea></td>
											</tr>
										</tbody>
										</table>
									</div>
									<?php } ?></div>
								</div>
								
								<div id="tab_footer_link" class="tab-pane">
									<div class="form-group">
										<label class="col-sm-2 control-label">Information</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['information']) && $boss_manager['footer_link']['information'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][information]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][information]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][information]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][information]" value="0"> No </label>
											
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Contact Us</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['contact_us']) && $boss_manager['footer_link']['contact_us'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][contact_us]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][contact_us]" value="0" checked="checked"> No </label>
											
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][contact_us]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][contact_us]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Returns</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['return']) && $boss_manager['footer_link']['return'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][return]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][return]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][return]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][return]" value="0"> No </label>
											
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Site Map</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['site_map']) && $boss_manager['footer_link']['site_map'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][site_map]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][site_map]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][site_map]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][site_map]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Brands</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['brands']) && $boss_manager['footer_link']['brands'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][brands]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][brands]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][brands]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][brands]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Gift Vouchers</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['gift_vouchers']) && $boss_manager['footer_link']['gift_vouchers'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][gift_vouchers]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][gift_vouchers]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][gift_vouchers]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][gift_vouchers]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Affiliates</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['affiliates']) && $boss_manager['footer_link']['affiliates'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][affiliates]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][affiliates]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][affiliates]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][affiliates]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Specials</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['specials']) && $boss_manager['footer_link']['specials'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][specials]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][specials]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][specials]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][specials]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Newsletter</label>
										<div class="col-sm-10">
											<?php if(isset($boss_manager['footer_link']['newsletter']) && $boss_manager['footer_link']['newsletter'] ==0){ ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][newsletter]" value="1"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][newsletter]" value="0" checked="checked"> No </label>
											<?php } else { ?>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][newsletter]" value="1" checked="checked"> Yes </label>
											<label class="radio-inline"><input type="radio" name="boss_manager[footer_link][newsletter]" value="0"> No </label>
											<?php } ?>
									  </div>
									</div>
								</div>
								
							 </div>
							</div>
						</div>
						<!-- End #option setting-->
						
						<!-- #option setting-->
						<div id="othersetting" class="tab-pane">
							<table class="table table-striped table-bordered table-hover">
								<tr><td><?php echo 'Product Description:'; ?></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrshow, 'boss_manager[other][pro_tab]','',isset($other['pro_tab']) ? $other['pro_tab'] : false); ?></td></tr>
								
								<tr><td><?php echo 'Show Category Info:'; ?></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrstatus, 'boss_manager[other][category_info]','',isset($other['category_info']) ? $other['category_info'] : false); ?></td></tr>
								<tr><td><?php echo 'Show Refine Search:'; ?></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrstatus, 'boss_manager[other][refine_search]','',isset($other['refine_search']) ? $other['refine_search'] : false); ?></td></tr>
								
							
								<tr><td><?php echo 'View Product:'; ?></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrview, 'boss_manager[other][view_pro]','',isset($other['view_pro']) ? $other['view_pro'] : false); ?></td></tr>
								
								<tr><td><?php echo 'Product Grid View:'; ?></td><td class="left">
								<?php echo $btform -> makeSelectHTML($arrgridview, 'boss_manager[other][grid_view]','',isset($other['grid_view']) ? $other['grid_view'] : false); ?></td></tr>
							</table>
						</div>
						<!-- End #option setting-->
						
						<?php 
						if (filesize("../config_xml/color_setting.xml") == 0){
						   $objXML = simplexml_load_file("../config_xml/theme_color_".$color.".xml");
						  }else{
						   $objXML = simplexml_load_file("../config_xml/color_setting.xml");
						  }?>
						<!-- #Color setting-->
						<div id="colorsetting" class="tab-pane">
							<div class="form-group">
								<label class="col-sm-2 control-label">Template Color</label>
								<div class="col-sm-10">
								  <select name="boss_manager[color]" id="input-status" class="form-control large" onchange="changeTemplate(this.value);">									
									<option value="1" <?php if(isset($color) && $color==1)echo 'selected="selected"';  ?>>Default</option>
									<option value="1" >Re-Load(Default)</option>
								  </select>
								</div>
							</div>
							<div class="default loading" id="color_default">
							<?php 
								$i=0;
							foreach($objXML->groups as $xml){ ?>
							<fieldset>							
								<legend><?php echo($xml->title); ?></legend>
								<input type="hidden" name="xml[<?php echo $i;?>][title][]" value="<?php echo($xml->title); ?>" />
								<div class="color_content form-group">
									<?php foreach($xml->item as $item){ ?>
									<div class="item">
										<?php echo $item->text;?>
										<input size=6 type="text" class="hex" name="xml[<?php echo $i;?>][value][]" id="<?php echo $item->name; ?>" value="<?php echo $item->value;  ?>">
									</div>
									<input type="hidden" name="xml[<?php echo $i;?>][text][]" value="<?php echo($item->text); ?>" />
									<input type="hidden" name="xml[<?php echo $i;?>][name][]" value="<?php echo($item->name); ?>" />
									<input type="hidden" name="xml[<?php echo $i;?>][class][]" value="<?php echo($item->class); ?>" />
									<input type="hidden" name="xml[<?php echo $i;?>][style][]" value="<?php echo($item->style); ?>" />
									<?php } ?>
								</div>							
							</fieldset>
							<?php $i++; } ?>
							</div>
							
							
							<div class="custom" id="color_custom">
								<fieldset>
								<legend>Custom</legend>
								<div class="color_content">
								<table class="table table-striped table-bordered table-hover">
								  <thead>
									<tr>
									  <td class="text-right">#</td>
									  <td class="text-left">Title</td>
									  <td class="text-left"><label class="control-label">Class Name<span data-toggle="tooltip" title="" data-original-title="EX: .custom1,#custom2" class="help"></span></label></td>
									  <td class="text-left">Style</td>
									  <td class="text-left">Color</td>
									  <td class="text-left">Important</td>
									  <td></td>
									</tr>
								  </thead>
								  
								  <tbody class="boss_content" id="custom_color">
									<?php $custom_row =0; ?>
									<?php if(isset($objXML->customs->item)) { ?>
									<?php foreach($objXML->customs->item as $xml){ ?>
										<tr id="custom_row<?php echo $custom_row; ?>">
											<td class="text-left"><?php echo $custom_row+1; ?></td>
											<td class="text-left"><input type="text" name="custom_color[<?php echo $custom_row; ?>][text]" value="<?php echo $xml->text; ?>" class="form-control" /></td>
											<td class="text-left">
											<textarea name="custom_color[<?php echo $custom_row; ?>][class]"  class="form-control" ><?php echo $xml->class; ?></textarea></td>
											<td class="text-left"><select name="custom_color[<?php echo $custom_row; ?>][style]" class="form-control">
											<option value="color"<?php if($xml->style=='color') echo 'selected="selected"'; ?>>color</option>
											<option value="background-color" <?php if($xml->style=='background-color') echo 'selected="selected"'; ?>>background-color</option>
											<option value="border-color" <?php if($xml->style=='border-color') echo 'selected="selected"'; ?>>border-color</option>
											</select></td>
											<td class="text-left"><input type="text" name="custom_color[<?php echo $custom_row; ?>][value]" id="id_custom<?php echo $custom_row; ?>" value="<?php echo $xml->value; ?>" class="form-control" /></td>
											<td class="text-left"><select name="custom_color[<?php echo $custom_row; ?>][important]" class="form-control">
											<option value="0"<?php if($xml->important==0) echo 'selected="selected"'; ?>>No</option>
											<option value="1" <?php if($xml->important==1) echo 'selected="selected"'; ?>>Yes</option></select></td>
											 <td class="text-left"><button type="button" onclick="$('#custom_row<?php echo $custom_row; ?>').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
										</tr>
									<?php $custom_row ++; }} ?>
								  </tbody>
								  <tfoot>
									<tr>
									  <td colspan="6"></td>              
									   <td class="text-left"><button type="button" onclick="addCustom();" data-toggle="tooltip" title="Add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
									</tr>
								  </tfoot>
								</table>
								</div>								
								</fieldset>
							</div>
						</div>
						<!-- End #Color setting-->
						
						<!-- #Font setting-->
						<?php
							$json = file_get_contents("view/font/webfonts.json", true);
							$decode = json_decode($json, true);
							$webfonts = array();
							foreach ($decode['items'] as $key => $value) {
								// FONT FAMILY
								$item_family = $decode['items'][$key]['family'];
								$item_family_trunc =  str_replace(' ','+',$item_family);
								$webfonts[$item_family_trunc] = $item_family;
							}
							//print_r ($default);
							$defaultFont = array( 
								'Arial', 
								'Verdana', 
								'Helvetica', 
								'Lucida Grande', 
								'Trebuchet MS', 
								'Times New Roman', 
								'Tahoma', 
								'Georgia'
								);
							$FontWeight = array( 'default','normal', 'bold','italic' );
							
						?>
						<?php $FontsSizes = array( 
							'default', '10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', 
							'26px', '27px', '28px', '29px', '30px', '31px', '32px', '33px',
							'34px', '35px', '36px', '37px', '38px', '39px', '40px', '41px',
							'42px', '43px', '44px', '45px', '46px', '47px', '48px', '49px', '50px'
						); ?>
						<?php $FontsTransform = array( 'default', 'capitalize', 'lowercase', 'uppercase' ); ?>
						
						<?php 
						$objXML = simplexml_load_file("../config_xml/font_setting.xml"); ?>
						<div id="fontsetting" class="tab-pane">
							<div class="default" id="default">
							<?php 
							$i=0;
							foreach($objXML->groups as $xml){ ?>
							<fieldset>
								<legend><?php echo $xml->title ?></legend>
								<input type="hidden" name="xml_font[<?php echo $i;?>][title][]" value="<?php echo($xml->title); ?>" />
								<div class="font_content">
								<table class="table table-striped table-bordered table-hover">
									  <thead>
										<tr>										  
										  <td class="text-right">#</td>
										  <td class="text-left">Title</td>
										  <td class="text-left">Font Style</td>
										  <td class="text-left">Font Size</td>
										  <td class="text-left">Fonts Weight</td>
										  <td class="text-left">Transform</td>
										</tr>
									  </thead>
									  
									  <tbody class="boss_content">
										<?php 
										$row=0;
										foreach($xml->item as $item){ ?>
										<tr><td colspan="6" style="text-align: center;" id="id_font<?php echo $row; ?>">Praesent pulvinar ullamcorper ligula vitae aliquet</td></tr>
										<tr id="custom_row_font<?php echo $row; ?>">
											<td class="text-left"><?php echo $row+1; ?></td>
											<td class="text-left"><input type="text" name="xml_font[<?php echo $i; ?>][text][]" value="<?php echo $item->text; ?>" class="form-control" /></td>
											<td class="text-left">
											<select name="xml_font[<?php echo $i; ?>][style][]" class="form-control" onchange="selectedFontStyle(this.value,'#id_font<?php echo $row; ?>')">
												<option>default</option>
												<optgroup label="HTML default fonts">
												<?php foreach ($defaultFont as $key) { ?>
													<?php ($key ==  $item->style) ? $selected = 'selected' : $selected = ''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
												<?php } ?>
												</optgroup>
												<optgroup label="Google fonts">
												<?php foreach ($webfonts as $key => $face ) { ?>
													<?php ($key ==  $item->style) ? $selected = 'selected' : $selected=''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $face; ?></option>
												<?php } ?>
												</optgroup>
											</select></td>
											<td class="text-left">
											<select name="xml_font[<?php echo $i; ?>][size][]" class="form-control" onchange="selectedFontSize(this.value,'#id_font<?php echo $row; ?>')">
												<?php foreach ($FontsSizes as $key) { ?>
													<?php ($key ==  $item->size) ? $selected = 'selected' : $selected=''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
												<?php } ?>
											</select></td>
											<td class="text-left"><select class="form-control" name="xml_font[<?php echo $i; ?>][weight][]" onchange="selectedFontWeight(this.value,'#id_font<?php echo $row; ?>')">
												<?php foreach ($FontWeight as $key) { ?>
													<?php ($key ==  $item->weight) ? $selected = 'selected' : $selected=''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
												<?php } ?>
											</select></td>
											<td class="text-left"><select class="form-control"  name="xml_font[<?php echo $i; ?>][transform][]" onchange="selectedFontTrans(this.value,'#id_font<?php echo $row; ?>')">
												<?php foreach ($FontsTransform as $key) { ?>
													<?php ($key ==  $item->transform) ? $selected = 'selected' : $selected=''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
												<?php } ?>
											</select></td>
											<input type="hidden" name="xml_font[<?php echo $i;?>][class_name][]" value="<?php echo $item->class_name; ?>">											
										</tr>
										<script type="text/javascript"><!--
												$(document).ready(function() {
													selectedFontStyle('<?php echo $item->style; ?>','#id_font<?php echo $row; ?>');
													selectedFontSize('<?php echo $item->size; ?>','#id_font<?php echo $row; ?>');
													selectedFontWeight('<?php echo $item->weight; ?>','#id_font<?php echo $row; ?>');
													selectedFontTrans('<?php echo $item->transform; ?>','#id_font<?php echo $row; ?>')
												});
											//--></script>
										<?php $row++; } ?>
									  </tbody>
								</table>
								</div>
							</fieldset>
							<?php $i++; } ?>
							
							</div>
							
							
							<div class="custom">
								<fieldset>
								<legend>Custom</legend>
								<div class="font_content">
								<table class="table table-striped table-bordered table-hover">
								  <thead>
									<tr>
									  <td class="text-right">#</td>
										  <td class="text-left">Title</td>
										  <td class="text-left"><label class="control-label">Class Name<span data-toggle="tooltip" title="" data-original-title="EX: .custom1,#custom2" class="help"></span></label></td>
										  <td class="text-left">Font Style</td>
										  <td class="text-left">Font Size</td>
										  <td class="text-left">Fonts Weight</td>
										  <td class="text-left">Transform</td>
									  <td></td>
									</tr>
								  </thead>
								  
								  <tbody class="boss_content_font">
									<?php $custom_row_font =0; ?>
									<?php if(isset($objXML->customs->item)) { ?>
									<?php foreach($objXML->customs->item as $item){ ?>
										<tr id="custom_row_font_text<?php echo $custom_row_font; ?>"><td colspan="6" style="text-align: center;" id="id_custom_font<?php echo $custom_row_font; ?>">Praesent pulvinar ullamcorper ligula vitae aliquet</td></tr>
										<tr id="custom_row_font<?php echo $custom_row_font; ?>">
											<td class="text-left"><?php echo $custom_row_font+1; ?></td>
											<td class="text-left"><input type="text" name="custom_font[<?php echo $custom_row_font; ?>][text]" value="<?php echo $item->text; ?>" class="form-control" /></td>
											<td class="text-left">
											<textarea name="custom_font[<?php echo $custom_row_font; ?>][class_name]" class="form-control"><?php echo $item->class_name; ?></textarea>
											</td>
											<td class="text-left">
											<select name="custom_font[<?php echo $custom_row_font; ?>][style]" class="form-control" onchange="selectedFontStyle(this.value,'#id_custom_font<?php echo $custom_row_font; ?>')">
												<option>default</option>
												<optgroup label="HTML default fonts">
												<?php foreach ($defaultFont as $key) { ?>
													<?php ($key ==  $item->style) ? $selected = 'selected' : $selected = ''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
												<?php } ?>
												</optgroup>
												<optgroup label="Google fonts">
												<?php foreach ($webfonts as $key => $face ) { ?>
													<?php ($key ==  $item->style) ? $selected = 'selected' : $selected=''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $face; ?></option>
												<?php } ?>
												</optgroup>
											</select></td>
											<td class="text-left">
											<select name="custom_font[<?php echo $custom_row_font; ?>][size]" class="form-control" onchange="selectedFontSize(this.value,'#id_custom_font<?php echo $custom_row_font; ?>')">
												<?php foreach ($FontsSizes as $key) { ?>
													<?php ($key ==  $item->size) ? $selected = 'selected' : $selected=''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
												<?php } ?>
											</select></td>
											<td class="text-left"><select class="form-control" name="custom_font[<?php echo $custom_row_font; ?>][weight]" onchange="selectedFontWeight(this.value,'#id_custom_font<?php echo $custom_row_font; ?>')">
												<?php foreach ($FontWeight as $key) { ?>
													<?php ($key ==  $item->weight) ? $selected = 'selected' : $selected=''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
												<?php } ?>
											</select></td>
											<td class="text-left"><select class="form-control"  name="custom_font[<?php echo $custom_row_font; ?>][transform]" onchange="selectedFontTrans(this.value,'#id_custom_font<?php echo $custom_row_font; ?>')">
												<?php foreach ($FontsTransform as $key) { ?>
													<?php ($key ==  $item->transform) ? $selected = 'selected' : $selected=''; ?>
													<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
												<?php } ?>
											</select></td>
											<td class="text-left"><button type="button" onclick="$('#custom_row_font_text<?php echo $custom_row_font; ?>').remove();$('#custom_row_font<?php echo $custom_row_font; ?>').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
																						
										</tr>
										<script type="text/javascript"><!--
											$(document).ready(function() {
												selectedFontStyle('<?php echo $item->style; ?>','#id_custom_font<?php echo $custom_row_font; ?>');
												selectedFontSize('<?php echo $item->size; ?>','#id_custom_font<?php echo $custom_row_font; ?>');
												selectedFontWeight('<?php echo $item->weight; ?>','#id_custom_font<?php echo $custom_row_font; ?>');
												selectedFontTrans('<?php echo $item->transform; ?>','#id_custom_font<?php echo $custom_row_font; ?>')
											});
										//--></script>
									<?php $custom_row_font ++; }} ?>
								  </tbody>
								  <tfoot>
									<tr>
									  <td colspan="7"></td>              
									   <td class="text-left"><button type="button" onclick="addCustomFont();" data-toggle="tooltip" title="Add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
									</tr>
								  </tfoot>
								</table>
								</div>								
								</fieldset>
							</div>
						</div>
						<!-- End #Font setting-->
						
						<!-- Add Sample data-->
						<div id="sampledata" class="tab-pane">
						<div class="panel panel-default">
							<div class="container-fluid">
								<div class="panel-heading">
									<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo 'Insstall module data sample'; ?></h3>									
								</div>
								
								<div class="panel-body">
									<table class="table table-striped table-bordered table-hover">
										<?php $dataModule = array("boss_alphabet"=>"Boss - Products by Alphabet","boss_manufacturer"=>"Boss - Manufacturer","boss_quickshop"=>"Boss - QuickShop","boss_tagcloud"=>"Boss - Tag Cloud","boss_zoom"=>"Boss - Zoom","html"=>"HTML Content","boss_newmegamenu"=>"Boss - Megamenu","boss_revolutionslider"=>"Boss Revolution Slider","bossblog"=>"Boss Blog","blogcategory"=>"Boss - Blog Category","blogrecentcomment"=>"Boss - Blog Recent Comment","blogrecentpost"=>"Boss - Blog Recent Post","blogsearch"=>"Boss - Blog Search","blogtagcloud"=>"Boss - Blog Tagcloud","boss_featured"=>"Boss - Featured Product","newslettersubscribe"=>"News Letter","boss_facecomments"=>"Boss - Facebook Comments"); ?>
										<?php foreach($dataModule as $code => $name){ ?>
										<tr><td><label class="form-control"><?php echo 'Module: '.$name; ?></label><div id="success_<?php echo $code; ?>"> </div></td>
											<td><input type="button" onclick="installDataModule('<?php echo $code ;?>')" class="btn btn-success" value="Insstall Data" /></td></tr>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>
						</div>
						<!-- End add Sample data-->
					</div>
					
				</form>
			</div>
		</div>
	  
	</div>	
</div>
<script type="text/javascript" src="view/javascript/bossthemes/colorpicker.js"></script>
<script type="text/javascript" src="view/javascript/bossthemes/eye.js"></script>
<script type="text/javascript" src="view/javascript/bossthemes/layout.js"></script>
<link rel="stylesheet" type="text/css" href="view/stylesheet/bossthemes/colorpicker.css" />

<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#bt_shipping_content<?php echo $language['language_id']; ?>,#bt_about_content<?php echo $language['language_id']; ?>,#bt_powered<?php echo $language['language_id']; ?>,#bt_contact_content<?php echo $language['language_id']; ?>').summernote({height: 300});
<?php } ?>
$('#shipping_language a:first').tab('show');
$('#about_language a:first').tab('show');
$('#contact_language123 a:first').tab('show');
$('#powered_language a:first').tab('show');
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function(){ 
$('fieldset legend').click(function(){
		$(this).parent().toggleClass('open');
	});
});
	
<?php
if (filesize("../config_xml/color_setting.xml") == 0){
   $objXML = simplexml_load_file("../config_xml/theme_color_".$color.".xml");
  }else{
   $objXML = simplexml_load_file("../config_xml/color_setting.xml");
  }
$code_color = array();
if(isset($objXML->groups)){
foreach($objXML->groups as $xml){
	foreach($xml->item as $item){
		$code_color[] = $item->name;			
	}	
}
}
$i=0;
if(isset($objXML->customs->item)){
foreach($objXML->customs->item as $item){	
	$code_color[] = 'id_custom'.$i;					
	$i++;
}
}

?>
var id_Color_List = Array(<?php foreach ($code_color as $color) {
								if($color==end($code_color))
									echo "'".$color."'";
								else
									echo "'".$color."'".", ";
								
								} ?>);


var custom_row = <?php echo $custom_row+1; ?>;
function addCustom() {
	
	html = '<tr id="custom_row' + custom_row + '">'
	html += '<td class="text-left">' + custom_row + '</td>';
	html += '<td class="text-left"><input type="text" name="custom_color[' + custom_row + '][text]" value="" class="form-control" /></td>';
	html += '<td class="text-left"><textarea name="custom_color[' + custom_row + '][class]"  class="form-control" ></textarea></td>';
	html += '<td class="text-left"><select name="custom_color[' + custom_row + '][style]" class="form-control">';
	html += ' <option value="color">color</option>';
	html += ' <option value="background-color" >background-color</option>';
	html += ' <option value="border-color" >border-color</option></select></td> ';
	html += ' <td class="text-left"><input type="text" name="custom_color[' + custom_row + '][value]" value="" id="id_custom' + custom_row + '" class="form-control" /></td>';
	html+= ' <td class="text-left"><select name="custom_color[' + custom_row + '][important]" class="form-control"> ';
	html += '	<option value="0">No</option> ';
	html += '	<option value="1" >Yes</option></select></td>';
	html += ' <td class="text-left"><button type="button" onclick="$(\'#custom_row' + custom_row + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	$('#custom_color').append(html);
	
	var id = '#id_custom'+custom_row;
	$('#id_custom' + custom_row).ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).css({backgroundColor:"#" + hex});
			$(el).ColorPickerHide();
		},
		onChange: function (hsb, hex, rgb) {			
			$(id).css('background', '#' + hex);
			$(id).val(hex);
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
	custom_row++;
}


var custom_row_font = <?php echo $custom_row_font+1; ?>;
function addCustomFont() {
	
	html = '<tr id="custom_row_font_text' + custom_row_font + '"><td colspan="6" id="id_custom_font' + custom_row_font + '" style="text-align: center;">Praesent pulvinar ullamcorper ligula vitae aliquet</td></tr>';
	html += '<tr id="custom_row_font' + custom_row_font + '">';
	html +=	'<td class="text-left">' + custom_row_font + '</td>';
	html +=	'<td class="text-left"><input type="text" name="custom_font[' + custom_row_font + '][text]" value="" class="form-control" /></td>';
	html +=	'<td class="text-left"><textarea name="custom_font[' + custom_row_font + '][class_name]" class="form-control"></textarea></td>';
	html +=	'<td class="text-left">';
	html +=	'<select name="custom_font[' + custom_row_font + '][style]" class="form-control" onchange="selectedFontStyle(this.value,\'#id_custom_font' + custom_row_font + '\')">';
	html += ' <option>default</option>';
	html +=	 '<optgroup label="HTML default fonts">';
			<?php foreach ($defaultFont as $key) { ?>				
	html +=	'<option value="<?php echo $key; ?>"><?php echo $key; ?></option>';
			<?php } ?>
	html += ' </optgroup>';
	html +=	'<optgroup label="Google fonts">';
			<?php foreach ($webfonts as $key => $face ) { ?>				
	html +=	' <option value="<?php echo $key; ?>"><?php echo $face; ?></option>';
			<?php } ?>
	html +=	'</optgroup>';
	html +=	'</select></td>';
	html +=	'<td class="text-left">';
	html +=	'<select name="custom_font[' + custom_row_font + '][size]" class="form-control" onchange="selectedFontSize(this.value,\'#id_custom_font' + custom_row_font + '\')">';
			<?php foreach ($FontsSizes as $key) { ?>	
	html +=	'<option value="<?php echo $key; ?>"><?php echo $key; ?></option>';
			<?php } ?>
	html +=	'</select></td>';
	html +=	'<td class="text-left"><select class="form-control" name="custom_font[' + custom_row_font + '][weight]" onchange="selectedFontWeight(this.value,\'#id_custom_font' + custom_row_font + '\')">';
			<?php foreach ($FontWeight as $key) { ?>
	html += '	<option value="<?php echo $key; ?>"><?php echo $key; ?></option>';
			<?php } ?>
	html +=	'</select></td>';
	html +=	'<td class="text-left"><select class="form-control"  name="custom_font[' + custom_row_font + '][transform]" onchange="selectedFontTrans(this.value,\'#id_custom_font' + custom_row_font + '\')">';
			<?php foreach ($FontsTransform as $key) { ?>				
	html += ' <option value="<?php echo $key; ?>"><?php echo $key; ?></option>';
			<?php } ?>
	html +=	'</select></td>';
	html +=	'<td class="text-left"><button type="button" onclick="$(\'#custom_row_font_text' + custom_row_font + '\').remove();$(\'#custom_row_font' + custom_row_font + '\').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
												
	html += '</tr>';
	$('.boss_content_font').append(html);
	
	
	custom_row_font++;
}

function selectedFontStyle(value,$span){	
	var span = $($span);
	//var idSelect = $($id);
	if(value == 'Arial'){
		span.css("font-family",'Arial');
		span.css("display",'');
	}else if(value == 'Verdana'){
		span.css("font-family",'Verdana');
		span.css("display",'');
	}else if(value == 'Helvetica'){
		span.css("font-family",'Helvetica');
		span.css("display",'');
	}else if(value == 'Lucida Grande'){
		span.css("font-family",'Lucida Grande');
		span.css("display",'');
	}else if(value == 'Trebuchet MS'){
		span.css("font-family",'Trebuchet MS');
		span.css("display",'');
	}else if(value == 'Times New Roman'){
		span.css("font-family",'Times New Roman');
		span.css("display",'');
	}else if(value == 'Tahoma'){
		span.css("font-family",'Tahoma');
		span.css("display",'');
	}else if(value == 'Georgia'){
		span.css("font-family",'Georgia');
		span.css("display",'');
	}else if(value == 'default'){
		span.css("font-family",'');
		span.css("display",'');
	}else {
		var font = 	value.replace(/\+/g," ");
		
		$('head').append('<link id="link_' + value + '" rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' + font + '">');
		span.css("font-family",'"'+ font +'"');
		span.css("display",'');
	}
}
function selectedFontWeight(value,$span){
	var span = $($span);
	//var idSelect = $($id);
	if(value == 'default'){
		span.css("font-weight",'');	
		span.css("font-style",'');
	}else if(value == 'italic'){
		span.css("font-style",'italic');
		span.css("font-weight",'');	
	} else {
		span.css("font-weight",value);
		span.css("font-style",'');
	}
}

function selectedFontSize(value,$span){
	var span = $($span);
	//var idSelect = $($id);
	if(value == 'default'){
		span.css("font-size",'');	
	}else {
		span.css("font-size",value);
	}
}

function selectedFontTrans(value,$span){
	var span = $($span);
	//var idSelect = $($id);
	if(value == 'default'){
		span.css("text-transform",'');	
	}else {
		span.css("text-transform",value);
	}
}
function changeTemplate(value) {		
	$.ajax({
		url: 'index.php?route=module/boss_manager/changeTemplate&token=<?php echo $token; ?>&value='+value,
		dataType: 'json',
		beforeSend: function() {
			$('.loading').html('<span class="wait">&nbsp;<img src="../admin/view/image/loading.gif" alt="" /></span>');
		},		
		complete: function() {
			$('.wait').remove();
		},
		success: function(json) { 
			if (json['output']) {	
				$('#color_default').remove();
				$('#color_custom').before(json['output']);
			}
		}
	});
	
	
};

function installDataModule(value) {	
	var c =confirm('Are you sure? All the data of this module will be lost! The new data will same as homepage default.');
	if(c){
		$.ajax({
			url: 'index.php?route=module/boss_manager/addSampleData&token=<?php echo $token; ?>&module_code=' + value,
			type: 'post',
			dataType: 'json',
			success: function(json) {
				if(json['error']){
					$("#success_"+value).addClass('alert alert-danger');
					$("#success_"+value).html(json['error']);
					$("#success_"+value).slideDown('slow');
					slideout(value);
				}else if (json['output']) {
					$("#success_"+value).addClass('alert alert-success');
					$("#success_"+value).html(json['output']);
					$("#success_"+value).slideDown('slow');
					slideout(value);
				}
			}
		});
	}
	return false;
	
};

function slideout(code){
	setTimeout(function(){
		$("#success_"+code).slideUp("slow", function () {});
		
	}, 3000);
}
//--></script> 
<?php echo $footer; ?>