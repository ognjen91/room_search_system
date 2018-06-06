<?php include("../includes/header.php"); ?>


<?php 

$active_fac=$facility->facility_for_edit();
//var_dump($active_fac);
?>

<h2 class=''>Mijenjate opise za objekat <span class="facility_for_upd-text"><?php echo $active_fac->facility_name; ?></span></h2>

<h3><a href="<?php echo SITE_ADRESS; ?>/admin/additional_pages/edit_facility.php?facility=<?php echo $active_fac->facility_name; ?>">Povratak na izmjenu objekta</a></h3>
<h3><a href="<?php echo SITE_ADRESS; ?>/admin">Povratak na admin panel</a></h3>

<div class="ef-descriptions">
    
    
    <div class="ef-description">
        <p class="to_change-text">Opis na srpskom: </p>
        <div class="description_srb">
            <p class="to_change-text"> <span class="ef-value-text"> <?php echo $active_fac->description_srb; ?></span></p>
        </div>
        <div class="ef-edit-text" id="ef-name-btn">Izmjenite opis</div>
    </div>

    <div class="ef-description">
        <p class="to_change">Opis na engleskom: </p>
        <div class="description_eng">
            <p class="to_change-text"> <span class="ef-value-text"> <?php echo $active_fac->description_eng; ?></span></p>
        </div>
        <div class="ef-edit-text" id="ef-name-btn">Izmjenite opis</div>
    </div>


</div>



<!--
<div class='ef-form'>
    <textarea name='' class='input_field'></textarea>
    <input type='submit' name='ef-submit' value='submit'>

</div>
-->










<?php include("../includes/footer.php"); ?>
