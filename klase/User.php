<?php


/*
check_login_data i submit_login_form - za submitovanje login forme na stranici login.php
create_user - glavna fja za kreiranje novog korisnika
update_user - update podataka o korisniku
login_from_session - prijava na stranicama koje nisu naznacene u samoj metodi. prima podatke iz sesije i preuzima podatke iz baze

POMOCNE METODE:
get_data_for_checking: uzima username i pass iz session-a i dodjeljuje propsima objekta
select_all_users: pronalazenje svih korisnika u bazi
user_exists : provjera da li korisnik postoji u bazi (za logovanje)
username_exists : provjerava da li korisnicko ime vec postoji u bazi (za kreiranje novog naloga)

GETTER METODE:
za username, password, email

*/

class User extends Db_object{
    protected static $db_table = "users";
   protected $username;
    protected $password;
    protected $id;
    protected $email;
    protected $username_for_check;
    protected $password_for_check;
    
    protected static $db_table_fields = ['username', 'password', 'email'];
    
 
//  =============SUBMIT LOGIN FORME=============
    
  //provjerava da li su uneseni username i sifra ispravni
    //dio glavne login fje
    //ako jesu podesava sesiju i vraca true... suprotno false
   private function check_login_data(){
  
       if (isset($_POST['login_submit'])){
        
      $data_for_check = $this->get_data_for_checking();    
    if ($this->user_exists()){
          $_SESSION['logged'] = true;
          $_SESSION['logged_user'] = $this->username_for_check;
//          echo "ok";
//          $output = ob_get_contents();
//          ob_end_clean();
          header('Location: ' . GO_to::to_admin_index());
      }  else {
          echo "<h1>Uneseni su neispravni podaci.</h1><h3>Molimo pokušajte ponovo.</h3>";
      }
        
  }    
 }
    
    //KONACNA FJA ZA SUBMIT LOGIN FORME
    public function submit_login_form(){
        if (!isset($_SESSION['logged'])){
            $this->check_login_data();
        } else {
            header('Location: ' . Go_to::to_login_page());
        }
    }
     

    
//    -=========KREIRANJE NOVOG KORISNIKA=========

    
    
//  GLAVNA  FUNKCIJA ZA KREIRANJE NOVOG KORISNIKA
    public function create_user(){
        if (isset($_POST['create_submit'])){
          $this->get_data_for_checking();  
//            var_dump($this);
             if (!$this->username_exists()){
                 $create_query = "INSERT INTO ". self::$db_table ."  (username, password, email) ";
                 $create_query .= "VALUES ('".$this->username_for_check."','".$this->password_for_check."','". $this->email ."')";
                 
                 try {
                     $result = $this->query_to_db($create_query);
                     
                     
                     if (!$result){
                          throw new Exception ("Problem pri kreiranju korisnika"); 
                     } else {
                       echo "<h2>Korisnik uspjesno kreiran!</h2>";
                       echo "<h5><a href='". Go_to::to_login_page() ."'>Povratak na stranicu za prijavljivanje</a></h5>";
                         
                         
                     }
                   
                 } catch (Exception $e){
                     echo "Greska! " . $e->get_message();
                 }
                 
                 
                 
                 
             }  else {
                 echo "<h2>Greska! Korisnik sa unesenim korisnickim imenom vec postoji. Molimo izaberite drugo korisnicko ime.</h2>";
                  echo "<h5><a href='". Go_to::to_user_create_page() ."'>Povratak na stranicu za kreiranje naloga</a></h5>";
                  echo "<h5><a href='". Go_to::to_login_page() ."'>Povratak na stranicu za prijavljivanje</a></h5>";
                 
             }
            
        }
    }
    
    
//    =====================UPDATE KORISNIKA=====================
    
    public function update_user(){
        $array_for_update = ['email' => $_POST['new_email'], 'password' => $_POST['new_password']];
        $old_array_for_update = $array_for_update; //za kasnije poredjenje
        foreach($array_for_update as $key=>$value){
            if (!$value == ''){
                $update_query = "UPDATE " . self::$db_table;
                $update_query .= " SET " . $key . "='".$value;
                $update_query .= "' WHERE username='". $this->username();
                $update_query .= "' AND password='" . $this->password() . "'";
                var_dump($update_query);
                $result = $this->query_to_db($update_query);
                if (!$result){
                    echo "Neuspjesno! Molimo, pokusajte ponovo.";
                } 

            } else {
                unset($array_for_update[$key]);
            }
        }
        
        if (empty(array_diff($array_for_update, $old_array_for_update))){
            echo '<h3>Podaci uspjesno promjenjeni.</h3>'; 
            echo 'Povratak na <a href="profile.php">stranicu profila</a><br>';
            echo 'Povratak na <a href="../index.php">admin panel</a><br>';
            
        }
        
        
}
    
    
     
//    ----prijava na drugim stranicama-------
  //prijava na stranicama koje nisu naznacene. prima podatke iz sesije i preuzima podatke iz baze  
    public function login_from_session(){
      if (!Go_to::is_on_page("form_submit")){  
        if (session_status() == 2){
            if(!Go_to::is_on_page('login')){
        $this->username = $_SESSION['logged_user'];
        $query = "SELECT * FROM ". self::$db_table . " WHERE username = '" . $this->username . "'";
        
        $users_array = self::get_queries_object_array($query); 
        $active_user = array_shift($users_array);
        $this->email = $active_user->email;
        $this->password = $active_user->password;

//                return $active_user;
        }        
    }
    
   }
   
    
}
    
  
//    ===============POMOCNE METODE===============
   
    //uzimanje podataka iz sessiona
    private function get_data_for_checking(){
     global $connection;
     $username = $_POST['username'];
     $password = $_POST['password'];
        
     $this->username_for_check = $_POST['username'];
     $this->password_for_check = $_POST['password']; 
      
 
 } 
    
   // pronalazenje svih usera u bazi 
  public function select_all_users(){
        
        $query = "SELECT * FROM " . self::$db_table ;
        $usersArray = self::get_queries_object_array($query);
        return $usersArray;
    }   
    
    
   //pomocna fja da vidimo da li user postoji u bazi
    //koristi se kod LOGOVANJA, vraca bool
    private function user_exists(){
         $query = "SELECT * FROM " . self::$db_table   . " WHERE username = '" . $this->username_for_check . "' AND password = '" . $this->password_for_check . "'";
         
         $usersArray = static::get_queries_object_array($query); 
         return !empty($usersArray);
    }    
    
    
       //pomocna fja koja provjerava da (samo) username u bazi
    //koristi se kod KREIRANJA novog naloga
    private function username_exists(){
        $query = "SELECT * FROM " . self::$db_table   . " WHERE username = '" . $this->username_for_check . "'";
         
         $usersArray = static::get_queries_object_array($query); 
         return !empty($usersArray);
    } 
    
    
//    ==============GETTER METODE===================
    //  --getter fje za propse objekta-------------  

 public function username(){
     return $this->username;
 }
    
    
 public function email(){
     return $this->email;
 }

public function password(){
     return $this->password;
 }
    
    


    
    
//====class end====
}




?>