$(document).on('change', '#modal-check-patient .search-option', function(){
	var val = $(this).val();
	if (val == "1") {
        $('#modal-check-patient .l_name').attr('readonly', false).attr('required', true).focus();
        $('#modal-check-patient .f_name').attr('readonly', false).attr('required', true);
        $('#modal-check-patient .id_no').attr('readonly', true).attr('required', false);
         $('#modal-check-patient .l_name').siblings('span').css({'display': 'block'});
        $('#modal-check-patient .id_no').siblings('span').css({'display': 'none'});
        $('#modal-check-patient .f_name').siblings('span').css({'display': 'block'});
    }else{
        $('#modal-check-patient .l_name').attr('readonly', true).attr('required', false);
        $('#modal-check-patient .f_name').attr('readonly', true).attr('required', false);
        $('#modal-check-patient .id_no').attr('readonly', false).attr('required', true).focus();
        $('#modal-check-patient .l_name').siblings('span').css({'display': 'none'});
        $('#modal-check-patient .id_no').siblings('span').css({'display': 'block'});
        $('#modal-check-patient .f_name').siblings('span').css({'display': 'none'});
    }
});

$('#modal-check-patient').on('shown.bs.modal', function(){
    $('#modal-check-patient input.l_name').focus();
});


$(document).on('submit', '#search-form', function(e){
        e.preventDefault();
        $('#modal-check-patient .loaderRefresh').fadeIn('fast');
        var url = $(this).attr('action');
        var data = $(this).serialize();
            request = $.ajax({
                url: url,
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data,
                dataType: "json"
            });

            request.done(function (response, textStatus, jqXHR) {
                if (response.errors) {
                    if (response.errors.id_no) {
                        toastr.error(response.errors.id_no);
                    }
                    if (response.errors.l_name) {
                        toastr.error(response.errors.l_name);
                    }
                    if (response.errors.f_name) {
                        toastr.error(response.errors.f_name);
                    }
                }else{
                    result_patient(response);
                }
            });
            request.fail(function (jqXHR, textStatus, errorThrown){
                console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
                toastr.error('Oops! something went wrong.');
            });
            request.always(function (response){
                console.log("To God Be The Glory...");
                $('#modal-check-patient .loaderRefresh').fadeOut('fast');
            });
});

function modalCheckpatient(){
    $('#modal-check-patient .id_no').val('').attr('readonly', true);
    $('#modal-check-patient .l_name').val('').attr('readonly', false);
    $('#modal-check-patient .f_name').val('').attr('readonly', false);
    $('#modal-check-patient .search-option').val('1');
    $('#modal-check-patient').modal('toggle');
}

