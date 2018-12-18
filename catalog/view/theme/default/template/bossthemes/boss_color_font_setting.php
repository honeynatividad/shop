<?php global $config; 
 $b_color=1;
 if($config->get('boss_manager')){
  $boss_manager = $config->get('boss_manager'); 
  $b_color = isset($boss_manager['color'])?$boss_manager['color']:1;
 }
 if (filesize("config_xml/color_setting.xml") == 0){
  $objXML = simplexml_load_file("config_xml/theme_color_".$b_color.".xml");
 }else{
  $objXML = simplexml_load_file("config_xml/color_setting.xml");
 }

?>
<style type="text/css">
<?php foreach($objXML->groups as $xml){ 
	foreach($xml->item as $item){ ?>
		<?php echo html_entity_decode($item->class, ENT_QUOTES, 'UTF-8'); ?> { 
			<?php if($item->style=='color') { ?>color:#<?php echo $item->value; } ?>
			<?php if($item->style=='background-color') { ?>background-color:#<?php echo $item->value; } ?>
			<?php if($item->style=='border-color') { ?>border-color:#<?php echo $item->value; } ?>
		}
<?php } } ?>
	<?php foreach($objXML->customs->item as $item){ ?>
		<?php echo html_entity_decode($item->class, ENT_QUOTES, 'UTF-8'); ?> { 
		<?php if($item->style=='color') { ?>color:#<?php echo $item->value; ?><?php if($item->important==1) echo '!important'; } ?>
		<?php if($item->style=='background-color') { ?>background-color:#<?php echo $item->value; ?><?php if($item->important==1) echo '!important'; } ?>
		<?php if($item->style=='border-color') { ?>border-color:#<?php echo $item->value; ?><?php if($item->important==1) echo '!important'; } ?>
		}
<?php  } ?>
</style>

<?php
/* Load font */
$defaultFont = array( 
	'Arial', 
	'Verdana', 
	'Helvetica', 
	'Lucida Grande', 
	'Trebuchet MS', 
	'Times New Roman', 
	'Tahoma', 
	'Georgia'
);


$objXML = simplexml_load_file("config_xml/font_setting.xml");
?>

<?php 
foreach($objXML->groups as $xml){	
	foreach($xml->item as $item){ 		 
		 $is_array = in_array($item->style, $defaultFont);		 
		 if($item->style != 'default' && ($is_array==false)) {
			array_push($defaultFont,$item->style.'');
			
		 ?>			
		<link href='https://fonts.googleapis.com/css?family=<?php echo $item->style;?>' rel='stylesheet' type='text/css'>
		<?php }
} } ?>
<?php 
/* load font custom google */
	foreach($objXML->customs->item as $item){ 		 
		 $is_array = in_array($item->style, $defaultFont);
		 if($item->style != 'default' && ($is_array==false)) {
			array_push($defaultFont,$item->style.'');
		 ?>
			<link href='https://fonts.googleapis.com/css?family=<?php echo $item->style;?>' rel='stylesheet' type='text/css'>
		<?php }
} ?>

<style type="text/css">
<?php foreach($objXML->groups as $xml){	
	foreach($xml->item as $item){  ?>
		<?php $style_name =  $item->style; ?>
		<?php $size_name =  $item->size; ?>
		<?php $weight_name =  $item->weight; ?>
		<?php $transform_name =  $item->transform; ?>
		<?php $class_name =  $item->class_name; ?>
		<?php echo html_entity_decode($class_name, ENT_QUOTES, 'UTF-8'); ?> { 
				<?php if($item->style != 'default') {
				$fontStyle = str_replace("+", " ", $item->style); ?>
				font-family: <?php echo $fontStyle ?>;
				<?php } ?>
				<?php if($item->size != 'default') { ?> 
				font-size: <?php echo $item->size; ?>;
				<?php } ?>
				<?php if($item->weight != 'default' && $item->weight != 'italic') { ?>
				font-weight: <?php echo $item->weight; ?>;
				<?php }else if($item->weight != 'default'){ ?>
				font-style: <?php echo $item->weight; ?>;
				<?php } ?>
				<?php if($item->transform != 'default') { ?>
				text-transform: <?php echo $item->transform; ?>;
				<?php } ?>
			}
<?php } } ?>
<?php foreach($objXML->customs->item as $item){ 	
	  ?>
		<?php $style_name =  $item->style; ?>
		<?php $size_name =  $item->size; ?>
		<?php $weight_name =  $item->weight; ?>
		<?php $transform_name =  $item->transform; ?>
		<?php $class_name =  $item->class_name; ?>
		<?php echo html_entity_decode($class_name, ENT_QUOTES, 'UTF-8'); ?> { 
				<?php if($item->style != 'default') {
				$fontStyle = str_replace("+", " ", $item->style); ?>
				font-family: <?php echo $fontStyle ?>;
				<?php } ?>
				<?php if($item->size != 'default') { ?> 
				font-size: <?php echo $item->size; ?>;
				<?php } ?>
				<?php if($item->weight != 'default' && $item->weight != 'italic') { ?>
				font-weight: <?php echo $item->weight; ?>;
				<?php }else if($item->weight != 'default') { ?>
				font-style: <?php echo $item->weight; ?>;
				<?php } ?>
				<?php if($item->transform != 'default') { ?>
				text-transform: <?php echo $item->transform; ?>;
				<?php } ?>
			}
<?php } ?>
</style>
<?php //die();?>
