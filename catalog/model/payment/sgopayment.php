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
	
	
	
}