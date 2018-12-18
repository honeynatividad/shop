<?php  
class ThemeControlHelper extends Controller {
	private $layout_id = 0;
	private $theme = '';
	private $positions = array();
	private $positions_load = array();
	private $modulesList = array();
	/**
	getInstance
	**/
	public static function getInstance($registry,$theme='default'){
		static $_instance;
		if( !$_instance ){
			$_instance = new ThemeControlHelper($registry,$theme);
		}
		return $_instance;
	}
	
	/**
	__construct
	**/
	public function __construct($registry,$theme){
		$this->positions = array(
			'header',
			'mainmenu',
			'slideshow',
			'footer',
			'footer_top',
			'footer_middle');
			
		parent::__construct( $registry );
		//$this->modules = $this->loadModules();
	}
	
	/**
	getModulesByPosition
	**/
	public function getModulesByPosition( $position ){
		$layout_id = $this->getLayoutId();
		$this->load->model('bossthemes/bossthemes');
		$modules = $this->model_bossthemes_bossthemes->getLayoutModulesByPosition($position);
		
		$data = array();
		foreach ($modules as $module) {
			if($module['layout_id'] == 9999 || $module['layout_id'] == $layout_id){		
				$part = explode('.', $module['code']);
				
				if (isset($part[0])) {
					$code = $part[0];
				}
				
				if ($code && $this->config->get($code . '_status')) { 
					$setting = $this->config->get($code . '_module');
					
					if (isset($part[1]) && isset($setting[$part[1]])) {
						$data['modules'] = $this->load->controller('module/' . $code, $setting[$part[1]]);
					} else {
						$data['modules'] = $this->load->controller('module/' . $code);
					}			
				}
			}
		}
		return $data;
		
	}
	
	/**
	getLayoutId();
	**/
	public function getLayoutId(){	
		$this->load->model('design/layout');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('catalog/information');
		if(!$this->layout_id) {
			if (isset($this->request->get['route'])) {
				$route = (string)$this->request->get['route'];
			} else {
				$route = 'common/home';
			}

			$layout_id = 0;

			if ($route == 'product/category' && isset($this->request->get['path'])) {
				$path = explode('_', (string)$this->request->get['path']);

				$layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
			}

			if ($route == 'product/product' && isset($this->request->get['product_id'])) {
				$layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
			}

			if ($route == 'information/information' && isset($this->request->get['information_id'])) {
				$layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
			}

			if (!$layout_id) {
				$layout_id = $this->model_design_layout->getLayout($route);
			}

			if (!$layout_id) {
				$layout_id = $this->config->get('config_layout_id');
			}
				
			$this->layout_id = $layout_id;
		}		
		return $this->layout_id;
	}
	
	/*public function getBlockByPosition($position_d) {
		$boss_block_data = array();
		$boss_block_data = $this->config->get($position_d);
		if(isset($boss_block_data['content'][$this->config->get('config_language_id')])){
			$block_content = html_entity_decode($boss_block_data['content'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}else{
			$block_content ='';
		}
		if ($boss_block_data['status']==1){	
			return $block_content; 
		} 
	}*/
	
}
?>