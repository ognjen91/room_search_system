<?php

/*

CIJENA ARANZMANA IZMEDJU 2 DATUMA
arrangement_price
sastoji se iz 2 dijela: arrival_month_price
                        other_months_prices
  
CIJENE I POPUSTI ZA DATUME
 all_prices : vraca array elemenata dan_u_mjesecu=>cijena, a $this->$month_prices primi vrijednost arraya dan=>cijena, a $this->$month_discounts da primi vr. arraya dan=>popust

STAMPANJE KALENDARA SA CIJENAMA I POPUSTIMA
print_calendar : stampa kalendar sa sve podacima o cjenama i popustima u data html atributima
 
UPDATE CIJENA I POPUSTA
prices_submit 
 

*/

class Prices extends Calendar {
public $january_prices;
public $february_prices;
public $march_prices;
public $april_prices;
public $may_prices;
public $june_prices;
public $july_prices;
public $august_prices;
public $september_prices;
public $october_prices;
public $november_prices;
public $december_prices;
public $january_discounts;
public $february_discounts;
public $march_discounts;
public $april_discounts;
public $may_discounts;
public $june_discounts;
public $july_discounts;
public $august_discounts;
public $september_discounts;
public $october_discounts;
public $november_discounts;
public $december_discounts;    
protected static $db_table = "prices";  

private $arrival_date;
private $departure_date;    
    
//   =================================================== 
//    ===========CIJENA ARANZMANA=======
//   =================================================== 

    //cijena se formira iz dva dijela: 
    //1. dio dolaznog mjeseca (sigurno postoji)
//    2. dio ostalih mjeseci (ako postoje)
    
    //$date1 je dolazni datum, $date2 odlazni

public function arrangement_price(DateTime $date1,DateTime $date2, Room $room_for_check){
    global $calendar;
    $total_price = 0;
    $arrival_day = $date1->format("j");
    $departure_day = $date2->format("j");
    $arrival_month = $date1->format('F');
    $arrival_month = strtolower($arrival_month);
    $departure_month =  $date2->format('F');
    $departure_month = strtolower($departure_month);
    $year = $date1->format('Y');
    $this->arrival_date = $date1;
    $this->departure_date = $date2;
    $total_price = 0;
   
 //!!! ovdje se mora klonirati objekat, jer je u varijabli sacuvana referenca na objekat, tj nije sacuvan prvobitni objekat u toj varijabli
     $this->arrival_date = clone $date1;
     $this->departure_date = clone $date2;
    
    
     $months_between = self::months_between($date1, $date2);
//    var_dump($months_between );
    
    
    //DOLAZNI MJESEC - SIGURNO POSTOJI
    
    $total_price += $this->arrival_month_price($this->arrival_date, $this->departure_date, $room_for_check);
    echo "<h1>$total_price</h1>";
    

   
    //DIO ZA OSTALE MJESECE (ako postoje)
    
    if ($arrival_month !== $departure_month){
          $total_price += $this->other_months_prices($this->arrival_date, $this->departure_date, $room_for_check);
          echo "<h1>$total_price</h1>";
   } 

        return $total_price;

// 
  
}    
    
   
    
//    ----CIJENA U POCETNOM MJESECU-------------------
    private function arrival_month_price(DateTime $date1,DateTime $date2, Room $room_for_check){
       global $calendar;
       $arrival_day = $date1->format("j");
       $departure_day = $date2->format("j");
       $arrival_month = $date1->format('F');
       $arrival_month = strtolower($arrival_month);        
       $departure_month =  $date2->format('F');
       $departure_month = strtolower($departure_month);
       $price = 0;
       $year = $date1->format('Y');
       $month_prices_n_disc = $this->all_prices($arrival_month, $year,        $room_for_check);//ucitavam propse $month_prices i $month_discounts (month je mjesec)
       $month_prices = $arrival_month . "_prices";
       $month_discounts = $arrival_month . "_discounts";

        //    broj iteracija zavisi da li se aranzman zavrsava u tom prvom mjesecu
      $days_in_month = ($arrival_month == $departure_month)? $departure_day : self::no_of_days_in_month($arrival_month, $year);
               for ($i=$arrival_day; $i<=$days_in_month; $i++){
    
        
                 $price += $this->$month_prices[$i] - $this->$month_discounts[$i]/100*$this->$month_prices[$i];
                        echo "first month " . $i . " : ".$this->$month_prices[$i] . " - " .  $this->$month_discounts[$i]. "<br>";  
                        echo "price: " . $price . "<br>"; 
                 }
       
        return $price;
   }   
    
    
//  -----------------CIJENA U OSTALIM MJESECIMA-------------------  
    
