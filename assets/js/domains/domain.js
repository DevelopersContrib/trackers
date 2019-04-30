var domaintbl = $('#tbldomain').dataTable({
	    "processing": true,
	    "serverSide": true,
	    "ajax": {
	        "url": "/domains/domainlist",
	        "data": function ( d ) {
	          return $.extend( {}, d, {
	            "campaign_id": $('#tbldomain_campaign').val()
	          } );
	        }
	      },
	    "order": [[0, 'DESC']],
	    "columns": [
	        {
	            "orderable": false,
	            "searchable": false,
	            "render": (data, type, row) => {
	                return '<input type="checkbox" id="dombox" value="'+row[0]+'"/>';
	            }
	        },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true }
	    ]
	});

$(document).ready(function(){
	$('#tbldomain_campaign').change(function(){
		domaintbl.fnDraw();
	});
	
	$("#checkalldomain").click(function(){
	    $('#tbldomain tbody input:checkbox').not(this).prop('checked', this.checked);
	});
	
	$( document ).on( "change", "#selDomainAction", function() {
		var action = $(this).val();
		$('#domainMainTableError').addClass('d-none');
		$('#domainMainTableSuccess').addClass('d-none');
		var entries = [];
		jQuery('#tbldomain tbody tr').each(function() {
		    jQuery(this).find('input:checkbox:checked').each(function() {
		      	    entries.push($(this).val());
		      	    
		    });
		});
		
		if (action != ''){
			if (entries.length == 0){
				$('#domainMainTableError').removeClass('d-none');
				$('#domainMainTableError .alert-danger').html('Please select domains first.');
				$('#selDomainAction').val("");
			}else {
				switch (action){
					case 'move_to_campaign':
						$.post("/domains/movecampaignform",
								{
								  entries:entries
								}
								 ,function(data){
									 if (data.status){
										 $('#domainModal .modal-dialog .modal-content').html(data.html); 
										 $('#domainModal').modal('show');
					                 }
								 }
						);
					break;
					case 'delete':
						$.post("/domains/deletedomainconfirm",
								{
								  entries:entries
								}
								 ,function(data){
									 if (data.status){
										 $('#domainModal .modal-dialog .modal-content').html(data.html); 
										 $('#domainModal').modal('show');
					                 }
								 }
						);

					break;
					case 'send_email':
						$.post("/domains/sendemailform",
								{
								  entries:entries
								}
								 ,function(data){
									 if (data.status){
										 $('#domainModal .modal-dialog .modal-content').html(data.html); 
										 $('#domainModal').modal('show');
					                 }
								 }
						);
					break;
				}
			}
		}
		
		
	});
	
	$( document ).on( "click", "#btnSaveMoveDomainCampaign", function() {
		var campaign_id = $('#move_campaign_id_d').val();
		var entries = $('#move_entries_d').val();
		$('#domainModalError').addClass('d-none');
		$('#domainModalSuccess').addClass('d-none');
		
		if (campaign_id == ''){
			$('#domainModalError').removeClass('d-none');
			$('#domainModalError .alert-danger').html('Please select campaign');
		}else {
			$('#btnSaveMoveDomainCampaign').attr("disabled", true);
			$('#btnSaveMoveDomainCampaign').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
			$.post("/domains/savedomainnewcampaign",
					{
					  entries:entries,
					  campaign_id
					}
					 ,function(data){
						 if (data.status){
							 $('#domainModal .modal-dialog .modal-content').html(''); 
							 $('#domainModal').modal('hide');
							 domaintbl.fnDraw();
							 $('#selDomainAction').val("");
		                 }else {
		                	 $('#domainModalError').removeClass('d-none');
		         			$('#domainModalError .alert-danger').html(data.message);
		         			$('#btnSaveMoveDomainCampaign').attr("disabled", false);
		        			$('#btnSaveMoveDomainCampaign').html('Submit');
		                 }
					 }
			);
			
		}
		
	});
	
	
	$( document ).on( "click", "#btnProceedDomainDelete", function() {
		var entries = $('#move_entries_d').val();
		$('#domainModalError').addClass('d-none');
		$('#domainModalSuccess').addClass('d-none');
		
		
			$('#btnProceedDomainDelete').attr("disabled", true);
			$('#btnProceedDomainDelete').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Deleting...');
			$.post("/domains/deletedomain",
					{
					  entries:entries
					}
					 ,function(data){
						 if (data.status){
							 $('#domainModal .modal-dialog .modal-content').html(''); 
							 $('#domainModal').modal('hide');
							 domaintbl.fnDraw();
							 $('#selDomainAction').val("");
		                 }else {
		                	$('#domainModalError').removeClass('d-none');
		         			$('#domainModalError .alert-danger').html(data.message);
		         			$('#btnProceedDomainDelete').attr("disabled", false);
		        			$('#btnProceedDomainDelete').html('Submit');
		                 }
					 }
			);
		
	});
	
	$( document ).on( "click", "#btnSendDomainMail", function() {
		var subject = jQuery('#mail_subject_d').val();
		var from_name = jQuery('#mail_from_name_d').val();
		var from_email = jQuery('#mail_from_email_d').val();
		var message = jQuery('#mail_message_d').val();
		var entries = $('#move_entries_d').val();
		
		$('#domainModalError').addClass('d-none');
		$('#domainModalSuccess').addClass('d-none');

		if (subject == ''){
			$('#domainModalError').removeClass('d-none');
			$('#domainModalError .alert-danger').html('Please enter subject');
			jQuery('#mail_subject_d').focus();
		}else if (from_name == ''){
			$('#domainModalError').removeClass('d-none');
			$('#domainModalError .alert-danger').html('Please from name');
			jQuery('#mail_from_name_d').focus();
		}else if (from_email == ''){
			$('#domainModalError').removeClass('d-none');
			$('#domainModalError .alert-danger').html('Please from email');
			jQuery('#mail_from_email_d').focus();
		}else if (message == ''){
			$('#domaineModalError').removeClass('d-none');
			$('#domainModalError .alert-danger').html('Please message');
			jQuery('#mail_message_d').focus();
		}else {
			$('#btnSendDomainMail').attr("disabled", true);
			$('#btnSendDomainMail').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Sending...');
			$.post("/domains/sendmaildomain",
					{
					  entries:entries,
					  subject:subject,
					  from_name:from_name,
					  from_email:from_email,
					  message:message
					  
					}
					 ,function(data){
						 $('#btnSendDomainMail').attr("disabled", false);
		        		 $('#btnSendDomainMail').html('Submit');
						 if (data.status){
							 $('#domainModalSuccess').removeClass('d-none');
							 $('#domainModalSuccess .alert-success').html('You successfully sent mail.');
							 $('#selDomainAction').val("");	
		                 }else {
		                	 $('#domainModalError').removeClass('d-none');
		         			 $('#domainModalError .alert-danger').html(data.message);
		         			
		                 }
					 }
			);
			
		}
		
	});
	
	
});