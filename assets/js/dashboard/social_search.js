function saveSocialsChecked(){
	var campaign_name = $('#s_campaign_name').val();
	var campaign_id = $('#social_campaign').val();
	var option = $('#s_option_campaign').val();
	$('#socialModalError').addClass('d-none');
	var error = 0;
	var i = 0;
	var entries = [];
	
	if (option == 'select'){
		if (campaign_id == ''){
			$('#socialModalError').removeClass('d-none');
			$('#socialModalError .alert-danger').html('Please select campaign');
			$error = $error+1;
		}
	}else if (option == 'create'){
		if (campaign_name == ''){
			$('#socialModalError').removeClass('d-none');
			$('#socialModalError .alert-danger').html('Please enter campaign name');
			$error = $error+1;
		}
	}
	
	jQuery('#table-social tbody tr').each(function() {
		jQuery(this).find('input:checkbox:checked').each(function() {
	      	    i = i+1;
	     	    cnt = jQuery(this).val();
	    
	     	   entries.push({
					name : jQuery("#tdsresname_"+cnt).html(), 
					email : jQuery("#tdsresemail_"+cnt).html(),
					address : jQuery("#tdsresaddress_"+cnt).html(),
					phone : jQuery("#tderssphone_"+cnt).html(),
					company : jQuery("#tdsrescompany_"+cnt).html(),
					notes : jQuery("#tderssnotes_"+cnt).html(),
					socials : jQuery("#tdsressocials_"+cnt).html(),
					twitter : jQuery("#tdsressocials_"+cnt).attr('data'),
					domains : jQuery("#row_domains_"+cnt).html()
				});
	     	
	    });
	});
	
	if (error == 0){
		$('#btnSaveSocial').attr("disabled", true);
		$('#btnSaveSocial').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
		$.post("/dashboard/savepeople",
    			{ 
			     entries:entries,
			     campaign_id:campaign_id,
			     campaign_name:campaign_name,
			     option:option,
			     by:'social'
    			},
    			function(data){
    				if (data.status){
    					$('#btnSaveSocial').attr("disabled", false);
    					$('#btnSaveSocial').html('Submit');
    					$('#modalSCampaigns').modal('hide');
    					$('#socialTableSuccess').removeClass('d-none');
    					$('#socialTableSuccess .alert-success').html('You successfully saved '+data.count+' out of '+data.number+' domains');
    					$('#selectSocial').val('');
    					refreshCampaignSelect();
    				}else {
    					$('#socialModalError').removeClass('d-none');
    					$('#socialModalError .alert-danger').html(data.message);
    					$('#btnSaveSocial').attr("disabled", false);
    					$('#btnSaveSocial').html('Submit');
    					refreshCampaignSelect();
    				}
    			}   
    	 );
		
	}
}

function alphanumeric(inputtxt) { 
	  var letters = /^[a-z0-9\\-]+$/i;
	  if (letters.test(inputtxt)) {
	    return true;
	  } else {
	    return false;
	  }
}

