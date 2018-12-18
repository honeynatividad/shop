<?php global $config;?>
<?php
	$boss_manager = array(
		'option' => array(
			'bt_scroll_top' => true,
			'animation' 	=> true,
			'quick_view'   	=> false
		),
		'layout' => array(
			'mode_css'   => 'wide',
			'box_width' 	=> 1200,
			'h_mode_css'   => 'inherit',
			'h_box_width' 	=> 1200,
			'f_mode_css'   => 'inherit',
			'f_box_width' 	=> 1200
		),
		'status' => 1
	);
?>
<?php $footer_about = $config->get('boss_manager_footer_about'); ?>
<?php $footer_social = $config->get('boss_manager_footer_social'); ?>
<?php $footer_payment = $config->get('boss_manager_footer_payment'); ?>
<?php $footer_powered = $config->get('boss_manager_footer_powered'); ?>
<?php $footer_contact = $config->get('boss_manager_footer_contact'); ?>
<?php 
	if($config->get('boss_manager')){
		$boss_manager = $config->get('boss_manager'); 
	}else{
		$boss_manager = $boss_manager;
	} 
?>
	
<?php 
	//echo '<pre>';print_r($boss_manager); die(); echo '</pre>';
?>

<?php
	if(!empty($boss_manager)){
		$layout = $boss_manager['layout'];
		$footer_link = isset($boss_manager['footer_link'])?$boss_manager['footer_link']:'';
	}
	$f_style = '';
	if($layout['f_mode_css']=='fboxed'){
		$f_mode_css = 'bt-fboxed';
		$f_style = (!empty($layout['f_box_width']))?'style="max-width:'.$layout['f_box_width'].'px"':'';
	}else{
		$f_mode_css = '';
	}
?>
<div id="bt_footer" class="" >
	<footer>
  		<div class="bt-footer-middle">
  			<div class="container">
				<div class="row">
	  				<div class="col-md-12">	   
	  					
						<div class="bt-block-footer col-sm-4 col-xs-12">
							<div class="col-xs-12">
		  						<a href="index.php?route=common/home"><img src="image/catalog/jlt-logo.png" alt="JLT" title="JLT"/></a>
		  						<div class="box block boss-recent-post">
								    <div class="box-heading">
								        <span>Bayani Family Care Product Overview</span>
								    </div>
								    <p>Provides coverage for emergency care and hospitalization for viral and bacterial illnesses, treatment of injuries resulting from accidents except for cerebrovascular accidents (stroke) at around 500+ PhilCare accredited hospitals nationwide.</p>
								</div>  
								<div class="box block boss-recent-post">
								    <div class="box-heading">
								        <span>Includes</span>
								    </div>
								    <ul>
								    	<li>Convers special modalities of treatment which are medically necessary during ER and confinement <br>and subject to standard inner limits.</li>
								    	<li>Inclusive of diagnostic and therapeutic procedures as medically necessary during ER and confinement.</li>
								    	<li>One year unlimited frequency of availment up to plan benefit limit</li>
								    	<li>No hospital deposit requred</li>
								    	<li>Access to 500+ PhilCare affiliated hospitals nationwide <a href="https://www.philcare.com.ph/erhospitals">www.philcare.com.ph/erhospitals</a></li>
								    	<li>No medical examination required to apply</li>
								    </ul>
								</div>      

							</div>
	  					</div>

  	  					<div class="bt-block-footer col-sm-4 col-xs-12">
							<div class="col-xs-12">
		  						<a href="index.php?route=common/home"><img src="image/catalog/philcare-new-logo-small.png" alt="Comohost" title="Comohost"/></a>
		  						<p>Established in 1982, PhilCare is one of the country’s pioneering Health Maintenance Organization (HMO) companies. The company is built on a vision to allow Filipinos enjoy a better quality of life by providing them access to world-class health services.</p>		
		 
								<div class="footer-contact">
									<ul>	
										<li>
											<i class="fa fa-map-marker"></i> 
												<span>4/5F STI Holdings Center 6764 Ayala Avenue, Makati City</span>
										</li>	
										
										<li>
											<i class="fa fa-envelope-o"></i>&nbsp;<span><a href="mailto:order@philcare.com.ph">order@philcare.com.ph</a></span>
										</li>    
									</ul>
								</div>
								<div class="box block boss-recent-post">
									<hr>
								    <div class="box-heading">
								        <span>CONTACT US</span>
								    </div>
								    <ul>
								    	<li>
											<i class="fa fa-phone"></i>For Sales and Product Inquiry: 1809571036
										</li>
										<li>
											<i class="fa fa-phone"></i>For Availment Concerns and Endorsements: (02) 462-1800
										</li>
								    </ul>
								</div> 
							</div>
	  					</div>	  
	  	  				
	  	  
		  				<div class="footer-social col-xs-4">
							<h3>Follow us</h3>
							<ul>
								<li>
									<a class="facebook" href="https://www.facebook.com/BayaniFamilyCare" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
								</li>
								
								<li>
									<a class="instagram" href="https://www.instagram.com/BayaniFamilyCare" title="instagram" target="_blank"><i class="fa fa-instagram"></i></a>
								</li>
							</ul>
						</div>
	  	  			</div>
				</div>
  			</div>
  		</div>
  
	  	<div class="bt-footer-bottom">
	  		<div class="container">
	    		<div class="row">
		  			<div class="link">
						<ul class="list-unstyled">
			  		  		<li><a href="https://shop.philcare.com.ph/testsite/index.php?route=information/contact">Contact Us</a></li>
			  		        <li><a href="https://shop.philcare.com.ph/testsite/3339946C-D67E-4108-A0C8-79FB50414A1A">Products</a></li>
			  		  		
			          	</ul>
	      			</div>
		  
		  			<div class="powered-payment">
						<div class="row">
			  				<div class="powered col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div id="powered">  <p>© 2018 PhilCare Inc. All rights Reserved.</p>
								</div>		  
							</div>
			  
						</div>
		  			</div>
	    		</div>
	  		</div>
	  	</div>
	</footer>
</div>
<div id="back_top" class="back_top" title="Back To Top"><span><i class="fa fa-angle-up"></i></span></div>
 	<script type="text/javascript">
        $(function(){
			$(window).scroll(function(){
				if($(this).scrollTop()>600){
				  $('#back_top').fadeIn();
				}
				else{
				  $('#back_top').fadeOut();
				}
			});
			$("#back_top").click(function (e) {
				e.preventDefault();
				$('body,html').animate({scrollTop:0},800,'swing');
			});
        });
	</script> 
</div>

</body></html>