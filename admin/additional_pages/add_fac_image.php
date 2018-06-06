<?php include("../includes/header.php"); ?>

<?php $active_fac = $facility->facility_for_edit(); ?>
<h4>Pozdrav,
    <?php echo $user->username(); ?>. Nove slike mozete dodati klikom na "DODAJ NOVU SLIKU."<br> Na kraju, pritisnite "SACUVAJ IZMJENE" da bi sacuvali izmjene.</h4>

<form method="POST" action="facility_submit.php" enctype="multipart/form-data">

    Naziv objekta:<br>
    <select name="facility_name">
        <option>
<?php echo $active_fac->facility_name; ?>
      </option>
    
    </select>
    
    
    <div class="form-addimage">
        <br> Nova Slika:<br>
        <div class="new_image_add_wrap">
            <div class="new_image_add">
                <input class="input_file" type="file" name="new_fac_image[]">
                <br> Kratak opis (do 150 karaktera) - srpski:<br>
                <textarea cols="40" rows="5" name="description_srb[]" maxlength="150" value=" ">
  
                </textarea>
                <br> Kratak opis (do 150 karaktera) - engleski:<br>
                <textarea cols="40" rows="5" name="description_eng[]" maxlength="150" value=" ">
  
                </textarea>
                <br>
                <div class='new_img_btn'>DODAJ NOVU SLIKU</div>
            </div>
        </div>
    </div>


    <input type="submit" value="SACUVAJ IZMJENE" name="submit-facilityimage">

</form>










<?php include("../includes/footer.php"); ?>
