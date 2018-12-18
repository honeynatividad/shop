<?php

/* 
 * Aurumpay Model
 * by HCN 
 */

class ModelPaymentDragonpay extends Model {

    public function getMethod($address) {
        
        $this->load->language('payment/dragonpay');
        
    if ($this->config->get('dragonpay_status')) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('dragonpay_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
        
            if (!$this->config->get('dragonpay_geo_zone_id')) {
                $status = TRUE;
            } elseif ($query->num_rows) {
            $status = TRUE;
            } else {
            $status = FALSE;
            }   
        } else {
            $status = FALSE;
    }
        
    $method_data = array();
    
    if ($status) {  
            $method_data = array( 
                'code'         => 'dragonpay',
            'title'      => $this->language->get('text_title'),
        'terms'      => '',
        'image' =>  $this->language->get('text_image'),
        'sort_order' => $this->config->get('dragonpay_sort_order')
            );
        }
   
        return $method_data;
    }

}