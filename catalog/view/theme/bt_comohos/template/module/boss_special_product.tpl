<div id="countsp">
	<div class="devi-special">
		<p>Only: <span><?php echo $devi_special.'%'; ?></span></p>
	</div>
	<div class="status-special">
		<h3><?php echo $text_time_offer; ?></h3>
	</div>
	<div id="expirycount" class="remain-time">
		<div id="specialproductcount"></div>
	</div>
</div>
<script type="text/javascript"><!--
var myVar=setInterval(function(){Deal()},1000);
function Deal(){
		var today = new Date().getTime();
		
		var dateStr = "<?php echo $date_end; ?>";
		
		var date = dateStr.split("-");
		
		var date_end = new Date(date[0],(date[1]-1),date[2]);
		
		var deal = new Date();
		
		deal.setTime(date_end - today);
		
		if(date_end >= today){
		
		var month = new Date(deal.getMonth(), deal.getMonth(), 0).getDate();
		
		var d = deal.getDate() + (month*deal.getMonth());
		var h = deal.getHours() + (d * 24);
		var m = deal.getMinutes();
		var s = deal.getSeconds();
		h = checkTime(h);
		m = checkTime(m);
		s = checkTime(s);
		
		$("#specialproductcount").html('<div class="sep"></div><div><span class="number">'+h+'</span><span><?php echo $text_hours; ?></span></div><div class="sep"></div><div><span class="number">'+m+'</span><span><?php echo $text_minutes; ?></span></div><div class="sep"></div><div><span class="number">'+s+'</span><span><?php echo $text_seconds; ?></span></div>');
		}
}
function checkTime(j){
	if (j<10){
	  j="0" + j;
	}
	return j;
}
//--></script>