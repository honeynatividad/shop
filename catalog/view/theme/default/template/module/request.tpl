<div class="box block boss_blog-cat">
  <div class="box-heading block-title">
    <div><h1><?php echo $heading_title; ?></h1></div>
  </div>
  <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      
      

	<div class="panel panel-default">
      	<div class="panel-body">
			<div class="row">
    			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        			<fieldset>
          				<h3><?php echo $text_contact; ?></h3>
          				<div class="required">
            				<label class="control-label" for="input-name"><?php echo $entry_name; ?></label>
              				<input type="text" name="name" value="<?php echo $name; ?>" id="input-name" class="form-control" />
              				<?php if ($error_name) { ?>
              				<div class="text-danger"><?php echo $error_name; ?></div>
              				<?php } ?>
          				</div>
          				<div class="required">
            				<label class="control-label" for="input-email"><?php echo $entry_email; ?></label>
              				<input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
              				<?php if ($error_email) { ?>
              				<div class="text-danger"><?php echo $error_email; ?></div>
              				<?php } ?>
          				</div>
          				
        			</fieldset>
        			<div class="buttons">
          				<div class="pull-left">
            				<input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>" />
          				</div>
        			</div>
				</form>
        	</div>
        </div>
      
    </div>
</div>
<script type="text/javascript">
	$('document').ready(function(){			
		$('#boss-blog-category li.sub_child').prepend('');
		$('#boss-blog-category li.sub_child > p').click(function(){			
			if ($(this).text() == '+'){
				$(this).parent('li').children('ul.blog_child').slideDown(300);
				$(this).text('-');
			}else{
				$(this).parent('li').children('ul.blog_child').slideUp(300);
				$(this).text('+');
			}  
			
		});				
	});
</script>