<div class="bt-contact-me">
<div class="box-heading"><h3><?php echo $heading_title; ?></h3></div>
<div class="box-content">
    <form id="contact" class="frm_contact">
		<div class="input-name">
			<input class="form-control " size="25" type="text" value="" placeholder="<?php echo $entry_name; ?>" name="contact_name" id="contact_name" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" />
		</div>
		<div class="input-email">
			<input class="form-control" size="25" type="text" value="" placeholder="<?php echo $entry_email; ?>" name="contact_mail" id="contact_mail" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue" >
		</div>
		
		<div class="input-message">
			<textarea class="form-control" name="contact_msg" placeholder="<?php echo $entry_msg; ?>" onfocus="if(this.value==this.defaultValue)this.value=''" onblur="if(this.value=='')this.value=this.defaultValue"></textarea>
		</div>
		
		<a class="btn btn-primary" id="b_button_contact" onclick="contact_sub('.frm_contact')"><?php echo $entry_send_msg; ?></a>
		
		<div id="contact_result"></div>
	</form>
</div>
</div>
<script type="text/javascript">
function contact_sub(id){ 
	$.ajax({
			type: 'post',
			url: 'index.php?route=module/boss_contactme/contact',
			dataType: 'json',
			data:$("#contact").serialize(),
			beforeSend: function() {
			$('.success, .warning').remove();
				$(id+' #b_button_contact').button('loading');						
			},		
			success: function(json) {
				$(id+' #b_button_contact').button('reset');
				if (json['error']) {
					$(id+' #contact_result').html('<span class="error">' + json['error'] + '</span>');
				}
				
				if (json['success']) {					
					$(id+' #contact_result').html('<span class="success">' + json['success'] + '</span>');
					$('#contact').find('input:text, textarea').val('');
				}
			}			
	}); 
}
</script>