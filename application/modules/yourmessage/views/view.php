<div class="row">	
	<div class="col-md-8">
		<p><span class="enquires">Message Sent : </span><?=$date_created ?></p>
		<p>
			<a href="<?= base_url()?>yourmessage/create/<?= $code?>"><button type="button" class="btn btn-default">Reply</button>
			</a>
		</p>
				<h3><span class="enquires">Subject : </span><?=$subject ?></h3>
		<p><span class="enquires">Message  : </span><?=$message ?></p>
	</div>
</div>
