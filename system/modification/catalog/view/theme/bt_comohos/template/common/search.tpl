<div id="bt-search" class="input-group">
	<a class="icon_search" href=""><i class="fa fa-search"></i></a>
	<div class="search-form">
	<div id="search" class="input-group">
	  <input type="text" name="search" value="<?php echo $search; ?>" placeholder="<?php echo $text_search; ?>" class="form-control input-lg" />
	  <span class="input-group-btn">
		<button type="button" class="btn btn-default btn-lg"><i class="fa fa-search"></i></button>
	  </span>
	</div>

			<script type="text/javascript">
				var status = <?php echo $status; ?>;
				var image = <?php echo $image; ?>;
				var price = <?php echo $price; ?>;
				var limit = <?php echo $limit; ?>;
				var url = "<?php echo $url_prod; ?>";
				if (status == 1) {
					$('input[name=\'search\']').autocomplete({
						source: function (request, response) {
							$.ajax({
								url: 'index.php?route=module/boss_search_autocomplete&limit=' + limit + '&filter_name=' + encodeURIComponent(request),
								dataType: 'json',
								success: function (json) {
									response($.map(json, function (item) {
										return {
											label: item['name'],
											value: item['product_id'],
											price: item['price'],
											image: item['image']
										}
									}));
								}
							});
						},
					});
				}
			</script>
			
	</div>

			<script type="text/javascript">
				var status = <?php echo $status; ?>;
				var image = <?php echo $image; ?>;
				var price = <?php echo $price; ?>;
				var limit = <?php echo $limit; ?>;
				var url = "<?php echo $url_prod; ?>";
				if (status == 1) {
					$('input[name=\'search\']').autocomplete({
						source: function (request, response) {
							$.ajax({
								url: 'index.php?route=module/boss_search_autocomplete&limit=' + limit + '&filter_name=' + encodeURIComponent(request),
								dataType: 'json',
								success: function (json) {
									response($.map(json, function (item) {
										return {
											label: item['name'],
											value: item['product_id'],
											price: item['price'],
											image: item['image']
										}
									}));
								}
							});
						},
					});
				}
			</script>
			
</div>

			<script type="text/javascript">
				var status = <?php echo $status; ?>;
				var image = <?php echo $image; ?>;
				var price = <?php echo $price; ?>;
				var limit = <?php echo $limit; ?>;
				var url = "<?php echo $url_prod; ?>";
				if (status == 1) {
					$('input[name=\'search\']').autocomplete({
						source: function (request, response) {
							$.ajax({
								url: 'index.php?route=module/boss_search_autocomplete&limit=' + limit + '&filter_name=' + encodeURIComponent(request),
								dataType: 'json',
								success: function (json) {
									response($.map(json, function (item) {
										return {
											label: item['name'],
											value: item['product_id'],
											price: item['price'],
											image: item['image']
										}
									}));
								}
							});
						},
					});
				}
			</script>
			