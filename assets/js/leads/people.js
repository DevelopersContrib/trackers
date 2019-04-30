var peopletbl = $('#tblpeople').dataTable({
	    "processing": true,
	    "serverSide": true,
	    "ajax": {
	        "url": "/leads/leadslist",
	        "data": function ( d ) {
	          return $.extend( {}, d, {
	            "campaign_id": $('#tblpeople_campaign').val()
	          } );
	        }
	      },
	    "order": [[0, 'DESC']],
	    "columns": [
	        {
	            "orderable": false,
	            "searchable": false,
	            "render": (data, type, row) => {
	                return '<input type="checkbox" id="pipbox" value="'+row[0]+'"/>';
	            }
	        },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	        {
	            "orderable": false,
	            "searchable": false,
	            "render": (data, type, row) => {
	                return '';
	            }
	        },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	       {
	            "orderable": false,
	            "searchable": false,
	            "render": (data, type, row) => {
	                return '<a href="javascript:void(0)" class="btn btn-warning btn-sm btnEditPip" data="'+row[0]+'">Edit</a>';
	            }
	        }
	        
	    ],
	    
		"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			
			var id = aData[0];              
			UpdateSocials(id,nRow);
			return nRow;
		},
		"footerCallback": function ( row, data, start, end, display ) {
		}
	});

function UpdateSocials(id,nRow){
	 jQuery.post("/leads/showsocials",
  			 {
			       owner_id:id
  			 }
  			 ,function(data){
  				 data = data.split("<br>");
				 var html = '';
				 for(var x=0;x<data.length;x++){
					html+='<a target="_blank" href="'+data[x]+'">'+data[x]+'</a><br>';
				 }
  				jQuery('td:eq(4)', nRow).html(html);
  			 }
  	   );
}	 

