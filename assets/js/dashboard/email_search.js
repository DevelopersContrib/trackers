function saveEmailsChecked(){
	var campaign_name = $('#e_campaign_name').val();
	var campaign_id = $('#email_campaign').val();
	var option = $('#e_option_campaign').val();
	$('#emailModalError').addClass('d-none');
	var error = 0;
	var i = 0;
	var entries = [];
	
	if (option == 'select'){
		if (campaign_id == ''){
			$('#emailModalError').removeClass('d-none');
			$('#emailModalError .alert-danger').html('Please select campaign');
			$error = $error+1;
		}
	}else if (option == 'create'){
		if (campaign_name == ''){
			$('#emailModalError').removeClass('d-none');
			$('#emailModalError .alert-danger').html('Please enter campaign name');
			$error = $error+1;
		}
	}
	
	jQuery('#table-email tbody tr').each(function() {
		jQuery(this).find('input:checkbox:checked').each(function() {
	      	    i = i+1;
	     	    cnt = jQuery(this).val();
	    
	     	   entries.push({
					name : jQuery("#tderesname_"+cnt).html(), 
					email : jQuery("#tderesemail_"+cnt).html(),
					address : jQuery("#tderesaddress_"+cnt).html(),
					phone : jQuery("#tderesphone_"+cnt).html(),
					company : jQuery("#tderescompany_"+cnt).html(),
					notes : jQuery("#tderesnotes_"+cnt).html(),
					socials : jQuery("#tderessocials_"+cnt).html(),
					domains : jQuery("#row_domains_"+cnt).html()
				});
	     	
	    });
	});
	
	if (error == 0){
		$('#btnSaveEmail').attr("disabled", true);
		$('#btnSaveEmail').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
		$.post("/dashboard/savepeople",
    			{ 
			     entries:entries,
			     campaign_id:campaign_id,
			     campaign_name:campaign_name,
			     option:option,
			     by:'email'
    			},
    			function(data){
    				if (data.status){
    					$('#btnSaveEmail').attr("disabled", false);
    					$('#btnSaveEmail').html('Submit');
    					$('#modalECampaigns').modal('hide');
    					$('#emailTableSuccess').removeClass('d-none');
    					$('#emailTableSuccess .alert-success').html('You successfully saved '+data.count+' out of '+data.number+' domains');
    					$('#selectEmail').val('');
    					refreshCampaignSelect();
    				}else {
    					$('#emailModalError').removeClass('d-none');
    					$('#emailModalError .alert-danger').html(data.message);
    					$('#btnSaveEmail').attr("disabled", false);
    					$('#btnSaveEmail').html('Submit');
    					refreshCampaignSelect();
    				}
    			}   
    	 );
		
	}
}

