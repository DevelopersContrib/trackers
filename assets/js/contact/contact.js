function resetcontactform(){
	$('#form_error_contact_name').addClass('d-none');
	$('#form_error_contact_email').addClass('d-none');
	$('#form_error_contact_subject').addClass('d-none');
	$('#form_error_contact_message').addClass('d-none');
}

function showcontacterror(field,message){
	$('#form_error_'+field).removeClass('d-none');
	$('#form_error_'+field).html(message);
}


$(document).ready(function(){
	$('#btnSubmitContact').click(function(){
		var name = 	$('#contact_name').val();
		var email = $('#contact_email').val();
		var subject = $('#contact_subject').val();
		var message = $('#contact_message').val();
		var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		
		resetcontactform();
		$('#contactsuccess').addClass('d-none');
		
		if (name == ''){
			showcontacterror('contact_name','Please enter name');
		}else if (email == ''){
			showcontacterror('contact_email','Please enter email');
		}else if (subject == ''){
			showcontacterror('contact_subject','Please enter subject');
		}else if (message == ''){
			showcontacterror('contact_message','Please enter message');
		}else if(!emailfilter.test(email)){
			showcontacterror('contact_email','Invalid email address');
		}else {
			$('#btnSubmitContact').attr("disabled", true);
			$('#btnSubmitContact').html('<i class="fa fa-spinner fa-spin fa-fw"></i> Sending...');
			$.post('/contact/ajaxsavecontact',
				    {
					   name:name,
					   email:email,
					   subject:subject,
					   message:message
					}
				    ,function(data){
				     if (data.status){
				    	 $('#contactsuccess').removeClass('d-none');
				    	 $('#contactsuccess .form-group .alert-success').html('Your message was sent successfully.');  
				    	 $('#btnSubmitContact').attr("disabled", false);
				 		 $('#btnSubmitContact').html('Submit');
				     }else {
				    	 showloginerror(data.field,data.message);
				    	 $('#btnSubmitContact').attr("disabled", false);
				 		 $('#btnSubmitContact').html('Submit');
				     }
					
				    
				});
		}

	});
	
	
});