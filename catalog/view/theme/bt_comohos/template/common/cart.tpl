<div id="cart" class="btn-group btn-block">
  <button type="button" data-toggle="dropdown" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-block btn-lg dropdown-toggle"><i class="fa fa-shopping-cart"></i> <span id="cart-total"><?php echo $text_items; ?></span></button>
  <ul class="dropdown-menu pull-right">
    <?php if ($products || $vouchers) { ?>
    <li>
      <table class="table table-striped">
        <?php foreach ($products as $product) { ?>
        <tr>
          <td class="text-center image">
		  <div class="image"><?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail" /></a>
            <?php } ?>
			<div class="remove">
					<button type="button" onclick="cart.remove('<?php echo $product['cart_id']; ?>');" title="<?php echo $button_remove; ?>" class="btn-danger"><i class="fa fa-times"></i></button>
			</div>
		  </div>
		 </td>
          <td class="text-left name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
            <?php if ($product['option']) { ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small>
            <?php } ?>
            <?php } ?>
            <?php if ($product['recurring']) { ?>
            <br />
            - <small><?php echo $text_recurring; ?> <?php echo $product['recurring']; ?></small>
            <?php } ?>
		    <div><?php echo $product['quantity']; ?> x <span class="price"><?php echo $product['total']; ?></span></div>
		  </td>
        </tr>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <tr>
          <td class="text-center image"> 
			<div class="image">
				<div class="remove"><button type="button" onclick="voucher.remove('<?php echo $voucher['cart_id']; ?>');" title="<?php echo $button_remove; ?>" class="btn-danger"><i class="fa fa-times"></i></button></div>
			</div>	
		  </td>
          <td class="text-left">
			<div class="description"><?php echo $voucher['description']; ?></div>
			<div class="quantity">1 x <span class="price"><?php echo $voucher['amount']; ?></div>
		  </td>
        </tr>
        <?php } ?>
      </table>
    </li>
    <li>
      <div class="cart_bottom">
        <table class="minicart_total">          
          <?php foreach ($totals as $total) { ?>
          <tr>
            <td class="text-left"><span><?php echo $total['title']; ?></span></td>
            <td class="text-right"><?php echo $total['text']; ?></td>
          </tr>
          <?php } ?>
        </table>
        <div class="buttons">
		<span class="cart_bt"><a href="<?php echo $cart; ?>" class="btn"><?php echo $text_cart; ?></a></span>
		<span class="checkout_bt"><a class="btn btn-shopping" href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></span>
		</div>
      </div>
    </li>
    <?php } else { ?>
    <li>
      <p class="text-center"><?php echo $text_empty; ?></p>
    </li>
    <?php } ?>
  </ul>
</div>
