		<div class="pt-3 pr-3 pl-3 pb-4" id="formName">
										 <div class="row">
											<div class="col-md-10">
												<label class="sr-only" for="inlineFormInputName2">Names</label>
												<textarea class="form-control mb-2 form-control-lg" name="searchName" id="searchName" rows="3"></textarea>
												<small class="text-info">Names (separate by new line)</small>
												<small class="text-danger d-none" id="form_error_name">
							                    </small>
											</div>
											<div class="col-md-2">
												<button type="submit" class="btn btn-primary btn-block mb-2 btn-lg" id="btnSearchName">Submit</button>
											</div>
										</div>
									</div>
									<div class="row d-none" id="resultName">
										<div class="col-md-12">
												<div class="m-3">
												    <button type="submit" class="btn btn-info mb-2 btn-lg" id="btnNewSearchName" style="width:200px">Track New Name</button>
													<h4 class="mb-4" id="resultNameH">
												   </h4>
												    <div class="row">
													<div class="col-md-4 d-none" id="nameSelect">
														<select name="selectName" id="selectName" class="custom-select mb-3">
															<option value="">With selected</option>
															<option value="save_leads">Save Leads</option>
														</select>
													</div>
												   </div>
												   <div class="form-group d-none" id="nameTableError">
														<div class="alert alert-danger" role="alert">
														     
														</div>
													</div>
													<div class="form-group d-none" id="nameTableSuccess">
														<div class="alert alert-success" role="alert">
														     
														</div>
													</div>
												   <div class="table-responsive">
													   <table id="table-name" class="table table-striped table-bordered table-result-custom">
													      <thead>
															<tr>
															   	<th><input type="checkbox" id="checkalln" class="checkalln"></th>
																<th>Name</th>
																<th>Email</th>
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
										<div class="modal fade" id="modalNCampaigns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
												    <div class="form-group d-none" id="nameModalError">
															<div class="alert alert-danger" role="alert">
																							     
															</div>
													</div> 
													<div class="form-body" id="fieldn_campaign">   
													       <?php  if ($campaigns->num_rows() > 0):?>
										     		 			<div class="form-group">
																	<label for="">Campaign</label>
																	<select class="form-control"  id="name_campaign" name="name_campaign">
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
										                             </select>&nbsp;<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btnaddcampaignn">CREAT NEW</a>
																</div>	
										     		 		
										     		 		
												          <?php else:?>
												        <div class="form-group">
																	<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btnaddcampaignn">CREAT NEW</a>
																</div>	
												          <?php endif?> 
										     		 </div>  
										     		 				
													 <div class="form-body" id="fieldn_addcampaign" style="display:none">   
										     		 		<div class="form-group">
																<label for="">Campaign Name</label>
																<input type="text" name="n_campaign_name" class="form-control" id="n_campaign_name" value=""/> 
																<br>
																<a href="javascript:void(0)" class="btn btn-warning btn-sm" id="btncanceladdn">BACK</a>  
													        </div>
										     		 </div>  
										     		 
												</form>
											  </div>
											  <div class="modal-footer">
											    <input type="hidden" name="n_option_campaign" id="n_option_campaign" value="select">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
												<button type="button" class="btn btn-primary" id="btnSaveName">Submit</button>
											  </div>
											</div>
										  </div>
	</div>	
									</div>
<script src="/assets/js/dashboard/name_search.js"></script>									