<?php
class ModelTotalCustomot extends Model {

  public function getTotal($total) {

    //$this->load->language('total/customot');

    // get customtax
    //$customtax_percentage = $this->config->get('customot_customtax');
   
    $this->load->language('total/customot');

    $sub_total = $this->config->get('customot_customtax');

    $sub = $this->cart->getSubTotal();
    if($sub==0){

    }else{
        $total['totals'][] = array(
        'code'       => 'customot',
        'title'      =>  $this->language->get('text_customot'),
        'value'      => $sub_total,
        'sort_order' => $this->config->get('customot_sort_order')
      );

      $total['total'] += $sub_total;
    }

    
 
 /*
    $total_data[] = array(
        'code'       => 'customot',
        'title'      => $this->language->get('text_customot'),
        'value'      => $customtax_percentage ,
        'sort_order' => $this->config->get('customot_sort_order')
    );
    $total['total'] += $customtax_percentage ;

*/

  }
}