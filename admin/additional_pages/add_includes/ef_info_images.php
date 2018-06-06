<div class="ef-info">

            
           
            <div class="ef-change">
                <p class="to_change">Naziv objekta:</p>
                <div class="facility_name">
                    <p class="to_change"> <span class="facility_for_upd"><?php echo $active_fac->facility_name; ?></span></p>
                </div>

            </div>


            <div class="ef-change">
                <p class="to_change">Mjesto: </p>
                <div class="place">
                    <p class="to_change"> <span class="ef-value"> <?php echo $active_fac->place; ?></span></p>
                </div>
                <div class="ef-edit" id="ef-name-btn">Izmjenite</div>
            </div>

            <div class="ef-change">
                <p class="to_change">Adresa: </p>
                <div class="adress">
                    <p class="to_change"> <span class="ef-value"> <?php echo $active_fac->adress; ?></span></p>
                </div>
                <div class="ef-edit" id="ef-name-btn">Izmjenite</div>
            </div>

            <div class="ef-change">
                <p class="to_change">Broj telefona 1: </p>
                <div class="phone_1">
                    <p class="to_change"> <span class="ef-value"> <?php echo $active_fac->phone_1; ?></span></p>
                </div>
                <div class="ef-edit" id="ef-name-btn">Izmjenite</div>
            </div>



            <div class="ef-change">
                <p class="to_change">Broj telefona 2: </p>
                <div class="phone_2">
                    <p class="to_change"> <span class="ef-value"> <?php echo $active_fac->phone_2; ?></span></p>
                </div>
                <div class="ef-edit" id="ef-name-btn">Izmjenite</div>
            </div>
            <div class="ef_to_descriptions">

                <h4><a href="<?php echo SITE_ADRESS; ?>/admin/additional_pages/edit_descriptions.php?facility=<?php echo $active_fac->facility_name; ?>">KLIKNITE DA PROMJENITE OPISE OBJEKTA</a></h4>
                <h4><a href="<?php echo SITE_ADRESS; ?>/admin">Povratak na admin panel</a></h4>


            </div>


        </div>


        <!--
    
-->
        <!--
        <div class='ef-form'>
            <input type='text' name='' class='input_field'>
            <input type='submit' name='ef-submit' value='submit'>

        </form>
-->


        <div class="ef-images">

            <div class="ef-image-text">Trenutno dodate slike objekta
                <?php echo $active_fac->facility_name; ?>
                <h2><a href="<?php echo SITE_ADRESS; ?>/admin/additional_pages/add_fac_image.php">Dodajte nove slike</a></h2>

            </div>

            <div class="ef-all_images">

<!--                  ovdje ide spisak soba, link update, delete i add new  -->

                <?php 
        foreach($image->all_facility_images_adm() as $fac_image){ 
            ?>

                <div class="ef-image">

                    <img class="ef_image_img" data-descriptionsrb="<?php echo $fac_image->description_srb; ?>" data-descriptioneng="<?php echo $fac_image->description_eng; ?>" data-imgname="<?php echo $fac_image->name; ?>" src="<?php echo SITE_ADRESS; ?>/images/fac-images/<?php echo $fac_image->name; ?>">

                </div>

                <?php
            
        }
            
        
        ?>


            </div>


        </div>