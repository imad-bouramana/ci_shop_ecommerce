<h1>Your Orders</h1>
<?php  if($num_rows < 1){
	echo "<h3>You Has No Order To show Here</h3>";
}else{ ?>
<h4><?= $statement; ?></h4>
<h4><?= $pagination; ?></h4>

<table class="table table-striped table-bordered bootstrap-datatable ">
						  <thead>
							  <tr>
							      <th>Order Ref</th>
							      <th>Order Gross</th>
								  <th>Date Created</th>
								  <th>Orders Status</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						 <?php 
						  $this->load->module('datemade');
						  $this->load->module('site_sittings');

						 foreach($query->result() as $row): ?>
						 	<?php 
						    $order_ref = $row->order_ref;
						 	$view_item_url = base_url().'yourorders/view/'.$order_ref; 

                            $mc_gross = $row->mc_gross;
                            $order_name = $row->order_status;
                            $order_title = $order_status_name[$order_name];
                          
                            $date_created = $this->datemade->get_nice_date($row->date_created, 'full');
                            $sybmole = $this->site_sittings->_get_symbol();
                            
						 	?>
							<tr>
							    <td><?= $order_ref; ?></td>
							    <td><?= $sybmole.$mc_gross; ?></td>
								<td><?= $date_created; ?></td>
					        
								<td class="center"><?=$order_title ?></td>
								<td class="center">
									<a class="btn btn-default" href="<?= $view_item_url ?>">
										<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> view
									</a>
									
								</td>
							</tr>
						<?php endforeach; ?>
							
							
							
						  </tbody>
					  </table>            
  <h4><?= $pagination; ?></h4>
  <?php } ?>