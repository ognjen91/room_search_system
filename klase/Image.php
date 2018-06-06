<?php



class Image extends Db_object {
    protected static $db_table = "images";
    
    
//    private $name;//ok
//    private $tmp_name; //ok
//    private $owner; //ok
//    private $facility_name; //-->iz drop-down
//    private $size; //getimagesize
//    private $created; //ok
//    private $target; //ok
//    private $description_srb; //ok
//    private $description_eng; //ok
//     private $room_name; //ok
    public $name;//ok
    public $tmp_name; //ok
    public $owner; //ok
    public $facility_name; //-->iz drop-down
    public $size; //getimagesize
    public $created; //ok
    public $target; //ok
    public $description_srb; //ok
    public $description_eng; //ok
//    public $room_name; //ok
    private $unlink;
    private $i = 0;
   
    protected static $db_table_fields = ['facility_name', 'owner', 'name', 'tmp_name', 'size', 'created', 'description_srb', 'description_eng'];
    
    public $new_image = array();
    
    
    public function __contstruct(){
        
        
    }

    
//    ===========ADD NEW IMAGE============================

    
    
    
    
    //$fileName: to je ime fajla iz prihvata forme,  $_FILES['ovo_je_ime]
    
    public function add_new(string $folderInWhichWillSave, string $fileName) {
//        var_dump($_FILES);
       
        
         global $user;
         $this->owner = $user->username();
         $this->created = date("d.m.Y");       
 
        //novo ime slike
  //loopujem onoliko puta koliko ima slika
       foreach($_FILES[$fileName]['name'] as $img){
           
           
           //preskacem ako je prazno polje...
         if (!$_FILES[$fileName]['size'][$this->i]){ 
           if (isset($new_image)) unset($new_image);
          $new_image = array();
           $this->i++;
             continue;
         }

           
        
           
           //DODJELA NOVOG IMENA SLICI
       $temp = explode(".", $img);
       $random_number = Go_to::random_number();
        $newfilename = $random_number .round(microtime(true)) . '.' . end($temp);

           
       //prebacivanje informacija iz posta i filesa u array new_image (=podaci o novoj slici)    
       $x= $this->array_fields_in_db($_POST, static::$db_table_fields, $this->i); 
//       echo "<br><br><br>"; var_dump ($_FILES[$fileName]["error"][$this->i]); echo "<br><br><br>";
//       echo "<br><br><br>"; var_dump ($_FILES[$fileName]["size"][$this->i]); echo "<br><br><br>";
//       if ($_FILES[$fileName]["size"][$this->i] == 0){
//           $number_of_field = $this->i + 1;
//           "Polje za ubacivanje fajla broj " .$number_of_field ."nije popunjeno.";
//       continue; } 
           
       $y = $this->array_fields_in_db($_FILES[$fileName], static::$db_table_fields, $this->i);
           
           
      

           
           
       //polja koja ne dobijam kroz post i files   
       $this->new_image['owner'] = $user->username();
       $this->new_image['created'] = $this->created;
         
     
           
           
        //  cuvam sve vrijednosti u varijablama 
        self::array_vars_to_obj_props($this->new_image, $this); 
         
   
    //mijenjam ime slike u jedinstveno prije ubaca u bazu
        $this->target = SITE_ROOT . DS ."images/$folderInWhichWillSave". DS . $newfilename;
        $this->new_image['name'] =$this->name = $newfilename;
           
//        if (!$_FILES[$fileName]["size"][$this->i] > 0 ) continue;
 //PROVJERE I UBAC U BAZU I U FOLDERE
      if (!file_exists($this->target)){
          
      try {
          
//           echo "<b4>".$this->new_image['tmp_name']."<b4>";
          //jer ga nema u tabeli, posluzio svrsi
          unset($this->new_image['tmp_name']);
//echo "<br><br>velicina slike ". $this->i." je " . $_FILES[$fileName]["size"][$this->i] . "<br><br><br>";
          
          
//         if (!isset($this->tmp_name)) continue;
       if (getimagesize($this->tmp_name)){
           $result = $this->create(static::$db_table, $this->new_image);
           $move = move_uploaded_file($this->tmp_name, $this->target);
           
            if (!$result || !$move){
                throw new Exception ("...Problem pri ubacivanju slike". $this->name . "! ");
            } else {echo "Slika je". $this->name . " uspjesno ubacena. <br>";}
       
       } else {
           echo "Pokusaj ubacivanja fajla koji nije slika. Fajl nije ubacen u bazu. ";
       }
          
       } catch (Exception $e) {
         die ($e->getMessage());
      }
    
    
      //kada file vec postoji
      } else {
        echo "Slika <b>". $this->name ."<b> vec postoji. Molimo promjenite naziv ili uploadujte drugu sliku. <br>";
    }
     
         //resetujem array kako bi mogao primiti novu sliku
          
          

           if (isset($new_image)) unset($new_image);
          $new_image = array();
           $this->i++;
     }
        
         
        
    }
 
    
    
    
//    =============UPDATE IMAGE=========================
    
//$imageNameString - ime slike iz posta
//$db_table - ime tabele u bazi
//$db_image_field - ime rowa iz baze sa imenom slike 
//$conditionString - npr "objekat = 'Belvedere'"    

public function update_image($imageNameString, $db_table, $db_image_field, $conditionString, $folder){
     global $user;
     $this->owner = $user->username();
    
   //DODJELA NOVOG IMENA SLICI 
    
    $random_number = Go_to::random_number();
    
    $this->name = $random_number . $_FILES[$imageNameString]['name'];
    $this->tmp_name = $_FILES[$imageNameString]['tmp_name'];
    $this->target = SITE_ROOT . DS ."images". DS. $folder . DS . basename($this->name); 
    
    $sql = "UPDATE ". $db_table . " SET ";
    $sql .= "$db_image_field='". $this->name . "' ";
    $sql .= "WHERE ". $conditionString;
//    var_dump($sql);
    if (!file_exists($this->target)){

   try {
       
       $result_of_update = $this->update_query_to_db($sql);
       $move = move_uploaded_file($this->tmp_name, $this->target);
       if (!$result_of_update || !$move){
           throw new Exception ("...Problem pri update-u slike! ");
       } else {echo "Slika je uspjesno ubacena";}
   } catch (Exception $e) {
       die ($e->getMessage());
   }
    
    } else {
        echo "Slika vec postoji. Molimo promjenite naziv ili uploadujte drugu sliku.";
    }
    
}
    
    

//    =======================DELETE SLIKA==================
     
//------------BRISANJE IZ FOLDERA-----------
//koristim ugradjenu klasu DirectoryIterator
    
