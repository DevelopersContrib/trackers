function resetloginform(){
	$('#form_error_email').addClass('d-none');
	$('#form_error_password').addClass('d-none');
}

function showloginerror(field,message){
	$('#form_error_'+field).removeClass('d-none');
	$('#form_error_'+field).html(message);
}


function submitlogin(){
	var email = $('#login_email').val();
	var password = $('#login_password').val();
	var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	
	resetloginform();
	
	if (email == ''){
		showloginerror('email','Please enter email');
	}else if (password == ''){
		showloginerror('password','Please enter password');
	}else if(!emailfilter.test(email)){
		showloginerror('email','Invalid email address');
	}else {
		$('#btnLogin').attr("disabled", true);
		$('#btnLogin').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Verifying account...');
		
		$.post('/login/ajaxlogin',
			    {
				   email:email,
				   password:password
				}
			    ,function(data){
			     if (data.status){
			    		window.location = '/dashboard';
			     }else {
			    	 showloginerror(data.field,data.message);
			    	 $('#btnLogin').attr("disabled", false);
			 		 $('#btnLogin').html('<i class="fas fa-lock"></i> Login');
			     }
				
			    
			});
	}
}

$(document).ready(function(){
	$('#btnLogin').click(function(){
		submitlogin();
	});
	
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	    	submitlogin();
	    }
	});
});