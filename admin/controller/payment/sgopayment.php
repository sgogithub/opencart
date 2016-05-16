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


		$this->data['productlist'] =$this->buildListProduct();
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
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
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_sgopayment_env'] = $this->language->get('entry_sgopayment_env');


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

		if (isset($this->request->post['sgopayment_environment'])) {
			$this->data['sgopayment_environment'] = $this->request->post['sgopayment_environment'];
		} else {
			$this->data['sgopayment_environment'] = $this->config->get('sgopayment_environment');
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
		/*
		$this->load->model('payment/sgopayment');
		$this->model_payment_sgopyamennt->uninstall();*/
	}

	public function validate(){
		if (!$this->user->hasPermission('modify', 'payment/sgopayment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['sgopayment_id'])) {
			$this->errors[] = $this->language->get('error_payment_id');
		}

		if (empty($this->request->post['sgopayment_password'])) {
			$this->errors[] = $this->language->get('error_password');
		}


		return empty($this->error);

	}



	private function getListProduct(){
		$requestMerchant = new stdClass();
		$requestProduct = new stdClass();

		$this->load->model('payment/sgopayment');
		$uri = 'https://116.90.162.172:812';

		if ($this->config->get('sgopayment_environment') === 'sandbox'){
			$uri = 'http://116.90.162.170:10809';
		}
		$urlMerchant = $uri.'/rest/merchant/merchantinfo';
		$requestMerchant->key = $this->config->get('sgopayment_id');
		$responseMerchant = $this->Call($urlMerchant, $requestMerchant);
		#$responseMerchant = json_decode($responseMerchant);
		$products = json_decode($responseMerchant);
		$this->model_payment_sgopayment->insertProduct($products);

	

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
