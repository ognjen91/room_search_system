<?php


class Room extends Db_object{
 protected static $db_table = "rooms";   
    
 public $name;
 public $facility_name;
 public $owner;
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
 public $place;
public static $db_table_fields = ['name', 'owner', 'facility_name', 'profile_image', 'description_srb', 'description_eng', 'air_conditioner', 'kitchen', 'bathroom', 'tv', 'terace', 'other_amenities_srb', 'other_amenities_eng', 'no_of_beds']; 
    
public function __construct(){
    
    
}    
 
    
    
//    ==========CREATE NEW ROOM================
      public function make_room_and_add_data(){
      $this->get_room_data();
      $db_props = $this->object_props(); //ubac podataka iz objekta u array db_table_fields

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
    
    //necu mijenjati profile image pa je izbacujem iz arraya za update
    $this->get_room_data();
    if (($key = array_search("profile_image", self::$db_table_fields)) !== false) {
    unset(self::$db_table_fields[$key]);
}
    
    $props_for_update = $this->object_props();
//    var_dump($props_for_update);
    foreach($props_for_update as $key=>$value){
    $query = "UPDATE " . self::$db_table;
    $query .= " SET ". $key . "='" . $value . "' WHERE ";
    $query .= " name='" . $this->name . "' AND";
    $query .= " facility_name='" . $this->facility_name . "' AND";
    $query .= " owner='" . $this->owner . "'";
    
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

    //izlistavanje svih soba aktivnog korisnika
   public function all_facility_rooms_adm(){
       $this->get_room_data();
       
       $condition = "facility_name='".$this->facility_name ."' AND owner='".$this->owner."'";
//       var_dump($condition);
       $rooms = $this->find_all($condition);
//       var_dump($rooms);
       return $rooms;
   }

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
      
     $condition = " facility_name='".$this->facility_name."' AND";
     $condition .= " owner='". $this->owner . "' AND";
     $condition .= " name='".$this->name."'";    
      
     $room = $this->find_specific($condition);
     $room_name = $room->profile_image;
      
      $name_no_extension = $image->name_no_extension($room_name);

//     var_dump($name_no_extension);
      return $name_no_extension;
  }
    
     
    
//=======GLAVNA METODA ZA PODATKE SOBE============
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
    public function get_all_rooms(){
        $all_rooms = self::find_all_no_cond();
        foreach($all_rooms as $room){
            
            
        }
        
        return $all_rooms;
    }
    
  
    
//    ==class end==
}













?>