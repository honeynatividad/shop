<?php echo $header; ?>
<div id="content" class="form-horizontal">  
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-body layout-builder">         
          <div class="ds_accordion">
              <?php foreach ($modules as $module) { ?>
          		<div class="ds_heading"><i class="fa fa-bars"></i> <?php echo strip_tags($module['name']); ?>
               
                <div class="btn-group"><a class="btn btn-xs modalbox" href="<?php echo $module['edit']; ?>" data-type="iframe" data-size="modal-lg" data-title="<?php echo strip_tags($module['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a></div> 
                </div>
                <div class="ds_content drag_area">
    <?php foreach ($module['module'] as $module) { ?>       
                <div class="module-block" data-code="<?php echo $module['code']; ?>">
                <i class="fa fa-arrows-alt"></i> <?php echo strip_tags($module['name']); ?>    
           <a class="btn btn-sm btn-edit" href="<?php echo $module['edit']; ?>"><i class="fa fa-edit" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"></i></a>   
           		</div>                 
    <?php } ?>   
                </div><!--ds_content --> 
              <?php } ?>                
          </div><!--//ds_accordion --> 
      </div>
    </div>
  </div>
</div>
<script>// Call template init (optional, but faster if called manually)
	$(document).ready(function() { 
		Layout.handleAccordion();  
		$('.drag_area>div').on('click', function() {
			var code = $(this).attr('data-code');
			var data_href = $(this).find('a').attr('href');
			var module_label = $(this).text();
			var position = '<?php echo $position;?>';
			parent.Layout.addModule(code,position,module_label,data_href);			
			parent.$('.modal-backdrop').hide(); 		
			parent.$('.modal-box').modal('hide');	
		});	
		$('#modal-iframe').contents().find('form').on('submit', function(event) {
			$('#modal-iframe').removeClass('loading');
		});
	});
</script>