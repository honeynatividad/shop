

<div style="text-align:right;">
    <a href="http://www.aurumpay.com" target="New">
        <img src="image/catalog/philcare/dragonpay-logo.png" alt="Aurumpay" title="Aurumpay" style="border: 1px solid #EEEEEE;" />
    </a>
</div>
<div style="text-align:right;font-weight:bold;">
    Please take note that your payment will be processed by Dragonpay. <br>You will receive a notification e-mail from Dragonpay on this transaction.
</div>

<form action="<?php echo $action; ?>" method="post" id="payment">
	<input type="hidden" name="Amount" value="<?php echo $Amount ?>" />
	<input type="hidden" name="Description" value="<?php echo $Description ?>" />
	<input type="hidden" name="ccy" value="<?php echo $CCY ?>" />
	<input type="hidden" name="email" value="<?php echo $Email ?>" />
	<input type="hidden" name="tnxid" value="<?php echo $TransactionID ?>" />


    <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" onclick="$('#payment').submit();"/>
    </div>
  </div>
</form>