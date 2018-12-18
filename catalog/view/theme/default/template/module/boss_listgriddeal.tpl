<div class="bt-list-grid-deal">
	<div class="box-heading"><h1><?php echo $heading_title; ?></h1></div>
	<div class="box-content">
	<div class="row">
		<?php foreach($listgridproducts as $key_lg => $listgridproduct) { ?>
		<div class="column-list-grid <?php echo ($column != 12)?'col-sm-'.$column.' col-xs-12':'';?>">
		  <?php if(isset($listgridproduct['title']) && $listgridproduct['title']) { ?><div class="heading-title"><h2><?php echo $listgridproduct['title']; ?></h2></div><?php } ?>
		  <div class="column-content">
		  <?php foreach($listgridproduct['products'] as $key => $product) { ?>
		  <?php $per_row = 12/(int)$listgridproduct['per_row']; ?>
		  <div class="product-thumb <?php echo($listgridproduct['list_grid']?'product-grid':'product-list')?> <?php echo ($per_row != 12)?'col-sm-'.$per_row.' col-xs-12':''; ?>">
			<div class="image <?php echo $class_label; ?>"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
				<?php if ($listgridproduct['list_grid']) { ?>
					<div class ="sale-info sale-grid">
						<?php if ($product['rating']) { ?>
					<div class="rating">
					  <?php for ($i = 1; $i <= 5; $i++) { ?>
					  <?php if ($product['rating'] < $i) { ?>
					  <span class="fa fa-stack fa-hidden"><i class="fa fa-star-o fa-stack-2x"></i></span>
					  <?php } else { ?>
					  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i></span>
					  <?php } ?>
					  <?php } ?>
					</div>
					<?php } ?>
						<?php if($product['count_sell']){ ?>
						<p class="count-sell"><?php echo $product['count_sell']; ?> Bought</p>
						<?php } ?>
						<?php if($show_countdown){ ?>
						<div class="lg-datetime<?php echo $module.$key_lg.$key; ?> remain-time"></div>
						<?php } ?>
					</div>
				<?php } ?>
				</div>
			
			<div class="caption">
				<div class="name"><a title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>	
				<?php if($product['percent']){?>
					<div class="percent">
						<span><?php echo $product['percent'];?>%</span>
					</div>
				<?php } ?>
				<p class="price">
					<?php if (!$product['special']) { ?>
					<?php echo $product['price']; ?>
					<?php } else { ?>
					<span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
					<?php } ?>
				</p>
				<div class="button-group bt-button-group">
					<button type="button" onclick="btadd.cart('<?php echo $product['product_id']; ?>');" class="btn-cart"><i class="fa fa-shopping-cart"></i>Buy Now</button>
					<button class="btn-wishlist" type="button" title="<?php echo $button_wishlist; ?>" onclick="btadd.wishlist('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
					<button class="btn-compare" type="button" title="<?php echo $button_compare; ?>" onclick="btadd.compare('<?php echo $product['product_id']; ?>');"><i class="fa fa-retweet"></i></button>
				</div>
			</div>
		  </div>
		  <?php } ?>
		  </div>
		</div>
		<?php } ?>
	</div>
	</div>
