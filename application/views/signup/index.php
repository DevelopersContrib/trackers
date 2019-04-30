<?php $this->load->view('includes/header')?>
	<?php $this->load->view('includes/navigation')?>
		
		<div class="section-1">
			<div class="container">
				<div class="row" id="form-step1-success">
					<div class="col-md-12">
						<div class="wrap-form-containter-tracker">
							<div class="mb-3 text-center">
								<img src="https://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-trackers1.png" style="margin-left: -25px;" alt="" width="200" height="60">
							</div>
						</div>
					</div>
					<!-- Sign Up Form -->
					<div class="col-md-12 text-center">
						<h1 class="lead-title-center">
							Create Your Account
						</h1>
						<span class="meta-dash-headline">
							<span>
								Just complete this form and you’re done :)
							</span>
						</span>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 offset-md-3 text-center mt-3">
								<div class="mb-3">
									<div class="input-group input-group-lg">
										<div class="input-group-prepend">
											<span class="input-group-text">First Name</span>
										</div>
										<input type="text" class="form-control" id="first_name" placeholder="First Name" />
									</div>
									<small class="form-text text-danger text-left d-none" id="form_error_first_name">
									</small>
								</div>
								<div class="mb-3">
									<div class="input-group input-group-lg">
										<div class="input-group-prepend">
											<span class="input-group-text">Last Name </span>
										</div>
										<input type="text" id="last_name" class="form-control" placeholder="Last Name" />
									</div>
									<small class="form-text text-danger text-left d-none" id="form_error_last_name">
									</small>
								</div>
								<div class="mb-3">
									<div class="input-group input-group-lg">
										<div class="input-group-prepend">
											<span class="input-group-text">Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
										</div>
										<input type="text" id="email" class="form-control" placeholder="Email" />
									</div>
									<small class="form-text text-danger text-left d-none" id="form_error_email">
									</small>
								</div>
								<div class="mb-3">
									<div class="input-group input-group-lg">
										<div class="input-group-prepend">
											<span class="input-group-text">Password &nbsp;&nbsp;</span>
										</div>
										<!-- Add .is-valid to form-control for error style -->
										<input type="password" id="password" class="form-control" placeholder="at least 6 charactesrs" />
									</div>
									<small class="form-text text-danger text-left d-none" id="form_error_password">
										Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
									</small>
								</div>
								<div class="mb-3">
									<input type="hidden" id="domain" value="<?php echo $domain?>">
									<input type="hidden" id="user_ip" value="<?php echo $_SERVER['REMOTE_ADDR']?>">
									<input type="text" class="form-control" id="secret" name="secret" value="" style="display:none;">
									<a href="javascript:void(0)" class="btn btn-primary btn-lg" id="btn-signup-submit">
										<i class="fas fa-check"></i>
										Sign Up
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row d-none" id="form-div-success">
					<div class="col-md-12">
						<div class="wrap-form-containter-tracker">
							<div class="mb-3 text-center">
								<img src="https://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-trackers1.png" style="margin-left: -25px;" alt="" width="200" height="60">
							</div>
						</div>
					</div>
					<!-- Success Message -->
					<div class="col-md-12 text-center">
						<h1 class="lead-title-center text-primary">
							Congratulations! Your trackers.com account has been created.
						</h1>
						<span class="meta-dash-headline">
							<span>
								A link was sent to your email.
							</span>
						</span>

						<div class="row">
							<div class="col-md-6 offset-md-3">
								<ul class="list-group">
									<li class="list-group-item p-4" id="success-email-content">
										<h3>
											h.castanos@yahoo.com.sg
										</h3>
									</li>
									<li class="list-group-item">
										Follow the magic link in your email to activate your account
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<script src="/assets/js/signup/signup.js"></script>		
<?php $this->load->view('includes/footer')?>	