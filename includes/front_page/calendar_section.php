
<div class="fp_calendar fp_arrival_calendar">
    <div class="calendar_choice">
        <select class="calendar_month">
    <?php foreach(Calendar::$db_table_months as $month){
    $correct_month_name = Calendar::correct_month_name($month);
      echo "<option value='$month'>$correct_month_name</option>";
}
    ?>
    </select>

        <select class="calendar_year">
    <?php foreach(Calendar::$db_table_years as $year){
      echo "<option value='$year'>$year</option>";
}
    ?>
    </select>



    </div>






    <div class="fp_calendars_wrap">
    <div class="fp_calendars_holder">
        <?php $fp_calendar = new Calendar(); 
    
        
        
        
    foreach (Calendar::$db_table_years as $year){
      foreach (Calendar::$db_table_months as $month){
          
          
        
          ?>
        
        
        <div class="calendar_blanc_wrap">
            <?php
          $correct_month_name = Calendar::correct_month_name($month);
//          echo "<h5> $correct_month_name $year</h5>";
          ?>

                <div class="calendar_blanc calendar" data-month='<?php echo $month;?>' data-year='<?php echo $year;?>'>
                    <?php
          
         $fp_calendar->print_blanc_calendar($month, $year);
          ?>
                </div>

        </div>
    
        <?php
          
       }
        
    }



?>

  </div>
</div>
</div>

<div class="fp_calendar fp_departure_calendar">
    <div class="calendar_choice">
        <select class="calendar_month">
    <?php foreach(Calendar::$db_table_months as $month){
    $correct_month_name = Calendar::correct_month_name($month);
      echo "<option value='$month'>$correct_month_name</option>";
}
    ?>
    </select>

        <select class="calendar_year">
    <?php foreach(Calendar::$db_table_years as $year){
      echo "<option value='$year'>$year</option>";
}
    ?>
    </select>



    </div>






    <div class="fp_calendars_wrap">
    <div class="fp_calendars_holder">
        <?php $fp_calendar = new Calendar(); 
    
        
        
        
    foreach (Calendar::$db_table_years as $year){
      foreach (Calendar::$db_table_months as $month){
          
          
        
          ?>
        
        
        <div class="calendar_blanc_wrap">
            <?php
          $correct_month_name = Calendar::correct_month_name($month);
//          echo "<h5> $correct_month_name $year</h5>";
          ?>

                <div class="calendar_blanc calendar" data-month='<?php echo $month;?>' data-year='<?php echo $year;?>'>
                    <?php
          
         $fp_calendar->print_blanc_calendar($month, $year);
          ?>
                </div>

        </div>
    
        <?php
          
       }
        
    }



?>

  </div>
</div>
</div>


