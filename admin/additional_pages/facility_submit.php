<?php



//
//echo "jel':" . empty($_POST['adress']);

include("../includes/header.php");

//var_dump($_SESSION);
//var_dump($user);
//var_dump($user->username);
isset($_POST['submit-addfacility'])? $facility->make_facility_and_add_data() : null;

isset($_POST['submit-facilityimage'])? $image->add_new('fac-images', 'new_fac_image') : null;

isset($_POST['submit-roomimage'])? $room_image->add_new('room-images', 'new_room_image') : null;

isset($_POST['submit-addnewroom'])? $room->make_room_and_add_data() : null;

//echo '<pre>'.var_export($_POST, true).'</pre>';
?>


<a href='<?php echo Go_to::to_admin_index(); ?>'> Povratak na index.  </a>

<?php
include("../includes/footer.php"); 
?>






























