<h1><?= $headline?></h1>
<?php echo validation_errors("<div style='color: red;margin: 10px 0'>","</div>"); ?>
<?php 
if(isset($flash)){
	echo $flash;
} 
?>
<?php $form_url = current_url();
			?>
			
<form action="<?php echo $form_url;?>" method="POST" class="form-horizontal">
  <?php if($code==''){ ?>
  <div class="form-group">
    <label for="exampleInputsubject">Subject : </label>
    <input type="text" class="form-control" id="exampleInputsubject" placeholder="Subject" name="subject" value="<?php echo $subject?>">
  </div>
  <?php }else{
    echo form_hidden('subject',$subject);
  } ?>
  <div class="form-group">
    <label for="exampleInputmessage">Message : </label>
    <textarea name="message" class="form-control" id="exampleInputmessage" rows="6"  ><?php echo $message; ?></textarea>
  </div>
  
  <div class="checkbox">
    <label>
      <input type="checkbox" name="urgent" value="1" 
      <?php if($urgent==1){
      	echo ' checked';
      } ?>> Urgent
    </label>
  </div>
    <button type="submit" class="btn btn-primary" name="submit" value="Submit">Create Message</button>
	<button type="submit" class="btn" name="submit" value="Cancel">Cancel</button>
  <?php 
  echo form_hidden('token',$token);
  ?>
</form>