</div>
<?php if($show_countdown){ ?>
<script type="text/javascript"><!--
<?php if (!empty($listgridproducts)) { ?>
	<?php foreach ($listgridproducts as $key_lg => $listgridproduct) { ?>
var myVar=setInterval(function(){DealCategory<?php echo $module.$key_lg; ?>()},1000);
var deals_filter_cate<?php echo $module.$key_lg; ?> = '<?php echo $deals_filter; ?>';
var auto_repeat_cate<?php echo $module.$key_lg; ?> = <?php echo $auto_repeat; ?>;
var repeat_day_cate<?php echo $module.$key_lg; ?> = <?php echo $repeat_day; ?>;
var repeat_week_cate<?php echo $module.$key_lg; ?> = <?php echo $repeat_week; ?>;
var repeat_month_cate<?php echo $module.$key_lg; ?> = <?php echo $repeat_month; ?>;
var repeat_year_cate<?php echo $module.$key_lg; ?> = <?php echo $repeat_year; ?>;
function DealCategory<?php echo $module.$key_lg; ?>(){
	var i = 0;
	<?php if (!empty($listgridproduct['products'])) { ?>
	<?php foreach ($listgridproduct['products'] as $key => $product) { ?>
	
		var today = new Date();
		
		var dateStr = "<?php echo $product['date_end']; ?>";
		//alert(dateStr);
		if (dateStr != "0000-00-00") {
			var date = dateStr.split("-");
			
			var date_end = new Date(date[0],(date[1]-1),date[2]);
			
			var deal = new Date();
			
			deal.setTime(date_end - today);
			
			if(date_end >= today){
				if(deals_filter_cate<?php echo $module.$key_lg; ?> == 'day'){
					deal.setTime(today);
					var h = 23-deal.getHours();
					var m = 59-today.getMinutes();
					var s = 59-today.getSeconds();
					h = checkTime(h);
					m = checkTime(m);
					s = checkTime(s);
					if((!auto_repeat_cate<?php echo $module.$key_lg; ?> && repeat_day_cate<?php echo $module.$key_lg; ?>==getDOY()) || auto_repeat_cate<?php echo $module.$key_lg; ?>){
					$(".lg-datetime<?php echo $module.$key_lg.$key; ?>").html('<div class="deal-number"><i class="fa fa-clock-o"></i><div><span class="number">'+h+'</span></div><div><span class="number">'+m+'</span></div><div><span class="number">'+s+'</span></div></div><div class="deal-text"><span><?php echo $text_hours; ?></span><span><?php echo $text_minutes; ?></span><span><?php echo $text_seconds; ?></span></div>');
					}
				}else if(deals_filter_cate<?php echo $module.$key_lg; ?> == 'week'){
					//var week = new Date();
					var d = today.getDay();
					if(d==0){ //if today is sunday
						d=7;
					}
					d = 7-d;
					var week = new Date(today.getFullYear(),today.getMonth(),today.getDate()+d);
					if(date_end >= week){
						var h = 23-today.getHours() +(d*24);
					}else{
						var month = deal.getMonth(); 
						var d = deal.getDate() + (month*deal.getMonth());
						var h = 23-today.getHours() + ((d-1) * 24); 
					}
					var m = 59-today.getMinutes();
					var s = 59-today.getSeconds();
					h = checkTime(h);
					m = checkTime(m);
					s = checkTime(s);
					if((!auto_repeat_cate<?php echo $module.$key_lg; ?> && repeat_week_cate<?php echo $module.$key_lg; ?>==(getWeek(1) +1)) || auto_repeat_cate<?php echo $module.$key_lg; ?>){
						$(".lg-datetime<?php echo $module.$key_lg.$key; ?>").html('<div class="deal-number"><i class="fa fa-clock-o"></i><div><span class="number">'+h+'</span></div><div><span class="number">'+m+'</span></div><div><span class="number">'+s+'</span></div></div><div class="deal-text"><span><?php echo $text_hours; ?></span><span><?php echo $text_minutes; ?></span><span><?php echo $text_seconds; ?></span></div>');
					}
				}else if(deals_filter_cate<?php echo $module.$key_lg; ?> == 'month'){
					var month = new Date(today.getMonth()+1, today.getMonth()+1, 0).getDate(); 
					var d = month - today.getDate();
					var m_add = new Date(today.getFullYear(),today.getMonth(),today.getDate()+d);
					if(date_end >= m_add){
						var h = 23-today.getHours() +(d*24);
					}else{
						var month = deal.getMonth(); 
						var d = deal.getDate() + (month*deal.getMonth());
						var h = 23-today.getHours() + ((d-1) * 24);
					}
					var m = 59-today.getMinutes();
					var s = 59-today.getSeconds();
					h = checkTime(h);
					m = checkTime(m);
					s = checkTime(s);
					if((!auto_repeat_cate<?php echo $module.$key_lg; ?> && repeat_month_cate<?php echo $module.$key_lg; ?>==(today.getMonth()+1)) || auto_repeat_cate<?php echo $module.$key_lg; ?>){
						$(".lg-datetime<?php echo $module.$key_lg.$key; ?>").html('<div class="deal-number"><i class="fa fa-clock-o"></i><div><span class="number">'+h+'</span></div><div><span class="number">'+m+'</span></div><div><span class="number">'+s+'</span></div></div><div class="deal-text"><span><?php echo $text_hours; ?></span><span><?php echo $text_minutes; ?></span><span><?php echo $text_seconds; ?></span></div>');
					}
				}else if(deals_filter_cate<?php echo $module.$key_lg; ?> == 'year'){
					var month = new Date(today.getMonth()+1, today.getMonth()+1, 0).getDate(); 
					if(daysInFebruary(today.getFullYear())==29){
						var dy = 366;
					}else{
						var dy = 365;
					}
					//var test = new Date(today.getFullYear(), 0, 0); alert(test);
					var doy = getDOY(); 
					var d = dy - doy;
					var y_add = new Date(today.getFullYear(),today.getMonth(),today.getDate()+d);
					if(date_end >= y_add){
						var h = 23-today.getHours() +(d*24);
					}else{
						var month = deal.getMonth(); 
						var d = deal.getDate() + (month*deal.getMonth());
						var h = 23-today.getHours() + ((d-1) * 24);
					}
					var m = 59-today.getMinutes();
					var s = 59-today.getSeconds();
					h = checkTime(h);
					m = checkTime(m);
					s = checkTime(s);
					if((!auto_repeat_cate<?php echo $module.$key_lg; ?> && repeat_year_cate<?php echo $module.$key_lg; ?>==(today.getFullYear())) || auto_repeat_cate<?php echo $module.$key_lg; ?>){
						$(".lg-datetime<?php echo $module.$key_lg.$key; ?>").html('<div class="deal-number"><i class="fa fa-clock-o"></i><div><span class="number">'+h+'</span></div><div><span class="number">'+m+'</span></div><div><span class="number">'+s+'</span></div></div><div class="deal-text"><span><?php echo $text_hours; ?></span><span><?php echo $text_minutes; ?></span><span><?php echo $text_seconds; ?></span></div>');
					}
				}else{
					var month = new Date(deal.getMonth(), deal.getMonth(), 0).getDate();
					var d = deal.getDate() + (month*deal.getMonth());
					var h = 23-today.getHours() + ((d-1) * 24);	
					var m = 59-today.getMinutes();
					var s = 59-today.getSeconds();
					h = checkTime(h);
					m = checkTime(m);
					s = checkTime(s);
					
					$(".lg-datetime<?php echo $module.$key_lg.$key; ?>").html('<div class="deal-number"><i class="fa fa-clock-o"></i><div><span class="number">'+h+'</span></div><div><span class="number">'+m+'</span></div><div><span class="number">'+s+'</span></div></div><div class="deal-text"><span><?php echo $text_hours; ?></span><span><?php echo $text_minutes; ?></span><span><?php echo $text_seconds; ?></span></div>');
				}
				
			}
		}
	<?php } }?>
}
<?php } } ?>
function checkTime(j){
	if (j<10){
	  j="0" + j;
	}
	return j;
}
function daysInFebruary(year) {
    if(year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0)) {
        // Leap year
        return 29;
    } else {
        // Not a leap year
        return 28;
    }
}

