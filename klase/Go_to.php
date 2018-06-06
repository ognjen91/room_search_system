<?php



class Go_to{
    
    
//    --------LINKOVI, ADRESE--------
    public static function to_admin_index(){
    $adresa =  SITE_ADRESS . "/admin/index.php";
    return $adresa;
 }   
    
  public static function to_login_page(){
      $adresa =  SITE_ADRESS . "/admin/login.php";
      return $adresa;
 }  

public static function to_logout_page(){
    $adresa =  SITE_ADRESS . "/admin/logout.php";
      return $adresa;
}


public static function to_user_create_page(){
    $adresa =  SITE_ADRESS . "/admin/additional_pages/create_user.php";
      return $adresa;
}

public static function to_profile_page(){
    $adresa =  SITE_ADRESS . "/admin/additional_pages/profile.php";
      return $adresa;
}


    
  public static function site_root(){  
    $adress = $_SERVER['HTTP_HOST'] . "/oop";
      return $adress;
  }
    
    
    
  
    //vraca mjesto headera
public static function header_location(){
   $path = SITE_ROOT;
   $path .= "/admin/includes/header.php";
   return $path;
}
    

//    ---PROVJERA NA KOJOJ STRANICI SE TRENUTNO NALAZI PREGLEDAC------
//treba ubaciti naziv stranice pod navodnicima
public static function is_on_page($name_of_page){
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    return strpos($url, $name_of_page);
}



//----SLUCAJAN BROJ----------
    //korisno za novo ime slike
    
    public static function random_number(){
        $random_number1 = rand(1,1000);
       $random_number2 = rand(1,1000);
       $random_number3 = rand(1,10);
       $random_number = $random_number1 * $random_number2 * $random_number3;
        
        return $random_number;
    }



//  ---------trenutna adresa------ (sa stack-a...)
public static function current_adress(){
   return $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

}



}
















?>