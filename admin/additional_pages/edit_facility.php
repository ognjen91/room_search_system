<?php include("../includes/header.php"); ?>



<?php 
$active_fac=$facility->facility_for_edit();
//var_dump($active_fac);
$_SESSION['active_fac'] = $active_fac->facility_name; 
//var_dump($_SESSION['active_fac']);
?>

<div class="ef_big_img_wrap">
<div class="ef_close">X</div>
    
<?php require "add_includes/ef_big_img_wrap.php"; ?>   

</div>


<div class="ef-wrap">


    
    
 
    
     

    <div class="ef-info-images">
        <?php require "add_includes/ef_info_images.php"; ?> 
    </div>



    <div class='ef-rooms'>
<?php require "add_includes/ef_rooms.php"; ?>
    </div>





</div>
    <?php include("../includes/footer.php"); ?>
