<div class="row">
											<div class="col-md-5">
												<label for="">
													Filter by campaign
												</label>
												<select name="tblpeople_campaign" id="tblpeople_campaign" class="custom-select mb-2">
												    <option value=""></option>
													<?php if ($campaigns->num_rows() > 0):?>
														<?php  foreach ($campaigns->result() as $row):?>
															<option value="<?php echo $row->id?>"><?php echo $row->campaign_name?></option>
														<?php endforeach;?>
													<?php endif?>
													
												</select>
											</div>
											<div class="col-md-4">
												<p>&nbsp;</p>
												<a href="javascript:void(0)" class="btn btn-dark btn-sm mb-2" id="btnExportPeople">Export to CSV</a>
												<a href="javascript:void(0)" class="btn btn-dark btn-sm mb-2" id="btnImportPeople">Import CSV</a>
												<a href="javascript:void(0)" class="btn btn-dark btn-sm mb-2" id="btnAddPeople">Add People</a>
											</div>
											<div class="col-md-3">
												<label for="">
													Action
												</label>
												<select name="selPeopleAction" id="selPeopleAction" class="form-control mb-2">
													<option value=""></option>
													<option value="move_to_campaign">Move to another campaign</option>
													<option value="delete">Delete</option>
													<option value="send_email">Send Email</option>
												</select>
											</div>
										</div>
										<div class="form-group d-none" id="peopleMainTableError">
											<div class="alert alert-danger" role="alert">
											</div>
										</div>
										<div class="form-group d-none" id="peopleMainTableSuccess">
												<div class="alert alert-success" role="alert">
												</div>
										</div>
										<table id="tblpeople" class="table table-striped table-bordered table-result-custom">
											<thead>
												<tr>
													<th class="text-center">
														<input type="checkbox" id="checkallpeople"/>
													</th>
													<th>
														Name 
													</th>
													<th>
														Email 
													</th>
													<th>
														Campaign 
													</th>
													<th>
														Social 
													</th>
													<th>
														Company
													</th>
													<th>
														Notes 
													</th>
													<th>
														Date Added 
													</th>
													<th>
														Actions 
													</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
	
	<div class="modal fade" id="peopleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				
				</div>
			  </div>
			</div>
		
		<script src="/assets/js/leads/people.js"></script>										