<?php include("../includes/header.php"); ?>


<!--<?php var_dump($_SESSION); ?>-->



<?php $room->get_room_data_spec(); ?>
<!--<?php var_dump($room); ?>-->



<div class="admin_calendars_wrap">

<?php $calendar = new Calendar() ?>
<?php $prices = new Prices() ?>    

<?php foreach(Calendar::$db_table_years as $year){
    
    ?> <div class="ac_year">
    <?php echo "<div class='ac_display_year'><h1>$year<h1></div>"; ?> 
     <div class="ac_calendars_for_year">
    <?php
   
        foreach(Calendar::$db_table_months as $month){
   ?>
    
    <div class="ac_wrap">
    <h5>Mjesec: <?php echo $month; ?></h5>
    <h5>Godina: <?php echo $year; ?></h5>
    <h4 id="er_see_calendars"><a href="<?php echo SITE_ADRESS; ?>/admin/additional_pages/edit_calendar.php?room=<?php echo $room->name; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>">PROMJENITE DOSTUPNOST, CIJENE I POPUSTE ZA MJESEC</a></h4>    
    
        <div class="adm_cal">
        
        <div class="calendar">
            
        <?php $prices->print_calendar($month, $year, $room); ?>    
            
            
        </div>
        
        
        
        </div>
    
    
    </div>
    
    
    
    <?php 
    
}
    
   ?> </div></div><?php
}

?>









</div>




























<?php include("../includes/footer.php"); ?>