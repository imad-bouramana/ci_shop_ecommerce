<div class="row-fluid">
				
	<div class="span12 statbox purple" onTablet="span6" onDesktop="span12">
		<div class="span4">
			<img src="<?=base_url() ?>assets/img/gallery/paypal.png" class="img-responsive" alt="">
		</div>
		<div class="span8">
		  <h2>FEEDBACK FROM PAYPAL</h2>
		  <p>
		  	<b>Transmission Date :</b> <?=$date_created ?><br>
		  	<b>Payment Status :</b> <?=$payment_status ?><br>
		  	<b>Transaction ID :</b> <?=$txn_id ?><br>
            <b>Payment Gross :</b> <?=$mc_gross ?><br>
            <b>Payer ID :</b> <?=$payer_id ?><br>
            <b>Payer Email :</b> <?= $payer_email?><br>
            <b>Payer Status :</b> <?=$payer_status ?><br>
            <b>Payment Date :</b> <?=$payment_date ?><br>
            <!--  Payer detais  -->
            <b>Payer's Name :</b> <?=$first_name.' '.$last_name ?><br>
            <b>Payer's Company :</b> <?=$payer_business_name ?><br>
		  	<b>Adress Line 1 :</b> <?=$address_name ?><br>
		  	<b>Adress Line 2 :</b> <?=$address_street ?><br>
		  	<b>City :</b> <?=$address_city ?><br>
		  	<b>State :</b> <?=$address_state ?><br>
		  	<b>Postcode/Zip :</b> <?=$address_zip ?><br>
		  	<b>Country :</b> <?=$address_country ?><br>
		  </p>
	    </div>
		<div class="footer">
			<a href="http://www.paypal.com"> Check Paypal For More Info </a>
		</div>	
	</div>
</div>