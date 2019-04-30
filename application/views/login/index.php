<?php $this->load->view('includes/header')?>
	<?php $this->load->view('includes/navigation')?>
		<div class="section-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="wrap-form-containter-tracker">
							<div class="mb-5 text-center">
								<img src="https://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-trackers1.png" style="margin-left: -25px;" alt="" width="200" height="60">
							</div>
							<div class="text-center">
								<h1 class="lead-title">
									Login
								</h1>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 offset-md-4">
					 <?php if ($confirm_error !=""):?>
							<div class="form-group">
								<div class="alert alert-danger" role="alert">
									<?php echo $confirm_error?>
								</div>
							</div>
						<?php endif?>
						<?php if ($confirm_success !=""):?>
							<div class="form-group">
								<div class="alert alert-success" role="alert">
									<?php echo $confirm_success?>
								</div>
							</div>
						<?php endif?>
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" id="login_email" placeholder="Enter Email">
							<small class="text-danger d-none" id="form_error_email">
							</small>
						</div>
						<div class="form-group">
							<input type="password" class="form-control form-control-lg" id="login_password" placeholder="Enter Password">
							<small class="text-danger d-none" id="form_error_password">
							</small>
						</div>
						<div class="form-group clearfix">
							<div class="float-right">
								<a href="/forgot">
									Forgot Password?
								</a>
							</div>
							<div class="custom-control custom-checkbox custom-inline-block">
								<input type="checkbox" class="custom-control-input" id="customCheck1">
								<label class="custom-control-label" for="customCheck1">Remember me</label>
							</div>
						</div>
						<div class="form-group">
							<a href="javascript:void(0)" class="btn btn-primary btn-block btn-lg" id="btnLogin">
								<i class="fas fa-lock"></i>
								Login
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
<script src="/assets/js/login/login.js"></script>		
<?php $this->load->view('includes/footer')?>	