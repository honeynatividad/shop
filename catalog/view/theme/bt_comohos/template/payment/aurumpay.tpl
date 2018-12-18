<?php

/* 
 * Aurumpay View
 * by HCN 
 */
?>
<div style="text-align:right;">
    <a href="http://www.aurumpay.com" target="New">
        <img src="image/catalog/philcare/aurumpay-logo.png" alt="Aurumpay" title="Aurumpay" style="border: 1px solid #EEEEEE;" />
    </a>
</div>
<div style="text-align:right;font-weight:bold;">
    Please take note that your payment will be processed by Aurumpay. <br>
    You will receive a notification e-mail from Aurumpay on this transaction.
</div>

<form action="<?php echo $action; ?>" method="post" id="payment">
	
	
    <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" onclick="$('#payment').submit();"/>
    </div>
  </div>
</form>