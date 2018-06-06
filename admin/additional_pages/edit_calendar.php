<?php include("../includes/header.php"); ?>


<!--<?php var_dump($_SESSION); ?>-->



<?php $room->get_room_data_spec(); ?>
<!--<?php var_dump($room); ?>-->

<?php $_SESSION['active_month']=$_GET['month']; ?>
<?php $_SESSION['active_year']=$_GET['year']; ?>
<?php $_SESSION['last_edit_calendar_adress']=Go_to::current_adress(); 






?>

<div class="ec_wrap">

<?php $calendar = new Calendar() ?>
<?php $calendar->get_calendar_data_spec(); ?>
<?php $prices = new Prices() ?>    

    <h1>Soba: <?php echo $room->name; ?></h1>
    <h2>Objekat: <?php echo $room->facility_name; ?></h2>
    <h3>Vlasnik: <?php echo $room->owner; ?></h3>
    
    
    
    

    <div class="ec_calendar">
        
    <h5>Mjesec: <?php echo $calendar->active_month(); ?></h5>
    <h5>Godina: <?php echo $calendar->active_year(); ?></h5>
    
            <?php if ($_SESSION['calendar_updated'] && $_SESSION['prices_updated'] ){
    echo "<h1>Uspjesno. Mozete napraviti nove izmjene.</h1>";
    //resetujem parametre
    $_SESSION['calendar_updated'] = false;
    $_SESSION['prices_updated'] = false;
} ?>
    
    
        <div class="adm_cal">
        
        <form class="ec_edit_form" method="post" action="<?php echo SITE_ADRESS; ?>/admin/additional_pages/calendar_submit.php">    
            
        <div class="calendar ec_edit_calendar_ava">
            
        <?php $prices->print_calendar($calendar->active_month(), $calendar->active_year(), $room); ?>    
            
            
        </div>
        
            <input type="submit" name="submit" value='SACUVAJ!'>
        </form> 
        
        </div>
    
    
    </div>
    
    
    
    <?php 
    

    
   ?> </div><?php


?>






































<?php include("../includes/footer.php"); ?>