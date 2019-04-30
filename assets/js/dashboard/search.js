function resetsearchform(){
	$('#form_error_website').addClass('d-none');
	$('#form_error_name').addClass('d-none');
	$('#form_error_email').addClass('d-none');
	$('#form_error_social').addClass('d-none');
	$('#info-notif-website').addClass('d-none');
	$('#info-notif-name').addClass('d-none');
	$('#info-notif-email').addClass('d-none');
	$('#info-notif-social').addClass('d-none');
	$('#people_domains_content').html('');
	$("#table-website tbody").html('');
	$("#table-name tbody").html('');
	$("#table-email tbody").html('');
	$("#table-social tbody").html('');
}

function showsearcherror(field,message){
	$('#form_error_'+field).removeClass('d-none');
	$('#form_error_'+field).html(message);
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



function refreshCampaignSelect(){
	$.post('/dashboard/refreshcampaigns',
		    {
			}
		    ,function(data){
		    	$('#website_campaign').html(data.html);
		    	$('#name_campaign').html(data.html);
		    	$('#email_campaign').html(data.html);
		    
		});
}


function saveRelatedDomains(cnt){
	var reldomains = [];
	jQuery('#table-reldomain tbody tr').each(function() {
		jQuery(this).find('input:checkbox:checked').each(function() {
			reldomains.push(jQuery(this).val());
		});
	});

	if (reldomains.length == 0){
		$('#rdomainTableError').removeClass('d-none');
		$('#rdomainTableError .alert-danger').html('Please select domains');
	}else {
		var domains = reldomains.join(',');
		jQuery('#row_domains_'+cnt).append(domains);
		$('#dashboardModal .modal-dialog .modal-content').html(''); 
		$('#dashboardModal').modal('hide');
	}
	
}

function showrdomains(cnt,by,owner_name){
	var domains = jQuery('#related_domains'+cnt).val();
	
	$.post("/dashboard/getrdomains",
	{
		cnt:cnt,
		domains:domains,
		owner_name:owner_name
	}
	,function(data){
		 if (data.status){
			 $('#dashboardModal .modal-dialog .modal-content').html(data.html); 
			 $('#dashboardModal').modal('show');
         }

	  }
	);	
}


$(document).ready(function(){
	
	
	$( document ).on( "click", "#btnAddReldomains", function() {
		var cnt = $('#modal_reldom_count').val();
		saveRelatedDomains(cnt);
	});
	
	$( document ).on( "click", "#checkallreldomain", function() {
		$('#table-reldomain tbody input:checkbox').not(this).prop('checked', this.checked);
	});
	
	
});