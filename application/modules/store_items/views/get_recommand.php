<?php 
if ($num_rows>0){ ?>
<h1>Our Recommand</h1>

   <script src="<?= base_url()?>assets/js/jssor.slider.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jssor_1_slider_init = function() {

            var jssor_1_options = {
              $AutoPlay: 1,
              $Idle: 0,
              $SlideDuration: 5000,
              $SlideEasing: $Jease$.$Linear,
              $PauseOnHover: 4,
              $SlideWidth: 140,
              $Cols: 7
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 980;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                    jssor_1_slider.$ScaleWidth(expectedWidth);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
    </script>
    <style>
        /* jssor slider loading skin spin css */
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

    </style>

 <div id="jssor_1" style="position:relative;margin:20px auto;top:0px;left:0px;width:980px;height:250px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="../svg/loading/static-svg/spin.svg" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:200px;overflow:hidden;">



 <?php  
      
   foreach($query->result() as $row_sld) {
       $target_url = $row_sld->item_url;
       $picture_path = base_url().'assets/img/small_pic/'.$row_sld->small_pic;
       $img_text = $row_sld->item_title;
         
     ?>



            <div>
            	<a href="<?=$target_url ?>">
                <img data-u="image" src="<?=$picture_path ?>" title="<?=$img_text ?>"/>
            </a>
            </div>
              
            <?php 
         } ?>
           <!--  <div style="background-color:#ff7c28;">
                <div style="position:absolute;top:-3px;left:-4px;width:150px;height:62px;z-index:0;font-size:12px;color:#000000;line-height:24px;text-align:left;padding:5px;box-sizing:border-box;">
                </div>
            </div> -->
        </div>
    </div>
   

    <?php } ?>
     <script type="text/javascript">jssor_1_slider_init();</script>