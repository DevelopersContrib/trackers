<script>
$('#table-reldomain').dataTable();
</script>
<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $owner_name?> Domains</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			   <div class="modal-body">
					<div class="row">
					   <div class="col-md-12">
												<div class="m-3">
												     <div class="row">
													
												   </div>
												   <div class="form-group d-none" id="rdomainTableError">
														<div class="alert alert-danger" role="alert">
														     
														</div>
													</div>
													<div class="form-group d-none" id="rdomainTableSuccess">
														<div class="alert alert-success" role="alert">
														     
														</div>
													</div>
												   <div class="table-responsive">
													   <table id="table-reldomain" class="table table-striped table-bordered table-result-custom">
													      <thead>
															<tr>
															   	<th><input type="checkbox" id="checkallreldomain" class="checkallreldomain"></th>
																<th>Domain</th>
															</tr>
														</thead>	
														<tbody>
											           <?php if (count($domains)>0):?>
											           	<?php foreach ($domains as $domain):?>
											           	   <tr>
											           	     <td><input type="checkbox" id="dombox" name="dombox" value="<?php echo $domain?>"></td>
											           	     <td><?php echo $domain?></td>
											           	   </tr>
											           	<?php endforeach;?>
											           <?php endif?>
											          </tbody>
													   </table>
												   </div>
												</div>
							</div>
					</div>						
					
			  </div>
			  <div class="modal-footer">
			  <input type="hidden" name="modal_reldom_count" id="modal_reldom_count" value="<?php echo $count?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="btnAddReldomains">Submit</button>
			  </div>
			