function searchEmailSubmit(){
	resetsearchform();
	var subs = $('#searchEmail').val();
	if (subs == ''){
		showsearcherror('email','Please enter email(s)');
	}else {
		$('#btnSearchEmail').attr("disabled", true);
		$('#btnSearchEmail').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Tracking...');
		$('#resultEmail').removeClass('d-none');
		$('#formEmail').addClass('d-none');
		
		 var split = $('#searchEmail').val().split('\n');
    	 var cnt = 0;
    	 var ncnt = 0;
    	 var html = '';
    	 $('#people_domains_content').html('');
    	 $("#table-email tbody").html('');
    	 
    	 
      	  var interval = setInterval(function(){
   		  if(split.length>0){
   			  if (split[0] != ""){
   				  
   						       cnt = cnt+1;
   							   html = '<tr>';
                               html += '<td id="tderesbox_'+cnt+'"><input type="checkbox" id="resboxe" name="resboxe" value="'+cnt+'"></td>';
                               html += '<td id="tderesemail_'+cnt+'">'+split[0]+'</td>';
                               html += '<td id="tderesname_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tderesaddress_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tderesphone_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tderescompany_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tderesnotes_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tderessocials_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tderesselect_'+cnt+'">&nbsp;</td>';
                               html += '</tr>';
                            $("#table-email tbody").append(html);
   							$.post("/dashboard/ajaxsearchpeople",{
   					        	 val:split[0],
   					        	 cnt:cnt,
   					        	 by:'email'
   					            },
   								function(data){
   					            	if (data.status){
   					            		jQuery("#tderesname_"+data.cnt).html(data.name);
   					            		jQuery("#tderesaddress_"+data.cnt).html(data.address);
   					            		jQuery("#tderesphone_"+data.cnt).html(data.phone);
   					            		jQuery("#tderescompany_"+data.cnt).html(data.company);
   					            		jQuery("#tderesnotes_"+data.cnt).html(data.notes);
   					            		jQuery("#tderessocials_"+data.cnt).html(data.socials);
   					            		
   					            		var html = '<textarea id="related_domains'+data.cnt+'">'+data.related_domains+'</textarea>';
                            			jQuery('#people_domains_content').append(html);
                            			if (data.domains!=0){
                            				if (data.domains != ""){  
                            					var n = 'email';
                            					jQuery("#tderesselect_"+data.cnt).html('<a href="javascript:showrdomains('+data.cnt+',\'name\',\''+data.name+'\')" class="btn btn-warning btn-sm">select domains</a><br><span id="row_domains_'+data.cnt+'"></span>');
                            				}else {
                            					jQuery("#tderesselect_"+data.cnt).html('<span id="row_domains_'+data.cnt+'"></span>');
                            				}
                            			}else {
                            				jQuery("#tderesselect_"+data.cnt).html('<span id="row_domains_'+data.cnt+'"></span>');
                            			}
   					            		
   					            	}else {
   					            		
   					            	    jQuery("#tderesemail_"+data.cnt).html(data.email);
   					            	    jQuery("#tderesname_"+data.cnt).html(data.msg);
										jQuery("#tderesname_"+data.cnt).css('color','red');
   										jQuery("#tderesaddress_"+data.cnt).html('');
   					            		jQuery("#tderesphone_"+data.cnt).html('');
   					            		jQuery("#tderescompany_"+data.cnt).html('');
   					            		jQuery("#tderesnotes_"+data.cnt).html('');
   					            		jQuery("#tderessocials_"+data.cnt).html('');
   					            		jQuery("#tderesselect_"+data.cnt).html('');
   					            		jQuery("#tderesbox_"+data.cnt).html('');
   									}
   					            	
   								}   
   						 );
   				 
   			  }
   				split.shift();
   			}else{
   				clearTimeout(interval);
   			    $('#searchEmail').val('');
	   			$('#btnSearchEmail').attr("disabled", false);
	   			$('#btnSearchEmail').html('Submit');
	   			$('#emailSelect').removeClass('d-none');
   			}
   			
   		},1000);
		
		
	}
}


function showEmailCampaign(){
	var i = 0;
	$('#emailTableError').addClass('d-none');
	$('#emailTableSuccess').addClass('d-none');
	jQuery('#table-email tbody tr').each(function() {
	    jQuery(this).find('input:checkbox:checked').each(function() {
	      	    i = i+1;
	    });
	});
	if (i == 0){
		$('#emailTableError').removeClass('d-none');
		$('#emailTableError .alert-danger').html('Please select leads to save.');
		$('#selectEmail').val('');
	}else {
		$('#modalECampaigns').modal('show');
	}
}


$(document).ready(function(){
	$('#btnSearchEmail').click(function(){
		searchEmailSubmit();
	});
	
	
	
	$('#btnNewSearchEmail').click(function(){
		$('#formEmail').removeClass('d-none');
		$('#resultEmail').addClass('d-none');
		$('#emailSelect').addClass('d-none');
		$("#table-email tbody").html('');
		$('#emailTableSuccess').addClass('d-none');
		$('#emailTableError').addClass('d-none');
		$('#people_domains_content').html('');
		$("#table-website tbody").html('');
		$("#table-name tbody").html('');
		$("#table-email tbody").html('');
		$("#table-social tbody").html('');
	});
	
	$('#selectEmail').change(function(){
		var val = $(this).val();
		$('#btnSaveEmail').attr("disabled", false);
		$('#btnSaveEmail').html('Submit');
		if (val == 'save_leads'){
			showEmailCampaign();
		}
	});
	
	$('#btnaddcampaigne').click(function(){
		$('#fielde_campaign').hide();
		$('#fielde_addcampaign').show();
		$('#email_campaign').val('');
		$('#e_option_campaign').val('create');
	});
	
	$('#btncanceladde').click(function(){
		$('#fielde_campaign').show();
		$('#fielde_addcampaign').hide();
		$('#e_campaign_name').val('');
		$('#e_option_campaign').val('select');
	});
	
	$('#btnSaveEmail').click(function(){
		saveEmailsChecked();
	});
	
	
	$("#checkalle").click(function(){
	    $('#table-email tbody input:checkbox').not(this).prop('checked', this.checked);
	});
	
	
});