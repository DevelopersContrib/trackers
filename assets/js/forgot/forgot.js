function submitforgot(){
	$('#form_error_email').addClass('d-none');
	var email = $('#forgot_email').val();
	var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	if (email == ''){
		$('#form_error_email').removeClass('d-none');
		$('#form_error_email').html('Please enter email');	
	}else if(!emailfilter.test(email)){
		$('#form_error_email').removeClass('d-none');
		$('#form_error_email').html('Invalid email address');	
	}else {
		$('#btnResetPassword').attr("disabled", true);
		$('#btnResetPassword').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Verifying...');
		$.post('/forgot/ajaxsendreset',
			    {
				   email:email
				}
			    ,function(data){
			     if (data.status){
			    	 $('#forgotForm').addClass('d-none');
			    	 $('#forgotSuccess').removeClass('d-none');
			    	 $('#btnResendPassword').attr('data',data.code)
			     }else {
			    	$('#btnResetPassword').attr("disabled", false);
			 		$('#btnResetPassword').html('RESET PASSWORD');
			 		$('#form_error_email').removeClass('d-none');
					$('#form_error_email').html(data.message);	
			     }
			});
	}
}

$(document).ready(function(){
	$('#btnResetPassword').click(function(){
		submitforgot();
	});
	
	$("#forgot_email").keypress(function(event) {
		  if ( event.which == 13 ) {
			  submitforgot();
		  }
	});
	
	$('#btnResendPassword').click(function(){
		var code = $(this).attr('data');
		$('#btnResendPassword').attr("disabled", true);
		$('#btnResendPassword').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Sending...');
		$.post('/forgot/resend',
			    {
				   code:code
				}
			    ,function(data){
			     if (data.status){
			    	 $('#forgotSuccess').addClass('d-none');
			    	 $('#resendSuccess').removeClass('d-none');
			    	 $('#btnResendPassword').attr("disabled", false);
			 		 $('#btnResendPassword').html('RESEND');
			 	 }
			});
		
	});
});