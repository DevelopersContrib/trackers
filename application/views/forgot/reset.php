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
					<div class="col-md-4 offset-md-4 ">
					  <?php if ($error_message !=""):?>
							<div class="form-group">
								<div class="alert alert-danger" role="alert">
									<?php echo $error_message?>
								</div>
							</div>
							<?php else:?>
							<div class="alert alert-info d-none" id="resetNotification" role="alert">
									Password successfully changed.
						    </div>
							<div class="form-group">
								<h1 class="lead-title">Set New Password</h1>
							</div>
							<div class="form-group">
								<input type="password" class="form-control form-control-lg" id="password" placeholder="New Password" />
								<small id="form_error_password" class="text-danger d-none"></small>
							</div>
							<div class="form-group">
								<input type="password" class="form-control form-control-lg" id="confirm_password" placeholder="Confirm Password" />
								<small id="form_error_confirm_password" class="text-danger d-none"></small>
							</div>
							<div class="form-group">
							    <input type="hidden" name="password_code" id="password_code" value="<?php echo $code?>">
								<a href="javascript:void(0)" class="btn btn-block btn-primary btn-lg" id="btnResetPassword">
									SET PASSWORD
								</a>
							</div>
							
						<?php endif?>
					
					
					
					</div>
				</div>
			</div>
		</div>
	<script src="/assets/js/forgot/reset.js"></script>			
	<?php $this->load->view('includes/footer')?>	