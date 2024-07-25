$('#modal-scan-patient').on('shown.bs.modal', function(){
    $('#modal-scan-patient input.patient').val('').focus();
});

var patient_request = null;
$(document).on('submit', '#modal-scan-patient #search-form', function(e){
    e.preventDefault();
    var scope = $(this);
    $('#modal-scan-patient .loaderRefresh').fadeIn('fast');
    var data = $(scope).serialize();
    request = $.ajax({
        url: $(scope).attr('action'),
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: data,
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        if (response.errors) {
            if (response.errors.hospital_no) {
                toastr.error(response.errors.hospital_no);
            }
        }else{
            if (!response.patient) {
                toastr.error("The numbers combination you entered doesn't mached any patients credential");
            }else if (response.queuing.length > 0) {
                toastr.error('The patient is already in the queued table today, \
                            Kindly search it in the queued patient table..');
            }else{

                appendpatientinfototransaction(response.info);
                updatepathologynavigation(response);
                updatepathologytable(response.list);
                // putrequestitemidtoarray(response, status = 'All');
                appendreuqesttotable(response, status = 'All');
                $('#modal-scan-patient').modal('toggle');
                $('#modal-new-transaction').modal('toggle');
                json_patient_queued = response.patients;
                appendqueuedpatientstotable(response.patients, status = 'P');
                patientqueuedtabs(response.patients);
            }
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
        $('#modal-scan-patient .loaderRefresh').fadeOut('fast');
    });
});