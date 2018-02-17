<h2><?= $headline ?></h2>
<?php
if(isset($flash)){
	echo $flash;
}
?>

<p>
	<a href="<?= base_url()?>webe_pages/create"><button type="button" class="btn btn-primary">Create Pages</button>
	</a>
</p>
<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white file"></i><span class="break"></span>CMS</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Page Url</th>
								  <th>Headline</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  	foreach ($query->result() as $row) {
						  		$edit_url = base_url().'webe_pages/create/'.$row->id;
						  		$page_url = base_url().$row->page_url;
						  	?>
							<tr>
								<td><?=$page_url ?></td>
								<td class="center"><?=$row->page_headline ?></td>
								<td class="center" span="2">
									<a class="btn btn-success" href="<?=$page_url ?>">
										<i class="halflings-icon white zoom-in"></i>  
									</a>
									<a class="btn btn-info" href="<?=$edit_url ?>">
										<i class="halflings-icon white edit"></i>  
									</a>
									
								</td>
							</tr>
							<?php } ?>
							
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
