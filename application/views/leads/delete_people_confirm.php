<div class="modal-header modal-alert-icon-close">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
							<circle class="path circle" fill="none" stroke="#D06079" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
							<line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="34.4" y1="37.9" x2="95.8" y2="92.3"/>
							<line class="path line" fill="none" stroke="#D06079" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" x1="95.8" y1="38" x2="34.4" y2="92.2"/>
						</svg>
					</div>
					<div class="modal-body text-center">
						<h2 class="mb-3">
							Are you sure?
						</h2>
						<h4 class="text-muted mb-5">
							Do you really want to delete these records? This process cannot be undone.
						</h4>
						<div class="mb-5">
						   <input type="hidden" name="move_entries_p" id="move_entries_p" value="<?php echo $entries?>">
							<button type="button" class="btn btn-secondary btn-lg" data-dismiss="modal">Cancel</button>
							<a href="javascript:void(0)" class="btn btn-danger btn-lg" id="btnProceedPeopleDelete">
								Delete
							</a>
						</div>
					</div>