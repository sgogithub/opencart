/*
* 2007-2013 Opencart
*
* NOTICE OF LICENSE
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade Opencart to newer
* versions in the future. If you wish to customize Opencart for your
* needs please refer to http://www.opencart.com for more information.
*
*  @author PT Square Gate One <business@sgo.co.id>
*  @copyright  2014 Square Gate One
*  International Registered Trademark & Property of PT Square Gate One
*/

function submitdata(){
	if (typeof	( $("#sgopayment input[type='radio']:checked").val()) === 'undefined'){
		alert("Please Select Payment Method");
		
	}else{
		
		var pos = $("#sgopayment input[type='radio']:checked").val(); 
		var posLength = pos.length;
		var n = pos.indexOf(":");
		var bankCode = pos.substr(0,n);
		var productCode = pos.substr(n+1,posLength);
		
		if ($('#sgopaymentid').val()){
			var data = {
						key : $('#sgopaymentid').val(),
						paymentId : $('#cartid').val(),
						paymentAmount : $('#paymentamount').val(),
						backUrl :escape($('#back_url').val()+"&product="+productCode),
						bankCode : bankCode,
						bankProduct: productCode
					},
				sgoPlusIframe = document.getElementById("sgoplus-iframe");
				
				if (sgoPlusIframe !== null) {
					sgoPlusIframe.src = SGOSignature.getIframeURL(data);
					console.log(sgoPlusIframe.src);
				}
				SGOSignature.receiveForm();
			}else{
				alert("sgopayment id is not defined");
			}
		}
		
	 
}

