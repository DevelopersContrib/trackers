<div class="form-group row">
							<div class="col-md-10 ml-auto">
								<h3>
									Personal Settings
								</h3>
							</div>
						</div>
						<div class="form-group d-none" id="accountPError">
							<div class="alert alert-danger" role="alert">
							</div>
					     </div>
						<div class="form-group d-none" id="accountPSuccess">
								<div class="alert alert-success" role="alert">
								</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">First Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="account_firstname" name="account_firstname" value="<?php echo $query->row()->firstname?>"/>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">Last Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="account_lastname" name="account_lastname" value="<?php echo $query->row()->lastname?>"/>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">Email</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="account_email" name="account_email" value="<?php echo $query->row()->email?>" readonly/>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">Occupation</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="account_occupation" name="account_occupation" value="<?php echo $query->row()->occupation?>"/>
							</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">Website URL</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="account_website" name="account_website" value="<?php echo $query->row()->website?>"/>
							</div>
						</div>
						
						<div class="form-group row">
							<div class="col-md-10 ml-auto">
								<a href="javascript:void(0)" class="btn btn-primary" id="btnSavePersonal">
									<i class="fas fa-check"></i>
									Save Changes
								</a>
							</div>
						</div>
						<script src="/assets/js/account/personal.js"></script>	