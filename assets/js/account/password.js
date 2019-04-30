$(document).ready(function(){
	$( document ).on( "click", "#btnSavePassword", function() {
		var current_password = $('#current_password').val();
		var new_password = $('#new_password').val();
		var new_password2 = $('#new_password2').val();
		
		$('#accountPassError').addClass('d-none');
		$('#accountPassSuccess').addClass('d-none');

		if (current_password == ''){
			$('#accountPassError').removeClass('d-none');
			$('#accountPassError .alert-danger').html('Please enter current password');
			jQuery('#current_password').focus();
		}else if (new_password == ''){
			$('#accountPassError').removeClass('d-none');
			$('#accountPassError .alert-danger').html('Please enter new password');
			jQuery('#new_password').focus();
		}else if (new_password2 == ''){
			$('#accountPassError').removeClass('d-none');
			$('#accountPassError .alert-danger').html('Please enter confirm password');
			jQuery('#new_password2').focus();
		}else if (new_password != new_password2){
			$('#accountPassError').removeClass('d-none');
			$('#accountPassError .alert-danger').html('Password mismatch');
			jQuery('#new_password2').focus();
		}else if(new_password.length < 8 || new_password.length > 20){
			$('#accountPassError').removeClass('d-none');
			$('#accountPassError .alert-danger').html('Password must be 8 to 20 characters');
			jQuery('#new_password').focus();
		}else {
		
			$('#btnSavePassword').attr("disabled", true);
			$('#btnSavePassword').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
			
			$.post("/account/savepassword",
					{
					  current_password:current_password,
					  new_password:new_password,
					  new_password2:new_password2
					}
					 ,function(data){
						 $('#btnSavePassword').attr("disabled", false);
		        		 $('#btnSavePassword').html('<i class="fas fa-check"></i> Save Changes');
						 if (data.status){
							 $('#accountPassSuccess').removeClass('d-none');
							 $('#accountPassSuccess .alert-success').html('You successfully updated password.');
							 setTimeout(function(){ 
								 $('#accountPassSuccess').addClass('d-none');
								 $('#accountPassSuccess .alert-success').html('');
						     }, 10000);
	
		                 }else {
		                	 $('#accountPassError').removeClass('d-none');
		         			 $('#accountPassError .alert-danger').html(data.message);
		         			
		                 }
					 }
			);
			
		}
		
		
	});
});