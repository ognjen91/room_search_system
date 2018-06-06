<?php include("../includes/header.php"); ?>


<!--<?php var_dump($_POST);  ?>-->
<!--<?php var_dump($_SESSION);  ?>-->

<?php $room->get_room_data_spec(); ?>
<?php $calendar = new Calendar() ?>
<?php $calendar->get_calendar_data_spec(); ?>
<?php $prices = new Prices() ?> 





<!--<?php var_dump($room);  ?>-->
<!--<?php var_dump($calendar);  ?>-->


<?php 

$updated_prices= $prices->prices_submit($room);
$updated_availability = $calendar->availability_submit($room);
$updated = $updated_prices && $updated_availability;
var_dump($updated_availability);
var_dump($updated_prices);
var_dump($updated);

if ($updated){
$url = $_SESSION['last_edit_calendar_adress'];
$_SESSION['calendar_updated'] = true;
$_SESSION['prices_updated'] = true;
$updated? header( "Location: $url" ) : null;
}


//echo "Greska prilikom updatea kalendatra. Molimo, obratite se administratoru."


?>


<?php
//sleep(5);
//
//


?>
















<?php include("../includes/footer.php"); ?>
