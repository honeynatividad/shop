<div class="box block boss_blog-cat">
   <div class="box-heading block-title">
      <div><h1><?php echo $heading_title; ?></h1></div>
   </div>
   <div id="content">
   
      <div class="panel panel-default">
         <div class="panel-body">
   			<div class="col-sm-12">
               <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
           		<fieldset>
             				
                  <div class="required">
                     <label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
                 		<input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
                 		<?php if ($error_name) { ?>
                 		<div class="text-danger"><?php echo $error_name; ?></div>
                 				<?php } ?>
                  </div>
                  <div class="required">
                     <label class="control-label" for="input-name"><?php echo $entry_designation; ?></label>
                     <input type="text" name="designation" value="" id="input-name" class="form-control" />
                     <?php if ($error_designation) { ?>
                     <div class="text-danger"><?php echo $error_designation; ?></div>
                     <?php } ?>
                  </div>

                  <div class="required">
                     <label class="control-label" for="input-name"><?php echo $entry_email; ?></label>
                     <input type="text" name="email" value="" id="input-name" class="form-control" />
                         <?php if ($error_designation) { ?>
                     <div class="text-danger"><?php echo $error_designation; ?></div>
                         <?php } ?>
                  </div>

                  <div class="required">
                     <label class="control-label" for="input-email"><?php echo $entry_contact_number; ?></label>
                 		<input type="text" name="contact_number" value="" id="input-email" class="form-control" />
                 				<?php if ($error_email) { ?>
                 		<div class="text-danger"><?php echo $error_email; ?></div>
                 				<?php } ?>
             		</div>

                  <div class="required">
                     <label class="control-label" for="input-email"><?php echo $entry_company; ?></label>
                     <input type="text" name="company" value="" id="input-email" class="form-control" />
                         <?php if ($error_company) { ?>
                     <div class="text-danger"><?php echo $error_company; ?></div>
                         <?php } ?>
                  </div>

                  <div class="required">
                     <label class="control-label" for="input-email"><?php echo $entry_nature_of_business; ?></label>
                     <input type="text" name="nature_of_business" value="" id="input-email" class="form-control" />
                         <?php if ($error_nature_of_business) { ?>
                     <div class="text-danger"><?php echo $error_nature_of_business; ?></div>
                         <?php } ?>
                  </div>

                  <div class="required">
                     <label class="control-label" for="input-email"><?php echo $entry_total_employees; ?></label>
                     <select class="form-control" id="sel1" name="total_employees">
                        <option value="5-19">5-19</option>
                        <option value="20-99">20-99</option>                        
                     </select> 
                     
                     <?php if ($error_total_employees) { ?>
                     <div class="text-danger"><?php echo $error_total_employees; ?></div>
                         <?php } ?>
                  </div>

                  <div class="required">
                     <label class="control-label" for="input-email"><?php echo $entry_total_dependents; ?></label>
                     <select class="form-control" id="sel1" name="total_dependents">
                        <option value="5-19">5-19</option>
                        <option value="20-99">20-99</option>                        
                     </select> 
                     
                     <?php if ($error_total_dependents) { ?>
                     <div class="text-danger"><?php echo $error_total_dependents; ?></div>
                         <?php } ?>
                  </div>

                  <div class="required">
                     <label class="control-label" for="input-email"><?php echo $entry_annual_budget; ?></label>
                     <select class="form-control" id="sel1" name="annual_budget">
                        <option value="3,500-5,999">3,500-5,999</option>
                        <option value="6,000-7,499">6,000-7,499</option>                        
                        <option value="7,500+">7,500+</option>
                     </select> 
                     
                         <?php if ($error_annual_budget) { ?>
                     <div class="text-danger"><?php echo $error_annual_budget; ?></div>
                         <?php } ?>
                  </div>

                  <div class="required">
                     <label class="control-label" for="input-email"><?php echo $entry_existing_hmo; ?></label>
                     <select class="form-control" id="sel1" name="existing_hmo">
                        <option value="yes">Yes</option>
                        <option value="no">No</option>                        
                     </select> 
                     
                         <?php if ($error_existing_hmo) { ?>
                     <div class="text-danger"><?php echo $error_existing_hmo; ?></div>
                         <?php } ?>
                  </div>

                  <div class="required">
                     <label class="control-label" for="input-email"><?php echo $entry_message; ?></label>
                     <textarea  name="message" value="" id="input-email" class="form-control"></textarea> 
                         <?php if ($error_message) { ?>
                     <div class="text-danger"><?php echo $error_message; ?></div>
                         <?php } ?>
                  </div>
             				
           		</fieldset>
           		<div class="buttons">
             	   <div class="pull-left">
               	   <input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>" />
             		</div>
           		</div>
   			   </form>
            </div>
         </div>
      
      </div>
   </div>
</div>
