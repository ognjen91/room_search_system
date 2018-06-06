<div class="er_labels">
    <div class="er_img_lbl">SLIKA</div>
    <div class="er_created_lbl">KREIRANO</div>
    <div class="er_del_lbl">BRISANJE</div>


</div>

<?php

foreach($room_image->all_room_images_adm() as $er_image){
    ?>

    <div class="er_image_all">

        <div class="er_img">


            <img src="<?php echo SITE_ADRESS . DS . 'images' . DS . "room-images".DS. $er_image->name; ?>" id="<?php echo $er_image->name; ?>">









        </div>

        <div class="er_img_info">

            <?php echo $er_image->created; ?>


        </div>

        <div class="er_img_del">


            <h4 class="er_go_del">OBRISITE SLIKU</h4>



        </div>



    </div>
    <?php
}




  ?>
