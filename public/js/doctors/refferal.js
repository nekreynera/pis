$(document).ready(function () {
   $('#clinic').on('change', function () {
       $("select[name='assignedTo']").find('option').first().text('Loading...');
       var clinic = $(this).val();
       if(clinic != ''){
           $('.errorshow').fadeOut('slow');
           request = $.ajax({
               url: baseUrl+"/selectDoctors",
               type: "post",
               headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               data: {'clinic_code':clinic},
               dataType: "json"
           });
           request.done(function (response, textStatus, jqXHR) {
                console.log(response)
               $("select[name='assignedTo']").find('option').first().nextUntil().remove();
               if(response.length > 0){
                   for(var i=0;i<response.length;i++){
                       var option = $('<option value="'+response[i].id+'">').text(response[i].doctorsname);
                       $('.selectDoctor').append(option);
                   }
               }else{

               }
           });
           request.fail(function (jqXHR, textStatus, errorThrown){
               console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
           });
           request.always(function(){
               $("select[name='assignedTo']").find('option').first().text('--Select A Doctor--');
           });

       }else{
           $("select[name='assignedTo']").find('option').first().text('--Select A Doctor--');
           $("select[name='assignedTo']").find('option').first().nextUntil().remove();
       }
   });


   $('#doctor').on('click', function () {
       var clinic = $('#clinic').val();
       if (clinic != ''){
           $('.errorshow').fadeOut('slow');
       }else{
           $("select[name='assignedTo']").find('option').first().nextUntil().remove();
           $('.errorshow').fadeIn('slow');
       }
   });

});