<h1><?=$headline ?></h1>
<?php echo validation_errors("<div class='alert alert-danger'>","</div>"); ?>
<?php $form_location = base_url().'your_account/submit'; ?>

<div class="col-md-4 col-md-offset-4" style="margin-top:50px;">
<form id="signupform" class="form-horizontal" role="form" class="col-md-6 col-md-offset-3" action="<?=$form_location  ?>" method="post">
    <div id="signupalert" style="display:none" class="alert alert-danger">
        <p>Error:</p>
        <span></span>
    </div>
    <div style="margin-bottom: 25px" class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <input type="text" class="form-control" name="username" value="<?= $username?>" placeholder="username">
        <input type="text" class="form-control" name="firstname" value="<?=$firstname ?>" placeholder="firstname">
    </div>
    <div style="margin-bottom: 25px" class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        <input type="text" class="form-control" name="email" value="<?=$email ?>" placeholder="Email">
    </div>

    

    <div style="margin-bottom: 25px" class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
        <input type="password" class="form-control" name="password" value="<?= $password?>" placeholder="Password">
        <input type="password" class="form-control" name="confirm_password" value="<?=$confirm_password ?>" placeholder="Confirm Password">
    </div>

    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-3">
            <button id="btn-signup" type="submit" name="submit" value="Submit" class="btn btn-default"><i class="icon-hand-right"></i>Sign Up</button>
        </div>
        
    </div>
</form>
</div>
