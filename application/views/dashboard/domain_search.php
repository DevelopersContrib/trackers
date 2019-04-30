<div class="pt-3 pr-3 pl-3 pb-4" id="formWebsite">
									  <div class="row">
											<div class="col-md-10">
												<label class="sr-only" for="inlineFormInputName2">Domain</label>
												<textarea class="form-control mb-2 form-control-lg" name="searchWebsite" id="searchWebsite" rows="3"></textarea>
												<small class="text-info">Domains (separate by new line)</small>
												<small class="text-danger d-none" id="form_error_website">
							                    </small>
											</div>
											<div class="col-md-2">
												<button type="submit" class="btn btn-primary btn-block mb-2 btn-lg" id="btnSearchWebsite">Submit</button>
											</div>
										</div>
									</div>
									<div class="row d-none" id="resultWebsite">
									
										<div class="col-md-12 ">
												<div class="m-3">
												    <button type="submit" class="btn btn-info mb-2 btn-lg" id="btnNewSearchWebsite" >Track New Domain</button>
													<h4 class="mb-4" id="resultWebsiteH">
												   </h4>
												    <div class="row">
													<div class="col-md-4 d-none" id="websiteSelect">
														<select name="selectWebsite" id="selectWebsite" class="custom-select mb-3">
															<option value="">With selected</option>
															<option value="save_domains">Save Domains</option>
														</select>
													</div>
												</div>
												    <div class="form-group d-none" id="websiteTableError">
														<div class="alert alert-danger" role="alert">
														     
														</div>
													</div>
													<div class="form-group d-none" id="websiteTableSuccess">
														<div class="alert alert-success" role="alert">
														     
														</div>
													</div>
												   <table id="table-website" class="table table-striped table-bordered table-result-custom">
												      <thead>
														<tr>
														  <th class="text-center"><input type="checkbox" id="checkallw" name="checkallw"/></th>
														   <th>Domain</th>
														   <th>Value</th>
														   <th>Owner</th>
														   <th>Owner Email</th>
														   <th>Phone</th> 
														   <th>Expire Date</th>
														   <th>Registrar</th>
														</tr>
													</thead>	
													<tbody>
													  	
													</tbody>
												   </table>
												</div>
										</div>
										
										
	<div class="modal fade" id="modalWCampaigns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Save To Campaign</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form>
			    <div class="form-group d-none" id="websiteModalError">
						<div class="alert alert-danger" role="alert">
														     
						</div>
				</div> 
				<div class="form-body" id="fieldw_campaign">   
				       <?php  if ($campaigns->num_rows() > 0):?>
	     		 			<div class="form-group">
								<label for="">Campaign</label>
								<select class="form-control"  id="website_campaign" name="website_campaign">
								<option value=""></option>
								                <?php 
								                if ($campaigns->num_rows() > 0){
								                	  foreach ($campaigns->result() as $row){
								                ?>
								                     <option value="<?php echo $row->id?>"> <?php echo $row->campaign_name?></option>
								                <?php 
								                    }
								                 }
								                ?>
	                             </select>&nbsp;<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btnaddcampaignw">CREAT NEW</a>
							</div>	
	     		 		
	     		 		
			          <?php else:?>
			        <div class="form-group">
								<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btnaddcampaignw">CREAT NEW</a>
							</div>	
			          <?php endif?> 
	     		 </div>  
	     		 				
				 <div class="form-body" id="fieldw_addcampaign" style="display:none">   
	     		 		<div class="form-group">
							<label for="">Campaign Name</label>
							<input type="text" name="w_campaign_name" class="form-control" id="w_campaign_name" value=""/> 
							<br>
							<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btncanceladdw">BACK</a>  
				        </div>
	     		 </div>  
	     		 
			</form>
		  </div>
		  <div class="modal-footer">
		    <input type="hidden" name="w_option_campaign" id="w_option_campaign" value="select">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-primary" id="btnSaveWebsite">Submit</button>
		  </div>
		</div>
	  </div>
	</div>					
</div>
<script src="/assets/js/dashboard/domain_search.js"></script>