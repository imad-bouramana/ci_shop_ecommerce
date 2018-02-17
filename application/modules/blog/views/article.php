<h1>The Blog</h1>
<?php 
$this->load->module('datemade');
foreach ($query->result() as $row) {
	$edit_url = base_url().'blog/create/'.$row->id;
	$blog_url = base_url().'blog/article/'.$row->blog_url;
	$date_created = $this->datemade->get_nice_date($row->date_created, 'mini');
	$picture = $row->picture;
	$picture_path = base_url().'assets/img/picture/'.$picture;
	

?>
<div class="row">
	<div class="col-md-5">
		<img src="<?=$picture_path ?>" alt="" class="img-responsive img-thumbnail">
	</div>
	<div class="col-md-7">
		<h3><a href="<?=$blog_url  ?>"><?=$row->blog_title ?></a></h3>
		<p><b><?=$row->author ?></b> - <?=$date_created ?></p>
		<p><?=$row->blog_content ?></p>
	</div>

</div>
	
<?php
}
?>