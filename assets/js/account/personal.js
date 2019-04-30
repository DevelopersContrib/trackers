$(document).ready(function(){
	$( document ).on( "click", "#btnSavePersonal", function() {
		var firstname = $('#account_firstname').val();
		var lastname = $('#account_lastname').val();
		var occupation = $('#account_occupation').val();
		var website = $('#account_website').val();
		$('#accountPError').addClass('d-none');
		$('#accountPSuccess').addClass('d-none');

		
		if (firstname == ''){
			$('#accountPError').removeClass('d-none');
			$('#accountPError .alert-danger').html('Please enter first name');
			jQuery('#account_firstname').focus();
		}else if (lastname == ''){
			$('#accountPError').removeClass('d-none');
			$('#accountPError .alert-danger').html('Please enter last name');
			jQuery('#account_lastname').focus();
		}else {
			$('#btnSavePersonal').attr("disabled", true);
			$('#btnSavePersonal').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
			
			$.post("/account/savepersonal",
					{
					  firstname:firstname,
					  lastname:lastname,
					  occupation:occupation,
					  website:website
					  
					}
					 ,function(data){
						 $('#btnSavePersonal').attr("disabled", false);
		        		 $('#btnSavePersonal').html('<i class="fas fa-check"></i> Save Changes');
						 if (data.status){
							 $('#accountPSuccess').removeClass('d-none');
							 $('#accountPSuccess .alert-success').html('You successfully updated personal settings.');
							 setTimeout(function(){ 
								 $('#accountPSuccess').addClass('d-none');
								 $('#accountPSuccess .alert-success').html('');
						     }, 10000);
	
		                 }else {
		                	 $('#accountPError').removeClass('d-none');
		         			 $('#accountPError .alert-danger').html(data.message);
		         			
		                 }
					 }
			);
		}
		
	});
});