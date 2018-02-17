<?php
 echo Modules::run('templates/_draw_breadcrumbs',$breadcrumbs_data);
if(isset($flash)){
  echo $flash;
} 
$symbol = $this->site_sittings->_get_symbol();
?>
<script type="text/javascript">
  var myApp = angular.module('myApp', []);
  myApp.controller('myController', ['$scope', function($scope){
      $scope.defaultPic = '<?= $angular_pics['0'] ?>';
      $scope.change = function(newPic){
        $scope.defaultPic = newPic;
      }
    }])
</script>


<div class="row" ng-controller="myController">
  <div class="col-md-1 img_angular">
    <?php 
      foreach($angular_pics as $thumbnail){ ?>
     <img ng-click="change('<?=$thumbnail ?>')" src="<?=$thumbnail ?>" alt="" width='100' >
    <?php  }

    ?>
  </div>
  <div class="col-md-4 img_angular2" >

     <a href="#" data-featherlight="{{ defaultPic }}">
       <img src="{{ defaultPic }}" alt=""  >
     </a>
  	
  </div>
  <div class="col-md-4">
    <h2><?=$item_title ?></h2>
    <h2>Our Price :<?=$symbole.number_format($item_price,2) ?></h2>

    <p><?=$item_description ?></p>
  	
  </div>
  <div class="col-md-3">
  	<?= Modules::run('cart/_draw_in_shop',$update_id) ?>
  </div>
</div>

<div class="row">
  
 <?= Modules::run('store_items/_get_recommand',$update_id); ?> 
 




 
</div>