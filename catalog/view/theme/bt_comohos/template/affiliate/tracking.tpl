<?php echo $header; ?>
<div class="container">
  <div class="row bt-breadcrumb">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
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
      <h1 class="block-title"><?php echo $heading_title; ?></h1>
      <p><?php echo $text_description; ?></p>
      <form class="form-horizontal">
        <div class="">
          <label class="control-label" for="input-code"><?php echo $entry_code; ?></label>
            <textarea cols="40" rows="5" placeholder="<?php echo $entry_code; ?>" id="input-code" class="form-control"><?php echo $code; ?></textarea>
        </div>
        <div class="">
          <label class="control-label" for="input-generator"><span data-toggle="tooltip" title="<?php echo $help_generator; ?>"><?php echo $entry_generator; ?></span></label>
            <input type="text" name="product" value="" placeholder="<?php echo $entry_generator; ?>" id="input-generator" class="form-control" />
        </div>
        <div class="">
          <label class="control-label" for="input-link"><?php echo $entry_link; ?></label>
            <textarea name="link" cols="40" rows="5" placeholder="<?php echo $entry_link; ?>" id="input-link" class="form-control"></textarea>
        </div>
      </form>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-blue"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=affiliate/tracking/autocomplete&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['link']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'product\']').val(item['label']);
		$('textarea[name=\'link\']').val(item['value']);	
	}	
});
//--></script> 
<?php echo $footer; ?> 