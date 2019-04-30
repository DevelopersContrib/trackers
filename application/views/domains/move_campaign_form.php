<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel">Move To Campaign</h5>
                
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			   <div class="modal-body">
					<div class="form-group d-none" id="domainModalError">
							<div class="alert alert-danger" role="alert">
							</div>
					</div>
					<div class="form-group d-none" id="domainModalSuccess">
							<div class="alert alert-success" role="alert">
							</div>
					</div>
					<div class="form-group">
						<label for="">Campaign*</label>
						<select name="move_campaign_id_d" id="move_campaign_id_d" class="custom-select mb-2">
							    <option value=""></option>
								<?php if ($campaigns->num_rows() > 0):?>
									<?php  foreach ($campaigns->result() as $row):?>
										<option value="<?php echo $row->id?>"><?php echo $row->campaign_name?></option>
									<?php endforeach;?>
								<?php endif?>
								
						</select>
					</div>		
			  </div>
			  <div class="modal-footer">
				<input type="hidden" name="move_entries_d" id="move_entries_d" value="<?php echo $entries?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="btnSaveMoveDomainCampaign">Submit</button>
			  </div>
			