
        <h3><a href='<?php echo SITE_ADRESS; ?>/admin/additional_pages/add_new_room.php?facility=<?php echo $active_fac->facility_name; ?>'>DODAJTE NOVU SOBU</a></h3>
        <h4>Sobe objekta <?php echo $active_fac->facility_name; ?>: </h4>
        
        <?php 
        foreach($room->all_facility_rooms_adm() as $active_room){ 
            ?>

        <div class="ef-room">
<div class="ef-room-info">
            <h5>
                <?php echo $active_room->name; ?>
            </h5>
    </div>
            <div class="ef-room-profile"><img src="<?php echo SITE_ADRESS; ?>/images/room-profiles/<?php echo $active_room->profile_image; ?>"></div>
            
            
<div class="ef-room-description">
    <h4><a href="edit_room.php?facility=<?php echo $active_fac->facility_name; ?>&room=<?php echo $active_room->name; ?>">Pogledajte i mijenjajte sobu</a></h4>    </div>
            
            <div class="ef-room-delete">
    <h4><a href="delete_room.php?facility=<?php echo $active_fac->facility_name; ?>&room=<?php echo $active_room->name; ?>">Obrišite sobu</a></h4>    </div>

            
        </div>

<?php } ?>
