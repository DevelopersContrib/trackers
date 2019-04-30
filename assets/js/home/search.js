function resetsearchform(){
	$('#form_error_website').addClass('d-none');
	$('#form_error_name').addClass('d-none');
	$('#form_error_email').addClass('d-none');
	$('#form_error_social').addClass('d-none');
	$('#info-notif-website').addClass('d-none');
	$('#info-notif-name').addClass('d-none');
	$('#info-notif-email').addClass('d-none');
	$('#info-notif-social').addClass('d-none');
}

function showsearcherror(field,message){
	$('#form_error_'+field).removeClass('d-none');
	$('#form_error_'+field).html(message);
}

function searchWebsiteSubmit(){
	resetsearchform();
	var website = $('#searchWebsite').val();
	var user_ip = $('#user_ip').val();
	if (website == ''){
		showsearcherror('website','Please enter domain name');
	}else {
		$('#btnSearchWebsite').attr("disabled", true);
		$('#btnSearchWebsite').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Tracking...');
		$('#resultWebsite').removeClass('d-none');
		$('#tdwdomain').html(website);
		$.post('/home/ajaxsearchwebsite',
			    {
				   website:website,
				   user_ip:user_ip
				}
			    ,function(data){
			    	$('#info-notif-website').removeClass('d-none');
			     if (data.status){
			    	$('#formWebsite').addClass('d-none');
			    	$('#resultWebsiteH').html('Results for <b>'+data.domain+'</b>');
			    	$('#tdwdomain').html(data.domain);
			    	$('#tdwvalue').html(data.value);
			    	$('#tdwowner').html(data.owner);
			    	$('#tdwemail').html(data.email);
			    	$('#tdwphone').html(data.phone);
			    	$('#tdwexpire').html(data.expire);
			    	$('#tdwregistrar').html(data.registrar);
			    	$('#searchWebsite').val('');
			    	$('#btnSearchWebsite').attr("disabled", false);
			 		$('#btnSearchWebsite').html('Submit');
			     }else {
			    	 $('#resultWebsite').addClass('d-none');
			    	 showsearcherror(data.field,data.message);
			    	 $('#btnSearchWebsite').attr("disabled", false);
			 		 $('#btnSearchWebsite').html('Submit');
			     }
				
			    
			});
	}
}

function searchNameSubmit(){
	resetsearchform();
	var name = $('#searchName').val();
	var user_ip = $('#user_ip').val();
	if (name == ''){
		showsearcherror('name','Please enter name');
	}else {
		$('#btnSearchName').attr("disabled", true);
		$('#btnSearchName').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Tracking...');
		$('#resultName').removeClass('d-none');
		$('#tdnname').html(name);
		$.post('/home/ajaxsearchname',
			    {
				   name:name,
				   user_ip:user_ip
				}
			    ,function(data){
			    	$('#info-notif-name').removeClass('d-none');
			     if (data.status){
			    	$('#formName').addClass('d-none');
			    	$('#resultNameH').html('Results for <b>'+data.name+'</b>');
			    	$('#tdnname').html(data.name);
			    	$('#tdnemail').html(data.email);
			    	$('#tdnaddress').html(data.address);
			    	$('#tdnphone').html(data.phone);
			    	$('#tdncompany').html(data.company);
			    	$('#tdnnotes').html(data.notes);
			    	$('#tdnsocial').html(data.socials);
			    	$('#searchName').val('');
			    	$('#btnSearchName').attr("disabled", false);
			 		$('#btnSearchName').html('Submit');
			     }else {
			    	 $('#resultName').addClass('d-none');
			    	 showsearcherror(data.field,data.message);
			    	 $('#btnSearchName').attr("disabled", false);
			 		 $('#btnSearchName').html('Submit');
			     }
				
			    
			});
	}
}

