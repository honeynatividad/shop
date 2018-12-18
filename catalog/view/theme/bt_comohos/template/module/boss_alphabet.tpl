<div class="box bt-alphabet not-animated" data-animate="fadeInLeft" data-delay="200">
  <div class="box-heading"><h1><?php echo $heading_title; ?></h1></div>
  <div class="box-content">
    <div class="boss-alphabet">
      <ul>
        <?php foreach ($alphabet as $char) { ?>
        <li><a href="<?php echo $char['href']; ?>"><?php echo $char['char']; ?></a></li>
        <?php } ?>
      </ul>
	</div>
  </div>
</div>
