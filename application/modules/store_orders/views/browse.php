<h1>manage Orders</h1>
<h2><?=$order_status_title; ?></h2>
<?php 

function get_customer_name($firstname,$lastname,$company){
	$firstname = trim($firstname);
		$lastname = trim($lastname);
		$company = trim($company);

		$company_length = strlen($company);
		if($company_length>2){
			$customer_name = $company;
		}else{
			$customer_name = $firstname." ".$lastname;
		}
	
	return $customer_name;
}
if(isset($flash)){
	echo $flash;
} 
?>
<?php 

 if($num_rows<1){
    echo 'In No Orders In This Order Status';
 }else{
 echo $statement; 
echo $pagination ?>
  <?php 
      $order_status_url = 'http://www.paypal.com';
  ?>
   <p><a href="<?= $order_status_url; ?>"><button type="button" class="btn btn-primary">Visit Paypal</button></a></p>

<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white tag"></i><span class="break"></span>View Orders</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable ">
						  <thead>
							  <tr>
							      <th>Order Ref</th>
							      <th>Order Gross</th>
								  <th>Date Created</th>
								  <th>Custom Name</th>
								  <th>Orders Status</th>
								  <th>Oppened</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						 <?php 
						  $this->load->module('datemade');
						  $this->load->module('site_sittings');
						  $this->load->module('datemade');

						 foreach($query->result() as $row): ?>
						 	<?php 
						    
						 	$view_item_url = base_url().'store_orders/view/'.$row->id; 
                            $firstname = $row->firstname;
                            $lastname = $row->lastname;
                            $company = $row->company;
                            $order_ref = $row->order_ref;
                            $mc_gross = $row->mc_gross;
                            $symbol = $this->site_sittings->_get_symbol();
                           
                            if(isset($row->status_title)){
                            	$order_name =  $row->status_title;
                            }else{
                             $order_name = 'Order Submited';
                            }
                            $openned = $row->openned;
                            $date_created = $this->datemade->get_nice_date($row->date_created, 'full');
                            $customer_name = get_customer_name($firstname,$lastname,$company);
                            if($openned == 1){
                               $status_label = 'success';
                               $status_desc = 'opened';
                            }else{
                               $status_label = 'important';
                               $status_desc = 'unopened';
                            }
						 	?>
							<tr>
							    <td><?= $order_ref; ?></td>
							    <td><?= $symbol.$mc_gross; ?></td>
								<td><?= $date_created; ?></td>
								<td class="center"><?= $customer_name; ?></td>
								<td class="center"><?= $order_name; ?></td>
								<td class="center">
									<span class="label label-<?= $status_label?>"><?= $status_desc?></span>
								</td>
								<td class="center">
									<a class="btn btn-success" href="<?= $view_item_url ?>">
										<i class="halflings-icon white zoom-in"></i>  
									</a>
									
								</td>
							</tr>
						<?php endforeach; ?>
							
							
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			<?php echo $pagination;
			}?>