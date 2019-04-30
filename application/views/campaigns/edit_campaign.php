<div class="modal-header">
                 <?php if ($campaign_id == ''):?>
					<h5 class="modal-title" id="exampleModalLabel">Add Campaign</h5>
					<?php else:?>
					<h5 class="modal-title" id="exampleModalLabel">Edit Campaign</h5>
				<?php endif?>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			   <div class="modal-body">
					<div class="form-group d-none" id="campaignModalError">
							<div class="alert alert-danger" role="alert">
							</div>
					</div>
					<div class="form-group d-none" id="campaignModalSuccess">
							<div class="alert alert-success" role="alert">
							</div>
					</div>
					<div class="form-group">
						<label for="">Campaign Name *</label>
						<input type="text" class="form-control" id="modal_campaign_name" name="modal_campaign_name" value="<?php echo $campaign_name?>">
					</div>							
					
			  </div>
			  <div class="modal-footer">
			  <input type="hidden" name="modal_campaign_id" id="modal_campaign_id" value="<?php echo $campaign_id?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="btnModalSaveCampaign">Submit</button>
			  </div>
			