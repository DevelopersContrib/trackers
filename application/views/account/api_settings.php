<?php $this->load->view('includes/header_login')?>
		<?php $this->load->view('includes/navigation_login')?>
		<div class="section-1">
			<div class="container">
				<div class="row">
					<div class="col-md-12 py-5 text-settings">
					   
		                 <?php if ($query->num_rows() > 0):?>  
		                 	  <?php $this->load->view('account/api_form_exist',array('api_key'=>$query->row()->api_key))?>
		                 	<?php else:?>
		                 	  <?php $this->load->view('account/api_form_new')?>
		                 <?php endif?>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('includes/footer_login')?>					