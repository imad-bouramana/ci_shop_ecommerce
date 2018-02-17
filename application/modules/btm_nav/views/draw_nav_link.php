   <div class="col-md-4 footer-four">
           <h5>Contact Us</h5>
           <p>Feel free to reach us</p>
             <div class="foot-address">
              <ul>
                    <li><i class="fa fa-map-marker"></i>350 Avenue, India, Delhi 110001 </li>
                    <li><i class="fa fa-envelope-o"></i>info@mailme.com </li>
                    <li><i class="fa fa-phone"></i>+91-xxx-xxx-2040 </li>
                    
                  </ul>
                 </div> 
        </div>
		 <div class="col-md-3 footer-two">
		           <h5>Quick Links</h5>
		              <ul>	<?php  
			foreach($query->result() as $row){
				$page_url = $row->page_url;
				$page_title = $row->page_title;
				?>
				<li><a href="<?=base_url().$page_url ?>"> <?= $page_title?></a> </li>
				<?php
		    
			}
			

			?>
			 </ul>
		</div>

    <div class="clearfix"></div>
  </div>
</div>

</div>
<div class="footer-bottom">
        <div class="container">
          <div class="row">
            <div class="col-sm-6 ">
              <div class="copyright-text">
                <p>CopyRight © 2017 Digital All Rights Reserved</p>
              </div>
            </div> <!-- End Col -->
            <div class="col-sm-6  ">
                <div class="copyright-text pull-right">
                <p> <?php  
			foreach($query->result() as $row){
				$page_url = $row->page_url;
				$page_title = $row->page_title;
				?>
				<a href="<?=base_url().$page_url ?>"> <?= $page_title?></a> |
				<?php
		    
			}
			

			?>
                	
                </p>
              </div>          
                          
            </div> <!-- End Col -->