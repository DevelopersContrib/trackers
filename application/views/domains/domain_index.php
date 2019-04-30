	<style>
		#tbldomain td, .table th {
			font-size: 14px !important;
		}
		
		#tbldomain{
		  width:100% !important;
		}
		</style>
	<div class="row">
											<div class="col-md-6">
												<label for="">
													Filter by campaign
												</label>
												<select name="tbldomain_campaign" id="tbldomain_campaign" class="custom-select mb-2">
													 <option value=""></option>
													<?php if ($campaigns->num_rows() > 0):?>
														<?php  foreach ($campaigns->result() as $row):?>
															<option value="<?php echo $row->id?>"><?php echo $row->campaign_name?></option>
														<?php endforeach;?>
													<?php endif?>
												</select>
											</div>
											<div class="col-md-6">
												<label for="">
													Action
												</label>
												<select name="selDomainAction" id="selDomainAction"  class="form-control mb-2">
													<option value=""></option>
													<option value="move_to_campaign">Move to another campaign</option>
													<option value="delete">Delete</option>
													<option value="send_email">Send Email</option>
												</select>
											</div>
										</div>
										<div class="form-group d-none" id="domainMainTableError">
											<div class="alert alert-danger" role="alert">
											</div>
										</div>
										<div class="form-group d-none" id="domainMainTableSuccess">
												<div class="alert alert-success" role="alert">
												</div>
										</div>
										
										<table id="tbldomain" class="table table-striped table-bordered table-result-custom">
											<thead>
												<tr>
													<th class="text-center">
														<input type="checkbox" id="checkalldomain"/>
													</th>
													<th>
														Domain 
													</th>
													<th>
														Value 
													</th>
													<th>
														Owner 
													</th>
													<th>
														Registrar 
													</th>
													<th>
														Date Expire 
													</th>
													<th>
														Campaign
													</th>
													
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>

<div class="modal fade" id="domainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				
				</div>
			  </div>
			</div>
		
		<script src="/assets/js/domains/domain.js"></script>												