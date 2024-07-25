$(document).ready(function(){

   $('.surveyNoFindings').on('click', function(){
       $(this).closest('div.radio').next('div.radio').find('input[type="text"]').attr('disabled','true').removeAttr('required');
   }) ;

    $('.surveyNoted').on('click', function() {
        $(this).closest('div.radio').find('input[type="text"]').removeAttr('disabled').focus().attr('required',true);
    });






    $('#industrialMainForm').on('submit', function(){
        event.preventDefault();

        $('.overlayLoader').fadeIn('fast');
        $('.submitIndustrialBtn').attr('disabled',true).text('Please Wait...');

        var data = $(this).serialize();

        request = $.ajax({
            url: baseUrl+'/industrialStore',
            type: "post",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: data,
            dataType: "json"
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log(response);
            if(response == 'deleted'){
                var $msg = 'Opps! No Data Inserted';
                shoutOut($msg);
                toastr.error($msg);
            }else if(response == 'updated'){
                $('.printIConIndustrial').fadeIn('fast');
                var $msg = 'Industrial Form Successfully Updated';
                shoutOut($msg);
                toastr.success($msg);
            }else{
                $('.printIConIndustrial').fadeIn('fast').attr('href',baseUrl+'/industrialPrint/'+response.id);
                $('input[name="industrialFormId"]').val(response.id);
                var $msg = 'Industrial Form Successfully Saved';
                shoutOut($msg);
                toastr.success($msg);
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
            var $msg = 'Opps! Something went wrong, please resubmit';
            shoutOut($msg);
            toastr.error($msg);
        });

        request.always(function(){
            $('.overlayLoader').fadeOut('fast');
            $('.submitIndustrialBtn').html('<span class="fa fa-save"></span> Update');
        });

    });
});



function shoutOut($msg)
{
    var msg = new SpeechSynthesisUtterance();
    msg.text = $msg;
    window.speechSynthesis.speak(msg);
    toastr.options = {
        "progressBar": true,
        "positionClass":"toast-bottom-right"
    };
}