function searchEmailSubmit(){
	resetsearchform();
	var email = $('#searchEmail').val();
	var user_ip = $('#user_ip').val();
	var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (email == ''){
		showsearcherror('email','Please enter email');
	}else if(!emailfilter.test(email)){
		showsearchperror('email','Invalid email address');
	}else {
		$('#btnSearchEmail').attr("disabled", true);
		$('#btnSearchEmail').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Tracking...');
		$('#resultEmail').removeClass('d-none');
		$('#tdeemail').html(email);
		$.post('/home/ajaxsearchemail',
			    {
				   email:email,
				   user_ip:user_ip
				}
			    ,function(data){
			    	$('#info-notif-email').removeClass('d-none');
			     if (data.status){
			    	$('#formEmail').addClass('d-none');
			    	$('#resultEmailH').html('Results for <b>'+data.email+'</b>');
			    	$('#tdename').html(data.name);
			    	$('#tdeemail').html(data.email);
			    	$('#tdeaddress').html(data.address);
			    	$('#tdephone').html(data.phone);
			    	$('#tdecompany').html(data.company);
			    	$('#tdenotes').html(data.notes);
			    	$('#tdesocial').html(data.socials);
			    	$('#searchEmail').val('');
			    	$('#btnSearchEmail').attr("disabled", false);
			 		$('#btnSearchEmail').html('Submit');
			     }else {
			    	 $('#resultEmail').addClass('d-none');
			    	 showsearcherror(data.field,data.message);
			    	 $('#btnSearchEmail').attr("disabled", false);
			 		 $('#btnSearchEmail').html('Submit');
			     }
				
			    
			});
	}
}

function isURL(str) {
	  var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
			  '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name and extension
			  '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
			  '(\\:\\d+)?'+ // port
			  '(\\/[-a-z\\d%@_.~+&:]*)*'+ // path
			  '(\\?[;&a-z\\d%@_.,~+&:=-]*)?'+ // query string
			  '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
			  return pattern.test(str);
}

function searchSocialSubmit(){
	resetsearchform();
	var social = $('#searchSocial').val();
	var user_ip = $('#user_ip').val();
	var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if (social == ''){
		showsearcherror('social','Please enter profile url');
	}else if(!isURL(social)){
		showsearcherror('social','Invalid profile url');
	}else {
		$('#btnSearchSocial').attr("disabled", true);
		$('#btnSearchSocial').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Tracking...');
		$('#resultSocial').removeClass('d-none');
		$('#resultSocialH').html('Results for <b>'+social+'</b>');
		$.post('/home/ajaxsearchsocial',
			    {
				   social:social,
				   user_ip:user_ip
				}
			    ,function(data){
			    	$('#info-notif-social').removeClass('d-none');
			     if (data.status){
			    	$('#formSocial').addClass('d-none');
			    	$('#tdsname').html(data.name);
			    	$('#tdsemail').html(data.email);
			    	$('#tdsaddress').html(data.address);
			    	$('#tdsphone').html(data.phone);
			    	$('#tdscompany').html(data.company);
			    	$('#tdsnotes').html(data.notes);
			    	$('#tdssocial').html(data.socials);
			    	$('#searchSocial').val('');
			    	$('#btnSearchSocial').attr("disabled", false);
			 		$('#btnSearchSocial').html('Submit');
			     }else {
			    	 $('#resultSocial').addClass('d-none');
			    	 showsearcherror(data.field,data.message);
			    	 $('#btnSearchSocial').attr("disabled", false);
			 		 $('#btnSearchSocial').html('Submit');
			     }
				
			    
			});
	}
}

$(document).ready(function(){
	$('#btnSearchWebsite').click(function(){
		searchWebsiteSubmit();
	});
	
	$("#searchWebsite").keypress(function(event) {
		  if ( event.which == 13 ) {
			  searchWebsiteSubmit();
		  }
	});	  

	$('#btnNewSearchWebsite').click(function(){
		$('#formWebsite').removeClass('d-none');
		$('#resultWebsite').addClass('d-none');
	});
	
	$('#btnSearchName').click(function(){
		searchNameSubmit();
	});
	
	$("#searchName").keypress(function(event) {
		  if ( event.which == 13 ) {
			  searchNameSubmit();
		  }
	});	 
	
	$('#btnNewSearchName').click(function(){
		$('#formName').removeClass('d-none');
		$('#resultName').addClass('d-none');
	});
	
	$('#btnSearchEmail').click(function(){
		searchEmailSubmit();
	});
	
	$("#searchEmail").keypress(function(event) {
		  if ( event.which == 13 ) {
			  searchEmailSubmit();
		  }
	});	 
	
	$('#btnNewSearchEmail').click(function(){
		$('#formEmail').removeClass('d-none');
		$('#resultEmail').addClass('d-none');
	});
	
	$('#btnSearchSocial').click(function(){
		searchSocialSubmit();
	});
	
	$("#searchSocial").keypress(function(event) {
		  if ( event.which == 13 ) {
			  searchSocialSubmit();
		  }
	});	
	
	$('#btnNewSearchSocial').click(function(){
		$('#formSocial').removeClass('d-none');
		$('#resultSocial').addClass('d-none');
	});
	
});