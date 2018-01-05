<?php
class ModelPaymentSgopayment extends Model {
	public function getMethod($address, $total) {
		$this->language->load('payment/sgopayment');
	
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('sgopayment_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
	
		if ($this->config->get('sgopayment_total') > 0 && $this->config->get('sgopayment_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('sgopayment_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}
	
		$method_data = array();
	
		if ($status) {
			$method_data = array(
					'code'       => 'sgopayment',
					'title'      => $this->language->get('text_title'),
					'sort_order' => $this->config->get('sgopayment_sort_order')
			);
		}
		 
		return $method_data;
	}
	
	
	public function insertLog($uuid, $datetime, $service, $data){
		$sqlInsertLog = "INSERT INTO `".DB_PREFIX."sgopayment_log` (`uuid`,`datetime`,`service`,`request`) VALUES ('".$uuid."', '".$datetime."', '".$service."', '".$data."')";
		$this->db->query($sqlInsertLog);
		return $this->db->getLastId();
	}
	
	
	public function updateLog($id, $data){
		$sqlUpdateLog = "UPDATE `".DB_PREFIX."sgopayment_log`
								SET respond='".$data."'
								WHERE id=".$id."";
		$this->db->query($sqlUpdateLog);
	}
	
	public function getProductList(){
		
		$sql = 'SELECT * FROM `'.DB_PREFIX.'sgopayment_product`';
		$productlist = $this->db->query($sql);
		return $productlist->rows;
	}
	
	public function insertfee($fee, $order_id, $product){
		
		//insert fee & product to tbl order		
		$sqltotal = $this->db->query("SELECT `total`, case when (`espay_fee` is null or `espay_fee` = '') then 0 else 1 end as `status_fee` FROM `".DB_PREFIX."order` where order_id=".$order_id);		
		
		if ($sqltotal->row['status_fee'] == 0){ // if fee not insert yet
			$total = $sqltotal->row['total'];		
			$total_ = str_replace( '.0000', '', $total);
			
			$totalorder = $total_ + $fee;
			
			$sqlUpdateFee = "UPDATE `".DB_PREFIX."order`
									SET espay_fee='".$fee."', total='".$totalorder."', espay_product='".$product."'
									WHERE order_id=".$order_id."";
			$this->db->query($sqlUpdateFee);
		}
		
		$currSymobl = $this->currency->getSymbolLeft($this->session->data['currency']);
		
		//insert fee to tbl order_total				
		$sqlstatustransactionfee = $this->db->query("SELECT count(*) as `status_transaction_fee` FROM `".DB_PREFIX."order_total` where order_id =".$order_id." and code = 'transaction_fee'");
		
		if ($sqlstatustransactionfee->row['status_transaction_fee'] == 0){ // if transaction_fee not insert yet
			$text = $currSymobl.number_format($fee,2);
			$sqlInsertFee = "INSERT INTO `".DB_PREFIX."order_total` (`order_id`,`code`,`title`,`text`,`value`,`sort_order`) VALUES ('".$order_id."', 'transaction_fee', 'Transaction Fee', '".$text."',  '".$fee."', '8')";
			$this->db->query($sqlInsertFee);
			
			//update total in tbl order_total
			$sqltotalorder = $this->db->query("SELECT `value` FROM `".DB_PREFIX."order_total` where order_id=".$order_id." and code='total'");		
			$totalorder2 = $sqltotalorder->row['value'];		
			$totalorder_ = str_replace( '.0000', '', $totalorder2);
			
			$value = $totalorder_ + $fee;
			$textTotal = $currSymobl.number_format($value,2);
			$sqlUpdateTotal = "UPDATE `".DB_PREFIX."order_total`
									SET text='".$textTotal."', value='".$value."'
									WHERE order_id=".$order_id." and code='total' ";
			$this->db->query($sqlUpdateTotal);
		}		
	}
	
	public function getfee($order_id){
		
		$sqltotal = $this->db->query("SELECT `espay_fee` FROM `".DB_PREFIX."order` where order_id=".$order_id);		
		$total = $sqltotal->row['espay_fee'];	
		
		return $total;
	}
	
	
	
}