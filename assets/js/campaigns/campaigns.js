var campaigntbl = $('#tblcampaigns').dataTable({
	    "processing": true,
	    "serverSide": true,
	    "ajax": "/campaigns/campaignlist",
	    "order": [[0, 'ASC']],
	    "columns": [
	        {
	            "orderable": false,
	            "searchable": false,
	            "render": (data, type, row) => {
	                return '<input type="checkbox" id="cbox" value="'+row[0]+'"/>';
	            }
	        },
	        { "orderable": true, "searchable": true },
	        { "orderable": true, "searchable": true },
	       {
	            "orderable": false,
	            "searchable": false,
	            "render": (data, type, row) => {
	                return '<a href="javascript:void(0)" class="btn btn-warning btn-sm btnEditCamapaign" data="'+row[0]+'">Edit</a>';
	            }
	        }
	        
	    ]
	});

$(document).ready(function(){
	$("#checkallc").click(function(){
	    $('#tblcampaigns tbody input:checkbox').not(this).prop('checked', this.checked);
	});
	
	$('#btnAddCampaign').click(function(){
		$.post("/campaigns/editform",
				{
				  id:''
				}
				 ,function(data){
					 if (data.status){
						 $('#campaignModal .modal-dialog .modal-content').html(data.html); 
						 $('#campaignModal').modal('show');
	                 }
				 }
		);
		
	});
	
	$( document ).on( "click", ".btnEditCamapaign", function() {
		var id = $(this).attr('data');
		$.post("/campaigns/editform",
				{
				  id:id
				}
				 ,function(data){
					 if (data.status){
						 $('#campaignModal .modal-dialog .modal-content').html(data.html); 
						 $('#campaignModal').modal('show');
	                 }
				 }
		);
	});
	
	
	$( document ).on( "click", "#btnModalSaveCampaign", function() {
		$('#campaignModalError').addClass('d-none');
		$('#campaignModalSuccess').addClass('d-none');
		var campaign_name = $('#modal_campaign_name').val();
		var id = $('#modal_campaign_id').val();
		
			if (campaign_name == ''){
				$('#campaignModalError').removeClass('d-none');
				$('#campaignModalError .alert-danger').html('Please enter campaign name');
			}else {
				$('#btnModalSaveCampaign').attr("disabled", true);
				$('#btnModalSaveCampaign').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Saving...');
				$.post("/campaigns/savecampaign",
						{
						  id:id,
						  campaign_name:campaign_name
						}
						 ,function(data){
							 if (data.status){
								 $('#btnModalSaveCampaign').attr("disabled", false);
								 $('#btnModalSaveCampaign').html('Submit');
								 campaigntbl.fnDraw();
								 $('#campaignModal .modal-dialog .modal-content').html(''); 
								 $('#campaignModal').modal('hide');
			                 }
						 }
				);
			}
		});
	
	
	$( document ).on( "change", "#selcampaign", function() {
		var val = $(this).val();
		var cnt = 0;
		
		$('#campaignTableError').addClass('d-none');
		$('#campaignSuccessError').addClass('d-none');
		if (val == 'delete'){
			jQuery('#tblcampaigns tbody tr').each(function() {
			    jQuery(this).find('input:checkbox:checked').each(function() {
			      	    cnt = cnt+1;
			    });
			});
			
			if (cnt==0){
				$('#campaignTableError').removeClass('d-none');
				$('#campaignTableError .alert-danger').html('Please select domains to delete');
				$('#selcampaign').val('');
			}else {
				if (cnt>1){
					$('#campaignTableSuccess').removeClass('d-none');
					$('#campaignTableSuccess .alert-success').html('All the leads under these campaigns will also be deleted. <a href="javascript:void(0);" class="btn btn-danger" id="btnProceedDelete">Proceed</a> <a href="javascript:void(0);" class="btn btn-secondary" id="btnCancelDelete">Cancel</a>');
				}else {
					$('#campaignTableSuccess').removeClass('d-none');
					$('#campaignTableSuccess .alert-success').html('All the leads under this campaign will also be deleted. <a href="javascript:void(0);" class="btn btn-danger" id="btnProceedDelete">Proceed</a> <a href="javascript:void(0);" class="btn btn-secondary" id="btnCancelDelete">Cancel</a>');
				}
				
			}
		}
	});
	
	$( document ).on( "click", "#btnProceedDelete", function() {
		var entries = [];
		jQuery('#tblcampaigns tbody tr').each(function() {
		    jQuery(this).find('input:checkbox:checked').each(function() {
		      	    entries.push($(this).val());
		      	    
		    });
		});
		
		$('#campaignTableSuccess').removeClass('d-none');
		$('#campaignTableSuccess .alert-success').html('<i class="fa fa-spinner fa-spin fa-fw"></i>Deleting...');
		$.post("/campaigns/deletecampaigns",
				{
				  entries:entries
				}
				 ,function(data){
					 if (data.status){
						 campaigntbl.fnDraw();
						 $('#campaignTableSuccess').removeClass('d-none');
						 $('#campaignTableSuccess .alert-success').html('You successfully deleted selected campaigns');
						 $('#selcampaign').val('');
						 setTimeout(function(){ $('#campaignTableSuccess').addClass('d-none'); }, 10000);
			         }
				 }
		);
	});
	
	$( document ).on( "click", "#btnCancelDelete", function() {
		$('#campaignTableSuccess').addClass('d-none');
		$("#checkallc").click();
		$('#selcampaign').val('');
		
	});
	
});