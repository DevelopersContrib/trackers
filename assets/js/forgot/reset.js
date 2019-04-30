function resetpasswordform(){
	$('#form_error_password').addClass('d-none');
	$('#form_error_confirm_password').addClass('d-none');
}

function showpassworderror(field,message){
	$('#form_error_'+field).removeClass('d-none');
	$('#form_error_'+field).html(message);
}

function resetpassword(){
	var password = $('#password').val();
	var confirm_password = $('#confirm_password').val();
	var code = $('#password_code').val();
	resetpasswordform();
	
	if (password == ''){
		showpassworderror('password','Please enter password');
	}else if(password.length < 8 || password.length > 20){
		showpassworderror('password','Password must be 8 to 20 characters');
	}else if (confirm_password == ''){
		showpassworderror('confirm_password','Please confirm password');
	}else if (password != confirm_password){
		showpassworderror('confirm_password','Password mismatch');
	}else {
		$('#btnResetPassword').attr("disabled", true);
		$('#btnResetPassword').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Updating...');
		
		$.post('/forgot/ajaxupdatepassword',
			    {
				   password:password,
				   code:code
				}
			    ,function(data){
			     if (data.status){
			    		window.location = '/login';
			     }else {
			    	 showpassworderror(data.field,data.message);
			    	 $('#btnResetPassword').attr("disabled", false);
			 		 $('#btnResetPassword').html('SET PASSWORD');
			     }
				
			    
			});
	}
}

$(document).ready(function(){
	$('#btnResetPassword').click(function(){
		resetpassword();
	});
	
	$("#confirm_password").keypress(function(event) {
		  if ( event.which == 13 ) {
			  resetpassword();
		  }
	});	
});