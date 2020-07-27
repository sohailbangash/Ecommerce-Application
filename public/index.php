<?php  require_once('../resources/config.php'); ?>
<?php  include(TEMPLATES_FRONT. DS . "header.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

          <!-- Hear categories -->
          <?php  include(TEMPLATES_FRONT. DS . "side_nav.php"); ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                         <!-- Hear slidershow -->
                         <?php  include(TEMPLATES_FRONT. DS . "slider.php"); ?>

                  
                    </div>

                </div>
         
                <div class="row">

                    <?php get_products();  ?>
          
                </div> 
                <!-- Row end here -->
            </div>

        </div>

    </div>
    <!-- /.container -->

  <?php include(TEMPLATES_FRONT . DS . "footer.php" );?>
