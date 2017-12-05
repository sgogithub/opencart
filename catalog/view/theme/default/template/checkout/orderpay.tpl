<?php echo $header; ?>

  <h1>
	<?php echo $heading_title; ?> » <?php echo $espay_product_name; ?>
  </h1>
  
  <!-- duplicate from Confirm -->
  <div class="checkout-product">
  <table>
    <thead>
      <tr>
        <td class="name"><?php echo $column_name; ?></td>
        <td class="model"><?php echo $column_model; ?></td>
        <td class="quantity"><?php echo $column_quantity; ?></td>
        <td class="price"><?php echo $column_price; ?></td>
        <td class="total"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>  
      <?php if($product['recurring']): ?>
        <tr>
            <td colspan="6" style="border:none;"><image src="catalog/view/theme/default/image/reorder.png" alt="" title="" style="float:left;" /><span style="float:left;line-height:18px; margin-left:10px;"> 
                <strong><?php echo $text_recurring_item ?></strong>
                <?php echo $product['profile_description'] ?>
            </td>
        </tr>
      <?php endif; ?>
      <tr>
        <td class="name">
		  <!-- <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a> -->
		  <?php echo $product['name']; ?>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?>
          <?php if($product['recurring']): ?>
          <br />
          &nbsp;<small><?php echo $text_payment_profile ?>: <?php echo $product['profile_name'] ?></small>
          <?php endif; ?>
        </td>
        <td class="model"><?php echo $product['model']; ?></td>
        <td class="quantity"><?php echo $product['quantity']; ?></td>
        <td class="price"><?php echo $product['price']; ?></td>
        <td class="total"><?php echo $product['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="name"><?php echo $voucher['description']; ?></td>
        <td class="model"></td>
        <td class="quantity">1</td>
        <td class="price"><?php echo $voucher['amount']; ?></td>
        <td class="total"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <?php foreach ($totals as $total) { ?>
      <tr>
        <td colspan="4" class="price"><b><?php echo $total['title']; ?>:</b></td>
        <td class="total"><?php echo $total['text']; ?></td>
      </tr>
      <?php } ?>
    </tfoot>
  </table>
</div>
<!-- <script type="text/javascript" src="http://secure-dev.sgo.co.id/public/signature/js"></script> -->

<?php if ($MODULE_PAYMENT_ESPAY_MODE == 1){ ?>
	<script type="text/javascript" src="https://kit.espay.id/public/signature/js"></script>
<?php }else{ ?>	
	<script type="text/javascript" src="https://sandbox-kit.espay.id/public/signature/js"></script>
<?php } ?>

 <iframe id="sgoplus-iframe" style="display:none" src="" scrolling="no" frameborder="0"></iframe>
<script type="text/javascript" src="<?php echo $dir_js; ?>sgopayment.js"></script>
  <div class="buttons">
    <div class="right">
		<input type="hidden" value="<?php echo $this->request->post['sgopaymentid'] ?>" name="sgopaymentid" id="sgopaymentid">
		<input type="hidden" value="<?php echo $this->request->post['cartid'] ?>" name="cartid" id="cartid">
		<input type="hidden" value="<?php echo $this->request->post['paymentamount'] ?>" name="paymentamount" id="paymentamount">
		<input type="hidden" value="<?php echo $this->request->post['back_url']?>" name="back_url" id="back_url">
		<input type="hidden" value="<?php echo $this->request->post['espayproduct']?>" name="espayproduct" id="espayproduct">
		
		<!-- <a href="<?php echo $checkout; ?>" class="button"><?php echo $button_confirm_and_pay; ?></a>     -->
		<input type="button" value="<?php echo $button_confirm_and_pay; ?>" id="button-confirm"  name="button-confirm" onclick="submitdata('<?php echo $this->request->post['url']?>&fee=<?php echo $fee; ?>')" class="button" />
	</div>
  </div>
  

<?php echo $footer; ?>
