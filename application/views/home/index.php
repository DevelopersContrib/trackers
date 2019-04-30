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
									<a class="nav-link" data-toggle="tab" href="#socialaccount" role="tab" aria-selected="false">SOCIAL ACCOUNT</a>
								</li>
							</ul>
							<div class="tab-content tab-content-custom-form" id="myTabContent">
								<div class="tab-pane fade show active" id="website" role="tabpanel">
									<div class="pt-3 pr-3 pl-3 pb-4" id="formWebsite">
									  <div class="row">
											<div class="col-md-10">
												<label class="sr-only" for="inlineFormInputName2">Domain</label>
												<input type="text" class="form-control mb-2 mr-sm-2 form-control-lg" id="searchWebsite" placeholder="Domain">
												<small class="text-danger d-none" id="form_error_website">
							                    </small>
											</div>
											<div class="col-md-2">
												<button type="submit" class="btn btn-primary btn-block mb-2 btn-lg" id="btnSearchWebsite">Submit</button>
											</div>
										</div>
									</div>
									<div class="row d-none" id="resultWebsite">
									<script>
													$(document).ready(function(){
														$('#table-website').DataTable();
													});
												</script>
										<div class="col-md-12 ">
												<div class="m-3">
												    <button type="submit" class="btn btn-info mb-2 btn-lg" id="btnNewSearchWebsite">Track New Domain</button>
													<h4 class="mb-4" id="resultWebsiteH">
												   </h4>
												     <div class="form-group d-none" id="info-notif-website">
														<div class="alert alert-info" role="alert">
															Please <a href="/signup">signup</a> to enjoy unlimited searches, create campaigns and save leads.
														</div>
							                       </div>
												   <table id="table-website" class="table table-striped table-bordered table-result-custom">
												      <thead>
														<tr>
														   <th>Domain</th>
														   <th>Value</th>
														   <th>Owner</th>
														   <th>Owner Email</th>
														   <th>Phone</th> 
														   <th>Expire Date</th>
														   <th>Registrar</th>
														</tr>
													</thead>	
													<tbody>
													  	<tr>
													  	  <td id="tdwdomain"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														  <td id="tdwvalue"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdwowner"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdwemail"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdwphone"><i class="fa fa-spinner fa-spin fa-fw"></i></td> 
														   <td id="tdwexpire"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdwregistrar"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
													  	</tr>
													</tbody>
												   </table>
												</div>
										</div>
									</div>
								</div>
								
								<div class="tab-pane fade" id="name" role="tabpanel">
									<div class="pt-3 pr-3 pl-3 pb-4" id="formName">
										<div class="row">
											<div class="col-md-10">
												<label class="sr-only" for="inlineFormInputName2">Name</label>
												<input type="text" class="form-control mb-2 mr-sm-2 form-control-lg" id="searchName" placeholder="Name">
												<small class="text-danger d-none" id="form_error_name">
							                    </small>
											</div>
											<div class="col-md-2">
												<button type="submit" class="btn btn-primary btn-block mb-2 btn-lg" id="btnSearchName">Submit</button>
											</div>
										</div>
									</div>
									<div class="row d-none" id="resultName">
										<script>
													$(document).ready(function(){
														$('#table-name').DataTable();
													});
										</script>
										<div class="col-md-12">
												<div class="m-3">
												    <button type="submit" class="btn btn-info mb-2 btn-lg" id="btnNewSearchName" >Track New Name</button>
													<h4 class="mb-4" id="resultNameH">
												   </h4>
												   <div class="form-group d-none" id="info-notif-name">
													<div class="alert alert-info" role="alert">
														Please <a href="/signup">signup</a> to enjoy unlimited searches, create campaigns and save leads.
													</div>
							            		  </div>
												   <table id="table-name" class="table table-striped table-bordered table-result-custom">
												      <thead>
														<tr>
														   <th>Name</th>
														   <th>Email</th>
														   <th>Address</th>
														   <th>Phone Number</th>
														   <th>Company</th> 
														   <th>Notes</th>
														   <th>Social Accounts</th>
														</tr>
													</thead>	
													<tbody>
													  	<tr>
													  	  <td id="tdnname"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														  <td id="tdnemail"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdnaddress"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdnphone"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdncompany"><i class="fa fa-spinner fa-spin fa-fw"></i></td> 
														   <td id="tdnnotes"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdnsocial"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
													  	</tr>
													</tbody>
												   </table>
												</div>
										</div>
										
									</div>
								</div>
								
								<div class="tab-pane fade" id="email" role="tabpanel">
									<div class="pt-3 pr-3 pl-3 pb-4" id="formEmail">
									   <div class="row">
											<div class="col-md-10">
												<label class="sr-only" for="inlineFormInputName2">Email</label>
												<input type="text" class="form-control mb-2 mr-sm-2 form-control-lg" id="searchEmail" placeholder="Email">
												<small class="text-danger d-none" id="form_error_email">
							                    </small>
											</div>
											<div class="col-md-2">
												<button type="submit" class="btn btn-primary btn-block mb-2 btn-lg" id="btnSearchEmail">Submit</button>
											</div>
										</div>
									</div>
									<div class="row d-none" id="resultEmail">
											<script>
													$(document).ready(function(){
														$('#table-email').DataTable();
													});
												</script>
										<div class="col-md-12 ">
												<div class="m-3">
												    <button type="submit" class="btn btn-info mb-2 btn-lg" id="btnNewSearchEmail" >Track New Email</button>
													<h4 class="mb-4" id="resultEmailH">
												   </h4>
												   <div class="form-group d-none" id="info-notif-email">
													<div class="alert alert-info" role="alert">
														Please <a href="/signup">signup</a> to enjoy unlimited searches, create campaigns and save leads.
													</div>
							                     </div>
												   <table id="table-email" class="table table-striped table-bordered table-result-custom">
												      <thead>
														<tr>
														  
														   <th>Email</th>
														   <th>Name</th>
														   <th>Address</th>
														   <th>Phone Number</th>
														   <th>Company</th> 
														   <th>Notes</th>
														   <th>Social Accounts</th>
														</tr>
													</thead>	
													<tbody>
													  	<tr>
													  	   <td id="tdeemail"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
													  	   <td id="tdename"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdeaddress"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdephone"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdecompany"><i class="fa fa-spinner fa-spin fa-fw"></i></td> 
														   <td id="tdenotes"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdesocial"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
													  	</tr>
													</tbody>
												   </table>
												</div>
										</div>	
									</div>
								</div>
								<div class="tab-pane fade" id="socialaccount" role="tabpanel">
									<div class="pt-3 pr-3 pl-3 pb-4" id="formSocial">
										<div class="row">
											<div class="col-md-10">
												<label class="sr-only" for="inlineFormInputName2">Profile Url</label>
												<input type="text" class="form-control mb-2 mr-sm-2 form-control-lg" id="searchSocial" placeholder="Profile Url">
												<small class="text-danger d-none" id="form_error_social">
							                    </small>
											</div>
											<div class="col-md-2">
												<button type="submit" class="btn btn-primary btn-block mb-2 btn-lg" id="btnSearchSocial">Submit</button>
											</div>
										</div>
									</div>
									<div class="row d-none" id="resultSocial">
										<script>
													$(document).ready(function(){
														$('#table-social').DataTable();
													});
												</script>
										<div class="col-md-12 ">
												<div class="m-3">
												    <button type="submit" class="btn btn-info mb-2 btn-lg" id="btnNewSearchSocial" >Track New Social</button>
													<h4 class="mb-4" id="resultSocialH">
												   </h4>
												   	<div class="form-group d-none" id="info-notif-social">
											<div class="alert alert-info" role="alert">
												Please <a href="/signup">signup</a> to enjoy unlimited searches, create campaigns and save leads.
											</div>
							            </div>
												   <table id="table-social" class="table table-striped table-bordered table-result-custom">
												      <thead>
														<tr>
														   <th>Social Accounts</th>
														   <th>Email</th>
														   <th>Name</th>
														   <th>Address</th>
														   <th>Phone Number</th>
														   <th>Company</th> 
														   <th>Notes</th>
														</tr>
													</thead>	
													<tbody>
													  	<tr>
													  	   <td id="tdssocial"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
													  	   <td id="tdsemail"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
													  	   <td id="tdsname"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdsaddress"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdsphone"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
														   <td id="tdscompany"><i class="fa fa-spinner fa-spin fa-fw"></i></td> 
														   <td id="tdsnotes"><i class="fa fa-spinner fa-spin fa-fw"></i></td>
													  	</tr>
													</tbody>
												   </table>
												</div>
										</div>	
									</div>
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
			</div>
		</div>
		<input type="hidden" id="user_ip" value="<?php echo $_SERVER['REMOTE_ADDR']?>">
	<script src="/assets/js/home/search.js"></script>	
	<?php $this->load->view('includes/footer')?>	