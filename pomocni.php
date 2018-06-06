<?php

public function arrangement_price(DateTime $date1,DateTime $date2, Room $room_for_check){
    global $calendar;
    $arrival_day = $date1->format("j");
    $departure_day = $date2->format("j");
    $price = 0;
    
    
    $arrival_month = $date1->format('F');
    $arrival_month = strtolower($arrival_month);
    $departure_month =  $date2->format('F');
    $departure_month = strtolower($departure_month);
    $year = $date1->format('Y');
     $months_between = self::months_between($date1, $date2);
    var_dump($months_between );
    
    
    //DOLAZNI MJESEC - SIGURNO POSTOJI
    $month_prices_n_disc = $this->all_prices($arrival_month, $year, $room_for_check);//ucitavam propse $month_prices i $month_discounts (month je mjesec)
    
    
    
    $month_prices = $arrival_month . "_prices";
    
    $month_discounts = $arrival_month . "_discounts";

//    broj iteracija zavisi da li se aranzman zavrsava u tom prvom mjesecu
    $days_in_month = ($arrival_month == $departure_month)? $departure_day : self::no_of_days_in_month($arrival_month, $year);
    for ($i=$arrival_day; $i<=$days_in_month; $i++){
    
        
    $price += $this->$month_prices[$i] - $this->$month_discounts[$i]/100*$this->$month_prices[$i];
                        echo "first month " . $i . " : ".$this->$month_prices[$i] . " - " .  $this->$month_discounts[$i]. "<br>";  
                        echo "price: " . $price . "<br>"; 
    }
    
    
    //        var_dump($unav_days);
            for ($i=1; $i<= $month_days; $i++){
                $ava_class = array_key_exists($i, $unav_days)? "unava_date" : "ava_date";
//                
//                
                echo "<div class='cal_date ".$ava_class."' data-price='".$this->$month_prices[$i]."' data-discount='".$this->$month_discounts[$i]."'> $i </div>";
               }
         
          /*  */    

    }
    


?>