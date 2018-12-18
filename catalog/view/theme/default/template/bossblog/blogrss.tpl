<?php echo $header; ?>  
<div class="bt-breadcrumb">
<div class="container">
  <div class="row">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
  </div>
</div>
<div class="container">
<div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
	<div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
		<div class="rss-title"><h1><?php echo $heading_title; ?></h1>
		</div>
		<div class="box-content rss-content">
			<table border="0" style="text-align:left">
			<tr><td colspan="2"><strong><span><?php echo $heading_title; ?></span></strong></td></tr>
			<tr>
				<td><a href="index.php?route=bossblog/bossblog&rss=bossblog"><img border="0" src="image/catalog/boss_blog/rss.png" /></a></td>
				<td><a href="index.php?route=bossblog/bossblog&rss=bossblog"><?php echo $heading_title;?></a></td>
			</tr>
			<tr><td colspan="2"><strong><span><?php echo $text_rss_blog_categories;?></span></strong></td></tr>
			<?php foreach ($categories as $category) { ?>
			<tr>
				<td><a href="<?php echo $category['href']; ?>"><img border="0" src="image/catalog/boss_blog/rss.png" /></a></td>
				<td><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></td>
			</tr>
			<?php if ($category['children']) { ?>
			<?php foreach ($category['children'] as $child) { ?>
			<tr>
				<td class="child"><a href="<?php echo $child['href']; ?>"><img border="0" src="image/catalog/boss_blog/rss.png" /></a></td>
				<td class="child"><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></td>
			</tr>
			<?php } ?>
			<?php } ?>
			 <?php } ?>
			</table>
		</div>
	  <?php echo $content_bottom; ?>
	</div>	
    <?php echo $column_right; ?>
</div>
</div>
<?php echo $footer; ?>
