function searchWebsiteSubmit(){
	resetsearchform();
	
	var subs = $('#searchWebsite').val();
	
	if (subs == ''){
		showsearcherror('website','Please enter domain(s)');
	}else {
		$('#btnSearchWebsite').attr("disabled", true);
		$('#btnSearchWebsite').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Tracking...');
		$('#resultWebsite').removeClass('d-none');
		$('#formWebsite').addClass('d-none');
		
		 var split = $('#searchWebsite').val().split('\n');
    	 var cnt = '';
    	 var ncnt = 0;
    	 var html = '';
		
    	 
      	  var interval = setInterval(function(){
   		  if(split.length>0){
   			  if (split[0] != ""){
   						    cnt = cnt+1;
   							html = '<tr>';
                               html += '<td id="tdwresbox_'+cnt+'"><input type="checkbox" id="resboxw" name="resboxw" value="'+cnt+'"></td>';
                               html += '<td id="tdwresdomain_'+cnt+'">'+split[0]+'</td>';
                               html += '<td id="tdwresval_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdwresowner_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdwresemail_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdwresphone_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdwresexpire_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdwresregistrar_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '</tr>';
                            $("#table-website tbody").append(html);
   							$.post("/dashboard/ajaxsearchwebsite",{
   					        	 domain:split[0],
   					        	 cnt:cnt
   					            },
   								function(data){
   					            	if (data.status){
   					            		jQuery("#tdwresval_"+data.cnt).html(data.value);
   					            		jQuery("#tdwresowner_"+data.cnt).html(data.owner);
   					            		jQuery("#tdwresemail_"+data.cnt).html(data.email);
   					            		jQuery("#tdwresphone_"+data.cnt).html(data.phone);
   					            		jQuery("#tdwresexpire_"+data.cnt).html(data.expire);
   					            		jQuery("#tdwresregistrar_"+data.cnt).html(data.registrar);
   					            	}else {
   										jQuery("#tdwresval_"+data.cnt).html(data.message);
   										jQuery("#tdwresval_"+data.cnt).css('color','red');
   										jQuery("#tdwresowner_"+data.cnt).html('');
   					            		jQuery("#tdwresemail_"+data.cnt).html('');
   					            		jQuery("#tdwresphone_"+data.cnt).html('');
   					            		jQuery("#tdwresexpire_"+data.cnt).html('');
   					            		jQuery("#tdwresregistrar_"+data.cnt).html('');
   					            		jQuery("#tdwresbox_"+data.cnt).html('');
   									}
   					            	
   								}   
   						 );
   				 
   			  }
   				split.shift();
   			}else{
   				clearTimeout(interval);
   			    $('#searchWebsite').val('');
	   			$('#btnSearchWebsite').attr("disabled", false);
	   			$('#btnSearchWebsite').html('Submit');
	   			$('#websiteSelect').removeClass('d-none');
   			}
   			
   		},1000);
		
		
	}
}


function showWebsiteCampaign(){
	var i = 0;
	$('#websiteTableError').addClass('d-none');
	$('#websiteTableSuccess').addClass('d-none');
	jQuery('#table-website tbody tr').each(function() {
	    jQuery(this).find('input:checkbox:checked').each(function() {
	      	    i = i+1;
	    });
	});
	if (i == 0){
		$('#websiteTableError').removeClass('d-none');
		$('#websiteTableError .alert-danger').html('Please select domains to save.');
		$('#selectWebsite').val('');
	}else {
		$('#modalWCampaigns').modal('show');
	}
}

function saveWebsitesChecked(){
	var campaign_name = $('#w_campaign_name').val();
	var campaign_id = $('#website_campaign').val();
	var option = $('#w_option_campaign').val();
	$('#websiteModalError').addClass('d-none');
	var error = 0;
	var i = 0;
	var entries = [];
	
	if (option == 'select'){
		if (campaign_id == ''){
			$('#websiteModalError').removeClass('d-none');
			$('#websiteModalError .alert-danger').html('Please select campaign');
			$error = $error+1;
		}
	}else if (option == 'create'){
		if (campaign_name == ''){
			$('#websiteModalError').removeClass('d-none');
			$('#websiteModalError .alert-danger').html('Please enter campaign name');
			$error = $error+1;
		}
	}
	
	jQuery('#table-website tbody tr').each(function() {
		jQuery(this).find('input:checkbox:checked').each(function() {
	      	    i = i+1;
	     	    cnt = jQuery(this).val();
	    
	     	     entries.push({
				    domain : jQuery("#tdwresdomain_"+cnt).html(), 
				    value : jQuery("#tdwresval_"+cnt).html(),
				    owner : jQuery("#tdwresowner_"+cnt).html(),
				    email : jQuery("#tdwresemail_"+cnt).html(),
				    phone : jQuery("#tdwresphone_"+cnt).html(),
				    expire : jQuery("#tdwresexpire_"+cnt).html(),
				    registrar : jQuery("#tdwresregistrar_"+cnt).html(),
				     
				});
	     	
	    });
	});
	
	if (error == 0){
		$('#btnSaveWebsite').attr("disabled", true);
		$('#btnSaveWebsite').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
		$.post("/dashboard/savewebsitesearch",
    			{ 
			     entries:entries,
			     campaign_id:campaign_id,
			     campaign_name:campaign_name,
			     option:option
    			},
    			function(data){
    				if (data.status){
    					$('#btnSaveWebsite').attr("disabled", false);
    					$('#btnSaveWebsite').html('Submit');
    					$('#modalWCampaigns').modal('hide');
    					$('#websiteTableSuccess').removeClass('d-none');
    					$('#websiteTableSuccess .alert-success').html('You successfully saved '+data.count+' out of '+data.number+' domains');
    					$('#selectWebsite').val('');
    					refreshCampaignSelect();
    				}else {
    					$('#websiteModalError').removeClass('d-none');
    					$('#websiteModalError .alert-danger').html(data.message);
    					$('#btnSaveWebsite').attr("disabled", false);
    					$('#btnSaveWebsite').html('Submit');
    					refreshCampaignSelect();
    				}
    			}   
    	 );
		
	}
}


$(document).ready(function(){
	$('#btnSearchWebsite').click(function(){
		searchWebsiteSubmit();
	});
	  

	$('#btnNewSearchWebsite').click(function(){
		$('#formWebsite').removeClass('d-none');
		$('#resultWebsite').addClass('d-none');
		$('#websiteSelect').addClass('d-none');
		$("#table-website tbody").html('');
		$('#websiteTableSuccess').addClass('d-none');
		$('#websiteTableError').addClass('d-none');
		$('#people_domains_content').html('');
		$("#table-website tbody").html('');
		$("#table-name tbody").html('');
		$("#table-email tbody").html('');
		$("#table-social tbody").html('');
	});
	
	$('#selectWebsite').change(function(){
		var val = $(this).val();
		if (val == 'save_domains'){
			showWebsiteCampaign();
		}
	});
	
	$('#btnaddcampaignw').click(function(){
		$('#fieldw_campaign').hide();
		$('#fieldw_addcampaign').show();
		$('#website_campaign').val('');
		$('#w_option_campaign').val('create');
	});
	
	$('#btncanceladdw').click(function(){
		$('#fieldw_campaign').show();
		$('#fieldw_addcampaign').hide();
		$('#w_campaign_name').val('');
		$('#w_option_campaign').val('select');
	});
	
	$('#btnSaveWebsite').click(function(){
		saveWebsitesChecked();
	});
	
	$("#checkallw").click(function(){
	    $('#table-website tbody input:checkbox').not(this).prop('checked', this.checked);
	});
	
});