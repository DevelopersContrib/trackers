<option value=""></option>
								                <?php 
								                if ($campaigns->num_rows() > 0){
								                	  foreach ($campaigns->result() as $row){
								                ?>
								                     <option value="<?php echo $row->id?>"> <?php echo $row->campaign_name?></option>
								                <?php 
								                    }
								                 }
?>