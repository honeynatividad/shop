<?php echo $header; ?>
<div class="container">
  <div class="row bt-breadcrumb">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
  <div class="row">
  <?php if ($attention) { ?>
  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  </div>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?>
        <?php if ($weight) { ?>
        &nbsp;(<?php echo $weight; ?>)
        <?php } ?>
      </h1>
	  
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
        <div class="table-responsive cart-info">
          <table class="table">
            <thead>
              <tr>
                <td class="image" colspan="2"><?php echo $column_name; ?></td>
                <td class="product-price"><?php echo $column_price; ?></td>
                <td class="quantity"><?php echo $column_quantity; ?></td>
                <td class="total"><?php echo $column_total; ?></td>
				<td class="remove"></td>
              </tr>
            </thead>
            <tbody>
              <?php $i=0; foreach ($products as $product) { ?>
              <tr>
				<td class="image">
                <?php if ($product['thumb']) { ?>
                  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a>
                  <?php } ?>
				</td>
                <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                  <?php if (!$product['stock']) { ?>
                  <span class="text-danger">***</span>
                  <?php } ?>
                  <?php if ($product['option']) { ?>
                  <?php foreach ($product['option'] as $option) { ?>
                  <br />
                  <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                  <?php } ?>
                  <?php } ?>
                  <?php if ($product['reward']) { ?>
                  <br />
                  <small><?php echo $product['reward']; ?></small>
                  <?php } ?>
                  <?php if ($product['recurring']) { ?>
                  <br />
                  <span class="label label-info"><?php echo $text_recurring_item; ?></span> <small><?php echo $product['recurring']; ?></small>
                  <?php } ?>
				</td>
				
                <td class="product-price"><?php echo $product['price']; ?></td>
				
                <td class="quantity">
				  <div class="input-group btn-block" style="max-width: 100px;">
				    <button onclick="changeQty('<?php echo $i;?>',0); return false;" class="decrease"><i class="fa fa-minus"></i></button>
					
                    <input id="select-number<?php echo $i; ?>" type="center" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="form-control" />
					
					<button onclick="changeQty('<?php echo $i;?>',1); return false;" class="increase"><i class="fa fa-plus"></i></button>
                  </div>
				</td>
				
                <td class="total"><?php echo $product['total']; ?></td>
				
                <td class="remove">
                    <button type="submit" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-update"><i class="fa fa-refresh"></i></button>
					<button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-remove" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i class="fa fa-times"></i></button>
				</td>
              </tr>
              <?php $i++; } ?>
              <?php foreach ($vouchers as $voucher) { ?>
              <tr>
                <td></td>
                <td class="name"><?php echo $voucher['description']; ?></td>
                <td class="model"></td>
				<td class="quantity"><span class="price"><?php echo $voucher['amount']; ?></span></td>
                <td class="product-price"><div class="input-group btn-block" style="max-width: 200px;">
                    <input type="text" name="" value="1" size="1" disabled="disabled" class="form-control" />
                <td class="total"><span class="price"><?php echo $voucher['amount']; ?></span></td>
				<td class="remove">
					<button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="button-remove" onclick="voucher.remove('<?php echo $voucher['cart_id']; ?>');"><i class="fa fa-times"></button>
				</td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </form>
      <?php if ($modules) { ?>
      <h2><?php echo $text_next; ?></h2>
      <p><?php echo $text_next_choice; ?></p>
      <div class="panel-group" id="accordion">
        <?php foreach ($modules as $module) { ?>
        <?php echo $module; ?>
        <?php } ?>
      </div>
      <?php } ?>
       <div class="cart-total">
          <table>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td class="left"><?php echo $total['title']; ?>:</td>
              <td class="right"><?php echo $total['text']; ?></td>
            </tr>
            <?php } ?>
          </table>
       </div>
      <div class="buttons">
        <div class="pull-left"><a href="<?php echo $continue; ?>" class="btn btn-gray"><?php echo $button_shopping; ?></a></div>
        <div class="pull-right"><a href="<?php echo $checkout; ?>" class="btn btn-blue"><?php echo $button_checkout; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>

<script type="text/javascript">
	
function changeQty(position,increase) {
//console.log(position);
    var qty = parseInt($('#select-number' + position+'').val());
	
    if ( !isNaN(qty) ) {
        qty = increase ? qty+1 : (qty-1 > 1 ? qty-1:1);
        $('#select-number' + position+'').val(qty);
    }else{
		$('#select-number' + position+'').val(1);
	}
	position ='';
}
</script>

</div>
<?php echo $footer; ?> 