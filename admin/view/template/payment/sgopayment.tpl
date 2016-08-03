<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/payment.png" alt="" /> <?php echo $heading_title; ?></h1>
       <script type="text/javascript">
				var input = $("<input>").attr("type", "hidden").attr('name','updateproduct').val("update");
		</script>
      
      <div class="buttons">
		<a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
		<!--<a onclick="$('#form').append($(input)); $('#form').submit();" class="button"><?php echo $button_update; ?></a>-->
		<a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
         
           <tr>
            <td><span class="required">*</span> <?php echo $entry_sgopayment_id; ?></td>
            <td>
				<input type="text" size="50" name="sgopayment_id" value="<?php echo $sgopayment_id; ?>" />
				<?php if (isset($error['sgopayment_id'])): ?>
                <span class="error"><?php echo $error['sgopayment_id']; ?></span>
              <?php endif; ?>
			</td>
          </tr>
         
           <tr>
            <td><span class="required">*</span> <?php echo $entry_sgopayment_password; ?></td>
            <td>
				<input type="password" size="50" name="sgopayment_password" value="<?php echo $sgopayment_password; ?>" />
				<?php if (isset($error['sgopayment_password'])): ?>
                <span class="error"><?php echo $error['sgopayment_password']; ?></span>
              <?php endif; ?>
			</td>
          </tr>
		  
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_sgopayment_signaturekey; ?></td>
            <td>
				<input type="password" size="50" name="sgopayment_signaturekey" value="<?php echo $sgopayment_signaturekey; ?>" />
				<?php if (isset($error['sgopayment_signaturekey'])): ?>
                <span class="error"><?php echo $error['sgopayment_signaturekey']; ?></span>
              <?php endif; ?>
			</td>
          </tr>
          
		  <tr>
            <td><?php echo $entry_sgopayment_ip; ?></td>
            <td><input type="text" size="50" name="sgopayment_ip" value="<?php echo $sgopayment_ip; ?>" /></td>
          </tr>
          
          <tr>
            <td><span class="required">*</span> <?php echo $entry_total; ?></td>
            <td>
				<input type="text" name="sgopayment_total" value="<?php echo $sgopayment_total; ?>" />
				<?php if (isset($error['sgopayment_total'])): ?>
                <span class="error"><?php echo $error['sgopayment_total']; ?></span>
              <?php endif; ?>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status; ?></td>
            <td><select name="sgopayment_order_status_id">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $sgopayment_order_status_id) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
				<?php if (isset($error['sgopayment_order_status'])): ?>
                <span class="error"><?php echo $error['sgopayment_order_status']; ?></span>
              <?php endif; ?>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_order_status_waiting; ?></td>
            <td><select name="sgopayment_order_status_waiting">
                <?php foreach ($order_statuses as $order_status) { ?>
                <?php if ($order_status['order_status_id'] == $sgopayment_order_status_waiting) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
			  <?php if (isset($error['sgopayment_order_status'])): ?>
                <span class="error"><?php echo $error['sgopayment_order_status']; ?></span>
              <?php endif; ?>
			</td>
          </tr>
          <tr>
            <td><?php echo $entry_geo_zone; ?></td>
            <td><select name="sgopayment_geo_zone_id">
                <option value="0"><?php echo $text_all_zones; ?></option>
                <?php foreach ($geo_zones as $geo_zone) { ?>
                <?php if ($geo_zone['geo_zone_id'] == $sgopayment_geo_zone_id) { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>" selected="selected"><?php echo $geo_zone['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $geo_zone['geo_zone_id']; ?>"><?php echo $geo_zone['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select></td>
          </tr>
          <tr>
            <td><?php echo $entry_status; ?></td>
            <td><select name="sgopayment_status">
                <?php if ($sgopayment_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td><?php echo $entry_environment; ?></td>
            <td><select name="sgopayment_environment">
                <?php if ($sgopayment_environment) { ?>
                <option value="1" selected="selected"><?php echo $text_production; ?></option>
                <option value="0"><?php echo $text_development; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_production; ?></option>
                <option value="0" selected="selected"><?php echo $text_development; ?></option>
                <?php } ?>
              </select></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_max_order_total; ?></td>
            <td>
				<input type="text" name="sgopayment_max_order_total" value="<?php echo $sgopayment_max_order_total; ?>" />
				<?php if (isset($error['sgopayment_max_order_total'])): ?>
                <span class="error"><?php echo $error['sgopayment_max_order_total']; ?></span>
              <?php endif; ?>
			</td>
          </tr>
		  <tr>
            <td><?php echo $entry_credit_card_mdr; ?></td>
            <td><input type="text" name="sgopayment_credit_card_mdr" value="<?php echo $sgopayment_credit_card_mdr; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_bca_klikpay; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_bca_klikpay" value="<?php echo $sgopayment_transaction_fee_bca_klikpay; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_epay_bri; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_epay_bri" value="<?php echo $sgopayment_transaction_fee_epay_bri; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_mandiri_ib; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_mandiri_ib" value="<?php echo $sgopayment_transaction_fee_mandiri_ib; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_mandiri_ecash; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_mandiri_ecash" value="<?php echo $sgopayment_transaction_fee_mandiri_ecash; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_credit_card; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_credit_card" value="<?php echo $sgopayment_transaction_fee_credit_card; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_permata_atm; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_permata_atm" value="<?php echo $sgopayment_transaction_fee_permata_atm; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_danamon_ob; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_danamon_ob" value="<?php echo $sgopayment_transaction_fee_danamon_ob; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_bii_atm; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_bii_atm" value="<?php echo $sgopayment_transaction_fee_bii_atm; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_permata_netpay; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_permata_netpay" value="<?php echo $sgopayment_transaction_fee_permata_netpay; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_nobupay; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_nobupay" value="<?php echo $sgopayment_transaction_fee_nobupay; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_finpay; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_finpay" value="<?php echo $sgopayment_transaction_fee_finpay; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_mayapada_ib; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_mayapada_ib" value="<?php echo $sgopayment_transaction_fee_mayapada_ib; ?>" /></td>
          </tr>
		  <tr>
            <td><?php echo $entry_transaction_fee_bitcoin; ?></td>
            <td><input type="text" name="sgopayment_transaction_fee_bitcoin" value="<?php echo $sgopayment_transaction_fee_bitcoin; ?>" /></td>
          </tr>
		  <tr>
            <td><span class="required">*</span> <?php echo $entry_transaction_fee_label; ?></td>
            <td>
				<input type="text" name="sgopayment_transaction_fee_label" value="<?php echo $sgopayment_transaction_fee_label; ?>" size="50" />
				<?php if (isset($error['sgopayment_transaction_fee_label'])): ?>
                <span class="error"><?php echo $error['sgopayment_transaction_fee_label']; ?></span>
              <?php endif; ?>
			</td>
          </tr>
		  
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="sgopayment_sort_order" value="<?php echo $sgopayment_sort_order; ?>" size="1" /></td>
          </tr>
          
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>