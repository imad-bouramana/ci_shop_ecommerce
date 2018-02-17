<?php 
$first_bit = $this->uri->segment(1);
$third_bit = $this->uri->segment(3);
if($third_bit!=""){
	$start_of_target_url = "../../";
}else{
	$start_of_target_url = "../";
}


?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

		$('#sortlist').sortable({
			stop: function(event, ui){saveChanges();}
		});
		$('#sortlist').desableSelection();
	});

	function saveChanges(){
		var $num = $('#sortlist > li').size();
		$datastring = "number=" +$num;
		for($x=1;$x<=$num;$x++){
			 var $catid = $('#sortlist li:nth-child('+$x+')').attr('id');
			 $datastring = $datastring + "&order" +$x+"="+$catid;
		} $	.ajax({
			type: "POST",
			url: "<?php echo $start_of_target_url.$first_bit; ?>/sort",
			data: $datastring
		});
		return false;
	}
</script>