<div class="modal-header">
    <?php if ($lead_id == ''):?>
    	<h5 class="modal-title" id="exampleModalLabel">Add Lead</h5>
    	<?php else:?>
    	<h5 class="modal-title" id="exampleModalLabel">Edit Lead</h5>
    <?php endif?>
	
                
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			   <div class="modal-body">
					<div class="form-group d-none" id="editPeopleModalError">
							<div class="alert alert-danger" role="alert">
							</div>
					</div>
					<div class="form-group d-none" id="editPeopleModalSuccess">
							<div class="alert alert-success" role="alert">
							</div>
					</div>
					<div class="form-group">
						<label for="">Campaign*</label>
						<select name="lead_campaign" id="lead_campaign" class="custom-select mb-2">
							    <option value=""></option>
								<?php if ($campaigns->num_rows() > 0):?>
									<?php  foreach ($campaigns->result() as $row):?>
										<option value="<?php echo $row->id?>" <?php if ($campaign_id==$row->id) echo 'selected'?>><?php echo $row->campaign_name?></option>
									<?php endforeach;?>
								<?php endif?>
								
						</select>
					</div>		
					<div class="form-group">
					 	<label>Name</label>
					 	<input type="text" class="form-control" id="lead_name" name="lead_name" value="<?php echo $name?>">
					</div>					
					<div class="form-group">
					 	<label>Email</label>
					 	<input type="text" class="form-control" id="lead_email" name="lead_email" value="<?php echo $email?>">
					</div>					
					<div class="form-group">
					 	<label>Address</label>
					 	<input type="text" class="form-control" id="lead_address" name="lead_address" value="<?php echo $address?>">
					</div>
					<div class="form-group">
					 	<label>Phone</label>
					 	<input type="text" class="form-control" id="lead_phone" name="lead_phone" value="<?php echo $phone?>">
					</div>
					<div class="form-group">
					 	<label>Company</label>
					 	<input type="text" class="form-control" id="lead_company" name="lead_company" value="<?php echo $company?>">
					</div>					
					<div class="form-group">
					 	<label>Notes</label>
					 	<input type="text" class="form-control" id="lead_notes" name="lead_notes" value="<?php echo $notes?>">
					</div>					
					<div class="form-group">
					 	<label>Domains</label>
					 	<textarea class="form-control"  name="lead_domains" id="lead_domains" ><?php echo $domains?></textarea>
					</div>	
					<div class="form-group">
					 	<label>Socials</label>
					 	<textarea class="form-control"  name="lead_socials" id="lead_socials" ><?php echo $socials?></textarea>
					</div>	
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="btnSaveLead" data="<?php echo $lead_id?>">Submit</button>
			  </div>
			