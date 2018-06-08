<?php

/*
all_images : vraca listu imena slika sobe iz tabele room_images
all_room_images_adm : sve slike, admin panel
delete : brisanje 

*/

class Room_image extends Image {
   protected static $db_table = "room_images";   
    public $room_name; //ok
   
      protected static $db_table_fields = ['facility_name', 'owner', 'name', 'tmp_name', 'size', 'created', 'room_name'];
    
    
    
        
    
    //vraca listu imena slika sobe iz tabele room_images
  public static function all_images($room, $facility, $owner){
     
      
     $images = array();  
      
     $condition = " facility_name='".$facility."' AND";
     $condition .= " owner='". $owner . "' AND";
     $condition .= " room_name='".$room."'";    
      
     $room_images = (new self)->find_all($condition);
     foreach($room_images as $image){

         $images[] = $image->name;
     } 
//      var_dump($images);
      return $images;
  }

    
    //sve slike, admin panel
    public function all_room_images_adm(){
       $this->get_image_data();
//       var_dump($this->room_name);
       $condition = "facility_name='".$this->facility_name ."' AND owner='".$this->owner."'";
       $condition .= " AND room_name='".$this->room_name."'";
//       var_dump($condition);
       $images = (new self)->find_all($condition);
//       var_dump($images);
       return $images;
   }




public function delete($imageNameWithExtension){
    $this->delete_image($imageNameWithExtension, self::$db_table, "images");
}














}
















?>
















