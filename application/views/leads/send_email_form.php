<div class="modal-header">
    	<h5 class="modal-title" id="exampleModalLabel">Send Email</h5>
                
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			   <div class="modal-body">
					<div class="form-group d-none" id="peopleModalError">
							<div class="alert alert-danger" role="alert">
							</div>
					</div>
					<div class="form-group d-none" id="peopleModalSuccess">
							<div class="alert alert-success" role="alert">
							</div>
					</div>
						
					<div class="form-group">
					 	<label>Subject</label>
					 	<input type="text" class="form-control" id="mail_subject" name="mail_subject" value="">
					</div>					
					<div class="form-group">
					 	<label>From Name</label>
					 	<input type="text" class="form-control" id="mail_from_name" name="mail_from_name" value="<?php echo $from_name?>">
					</div>					
					<div class="form-group">
					 	<label>From Email</label>
					 	<input type="text" class="form-control" id="mail_from_email" name="mail_from_email" value="<?php echo $from_email?>">
					</div>
					<div class="form-group">
					 	<label>Message</label>
					 	<textarea class="form-control mb-2 form-control-lg" name="mail_message" id="mail_message" rows="3"></textarea>
					</div>
					
			  </div>
			  <div class="modal-footer">
			  <input type="hidden" name="move_entries_p" id="move_entries_p" value="<?php echo $entries?>">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button class="btn btn-primary" id="btnSendLeadsMail">Submit</button>
			  </div>
			