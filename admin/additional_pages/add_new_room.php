<?php include("../includes/header.php"); ?>

<?php 
$active_fac=$facility->facility_for_edit();
//var_dump($active_fac);
//var_dump($_SESSION);
?>

<form method="POST" action="facility_submit.php?facility=<?php echo $active_fac->facility_name; ?>" enctype="multipart/form-data">
  Naziv sobe:<br>
  <input type="text" name="name">
  <br>
Klima uredjaj:
<select name="air_conditioner">
  <option value="1">Da</option>
  <option value="0">Ne</option>
</select>
  <br> 
    Kuhinja:
  <select name="kitchen">
  <option value="1">Da</option>
  <option value="0">Ne</option>
</select>
  <br>
    Kupatilo:
  <select name="bathroom">
  <option value="1">Da</option>
  <option value="0">Ne</option>
</select>
  <br>  
    Tv:
  <select name="tv">
  <option value="1">Da</option>
  <option value="0">Ne</option>
</select>
  <br>  
    Terasa:
  <select name="terace">
  <option value="1">Da</option>
  <option value="0">Ne</option>
</select>
  <br>  
  Broj kreveta:<br>
  <input type="text" name="no_of_beds">
  <br>
    
   Ostale pogodnosti srpski:<br>
  <textarea cols="40" rows="5" name="other_amenities_srb">
</textarea> 
 <br>   
    
  Ostale pogodnosti engleski:<br>
  <textarea cols="40" rows="5" name="other_amenities_eng">
</textarea> 
 <br>  
    
    
    
    
    
  Opis na srpskom:<br>
  <textarea cols="40" rows="5" name="description_srb">
</textarea>
  <br>
  Opis na engleskom:<br>
  <textarea cols="40" rows="5" name="description_eng">
  
</textarea>
  <br>    
    
  Naslovna slika:<br>
  <input type="file" name="profile_image">
  <br>
    
    <br>
  <input type="submit" value="Submit" name="submit-addnewroom">
</form>



























<?php include("../includes/footer.php"); ?>