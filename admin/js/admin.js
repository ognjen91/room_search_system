$( document ).ready(function() {
    
   $site_adress = "http://localhost/oop";
    
    console.log('ajde');
//automatsko dodavanje polja za dodavanje slika
  $add_file_field =  $(".new_image_add_wrap").html(); 
  $('body').on('click', 'div.new_img_btn', function() {
          $(this).attr('class', 'new_img_btn_done');
          
      //ovo je validno :)
          $for_append = $("<div>" + $add_file_field + "</div>").hide().fadeIn(1000);  
          $(".form-addimage").append($for_append);
   
       })
   
 
  
//  $add_file_field =  $(".new_image_add_wrap").html(); 
//  $('body').on('click', 'div.new_img_btn', function() {
//          $(this).attr('class', 'new_img_btn_done');
//          $(".form-addimage").append($add_file_field);
//      })
  
//update sa ajaxom za polja izmjene objekta
  $('body').on('click', 'div.ef-edit', function() {
      $facility = $(".facility_for_upd").eq(0).text();
      $div_to_change = $(this).parent().children().eq(1);
       
      $div_to_change.css("border", "1px solid aqua");
      
        $class_needed = $div_to_change.attr('class'); //ovu klasu koristim kao identifikator i u js i u php-u (klasa=naziv polja u tabeli koje mijenjam)

         //vrijednost koju mijenjam
        $old_value = $(this).parent().find(".ef-value").eq(0).text();
        $value = '';
      
        
      
        $editForm = "<div class='ef-form'><input type='text' name='" + $class_needed + "'   class='input_field'><input type='submit' name='ef-submit' value='Izmjeni!' class='edit-submit'></div>";

       $update_btn1 = $(this);
       $update_btn1.css("visibility", "hidden");
       
       $div_to_change.html($editForm);
      
      console.log('old' + $old_value)   

      

      
      
   })
    
    
   $('body').on('click', 'input.edit-submit', function() {
      
    $div_to_change = $(this).parent().parent();
    $value_field = $(this).parent().children().eq(0);   
       
    $value_needed = $value_field.val();
    
//    console.log($value_needed);
       
    $new_value = "";    
     
        $.post('../additional_pages/edit_facility_submit.php',
            {
            facility : $facility,
            field_to_change : $class_needed,
            new_value : $value_needed
        },
            function (data){
            $new_value = data;
            $value_shown = "<p class='to_change'> <span class='ef-value'>" + $new_value + "</span></p>"
            $div_to_change.html($value_shown);
            $update_btn1.css("visibility", "visible");
            
        });   
    
   });
    
   
    
//    ------------za opise---------
    
     $('body').on('click', 'div.ef-edit-text', function() {
      $facility = $(".facility_for_upd-text").eq(0).text();
      $div_to_change = $(this).parent().children().eq(1);
       
//      $div_to_change.css("border", "1px solid aqua");
      
        $class_needed = $div_to_change.attr('class'); //ovu klasu koristim kao identifikator i u js i u php-u (klasa=naziv polja u tabeli koje mijenjam)

         //vrijednost koju mijenjam
        $old_value = $(this).parent().find(".ef-value-text").eq(0).text();
        $value = '';
      
        
      
        $editForm = "<div class='ef-form'><textarea name='"+ $class_needed  +"' class='input_field-text' value=''>"+ $old_value +"</textarea><input type='submit' name='ef-submit-text' value='submit' class='ef-submit-text'></div>";

       $update_btn1 = $(this);
       $update_btn1.css("visibility", "hidden");
       $div_to_change.css("overflow-y", "visible")
       $div_to_change.html($editForm);
      
//      console.log('old: ' + $old_value)   

 })
    
      $('body').on('click', 'input.ef-submit-text', function() {
      
    $div_to_change = $(this).parent().parent();
    $value_field = $(this).parent().children().eq(0);   
       
    $value_needed = $value_field.val();
    
//    console.log($value_needed);
       
    $new_value = "";    
     
        $.post('../additional_pages/edit_facility_submit.php',
            {
            facility : $facility,
            field_to_change : $class_needed,
            new_value : $value_needed
        },
            function (data){
            $new_value = data;
            $div_to_change.css("overflow-y", "scroll")
            $value_shown = " <p class='to_change-text'> <span class='ef-value-text'>"+$new_value+"</span></p>"
            $div_to_change.html($value_shown);
            $update_btn1.css("visibility", "visible");
            
        });   
    
   });
    
    
    
    
    
    
//    -----------edit_room.php ... izmjena sobe------
    
    
    //pravilno popunjavanje select polja
//    alert('ok')
 $(".er_active_value").each(function() {
   
   $active_value = $(this).attr('value');
   $other_value = 1;     
   $active_value == 1? $other_value=0 : null;
//   console.log($other_value);
    if ($active_value == 1){
        $(this).text("DA");
        $(this).parent().find(".er_other_value").text("NE");
        $(this).next().attr("value", $other_value)
    } else {
        $(this).text("NE");
        $(this).parent().find(".er_other_value").text("DA");
        $(this).next().attr("value", $other_value)
    }
     
     
   
});
    
    
    
// =============ADMIN EDIT FACILITY: otvaranje velike slike sa opcijama================   
    
    $('.ef_image_img').click(function(){
       $ef_description_srb = $(this).attr("data-descriptionsrb"); 
       $ef_description_eng = $(this).attr("data-descriptioneng"); 
       $ef_img_name = $(this).attr("data-imgname"); 
        
//       console.log($ef_description_srb);    
//       console.log($ef_description_eng);    
//       console.log($ef_img_name);    
       
        $img_adress = $(this).attr('src');
        
        $("#ef_big_img").attr('src', $img_adress);
        $(".ef_big_img_wrap").css("display", "inherit");
        $("#ef-big-sr").html($ef_description_srb);
        $("#ef-big-eng").html($ef_description_eng);
        
        
       //ideja je da potrebne podatke stavim u linkove a-a...
        
        
    })
    
    
    $('body').on('click', '.ef_close', function() {
      $(this).parent().css("display", "none");
    }); 
    
    
    
    
//    =================EDIT ROOM BRISANJE SLIKE SOBE============
    
//    function fadeout_after_time($time)
    
    
    
    $(".er_go_del").click(function(){
        $img_for_del = $(this).parent().parent().children().eq(0).find("img").attr("id");
        
        $img_div = $(this).parent().parent();
//        console.log($img_for_del);
        
         $.post('../additional_pages/delete_room_img.php',
            {
            image : $img_for_del
        },
            function (data){
             
            $new_value = data;
             $img_div.html("<h1>aaaaa "+$new_value+"</h1>");
           
              $timeouted_fadeout = setTimeout(function(){ $img_div.fadeOut(2000); }, 1000);
             
             //divno :)
        });
        
    })
    
    
//    --------------edit kalendara u admin panelu-------
    
        $i = 1;
    $(".ec_edit_calendar_ava>.ava_date, .ec_edit_calendar_ava>.unava_date").each(function(){
        
        $date_class = $(this).attr("class");
        $ava_status = $date_class.split(' ')[1];
        $ava_status = ($ava_status == "ava_date");
        $init_price = $(this).attr("data-price");
        $init_discount = $(this).attr("data-discount");
        
//        console.log($ava_status);
        $select_name = "availability[]";
        
        $option_ava = "<option value='1'>Slobodno</option>";
        $option_unava = "<option value='0'>Zauzeto</option>";
        $options = $ava_status? $option_ava + $option_unava : $option_unava + $option_ava;
        
        
        $form_string = "<div class='edit_fields'>Cijena:<input type='text' name='price[]' value='"+$init_price+"' class='ec_price'>Popust: <input type='text' name='discount[]' value='"+$init_discount+"' class='ec_discount' ><select name='"+ $select_name +"' class='ec_select'>"+$options+"</select></div>";
        
//        $form_string = "<div class='edit_fields'>Cijena:<input type='text' name='price_" + $i +"' value='"+$init_price+"' class='ec_price'>Popust: <input type='text' name='discount_" + $i + "' value='"+$init_discount+"' class='ec_discount' ><select name='"+ $select_name +"' class='ec_select'>"+$options+"</select></div>";
       
        
        $(this).append($form_string);
        
        

        
        
        $i++;
      
    })
        
                    
   
     $('body').on('keyup', 'input.ec_price, input.ec_discount', function() {
        var cleared = $(this).val().replace(/[^0-9]/g, '');
  // vracam vrijednost bez slova
  $(this).val(cleared);
}); 
     
          $('body').on('keyup', 'input.enter_room_name', function() {
        var cleared = $(this).val().replace("'", '').replace('"', '');
        
  // vracam vrijednost bez slova
  $(this).val(cleared);
}); 
     
        
 
    
    
    
    
    
    
    
    
    
//    -----KLASA KALENDARA--------
    

   class Calendar {
       
       
      get_dates(){
          
      } 
       
       
       
       
       
       
       
       
   }
    
    
 
    
    
    
    
    
    
    
    
    
    
//    =========podsjetnik za klase===========
// unnamed
//var Rectangle = class {
//  constructor(height, width) {
//    this.height = height;
//    this.width = width;
//  }
//    
//    
//};
//    
//var x = new Rectangle(2, 3);
//var y = new Rectangle(4, 5);
//console.log("x height " + x.height);
//console.log("y height " + y.height);
// output: "Rectangle"


    
    
    
    
    
});