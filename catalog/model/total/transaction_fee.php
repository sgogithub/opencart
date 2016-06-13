<?php
class ModelTotalTransactionFee extends Model {	
	public function getTotal(&$total_data, &$total, &$taxes) {
		$this->language->load('total/transaction_fee');
				
		if (isset($this->request->post['espayproduct']) && isset($this->session->data['payment_method'])) {
			
			$espayproductOri = $this->request->post['espayproduct'];			
			$espayproduct = explode(":", $espayproductOri);
						
			$bankCode = $espayproduct[0];
			$productCode = $espayproduct[1];
			$productName = $espayproduct[2];
			$orderId = $this->request->post['cartid'];
			
			$feeTransaction = 0;
			$feeMDR = 0;
			if($productCode == 'BCAKLIKPAY'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_bca_klikpay'] == '')?0:$this->request->post['sgopayment_transaction_fee_bca_klikpay'];
			}elseif($productCode == 'BRI'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_epay_bri'] == '')?0:$this->request->post['sgopayment_transaction_fee_epay_bri'];
			}elseif($productCode == 'MANDIRIIB'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_mandiri_ib'] == '')?0:$this->request->post['sgopayment_transaction_fee_mandiri_ib'];
			}elseif($productCode == 'MANDIRIECASH'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_mandiri_ecash'] == '')?0:$this->request->post['sgopayment_transaction_fee_mandiri_ecash'];
			}elseif($productCode == 'CREDITCARD'){
				
				$sqltotal = $this->db->query("SELECT `total` FROM `".DB_PREFIX."order` where order_id=".$orderId);		
				$totalorder = $sqltotal->row['total'];
				
				$feeMDR = str_replace('%','',$this->request->post['sgopayment_credit_card_mdr']);
								
				$feeCreditCard = ($this->request->post['sgopayment_transaction_fee_credit_card'] == '')?0:$this->request->post['sgopayment_transaction_fee_credit_card'];	
				
				$feeTransaction = floatval($feeCreditCard) + ((floatval($totalorder) + floatval($feeCreditCard)) * floatval($feeMDR) / 100);
				
				
			}elseif($productCode == 'PERMATAATM'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_permata_atm'] == '')?0:$this->request->post['sgopayment_transaction_fee_permata_atm'];
			}elseif($productCode == 'DANAMONOB'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_danamon_ob'] == '')?0:$this->request->post['sgopayment_transaction_fee_danamon_ob'];			
			}elseif($productCode == 'BIIATM'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_bii_atm'] == '')?0:$this->request->post['sgopayment_transaction_fee_bii_atm'];
			}elseif($productCode == 'NOBUPAY'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_nobupay'] == '')?0:$this->request->post['sgopayment_transaction_fee_nobupay'];
			}elseif($productCode == 'FINPAY195'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_finpay'] == '')?0:$this->request->post['sgopayment_transaction_fee_finpay'];
			}elseif($productCode == 'MAYAPADAIB'){
				$feeTransaction = ($this->request->post['sgopayment_transaction_fee_mayapada_ib'] == '')?0:$this->request->post['sgopayment_transaction_fee_mayapada_ib'];
				
			}elseif($productCode == 'BNIDBO'){
				$feeTransaction = ($this->request->post['test'] == '')?0:$this->request->post['test'];			
			}elseif($productCode == 'DKIIB'){
				$feeTransaction = ($this->request->post['test'] == '')?0:$this->request->post['test'];						
			}elseif($productCode == 'MANDIRISMS'){
				$feeTransaction = ($this->request->post['test'] == '')?0:$this->request->post['test'];			
			}elseif($productCode == 'MUAMALATATM'){
				$feeTransaction = ($this->request->post['test'] == '')?0:$this->request->post['test'];			
			}elseif($productCode == 'XLTUNAI'){
				$feeTransaction = ($this->request->post['test'] == '')?0:$this->request->post['test'];
						
			}
			  
			$total_data[] = array( 
				'code'       => 'transaction_fee',
				'title'      => $this->language->get('text_transaction_fee'),
				'text'       => $this->currency->format($feeTransaction),
				'value'      => $feeTransaction,
				'sort_order' => $this->config->get('shipping_sort_order')
			);

			/* if ($this->session->data['shipping_method']['tax_class_id']) {
				$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			} */

			$total += $feeTransaction;
		}			
	}
	
	public function gettotalorder($order_id){
		$sqltotal = $this->db->query("SELECT `total` FROM `".DB_PREFIX."order` where order_id=".$order_id);		
		$total = $sqltotal->row['total'];	
		
		return $total;
	}
}
?>