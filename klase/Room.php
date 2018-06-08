<?php

/*
ideja kod kreiranja nove sobe je da se ubace svi podaci sem profile_picture, a za nju imam posebnu metodu, pa je prakticno updatujem

make_room_and_add_data : kreiranje nove sobe
set_room_profile_image : postavljanje (=update) profilne slike -- MOZE SE ISKORISTITI ZA UPDATE PROFILNE
update_room : update podataka sobe
delete_room : brisanje sobe

DRUGE i POMOCNE METODE:
all_facility_rooms_adm - izlistavanje soba za admin page
room_for_edit : vraca aktivnu sobu za edit
profile_image_name - vraca ime profilne slike sobe BEZ EKSTENZIJE
rooms_place : mjesto u kom se nalazi soba
get_room_by_id : pretraga sobe po id-u
get_all_rooms : vraca array sa svim sobama u bazi

METODE ZA PODATKE SOBE:
get_room_data
get_room_data_spec - za spec slucajeve, npr kad treba uzeti van klase

GETTER METODE:
get_owner, get_facility, get_room_name, get_room_id, get_all_room_data

*/

class Room extends Db_object{
 protected static $db_table = "rooms";   
 
 protected $id;
 public $name;
 public $facility_name;
 protected $owner;
 public $profile_image;
 public $description_srb;
 public $description_eng;
 public $air_conditioner;
 public $kitchen;
 public $bathroom;
 public $tv;
 public $terace;
 public $other_amenities_srb;
 public $other_amenities_eng;
 public $no_of_beds;
 public $place; //nema potrebe za protected
public static $db_table_fields = ['id', 'name', 'owner', 'facility_name', 'profile_image', 'description_srb', 'description_eng', 'air_conditioner', 'kitchen', 'bathroom', 'tv', 'terace', 'other_amenities_srb', 'other_amenities_eng', 'no_of_beds']; 
    
public function __construct(){
    
    
}    
 
    
    
//    ==========CREATE NEW ROOM================
      public function make_room_and_add_data(){
      $this->get_room_data();
      $db_props = $this->object_props(); //ubac podataka iz objekta u array db_table_fields
      
      $this->owner = $this->escape_string($this->owner);
      $this->facility_name = $this->escape_string($this->facility_name);
          
     $this->name = $this->escape_string($this->name);
          
          
        $does_exist = self::if_already_exists(self::$db_table, "owner='".$this->owner."' AND facility_name='" . $this->facility_name . "' AND name='" . $this->name . "'");
//        return var_dump($does_exist);
        if (!$does_exist){
            $x = $this->create(self::$db_table, $db_props);
            echo "<h2>Soba uspjesno kreirana!</h2>";
            echo "<h2><a href='".SITE_ADRESS. DS ."admin/additional_pages/edit_facility.php?facility=".$this->facility_name."'>Povratak na izmjenu objekta</a></h2>";
             $this->set_room_profile_image();
        } else {
            echo "<h2>Navedena soba je vec kreirana</h2><h3>Pokusajte ponovo</h3>";
        }
       
 }
    
    
    //profilnu sliku ubacujem u fji make_room_and_add_data
    public function set_room_profile_image(){
       global $image;
       
        $condition = "facility_name='".$this->facility_name ."' AND owner= '" . $this->owner . "' AND name='".$this->name."'";
//        var_dump($condition);
        
       $x = $image->update_image('profile_image', self::$db_table, "profile_image", $condition , "room-profiles");

   }
    
    
//==================UPDATE ROOM===========

public function update_room(){
    

    $this->get_room_data();
//    //necu mijenjati id sigurno pa ga izbacujem iz arraya za update
   if (($key = array_search("id", self::$db_table_fields)) !== false) {
    unset(self::$db_table_fields[$key]);
    }

//   ideja da iz sessiona uzmem stare podatke i da izbacim iz db_table_fields one koji su ista...jer sql ne updatuje polja koja nisu promjenjena i izbacuje gresku. tako eliminisem i polja name, fac_name, owner, profile_picture ali i sve sto je isto
    $old_props = $_SESSION['active_room_old'];
    unset($old_props['id']); //da ne bi bilo greske pri poredjenju
    $props_for_update = $this->object_props();
    
    foreach($old_props as $key=>$value){
        if (isset($old_props[$key])){
        if ($old_props[$key] == $props_for_update[$key]) unset($props_for_update[$key]);
        }
    }
   
   foreach($props_for_update as $key=>$value){
    $query = "UPDATE " . self::$db_table;
    $query .= " SET ". $key . "='" . $value . "' WHERE ";
    $query .= " name='" . $this->name . "' AND";
    $query .= " facility_name='" . $this->facility_name . "' AND";
    $query .= " owner='" . $this->owner . "'";
//    var_dump($query);
        
    $result = $this->update_query_to_db($query); 
    if (!$result){
        die ("Greska prilikom update-a sobe.");
    }   
    }
    
    echo "<h2>Promjene uspjesno izvrsene!</h2>";  
    echo "<h2><a href='".SITE_ADRESS."/admin/additional_pages/edit_facility.php?facility=".$this->facility_name."'>Povratak na izmjene objeka</a></h2>";  

    
}

    
//    =========DELETE ROOM=====================
    //treba izbrisati sobu iz svih tabela, a takodje i slike sobe iz svih foldera
     //prvo brisem iz foledera, pa iz baze
public function delete_room(){
    global $image;
    $this->get_room_data();
    $db_tables = ['rooms', 'room_images'];
    
    
   //brisanje profilne slike
     $profile_img = $this->profile_image_name();
//      var_dump($profile_img);
    
     $delete_profile_img = $image->delete_image_from_folers($profile_img, "images");
 

     //brisanje ostalih slika sobe
     foreach(Room_image::all_images($this->name, $this->facility_name, $this->owner) as $image_for_del){
      $image_for_del = $image->name_no_extension($image_for_del);
      
      $delete_ok = $image->delete_image_from_folers($image_for_del, "images");

    }

    

    //brisanje iz tabela
    foreach($db_tables as $table){
        
    $delete_query = "DELETE FROM ".$table." WHERE ";
        if ($table === "rooms"){
       $delete_query .= "name='".$this->name."' AND";    
        }
        if ($table === "room_images"){
       $delete_query .= "room_name='".$this->name."' AND";    
        }
        
        
    $delete_query .= " facility_name='".$this->facility_name."'   AND";
    $delete_query .= " owner='". $this->owner . "'";   
        
       //brisanje iz baze 
      $result = $this->update_query_to_db($delete_query);
        
 }
   
}





//    =============DRUGE I POMOCNE METODE================

