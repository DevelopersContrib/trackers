<div class="modal-header">
    	<h5 class="modal-title" id="exampleModalLabel">Send Email</h5>
                
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			   <div class="modal-body">
					<div class="form-group d-none" id="domainModalError">
							<div class="alert alert-danger" role="alert">
							</div>
					</div>
					<div class="form-group d-none" id="domainModalSuccess">
							<div class="alert alert-success" role="alert">
							</div>
					</div>
						
					<div class="form-group">
					 	<label>Subject</label>
					 	<input type="text" class="form-control" id="mail_subject_d" name="mail_subject_d" value="">
					</div>					
					<div class="form-group">
					 	<label>From Name</label>
					 	<input type="text" class="form-control" id="mail_from_name_d" name="mail_from_name_d" value="<?php echo $from_name?>">
					</div>					
					<div class="form-group">
					 	<label>From Email</label>
					 	<input type="text" class="form-control" id="mail_from_email_d" name="mail_from_email_d" value="<?php echo $from_email?>">
					</div>
					<div class="form-group">
					 	<label>Message</label>
					 	<textarea class="form-control mb-2 form-control-lg" name="mail_message_d" id="mail_message_d" rows="3"></textarea>
					</div>
					
			  </div>
			  <div class="modal-footer">
			  <input type="hidden" name="move_entries_d" id="move_entries_d" value="<?php echo $entries?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="btnSendDomainMail">Submit</button>
			  </div>
			