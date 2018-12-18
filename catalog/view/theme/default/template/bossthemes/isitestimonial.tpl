<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div class="bt-breadcrumb">
<div class="container">
  <ul class="breadcrumb">
	<h2><?php echo $heading_title; ?></h2>
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
</div>
<div class="container"><div class="row">
<div id="content">	
  	<strong><?php echo $text_conditions ?></strong><br/><br/>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="testimonial">
	<div class="content">
        <table width="100%">
          <tr>
            <td><?php echo $entry_title ?><br />
              <input class="form-control" type="text" name="title" value="<?php echo $title; ?>" size = 90 />
              <?php if ($error_title) { ?>
              <span class="error"><?php echo $error_title; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_enquiry ?><span class="required">*</span><br />
              <textarea class="form-control" name="description" rows="10"><?php echo $description; ?></textarea>
              <?php if ($error_enquiry) { ?>
              <span class="error"><?php echo $error_enquiry; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $entry_name ?><br />
              <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" />
              <?php if ($error_name) { ?>
              <span class="error"><?php echo $error_name; ?></span>
              <?php } ?>
		</td>
          </tr>
          <tr>
             <td><?php echo $entry_city ?><br />
			<input class="form-control" type="text" name="city" value="<?php echo $city; ?>" />
		</td>
          </tr>
          <tr>
            <td>
		  <?php echo $entry_email ?><br />
              <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" />
              <?php if ($error_email) { ?>
              <span class="error"><?php echo $error_email; ?></span>
              <?php } ?></td>
          </tr>
          <tr>
            <td><br><?php echo $entry_rating; ?> &nbsp;&nbsp;&nbsp; <span><?php echo $entry_bad; ?></span>&nbsp;
        		<input type="radio" name="rating" value="1" style="margin: 0;" <?php if ( $rating == 1 ) echo 'checked="checked"';?> />
        		&nbsp;
        		<input type="radio" name="rating" value="2" style="margin: 0;" <?php if ( $rating == 2 ) echo 'checked="checked"';?> />
        		&nbsp;
        		<input type="radio" name="rating" value="3" style="margin: 0;" <?php if ( $rating == 3 ) echo 'checked="checked"';?> />
        		&nbsp;
        		<input type="radio" name="rating" value="4" style="margin: 0;" <?php if ( $rating == 4 ) echo 'checked="checked"';?> />
        		&nbsp;
        		<input type="radio" name="rating" value="5" style="margin: 0;" <?php if ( $rating == 5 ) echo 'checked="checked"';?> />
        		&nbsp; <span><?php echo $entry_good; ?></span><br /><br>

          	</td>
          </tr>
          <tr>
            <td>
              <?php if ($error_captcha) { ?>
              <span class="error"><?php echo $error_captcha; ?></span>
              <?php } ?>
              
              <img src="index.php?route=tool/captcha" /> <br>
		<?php echo $entry_captcha; ?><span class="required">*</span> <br>

              <input class="form-control" type="text" name="captcha" value="<?php echo $captcha; ?>" /><br>
		</td>
          </tr>		  
        </table>
	  </div>
      <div class="buttons">
        <table>
          <tr>
            <td><a  onclick="$('#testimonial').submit();" class="btn"><span><?php echo $button_send; ?></span></a></td>
			<td align="right"><a class="btn" href="<?php echo $showall_url;?>"><span><?php echo $show_all; ?></span></a></td>
          </tr>
        </table>

      </div>
    </form>
</div>
</div>
</div>
<?php echo $footer; ?> 