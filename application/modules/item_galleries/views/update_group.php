<h1><?=$headline ?></h1>
<h2><?=$sub_headline ?></h2>

<?php 

if(isset($flash)){
	echo $flash;
} 

?>
 <p>
 	<a href="<?=base_url().'store_items/create/'.$parent_id; ?>">
	<button class="btn btn-default">Previous Page</button>
    </a>
    
      <!-- Button to trigger modal -->
	<a href="<?=base_url().'item_galleries/upload_image/'.$parent_id; ?>" role="button" class="btn btn-info" data-toggle="modal">Create A Galleries</a>
 </p>
  <?php 

      $web_page_url = base_url().'item_galleries/update_group/'.$parent_id;
 
 if($num_rows < 1){
 	echo 'You have not uploaded any '.$entity.' for '.$slider_title.' .';
 }else{
  ?>
  

<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white file"></i><span class="break"></span>Galleries Details</h2>
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
							      <th>Picture</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						 <?php 

						 foreach($query->result() as $row): ?>
						 	<?php 
						 
						    $delete_gallery = base_url().'item_galleries/deleteconf/'.$row->id;
                            $picture = $row->picture;
                            $picture_path = base_url().'assets/img/gallery/'.$picture;
                            
						 	?>
							<tr>
								
							    <td>
							    	 <?php if($picture!=''){ ?>
							    	<img src="<?=  $picture_path?>" alt="">
							    	  <?php } ?>
							    </td>
							
					         
								<td class="center">
									
									<a class="btn btn-danger" href="<?= $delete_gallery ?>">
										<i class="halflings-icon white trash"></i>  
									</a>
								
								</td>
							</tr>
						<?php endforeach; ?>
							
							
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
			<?php } ?>