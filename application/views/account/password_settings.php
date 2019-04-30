<div class="form-group row">
							<div class="col-md-12">
								<hr class="hr-dashed" />
							</div>
							<div class="col-md-10 ml-auto">
								<h3>
									Password
								</h3>
							</div>
						</div>
						<div class="form-group d-none" id="accountPassError">
							<div class="alert alert-danger" role="alert">
							</div>
					     </div>
						<div class="form-group d-none" id="accountPassSuccess">
								<div class="alert alert-success" role="alert">
								</div>
						</div>
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">Current Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="current_password" id="current_password" value=""/>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">New Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="new_password" id="new_password" value=""/>
							</div>
						</div>
						
						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label text-right">Confirm New Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="new_password2" id="new_password2" value=""/>
							</div>
						</div>
						
						
						<div class="form-group row">
							<div class="col-md-10 ml-auto">
								<a href="javascript:void(0)" class="btn btn-primary" id="btnSavePassword">
									<i class="fas fa-check"></i>
									Save Changes
								</a>
							</div>
						</div>
						<script src="/assets/js/account/password.js"></script>	