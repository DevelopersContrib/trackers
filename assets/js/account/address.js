$(document).ready(function(){
	$( document ).on( "click", "#btnSaveAddress", function() {
		var address = $('#account_address').val();
		var city = $('#account_city').val();
		var state = $('#account_state').val();
		var zipcode = $('#account_zipcode').val();
		$('#accountAError').addClass('d-none');
		$('#accountASuccess').addClass('d-none');

		
			$('#btnSaveAddress').attr("disabled", true);
			$('#btnSaveAddress').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
			
			$.post("/account/saveaddress",
					{
					  address:address,
					  city:city,
					  state:state,
					  zipcode:zipcode
					  
					}
					 ,function(data){
						 $('#btnSaveAddress').attr("disabled", false);
		        		 $('#btnSaveAddress').html('<i class="fas fa-check"></i> Save Changes');
						 if (data.status){
							 $('#accountASuccess').removeClass('d-none');
							 $('#accountASuccess .alert-success').html('You successfully updated address settings.');
							 setTimeout(function(){ 
								 $('#accountASuccess').addClass('d-none');
								 $('#accountASuccess .alert-success').html('');
						     }, 10000);
	
		                 }else {
		                	 $('#accountAError').removeClass('d-none');
		         			 $('#accountAError .alert-danger').html(data.message);
		         			
		                 }
					 }
			);
		
		
	});
});