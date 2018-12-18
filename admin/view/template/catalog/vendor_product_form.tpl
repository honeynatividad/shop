<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
      
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
         
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
             
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_vendor_id; ?></label>
                  <div class="col-sm-10">
                    <select name="vendor_id" id="input-status" class="form-control">
                      <?php foreach($vendors as $vendor): ?>
                      <option value="<?php echo $vendor['vendor_id'] ?>" ><?php echo $vendor['vendor_name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_product_id; ?></label>
                  <div class="col-sm-10">
                    <select name="product_id" id="input-status" class="form-control">
                      <?php foreach($products as $product): ?>
                      <option value="<?php echo $product['product_id'] ?>" ><?php echo $product['name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_product_price; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="product_price" value="<?php echo $product_price; ?>" placeholder="<?php echo $entry_product_price; ?>" id="input-sort-order" class="form-control" />
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_promo_code; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="promo_code" value="<?php echo $promo_code; ?>" placeholder="<?php echo $entry_promo_code; ?>" id="input-sort-order" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_promo_price; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="promo_price" value="<?php echo $promo_price; ?>" placeholder="<?php echo $entry_promo_price; ?>" id="input-sort-order" class="form-control" />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                  <div class="col-sm-10">
                    <select name="status" id="input-status" class="form-control">
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
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                  <div class="col-sm-10">
                    <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
           
           
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>