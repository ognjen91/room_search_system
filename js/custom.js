

$( document ).ready(function() {
    
    var $arrival_day;
    var $arrival_month;
    var $arrival_year;
    var $departure_day;
    var $departure_month;
    var $departure_year;
   
//    ---visine kalendara----
    function calendar_heights(){
        
       $no_of_calendars = $(".calendar_blanc_wrap").length;
       $wrapper_width =  $(".fp_calendar").eq(0).width(); $(".calendar_blanc_wrap").length;  
       $holder= $(".fp_calendars_holder");
       $holder.width(($no_of_calendars+1) * $wrapper_width); $calendar_for_month = $(".calendar_blanc_wrap");
       $calendar_for_month.width($holder.width()/($no_of_calendars+1));
        console.log($no_of_calendars)
       
    }
    
    
calendar_heights();
    
    
    
//    -kalendar-----
    
    
    $(".calendar_month, .calendar_year").change(function(){
        $month_chosen = $(this).parent().find(".calendar_month").val();
        $year_chosen = $(this).parent().find(".calendar_year").val();
        

        $chosen_calendar = $(this).parent().parent().find("[data-month='"+$month_chosen+"'][data-year='"+$year_chosen+"']").eq(0);
        $calendar_content = $chosen_calendar.html();
        
        
        $(this).parent().parent().find(".calendar_blanc ").eq(0).html($calendar_content);
        
    })
    
    
    //prilagodjavanje drugog kalendara prvom
    $(".fp_arrival_calendar>div>.calendar_month, .fp_arrival_calendar>div>.calendar_year").change(function(){
        
        $month_chosen = $(this).parent().find(".calendar_month").val();
        $year_chosen = $(this).parent().find(".calendar_year").val();
        
        
        $chosen_calendar = $(this).parent().parent().next().find("[data-month='"+$month_chosen+"'][data-year='"+$year_chosen+"']").eq(0);
        
         $(this).parent().parent().next().find(".calendar_blanc").eq(0).html($calendar_content);
        
        $(this).parent().parent().next().find(".calendar_month").eq(0).val($month_chosen);
        $(this).parent().parent().next().find(".calendar_year").eq(0).val($year_chosen);
})
    
    //priprema podataka za slanje
    
    $(".fp_arrival_calendar  .cal_blanc_date").click(function(){
        $arrival_day = $(this).text();
        $arrival_month = $(".fp_arrival_calendar").find(".calendar_month").val();
        $arrival_year = $(".fp_arrival_calendar").find(".calendar_year").val();
        
        console.log($arrival_day + " " + $arrival_month +" " + $arrival_year);
        
    });
    
    
    
    $(".fp_departure_calendar  .cal_blanc_date").click(function(){
        $departure_day = $(this).text();
        $departure_month = $(".fp_departure_calendar").find(".calendar_month").val();
        $departure_year = $(".fp_departure_calendar").find(".calendar_year").val();
        
        console.log($departure_day + " " + $departure_month +" " + $departure_year);
        
        
        
});
    
    $(".cal_blanc_date").click(function(){
        if ($arrival_day && $arrival_month && $arrival_year && $departure_day && $departure_month && $departure_year){
             
     //ADRESU TREBA PROMJENITI nz adresu sajta      
//    alert('Running AJAX request');
         $.ajax({
             url: 'includes/room_search/search_by_dates.php',
             type: 'POST',
             data: {
                 arrival_day: $arrival_day,
                 arrival_month: $arrival_month,
                 arrival_year: $arrival_year,
                 departure_day: $departure_day,
                 departure_month: $departure_month,
                 departure_year: $departure_year
             },
             success: function (response) {
//                 alert('Response received: ' + response);
                 $("#search_results").html(response);
//                 alert('Document modified.');
             },
             error: function (req) {
                 console.log('Error: ' + req.status);
             }
         }); 
//            $.post('../includes/room_search/search_by_dates.php',
//            {
//            arrival_day : $arrival_day,
//            arrival_month : $arrival_month,
//            arrival_year : $arrival_year,
//            departure_day : $departure_day,
//            departure_month : $departure_month,
//            departure_year : $departure_year,     
//            success : function( result ) {
//             $("#search_results").html(result);
//            }
          
             console.log("sada...")
        } 
        });
        
       
        
//--------------PRIKAZ SOBE----------
    
    
   $('body').on('click', 'div.fp_show_more', function() {
       $room_id = $(this).parent().attr('id');
        $.ajax({
             url: 'includes/room_search/search_room_by_id.php',
             type: 'POST',
             data: {
                 room_id : $room_id
             },
             success: function (room) {
         
                 
            console.log(room);
//            console.log(room.info.room_name)     
                 
                 
                 
                 
                 
                 
//                
             },
             error: function (req) {
                 console.log('Error: ' + req.status);
             }
         }); 
       
       
       
       
   });
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
        
});