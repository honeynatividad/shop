<?php if (count($languages) > 1) { ?>
<div class="bt-language">
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="language">
  <div class="btn-group">
    <button class="btn btn-link dropdown-toggle" data-toggle="dropdown">
	<?php foreach ($languages as $language) { ?>
    <?php if ($language['code'] == $code) { ?>
    <img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>">
    <?php } ?>
    <?php } ?>
    <span><?php echo $code; ?></span><i class="fa fa-angle-down"></i></button>
    <ul class="dropdown-menu">
      <?php foreach ($languages as $language) { ?>
      <li><a href="<?php echo $language['code']; ?>"><span class="text-left"><?php echo $language['name']; ?></span><span class="text-right"><img src="catalog/language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" alt="<?php echo $language['name']; ?>" title="<?php echo $language['name']; ?>" /></span></a></li>
      <?php } ?>
    </ul>
  </div>
  <input type="hidden" name="code" value="" />
  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
</form>
</div>
<?php } ?>
