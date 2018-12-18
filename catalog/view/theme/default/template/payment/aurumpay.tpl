<?php

/* 
 * Aurumpay View
 * by HCN 
 */
?>
<div style="text-align:right;">
    <a href="http://www.aurumpay.com" target="New">
        <img src="image/payment/aurumpay.png" alt="Aurumpay" title="Aurumpay" style="border: 1px solid #EEEEEE;" />
    </a>
</div>
<div style="text-align:right;font-weight:bold;">
    Please note that your Payment will be processed by Aurumpay. <br/>
    The Name of Aurumpay will be shown on your Credit Card / Bank Statement <br/>
    and you will also receive a notification e-mail from Aurumpay on this Transaction.
</div>

<form action="<?php echo $action; ?>" method="post" id="payment">
	
	
    <div class="buttons">
    <div class="pull-right">
      <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" onclick="$('#payment').submit();"/>
    </div>
  </div>
</form>