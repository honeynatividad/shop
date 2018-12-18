<div class="box bt-manufacturer not-animated" data-animate="fadeInLeft" data-delay="200">
	<div class="box-heading"><h1><?php echo $heading_title; ?></h1></div>
	<div class="box-content">
	  <select class="boss-select" onchange="location = this.value">
        <?php foreach ($manufacturers as $manufacturer) { ?>
        <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
        <option value="<?php echo $manufacturer['href']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $manufacturer['href']; ?>"><?php echo $manufacturer['name']; ?></option>
        <?php } ?>
        <?php } ?>
	  </select>
	</div>
</div>