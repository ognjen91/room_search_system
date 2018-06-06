<?php
include("../includes/init.php");

$image->get_image_data_publ();
$image_to_del = $image->name;
//$image_to_del = $image->name_no_extension($image_to_del);
//var_dump($image_to_del);
//$x = $image->delete_image_from_folers($image_to_del, "images");



$x = $room_image->delete($image_to_del);




















?>


