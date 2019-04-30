function saveNamesChecked(){
	var campaign_name = $('#n_campaign_name').val();
	var campaign_id = $('#name_campaign').val();
	var option = $('#n_option_campaign').val();
	$('#nameModalError').addClass('d-none');
	var error = 0;
	var i = 0;
	var entries = [];
	
	if (option == 'select'){
		if (campaign_id == ''){
			$('#nameModalError').removeClass('d-none');
			$('#nameModalError .alert-danger').html('Please select campaign');
			$error = $error+1;
		}
	}else if (option == 'create'){
		if (campaign_name == ''){
			$('#nameModalError').removeClass('d-none');
			$('#nameModalError .alert-danger').html('Please enter campaign name');
			$error = $error+1;
		}
	}
	
	jQuery('#table-name tbody tr').each(function() {
		jQuery(this).find('input:checkbox:checked').each(function() {
	      	    i = i+1;
	     	    cnt = jQuery(this).val();
	    
	     	   entries.push({
					name : jQuery("#tdnresname_"+cnt).html(), 
					email : jQuery("#tdnresemail_"+cnt).html(),
					address : jQuery("#tdnresaddress_"+cnt).html(),
					phone : jQuery("#tdnresphone_"+cnt).html(),
					company : jQuery("#tdnrescompany_"+cnt).html(),
					notes : jQuery("#tdnresnotes_"+cnt).html(),
					socials : jQuery("#tdnressocials_"+cnt).html(),
					domains : jQuery("#row_domains_"+cnt).html()
				});
	     	
	    });
	});
	
	if (error == 0){
		$('#btnSaveName').attr("disabled", true);
		$('#btnSaveName').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
		$.post("/dashboard/savepeople",
    			{ 
			     entries:entries,
			     campaign_id:campaign_id,
			     campaign_name:campaign_name,
			     option:option,
			     by:'name'
    			},
    			function(data){
    				if (data.status){
    					$('#btnSaveName').attr("disabled", false);
    					$('#btnSaveName').html('Submit');
    					$('#modalNCampaigns').modal('hide');
    					$('#nameTableSuccess').removeClass('d-none');
    					$('#nameTableSuccess .alert-success').html('You successfully saved '+data.count+' out of '+data.number+' domains');
    					$('#selectName').val('');
    					refreshCampaignSelect();
    				}else {
    					$('#nameModalError').removeClass('d-none');
    					$('#nameModalError .alert-danger').html(data.message);
    					$('#btnSaveName').attr("disabled", false);
    					$('#btnSaveName').html('Submit');
    					refreshCampaignSelect();
    				}
    			}   
    	 );
		
	}
}

