<?php $this->load->view('includes/header')?>
	<?php $this->load->view('includes/navigation')?>
		
		<div class="section-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="wrap-form-containter-tracker">
							<h1 class="lead-title">
								Contact Us
							</h1>
							<p>
								Please submit your question or request using the form below.
							</p>
						</div>
					</div>
					
					
					
						
					<div class="col-md-12">
					   <div class="d-none" id="contactsuccess">
						    <div class="form-group" >
								<div class="alert alert-success" role="alert">
									
								</div>
							</div>
						</div>	
						
						<div class="row">
						
						
						
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Name <span class="text-danger">*</span></label>
									<input type="text" name="contact_name" id="contact_name" class="form-control form-control-lg">
									<small class="text-danger d-none" id="form_error_contact_name">
							        </small>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Email <span class="text-danger">*</span></label>
									<input type="text" name="contact_email" id="contact_email" class="form-control form-control-lg">
									<small class="text-danger d-none" id="form_error_contact_email">
							        </small>
								</div>
							</div>
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Subject <span class="text-danger">*</span></label>
									<input type="text" name="contact_subject" id="contact_subject" class="form-control form-control-lg">
									<small class="text-danger d-none" id="form_error_contact_subject">
							        </small>
								</div>
								<div class="form-group">
									<label for="">Message <span class="text-danger">*</span></label>
									<textarea class="form-control" name="contact_message" id="contact_message" cols="30" rows="10"></textarea>
									<small class="text-danger d-none" id="form_error_contact_message">
							        </small>
								</div>
								<div class="form-group">
									<a href="javascript:void(0)" class="btn btn-primary btn-block btn-lg" id="btnSubmitContact">Submit</a>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
<script src="/assets/js/contact/contact.js"></script>		
<?php $this->load->view('includes/footer')?>	