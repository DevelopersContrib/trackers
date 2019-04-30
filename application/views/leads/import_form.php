<div class="modal-header">
	<h5 class="modal-title" id="exampleModalLabel">Import Leads</h5>
                
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <form action="/leads/processimportcsv" method="post" class="stdform quickform" id="modalFormPeople" enctype="multipart/form-data">
			   <div class="modal-body">
					<div class="form-group d-none" id="peopleModalError">
							<div class="alert alert-danger" role="alert">
							</div>
					</div>
					<div class="form-group d-none" id="peopleModalSuccess">
							<div class="alert alert-success" role="alert">
							</div>
					</div>
					<div class="form-group">
						<label for="">Campaign*</label>
						<select name="modal_people_campaign" id="modal_people_campaign" class="custom-select mb-2">
							    <option value=""></option>
								<?php if ($campaigns->num_rows() > 0):?>
									<?php  foreach ($campaigns->result() as $row):?>
										<option value="<?php echo $row->id?>"><?php echo $row->campaign_name?></option>
									<?php endforeach;?>
								<?php endif?>
								
						</select>
					</div>		
					<div class="form-group">
					 	<label>Upload csv file</label>
					 	<input name="csv_file" id="csv_file" type="file"  /><br>
	                    <small>Format: Name | Email | Company | Socials (urls separated by comma) | Domain</small>
					</div>					
					
			  </div>
			  </form>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="btnSaveImportPeople">Submit</button>
			  </div>
			