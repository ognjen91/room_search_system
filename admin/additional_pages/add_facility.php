<?php include("../includes/header.php"); ?>



<form method="POST" action="facility_submit.php" enctype="multipart/form-data">
  Naziv objekta:<br>
  <input type="text" name="facility_name">
  <br>
  Mjesto:<br>
  <input type="text" name="place">
  <br>
  Adresa:<br>
  <input type="text" name="adress">
  <br>
  Telefon 1:<br>
  <input type="text" name="phone_1">
  <br>
  Telefon 2:<br>
  <input type="text" name="phone_2">
  <br>
  Opis na srpskom:<br>
  <textarea cols="40" rows="5" name="description_srb">
  
</textarea>
  <br>
  Opis na engleskom:<br>
  <textarea cols="40" rows="5" name="description_eng">
  
</textarea>
  <br>    
    
  Slika:<br>
  <input type="file" name="profile_image">
  <br>
    
    <br>
  <input type="submit" value="Submit" name="submit-addfacility">
</form> 

















<?php include("../includes/footer.php"); ?>