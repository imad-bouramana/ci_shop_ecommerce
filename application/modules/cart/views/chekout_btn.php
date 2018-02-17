<h2>Would You Create A Acount </h2>
<p>You Not Need To Create A Acout With Us </p>
<p>If You Do You Can Enjoy </p>
<p>
	<ul>
		<li>Order Tracking</li>
		<li>Dounloadable Form Orders</li>
		<li>Priority Tychnical Support</li>

	</ul>
</p>
<p>Youl  You Create An Acount ?</p>
<?php echo form_open('cart/submit_checkout'); ?>
<button class="btn btn-success"  name="submit" type="submit" value="Yes Create One">
	<span class="glyphicon glyphicon-thumbs-up"></span>
		Yes Create One
	</button>
	<button class="btn btn-danger" name="submit" type="submit" value="No Thanks">
		<span class="glyphicon glyphicon-thumbs-down"></span>
		No Thanks
</button>
<a href="<?=base_url() ?>your_account/login">
	<button class="btn btn-primary" name="submit" type="button" >
		<span class="glyphicon glyphicon-log-in"></span>
		Already Member (login)
</button>
</a>

<?php 
echo form_hidden('chekout_token', $chekout_token);
echo form_close();