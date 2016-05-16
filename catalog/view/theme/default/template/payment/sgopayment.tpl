<script type="text/javascript" src="<?=$uri ?>/public/signature/js"></script>


<!--<script type="text/javascript" src="https://secure.sgo.co.id/public/signature/js"></script>----->
<form name="sgopayment" id="sgopayment">
<h2><?php echo $text_instruction; ?></h2>
<div class="content">
	<table align="center" style="margin: 0px auto;">

	<?php echo $product_list; ?>
	</table>
	<input type="hidden" value="<?php echo $sgopaymentid ?>" name="sgopaymentid" id="sgopaymentid">
	<input type="hidden" value="<?php echo $order_id ?>" name="cartid" id="cartid">
	<input type="hidden" value="<?php echo $total ?>" name="paymentamount" id="paymentamount">
	<input type="hidden" value="<?php echo $back_url?>" name="back_url" id="back_url">
</div>
<iframe id="sgoplus-iframe" style="display:none" src="" scrolling="no" frameborder="0"></iframe>
<script type="text/javascript" src="<?php echo $dir_js; ?>sgopayment.js"></script>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm"  name="button-confirm" onclick="submitdata()" class="button" />
  </div>
</div>
</form>