    private function other_months_prices(DateTime $date1,DateTime $date2, Room $room_for_check){
         global $calendar;
         $arrival_day = $date1->format("j");
         $departure_day = $date2->format("j");
         $arrival_month = $date1->format('F');
         $arrival_month = strtolower($arrival_month);
         $year = $date1->format('Y');
         $price = 0;
         $months_between = self::months_between($date1, $date2);  
         $departure_month =  $date2->format('F');
         $departure_month = strtolower($departure_month);
//         var_dump($months_between);
        
    foreach($months_between as $year=>$months){
         
         foreach($months as $month){
            echo $month . "<br>";
            if ($month == $arrival_month) continue; 
            $month_prices = $month . "_prices";
            $month_discounts = $month . "_discounts";

//            echo $year ."..." .$month. "... <br>";
            $month_prices_n_disc = $this->all_prices($month, $year, $room_for_check); //ucitavam propse $month_prices i $month_discounts (month je mjesec)
            $month_prices = $month . "_prices";
            $month_discounts = $month . "_discounts";
            
            //ako je posljednji mjesec, iterirace se do polaznog dana
            $days_in_month = ($month == $departure_month)? $departure_day : self::no_of_days_in_month($month, $year);
            
            for ($i=1; $i<=$days_in_month; $i++){
                $price += $this->$month_prices[$i] - $this->$month_discounts[$i]/100*$this->$month_prices[$i];
                  echo "month ". $month . " day " . $i . " : ".$this->$month_prices[$i] . " - " .  $this->$month_discounts[$i]. "<br>"; 
                echo "price: " . $price . "<br>"; 
            }
            
            
//            var_dump($this->$month_prices);
//            var_dump($this->$month_discounts);
        }
    }
        echo "<h2>$price</h2>";
        return $price;
        
    }
    
    
    
    
//    ============================================================
//     =================CIJENE I POPUSTI ZA DATUME=================
//    ============================================================    


// da $this->$month_prics primi vrijednost arraya dan=>cijena, a $this->$month_discounts da primi vr. arraya dan=>popust
  //vraca array elemenata dan_u_mjesecu=>cijena
public function all_prices(string $month, int $year, Room $room_for_check){
    $days_prices_n_disc = $this->row_to_days($month, $year, $room_for_check); //dobijam array sa vrijednostima dan:cijena=>popust

  $day_price_disc_array = array();
    
    foreach ($days_prices_n_disc as $day_price_n_disc){
         $day_price_disc_array[] = preg_split( "/[:-]/", $day_price_n_disc);
    } //dobijam array arrayeva, a jedini elementi u tim (konacnim) arrayevima su [0]dan, [1] cijena i [2] popust u procentima
//        var_dump($day_price_disc_array);
//    
    $day_price_array_final = array();
    $day_discount_array_final = array();
    
    foreach ($day_price_disc_array as $day_price_disc){
        $day_price_array_final[$day_price_disc[0]]  =  $day_price_disc[1]; 
        $day_discount_array_final[$day_price_disc[0]]  =  $day_price_disc[2]; 
        
        
    }
 
          $month_prices = $month . "_prices";  
          $month_discounts = $month . "_discounts";  
          $this->$month_prices =  $day_price_array_final;
          $this->$month_discounts =  $day_discount_array_final;
//          var_dump($this->$month_discounts);
//          var_dump($this->$month_prices);
    
          return ($this->$month_prices && $this->$month_discounts);
//          return $day_price_array_final;
  

}
    
    
    
    
    
    
    
    
    
//   ========================================================================== 
// ==============STAMPANJE KALENDARA ZA DATU SOBU, MJESEC I GODINU, SA CIJENAMA I POPUSTIMA====
//    ==========================================================================   
    
