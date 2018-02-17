<h1>The Blog</h1>
<?php 
$this->load->module('datemade');
foreach ($query->result() as $row) {
	$edit_url = base_url().'blog/create/'.$row->id;
	$blog_url = base_url().'blog/article/'.$row->blog_url;
	$date_created = $this->datemade->get_nice_date($row->date_created, 'mini');
	$picture = $row->picture;
	$path_thumb = str_replace(".", '_thumb.', $picture);
	$picture_path = base_url().'assets/img/picture/'.$path_thumb;
	$string = word_limiter($row->blog_content, 35);

?>
<div class="row">
	<div class="col-md-3">
		<img src="<?=$picture_path ?>" alt="" class="img-responsive img-thumbnail">
	</div>
	<div class="col-md-9">
		<h3><a href="<?=$blog_url  ?>"><?=$row->blog_title ?></a></h3>
		<p><b><?=$row->author ?></b> - <?=$date_created ?></p>
		<p><?=$string ?></p>
	</div>

</div>
	
<?php
}
?>