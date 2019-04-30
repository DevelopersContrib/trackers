$(document).ready(function(){
	$( document ).on( "click", "#btnGenerateApi", function() {
		
		$('#accountApiSuccess').addClass('d-none');
		$('#accountApiError').addClass('d-none');
		$('#btnGenerateApi').attr("disabled", true);
		$('#btnGenerateApi').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Generating...');
			
			$.post("/account/generateapi",
					{
					}
					 ,function(data){
						 $('#btnGenerateApi').attr("disabled", false);
		        		 $('#btnGenerateApi').html('<i class="fas fa-check"></i> Generate New Api');
						 if (data.status){
							 $('#btnGenerateApi').removeClass('d-none');
							 $('#btnGenerateApi .alert-success').html('You successfully generated api key.');
							 $('#fromApiContent').removeClass('d-none');
							 $('#labelApi').addClass('d-none');
							 $('#genApiBtn').addClass('ml-auto');
							 $('#current_api_key').val(data.key);
							 setTimeout(function(){ 
								 $('#accountApiSuccess').addClass('d-none');
								 $('#accountApiSuccess .alert-success').html('');
						     }, 10000);
	
		                 }else {
		                	 $('#accountApiError').removeClass('d-none');
		         			 $('#accountApiError .alert-danger').html(data.message);
		         			
		                 }
					 }
			);
			
		
		
		
	});
});