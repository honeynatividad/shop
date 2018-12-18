<?php global $config;?>


<?php if($config->get('boss_manager')){
		$boss_manager = $config->get('boss_manager'); 
	}else{
		$boss_manager = '';
	} ?>
<?php 
	if(!empty($boss_manager)){
		$other = $boss_manager['other']; 
	}
	
?>
<?php
	$grid_view = explode("_",$other['grid_view']);
	//echo '<pre>'; print_r($boss_manager);die(); echo '</pre>';
?>

<script type="text/javascript">
$(document).ready(function() {
	// Product List
	$('#list-view').click(function() {
		$('#content .product-layout').attr('class', 'product-layout product-list col-xs-12');

		localStorage.setItem('display', 'list');
	});

	// Product Grid
	$('#grid-view').click(function() {
		// What a shame bootstrap does not take into account dynamically loaded columns
		cols = $('#column-right, #column-left').length;

		if (cols == 2) {
			$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-<?php echo $grid_view[0]; ?> col-md-<?php echo $grid_view[0]; ?> col-sm-<?php echo $grid_view[0]; ?> col-xs-12');
		} else if (cols == 1) {
			$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-<?php echo $grid_view[1]; ?> col-md-<?php echo $grid_view[1]; ?> col-sm-<?php echo $grid_view[1]; ?> col-xs-12');
		} else {
			$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-<?php echo $grid_view[2]; ?> col-md-<?php echo $grid_view[2]; ?> col-sm-<?php echo $grid_view[2]; ?> col-xs-12');
		}

		localStorage.setItem('display', 'grid');
	});
	if (localStorage.getItem('display') == 'list') {
		$('#list-view').trigger('click');
	} else {
		$('#grid-view').trigger('click');
	}
});
</script>