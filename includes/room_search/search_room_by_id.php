<?php require "../init.php"; ?>


<?php

$room_id = $_POST['room_id'];


//echo "ID je: " . $room_id;
$room_found = Room::get_room_by_id($room_id);
$room_info = $room_found->get_all_room_data();

$room_images = $room_image->all_images($room_found->get_room_name(), $room_found->get_facility(), $room_found->get_owner());

var_dump($room_images);
$room_data = array();
$room_data['info'] = $room_info;
$room_data['images'] = $room_images;

//header('Content-Type: application/json');
//echo json_encode($room_data);





















?>

