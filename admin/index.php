<?php include("includes/header.php"); ?>

        <!-- Navigation -->
   <?php include("includes/navigation.php"); ?>
<!--            Kraj navigacije-->

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="addFacility"><a href="additional_pages/add_facility.php">+ DODAJTE NOVI OBJEKAT</a></div>
                        <h3 class="page-header">
                            <small>Zdravo, <?php echo $user->username(); ?>. Dobrodošli u Admin panel. Odaberite objekat koji želite da modifikujete, ili dodajte novi objekat.</small>
                        </h3>
                        
                        
                        <ol class="breadcrumb">
                            
            <h2>Vaši objekti:</h2>                
                           
                            
                 <div class="facilities_listed">  
                      <?php
                   foreach($facility->users_facilities() as $fac){ ?>
                            
                          
 <div class="facility_listed">                      
 <a href="additional_pages/edit_facility.php?facility=<?php echo $fac->facility_name; ?>&owner=<?php echo $user->username();?>">        
          <h5 class="fac-name">        <?php    echo $fac->facility_name; ?></h5> 
                     
           <img src="<?php echo SITE_ADRESS . DS. "images" .DS . "fac-profiles" . DS . $fac->profile_image; ?>">                
                            </a>       
                           </div> 
                     
                     <?php  } ?>
                          </div>   
                          
                           
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>