    //SVI OBJEKTI ADMINA
    //izlistavanje svih soba aktivnog korisnika
   public function all_facility_rooms_adm(){
       $this->get_room_data();
       
       $condition = "facility_name='".$this->facility_name ."' AND owner='".$this->owner."'";
//       var_dump($condition);
       $rooms = $this->find_all($condition);
//       var_dump($rooms);
       return $rooms;
   }

    //AKTIVNA SOBA ZA EDIT
//vraca aktivnu sobu
 public function room_for_edit() {
    $this->get_room_data();
      
       $condition = "facility_name='". $this->facility_name ."' AND owner='" . $this->owner . "' AND name='" . $this->name . "'";   
        
      $active_room = $this->find_specific($condition);
     
     
      return  $active_room;   
//      return  var_dump($active_facility);   
        
    } 

    
  private function profile_image_name(){
      global $image; 
      
     $condition = " facility_name='".$this->get_facility()."' AND";
     $condition .= " owner='". $this->get_owner() . "' AND";
     $condition .= " name='".$this->get_room_name()."'";    
      
     $room = $this->find_specific($condition);
     $room_name = $this->profile_image;
      
      $name_no_extension = $image->name_no_extension($room_name);

//     var_dump($name_no_extension);
      return $name_no_extension;
  }
    
//    MJESTO SOBE
    //spaja se sa tabelom facilities i nalazi mjesto u kom se nalazi soba
public function rooms_place(Room $room_selected){
        $facility_name = $room_selected->get_facility();
        $owner = $room_selected->get_owner();
        
        $query = <<<EOT
SELECT facilities.place
FROM facilities
INNER JOIN rooms ON 
facilities.owner = rooms.owner
AND
facilities.facility_name = rooms.facility_name;
EOT;
        $result = $this->find_specific_full_query($query);
        return $result->place;
    }
    
    
    //PRETRAGA SOBE PO ID-u
     public static function get_room_by_id(int $id){
        $safe_id = self::escape_string($id);
        return self::find_specific("id='$safe_id'");
        
        
    }  
    
    
    //SVE SOBE U BAZI
    public function get_all_rooms(){
        $all_rooms = self::find_all_no_cond();
        foreach($all_rooms as $room){
        }
       return $all_rooms;
    }
     
// =======================================
//=======METODE ZA PODATKE SOBE============
//=======================================
    
//vazna glavna fja koja uzima potrebne podatke iz posta fja koja uzima podatke 
    
