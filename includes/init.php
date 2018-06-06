<?php









$root = realpath($_SERVER["DOCUMENT_ROOT"]);


defined('DS')? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ADRESS')? null : define('SITE_ADRESS', "http://localhost/oop");
defined('SITE_ROOT')? null : define('SITE_ROOT', 'C:'. DS. 'xampp' . DS. 'htdocs' . DS. 'oop');



require_once "$root/oop/klase/Connection.php";
require_once "$root/oop/klase/Go_to.php";
require_once "$root/oop/klase/Sql.php";
require_once "$root/oop/klase/Db_object.php";
require_once "$root/oop/klase/Session.php";
require_once "$root/oop/klase/User.php";
require_once "$root/oop/klase/Guest.php";

require_once "$root/oop/klase/Facility.php";
require_once "$root/oop/klase/Image.php";
require_once "$root/oop/klase/Room.php";
require_once "$root/oop/klase/Room_image.php";
require_once "$root/oop/klase/Calendar.php";
require_once "$root/oop/klase/Prices.php";







$connection = new Connection(); 
$sql = new Sql();
$db_object = new Db_object;

//$user = new User();
$session = new Session();
$facility = new Facility();
$image = new Image();
$room = new Room();
$room_image = new Room_image();
$guest = new Guest();



?>
















