<?php

/* 
 * Admin view of iPay88 Payment 
 * by HCN
 */
?>

<?php echo $header; ?><?php echo $column_left; ?>
  <div id="content">  
    <div class="page-header">
      <div class="container-fluid">
        <div class="pull-right">
          <button type="submit" form="form-pp-std-uk" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
      <?php if (isset($error['error_warning'])) { ?>
      <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
      </div>
      <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-cod" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-api" data-toggle="tab">General</a></li>
            <li><a href="#tab-order-status" data-toggle="tab"><?php echo $tab_order_status; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-api">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input1"><?php echo $entry_vendor; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="ipay88_vendor" value="<?php echo $ipay88_vendor; ?>"id="input1" class="form-control" />
                  <?php if ($error_vendor) { ?>
                  <div class="text-danger"><?php echo $error_vendor; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input2"><?php echo $entry_password; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="ipay88_password" value="<?php echo $ipay88_password; ?>" id="input2" class="form-control"  />
                  <?php if ($error_password) { ?>
                  <div class="text-danger"><?php echo $error_password; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input3"><?php echo $entry_order_status; ?></label>
                <div class="col-sm-10">
                  <select name="ipay88_order_status_id" id="input3" class="form-control" >
                  <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $ipay88_order_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input4"><?php echo $entry_geo_zone; ?></label>
                <div class="col-sm-10">
                  <select name="ipay88_geo_zone_id" id="input4" class="form-control" >
                    <option value="0"><?php echo $text_all_zones; ?></option>
                    <?php foreach ($geo_zones as $geo_zone) { ?>
                      <?php if ($geo_zone['geo_zone_id'] == $ipay88_geo_zone_id) { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                      <?php } else { ?>
                    <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input5"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="ipay88_status" id="input5" class="form-control" >
                  <?php if ($ipay88_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>

            </div>
          
            <div class="tab-pane" id="tab-order-status">

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-canceled-reversal-status"><?php echo $entry_canceled_reversal_status; ?></label>
                <div class="col-sm-10">
                  <select name="ipay88_canceled_reversal_status_id" id="input-canceled-reversal-status" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                      <?php if ($order_status['order_status_id'] == $ipay88_canceled_reversal_status_id) { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                      <?php } else { ?>
                      <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-completed-status"><?php echo $entry_completed_status; ?></label>
                <div class="col-sm-10">
                  <select name="ipay88_completed_status_id" id="input-completed-status" class="form-control">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $ipay88_completed_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                  <?php } ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-denied-status"><?php echo $entry_denied_status; ?></label>
                                    <div class="col-sm-10">
                                        <select name="ipay88_denied_status_id" id="input-denied-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $ipay88_denied_status_id) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-expired-status"><?php echo $entry_expired_status; ?></label>
                                    <div class="col-sm-10">
                                        <select name="ipay88_expired_status_id" id="input-expired-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $ipay88_expired_status_id) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-failed-status"><?php echo $entry_failed_status; ?></label>
                                    <div class="col-sm-10">
                                        <select name="ipay88_failed_status_id" id="input-failed-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $ipay88_failed_status_id) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-pending-status"><?php echo $entry_pending_status; ?></label>
                                    <div class="col-sm-10">
                                    <select name="ipay88_pending_status_id" id="input-pending-status" class="form-control">
                                        <?php foreach ($order_statuses as $order_status) { ?>
                                        <?php if ($order_status['order_status_id'] == $ipay88_pending_status_id) { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                        <?php } else { ?>
                                        <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                  </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-processed-status"><?php echo $entry_processed_status; ?></label>
                                    <div class="col-sm-10">
                                        <select name="ipay88_processed_status_id" id="input-processed-status" class="form-control">
                                            <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $ipay88_processed_status_id) { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-refunded-status"><?php echo $entry_refunded_status; ?></label>
                                    <div class="col-sm-10">
                                        <select name="ipay88_refunded_status_id" id="input-refunded-status"class="form-control">
                                            <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $ipay88_refunded_status_id) { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-reversed-status"><?php echo $entry_reversed_status; ?></label>
                                    <div class="col-sm-10">
                                        <select name="ipay88_reversed_status_id" id="input-reversed-status" class="form-control">
                                            <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $ipay88_reversed_status_id) { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-voided-status"><?php echo $entry_voided_status; ?></label>
                                    <div class="col-sm-10">
                                        <select name="ipay88_voided_status_id" id="input-voided-status" class="form-control">
                                            <?php foreach ($order_statuses as $order_status) { ?>
                                            <?php if ($order_status['order_status_id'] == $ipay88_voided_status_id) { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                                            <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            </div>
		    </form>
      
      </div>
  </div>
</div>
<?php echo $footer; ?>