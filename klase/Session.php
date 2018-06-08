<?php

/*
get_session_status - vraca status sesije
set_user_session - podesava sesiju
log_out - za odjavljivanje korisnika i unistavanje sesije

*/

class Session {
    public $username;
    public $password;
    
    private $logged = false;
    
    
    private function get_session_status(){
        if (isset($_SESSION['logged'])){
            return $_SESSION['logged'];
        }
        
    }

    
    //settovanje sesije
    public function set_user_session(){
    global $user;
         if (!GO_to::is_on_page("login") || !GO_to::is_on_page("login")){
             
         if ($this->get_session_status()){
             $this->logged = true;
             $this->username = $_SESSION['logged_user'];
//             echo "ULOGOVAN";
                 
             } else {
              !Go_to::is_on_page('login')? header('Location: '. Go_to::to_login_page()) : null;
             
         }
             }
         }
    

    
    
//  LOGOUT FUNKCIJA
    public function log_out(){
        
        session_destroy();
        header('Location: '. Go_to::to_login_page());
//        header('Location: '. );
    }
    



//====class end====
}
?>