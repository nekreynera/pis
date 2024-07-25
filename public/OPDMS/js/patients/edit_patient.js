$('#modal-edit-patient').on('shown.bs.modal', function(){
    $('#modal-edit-patient input.last_name').focus();
});

function edit_patient(id, enable) {


    $('#modal-edit-patient .loaderRefresh').fadeIn('fast');
    request = $.ajax({
        url: baseUrl+'/patients/'+id+'/edit',
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        if (getUrl.href == 'http://172.17.4.8/opd/cashier') {
            viewpatienttocashierwindow(response.patient);
        }else{
            $('#modal-edit-patient #edit-form').attr('data-id', response.patient.id);
            $('#modal-edit-patient .hospital_no').val(response.patient.hospital_no);
            $('#modal-edit-patient .last_name').val(response.patient.last_name);
            $('#modal-edit-patient .first_name').val(response.patient.first_name);
            $('#modal-edit-patient .middle_name').val(response.patient.middle_name);
            $('#modal-edit-patient .suffix').val(response.patient.suffix);
            $('#modal-edit-patient .birthday').val(dateCalculate(response.patient.birthday));
            $('#modal-edit-patient .calculated-age').val(getAge(response.patient.birthday));
            $('#modal-edit-patient div#sexdiv select.sex').val((response.patient.sex));
            $('#modal-edit-patient .civil_status').val(response.patient.civil_status);
            $('#modal-edit-patient .contact_no').val(response.patient.contact_no);
            $('#modal-edit-patient .address').val(response.patient.address);
            $('#modal-edit-patient .city_municipality_modal').val(response.patient.city_municipality);
            $('#modal-edit-patient .brgy_modal').val(response.patient.brgy);


            if (response.referral) {
                $('#modal-edit-patient .referral').val('yes');
            }

            getallclinics(response.triage);
            if (enable == false) {
                if (new Date(dateCalculate(response.patient.created_at)) < new Date(dateToday)) {
                    enable = false;
                }else{
                    enable = true;
                } 
            }

            if(enable == true){
                $('#modal-edit-patient .vital-signs-coontainer').css('display', 'block');
            }
            if (response.vital) {
                $('#modal-edit-patient .weight').val(response.vital.weight);
                $('#modal-edit-patient .height').val(response.vital.height);
                $('#modal-edit-patient .blood_pressure').val(response.vital.blood_pressure);
                $('#modal-edit-patient .pulse_rate').val(response.vital.pulse_rate);
                $('#modal-edit-patient .respiration_rate').val(response.vital.respiration_rate);
                $('#modal-edit-patient .body_temperature').val(response.vital.body_temperature);
            }else{
                $('#modal-edit-patient .weight').val('');
                $('#modal-edit-patient .height').val('');
                $('#modal-edit-patient .blood_pressure').val('');
                $('#modal-edit-patient .pulse_rate').val('');
                $('#modal-edit-patient .respiration_rate').val('');
                $('#modal-edit-patient .body_temperature').val('');
            }
            gotoaddressFile(response.address);            
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        $('#modal-edit-patient').modal('toggle');
        $('#modal-edit-patient .loaderRefresh').fadeOut('fast');
        console.log("To God Be The Glory...");
    });
}

$(document).on('submit', '#modal-edit-patient #edit-form', function(e){
    e.preventDefault();
    var scope = $(this);
    $('#modal-edit-patient .loaderRefresh').fadeIn('fast');
    var patient_id = $(scope).attr('data-id');
    var url = baseUrl+'/patients/'+patient_id;
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
                if (response.errors.last_name) {
                    toastr.error(response.errors.last_name);
                }
                if (response.errors.first_name) {
                    toastr.error(response.errors.first_name);
                }
                if (response.errors.birthday) {
                    toastr.error(response.errors.birthday);
                }
                if (response.errors.city_municipality) {
                    toastr.error(response.errors.city_municipality);
                }
                if (response.errors.sex) {
                    toastr.error(response.errors.sex);
                }
            }else{
                updateRowContent_patient(patient_id, response);
                clearinputs();
                $('#modal-edit-patient').modal('toggle');
                toastr.success('The Patient Record Successfully Updated');
            }
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
            toastr.error('Oops! something went wrong.');
        });
        request.always(function (response){
            console.log("To God Be The Glory...");
            $('#modal-edit-patient .loaderRefresh').fadeOut('fast');
            
        });
})
