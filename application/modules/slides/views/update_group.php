<h1><?=$headline ?></h1>
<?php 

if(isset($flash)){
	echo $flash;
} 

?>
  <?php 
      $web_page_url = base_url().'slides/update_group/'.$parent_id;
 echo Modules::run('slides/_draw_modal', $parent_id);
 if($num_rows < 1){
 	echo 'You have not uploaded any '.$entity.' for '.$slider_title.' .';
 }else{
  ?>
  

<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white file"></i><span class="break"></span>Slides Details</h2>
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
						 	$edit_page_url = base_url().'slides/view/'.$row->id; 
						 	$target_url = $row->target_url;
						 	if($target_url !=''){
						      $view_page_url = $target_url;      
						 	}
                            $picture = $row->picture;
                            $picture_path = base_url().'assets/img/carouse/'.$picture;
                            
						 	?>
							<tr>
								
							    <td>
							    	 <?php if($picture!=''){ ?>
							    	<img src="<?=  $picture_path?>" alt="">
							    	  <?php } ?>
							    </td>
							
					         
								<td class="center">
									<?php if(isset($view_page_url)){ ?>
									<a class="btn btn-success" href="<?= $view_page_url ?>">
										<i class="halflings-icon white zoom-in"></i>  
									</a>
									<?php } ?> 
									<a class="btn btn-info" href="<?= $edit_page_url ?>">
										<i class="halflings-icon white edit"></i>  
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