       public function print_calendar(string $month, int $year, Room $room_for_check){
          global $calendar;
        
        
          
        $month_days = static::no_of_days_in_month($month, $year);
         
        $unav_dates = $calendar->unav_days_to_dates($month, $year, $room_for_check);
        $prices_n_discounts = $this->all_prices($month, $year, $room_for_check); 
        if (!$prices_n_discounts) return;   
           
//           var_dump($calendar->february);
//           var_dump($this->february_prices);
//           var_dump($this->february_discounts);
          
        if (!$unav_dates){
            echo "Dostupnost soba nije definisna za dati mjesec i/ili sobu";
            return;
        }  
          
        //STAMPANJE "PRAZNIH DANA"
         for ($i=1; $i<=$this->empty_days($month, $year); $i++){
                echo "<div class='cal_date empty_date'> </div>";
         }
                
                   
        $unav_days = array();   
        foreach($unav_dates as $unav_date){
            if (!$unav_date) continue;
            $unav_days[$unav_date->format('j')] = false;
        } 
         
        $month_prices = $month . "_prices";   
        $month_discounts = $month . "_discounts";   
          
           
//        var_dump($unav_days);
            for ($i=1; $i<= $month_days; $i++){
                $ava_class = array_key_exists($i, $unav_days)? "unava_date" : "ava_date";
//                
//                
                echo "<div class='cal_date ".$ava_class."' data-price='".$this->$month_prices[$i]."' data-discount='".$this->$month_discounts[$i]."'> $i </div>";
               }
         
          /*  */    

    }
    

//===============================================================
//    ===================UPDATE CIJENA I POPUSTA===========================
//==================================================================
    
   public function prices_submit($room){
       global $calendar;
       
       
      $update_query = "UPDATE " . self::$db_table . " SET " . $calendar->active_month() . "='";
       
//       echo "MJESEC: "; var_dump($month);
       
      $days_in_month = $this->no_of_days_in_month($calendar->active_month(), $calendar->active_year());     
      for ($i=1; $i<=$days_in_month ; $i++){
          $day_price = $_POST['price'][$i-1]; //jer pocinje od 0
          $day_discount = $_POST['discount'][$i-1];

          $query_content = "$i:$day_price-$day_discount";
          $query_content .= ($i !== ($days_in_month))? "," : null;
//                    echo  $query_content;
          $update_query .= $query_content;
          
      }
       $update_query .= "'
       WHERE room_name = '" . $room->name . "'";
       $update_query .= " AND facility_name = '" . $room->facility_name . "'";
       $update_query .= " AND owner = '" . $room->get_owner() . "'";
       $update_query .= " AND year = '" . $calendar->active_year() . "'";
//       echo $update_query . "<br>";
       
       return $this->update_query_to_db($update_query);
 
   }










// pomocna test metoda
    
public function test2(){
    global $room;
    global $calendar;
    $date1 = new DateTime('2019-04-15');
    $date2 = new DateTime('2020-08-20');
//    $this->all_prices("february", 2019, $room);
//    $x = $calendar->is_reservtion_possible( $date1,$date2, $room);
//    var_dump($x);
//    $this->print_calendar("april", 2019, $room);
    $this->arrangement_price($date1, $date2, $room);
}








//==========class end=====
}

?>