function searchNameSubmit(){
	resetsearchform();
	var subs = $('#searchName').val();
	if (subs == ''){
		showsearcherror('name','Please enter name(s)');
	}else {
		$('#btnSearchName').attr("disabled", true);
		$('#btnSearchName').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Tracking...');
		$('#resultName').removeClass('d-none');
		$('#formName').addClass('d-none');
		
		 var split = $('#searchName').val().split('\n');
    	 var cnt = '';
    	 var ncnt = 0;
    	 var html = '';
		
    	 $('#people_domains_content').html('');
    	 $("#table-name tbody").html('');
    	 
      	  var interval = setInterval(function(){
   		  if(split.length>0){
   			  if (split[0] != ""){
   						    cnt = cnt+1;
   							html = '<tr>';
                               html += '<td  id="tdnresbox_'+cnt+'"><input type="checkbox" id="resboxn" name="resboxn" value="'+cnt+'"></td>';
                               html += '<td id="tdnresname_'+cnt+'">'+split[0]+'</td>';
                               html += '<td id="tdnresemail_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdnresaddress_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdnresphone_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdnrescompany_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdnresnotes_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdnressocials_'+cnt+'"><i class="fa fa-spinner fa-spin fa-fw"></i></td>';
                               html += '<td id="tdnresselect_'+cnt+'">&nbsp;</td>';
                               html += '</tr>';
                            $("#table-name tbody").append(html);
   							$.post("/dashboard/ajaxsearchpeople",{
   					        	 val:split[0],
   					        	 cnt:cnt,
   					        	 by:'name'
   					            },
   								function(data){
   					            	if (data.status){
   					            		jQuery("#tdnresemail_"+data.cnt).html(data.email);
   					            		jQuery("#tdnresaddress_"+data.cnt).html(data.address);
   					            		jQuery("#tdnresphone_"+data.cnt).html(data.phone);
   					            		jQuery("#tdnrescompany_"+data.cnt).html(data.company);
   					            		jQuery("#tdnresnotes_"+data.cnt).html(data.notes);
   					            		jQuery("#tdnressocials_"+data.cnt).html(data.socials);
   					            		
   					            		var html = '<textarea id="related_domains'+data.cnt+'">'+data.related_domains+'</textarea>';
                            			jQuery('#people_domains_content').append(html);
                            			if (data.domains!=0){
                            				if (data.domains != ""){  
                            					var n = 'name';
                            					jQuery("#tdnresselect_"+data.cnt).html('<a href="javascript:showrdomains('+data.cnt+',\'name\',\''+data.name+'\')" class="btn btn-warning btn-sm">select domains</a><br><span id="row_domains_'+data.cnt+'"></span>');
                            				}else {
                            					jQuery("#tdnresselect_"+data.cnt).html('<span id="row_domains_'+data.cnt+'"></span>');
                            				}
                            			}else {
                            				jQuery("#tdnresselect_"+data.cnt).html('<span id="row_domains_'+data.cnt+'"></span>');
                            			}
   					            		
   					            	}else {
   										jQuery("#tdnresname_"+data.cnt).html(data.msg);
   										jQuery("#tdnresname_"+data.cnt).css('color','red');
   										jQuery("#tdnresemail_"+data.cnt).html('');
   					            		jQuery("#tdnresaddress_"+data.cnt).html('');
   					            		jQuery("#tdnresphone_"+data.cnt).html('');
   					            		jQuery("#tdnrescompany_"+data.cnt).html('');
   					            		jQuery("#tdnresnotes_"+data.cnt).html('');
   					            		jQuery("#tdnressocials_"+data.cnt).html('');
   					            		jQuery("#tdnresselect_"+data.cnt).html('');
   					            		jQuery("#tdnresbox_"+data.cnt).html('');
   									}
   					            	
   								}   
   						 );
   				 
   			  }
   				split.shift();
   			}else{
   				clearTimeout(interval);
   			    $('#searchName').val('');
	   			$('#btnSearchName').attr("disabled", false);
	   			$('#btnSearchName').html('Submit');
	   			$('#nameSelect').removeClass('d-none');
   			}
   			
   		},1000);
		
		
	}
}


function showNameCampaign(){
	var i = 0;
	$('#nameTableError').addClass('d-none');
	$('#nameTableSuccess').addClass('d-none');
	jQuery('#table-name tbody tr').each(function() {
	    jQuery(this).find('input:checkbox:checked').each(function() {
	      	    i = i+1;
	    });
	});
	if (i == 0){
		$('#nameTableError').removeClass('d-none');
		$('#nameTableError .alert-danger').html('Please select leads to save.');
		$('#selectName').val('');
	}else {
		$('#modalNCampaigns').modal('show');
	}
}


$(document).ready(function(){
	$('#btnSearchName').click(function(){
		searchNameSubmit();
	});
	
	
	
	$('#btnNewSearchName').click(function(){
		$('#formName').removeClass('d-none');
		$('#resultName').addClass('d-none');
		$('#nameSelect').addClass('d-none');
		$("#table-name tbody").html('');
		$('#nameTableSuccess').addClass('d-none');
		$('#nameTableError').addClass('d-none');
		$('#people_domains_content').html('');
		$("#table-website tbody").html('');
		$("#table-name tbody").html('');
		$("#table-email tbody").html('');
		$("#table-social tbody").html('');
	});
	
	$('#selectName').change(function(){
		var val = $(this).val();
		$('#btnSaveName').attr("disabled", false);
		$('#btnSaveName').html('Submit');
		if (val == 'save_leads'){
			showNameCampaign();
		}
	});
	
	$('#btnaddcampaignn').click(function(){
		$('#fieldn_campaign').hide();
		$('#fieldn_addcampaign').show();
		$('#name_campaign').val('');
		$('#n_option_campaign').val('create');
	});
	
	$('#btncanceladdn').click(function(){
		$('#fieldn_campaign').show();
		$('#fieldn_addcampaign').hide();
		$('#m_campaign_name').val('');
		$('#n_option_campaign').val('select');
	});
	
	$('#btnSaveName').click(function(){
		saveNamesChecked();
	});
	
	
	$("#checkalln").click(function(){
	    $('#table-name tbody input:checkbox').not(this).prop('checked', this.checked);
	});
	
	
});