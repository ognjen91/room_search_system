<?php

/*

get_data_for_create - podaci za kreiranje nove sobe
make_facility_and_add_data - glavna create fja objekta
get_data_for_edit_ajax - podaci za ajax edit sobe
facility_edit_ajax - ajax edit sobe
set_facility_profile_image - ubac profilne slike MOZE SE ISKORISTI I ZA UPDATE!!!

DRUGE METODE:
users_facilities : vraca array sa objektima facility cijim je vlasnik aktivn user  
facility_for_edit : uzima vrijednost facility_namea iz get-a i postavlja vlasnika
vraca objekat objekta koji se sada aktivan

GLAVNA METODA ZA PODATKE:
get_facility_data
 
GETTER METODE 
za vlasnika...
*/


class Facility extends Db_object {

    protected $target_file;
    protected static $db_table = "facilities";
    
    protected $target;
    public $owner;
    public $facility_name;
    public $place;
    public $adress;
    public $phone_1;
    public $phone_2;
    public $description_srb;
    public $description_eng;
    public $profile_image;
    public $field_to_change;
    public $fac_to_change;
    public $new_value;
    public $active_facility;
    
    protected static $db_table_fields = ['facility_name', 'owner', 'place', 'adress', 'phone_1', 'phone_2', 'description_srb', 'description_eng', 'profile_image'];
    
    
    public function __construct(){
         }
    
    
//    ============KREIRANJE NOVOG OBJEKTA====================
    
    //uzima podatke iz posta,  vraca ociscen db_table_fields array
    protected function get_data_for_create(){
       global $user;
       $this->owner = $user->username();
      isset($_POST["submit-addfacility"])? $this->array_vars_to_obj_props($_POST, $this): null;

        $db_props = $this->object_props(); //iz klase Db_object, dobijen je niz sa vrijednostima za bazu (niz: key_iz_db_table_fields=>value_iz_obj_propsa)
        $db_props = $this->escape_array($db_props); //klasa Sql, priprema za bazu
        
        
        return $db_props;
//        return var_dump($db_props);
    }
    

    //glavna create fja objekta
      public function make_facility_and_add_data(){
        $db_props = $this->get_data_for_create();
        $does_exist = self::if_already_exists(self::$db_table, "owner='".$this->owner."' AND facility_name='" . $this->facility_name . "'"); //klasa Db_object, provjera da li postoji u bazi
        if (!$does_exist){
            $x = $this->create(self::$db_table, $db_props);
            echo "<h2>Objekat uspjesno kreiran!</h2>";
             $this->set_facility_profile_image();
        } else {
            echo "<h2>Navedeni objekat je vec kreiran</h2><h3>Pokusajte ponovo</h3>";
        }
   
    }
    
    
    
    
    
    
    
//  ===============EDIT FACILITY AJAX=======================
    //za glavnu edit stranu sobe i edit opisa
    
     private function get_data_for_edit_ajax(){
      global $user;
     $this->owner = $user->username();
      
     $this->field_to_change = $field_to_change = $_POST['field_to_change']; 
      $this->fac_to_change = $_POST['facility'];     
      $this->new_value = $_POST['new_value'];
      
 
}
   
   
    public function facility_edit_ajax(){
        
        
        $this->get_data_for_edit_ajax();
      
        
        $query = "UPDATE " . self::$db_table;
        $query .= " SET ". $this->field_to_change . "='" . $this->new_value ."'";
        $query .= " WHERE owner='".$this->owner ."'" ;
        $query .= " AND facility_name='". $this->fac_to_change ."'";
//        echo $query;
        $is_successfull = $this->update_query_to_db($query);    
         if (!$is_successfull){
             return null;
         }   else { echo $this->new_value;}
//var_dump($this);
    }
  
    
 
    
//  ===============PROFILNA===============
    
    
 //POSTAVLJANJE PROFILNE - ZAPRAVO UBAC PROFIL IMG jer se ovo vrsi nakon kreiranja objekta u bazi      
//$imageNameString - ime slike iz posta
//$db_name - ime tabele u bazi
//$db_image_field - ime rowa iz baze sa imenom slike 
//$conditionString - npr "objekat = 'Belvedere'"
  
   public function set_facility_profile_image(){
       global $image;
       
       $x = $image->update_image('profile_image', self::$db_table, "profile_image", "facility_name='".$this->facility_name ."' AND owner= '" . $this->owner . "'", "fac-profiles");

   }

    
    
//====================DRUGE FJE==================
    
    
//    --------KORISNIKOVI OBJKETI----------
   //vraca array sa objektima facility cijim je vlasnik aktivn user  
public function users_facilities(User $user){
    
    
    $facilities = self::find_all("owner='".$user->username()."'");
    
    return $facilities;
}




//uzima vrijednost facility_namea iz get-a i postavlja vlasnika... vraca objekat objekta koji se sada aktivan
//koristim ovu metodu na add_new_room.php, edit_descriptions.php i edit_facility.php
 public function facility_for_edit() {
     global $user;      
     $this->get_facility_data();
     $facility=  $this->active_facility;
     $owner = $this->owner = $user->username();
     $active_facility = $this->find_specific("facility_name='". $facility ."' AND owner='" . $owner . "'");
       return  $active_facility;   
  
        
    }




//=========GLAVNA METODA ZA PODATKE=========



public function get_facility_data(){
    
    if (Go_to::is_on_page("edit_facility")){
        $this->active_facility = $_GET['facility'];
    }
    if (Go_to::is_on_page("add_fac_image") || Go_to::is_on_page("add_new_room")){
        $this->active_facility = $_SESSION['active_fac'];
    }
    if (Go_to::is_on_page("edit_descriptions")){
        $this->active_facility = $_SESSION['active_fac'];
    }
   
}

//--------------------------GETTER METODE-------------
    
    public function get_owner(){
        return $this->owner;
    }

    


}









?>