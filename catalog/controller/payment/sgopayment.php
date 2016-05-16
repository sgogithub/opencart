<?php
class ControllerPaymentSgopayment extends Controller {
	protected function index() {
		$this->language->load ( 'payment/sgopayment' );

		$uri = 'https://secure.sgo.co.id';
		if ($this->config->get ( 'sgopayment_environment' ) === 'sandbox'){
			$uri = 'http://secure-dev.sgo.co.id';
		}

		$this->data ['text_instruction'] = $this->language->get ( 'text_instruction' );
		$this->data ['text_description'] = $this->language->get ( 'text_description' );
		$this->data ['text_payment'] = $this->language->get ( 'text_payment' );

		$this->data ['button_confirm'] = $this->language->get ( 'button_confirm' );

		$this->data ['bank'] = nl2br ( $this->config->get ( 'sgopayment_bank_' . $this->config->get ( 'config_language_id' ) ) ) . "asdarea";

		$this->data ["sgopaymentid"] = $this->config->get ( 'sgopayment_id' );
		$this->data ["sgopayment_env"] = $this->config->get ( 'sgopayment_environment' );

		$this->data ["uri"] =$uri;

		$this->data ["order_id"] = $this->session->data ['order_id'];
		$this->data ["total"] = $this->cart->getTotal ();
		$this->data ["back_url"] = $this->url->link ( 'payment/sgopayment/success' ) . "&order_id=" . $this->session->data ['order_id'];

		// $this->data['dir_image'] = HTT."sgopayment/";

		if (empty ( $_SERVER ["https"] )) {
			$this->data ['dir_js'] = HTTP_SERVER . "catalog/view/javascript/";
			$this->data ['dir_image'] = HTTP_SERVER . "catalog/view/theme/default/image/sgopayment/";
		} else {
			$this->data ['dir_image'] = HTTPS_SERVER . "catalog/view/theme/default/image/sgopayment/";
			$this->data ['dir_js'] = HTTPS_SERVER . "catalog/view/javascript/";
		}

		$this->data['product_list'] = $this->setProductList();

		if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/payment/sgopayment.tpl' )) {
			$this->template = $this->config->get ( 'config_template' ) . '/template/payment/sgopayment.tpl';
		} else {
			$this->template = 'default/template/payment/sgopayment.tpl';
		}

