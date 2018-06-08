<?php include("../includes/header.php"); ?>


<?php 

//var_dump($active_room);

isset($_POST['submit-editroom'])?$room->update_room() : null;

$active_room=$room->room_for_edit();
//var_dump($active_room);
$_SESSION['active_room'] = $_GET['room'];

$_SESSION['active_room_old'] = $active_room->public_object_props(); //za poredjenje koji su podaci zapravo promjenjeni
?>
<div class="er_wrap">




    <div class="er_edit_data">
        <h4 id="er_see_calendars"><a href="<?php echo SITE_ADRESS; ?>/admin/additional_pages/room_calendars.php?room=<?php echo $room->get_room_name(); ?>&facility=<?php echo $room->get_facility(); ?>&owner=<?php echo $room->get_owner; ?>">POGLEDAJTE I MIJENJAJTE SLOBODNE TERMINE, CIJENE I POPUSTE</a></h4>
        <form method="POST" action="" enctype="multipart/form-data">
            <p>Naziv sobe: <span id="er_room_name"><?php echo $active_room->get_room_name(); ?></span>
                <p>Objekat: <span id="er_room_facility"><?php echo $active_room->get_facility(); ?></span>
                    <p>Vlasnik: <span id="er_room_owner"><?php echo $active_room->get_owner(); ?></span>
                        <p>
                            <br> Klima uredjaj:  
                            <select name="air_conditioner">
  <option value="<?php echo $active_room->air_conditioner; ?>" class="er_active_value"></option>
  <option class="er_other_value"></option>
</select>
                            <br> Kuhinja:
                            <select name="kitchen">
  <option value="<?php echo $active_room->kitchen; ?>" class="er_active_value"></option>
  <option class="er_other_value"></option>
</select>
                            <br> Zasebno kupatilo:
                            <select name="bathroom">
  <option value="<?php echo $active_room->bathroom; ?>" class="er_active_value"></option>
  <option class="er_other_value"></option>
</select>
                            <br> Tv:
                            <select name="tv">
  <option value="<?php echo $active_room->tv; ?>" class="er_active_value"></option>
  <option class="er_other_value"></option>
</select>
                            <br> Terasa:
                            <select name="terace">
  <option value="<?php echo $active_room->terace; ?>" class="er_active_value"></option>
  <option class="er_other_value"></option>
</select>
                            <br> Broj kreveta:<br>
                            <input type="text" name="no_of_beds" value="<?php echo $active_room->no_of_beds; ?>">
                            <br> Ostale pogodnosti srpski:<br>
                            <textarea cols="40" rows="5" name="other_amenities_srb">
      <?php echo $active_room->other_amenities_srb; ?>
</textarea>
                            <br> Ostale pogodnosti engleski:<br>
                            <textarea cols="40" rows="5" name="other_amenities_eng">
      <?php echo $active_room->other_amenities_eng; ?>
</textarea>
                            <br> Opis na srpskom:<br>
                            <textarea cols="40" rows="5" name="description_srb">
       <?php echo $active_room->description_srb; ?>
</textarea>
                            <br> Opis na engleskom:<br>
                            <textarea cols="40" rows="5" name="description_eng">
   <?php echo $active_room->description_eng; ?>
</textarea>
                            <br>


                            <br>
                            <input type="submit" value="PRIHVATI PROMJENE" name="submit-editroom">
        </form>

    </div>








    <div class="er_images">
        
        <h4 id="er_add_new_img"><a href="<?php echo SITE_ADRESS; ?>/admin/additional_pages/add_room_image.php?room=<?php echo $room->get_room_name(); ?>&facility=<?php echo $room->get_facility(); ?>&owner=<?php echo $room->get_owner(); ?>">DODAJTE NOVE SLIKE SOBE</a></h4>
        <?php $calendar = new Calendar(); ?>
        <?php $prices = new Prices(); ?>

        <?php 
//var_dump($prices->april_prices);
?>

<?php require SITE_ROOT."/admin/additional_pages/add_includes/er_images.php"; ?>


    </div>




  



</div>
  <?php require SITE_ROOT."/admin/includes/footer.php"; ?>