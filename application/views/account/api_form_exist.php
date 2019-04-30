<div class="form-group row">
							<div class="col-md-12">
								<hr class="hr-dashed" />
							</div>
							<div class="col-md-10 ml-auto">
								<h3>
									Api Settings
								</h3>
							</div>
						</div>
						<div class="form-group d-none" id="accountApiError">
							<div class="alert alert-danger" role="alert">
							</div>
					     </div>
						<div class="form-group d-none" id="accountApiSuccess">
								<div class="alert alert-success" role="alert">
								</div>
						</div>
						<div class="form-group row" id="fromApiContent">
							<label for="" class="col-sm-2 col-form-label text-right">API Key</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="current_api_key" id="current_api_key" value="<?php echo $api_key?>" readonly/>
							</div>
						</div>
						
						
						<div class="form-group row">
							<div class="col-md-10 ml-auto">
								<a href="javascript:void(0)" class="btn btn-primary" id="btnGenerateApi">
									<i class="fas fa-check"></i>
									Generate New Api
								</a>
							</div>
						</div>
						<script src="/assets/js/account/apisettings.js"></script>	