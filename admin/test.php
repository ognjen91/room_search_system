<?php include("includes/header.php"); ?>
<?php
//	$session->check_log_status();	
		 
	?>


        <!-- Navigation -->
       <?php include("includes/navigation.php"); ?>
<!--         kraj navigacije-->


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Blank Page
                            <small>Subheading</small>
                        </h1>
                       
                        
                        
                        <?php
$connection = mysqli_connect("localhost", "root", "", "pocetna");
$query = "SELECT * FROM users WHERE username = 'Ognjen' and password='ognjen'";
$result = mysqli_query($connection, $query); 
$array = array();
//var_dump($result);
while ($row = mysqli_fetch_array($result)) {
foreach ($row as $key=>$value){
//        echo $key . "=>" . $value . "<br>";
$array[] = $key;
}  
}
var_dump($array);                    
                        ?>
                        
                        
                        
                        
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>