<?php

echo '<div style="text-align:right;"><a href="http://www.ipay88.com" target="New"><img src="image/payment/ipay88.png" alt="iPay88" title="iPay88" style="border: 1px solid #EEEEEE;" /></a></div>';
echo '<div style="text-align:right;font-weight:bold;">'."Please note that your Payment is processed by Mobile88.com Sdn Bhd. <br/>The Name of iPay88/Mobile88.com will be shown on your Credit Card / Bank Statement <br/>and you will also receive a notification e-mail from iPay88/Mobile88 on this Transaction.".'</div>';

?>

<form action="<?php echo $action; ?>" method="post" id="payment">
	<input type="hidden" name="MerchantCode" value="<?php echo $MerchantCode; ?>" />
	<input type="hidden" name="RefNo" value="<?php echo $RefNo; ?>" />
	<input type="hidden" name="Amount" value="<?php echo $Amount; ?>" />
	<input type="hidden" name="Currency" value="<?php echo $Currency; ?>" />
	<input type="hidden" name="ProdDesc" value="<?php echo $ProdDesc; ?>" />
	<input type="hidden" name="UserName" value="<?php echo $UserName; ?>" />
	<input type="hidden" name="UserEmail" value="<?php echo $UserEmail; ?>" />
	<input type="hidden" name="UserContact" value="<?php echo $UserContact; ?>" />
	<input type="hidden" name="Remark" value="<?php echo $Remark; ?>" />
	<input type="hidden" name="Lang" value="<?php echo $Lang; ?>" />
	<input type="hidden" name="Signature" value="<?php echo $Signature; ?>" />
	<input type="hidden" name="ResponseURL" value="<?php echo $ResponseURL; ?>" />
	<input type="hidden" name="BackendURL" value="<?php echo $BackendURL; ?>" />
	
    <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" onclick="$('#payment').submit();"/>
    </div>
  </div>
</form>