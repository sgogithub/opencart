<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

class ControllerPaymentSgopayment extends  Controller {
	private $error = array();
	
	private $sgopayment_ip = '116.90.162.170';
	public function index(){
		
		$this->language->load('payment/sgopayment');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('payment/sgopayment');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			
			if (isset($this->request->post['updateproduct']) && $this->request->post['updateproduct'] == 'update'){
				if($this->validate()){
					$this->getListProduct();
				}
				
			}else{
				if ($this->validate()){
					$this->model_setting_setting->editSetting('sgopayment', $this->request->post);
					$this->session->data['success'] = $this->language->get('text_success');
					$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
					
				}
				
			}
			
		}
		
		if (isset($this->error)) {
		  $this->data['error'] = $this->error;
		} else {
		  $this->data['error'] = array();
		}
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['sgopayment_geo_zone_id'])) {
			$this->data['sgopayment_geo_zone_id'] = $this->request->post['sgopayment_geo_zone_id'];
		} else {
			$this->data['sgopayment_geo_zone_id'] = $this->config->get('sgopayment_geo_zone_id'); 
		} 
		
		if (isset($this->request->post['sgopayment_sort_order'])) {
			$this->data['sgopayment_sort_order'] = $this->request->post['sgopayment_sort_order'];
		} else {
			$this->data['sgopayment_sort_order'] = $this->config->get('sgopayment_sort_order');
		}
		
		//add
		if (isset($this->request->post['sgopayment_max_order_total'])) {
			$this->data['sgopayment_max_order_total'] = $this->request->post['sgopayment_max_order_total'];
		} else {
			$this->data['sgopayment_max_order_total'] = $this->config->get('sgopayment_max_order_total');
		}
		if (isset($this->request->post['sgopayment_credit_card_mdr'])) {
			$this->data['sgopayment_credit_card_mdr'] = $this->request->post['sgopayment_credit_card_mdr'];
		} else {
			$this->data['sgopayment_credit_card_mdr'] = $this->config->get('sgopayment_credit_card_mdr');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_bca_klikpay'])) {
			$this->data['sgopayment_transaction_fee_bca_klikpay'] = $this->request->post['sgopayment_transaction_fee_bca_klikpay'];
		} else {
			$this->data['sgopayment_transaction_fee_bca_klikpay'] = $this->config->get('sgopayment_transaction_fee_bca_klikpay');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_epay_bri'])) {
			$this->data['sgopayment_transaction_fee_epay_bri'] = $this->request->post['sgopayment_transaction_fee_epay_bri'];
		} else {
			$this->data['sgopayment_transaction_fee_epay_bri'] = $this->config->get('sgopayment_transaction_fee_epay_bri');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_mandiri_ib'])) {
			$this->data['sgopayment_transaction_fee_mandiri_ib'] = $this->request->post['sgopayment_transaction_fee_mandiri_ib'];
		} else {
			$this->data['sgopayment_transaction_fee_mandiri_ib'] = $this->config->get('sgopayment_transaction_fee_mandiri_ib');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_mandiri_ecash'])) {
			$this->data['sgopayment_transaction_fee_mandiri_ecash'] = $this->request->post['sgopayment_transaction_fee_mandiri_ecash'];
		} else {
			$this->data['sgopayment_transaction_fee_mandiri_ecash'] = $this->config->get('sgopayment_transaction_fee_mandiri_ecash');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_credit_card'])) {
			$this->data['sgopayment_transaction_fee_credit_card'] = $this->request->post['sgopayment_transaction_fee_credit_card'];
		} else {
			$this->data['sgopayment_transaction_fee_credit_card'] = $this->config->get('sgopayment_transaction_fee_credit_card');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_permata_atm'])) {
			$this->data['sgopayment_transaction_fee_permata_atm'] = $this->request->post['sgopayment_transaction_fee_permata_atm'];
		} else {
			$this->data['sgopayment_transaction_fee_permata_atm'] = $this->config->get('sgopayment_transaction_fee_permata_atm');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_danamon_ob'])) {
			$this->data['sgopayment_transaction_fee_danamon_ob'] = $this->request->post['sgopayment_transaction_fee_danamon_ob'];
		} else {
			$this->data['sgopayment_transaction_fee_danamon_ob'] = $this->config->get('sgopayment_transaction_fee_danamon_ob');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_bii_atm'])) {
			$this->data['sgopayment_transaction_fee_bii_atm'] = $this->request->post['sgopayment_transaction_fee_bii_atm'];
		} else {
			$this->data['sgopayment_transaction_fee_bii_atm'] = $this->config->get('sgopayment_transaction_fee_bii_atm');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_permata_netpay'])) {
			$this->data['sgopayment_transaction_fee_permata_netpay'] = $this->request->post['sgopayment_transaction_fee_permata_netpay'];
		} else {
			$this->data['sgopayment_transaction_fee_permata_netpay'] = $this->config->get('sgopayment_transaction_fee_permata_netpay');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_nobupay'])) {
			$this->data['sgopayment_transaction_fee_nobupay'] = $this->request->post['sgopayment_transaction_fee_nobupay'];
		} else {
			$this->data['sgopayment_transaction_fee_nobupay'] = $this->config->get('sgopayment_transaction_fee_nobupay');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_finpay'])) {
			$this->data['sgopayment_transaction_fee_finpay'] = $this->request->post['sgopayment_transaction_fee_finpay'];
		} else {
			$this->data['sgopayment_transaction_fee_finpay'] = $this->config->get('sgopayment_transaction_fee_finpay');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_mayapada_ib'])) {
			$this->data['sgopayment_transaction_fee_mayapada_ib'] = $this->request->post['sgopayment_transaction_fee_mayapada_ib'];
		} else {
			$this->data['sgopayment_transaction_fee_mayapada_ib'] = $this->config->get('sgopayment_transaction_fee_mayapada_ib');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_bitcoin'])) {
			$this->data['sgopayment_transaction_fee_bitcoin'] = $this->request->post['sgopayment_transaction_fee_bitcoin'];
		} else {
			$this->data['sgopayment_transaction_fee_bitcoin'] = $this->config->get('sgopayment_transaction_fee_bitcoin');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_label'])) {
			$this->data['sgopayment_transaction_fee_label'] = $this->request->post['sgopayment_transaction_fee_label'];
		} else {
			$this->data['sgopayment_transaction_fee_label'] = $this->config->get('sgopayment_transaction_fee_label');
		}
		//
		
		//$this->data['productlist'] =$this->buildListProduct();
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		//add text for Environment
		$this->data['text_production'] = $this->language->get('text_production');
		$this->data['text_development'] = $this->language->get('text_development');
		//
	
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		
		$this->data['entry_bank'] = $this->language->get('entry_bank');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_total'] = $this->language->get('entry_total');
		
		$this->data['entry_sgopayment_id'] = $this->language->get('entry_sgopayment_id');
		$this->data['entry_sgopayment_password'] = $this->language->get('entry_sgopayment_password');
		$this->data['entry_sgopayment_ip'] = $this->language->get('entry_sgopayment_ip');
		
		
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_order_status_waiting'] = $this->language->get('entry_order_status_waiting');
		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		//add language
		$this->data['entry_environment'] = $this->language->get('entry_environment');
		$this->data['entry_max_order_total'] = $this->language->get('entry_max_order_total');
		$this->data['entry_credit_card_mdr'] = $this->language->get('entry_credit_card_mdr');
		$this->data['entry_transaction_fee_bca_klikpay'] = $this->language->get('entry_transaction_fee_bca_klikpay');
		$this->data['entry_transaction_fee_epay_bri'] = $this->language->get('entry_transaction_fee_epay_bri');
		$this->data['entry_transaction_fee_mandiri_ib'] = $this->language->get('entry_transaction_fee_mandiri_ib');
		$this->data['entry_transaction_fee_mandiri_ecash'] = $this->language->get('entry_transaction_fee_mandiri_ecash');
		$this->data['entry_transaction_fee_credit_card'] = $this->language->get('entry_transaction_fee_credit_card');
		$this->data['entry_transaction_fee_permata_atm'] = $this->language->get('entry_transaction_fee_permata_atm');
		$this->data['entry_transaction_fee_danamon_ob'] = $this->language->get('entry_transaction_fee_danamon_ob');
		$this->data['entry_transaction_fee_bii_atm'] = $this->language->get('entry_transaction_fee_bii_atm');
		$this->data['entry_transaction_fee_permata_netpay'] = $this->language->get('entry_transaction_fee_permata_netpay');
		$this->data['entry_transaction_fee_nobupay'] = $this->language->get('entry_transaction_fee_nobupay');
		$this->data['entry_transaction_fee_finpay'] = $this->language->get('entry_transaction_fee_finpay');
		$this->data['entry_transaction_fee_mayapada_ib'] = $this->language->get('entry_transaction_fee_mayapada_ib');
		$this->data['entry_transaction_fee_bitcoin'] = $this->language->get('entry_transaction_fee_bitcoin');
		$this->data['entry_transaction_fee_label'] = $this->language->get('entry_transaction_fee_label');
		//
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_update'] = $this->language->get('button_update');
		
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		
		$this->load->model('localisation/language');
		
		$languages = $this->model_localisation_language->getLanguages();
		
		foreach ($languages as $language) {
			if (isset($this->error['bank_' . $language['language_id']])) {
				$this->data['error_bank_' . $language['language_id']] = $this->error['bank_' . $language['language_id']];
			} else {
				$this->data['error_bank_' . $language['language_id']] = '';
			}
		}
		
		$this->data['breadcrumbs'] = array();
		
		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
		);
		
		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_payment'),
				'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);
		
		$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('payment/sgopayment', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
		);
		
		
		$this->data['action'] = $this->url->link('payment/sgopayment', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->load->model('localisation/language');
		
		foreach ($languages as $language) {
			if (isset($this->request->post['sgopayment_bank_' . $language['language_id']])) {
				$this->data['sgopayment_bank_' . $language['language_id']] = $this->request->post['sgopayment_bank_' . $language['language_id']];
			} else {
				$this->data['sgopayment_bank_' . $language['language_id']] = $this->config->get('sgopayment_bank_' . $language['language_id']);
			}
		}
		
		
		$this->data['languages'] = $languages;
		
		if (isset($this->request->post['sgopayment_total'])) {
			$this->data['sgopayment_total'] = $this->request->post['sgopayment_total'];
		} else {
			$this->data['sgopayment_total'] = $this->config->get('sgopayment_total');
		}
		
		if (isset($this->request->post['sgopayment_id'])) {
			$this->data['sgopayment_id'] = $this->request->post['sgopayment_id'];
		} else {
			$this->data['sgopayment_id'] = $this->config->get('sgopayment_id');
		}
		
		if (isset($this->request->post['sgopayment_password'])) {
			$this->data['sgopayment_password'] = $this->request->post['sgopayment_password'];
		} else {
			$this->data['sgopayment_password'] = $this->config->get('sgopayment_password');
		}
		
		if (isset($this->request->post['sgopayment_ip'])) {
			$this->data['sgopayment_ip']  = $this->request->post['sgopayment_ip'];
		} else {
			
			if ($this->config->get('sgopayment_ip') != ""){
				$this->data['sgopayment_ip']  = $this->config->get('sgopayment_ip');
			}else {
				$this->data['sgopayment_ip'] = $this->sgopayment_ip;
			}
			
		}
	
		
		
		if (isset($this->request->post['sgopayment_order_status_id'])) {
			$this->data['sgopayment_order_status_id'] = $this->request->post['sgopayment_order_status_id'];
		} else {
			$this->data['sgopayment_order_status_id'] = $this->config->get('sgopayment_order_status_id');
		}
		
		if (isset($this->request->post['sgopayment_order_status_waiting'])) {
			$this->data['sgopayment_order_status_waiting'] = $this->request->post['sgopayment_order_status_waiting'];
		} else {
			$this->data['sgopayment_order_status_waiting'] = $this->config->get('sgopayment_order_status_waiting');
		}
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['sgopayment_geo_zone_id'])) {
			$this->data['sgopayment_geo_zone_id'] = $this->request->post['sgopayment_geo_zone_id'];
		} else {
			$this->data['sgopayment_geo_zone_id'] = $this->config->get('sgopayment_geo_zone_id');
		}
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		

		if (isset($this->request->post['sgopayment_status'])) {
			$this->data['sgopayment_status'] = $this->request->post['sgopayment_status'];
		} else {
			$this->data['sgopayment_status'] = $this->config->get('sgopayment_status');
		}
		
		if (isset($this->request->post['sgopayment_sort_order'])) {
			$this->data['sgopayment_sort_order'] = $this->request->post['sgopayment_sort_order'];
		} else {
			$this->data['sgopayment_sort_order'] = $this->config->get('sgopayment_sort_order');
		}
		
		//add
		if (isset($this->request->post['sgopayment_environment'])) {
			$this->data['sgopayment_environment'] = $this->request->post['sgopayment_environment'];
		} else {
			$this->data['sgopayment_environment'] = $this->config->get('sgopayment_environment');
		}
		
		if (isset($this->request->post['sgopayment_max_order_total'])) {
			$this->data['sgopayment_max_order_total'] = $this->request->post['sgopayment_max_order_total'];
		} else {
			$this->data['sgopayment_max_order_total'] = $this->config->get('sgopayment_max_order_total');
		}
		if (isset($this->request->post['sgopayment_credit_card_mdr'])) {
			$this->data['sgopayment_credit_card_mdr'] = $this->request->post['sgopayment_credit_card_mdr'];
		} else {
			$this->data['sgopayment_credit_card_mdr'] = $this->config->get('sgopayment_credit_card_mdr');
		}
		if (isset($this->request->post['sgopayment_transaction_fee_bca_klikpay'])) {
			$this->data['sgopayment_transaction_fee_bca_klikpay'] = $this->request->post['sgopayment_transaction_fee_bca_klikpay'];
		} else {
			$this->data['sgopayment_transaction_fee_bca_klikpay'] = $this->config->get('sgopayment_transaction_fee_bca_klikpay');
		}
		
		//
		
		$this->template = 'payment/sgopayment.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);
		
		$this->response->setOutput($this->render());
	}
	
	
	public function install() {		
		$this->load->model('payment/sgopayment');
		$this->load->model('setting/setting');
		$this->model_payment_sgopayment->install();			
	}
	
	public function uninstall() {		
		$this->load->model('payment/sgopayment');
		$this->model_payment_sgopayment->uninstall();
	}
	
	public function validate(){
		if (!$this->user->hasPermission('modify', 'payment/sgopayment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (empty($this->request->post['sgopayment_id'])) {
			$this->error['sgopayment_id'] = $this->language->get('error_payment_id');
		}
		
		if (empty($this->request->post['sgopayment_password'])) {
			$this->error['sgopayment_password'] = $this->language->get('error_password');
		}
		
		if (empty($this->request->post['sgopayment_total'])) {
			$this->error['sgopayment_total'] = $this->language->get('error_total');
		}
		
		if (empty($this->request->post['sgopayment_max_order_total'])) {
			$this->error['sgopayment_max_order_total'] = $this->language->get('error_max_order_total');
		}
		
		if (empty($this->request->post['sgopayment_transaction_fee_label'])) {
			$this->error['sgopayment_transaction_fee_label'] = $this->language->get('error_sgopayment_transaction_fee_label');
		}
		
		if ($this->request->post['sgopayment_order_status_waiting'] == $this->request->post['sgopayment_order_status_id']){		
			$this->error['sgopayment_order_status'] = $this->language->get('error_status_same');
		}
		
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
		
	}
	
	
	
	private function getListProduct(){
		$requestMerchant = new stdClass();
		$requestProduct = new stdClass();
		
		$this->load->model('payment/sgopayment');
		
		$urlMerchant = 'http://116.90.162.170:10809/rest/merchant/merchantinfo';
		$requestMerchant->key = $this->config->get('sgopayment_id');
		//var_dump($requestMerchant);
		$responseMerchant = $this->Call($urlMerchant, $requestMerchant);
		//var_dump($responseMerchant);
		$responseMerchant = json_decode($responseMerchant);
		//var_dump($responseMerchant);
		//die();
		
		$this->model_payment_sgopayment->insertProduct($responseMerchant);
		
		/*if ($responseMerchant->body->errorCode == '0000'){
			$requestProduct->merchantCode = $responseMerchant->body->commCode;
			$this->model_payment_sgopayment->clearProduct();
			
			
			$urlProduct = 'http://116.90.162.173:20809/rest/merchant/merchantinfo';
			$products = $this->Call($urlProduct, $requestProduct);
			$products = json_decode($products);
			var_dump ($products);
			$this->model_payment_sgopayment->insertProduct($products);
			
		}*/		
		
	}
	
	
	public function Call($url, $request){
		$curl=curl_init($url);
	
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
	
		curl_setopt($curl, CURLOPT_HEADER, false);
		//curl_setopt($curl, CURLOPT_ENCODING, 'gzip');
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); //use http 1.1
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
		//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	
		//NOTE: skip SSL certificate verification (this allows sending request to hosts with self signed certificates, but reduces security)
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
	
		//enable ssl version 3
		//this is added because mandiri ecash case that ssl version that have been not supported before
		curl_setopt($curl, CURLOPT_SSLVERSION,1);
	
		curl_setopt($curl, CURLOPT_VERBOSE, true);
		//save to temporary file (php built in stream), cannot save to php://memory
		$verbose = fopen('php://temp', 'rw+');
		curl_setopt($curl, CURLOPT_STDERR, $verbose);
			
		$response=curl_exec($curl);
	
		return $response;
	}
	
	private function buildListProduct(){
		$i = 0;
		$html = '';
		$products = $this->model_payment_sgopayment->getProduct();
		
		foreach ($products as $product){
			if ($i == 0){
				$html .= ' <tr>
            				<td>Product</td>
            				<td><input checked type="checkbox" name="test" disabled="disabled"   >&nbsp'.$product['productname'].'</td>
          					</tr>';
			}else{
				$html .= ' <tr>
            				<td>&nbsp;</td>
            				<td><input checked type="checkbox" name="test" disabled="disabled"   >&nbsp'.$product['productname'].'</td>
          					</tr>';
			}
			$i++;
		}
		
		return $html;
	}
	

}