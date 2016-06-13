<?php
class ModelPaymentSgopayment extends Model {
	
	public function install (){
			
		$sqlalter = "ALTER TABLE `".DB_PREFIX."order` ADD espay_fee Varchar(50), ADD espay_product Varchar(50)";
		$this->db->query($sqlalter);
		
		$sqlinsertsetting = "INSERT INTO `".DB_PREFIX."setting` (`store_id`, `group`, `key`, `value`, `serialized`) values ('0','transaction_fee','transaction_fee_status','1','0')";
		$this->db->query($sqlinsertsetting);
		
		$sqlinsertsetting2 = "INSERT INTO `".DB_PREFIX."setting` (`store_id`, `group`, `key`, `value`, `serialized`) values ('0','transaction_fee','transaction_fee_sort_order','1','0')";
		$this->db->query($sqlinsertsetting2);
		
		$sqlinsertextension = "INSERT INTO `".DB_PREFIX."extension` (`type`, `code`) values ('total','transaction_fee')";
		$this->db->query($sqlinsertextension);
		
		/* $sqllog = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."sgopayment_log` (
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
		$this->db->query($sqlproduct); */
		
	}
	
	public function uninstall (){		
		$sqlalterdrop = "ALTER TABLE `".DB_PREFIX."order` DROP COLUMN espay_fee, DROP COLUMN espay_product";
		$this->db->query($sqlalterdrop);		
		
		$sqldeletesetting = "DELETE FROM `".DB_PREFIX."setting` where `group` = 'transaction_fee' ";
		$this->db->query($sqldeletesetting);
		
		$sqldeleteextension = "DELETE FROM `".DB_PREFIX."extension` where `code` = 'transaction_fee' ";
		$this->db->query($sqldeleteextension);
	}
	
	
	/* public function clearProduct(){
		$sqlDelete = 'TRUNCATE TABLE `'.DB_PREFIX.'sgopayment_product`';
		$this->db->query($sqlDelete);
	} */
	
	/* public function insertProduct($products){
		foreach ($products->data as $productValue){
			$sqlInsertProduct = "INSERT INTO `".DB_PREFIX."sgopayment_product`  (`bankcode`,`productcode`,`productname`) values ('".$productValue->bankCode."','".$productValue->productCode."','".$productValue->productName."') ";
			$this->db->query($sqlInsertProduct);
		}
	} */
	
	/* public function getProduct (){
		$sql = 'SELECT * FROM `'.DB_PREFIX.'sgopayment_product`';
		$query = $this->db->query($sql);
		
		return $query->rows;
	} */
	
}