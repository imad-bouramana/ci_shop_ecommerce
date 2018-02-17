<h2><?= $headline ?></h2>
<?php
if(isset($flash)){
	echo $flash;
}
?>

<p>
	<a href="<?= base_url()?>blog/create"><button type="button" class="btn btn-primary">Create Blog Entry</button>
	</a>
</p>
<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon white file"></i><span class="break"></span>Blog</h2>
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
							  	  <th>Picture</th>
								  <th>Author</th>
								  <th>Blog Entry Url</th>
								  <th>Blog Title</th>
								  <th>Date Published</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  	<?php 
						  	$this->load->module('datemade');
						  	foreach ($query->result() as $row) {
						  		$edit_url = base_url().'blog/create/'.$row->id;
						  		$blog_url = base_url().$row->blog_url;
						  		$data_created = $this->datemade->get_nice_date($row->date_created, 'mini');
						  		$picture = $row->picture;
						  		$path_thumb = str_replace(".", '_thumb.', $picture);
						  		$picture_path = base_url().'assets/img/picture/'.$path_thumb;
						  	?>
							<tr>
								<td><img src="<?=$picture_path ?>" alt=""></td>
								<td><?=$row->author ?></td>
								<td><?=$blog_url ?></td>
								<td class="center"><?=$row->blog_title ?></td>
								<td><?=$data_created ?></td>
								<td class="center" span="2">
									<a class="btn btn-success" href="<?=$blog_url ?>">
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
