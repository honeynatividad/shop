<div id="tab-special">
  <table id="special" class="table table-striped table-bordered table-hover">
	<thead>
	  <tr>
		<td class="text-left"><?php echo $entry_customer_group; ?></td>
		<td class="text-right"><?php echo $entry_priority; ?></td>
		<td class="text-right"><?php echo $entry_price; ?></td>
		<td class="text-left"><?php echo $entry_date_start; ?></td>
		<td class="text-left"><?php echo $entry_date_end; ?></td>
		<td></td>
	  </tr>
	</thead>
	<?php $special_row = 0; ?>
	<?php if(!empty($product_specials)){?>
	<?php foreach ($product_specials as $product_special) { ?>
	<tbody id="special-row<?php echo $special_row; ?>">
	  <tr>
		<td style="width: 15%;" class="left"><select class="form-control" name="product_special[<?php echo $special_row; ?>][customer_group_id]">
			<?php foreach ($customer_groups as $customer_group) { ?>
			<?php if ($customer_group['customer_group_id'] == $product_special['customer_group_id']) { ?>
			<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
			<?php } ?>
			<?php } ?>
		  </select></td>
		<td class="right"><input class="form-control" type="text" name="product_special[<?php echo $special_row; ?>][priority]" value="<?php echo $product_special['priority']; ?>" size="2" /></td>
		<td style="width: 15%;" class="right"><input class="form-control" type="text" name="product_special[<?php echo $special_row; ?>][price]" value="<?php echo $product_special['price']; ?>" /></td>
		<td class="text-left"><div class="input-group date">
		  <input type="text" name="product_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $product_special['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />		  
		  <span class="input-group-btn">
		  <button style="font-size:12px;" class="btn btn-default"><i class="fa fa-calendar"></i></button>
		  </span></div></td>
		<td class="text-left"><div class="input-group date">
		  <input type="text" name="product_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $product_special['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />
		  <span class="input-group-btn">
		  <button style="font-size:12px;" class="btn btn-default"><i class="fa fa-calendar"></i></button>
		  </span></div></td>
		<td class="left"><a onclick="$('#special-row<?php echo $special_row; ?>').remove();" class="btn btn-danger" data-toggle="tooltip" data-original-title="<?php echo $button_remove; ?>"><i class="fa fa-times"></i></a></td>
	  </tr>
	</tbody>
	<?php $special_row++; ?>
	<?php } ?>
	<?php } ?>
	<tfoot>
	  <tr>
		<td colspan="5"></td>
		<td class="left"><a onclick="addSpecial();" class="btn btn-primary" data-toggle="tooltip" data-original-title="<?php echo $button_add_special; ?>"><i class="fa fa-pencil"></i></a></td>
	  </tr>
	</tfoot>
  </table>
</div>
<script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
	html  = '<tbody id="special-row' + special_row + '">';
	html += '  <tr>'; 
    html += '    <td style="width: 15%;" class="left"><select class="form-control" name="product_special[' + special_row + '][customer_group_id]">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '    </select></td>';
    html += '    <td class="right"><input class="form-control" type="text" name="product_special[' + special_row + '][priority]" value="" size="2" /></td>';
	html += '    <td style="width: 15%;" class="right"><input class="form-control" type="text" name="product_special[' + special_row + '][price]" value="" /></td>';
    html += '  <td class="text-left"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button style="font-size:12px;" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '  <td class="text-left"><div class="input-group date"><input type="text" name="product_special[' + special_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button style="font-size:12px;" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';
	html += '    <td class="left"><a onclick="$(\'#special-row' + special_row + '\').remove();" class="btn btn-danger" data-toggle="tooltip" data-original-title="<?php echo $button_remove; ?>"><i class="fa fa-times"></i></a></td>';
	html += '  </tr>';	
    html += '</tbody>';
	
	$('#special tfoot').before(html);
		
	$('.date').datetimepicker({
		pickTime: false
	});
	special_row++;
}

function saveSpecial(id){
	$.ajax({
		url: 'index.php?route=module/boss_special/saveProductSpecials&token=<?php echo $token; ?>&product_id=' + id,
		type: 'post',
		data: $('#special input[type=\'text\'], #special select'),
		dataType: 'json',
		success: function(json) { 
			$( "#dialog_amazon_import" ).dialog("close");
			location = json['redirect'];
			
		}
	});
}
//--></script>
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script> 