// Get Day of Year
function getDOY() {
	var today = new Date();
	var feb = daysInFebruary(today.getFullYear());
	var aggregateMonths = [0, // January
                           31, // February
                           31 + feb, // March
                           31 + feb + 31, // April
                           31 + feb + 31 + 30, // May
                           31 + feb + 31 + 30 + 31, // June
                           31 + feb + 31 + 30 + 31 + 30, // July
                           31 + feb + 31 + 30 + 31 + 30 + 31, // August
                           31 + feb + 31 + 30 + 31 + 30 + 31 + 31, // September
                           31 + feb + 31 + 30 + 31 + 30 + 31 + 31 + 30, // October
                           31 + feb + 31 + 30 + 31 + 30 + 31 + 31 + 30 + 31, // November
                           31 + feb + 31 + 30 + 31 + 30 + 31 + 31 + 30 + 31 + 30, // December
                         ];
    return aggregateMonths[today.getMonth()] + today.getDate();
}
function getWeek(weekStart) {
	var today = new Date();
    var januaryFirst = new Date(today.getFullYear(), 0, 1);
    if(weekStart !== undefined && (typeof weekStart !== 'number' || weekStart % 1 !== 0 || weekStart < 0 || weekStart > 6)) {
      throw new Error('Wrong argument. Must be an integer between 0 and 6.');
    }
    weekStart = weekStart || 0;
    return Math.floor((((today - januaryFirst) / 86400000) + januaryFirst.getDay() - weekStart) / 7);
}

//--></script>
<?php } ?>