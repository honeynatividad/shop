<!-- PH File Manager Assets -->
<link href="view/javascript/ph_filemanager/sweet-alert/sweetalert.css" rel="stylesheet">
<link href="view/javascript/ph_filemanager/cropper/cropper.min.css" rel="stylesheet">
<link href="view/stylesheet/ph_filemanager/ph_filemanager.css" rel="stylesheet">
<script async src="view/javascript/ph_filemanager/jquery-ui.min.js" type="text/javascript"></script>
<script async src="view/javascript/ph_filemanager/sweet-alert/sweetalert.min.js" type="text/javascript"></script>
<script async src="view/javascript/ph_filemanager/cropper/cropper.min.js" type="text/javascript"></script>
<script async src="view/javascript/ph_filemanager/ph_filemanager.js" type="text/javascript"></script>

<div class="modal-dialog modal-lg" style="width: 98%;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"><?php echo $heading_title; ?></h4>
        </div>
        <div class="modal-body">
            <input type="hidden" id="phfm-helpers" value='<?php echo json_encode($helpers); ?>'>
            <ul class="nav nav-pills nav-justified" id="phfm-navs">
                <li class="active"><a data-toggle="tab" href="#gallery"><i class="fa fa-picture-o"></i> <?php echo $tab_gallery; ?></a></li>
                <li><a data-toggle="tab" href="#imageEditor"><i class="fa fa-edit"></i> <?php echo $tab_editor; ?></a></li>
            </ul>
            <div class="tab-content">
                <div id="gallery" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-sm-7">
                            <a href="javascript:void(0)" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" id="button-refresh" class="btn btn-default"><i class="fa fa-refresh"></i></a>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_folder; ?>" id="button-folder" class="btn btn-default"><i class="fa fa-folder"></i></button>
                            <label for="inputImage" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $button_upload; ?>"><i class="fa fa-upload"></i><form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" multiple class="sr-only" id="inputImage" name="file[]" accept="image/*"></form></label>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_remote_upload; ?>" id="button-remote" class="btn btn-primary"><i class="fa fa-external-link"></i></button>
                            <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" id="button-delete" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="search" placeholder="<?php echo $entry_search; ?>" class="form-control">
                                <span class="input-group-btn">
                                    <button type="button" data-toggle="tooltip" title="<?php echo $button_search; ?>" id="button-search" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-6" id="phfm-breadcrumb">
                                    <ol class="breadcrumb breadcrumb-manager">
                                        <li><a class="active"><?php echo $text_library; ?></a></li>
                                    </ol>
                                </div>
                                <div class="col-sm-6 text-right status-manager" id="phfm-status" data-text-loading="<?php echo $status_loading; ?>" data-text-error="<?php echo $status_error; ?>" data-text-success="<?php echo $status_success; ?>"></div>
                            </div>
                            <div class="row selectable" id="phfm-library"></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row details">
                                <p class="lead"><?php echo $text_details; ?></p>
                                <div id="phfm-details">
                                    <?php echo $text_details_none; ?>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-sm btn-default" style="display: none; margin-top: 5px;" id="button-cancel-selection"><i class="fa fa-ban text-danger"></i> <?php echo $button_cancel_selection ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="imageEditor" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12" id="editorInitial">
                            <div class="jumbotron text-center">
                                <h1 class="lead hidden-xs" style="text-transform: uppercase"><?php echo $entry_image_editor; ?></h1>
                                <p><?php echo $entry_image_editor_desc_1; ?></p>
                                <p><?php echo $entry_image_editor_desc_2; ?></p>
                            </div>
                        </div>
                        <div class="col-md-12" style="display: none" id="editorDivCanvas">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="btn-group">
                                        <button id="editorDragMode" data-toggle="tooltip" title="<?php echo $editor_drag; ?>" class="btn btn-default"><i class="fa fa-arrows"></i></button>
                                        <button id="editorCropMode" data-toggle="tooltip" title="<?php echo $editor_crop; ?>" class="btn btn-default"><i class="fa fa-crop"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button id="editorRotateLeft" data-toggle="tooltip" title="<?php echo $editor_rotate_left; ?>" class="btn btn-default"><i class="fa fa-rotate-left"></i></button>
                                        <button id="editorRotateRight" data-toggle="tooltip" title="<?php echo $editor_rotate_right; ?>" class="btn btn-default"><i class="fa fa-rotate-right"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button id="editorFlipHorizontal" data-scale="1" data-toggle="tooltip" title="<?php echo $editor_flip_horizontal; ?>" class="btn btn-default"><i class="fa fa-arrows-h"></i></button>
                                        <button id="editorFlipVertical" data-scale="1" data-toggle="tooltip" title="<?php echo $editor_flip_vertical; ?>" class="btn btn-default"><i class="fa fa-arrows-v"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button id="editorZoomIn" data-toggle="tooltip" title="<?php echo $editor_zoom_in; ?>" class="btn btn-default"><i class="fa fa-search-plus"></i></button>
                                        <button id="editorZoomOut" data-toggle="tooltip" title="<?php echo $editor_zoom_out; ?>" class="btn btn-default"><i class="fa fa-search-minus"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button id="editorSaveCrop" data-toggle="tooltip" title="<?php echo $editor_save_crop; ?>" class="btn btn-success"><i class="fa fa-check"></i></button>
                                        <button id="editorCancelCrop" data-toggle="tooltip" title="<?php echo $editor_cancel_crop; ?>" class="btn btn-default"><i class="fa fa-ban text-danger"></i></button>
                                        <button id="editorResetCrop" data-toggle="tooltip" title="<?php echo $editor_reset_crop; ?>" class="btn btn-default"><i class="fa fa-refresh text-primary"></i></button>
                                    </div>
                                    <label for="inputImageEditor" class="btn btn-primary" data-toggle="tooltip" title="<?php echo $editor_upload_new_image; ?>"><i class="fa fa-upload"></i></label>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12" id="editorContainerImg">
                                    <div style="max-height: 500px;">
                                        <div class="col-xs-2 text-center" id="editorStatus" style="z-index: 9999; background: #eee; margin-top: 5px; margin-left: 5px; border-radius: 5px;"></div>
                                        <img id="editorImage" style="width: 100%" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="col-xs-2 text-left"><button class="btn btn-default" id="phfm-help"><i class="fa fa-question-circle"></i> <?php echo $text_help; ?></button></div>
            <div class="col-xs-10" id="phfm-pagination"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    new PHFileManager('<?php echo $target; ?>', '<?php echo $thumb; ?>');
</script>