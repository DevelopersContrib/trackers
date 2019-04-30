		<div class="pt-3 pr-3 pl-3 pb-4" id="formEmail">
										 <div class="row">
											<div class="col-md-10">
												<label class="sr-only" for="inlineFormInputName2">Emails</label>
												<textarea class="form-control mb-2 form-control-lg" name="searchEmail" id="searchEmail" rows="3"></textarea>
												<small class="text-info">Emails (separate by new line)</small>
												<small class="text-danger d-none" id="form_error_email">
							                    </small>
											</div>
											<div class="col-md-2">
												<button type="submit" class="btn btn-primary btn-block mb-2 btn-lg" id="btnSearchEmail">Submit</button>
											</div>
										</div>
									</div>
									<div class="row d-none" id="resultEmail">
										<div class="col-md-12">
												<div class="m-3">
												    <button type="submit" class="btn btn-info mb-2 btn-lg" id="btnNewSearchEmail" style="width:200px">Track New Emails</button>
													<h4 class="mb-4" id="resultEmailH">
												   </h4>
												    <div class="row">
													<div class="col-md-4 d-none" id="emailSelect">
														<select name="selectEmail" id="selectEmail" class="custom-select mb-3">
															<option value="">With selected</option>
															<option value="save_leads">Save Leads</option>
														</select>
													</div>
												   </div>
												   <div class="form-group d-none" id="emailTableError">
														<div class="alert alert-danger" role="alert">
														     
														</div>
													</div>
													<div class="form-group d-none" id="emailTableSuccess">
														<div class="alert alert-success" role="alert">
														     
														</div>
													</div>
												   <div class="table-responsive">
													   <table id="table-email" class="table table-striped table-bordered table-result-custom">
													      <thead>
															<tr>
															   	<th><input type="checkbox" id="checkalle" class="checkalle"></th>
																<th>Email</th>
																<th>Name</th>
																<th>Address</th>
																<th>Phone</th>
																<th>Company</th>
																<th>Notes</th>
																<th>Socials</th>
																<th>Domains</th>
															</tr>
														</thead>	
														<tbody>
														  	
														</tbody>
													   </table>
												   </div>
												</div>
										</div>
										<div class="modal fade" id="modalECampaigns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
												    <div class="form-group d-none" id="emailModalError">
															<div class="alert alert-danger" role="alert">
																							     
															</div>
													</div> 
													<div class="form-body" id="fielde_campaign">   
													       <?php  if ($campaigns->num_rows() > 0):?>
										     		 			<div class="form-group">
																	<label for="">Campaign</label>
																	<select class="form-control"  id="email_campaign" name="email_campaign">
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
										                             </select>&nbsp;<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btnaddcampaigne">CREAT NEW</a>
																</div>	
										     		 		
										     		 		
												          <?php else:?>
												        <div class="form-group">
																	<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btnaddcampaigne">CREAT NEW</a>
																</div>	
												          <?php endif?> 
										     		 </div>  
										     		 				
													 <div class="form-body" id="fielde_addcampaign" style="display:none">   
										     		 		<div class="form-group">
																<label for="">Campaign Name</label>
																<input type="text" name="e_campaign_name" class="form-control" id="e_campaign_name" value=""/> 
																<br>
																<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btncanceladde">BACK</a>  
													        </div>
										     		 </div>  
										     		 
												</form>
											  </div>
											  <div class="modal-footer">
											    <input type="hidden" name="e_option_campaign" id="e_option_campaign" value="select">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
												<button type="button" class="btn btn-primary" id="btnSaveEmail">Submit</button>
											  </div>
											</div>
										  </div>
	</div>	
									</div>
<script src="/assets/js/dashboard/email_search.js"></script>									