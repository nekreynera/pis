$(document).ready(function () {

    $('#kmc_form').on('submit', function () {
        var ans = confirm('Do you really want save this form?');
        if (ans){
            $('.loaderRefresh').fadeIn('fast');
        } else{
            event.preventDefault();
        }
    });



    $('input[name="condition_of_baby"]:first').on('click', function(){

        $('input[name="condition_of_baby"]:last').closest('tr').find('input[name="notwell[]"]').each(function(){
           $(this).removeAttr('checked').attr('disabled','disabled');
        });
        $('input[name="not_well_others"]').val('').attr('disabled','disabled');

    });


    $('input[name="condition_of_baby"]:last').on('click', function(){

        $('input[name="condition_of_baby"]:last').closest('tr').find('input[name="notwell[]"]').each(function(){
            $(this).removeAttr('disabled');
        });

    });



    $('input[value="Others"]').on('click', function(){
        if($(this).is(':checked')){
            $('input[name="not_well_others"]').removeAttr('disabled').focus();
        }else{
            $('input[name="not_well_others"]').attr('disabled','disabled').val('');
        }
    });

});