    public function delete_image_from_folers($image_name_no_ext, $image_folder){
        $dir = new DirectoryIterator(dirname(SITE_ROOT . '/images/fac-profiles')); //to moze biti bilo koji folder u folderu sa slikama (=folder 'images')
        
        //iteracija kroz foldere
        foreach ($dir as $fileinfo) {
            //isDot provjerava da li je . ili 'normalan' string
        if (!$fileinfo->isDot())
        {
         //dobijam imena foldera
        $folder_name = $fileinfo->getFilename();
        $files = SITE_ROOT. DS. $image_folder . DS. $folder_name . DS . "*"; 
//        iteracija kroz fileove
       foreach(glob($files) as $file) {  
          $file_info = pathinfo($file); 
//          echo($file_info['filename']) . "<br>";
   
           if ($image_name_no_ext ===  $file_info['filename']){
               $this->unlink = unlink($file);
               echo "Slika $image_name_no_ext je uspjseno obrisana<br>";
           } 
           
           
    
      }
     
  
          }
        }
       }
    
    
//  -----------BRISANJE IZ BAZE---------
    
    protected function delete_image_from_db($imageNameWithExtension, $table_name){
        
        $query = "DELETE FROM ". $table_name . " WHERE name='".$imageNameWithExtension."'";
        $delete = $this->update_query_to_db($query);
        
        return $delete;
//        echo $delete? "izbr iz baze":"nije iz baze izbrisano";
        
    }
    
  
    
//    -------glavna METODA za BRISANJE SLIKE-------
    
    public function delete_image($imageNameWithExtension, $table_name, $image_folder){
        global $image;
        
        $imageNameNoExtension = $this->name_no_extension($imageNameWithExtension);
        
        $this->delete_image_from_folers($imageNameNoExtension, "images");
        $deleted=$this->delete_image_from_db($imageNameWithExtension, $table_name);
        
//        echo $deleted? "IZBRISAN FAJL" : "FAJL NIJE IZBRISAN";
    }
  
    
    
//    ============POMOCNE I DRUGE METODE=================
    
    
    
  //pomocna fja koja provjerava da li se clanovi $inputArray-a (Npr $_POST['nesto'], $_FILES['nesto]) nalaze u arrayu $db_table_fields i ako da, u $this->new_image (nova slika koju ubacujem) ubacuje.
    //npr provjerava da li se var iz POST-a nalaze u db_table_fields i ako se nalaze, dodjeljuje vrijednost u $this-new_image arrayu koji i ubacujem u bazu

    protected function array_fields_in_db($inputArray, $db_table_fields, $counter){
           foreach($inputArray as $input_key=>$input_val){
             if (in_array($input_key, $db_table_fields)){
                 if (!is_array($input_val)){
                   //sljedeci array se mijenja po potrebi
                       $this->new_image[$input_key] = $input_val;
                 } else {
                     //sljedeci array se mijenja po potrebi 
                     $this->new_image[$input_key] = $input_val[$counter];

                 }
             }
         }
    }
    
    
    
//    --------vraca IME BEZ EKSTENZIJE---------
     public function name_no_extension($file){
     $name_no_extension = explode('.', $file);
      unset($name_no_extension[count($name_no_extension) - 1]);
      $name_no_extension = implode('.', $name_no_extension);
       
       return $name_no_extension;
   } 
    
//    ==================PRIKAZI SLIKA=====================
    
//    ------------prikaz slika u admin panelu------------
       public function all_facility_images_adm(){
       $this->get_image_data();
       
       $condition = "facility_name='".$this->facility_name ."' AND owner='".$this->owner."'";
       
       $images = $this->find_all($condition);
//       var_dump($images);
       return $images;
   }
    
   
//  -------sve slike sa random uslovom---------------
    public function find_all_images($condition){
        $images = $this->find_all($condition);
        return $images;
    }

    
    
    
//    ============GLAVNA METODA ZA PODATKE SLIKA============
         protected function get_image_data(){
        global $user;
        
        
        if (Go_to::is_on_page("edit_facility")){
            $this->facility_name = $_GET['facility'];
            $this->owner = $user->username();
        }
          if (Go_to::is_on_page("edit_room") || Go_to::is_on_page("add_room_image")){
            $this->facility_name = $_GET['facility'];
            $this->room_name = $_GET['room'];
            $this->owner = $user->username();
            }
             
              if (Go_to::is_on_page("delete_room_img")){
            $this->name = $_POST['image'];
            }
             
           
         }
             
     public function get_image_data_publ(){
             $this->get_image_data();
         }
    
    
    
    
         }
    
        
    







?>
