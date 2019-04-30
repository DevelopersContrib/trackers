function resetsignupform(){
	$('#form_error_first_name').addClass('d-none');
	$('#form_error_last_name').addClass('d-none');
	$('#form_error_email').addClass('d-none');
	$('#form_error_password').addClass('d-none');
}

function showsignuperror(field,message){
	$('#form_error_'+field).removeClass('d-none');
	$('#form_error_'+field).html(message);
}

function submitsignup(){
	var first_name = $('#first_name').val();
	var last_name = $('#last_name').val();
	var email = $('#email').val();
	var password = $('#password').val();
	var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var domain = $('#domain').val();
	var user_ip = $('#user_ip').val();
	var secret = $('#secret').val();
	
	resetsignupform();
	
	if (first_name == ''){
		showsignuperror('first_name','Please enter first name');
	}else if (last_name == ''){
		showsignuperror('last_name','Please enter last name');
	}else if (email == ''){
		showsignuperror('email','Please enter email');
	}else if (password == ''){
		showsignuperror('password','Please enter password');
	}else if(!emailfilter.test(email)){
		showsignuperror('email','Invalid email address');
	}else if(password.length < 8 || password.length > 20){
		showsignuperror('password','Password must be 8 to 20 characters');
	}else {
		$('#btn-signup-submit').attr("disabled", true);
		$('#btn-signup-submit').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Please wait...');
		$.post('/signup/ajaxsaveuser',
		    {
			   first_name:first_name,
			   last_name:last_name,
			   email:email,
			   password:password,
			   domain:domain,
			   user_ip:user_ip
			}
		    ,function(data){
		     if (data.status){
		    	 $('#form-step1-success').addClass('d-none');
					$('#success-email-content').html('<h3>'+data.email+'</h3>');
					$('#form-div-success').removeClass('d-none');
		    	 
		    		
		     }else {
		    	 showsignuperror(data.field,data.message);
		    	 $('#btn-signup-submit').attr("disabled", false);
		 		 $('#btn-signup-submit').html('<i class="fas fa-check"></i> Sign Up');
		     }
			
		     $.ajax({
					type: "post",url: "http://www.contrib.com/forms/saveleads",
					data: {'email':data.email, 'domain':data.domain,'user_ip':data.ip,'secret':secret },
					success: function(res){
						
					}});
		});
		
	}
}


$(document).ready(function(){
	$('#btn-signup-submit').click(function(){
		submitsignup();
	});
	
	$(document).keypress(function(e) {
	    if(e.which == 13) {
	    	submitsignup();
	    }
	});
});