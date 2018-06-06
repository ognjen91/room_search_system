<?php include("../includes/header.php"); ?>


<h4>Pozdrav,
    <?php echo $user->username(); ?>. Nove slike mozete dodati klikom na "DODAJ NOVU SLIKU."<br> Na kraju, pritisnite "SACUVAJ IZMJENE" da bi sacuvali izmjene.</h4>
<?php $active_room = $room->room_for_edit();  ?>
<form method="POST" action="facility_submit.php" enctype="multipart/form-data">

    Naziv objekta:<br>
    <select name="facility_name">
<?php 
     echo "<option>" . $active_room->facility_name . "</option>";
    ?>
    </select>
    <br>
        <select name="room_name">
<?php 
        echo "<option>" . $active_room->name .  "</option>";
    
    ?>
    </select>
    
    
    <div class="form-addimage">
        <br> Nova Slika:<br>
        <div class="new_image_add_wrap">
            <div class="new_image_add">
                <input class="input_file" type="file" name="new_room_image[]">
               
              
                <br>
                <div class='new_img_btn'>DODAJ NOVU SLIKU</div>
            </div>
        </div>
    </div>


    <input type="submit" value="SACUVAJ IZMJENE" name="submit-roomimage">

</form>










<?php include("../includes/footer.php"); ?>
