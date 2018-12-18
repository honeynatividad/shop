<?php

/* 
 * PayPal for Madanes Model
 * by HCN 
 */

class ModelPaymentMadanes extends Model {

	public function getMethod($address) {
        
        $this->load->language('payment/madanes');
		
	if ($this->config->get('madanes_status')) {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('madanes_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
            if (!$this->config->get('madanes_geo_zone_id')) {
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
                'code'         => 'madanes',
        	'title'      => $this->language->get('text_title'),
		'terms'      => '',
		'sort_order' => $this->config->get('madanes_sort_order')
            );
    	}
   
    	return $method_data;
    }

}