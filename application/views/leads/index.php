<?php $this->load->view('includes/header_login')?>
		<?php $this->load->view('includes/navigation_login')?>
		<style>
		.table td, .table th {
			font-size: 12px !important;
		}
		</style>
		<div class="section-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12 py-5">
						<div class="card">
							<div class="card-header">
								<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#people" role="tab">
											People
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#domains" role="tab">
											Domains
										</a>
									</li>
								</ul>
							</div>
							<div class="card-body">
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="people" role="tabpanel">
									   <?php if ($import_success!=''):?>
									    <div class="form-group" id="peopleTableSuccess">
											<div class="alert alert-success" role="alert">
											<?php echo $import_success ?>
											</div>
									     </div>
									    <?php endif?> 
					                     
					                   <?php if ($import_error!=''):?>
					                     <div class="form-group" id="peopletableError">
							                  <div class="alert alert-danger" role="alert">
							                  	<?php echo $import_error?>
							                  </div>
					                     </div> 
					                   <?php endif?>
					                     
					                     
										<?php $this->load->view('leads/people_index')?>
									</div>
									<div class="tab-pane fade" id="domains" role="tabpanel">
									   <?php $this->load->view('domains/domain_index')?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function(){
				setTimeout(function(){ $('#peopleTableSuccess').hide();}, 10000);
				setTimeout(function(){ $('#peopletableError').hide();}, 10000);
			});
		</script>
		
		
		<?php $this->load->view('includes/footer_login')?>				