<h1>Contact Us</h1>
<?php echo validation_errors("<div style='color: red;margin: 10px 0'>","</div>"); 
$form_location = base_url().'contactus/submit';?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="well well-sm">
                <form action="<?=$form_location ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group name">
                            <label for="name">
                                Yourname</label>
                            <input type="text" name="firstname"  class="form-control" id="name" placeholder="Enter name"  />
                        </div>
                        <div class="form-group">
                            <label for="name">
                                Yourname</label>
                            <input type="text" name="yourname" value="<?=$yourname ?>" class="form-control" id="name" placeholder="Enter name"  />
                        </div>
                        <div class="form-group">
                            <label for="email">
                                Email Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email" name="email" value="<?=$email ?>" class="form-control" id="email" placeholder="Enter email"  /></div>
                        </div>
                        <div class="form-group">
                            <label for="telenum">
                                Telephone</label>
                           <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span>
                                </span>
                                <input type="text" name="telenum" value="<?=$telenum ?>" class="form-control" id="telenum" placeholder="Enter telephone"  /></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="message">
                                Message</label>
                            <textarea name="message" id="message" class="form-control" rows="9" cols="25"
                                placeholder="Message"><?=$message ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" name="submit" value="Submit" class="btn btn-primary pull-right">
                            Send Message</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <form>
            <legend><span class="glyphicon glyphicon-globe"></span> Our office</legend>
            <address>
                <strong><?=$company ?></strong><br>
                <?=$adress ?><br>
                <abbr title="Phone">
                    P:</abbr>
                <?=$telephone ?>
            </address>
            <address>
                <strong>Telephone</strong><br>
                <?=$telephone ?>
            </address>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="map-responsive">
            <?=$map_code ?>
            </div>
        </div>
    </div>
</div>
