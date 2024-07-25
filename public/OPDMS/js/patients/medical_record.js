$(document).on('click', '#medical-record', function(){
    var id = $(this).attr('data-id');
    // alert(id);
        // toastr.info('Feature is under Development mode\n sorry for the Inconvenience');

    if (id == '#') {
        toastr.error('Kindly Select Patient Record First');
    }else{
        getmedicalrecordsDate(id)
        
    }
});

var med_patient_id = null;

function getmedicalrecordsDate(id){

    /*clear text*/
    $('.medical-records-thead').empty();
    $('.medical-records-tbody').empty();

    $('#modal-medical-records #consultation').text('');
    $('#modal-medical-records #laboratory').text('');
    $('#modal-medical-records #x-ray').text('');
    $('#modal-medical-records #ultrasound').text('');
    $('#modal-medical-records #ecg').text('');
    $('#modal-medical-records #others').text('');
    $('#modal-medical-records #referral').text('');
    $('#modal-medical-records #follow-up').text('');
    /*==========*/

    $('#modal-medical-records').modal('toggle');
    $('#modal-medical-records .modal-body .loaderRefresh').fadeIn('fast');

    request = $.ajax({
        url: baseUrl+'/getmedicalrecordsDate/'+id,
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        $('font.patient_name').text(response.patient.last_name+', '+response.patient.first_name+' '+response.patient.middle_name);
        $('font.hospital_no').text(response.patient.hospital_no);
        med_patient_id = response.patient.id;

        if (response.consultation.length > 0) {
        $('#modal-medical-records #consultation').text(response.consultation.length);
        }
        if (response.laboratory.length > 0) {
            $('#modal-medical-records #laboratory').text(response.laboratory.length);
        }
        if (response.ancillary.length > 0 ) {
            var others = 0;
            for (var i = 0; i < response.ancillary.length; i++) {
               
                if (response.ancillary[i].id == 11) {
                    $('#modal-medical-records #x-ray').text(response.ancillary[i].result);
                }
                if (response.ancillary[i].id == 6) {
                    $('#modal-medical-records #ultrasound').text(response.ancillary[i].result);
                }
                if (response.ancillary[i].id == 12) {
                    $('#modal-medical-records #ecg').text(response.ancillary[i].result);
                }
                if($.inArray(response.ancillary[i].id, [10,11,6,12]) == -1){
                    others+=Number(response.ancillary[i].result);
                }
            }
            if (others > 0) {
                $('#modal-medical-records #others').text(others);
            }
        }

        if (response.appoinment.length > 0 ) {
            for (var i = 0; i < response.appoinment.length; i++) {
                if (response.appoinment[i].tabl == "refferals") {
                    $('#modal-medical-records #referral').text(response.appoinment[i].result);
                }
                if (response.appoinment[i].tabl == "followup") {
                    $('#modal-medical-records #follow-up').text(response.appoinment[i].result);
                }
               
            }
            
        }
        
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });

    request.always(function(){
        console.log('Thanks God');
        $('#modal-medical-records .modal-body .loaderRefresh').fadeOut('fast');

    });
}


$(document).on('click', '#modal-medical-records .sidebar-special li', function(){
    if ($(this).attr('class') != 'header') {
        $('#modal-medical-records .modal-body .loaderRefresh').fadeIn('fast');
        $(this).addClass('active').siblings().removeClass('active');
        var target = $(this).attr('data-id');
        if (target == 'consultation') {
            getpatientconsultation(med_patient_id);
        }
        else if(target == 'referral'){
            getpatientreferral(med_patient_id);
        }
        else if(target == 'followup'){
            getpatientfollowup(med_patient_id);
        }
        else{
            getpatientancillarys(med_patient_id, target);
        }
    }
});


function getpatientconsultation(id)
{
    request = $.ajax({
        url: baseUrl+'/getpatientconsultationrecord/'+id,
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        consultationtable(response);
        $('#modal-medical-records .modal-body .loaderRefresh').fadeOut('fast');
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
    });
}

function getpatientancillarys(patient, category) {
    request = $.ajax({
        url: baseUrl+'/getpatientancillarysrecord/'+patient+'/'+category,
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        ancillarytable(response);
        $('#modal-medical-records .modal-body .loaderRefresh').fadeOut('fast');
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
    });
}

function getpatientreferral(id) {
    request = $.ajax({
        url: baseUrl+'/getpatientreferralrecord/'+id,
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        referraltable(response);
        $('#modal-medical-records .modal-body .loaderRefresh').fadeOut('fast');
        
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
    });
}

function getpatientfollowup(id) {
    request = $.ajax({
        url: baseUrl+'/getpatientfollowuprecord/'+id,
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        followuptable(response);
        $('#modal-medical-records .modal-body .loaderRefresh').fadeOut('fast');
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
    });
}