<?php include("includes/header.php"); ?>

<div class="calendar_section">
<?php require "includes/front_page/calendar_section.php";
?>
</div>

<div class="fp_results">
<div class= "search_results" id='search_results'>
<?php
$all_rooms = $room->get_all_rooms();
//var_dump($all_rooms);

foreach ($all_rooms as $room_found){
    ?>

 <div class='room_found room_found_date' id='<?php echo $room_found->get_room_id(); ?>'>

<div class='fp_room_profile'>
 <img src='<?php echo SITE_ADRESS . "/images/room-profiles/" . $room_found->profile_image; ?>' alt="Room profile image">    
</div>

<div class='fp_basic_info'>
     
<p class="fp_basic_name"><?php echo $room_found->name; ?></p> 
<p class="fp_basic_name">Objekat: <?php echo $room_found->facility_name; ?></p>   <p class="fp_basic_beds">Broj kreveta: <?php echo $room_found->no_of_beds; ?></p> 
   
<p class="fp_basic_place">Mjesto: <?php  echo $room_found->rooms_place($room_found); ?></p>    
     
</div>

  <div class='fp_show_more'>
      SHOW MORE
      
     </div>      
     


 </div>
    
   
    
<?php    
    }

//echo "OK";

?>




</div>
</div>



<div class="fp_show_room">
<?php require "includes/front_page/show_room.php";
?>
</div>



<?php include("includes/footer.php"); ?>
