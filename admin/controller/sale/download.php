<?php
class ControllerSaleDownload extends Controller {
	private $error = array();

	/**
	* Will handle PHPExcel instance object
	*
	* @var object
	*/
	private $objPHPExcel;

	/**
	* Current order on the loop when exporting all
	*
	* @var integer
	*/
	private $mainCounter;

	/**
	* Data filter : start date
	*
	* @var string
	*/
	private $filter_date_start;

	/**
	* Data filter : end date
	*
	* @var string
	*/
	private $filter_date_end;

	/**
	* Data filter : status
	*
	* @var integer
	*/
	private $filter_order_status_id;

	/**
	* Display the module's index page
	*
	* @return response
	*/
	public function index()
	{

		$this->load->language('sale/download');
		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status'])) {
			$filter_order_status = $this->request->get['filter_order_status'];
		} else {
			$filter_order_status = null;
		}

		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_order_status'])) {
			$url .= '&filter_order_status=' . $this->request->get['filter_order_status'];
		}

		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}


		// Breadcrumbs

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);
		$this->document->setTitle($this->language->get('heading_title'));
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('sale/download', 'token=' . $this->session->data['token'] . $url, true)
		);

		// Text
		$data['heading_title']    = $this->language->get('heading_title');
		$data['text_customer']    = $this->language->get('text_customer');
		$data['text_invoice_no']  = $this->language->get('text_invoice_no');
		$data['text_generate']    = $this->language->get('text_generate');
		$data['text_date']        = $this->language->get('text_date');
		$data['text_order']       = $this->language->get('text_order');
		$data['text_amount']      = $this->language->get('text_amount');
		$data['text_product']     = $this->language->get('text_product');
		$data['text_status']      = $this->language->get('text_status');
		$data['text_action']      = $this->language->get('text_action');
		$data['text_export_all']  = $this->language->get('text_export_all');
		$data['text_all_status']  = $this->language->get('text_all_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end']   = $this->language->get('entry_date_end');
		$data['entry_status']     = $this->language->get('entry_status');
		$data['button_export']    = $this->url->link('report/export_xls/export', 'token=' . $this->session->data['token'] . $url . '&order=all', 'SSL');
		$data['button_filter']    = $this->language->get('button_filter');

		// Order status
		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		// Model export
		$this->load->model('sale/order');
		$this->load->model('sale/download');
		$data = array(
			'filter_date_start'      => $this->filter_date_start,
			'filter_date_end'        => $this->filter_date_end,
			'filter_order_status_id' => $this->filter_order_status_id
		);
		$results = $this->model_sale_download->getOrders($data);
		$data['orders'] = array();

		// Orders
		foreach ($results as $result)
		{
			// Create an action to each : View, export or invoice
			$action = array();
			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);
			$action[] = array(
				'text' => $this->language->get('text_export'),
				'href' => $this->url->link('sale/download/export', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);
			$action[] = array(
				'text' => $this->language->get('text_invoice'),
				'href' => $this->url->link('sale/download/createInvoice', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);

			// Invoice related informations
			$invoice = '';

			if ($result['invoice_no'])
			{
				$invoice = $result['invoice_prefix'] . $result['invoice_no'];
			}

			// New line
			$data['orders'][] = array(
				'firstname'  => $result['firstname'],
				'lastname'   => $result['lastname'],
				'invoice_no' => $invoice,
				'nb_product' => $this->model_sale_download->getTotalProductFromOrder($result['order_id']),
				'order_id'   => $result['order_id'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'status'     => $result['name'],
				'action'     => $action
			);
		}

		// Preparing response
		$data['token'] = $this->session->data['token'];
		$data['filter_date_start'] = date($this->language->get('date_format_short'), strtotime($this->filter_date_start));
		$data['filter_date_end'] = date($this->language->get('date_format_short'), strtotime($this->filter_date_end));
		$data['filter_order_status_id'] = $this->filter_order_status_id;

		// Preparing view
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		// Render
		//$this->response->setOutput($this->render());
		$this->response->setOutput($this->load->view('sale/download', $data));
	}

	/**
	* Set filter passed through URL
	* Use default values if filters not defined yet
	*
	* @return void
	*/
	protected function setFilters()
	{
		if (isset($this->request->get['filter_date_start']))
		{
			$this->filter_date_start = $this->request->get['filter_date_start'];
		}
		else
		{
			$this->filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
		}

		if (isset($this->request->get['filter_date_end']))
		{
			$this->filter_date_end = $this->request->get['filter_date_end'];
		}
		else
		{
			$this->filter_date_end = date('Y-m-d');
		}

		if (isset($this->request->get['filter_order_status_id']))
		{
			$this->filter_order_status_id = $this->request->get['filter_order_status_id'];
		}
		else
		{
			$this->filter_order_status_id = 0;
		}
	}

	/**
	* Export an order or all orders to an Excel File
	*
	* @param  integer  $order_id
	* @return File to download objPHPExcel
	*/
	public function getDownloadXlsFile($order_id = null){
		// Setup headers
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="export-order-'.$order_id.'.xlsx"');
		header('Cache-Control: max-age=0');
		//header('Content-type: application/vnd.ms-excel');
		

		// Generate file
		$objWriter = PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
		ob_end_clean();
		$objWriter->save('php://output');
		
		exit();
	}

	/**
	* Export an order or all orders to an Excel File
	*
	* @return File to download
	*/
	public function export()
	{
		require_once DIR_SYSTEM . 'library/excel/PHPExcel.php';
		require_once DIR_SYSTEM . 'library/excel/PHPExcel/IOFactory.php';

		$this->objPHPExcel = new PHPExcel();
		$this->mainCounter = 1;
		print_r("TEST");
		// Export one
		/*
		if (isset($this->request->get['order_id']))
		{

			$order_id = $this->request->get['order_id'];
			$this->createExcelWorksheet($order_id);
			$this->getDownloadXlsFile($order_id);
		}*/

		// Export all
		//if (isset($this->request->get['order']))
		//{


			$this->load->model('sale/download');
			$this->setFilters();

			$data = array(
				'filter_date_start'      => $this->filter_date_start,
				'filter_date_end'        => $this->filter_date_end,
				'filter_order_status_id' => $this->filter_order_status_id
			);

			$result = $this->model_sale_download->getOrders($data);

			foreach ($result as $res)
			{
				$this->createExcelWorksheet($res['order_id']);
				$this->mainCounter++;
			}
			$this->getDownloadXlsFile('all');
		//}
	}

	/**
	* Export the invoice associate to an order
	* Same display than "Print Invoice" (Sale info) but add the logo on the top
	*
	* @return void
	*/
	public function createInvoice()
	{
		require_once DIR_SYSTEM . 'library/excel/PHPExcel.php';
		require_once DIR_SYSTEM . 'library/excel/PHPExcel/IOFactory.php';

		$this->load->language('sale/download');
		$this->load->model('sale/download');
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id']))
		{
			$order_id = $this->request->get['order_id'];
		}
		else
		{
			$order_id = 0;
		}

		$result = $this->model_report_export_xls->getOrder($order_id);

		// Building data
		foreach ($result as $res)
		{
			$this->data['orders'][] = array(
				'order_id'           => $res['order_id'],
				'store_name'         => $res['store_name'],
				'customer'           => $res['firstname'] . ' ' . $res['lastname'],
				'email'              => $res['email'],
				'telephone'          => $res['telephone'],
				'total'              => $this->currency->format($res['total'], $res['currency_code'], $res['currency_value']),
				'date_added'         => date($this->language->get('date_format_short'), strtotime($res['date_added'])),

				'currency_code'      => $res['currency_code'],
				'currency_value'     => $res['currency_value'],

				'payment_firstname'  => $res['payment_firstname'],
				'payment_lastname'   => $res['payment_lastname'],
				'payment_address_1'  => $res['payment_address_1'],
				'payment_address_2'  => $res['payment_address_2'],
				'payment_city'       => $res['payment_city'],
				'payment_postcode'   => $res['payment_postcode'],
				'payment_zone'       => $res['payment_zone'],
				'payment_country'    => $res['payment_country'],
				'payment_method'     => $res['payment_method'],

				'shipping_firstname' => $res['shipping_firstname'],
				'shipping_lastname'  => $res['shipping_lastname'],
				'shipping_address_1' => $res['shipping_address_1'],
				'shipping_address_2' => $res['shipping_address_2'],
				'shipping_city'      => $res['shipping_city'],
				'shipping_postcode'  => $res['shipping_postcode'],
				'shipping_zone'      => $res['shipping_zone'],
				'shipping_country'   => $res['shipping_country'],
				'shipping_method'    => $res['shipping_method']
			);
		}

		$invoice = $this->data['orders'][0];

		$this->objPHPExcel = new PHPExcel();
		$this->objPHPExcel->getProperties()->setCreator('Opencart Excel Export')
										->setLastModifiedBy('Opencart Excel Export')
										->setTitle('Office 2007 XLSX')
										->setSubject('Office 2007 XLSX')
										->setDescription('Document for Office 2007 XLSX, generated by Opencart Excel Export')
										->setKeywords('office 2007 excel')
										->setCategory('Reporting');

		// Create only a sheet
		$this->objPHPExcel->setActiveSheetIndex(0);

		// Writing store info left top
		$this->objPHPExcel->getActiveSheet()->setCellValue('A4', $this->config->get('config_name'));
		$this->objPHPExcel->getActiveSheet()->setCellValue('A5', $this->config->get('config_address'));
		$this->objPHPExcel->getActiveSheet()->setCellValue('A6', 'Telephone : ' . $this->config->get('config_telephone'));
		$this->objPHPExcel->getActiveSheet()->setCellValue('A7', $this->config->get('config_email'));

		// Writing general info about the order
		$this->objPHPExcel->getActiveSheet()->setCellValue('G4', $this->language->get('header_date'));
		$this->objPHPExcel->getActiveSheet()->setCellValue('G5', $this->language->get('header_order_id'));
		$this->objPHPExcel->getActiveSheet()->setCellValue('G6', $this->language->get('header_payment_method'));
		$this->objPHPExcel->getActiveSheet()->setCellValue('G7', $this->language->get('header_shipping_method'));
		$this->objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true);
		$this->objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
		$this->objPHPExcel->getActiveSheet()->getStyle('G6')->getFont()->setBold(true);
		$this->objPHPExcel->getActiveSheet()->getStyle('G7')->getFont()->setBold(true);
		$this->objPHPExcel->getActiveSheet()->setCellValue('H4', $invoice['date_added']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('H5', $invoice['order_id']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('H6', $invoice['payment_method']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('H7', $invoice['shipping_method']);
		$this->objPHPExcel->getActiveSheet()->getStyle('H4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->objPHPExcel->getActiveSheet()->getStyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$this->objPHPExcel->getActiveSheet()->getStyle('H7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

		// Set thin black border outline around column
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
			),
		);

		// Address info header
		$this->objPHPExcel->getActiveSheet()->getStyle('A11:D11')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('A11:D11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->objPHPExcel->getActiveSheet()->getStyle('A11:D11')->getFill()->getStartColor()->setARGB('E7EFEF');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A11', $this->language->get('header_to'));
		$this->objPHPExcel->getActiveSheet()->mergeCells('A11:D11');
		$this->objPHPExcel->getActiveSheet()->getStyle('E11:H11')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('E11:H11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->objPHPExcel->getActiveSheet()->getStyle('E11:H11')->getFill()->getStartColor()->setARGB('E7EFEF');
		$this->objPHPExcel->getActiveSheet()->setCellValue('E11', $this->language->get('header_ship_to'));
		$this->objPHPExcel->getActiveSheet()->mergeCells('E11:H11');
		$this->objPHPExcel->getActiveSheet()->getStyle('A12:D19')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('E12:H19')->applyFromArray($styleThinBlackBorderOutline);

		// Write customer info
		$this->objPHPExcel->getActiveSheet()->setCellValue('A12', $invoice['payment_firstname'] . ' ' . $invoice['payment_lastname']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A13', $invoice['payment_address_1']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A14', $invoice['payment_address_2']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A15', $invoice['payment_city'] . ' ' . $invoice['payment_postcode']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A16', $invoice['payment_zone']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A17', $invoice['payment_country']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A18', $invoice['email']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('A19', $invoice['telephone']);

		// Write shipping info
		$this->objPHPExcel->getActiveSheet()->setCellValue('E12', $invoice['shipping_firstname'] . ' ' . $invoice['shipping_lastname']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('E13', $invoice['shipping_address_1']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('E14', $invoice['shipping_address_2']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('E15', $invoice['shipping_city'] . ' ' . $invoice['shipping_postcode']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('E16', $invoice['shipping_zone']);
		$this->objPHPExcel->getActiveSheet()->setCellValue('E17', $invoice['shipping_country']);

		// Product header
		$this->objPHPExcel->getActiveSheet()->getStyle('A21:C21')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('A21:C21')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->objPHPExcel->getActiveSheet()->getStyle('A21:C21')->getFill()->getStartColor()->setARGB('E7EFEF');
		$this->objPHPExcel->getActiveSheet()->setCellValue('A21', $this->language->get('header_product_name'));
		$this->objPHPExcel->getActiveSheet()->getStyle('D21:E21')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('D21:E21')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->objPHPExcel->getActiveSheet()->getStyle('D21:E21')->getFill()->getStartColor()->setARGB('E7EFEF');
		$this->objPHPExcel->getActiveSheet()->setCellValue('D21', $this->language->get('header_product_model'));
		$this->objPHPExcel->getActiveSheet()->mergeCells('D21:E21');
		$this->objPHPExcel->getActiveSheet()->getStyle('F21')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('F21')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->objPHPExcel->getActiveSheet()->getStyle('F21')->getFill()->getStartColor()->setARGB('E7EFEF');
		$this->objPHPExcel->getActiveSheet()->setCellValue('F21', $this->language->get('header_product_quantity'));
		$this->objPHPExcel->getActiveSheet()->getStyle('G21')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('G21')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->objPHPExcel->getActiveSheet()->getStyle('G21')->getFill()->getStartColor()->setARGB('E7EFEF');
		$this->objPHPExcel->getActiveSheet()->setCellValue('G21', $this->language->get('header_product_unit_price'));
		$this->objPHPExcel->getActiveSheet()->getStyle('H21')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('H21')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->objPHPExcel->getActiveSheet()->getStyle('H21')->getFill()->getStartColor()->setARGB('E7EFEF');
		$this->objPHPExcel->getActiveSheet()->setCellValue('H21', $this->language->get('header_product_price'));

		// Writing product details
		$products = $this->model_report_export_xls->getProductListFromOrder($order_id);
		$counter  = 22;

		foreach ($products as $prod)
		{
			$option_data = array();

			// Get the product option to get the color and the size
			$options = $this->model_sale_order->getOrderOptions($order_id, $prod['order_product_id']);

			if (!empty($options))
			{
				foreach ($options as $option)
				{
					if ($option['name'] == 'Size')
					{
						$option_data['Size'][] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					}
					if ($option['name'] == 'Color')
					{
						$option_data['Color'][] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					}
				}
			}

			$color = '';
			$size  = '';

			if (!empty($option_data['Color']))
			{
				$color = '[Color : ' . $option_data['Color'][0]['value'] . ']';
			}
			if (!empty($option_data['Size']))
			{
				$size = '[Size : ' . $option_data['Size'][0]['value'] . ']';
			}

			// Add each product line
			$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, html_entity_decode($prod['name'], ENT_QUOTES, 'UTF-8') . ' ' . $color . ' ' . $size);
			$this->objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $prod['model']);
			$this->objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $prod['quantity']);
			$this->objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $this->currency->format($prod['price'], $invoice['currency_code'], $invoice['currency_value']));
			$this->objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $this->currency->format($prod['total'], $invoice['currency_code'], $invoice['currency_value']));
			$this->objPHPExcel->getActiveSheet()->mergeCells('D'.$counter.':E'.$counter); // merge product model cells

			$counter++;
		}

		// Draw a frame around the products list
		$this->objPHPExcel->getActiveSheet()->getStyle('A22:C'.($counter-1))->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('D22:E'.($counter-1))->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('F22:F'.($counter-1))->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('G22:G'.($counter-1))->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('H22:H'.($counter-1))->applyFromArray($styleThinBlackBorderOutline);

		$total_data = $this->model_sale_order->getOrderTotals($order_id);

		// Write this under the product list on the right
		foreach ($total_data as $total)
		{
			$this->objPHPExcel->getActiveSheet()->setCellValue('G'.$counter, $total['title']);
			$this->objPHPExcel->getActiveSheet()->setCellValue('H'.$counter, $total['text']);
			$this->objPHPExcel->getActiveSheet()->getStyle('G'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->objPHPExcel->getActiveSheet()->getStyle('G'.$counter)->getFont()->setBold(true);
			$this->objPHPExcel->getActiveSheet()->getStyle('H'.$counter)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			$this->objPHPExcel->getActiveSheet()->getStyle('G'.$counter.':H'.$counter)->applyFromArray($styleThinBlackBorderOutline);

			$counter++;
		}

		// Add the shop logo on the top of the document
		$this->objPHPExcel->getActiveSheet()->insertNewRowBefore(1,1);
		$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setPath(DIR_IMAGE . $this->config->get('config_logo'));
		$objDrawing->setHeight(64);
		$objDrawing->setCoordinates('A1');
		$objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());

		// Set the orientation page an give a name to the worksheet
		$this->objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$this->objPHPExcel->getActiveSheet()->setTitle('Invoice #' . $order_id);

		// Set the column in autosize
		$columns = array('A', 'G', 'H');
		foreach ($columns as $col)
		{
			$this->objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
		}

		$this->objPHPExcel->getActiveSheet()->getStyle('A:H')->getFont()->setSize(10);
		$this->objPHPExcel->getActiveSheet()->removeColumn('B', 2);
		$this->getDownloadXlsFile($order_id);
	}

	/**
	* Create a list of orders (one or many order)
	* If an order has 3 products, 3 lines will be create with all the info
	*
	* @param  integer  order_id
	* @return void
	*/
	protected function createExcelWorksheet($order_id)
	{
		$this->load->language('sale/download');
		$this->load->model('sale/download');
		$this->load->model('sale/order');
		print_r($order_id);
		$result = $this->model_sale_download->getOrders($order_id);
		$totals = $this->model_sale_order->getOrderTotals($order_id);
		$vat = array(
			'title' => '',
			'text'  => ''
		);
		$x=0;
		$counter=0;
		// Build array
		foreach ($result as $res)
		{
			// Invoice related informations
			$invoice = '';

			if (isset($res['invoice_no']))
			{
				$invoice = $res['invoice_prefix'] . $res['invoice_no'];
			}

			// VAT information
			foreach ($totals as $total) {
				if (strpos($total['title'], 'VAT') === 0) {
					$vat = $total;
				}
			}

			// Customer company
			/*
			$address = $this->model_sale_download->getCustomerAddress($res['customer_id']);
			$company = '';
			if (sizeof($address) > 0)
			{
				$company = $address[0]['company'];
			}*/
			$getInfo = $this->model_sale_download->getOrder($res['order_id']);
			//echo '<pre>';
			//print_r($getInfo);
			//echo '</pre>';
			//foreach($getInfos as $getInfo){
				
				$data['orders'][] = array(
					'order_id'           => $getInfo['order_id'],
					'store_name'         => $getInfo['store_name'],
					'invoice_no'         => $invoice,
					'customer'           => $getInfo['firstname'] . ' ' . $getInfo['lastname'],
					'customer_company'   => $getInfo['shipping_company'],
					'email'              => $getInfo['email'],
					'telephone'          => $getInfo['telephone'],
					'vat'                => $vat,
					'total'              => $this->currency->format($res['total'], $res['currency_code'], $res['currency_value']),
					'date_added'         => date($this->language->get('date_format_short'), strtotime($res['date_added'])),

					'currency_code'      => $res['currency_code'],
					'currency_value'     => $res['currency_value'],

					'shipping_firstname' => $getInfo['shipping_firstname'],
					'shipping_lastname'  => $getInfo['shipping_lastname'],
					'shipping_address_1' => $getInfo['shipping_address_1'],
					'shipping_address_2' => $getInfo['shipping_address_2'],
					'shipping_city'      => $getInfo['shipping_city'],
					'shipping_postcode'  => $getInfo['shipping_postcode'],
					'shipping_zone'      => $getInfo['shipping_zone'],
					'shipping_country'   => $getInfo['shipping_country'],
					'shipping_method'    => $getInfo['shipping_method']
				);
			//}
			
		

			if ($this->mainCounter == 1)
			{
				$this->objPHPExcel->getProperties()->setCreator('Opencart Excel Export')
												->setLastModifiedBy('Opencart Excel Export')
												->setTitle('Office 2007 XLSX')
												->setSubject('Office 2007 XLSX')
												->setDescription('Document for Office 2007 XLSX, generated by Opencart Excel Export')
												->setKeywords('office 2007 excel')
												->setCategory('Reporting');

				$this->objPHPExcel->setActiveSheetIndex(0);

				$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $this->mainCounter, $this->language->get('header_order_id'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('B' . $this->mainCounter, $this->language->get('header_store_name'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('C' . $this->mainCounter, $this->language->get('header_invoice_no'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('D' . $this->mainCounter, $this->language->get('header_customer'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('E' . $this->mainCounter, $this->language->get('header_customer_company'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('F' . $this->mainCounter, $this->language->get('header_email'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('G' . $this->mainCounter, $this->language->get('header_telephone'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('H' . $this->mainCounter, $vat['title']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('I' . $this->mainCounter, $this->language->get('header_total'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('J' . $this->mainCounter, $this->language->get('header_date'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('K' . $this->mainCounter, $this->language->get('header_product_quantity'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('L' . $this->mainCounter, $this->language->get('header_product_name'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('M' . $this->mainCounter, $this->language->get('header_product_model'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('N' . $this->mainCounter, $this->language->get('header_product_color'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('O' . $this->mainCounter, $this->language->get('header_product_size'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('P' . $this->mainCounter, $this->language->get('header_shipping_firstname'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $this->mainCounter, $this->language->get('header_shipping_lastname'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('R' . $this->mainCounter, $this->language->get('header_shipping_address'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('S' . $this->mainCounter, $this->language->get('header_shipping_city'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('T' . $this->mainCounter, $this->language->get('header_shipping_postcode'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('U' . $this->mainCounter, $this->language->get('header_shipping_zone'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('V' . $this->mainCounter, $this->language->get('header_shipping_country'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('W' . $this->mainCounter, $this->language->get('header_shipping_method'));
			}

			$products = $this->model_sale_download->getProductListFromOrder($order_id);
			//$counter  = $this->mainCounter+1;
			//echo '<pre>';
			//print_r($data['orders']);
			//echo '</pre>';
			
			foreach ($products as $prod)
			{
				//echo '<pre>';
				//	print_r($counter);
				//echo '</pre>';
				$option_data = array();

				$options = $this->model_sale_order->getOrderOptions($order_id, $prod['order_product_id']);

				if (!empty($options))
				{
					foreach ($options as $option)
					{
						if ($option['name'] == 'Size')
						{
							$option_data['Size'][] = array(
								'name'  => $option['name'],
								'value' => $option['value'],
								'type'  => $option['type']
							);
						}
						if ($option['name'] == 'Color')
						{
							$option_data['Color'][] = array(
								'name'  => $option['name'],
								'value' => $option['value'],
								'type'  => $option['type']
							);
						}
					}
				}

				$color = 'N/A';
				$size  = 'N/A';

				if ( !empty($option_data['Color']) )
				{
					$color = $option_data['Color'][0]['value'];
				}
				if ( !empty($option_data['Size']) )
				{
					$size = $option_data['Size'][0]['value'];
				}
				$counter++;
				$this->mainCounter++;
				
			}

				$this->objPHPExcel->getActiveSheet()->setCellValue('A' . $counter, $data['orders'][$x]['order_id']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('B' . $counter, $data['orders'][$x]['store_name']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('C' . $counter, $data['orders'][$x]['invoice_no']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('D' . $counter, $data['orders'][$x]['customer']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('E' . $counter, $data['orders'][$x]['customer_company']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('F' . $counter, $data['orders'][$x]['email']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('G' . $counter, $data['orders'][$x]['telephone']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('H' . $counter, $data['orders'][$x]['vat']['text']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('I' . $counter, $data['orders'][$x]['total']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('J' . $counter, $data['orders'][$x]['date_added']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('K' . $counter, $prod['quantity']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('L' . $counter, html_entity_decode($prod['name'], ENT_QUOTES, 'UTF-8'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('M' . $counter, html_entity_decode($prod['model'], ENT_QUOTES, 'UTF-8'));
				$this->objPHPExcel->getActiveSheet()->setCellValue('N' . $counter, $color);
				$this->objPHPExcel->getActiveSheet()->setCellValue('O' . $counter, $size);
				$this->objPHPExcel->getActiveSheet()->setCellValue('P' . $counter, $data['orders'][$x]['shipping_firstname']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('Q' . $counter, $data['orders'][$x]['shipping_lastname']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('R' . $counter, $data['orders'][$x]['shipping_address_1'] . ' ' . 	$data['orders'][0]['shipping_address_2']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('S' . $counter, $data['orders'][$x]['shipping_city']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('T' . $counter, $data['orders'][$x]['shipping_postcode']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('U' . $counter, $data['orders'][$x]['shipping_zone']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('V' . $counter, $data['orders'][$x]['shipping_country']);
				$this->objPHPExcel->getActiveSheet()->setCellValue('W' . $counter, $data['orders'][$x]['shipping_method']);

			$x++;
		}
		// Set thin black border outline around column
		$styleThinBlackBorderOutline = array(
			'borders' => array(
				'outline' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('argb' => 'FF000000'),
				),
			),
		);

		// Set the style of heading cells
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:W1')->applyFromArray($styleThinBlackBorderOutline);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
		$this->objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFill()->getStartColor()->setARGB('FF808080');

		$columns = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W');
		foreach ($columns as $col)
		{
			$this->objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
			$this->objPHPExcel->getActiveSheet()->getStyle($col)->getFont()->setSize(11);
			$this->objPHPExcel->getActiveSheet()->getStyle($col)->getFont()->setBold(false);
			$this->objPHPExcel->getActiveSheet()->getStyle($col)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
			$this->objPHPExcel->getActiveSheet()->getStyle($col)->getAlignment()->setShrinkToFit(true);
		}
		unset($data['orders']);
	}

}