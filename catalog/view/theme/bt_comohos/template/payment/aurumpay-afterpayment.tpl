<?php

/* 
 * Aurumpay Payment
 * View after Aurumpay transaction
 * by HCN
 */
?>
<?php echo $header; ?>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
    </ul>
    <div class="row">
        <?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
            <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
            <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
            <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>

            <h1><?php echo $heading_title; ?></h1>
            <div class="alert alert-success" role="alert">
                <p class=""><?php echo $text_message; ?></p>  
            </div>
            <div class="alert alert-success" role="alert">
                <p class=""><?php echo $text_success_wait; ?></p>  
            </div>
      


        
        <script type="text/javascript"><!--
            setTimeout('location = \'<?php echo $continue; ?>\';', 9500);
    //--></script>

           
        </div>
    </div>
    
</div>
<?php echo $footer; ?>