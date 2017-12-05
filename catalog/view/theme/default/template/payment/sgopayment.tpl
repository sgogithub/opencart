<!-- <script type="text/javascript" src="http://secure-dev.sgo.co.id/public/signature/js"></script> -->


<!--<script type="text/javascript" src="https://secure.sgo.co.id/public/signature/js"></script>----->
<script type="text/javascript">
function validateespayproduct() {		
		
	if (typeof	( $("#sgopayment input[type='radio']:checked").val()) === 'undefined'){
		alert("Please Select Payment Method");
	} else {		
		//alert("Payment Method Selected");
		document.sgopayment.action = 'index.php?route=checkout/orderpay';		
	}
	
}
</script>
<form name="sgopayment" id="sgopayment" method="post" action="javascript:;" onsubmit="validateespayproduct(this)">
<h2><?php echo $text_instruction; ?></h2>
<div class="content">
	<table align="center" style="margin: 0px auto;">
	
	<?php echo $product_list; ?>
	</table>
	<input type="hidden" value="<?php echo $sgopaymentid ?>" name="sgopaymentid" id="sgopaymentid">
	<input type="hidden" value="<?php echo $order_id ?>" name="cartid" id="cartid">
	<input type="hidden" value="<?php echo $total ?>" name="paymentamount" id="paymentamount">
	<input type="hidden" value="<?php echo $back_url?>" name="back_url" id="back_url">
	<input type="hidden" value="<?php echo $urlUpdateOrder?>" name="url" id="url">
	
	
	<input type="hidden" value="<?php echo $sgopayment_credit_card_mdr?>" name="sgopayment_credit_card_mdr" id="sgopayment_credit_card_mdr">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_bca_klikpay?>" name="sgopayment_transaction_fee_bca_klikpay" id="sgopayment_transaction_fee_bca_klikpay">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_epay_bri?>" name="sgopayment_transaction_fee_epay_bri" id="sgopayment_transaction_fee_epay_bri">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_mandiri_ib?>" name="sgopayment_transaction_fee_mandiri_ib" id="sgopayment_transaction_fee_mandiri_ib">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_mandiri_ecash?>" name="sgopayment_transaction_fee_mandiri_ecash" id="sgopayment_transaction_fee_mandiri_ecash">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_credit_card?>" name="sgopayment_transaction_fee_credit_card" id="sgopayment_transaction_fee_credit_card">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_permata_atm?>" name="sgopayment_transaction_fee_permata_atm" id="sgopayment_transaction_fee_permata_atm">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_danamon_ob?>" name="sgopayment_transaction_fee_danamon_ob" id="sgopayment_transaction_fee_danamon_ob">

	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_danamon_atm?>" name="sgopayment_transaction_fee_danamon_atm" id="sgopayment_transaction_fee_danamon_atm">
	
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_bii_atm?>" name="sgopayment_transaction_fee_bii_atm" id="sgopayment_transaction_fee_bii_atm">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_permata_netpay?>" name="sgopayment_transaction_fee_permata_netpay" id="sgopayment_transaction_fee_permata_netpay">
	<input type="hidden" value="<?php echo $sgopaytment_transaction_fee_nobupay?>" name="sgopayment_transaction_fee_nobupay" id="sgopayment_transaction_fee_nobupay">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_finpay?>" name="sgopayment_transaction_fee_finpay" id="sgopayment_transaction_fee_finpay">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_mayapada_ib?>" name="sgopayment_transaction_fee_mayapada_ib" id="sgopayment_transaction_fee_mayapada_ib">
	<input type="hidden" value="<?php echo $sgopayment_transaction_fee_bitcoin?>" name="sgopayment_transaction_fee_bitcoin" id="sgopayment_transaction_fee_bitcoin">
	
	</div>
<iframe id="sgoplus-iframe" style="display:none" src="" scrolling="no" frameborder="0"></iframe>
<script type="text/javascript" src="<?php echo $dir_js; ?>sgopayment.js"></script>
<div class="buttons">
  <div class="right">
    <input type="submit" value="<?php echo $button_confirm; ?>" id="button-confirm" name="button-confirm" class="button" />
  </div>
</div>
</form>

