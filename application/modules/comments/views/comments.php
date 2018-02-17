<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white envelope"></i><span class="break"></span>Message Details</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
							<?php 
							$this->load->module('datemade');
							foreach ($query->result() as $row) { 
								$date_published = $this->datemade->get_nice_date($row->date_created, 'full');
								 ?>
								 <tr>
								 	<td><span class="enquires">Date Published : </span><?=$date_published ?></td>
								 </tr>
								<tr>
									
									<td><span class="enquires">Message : </span> 
										<?php 
										echo nl2br($row->comment);
										?>
									</td>
								</tr>
							<?php
						     }
							?>
						</table>
					</div>
				</div>


</div>

