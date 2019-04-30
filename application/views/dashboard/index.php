<?php $this->load->view('includes/header_login')?>
		<?php $this->load->view('includes/navigation_login')?>
		<script src="/assets/js/dashboard/search.js"></script>
		<style>
		.table td, .table th {
			font-size: 12px;
		}
		</style>
		<div class="section-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="wrap-form-containter-tracker">
							<div class="mb-5 text-center">
								<img src="https://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-trackers1.png" style="margin-left: -25px;" alt="" width="200" height="60">
							</div>

							<h1 class="lead-title">
								Trackers helps you find the people that matters most to grow your business. 
							</h1>
							<p>
								Research. Track. Import.  Verify.
							</p>
							<ul class="nav nav-tabs tabs-form-ul" id="myTab" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#website" role="tab" aria-selected="true">Domain</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#name" role="tab" aria-selected="false">NAME</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#email" role="tab" aria-selected="false">EMAIL</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-toggle="tab" href="#socialaccount" role="tab" aria-selected="false">SOCIAL ACCOUNT (Twitter)</a>
								</li>
							</ul>
							<div class="tab-content tab-content-custom-form" id="myTabContent">
								<div class="tab-pane fade show active" id="website" role="tabpanel">
									<?php $this->load->view('dashboard/domain_search')?>
								</div>
								
								<div class="tab-pane fade" id="name" role="tabpanel">
							       <?php $this->load->view('dashboard/name_search')?>
								</div>
								
								<div class="tab-pane fade" id="email" role="tabpanel">
								   <?php $this->load->view('dashboard/email_search')?>
								</div>
								<div class="tab-pane fade" id="socialaccount" role="tabpanel">
							 <?php $this->load->view('dashboard/social_search')?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<h1>
							<?php echo number_format($no_tracked)?> People Tracked
						</h1>
						<p>
							Our solutions allow you to sell more, grow, prevent fraud, and add the missing links to your contacts and lists. <b>One tool for email, phone, address, name, social and domain lookups.</b>
						</p>
					</div>
				</div>
				
				<span id="people_domains_content" style="display:none">

                </span>
			</div>
		</div>
		
		<div class="modal fade" id="dashboardModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			
			</div>
		  </div>
		</div>
		
		<?php $this->load->view('includes/footer_login')?>