function searchSocialSubmit(){
	resetsearchform();
	var subs = $('#searchSocial').val();
	if (subs == ''){
		showsearcherror('social','Please enter twitter username(s)');
	}else {
		$('#btnSearchSocial').attr("disabled", true);
		$('#btnSearchSocial').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Tracking...');
		$('#resultSocial').removeClass('d-none');
		$('#formSocial').addClass('d-none');
		 var split = $('#searchSocial').val().split('\n');
    	 var cnt = 0;
    	 var ncnt = 0;
    	 var html = '';
    	 var has_error = 0;
    	 var error_msg = "";
    	 
    	 $('#people_domains_content').html('');
    	 $("#table-social tbody").html('');
    	 
    	 
      	  var interval = setInterval(function(){
   		  if(split.length>0){
   			  if (split[0] != ""){
   				               has_error = 0;  
   						       cnt = cnt+1;
   						       
   						    split[0] = split[0].replace("https://twitter.com/", "");
   						       
   						    if (!alphanumeric(split[0].replace(" ", ""))) {
						    	error_msg = split[0]+' invalid twitter username/profile';
						    	has_error=1;
						    }
   						    
   						    
   						       if (has_error == 0){
				   							   html = '<tr>';
				                               html += '<td id="tdsresbox_'+cnt+'"><input type="checkbox" id="resboxs" name="resboxs" value="'+cnt+'"></td>';
				                               html += '<td id="tdsressocials_'+cnt+'" data="https://twitter.com/'+split[0]+'">Twitter=https://twitter.com/'+split[0]+'</td>';
				                               html += '<td id="tdsresname_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
				                               html += '<td id="tdsresemail_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
				                               html += '<td id="tdsresaddress_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
				                               html += '<td id="tdsresphone_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
				                               html += '<td id="tdsrescompany_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
				                               html += '<td id="tdsresnotes_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
				                               html += '<td id="tdsresselect_'+cnt+'">&nbsp;</td>';
				                               html += '</tr>';
			   						       
			                               
			                               $("#table-social tbody").append(html);
			   							
			                               $.post("/dashboard/ajaxsearchpeople",{
			   					        	 val:split[0],
			   					        	 cnt:cnt,
			   					        	 by:'twitter'
			   					            },
			   								function(data){
			   					            	if (data.status){
			   					            		jQuery("#tdsresname_"+data.cnt).html(data.name);
			   					            		jQuery("#tdsresemail_"+data.cnt).html(data.email);
			   					            		jQuery("#tdsresaddress_"+data.cnt).html(data.address);
			   					            		jQuery("#tdsresphone_"+data.cnt).html(data.phone);
			   					            		jQuery("#tdsrescompany_"+data.cnt).html(data.company);
			   					            		jQuery("#tdsresnotes_"+data.cnt).html(data.notes);
			   					            		jQuery("#tdsressocials_"+data.cnt).html(data.socials);
			   					            		
			   					            		var html = '<textarea id="related_domains'+data.cnt+'">'+data.related_domains+'</textarea>';
			                            			jQuery('#people_domains_content').append(html);
			                            			if (data.domains!=0){
			                            				if (data.domains != ""){  
			                            					var n = 'social';
			                            					jQuery("#tdsresselect_"+data.cnt).html('<a href="javascript:showrdomains('+data.cnt+',\'name\',\''+data.name+'\')" class="btn btn-warning btn-sm">select domains</a><br><span id="row_domains_'+data.cnt+'"></span>');
			                            				}else {
			                            					jQuery("#tdsresselect_"+data.cnt).html('<span id="row_domains_'+data.cnt+'"></span>');
			                            				}
			                            			}else {
			                            				jQuery("#tdsresselect_"+data.cnt).html('<span id="row_domains_'+data.cnt+'"></span>');
			                            			}
			   					            		
			   					            	}else {
			   					            		jQuery("#tdsressocials_"+data.cnt).html(data.socials);
			   					            	    jQuery("#tdsresname_"+data.cnt).html(data.msg);
			   					            	    jQuery("#tdsresname_"+data.cnt).css('color','red');
			   					            	    jQuery("#tdsresemail_"+data.cnt).html('');
			   					            	    jQuery("#tdsresaddress_"+data.cnt).html('');
			   					            		jQuery("#tdsresphone_"+data.cnt).html('');
			   					            		jQuery("#tdsrescompany_"+data.cnt).html('');
			   					            		jQuery("#tdsresnotes_"+data.cnt).html('');
			   					            		jQuery("#tdsresselect_"+data.cnt).html('');
			   					            		jQuery("#tdsresbox_"+data.cnt).html('');
			   									}
			   					            	
			   								}   
			   						 );
   						       }else {
	   						    	html = '<tr>';
		   						 	html += '<td>&nbsp;</td>';
		   						 	html += '<td id="tdsressocials_'+cnt+'">'+split[0]+'</td>';
		   						 	html += '<td id="tdsresname_'+cnt+'" colspan="7" style="color:red">'+error_msg+'</td>';
	   						 	    html += '</tr>';
	   						 	    $("#table-social tbody").append(html);
   						       }
   				 
   			  }
   				split.shift();
   			}else{
   				clearTimeout(interval);
   			    $('#searchSocial').val('');
	   			$('#btnSearchSocial').attr("disabled", false);
	   			$('#btnSearchSocial').html('Submit');
	   			$('#socialSelect').removeClass('d-none');
   			}
   			
   		},1000);
		
		
	}
}

function showSocialCampaign(){
	var i = 0;
	$('#socialTableError').addClass('d-none');
	$('#socialTableSuccess').addClass('d-none');
	jQuery('#table-social tbody tr').each(function() {
	    jQuery(this).find('input:checkbox:checked').each(function() {
	      	    i = i+1;
	    });
	});
	if (i == 0){
		$('#socialTableError').removeClass('d-none');
		$('#socialTableError .alert-danger').html('Please select leads to save.');
		$('#selectSocial').val('');
	}else {
		$('#modalSCampaigns').modal('show');
	}
}


$(document).ready(function(){
	$('#btnSearchSocial').click(function(){
		searchSocialSubmit();
	});
	
	$('#selectSocial').change(function(){
		var val = $(this).val();
		$('#btnSaveSocial').attr("disabled", false);
		$('#btnSaveSociall').html('Submit');
		if (val == 'save_leads'){
			showSocialCampaign();
		}
	});
	
	$('#btnSaveSocial').click(function(){
		saveSocialsChecked();
	});
	
	$('#btnNewSearchSocial').click(function(){
		$('#formSocial').removeClass('d-none');
		$('#resultSocial').addClass('d-none');
		$('#socialSelect').addClass('d-none');
		$("#table-social tbody").html('');
		$('#socialTableSuccess').addClass('d-none');
		$('#socialTableError').addClass('d-none');
		$('#people_domains_content').html('');
		$("#table-website tbody").html('');
		$("#table-name tbody").html('');
		$("#table-email tbody").html('');
		$("#table-social tbody").html('');
	});
	
	$('#btnaddcampaigns').click(function(){
		$('#fields_campaign').hide();
		$('#fields_addcampaign').show();
		$('#social_campaign').val('');
		$('#s_option_campaign').val('create');
	});
	
	$('#btncanceladds').click(function(){
		$('#fields_campaign').show();
		$('#fields_addcampaign').hide();
		$('#s_campaign_name').val('');
		$('#s_option_campaign').val('select');
	});
	
	
	$("#checkalls").click(function(){
	    $('#table-social tbody input:checkbox').not(this).prop('checked', this.checked);
	});
});