function exportPeopleTableToCSV($table, filename) {
    //var $rows = $table.find('tr:has(td)'),
    
	var $rows = jQuery('table#tblpeople td input:checkbox').parents('tr'),

	// Temporary delimiter characters unlikely to be typed by keyboard
	// This is to avoid accidentally splitting the actual contents
	tmpColDelim = String.fromCharCode(11), // vertical tab character
	tmpRowDelim = String.fromCharCode(0), // null character

	// actual delimiter characters for CSV format
	colDelim = '","',
	rowDelim = '"\r\n"',

	// Grab text from table into CSV formatted string
	csv = '"' + $rows.map(function (i, row) {
		var $row = jQuery(row),
			$cols = $row.find('td');

		return $cols.map(function (j, col) {
			var $col = jQuery(col)
			var a = $col.clone();
			a.html($col.html().replace('<br>',' '));
			var text = a.text();
			if(text=="Edit") text ='';
			
			return text.replace(/"/g, '""'); // escape double quotes

		}).get().join(tmpColDelim);

	}).get().join(tmpRowDelim)
		.split(tmpRowDelim).join(rowDelim)
		.split(tmpColDelim).join(colDelim) + '"',

	// Data URI
	csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

    jQuery('#btnExportPeople')
        .attr({
        'download': filename,
            'href': csvData,
            'target': '_blank'
    });
}

$(document).ready(function(){
	$('#tblpeople_campaign').change(function(){
		peopletbl.fnDraw();
	});
	
	$('#btnExportPeople').click(function(){
		var d = new Date();
		var t = d.getTime();
		exportPeopleTableToCSV.apply(this, [jQuery('table#tblpeople'), t+'export.csv']);
	});
	
	$("#checkallpeople").click(function(){
	    $('#tblpeople tbody input:checkbox').not(this).prop('checked', this.checked);
	});
	
	$('#btnImportPeople').click(function(){
		$.post("/leads/importpeopleform",
				{
				  
				}
				 ,function(data){
					 if (data.status){
						 $('#peopleModal .modal-dialog .modal-content').html(data.html); 
						 $('#peopleModal').modal('show');
	                 }
				 }
		);
	});
	
	
	$( document ).on( "click", "#btnSaveImportPeople", function() {
	
	    var campaign_id = $('#modal_people_campaign').val();
	    var fileName = $("#csv_file").val();
	    var extension = fileName.replace(/^.*\./, '');
	    extension = extension.toLowerCase();
	    
	    $('#peopleModalError').addClass('d-none');
	    $('#peopleModalSuccess').addClass('d-none');
	    
	    if (campaign_id == ''){
	    	$('#peopleModalError').removeClass('d-none');
	    	$('#peopleModalError .alert-danger').html('Please select campaign');
	    }else if (fileName == ''){
	    	$('#peopleModalError').removeClass('d-none');
	    	$('#peopleModalError .alert-danger').html('Please upload csv file');
	    }else if (extension !='csv'){
	    	$('#peopleModalError').removeClass('d-none');
	    	$('#peopleModalError .alert-danger').html('Invalid file format. Please upload csv file');
	    }else {
	    	$('#btnSaveImportPeople').attr("disabled", true);
			$('#btnSaveImportPeople').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
			setTimeout(function(){ $('#modalFormPeople').submit();}, 3000);
			
	    }
	    
	});
	
	$( document ).on( "click", ".btnEditPip", function() {
		var lead_id = $(this).attr('data');
		$.post("/leads/editleadform",
				{
				  lead_id: lead_id
				}
				 ,function(data){
					 if (data.status){
						 $('#peopleModal .modal-dialog .modal-content').html(data.html); 
						 $('#peopleModal').modal('show');
	                 }
				 }
		);
	
	});
	
	
	$( document ).on( "click", "#btnSaveLead", function() {
		var lead_id = $(this).attr('data');
		var lead_campaign = $('#lead_campaign').val();
		var lead_name = $('#lead_name').val();
		var lead_email = $('#lead_email').val();
		var lead_address = $('#lead_address').val();
		var lead_phone = $('#lead_phone').val();
		var lead_company = $('#lead_company').val();
		var lead_notes = $('#lead_notes').val();
		var lead_domains = $('#lead_domains').val();
		var lead_socials = $('#lead_socials').val();
		
		$('#editPeopleModalError').addClass('d-none');
		$('#editPeopleModalSuccess').addClass('d-none');
		
		
		 var d = [];
		 var s = [];

		 if (lead_domains != ""){
		   var d = lead_socials.split('\n');
		 }

		 if (lead_socials != ""){
		  	var s = lead_socials.split('\n');
		 }
		
		if (lead_campaign == ''){
			$('#editPeopleModalError').removeClass('d-none');
			$('#editPeopleModalError .alert-danger').html('Please select campaign');
		}else if ((lead_name == '') && (lead_email == '')){
			$('#editPeopleModalError').removeClass('d-none');
			$('#editPeopleModalError .alert-danger').html('Either name or email is required.');
		}else {
			$('#btnSaveLead').attr("disabled", true);
			$('#btnSaveLead').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
			$.post("/leads/savelead",
					{
					  lead_id: lead_id,
					  lead_campaign:lead_campaign,
					  lead_name:lead_name,
					  lead_email:lead_email,
					  lead_address:lead_address,
					  lead_phone:lead_phone,
					  lead_company:lead_company,
					  lead_notes:lead_notes,
					  lead_domains:d,
					  lead_socials:s
					  
					}
					 ,function(data){
						 if (data.status){
							 $('#editPeopleModalSuccess').removeClass('d-none');
							 $('#editPeopleModalSuccess .alert-success').html(data.message);
							 peopletbl.fnDraw();
		                 }else {
		                	 $('#editPeopleModalError').removeClass('d-none');
		         			 $('#editPeopleModalError .alert-danger').html(data.message); 
		                 }
						 
						 $('#btnSaveLead').attr("disabled", false);
						 $('#btnSaveLead').html('Submit');
					 }
			);
		}
	
	});
	
	$( document ).on( "click", "#btnAddPeople", function() {
		$.post("/leads/editleadform",
				{
				  lead_id: ''
				}
				 ,function(data){
					 if (data.status){
						 $('#peopleModal .modal-dialog .modal-content').html(data.html); 
						 $('#peopleModal').modal('show');
	                 }
				 }
		);
	});
	
	$( document ).on( "change", "#selPeopleAction", function() {
		var action = $(this).val();
		$('#peopleMainTableError').addClass('d-none');
		$('#peopleMainTableSuccess').addClass('d-none');
		var entries = [];
		jQuery('#tblpeople tbody tr').each(function() {
		    jQuery(this).find('input:checkbox:checked').each(function() {
		      	    entries.push($(this).val());
		      	    
		    });
		});
		
		if (action != ''){
			if (entries.length == 0){
				$('#peopleMainTableError').removeClass('d-none');
				$('#peopleMainTableError .alert-danger').html('Please select leads first.');
				$('#selPeopleAction').val("");
			}else {
				switch (action){
					case 'move_to_campaign':
						$.post("/leads/movecampaignform",
								{
								  entries:entries
								}
								 ,function(data){
									 if (data.status){
										 $('#peopleModal .modal-dialog .modal-content').html(data.html); 
										 $('#peopleModal').modal('show');
					                 }
								 }
						);
					break;
					case 'delete':
						$.post("/leads/deletepeopleconfirm",
								{
								  entries:entries
								}
								 ,function(data){
									 if (data.status){
										 $('#peopleModal .modal-dialog .modal-content').html(data.html); 
										 $('#peopleModal').modal('show');
					                 }
								 }
						);

					break;
					case 'send_email':
						$.post("/leads/sendemailform",
								{
								  entries:entries
								}
								 ,function(data){
									 if (data.status){
										 $('#peopleModal .modal-dialog .modal-content').html(data.html); 
										 $('#peopleModal').modal('show');
					                 }
								 }
						);
					break;
				}
			}
		}
		
		
	});
	
	$( document ).on( "click", "#btnSaveMovePeopleCampaign", function() {
		var campaign_id = $('#move_campaign_id_p').val();
		var entries = $('#move_entries_p').val();
		$('#peopleModalError').addClass('d-none');
		$('#peopleModalSuccess').addClass('d-none');
		
		if (campaign_id == ''){
			$('#peopleModalError').removeClass('d-none');
			$('#peopleModalError .alert-danger').html('Please select campaign');
		}else {
			$('#btnSaveMovePeopleCampaign').attr("disabled", true);
			$('#btnSaveMovePeopleCampaign').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
			$.post("/leads/savepeoplenewcampaign",
					{
					  entries:entries,
					  campaign_id:campaign_id
					}
					 ,function(data){
						 if (data.status){
							 $('#peopleModal .modal-dialog .modal-content').html(''); 
							 $('#peopleModal').modal('hide');
							 peopletbl.fnDraw();
		                 }else {
		                	 $('#peopleModalError').removeClass('d-none');
		         			$('#peopleModalError .alert-danger').html(data.message);
		         			$('#btnSaveMovePeopleCampaign').attr("disabled", false);
		        			$('#btnSaveMovePeopleCampaign').html('Submit');
		                 }
					 }
			);
			
		}
		
	});
	
	$( document ).on( "click", "#btnProceedPeopleDelete", function() {
		var entries = $('#move_entries_p').val();
		$('#peopleModalError').addClass('d-none');
		$('#peopleModalSuccess').addClass('d-none');
		
		
			$('#btnProceedPeopleDelete').attr("disabled", true);
			$('#btnProceedPeopleDelete').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Deleting...');
			$.post("/leads/deletepeople",
					{
					  entries:entries
					}
					 ,function(data){
						 if (data.status){
							 $('#peopleModal .modal-dialog .modal-content').html(''); 
							 $('#peopleModal').modal('hide');
							 peopletbl.fnDraw();
		                 }else {
		                	 $('#peopleModalError').removeClass('d-none');
		         			$('#peopleModalError .alert-danger').html(data.message);
		         			$('#btnProceedPeopleDelete').attr("disabled", false);
		        			$('#btnProceedPeopleDelete').html('Submit');
		                 }
					 }
			);
			
		
		
	});
	
	$( document ).on( "click", "#btnSendLeadsMail", function() {
		var subject = jQuery('#mail_subject').val();
		var from_name = jQuery('#mail_from_name').val();
		var from_email = jQuery('#mail_from_email').val();
		var message = jQuery('#mail_message').val();
		var entries = $('#move_entries_p').val();
		
		$('#peopleModalError').addClass('d-none');
		$('#peopleModalSuccess').addClass('d-none');

		if (subject == ''){
			$('#peopleModalError').removeClass('d-none');
			$('#peopleModalError .alert-danger').html('Please enter subject');
			jQuery('#mail_subject').focus();
		}else if (from_name == ''){
			$('#peopleModalError').removeClass('d-none');
			$('#peopleModalError .alert-danger').html('Please from name');
			jQuery('#mail_from_name').focus();
		}else if (from_email == ''){
			$('#peopleModalError').removeClass('d-none');
			$('#peopleModalError .alert-danger').html('Please from email');
			jQuery('#mail_from_email').focus();
		}else if (message == ''){
			$('#peopleModalError').removeClass('d-none');
			$('#peopleModalError .alert-danger').html('Please message');
			jQuery('#mail_message').focus();
		}else {
			$('#btnSendLeadsMail').attr("disabled", true);
			$('#btnSendLeadsMail').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Sending...');
			$.post("/leads/sendmailpeople",
					{
					  entries:entries,
					  subject:subject,
					  from_name:from_name,
					  from_email:from_email,
					  message:message
					  
					}
					 ,function(data){
						 $('#btnSendLeadsMail').attr("disabled", false);
		        		 $('#btnSendLeadsMail').html('Submit');
						 if (data.status){
							 $('#peopleModalSuccess').removeClass('d-none');
							 $('#peopleModalSuccess .alert-success').html('You successfully sent mail.');
								
		                 }else {
		                	 $('#peopleModalError').removeClass('d-none');
		         			 $('#peopleModalError .alert-danger').html(data.message);
		         			
		                 }
					 }
			);
			
		}
		
	});
	
	
	
	
});