<?php $this->load->view('includes/header')?>
	<?php $this->load->view('includes/navigation')?>
		
		<div class="section-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="wrap-form-containter-tracker">
							<div class="mb-3 text-center">
								<img src="https://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-trackers1.png" style="margin-left: -25px;" alt="" width="200" height="60">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4 offset-md-4" id="forgotForm">
						<div class="form-group">
							<h1 class="lead-title">Forgot Password</h1>
							<p>
								Please enter your email address below,<br> and we'll send 
								you an email to start the process.
							</p>
						</div>
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" id="forgot_email" placeholder="Email" />
							<small id="form_error_email" class="text-danger d-none">Please input correct email address.</small>
						</div>
						<div class="form-group">
							<a href="javascript:void(0)" class="btn btn-block btn-primary btn-lg" id="btnResetPassword">
								RESET PASSWORD
							</a>
						</div>
					</div>
					
					<div class="col-md-4 offset-md-4 d-none" id="forgotSuccess">
						<div class="form-group">
							<h1 class="lead-title">Password Reset</h1>
							<p>
								Password reset email was sent,
								you should<br> receive it momentarily.
								<br>
								If you do not receive it within a few minutes. try resending or contact us at <i>info@trackers.com</i>
							</p>
						</div>
						<div class="form-group">
							<a href="javascript:void(0)" class="btn btn-block btn-primary btn-lg" id="btnResendPassword" data="">
								RESEND
							</a>
						</div>
					</div>
					
					<div class="col-md-4 offset-md-4 d-none" id="resendSuccess">
						  <div class="form-group">
							  <div class="alert alert-success" role="alert">
									Password reset email was resent to your email. 
								</div>
							</div>
					</div>
					
				</div>
			</div>
		</div>
	<script src="/assets/js/forgot/forgot.js"></script>			
	<?php $this->load->view('includes/footer')?>	