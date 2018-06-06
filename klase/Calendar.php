<?php


//metode:
//-koja vraca niz objekata zauzetih dana u mjesecu (unav_days_to_dates)
//-vraca t/f mogucnost rezervacije (is_reservtion_possible)
//lista mjesece u kojim je aranzman (months_between)
//provjerava koji datum je kasnii (is_date_greater)
//vraca array sa svim objektima svih zauzetih datuma za sobu (all_unavailable_dates)
//za broj dana u mjesecu (no_of_days_in_month)
//vraca broj mjeseca (month_str_to_int)
//vraca broj praznih dana na pocetku mjseca (empty_days)
//stampanje cistog kalendar (print_blanc_calendar)

class Calendar extends Db_object {
private $room_name;
private $facility_name;
private $owner;
public $year;
public $january;
public $february;
public $march;
public $april;
public $may;
public $june;
public $july;
public $august;
public $september;
public $october;
public $november;
public $december;
protected $active_month;
protected $active_year;
public $all_unava_dates = array();
    
    
protected static $db_table = "calendars";
protected static $db_table_fields = ['room_name','facility_name', 'owner', 'year', 'january', 'february', '$march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
public static $db_table_months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
public static $serbian_months = ['Januar', 'Februar', 'Mart', 'April', 'May', 'Jun', 'Jul', 'Avgust', 'Septembar', 'Oktobar', 'Novembar', 'Decembar'];
public static $russian_months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
public static $db_table_years = [2019, 2020, 2021, 2022, 2023]; //po potrebi dodajem godine


    
//===================================================================================ZAUZETI DANI U MJESECU===============================================================
//za uneseni mjesec i godinu, vraca array sa stringovima zauzetih dana u mjesecu
protected function row_to_days(string $month, int $year, Room $room_for_check){
    $this->get_calendar_data();
    
    $query = "SELECT * FROM " . static::$db_table . " WHERE ";
    $query .= "facility_name='". $room_for_check->facility_name. "' AND room_name='". $room_for_check->name. "' AND owner='" . $room_for_check->owner."'";
    $query .= " AND year='". $year."'";

    //rezultat queya je objekat sa svim mjesecima
    $result_object = self::find_specific_full_query($query);
    if (!$result_object){
        return;
    }
    
    $unav_dates_str = $result_object->$month;
//var_dump($unav_dates_str);
    $unav_dates_array = explode(",",$unav_dates_str);
   
//    var_dump($unav_dates_array);
    return $unav_dates_array? $unav_dates_array : null;
    
}

    //GLAVNA FJA ZA ZAUZETE DANE JEDNOG MJESECA
//pretvaranje zauzetih dana u mjesecu u array sa datumima
    //vraca array sa zauzetim datumima u mjesecu (datumi su objekti DateTime-a)
    //podesava i $this->$month da ima vrijednost arraya zauzetih dana
protected  function unav_days_to_dates(string $month, int $year, Room $room_for_check){
    $days = $this->row_to_days($month, $year, $room_for_check);
//   var_dump($days);
    if (!$days){
        return;
    }

    $this->year = $year;
    $this->active_month = $month;

    $unav_dates_in_month = array();
    
    foreach($days as $day){
         $fixed_month = ucfirst ($this->active_month);   
         $date_string = $day."/".$fixed_month."/".$this->year;
         $new_date = DateTime::createFromFormat('d/M/Y', $date_string);
//            var_dump($new_date);
        $unav_dates_in_month[] = $new_date;
//        var_dump($new_date->format('d/M/Y'));

 //OVIM SU NAPRAVLJENI DATUMI ZA POREDJENJE OD UNESENIH ARGUMENATA
    }
//    var_dump($unav_dates_in_month);
   $this->$month = $unav_dates_in_month;
   return $unav_dates_in_month;
}

                      
       
//    ================================================================================MOGUCNOST   ARANZMANA=============================================================================
   //provjerava da li izmedju 2 dana ima zauzetih dana --->da li je moguc aranzman
    //vraca bool
protected function is_reservtion_possible(DateTime $date1, DateTime  $date2, Room $room_for_check){
    $unavailable_dates = $this->all_unavailable_dates($room_for_check);
//    var_dump($unavailable_dates);                                           
    $unav_dates_between = array();
    foreach($unavailable_dates as $the_date){
        if (self::is_date_greater($the_date, $date1) && self::is_date_greater($date2, $the_date)){
            $unav_dates_between[] = $the_date;
        }
    }
//    var_dump($unav_dates_between);
    return empty($unav_dates_between);
}


//=========stampanje cistog kalendara=============
public function print_blanc_calendar(string $month, int $year){
       
               $month_days = static::no_of_days_in_month($month, $year); 
               $empty_days = $this->empty_days($month, $year);
               for ($i=1; $i<=$empty_days; $i++){
                echo "<div class='cal_date empty_date'> </div>";
         }
               
               
               for ($i=1; $i<=$month_days; $i++){
                   echo "<div class='cal_date cal_blanc_date'>";
                   echo $i;
                   echo "</div>";
               }
           }
      

//    =====================================
//    ============POMOCNE METODE==============
//    ====================================
        




    //==============MJESECI IZMEDJU DVA DATUMA============
    //treba da vrati array u kom se nalaze mjeseci u kojim se nalazi aranzman, NE RACUNAJUCI POCETNI MJESEC
    protected static function months_between(DateTime $date1, DateTime $date2){
        

        $months_between = array();
        $m1 = $date1->format('n');
        $m2 = $date2->format('n');
        $y1 = $date1->format('Y');
        $y2 = $date2->format('Y');
        echo "<h5>1: $m1 $y1  2: $m2 $y2</h5>";
        
        $total_months_between = $m2-$m1 + ($y2-$y1)*12 ;
//        echo "<h5>ukupno izmedju $total_months_between</h5>";
        
        $date1->modify('first day of this month');
        $date2->modify('first day of this month');
        $date1->modify('+1 month');

for ($i=1; $i<=$total_months_between; $i++){
            $month = $date1->format('F');
            $month = strtolower($month);
            $year = $date1->format('Y');
            
            $months_between[$year][] = $month;
            $date1->modify('+1 month');
        }

            
//            var_dump($months_between);
            return $months_between;

        }
        
        

                            
                            
//           ----------KOJI DATUM JE KASNIJI---------   
     //provjerava da li je $date1 veci ili jednak od $date2, vraca bool
    protected static function is_date_greater(DateTime $date1, DateTime $date2){
       
        return $date1->format("Ymd") >= $date2->format("Ymd");
        
//        var_dump($date1->format("Ymd"));
      
        
    }
    
    
//    ===============SVI ZAUZETI DATUMI ZA SOBU=========
    //    ==============metoda za izlistavanje svih zauzetih datuma. vraca array sa objektima zauzetih datuma===== 
    protected function all_unavailable_dates($room_for_check){
       $all_unavailable_dates = array();
        
        foreach (self::$db_table_months as $month){
            foreach (self::$db_table_years as $year){
              $unav_dates = $this->unav_days_to_dates($month, $year, $room_for_check);
//                var_dump($unav_dates);
                if (!$unav_dates) continue; //otarasim se onih koji su null
//                var_dump($unav_dates);
                foreach ($unav_dates as $unav_date){  
                  if (is_bool($unav_date)) continue;
                $all_unavailable_dates[] = $unav_date;
         }
        }
          
    }
        return  $all_unavailable_dates;
    }
    
    
    
    
//    ==============metoda za broj dana u mjesecu=======

    
    protected static function no_of_days_in_month(string $month, $year){
        $month = static::month_str_to_int($month);
        $number = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
        return $number;
    }
//         =====================fje za pretvranje imena mjeseci string/int=========           
    protected static function month_str_to_int(string $month){
        $month = strtolower($month);
switch ($month) {
    case "january":
        $month_int = 1;
        break;
    case "february":
        $month_int = 2;
        break;
    case "march":
        $month_int = 3;
        break;
    case "april":
        $month_int = 4;
        break;
    case "may":
        $month_int = 5;
        break;
    case "june":
        $month_int = 6;
        break;
    case "july":
        $month_int = 7;
        break;
    case "august":
        $month_int = 8;
        break;
    case "september":
        $month_int = 9;
        break;
    case "october":
        $month_int = 10;
        break;
    case "november":
        $month_int = 11;
        break;
    case "december":
        $month_int = 12;
        break;
    default: die("wrong month name");

            
           
              } 
           return $month_int;
          }                             
          
    //          =====================prazni dani====================
    
    //       ---------------pomocna metoda za stampanje 'praznih dana' na pocetku mjeseca------                   
        public function empty_days(string $month, int $year){
            $active_month = static::month_str_to_int($month);
            $first_date_of_month = new DateTime("$year-$month-1");
            $first_day_of_month = $first_date_of_month->format('D');
            switch ($first_day_of_month) {
             case "Mon":
             $empty_days = 0;
             break;
             case "Tue":
             $empty_days = 1;
             break;
             case "Wed":
             $empty_days = 2;
             break;
             case "Thu":
             $empty_days = 3;
             break;
             case "Fri":
             $empty_days = 4;
             break
              ;case "Sat":
             $empty_days = 5;
             break;
             case "Sun":
             $empty_days = 6;
             break;
             default: die("wrong m/y format");
        }                    
              return $empty_days;  
            
        }    

//    ============GLAVNA METODA ZA PODATKE KALENDARA============
         protected function get_calendar_data(){
        global $user;
        
        
        if (Go_to::is_on_page("edit_room")){
            $this->room_name = $_GET['room'];
            $this->owner = $user->username();
            $this->facility_name = $_SESSION['active_fac'] ;
//            $this->room = $user->username()";
//            var_dump($_SESSION);
//            var_dump($this);
        }
         
            
             

 }

                            

          public function get_calendar_data_spec(){

        if (Go_to::is_on_page("edit_calendar")){
           
            $this->active_month = $_GET['month'];
            $this->active_year = $_GET['year']; 
               
          
        }
               if (Go_to::is_on_page("calendar_submit")){
           
            $this->active_month = $_SESSION['active_month'];
            $this->active_year = $_SESSION['active_year']; 
//            echo "MIJESECCCCCC " . $this->active_month;   
          
        }
          }
                      
              //    ====pomocna test metoda=========
    public function test(){
        global $room;
//        $unav_dates = self::unav_days_to_dates("february", 2019, $room);
//        var_dump($unav_dates);
//        var_dump(self::all_unavailable_dates());
        
        
        $date1 = new DateTime('2019-02-12');
        $date2 = new DateTime('2021-01-18');
//        $months_between = $this->months_between($date1, $date2, $room);
//        $x = self::compare_two_dates($date1, $date2);
//        var_dump($x);
        
//        $all_unav = $this->all_unavailable_dates($room);
//        $x = $this->is_reservtion_possible($date1, $date2, $room);
//        var_dump($x);
        
//     $this->print_calendars   

    }              
                            
                               
                            
public function active_month(){
    return $this->active_month;
}
public function active_year(){
    return $this->active_year;
}
                            
 
    
   public function availability_submit($room){
       
  $update_query = "UPDATE " . self::$db_table . " SET " . $this->active_month() . "='";
       
//       echo "MJESEC: "; var_dump($month);
       
      $days_in_month = $this->no_of_days_in_month($this->active_month(), $this->active_year());     
      for ($i=1; $i<=$days_in_month ; $i++){
          $availability = $_POST['availability'][$i-1]; //jer pocinje od 0
          $availability = boolval($availability); 
//          var_dump($availability);
          if (!$availability){
          $query_content = "$i,";
          
//                    echo  $query_content;
          $update_query .= $query_content;
          }
      }
       $update_query .= "'
       WHERE room_name = '" . $room->name . "'";
       $update_query .= " AND facility_name = '" . $room->facility_name . "'";
       $update_query .= " AND owner = '" . $room->owner . "'";
       $update_query .= " AND year = '" . $this->active_year() . "'";
//       echo $update_query . "<br>";
       
       return $this->update_query_to_db($update_query);
 
   }
             
    
//    ---------CORRECT NAMES OF MONTHS----------
//    pravilni nazivi mjeseci za frontend
    //glavni jezik sajta je srpski, drugi je engleski
    public static function correct_month_name($month){
       for ($i=0; $i<=count(self::$db_table_months); $i++){
           if ($month == self::$db_table_months[$i]){
               $correct = (isset($_GET['lang']) && $_GET['lang']=='en')? ucfirst($month) : self::$serbian_months[$i];
               if ((isset($_GET['lang']) && $_GET['lang']=='ru')) $correct = self::$russian_months[$i];
               return $correct;
           }
       }
        
    }
    
                            
//       ====class end====                       
              }  
    
    
    
    
    
    
                            
                            
          

?>











