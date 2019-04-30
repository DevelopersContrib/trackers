<div class="form-group row">
							<div class="col-md-12">
								<hr class="hr-dashed" />
							</div>
							<div class="col-md-10 ml-auto">
								<h3>
									Address
								</h3>
							</div>
						</div>
						<div class="form-group d-none" id="accountAError">
							<div class="alert alert-danger" role="alert">
							</div>
					     </div>
						<div class="form-group d-none" id="accountASuccess">
								<div class="alert alert-success" role="alert">
								</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">Address</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="account_address" id="account_address" value="<?php echo $query->row()->address?>"/>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">City</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="account_city" id="account_city" value="<?php echo $query->row()->city?>"/>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">State</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="account_state" id="account_state" value="<?php echo $query->row()->state?>"/>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">Postcode</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="account_zipcode" id="account_zipcode" value="<?php echo $query->row()->zipcode?>"/>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-10 ml-auto">
								<a href="javascript:void(0)" class="btn btn-primary" id="btnSaveAddress">
									<i class="fas fa-check"></i>
									Save Changes
								</a>
							</div>
						</div>
						<script src="/assets/js/account/address.js"></script>	