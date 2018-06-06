<?php include("includes/header.php"); ?>
 


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
  <h2>Dobrodošli! Molimo, ulogujte se.</h2>                     
<form method="POST" action="" >
  Username:<br>
  <input type="text" name="username">
  <br>
  Password:<br>
  <input type="password" name="password">
  <br><br>
  <input type="submit" value="Submit" name="login_submit">
</form> 
   <?php


              
                        
  $user->submit_login_form();                    
                        
                     
                        
                        
                        
  

?>  
 <div class="go_to_register">
        <h4><a href="<?php echo Go_to::to_user_create_page(); ?>">REGISTRACIJA NOVOG KORISNIKA</a></h4>
                        
                        
                        </div>              
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


</body>

</html>



