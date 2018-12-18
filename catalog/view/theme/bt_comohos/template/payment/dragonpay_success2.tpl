<?php echo $header; ?>
<div class="container">
  <div class="row bt-breadcrumb">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  </div>
  <div class="row"><?php echo $column_left; ?>
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
      


        <table class="table table-bordered">
          <thead>
            <th class="health-tables" colspan="2">Order Details</th>
          </thead>
          <tbody>
            <tr>
              <td>
                <p>Order ID: <?php echo $orders['order_id'] ?></p>
                <p>Date Added: <?php echo $orders['date_added'] ?></p>
                <p>Payment Method: <?php echo $orders['payment_method'] ?></p>
                <p>Shipping Method: <?php echo $orders['shipping_method'] ?></p>
              </td>
              <td>
                <p>Email: </p>
                <p>Telephone</p>
                <p>Order Status</p>
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered">
          <thead>
            <th class="health-tables">Payment Address</th>
            <th class="health-tables">Shipping Address</th>
          </thead>
          <tbody>
            <tr>
              <td>
                <p>
                  <?php echo $orders['payment_firstname'] ?> <?php echo $orders['payment_lastname'] ?>                    
                </p>
                <?php
                if(isset($orders['payment_company'])){
                  echo "<p>".$orders['payment_company']."</p>";
                }
                if(isset($orders['payment_address_1'])){
                  echo "<p>".$orders['payment_address_1']."</p>";
                }
                if(isset($orders['payment_address_2'])){
                  echo "<p>".$orders['payment_address_2']."</p>";
                }
                if(isset($orders['payment_postcode'])){
                  echo "<p>".$orders['payment_postcode']."</p>";
                }
                if(isset($orders['payment_city'])){
                  echo "<p>".$orders['payment_city']."</p>";
                }
                if(isset($orders['payment_zone'])){
                  echo "<p>".$orders['payment_zone']."</p>";
                }
                if(isset($orders['payment_country'])){
                  echo "<p>".$orders['payment_country']."</p>";
                }

                ?>
                
              </td>
              <td>
                <?php
                if(isset($orders['shipping_firstname'])){
                  echo "<p>".$orders['shipping_firstname']." .".$orders['shipping_lastname']."</p>";
                }
                if(isset($orders['shipping_company'])){
                  echo "<p>".$orders['shipping_company']."</p>";
                }
                if(isset($orders['shipping_address_1'])){
                  echo "<p>".$orders['shipping_address_1']."</p>";
                }
                if(isset($orders['shipping_address_2'])){
                  echo "<p>".$orders['shipping_address_2']."</p>";
                }
                if(isset($orders['shipping_postcode'])){
                  echo "<p>".$orders['shipping_postcode']."</p>";
                }
                if(isset($orders['shipping_city'])){
                  echo "<p>".$orders['shipping_city']."</p>";
                }
                if(isset($orders['shipping_zone'])){
                  echo "<p>".$orders['shipping_zone']."</p>";
                }
                if(isset($orders['shipping_country'])){
                  echo "<p>".$orders['shipping_country']."</p>";
                }
                ?>
              </td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered">
          <thead class="health-tables">
            <th>Product</th>
            <th>Model</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
          </thead>
          <tbody>
            <?php foreach($products as $product): ?>
            <tr>
              <td><?php echo $product['name'] ?></td>
              <td><?php echo $product['model'] ?></td>
              <td><?php echo $product['quantity'] ?></td>
              <td><?php echo $product['price'] ?></td>
              <td><?php echo $product['total'] ?></td>
            </tr>
          <?php endforeach; ?>
          <tr>
            <td colspan="4" align="right"><b>Sub-Total</b></td>
            <td>PHP <?php echo $orders['subtotal'] ?></td>
          </tr>
          <tr>
            <td colspan="4" align="right"><b><?php echo $orders['shipping_method'] ?></b></td>
            <td>PHP</td>
          </tr>
          <tr>
            <td colspan="4" align="right"><b>Total</b></td>
            <td>PHP <?php echo $orders['total']  ?></td>
          </tr>
          </tbody>
        </table>
        <script type="text/javascript"><!--
setTimeout('location = \'<?php echo $continue; ?>\';', 2500);
//--></script>
     
      <?php 
      //echo '<pre>';
      //print_r($orders); 
      //echo '</pre>';
      ?>
      
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>