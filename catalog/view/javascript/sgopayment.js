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

function submitdata(url){
	
	var espayproduct = $("#espayproduct").val();
		
	if (espayproduct == ""){
		alert("Please Select Payment Method");
		
	}else{			
				
		var espayproductarr = espayproduct.split(":");
		var bankCode = espayproductarr[0];
		var productCode = espayproductarr[1];
	
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
				
				//console.log(url+"&product="+productCode);
				
				 jQuery.ajax({
					   type : "GET",
					   url : url+"&product="+productCode,
					   success : (function() {
						//console.log('success');
						if (sgoPlusIframe !== null)
						 sgoPlusIframe.src = SGOSignature.getIframeURL(data);
						 SGOSignature.receiveForm() 

					   })
				});				
				
		}else{
				alert("espayproduct id is not defined");
			} 
	}
		 
	 
}