        protected function get_room_data(){
        global $user;
        
        
        if (Go_to::is_on_page("edit_facility")){
            $this->facility_name = $_GET['facility'];
            $this->owner = $user->username();
            
           
        }
            
            
         if (Go_to::is_on_page("add_new_room")){
            $this->facility_name = $_GET['facility'];
            $this->owner = $user->username();
        }
        
        if (Go_to::is_on_page("facility_submit")){
            $this->facility_name = $_GET['facility'];
            $this->owner = $user->username();
            $this->array_vars_to_obj_props($_POST, $this);
            
            
//            var_dump($user->username());
//            var_dump($this);
        }
            
             if (Go_to::is_on_page("edit_room")){
            $this->facility_name = $_GET['facility'];
            $this->name = $_GET['room'];
            $this->owner = $user->username();
            isset($_POST['submit-editroom'])? $this->array_vars_to_obj_props($_POST, $this) : null;
//                 var_dump($this);
        }
            if (Go_to::is_on_page("delete_room") || Go_to::is_on_page("add_room_image")){
            $this->facility_name = $_GET['facility'];
            $this->name = $_GET['room'];
            $this->owner = $user->username();
        
            }

        
        
    }

    
           //druga za podatke sobe
     public function get_room_data_spec(){
          if (Go_to::is_on_page("room_calendars")){
            global $user;
            $this->facility_name = $_SESSION['active_fac'];
            $this->name = $_SESSION['active_room'];
            $this->owner = $user->username();
       
            }
         
          if (Go_to::is_on_page("edit_calendar")){
            global $user;
            $this->facility_name = $_SESSION['active_fac'];
            $this->name = $_SESSION['active_room'];
            $this->owner = $user->username();
       
            }
         if (Go_to::is_on_page("calendar_submit")){
            global $user;
            $this->name = $_SESSION['active_room'];
            $this->facility_name = $_SESSION['active_fac'];
            $this->owner = $user->username();
            
               
          
        }
     }

    
        
//    ======GETTER METODE==========
    
    
   public function get_owner(){
        return $this->owner;
    }
    
    public function get_facility(){
        return $this->facility_name;
    }
    
     public function get_room_name(){
        return $this->name;
    }
    
     public function get_room_id(){
        return $this->id;
    }
   
    //zgodno je vratiti array jer saljem kao json
    public function get_all_room_data(){
        $data = array ();
        $data['room_name'] = $this->get_room_name();
        $data['facitilty_name'] = $this->get_facility();
        $data['owner'] = $this->get_owner();
        $data['profile_image'] = $this->get_owner();
        $data['description_srb'] = $this->description_srb;
        $data['description_eng'] = $this->description_eng;
        $data['air_conditioner'] = $this->air_conditioner;
        $data['kitchen'] = $this->kitchen;
        $data['bathroom'] = $this->bathroom;
        $data['tv'] = $this->tv;
        $data['terace'] = $this->terace;
        $data['other_amenities_srb'] = $this->other_amenities_srb;
        $data['other_amenities_eng'] = $this->other_amenities_eng;
        $data['no_of_beds'] = $this->no_of_beds;
        
        
        return $data;
    }
    
    
//    ==class end==
}













?>