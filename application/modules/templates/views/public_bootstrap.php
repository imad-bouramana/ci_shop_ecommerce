<!DOCTYPE html>
<html lang="en" <?php   
   if(isset($angularjs)){
    echo ' ng-app="myApp"';
   }
   ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= base_url()?>favicon.ico">

    <title>Jumbotron Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url()?>assets/css/bootstrap.css" rel="stylesheet"> 
    <link href="<?= base_url()?>assets/css/font-awesome.min.css" rel="stylesheet"> 
   <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?= base_url()?>assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="<?= base_url()?>assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
   

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
   



<!-- Custom Theme files -->
<link href="<?= base_url()?>assets/css/stylecw.css" rel='stylesheet' type='text/css' />  

<link href="<?= base_url()?>assets/css/megamenu.css" rel="stylesheet" type="text/css" media="all" />

<link href="<?= base_url()?>assets/css/jumbotron.css" rel="stylesheet">

     <?php  if(isset($featherlight_library)){  ?>
      <link href="<?= base_url()?>assets/css/featherlight.min.css" rel="stylesheet">
      <link href="<?= base_url()?>assets/css/featherlight.gallery.min.css" rel="stylesheet">
   <?php   }
   if(isset($angularjs)){
    echo '<script type="text/javascript"  src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.6/angular.min.js"></script>';
   } ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?= base_url()?>assets/js/jssor.slider.min.js" type="text/javascript"></script>


  </head>

  <body>



<div class="header_bg">
   <div class="container">
  <div class="header">
    <div class="head-t">
     <div class="logo">
        <a href="<?=base_url()?>"><h1>Nuevo <span>Shop</span></h1> </a>
        
      </div>
         <?php echo Modules::run('templates/_draw_top_right',$customer_id); ?>  

    <div class="clearfix"></div>  
      </div>
    <!--start-header-menu-->
    <ul class="megamenu skyblue">
      <li class="active grid"><a class="color1" href="<?=base_url()?>">Home</a></li>
     
         <?php echo Modules::run('store_categories/_draw_cat_title'); ?> 
        
            <li class="pull-right">
      
              <?php echo Modules::run('templates/_draw_top_nav'); ?>
            
            </li>
     </ul> 
  </div>
</div>
</div>


    
      <div class="container">
        <div class="row">
         <?php
           if($uri!=''){
          if($customer_id>0){
          
            include('draw_customer_details.php');
        } }?>
        <br>
          
         <?php

          echo Modules::run('sliders/_attemp_draw_slides') ?>
       
      </div>
       </div>
       <div class="container">
       
        <?php 
       
          if(isset($page_content)){
            echo nl2br($page_content);
             if(!isset($page_url)){
              $page_url = 'homepage';
             }
            if($page_url==""){
              require_once('home_page.php');
            }elseif($page_url=='contactus'){
              echo Modules::run('contactus/_draw_contact_form');
            }
          }elseif(isset($view_file)){
          
             $this->load->view($view_module.'/'.$view_file);
        
           }
          
           ?>

      </div>

      <hr>
   

   

<div class="footer-section">
    <div class="footer">
  <div class="container">
          
       
       
       <?php echo Modules::run('btm_nav/_draw_nav_link'); ?>
    
    
    
    
    
          </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?= base_url()?>assets/js/jquery.min.js"><\/script>')</script>
    <script src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?= base_url()?>assets/js/ie10-viewport-bug-workaround.js"></script>
    <?php  if(isset($featherlight_library)){  ?>
    <script src="<?= base_url()?>assets/js/featherlight.min.js"></script>
    <script src="<?= base_url()?>assets/js/featherlight.gallery.min.js"></script>

      <?php   } ?>



<!-- start menu -->

<script type="text/javascript" src="<?= base_url()?>assets/js/megamenu.js"></script>
<script>$(document).ready(function(){$(".megamenu").megamenu();});</script>
<script src="<?= base_url()?>assets/js/menu_jquery.js"></script>
<script src="<?= base_url()?>assets/js/simpleCart.min.js"> </script>
 <script src="<?= base_url()?>assets/js/ie-emulation-modes-warning.js"></script>
<!--web-fonts-->
<script type="applijegleryion/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } 
</script>
 <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,300italic,600,700' rel='stylesheet' type='text/css'>
 <link href='//fonts.googleapis.com/css?family=Roboto+Slab:300,400,700' rel='stylesheet' type='text/css'>
<!--//web-fonts-->
 <script src="<?= base_url()?>assets/js/scripts.js" type="text/javascript"></script>
<script src="<?= base_url()?>assets/js/modernizr.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/move-top.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/easing.js"></script>
<script type="text/javascript" src="<?= base_url()?>assets/js/jssor.slider.min.js"></script>




<!--/script-->
<script type="text/javascript">
      jQuery(document).ready(function($) {
        $(".scroll").click(function(event){   
          event.preventDefault();
          $('html,body').animate({scrollTop:$(this.hash).offset().top},900);
        });
      });
     
</script>
 

</body>
</html>