		$this->render ();
	}
	private function viewSuccess($textCustomer, $textGuest) {
		$this->cart->clear ();
		unset ( $this->session->data ['cba'] );
		unset ( $this->session->data ['shipping_method'] );
		unset ( $this->session->data ['shipping_methods'] );
		unset ( $this->session->data ['payment_method'] );
		unset ( $this->session->data ['payment_methods'] );
		unset ( $this->session->data ['guest'] );
		unset ( $this->session->data ['comment'] );
		unset ( $this->session->data ['order_id'] );
		unset ( $this->session->data ['coupon'] );
		unset ( $this->session->data ['reward'] );
		unset ( $this->session->data ['voucher'] );
		unset ( $this->session->data ['vouchers'] );

		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );

		$this->data ['breadcrumbs'] = array ();

		$this->data ['breadcrumbs'] [] = array (
				'href' => $this->url->link ( 'common/home' ),
				'text' => $this->language->get ( 'text_home' ),
				'separator' => false
		);

		$this->data ['breadcrumbs'] [] = array (
				'href' => $this->url->link ( 'checkout/cart' ),
				'text' => $this->language->get ( 'text_basket' ),
				'separator' => $this->language->get ( 'text_separator' )
		);

		$this->data ['breadcrumbs'] [] = array (
				'href' => $this->url->link ( 'checkout/checkout', '', 'SSL' ),
				'text' => $this->language->get ( 'text_checkout' ),
				'separator' => $this->language->get ( 'text_separator' )
		);

		$this->data ['breadcrumbs'] [] = array (
				'href' => $this->url->link ( 'checkout/success' ),
				'text' => $this->language->get ( 'text_success' ),
				'separator' => $this->language->get ( 'text_separator' )
		);

		$this->data ['heading_title'] = $this->language->get ( 'heading_title' );

		if ($this->customer->isLogged ()) {
			$this->data ['text_message'] = sprintf ( $textCustomer, $this->url->link ( 'account/account', '', 'SSL' ), $this->url->link ( 'account/order', '', 'SSL' ), $this->url->link ( 'account/download', '', 'SSL' ), $this->url->link ( 'information/contact' ) );
		} else {
			$this->data ['text_message'] = sprintf ( $textGuest, $this->url->link ( 'information/contact' ) );
		}

		$this->data ['button_continue'] = $this->language->get ( 'button_continue' );

		$this->data ['continue'] = $this->url->link ( 'common/home' );

		if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/common/success.tpl' )) {
			$this->template = $this->config->get ( 'config_template' ) . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
		}
	}
	public function confirm() {
		$this->language->load ( 'payment/sgopayment' );

		$this->load->model ( 'checkout/order' );

		$comment = $this->language->get ( 'text_instruction' ) . "\n\n";
		$comment .= $this->config->get ( 'sgopayment_bank_' . $this->config->get ( 'config_language_id' ) ) . "\n\n";
		$comment .= $this->language->get ( 'text_payment' );

		$this->model_checkout_order->confirm ( $this->session->data ['order_id'], $this->config->get ( 'sgopayment_order_status_id' ), $comment, true );
	}
	public function success() {
		$this->language->load ( 'payment/sgopayment' );

		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		$this->data ["heading_title"] = $this->language->get ( 'heading_title' );
		$this->data ['order_id'] = $order_id = $this->request->get ['order_id'];
		$product = $this->request->get ['product'];

		$this->load->model ( 'checkout/order' );
		$order_detail = $this->model_checkout_order->getOrder ( $order_id );

		if ($order_detail ["order_status_id"] == $this->config->get ( 'sgopayment_order_status_id' )) {

			$textCustomer = $this->language->get('text_customer');
			$textGuest = $this->language->get('text_guest');
			$this->viewSuccess ($textCustomer, $textGuest);
		} else {
			if ($product == 'BIIATM') {

				$comment = "";
				$comment .= $this->language->get ( 'text_transfer' ) . "\n\n";
				$comment .= $this->language->get ( 'text_transfer_waiting' ) ."\n\n";

				$this->model_checkout_order->confirm ( $order_id, $this->config->get ( 'sgopayment_order_status_waiting' ), $comment, true );

				$textCustomer = $this->language->get('text_customer_waiting');
				$textGuest = $this->language->get('text_guest_waiting');
				$this->viewSuccess ($textCustomer, $textGuest);

			} else {
				$this->data ['heading_title'] = $this->language->get ( 'heading_title' );
				$this->data ['text_payment_failed'] = $this->language->get ( 'text_payment_failed' );

				if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/payment/sgopayment_failure.tpl' )) {
					$this->template = $this->config->get ( 'config_template' ) . '/template/payment/sgopayment_failure.tpl';
				} else {
					$this->template = 'default/template/payment/sgopayment_failure.tpl';
				}
			}
		}

		$this->children = array (
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
		);

		$this->response->setOutput ( $this->render ( true ) );
	}

	private function get_all_request() {
		$headers = array();
		$request_header = "";
		foreach($_SERVER as $key => $value) {
			if(substr($key, 0, 5) == 'HTTP_') {
				$request_header .= strtolower($key) ." : ".$value."\n";
			}
		}
		$request_header .= "request_method : ".$_SERVER['REQUEST_METHOD']."\n";
		$request_header .= print_r($_POST, true);
		return $request_header;
	}

	private function response_all($response){
		$headers = array();
		$response_header = "";
		foreach($_SERVER as $key => $value) {
			if(substr($key, 0, 5) == 'HTTP_') {
				$response_header .= strtolower($key) ." : ".$value."\n";
			}
		}

		$response_header .= $response;
		return $response_header;


	}

	public function inquirytrx() {
		$method = $_SERVER ['REQUEST_METHOD'];
		$this->load->model ( 'checkout/order' );
		$this->load->model ('payment/sgopayment');
		$uuid = '';
		$datetime = '';

		$data = '';
		//$lastLogId = $this->model_payment_sgopayment->insertLog($uuid, $datetime, 'TrxInquiry', $data);
		if ($method == "POST") {
			header ( 'HTTP/1.1 200 OK' );
			$order_id = $this->request->post ["order_id"]; // get the order_id
			$password = $this->request->post ["password"]; // get the password from sgo

			// validate the password
			if ($password == $this->config->get ( "sgopayment_password" )) {

				// validate order id
				if (! $this->model_checkout_order->getOrder ( $order_id )) {
					echo '1;Order Id Does Not Exist;;;;;'; // if order id not exist show plain reponse
				} else {
					// if order id truly exist get order detail from database
					$order_detail = $this->model_checkout_order->getOrder ( $order_id );
					// show response
					// see TSD for more detail
					echo '0;Success;' . $order_id . ';' . str_replace ( '.', '', $order_detail ["total"] ) . '.00;' . $order_detail ["currency_code"] . '; Pembayaran Order ' . $order_id . ' oleh ' . $order_detail ["lastname"] . ' ' . $order_detail ["firstname"] . ';' . date ( 'Y/m/d H:i:s' ) . '';
				}
			} else {
				// if password not true
				echo '1;Merchant Failed to Identified;;;;;';
			}
		} else {
			// if request not post
			header ( 'HTTP/1.1 404 Not Found' );
		}
	}
	public function reportpayment() {
		$method = $_SERVER ['REQUEST_METHOD'];
		$this->load->model ( 'checkout/order' );
		$this->language->load ( 'payment/sgopayment' );

		if ($method == "POST") {
			header ( 'HTTP/1.1 200 OK' );
			// get all the data that sent by sgo
			$member_id = $this->request->post ["member_id"];
			$order_id = $this->request->post ["order_id"];
			$password = $this->request->post ["password"];
			$debit_from = $this->request->post ["debit_from"];
			$credit_to = $this->request->post ["credit_to"];
			$product = $this->request->post ["product_code"];

			// validate password
			if ($password == $this->config->get ( "sgopayment_password" )) {
				if (! $this->model_checkout_order->getOrder ( $order_id )) { // check order id exist
				                                                        // if order id not exist
					echo '1,Order Id Does Not Exist,,,';
				} else {
					// get order detail
					$order_detail = $this->model_checkout_order->getOrder ( $order_id );

					$comment = "";
					$comment .= $this->language->get ( 'text_transfer' ) . "\n\n";
					$comment .= $this->language->get ( 'text_transfer_from' ) . " " . $credit_to . "\n\n";
					$comment .= $this->language->get ( 'text_transfer_to' ) . " " . $debit_from . "\n\n";
					$comment .= $this->language->get ( 'text_transfer_product' ) . " " . $product . "\n\n";

					$reconsile_id = $member_id . " - " . $order_id . date ( 'YmdHis' );
					echo '0,Success,' . $reconsile_id . ',' . $order_id . ',' . date ( 'Y-m-d H:i:s' ) . '';
					// save the order id that already pay
					$this->model_checkout_order->confirm ( $order_id, $this->config->get ( 'sgopayment_order_status_id' ), $comment, true );
				}
			} else {
				//
				echo '1,Password does not match,,,';
			}
		} else {
			header ( 'HTTP/1.1 404 Not Found' );
		}
	}

	public function setProductList(){
		$this->load->model ( 'payment/sgopayment' );
		$productlist = $this->model_payment_sgopayment->getProductList();
		$html = '';

		if (empty ( $_SERVER ["https"] )) {
			$dir_image = HTTP_SERVER . "catalog/view/theme/default/image/sgopayment/";
		} else {
			$dir_image = HTTPS_SERVER . "catalog/view/theme/default/image/sgopayment/";

		}
		$i = 0;
		foreach ($productlist as $product){

				if ($i % 4 == 0){
					$html .= "<tr>";
				}
				$html .="<td>";
				$html .= '<input type="radio" name="product" id="product" value="'.$product['bankcode'].':'.$product['productcode'].'">  <img src="'.$dir_image.$product['productcode'].'.png">';
				$html .= '</td>';

				if ($i % 4 == 3){
					$html .= "</tr>";
				}
				$i++;
			}


		return $html;
	}
}
