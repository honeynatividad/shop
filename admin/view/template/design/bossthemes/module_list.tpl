<?php foreach ($modules as $module) { ?>
    <div class="ds_heading"><?php echo strip_tags($module['name']); ?>
    <div class="btn-group pull-right"><a class="btn btn-xs btn-edit" href="<?php echo $module['edit']; ?>" data-type="iframe" data-title="<?php echo strip_tags($module['name']); ?>" data-toggle="tooltip" title="<?php echo $text_edit_module;?>"><i class="fa fa-edit"></i></a></div>
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