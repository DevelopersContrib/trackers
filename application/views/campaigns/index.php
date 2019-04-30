<?php $this->load->view('includes/header_login')?>
		<?php $this->load->view('includes/navigation_login')?>
		<div class="section-1">
			<div class="container">
			<div class="row">
					<div class="col-md-12 py-5">
						<div class="card bg-light mb-3">
							<div class="card-header">Campaigns</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<label for="">Action</label>
										<select name="selcampaign" id="selcampaign" class="custom-select mb-3">
											<option value="">With selected</option>
											<option value="delete">Delete</option>
										</select>
									</div>
									<div class="col-md-8 text-right">
									<a href="javascript:void(0);" class="btn btn-primary float-right" id="btnAddCampaign">
										+
										Add Campaign
									</a>
									</div>
								</div>
								<div class="form-group d-none" id="campaignTableError">
									<div class="alert alert-danger" role="alert">
									</div>
								</div>
								<div class="form-group d-none" id="campaignTableSuccess">
										<div class="alert alert-success" role="alert">
										</div>
								</div>
								<table id="tblcampaigns" class="table table-striped table-bordered table-result-custom">
									<thead>
										<tr>
											<th>
												<input type="checkbox" id="checkallc" name="checkallc"/>
											</th>
											<th>
												Name 
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="campaignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			
			</div>
		  </div>
		</div>
		
		<script src="/assets/js/campaigns/campaigns.js"></script>
		<?php $this->load->view('includes/footer_login')?>						