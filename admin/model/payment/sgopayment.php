<?php
class ModelPaymentSgopayment extends Model {
	
	public function install (){
		
		$sqllog = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."sgopayment_log` (
		`uuid`  varchar(255) NOT NULL,
		`datetime` varchar(255) NOT NULL,
		`service`  varchar(255) NOT NULL,
		`request` TEXT NOT NULL,
		`respond` TEXT NOT NULL,
		PRIMARY KEY (`uuid`)
		)";
		
		$this->db->query($sqllog);
		
		$sqlproduct = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."sgopayment_product` (
		`id`  int(10) NOT NULL AUTO_INCREMENT,
		`bankcode` varchar(255) NOT NULL,
		`productcode`  varchar(255) NOT NULL,
		`productname`  varchar(255) NOT NULL,
		PRIMARY KEY (`id`)
		)";
		$this->db->query($sqlproduct);
		
	}
	
	
	public function clearProduct(){
		$sqlDelete = 'TRUNCATE TABLE `'.DB_PREFIX.'sgopayment_product`';
		$this->db->query($sqlDelete);
	}
	
	public function insertProduct($products){
		foreach ($products->data as $productValue){
			$sqlInsertProduct = "INSERT INTO `".DB_PREFIX."sgopayment_product`  (`bankcode`,`productcode`,`productname`) values ('".$productValue->bankCode."','".$productValue->productCode."','".$productValue->productName."') ";
			$this->db->query($sqlInsertProduct);
		}
	}
	
	public function getProduct (){
		$sql = 'SELECT * FROM `'.DB_PREFIX.'sgopayment_product`';
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
	
}