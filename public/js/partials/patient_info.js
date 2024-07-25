$(document).ready(function () {
    $('.patient_info').on('click', function () {


        $('#patient_infoModal .loaderRefresh').fadeIn(0);

        var pid = $(this).attr('data-pid');

        request = $.ajax({
            url: baseUrl+'/patient_information/'+pid,
            type: "get",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json"
        });

        request.done(function (response, textStatus, jqXHR) {

            console.log(response);

            var suffix = (response.suffix == null)? '' : response.suffix;
            var middleName = (response.middle_name == null)? '' : response.middle_name;

            $('#hosp_noTD').text(response.hospital_no);
            $('#barTD').text(response.barcode);
            $('#nameTD').text(response.last_name+', '+response.first_name+' '+suffix+' '+middleName);
            $('#birtTD').text(dateCalculate(response.birthday));
            $('#addressTD').text((response.address == null)? '' : response.address);
            $('#sexTD').text((response.sex == null)? '' : response.sex);
            $('#cvTD').text((response.civil_status == null)? '' : response.civil_status);
            $('#mssTD').text(response.label+' '+response.description+'%');
            $('#dateTD').text(dateCalculate(response.created_at));



            $('#bpTD').text((response.blood_pressure == null)? '' : response.blood_pressure);
            $('#prTD').text((response.pulse_rate == null)? '' : response.pulse_rate);
            $('#rrTD').text((response.respiration_rate == null)? '' : response.respiration_rate);
            $('#btTD').text((response.body_temperature == null)? '' : response.body_temperature);
            $('#weightTD').text((response.weight == null)? '' : response.weight);
            $('#heightTD').text((response.height == null)? '' : response.height);


            $('#patient_infoModal').modal();


        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });

        request.always(function(){
            $('#patient_infoModal .loaderRefresh').fadeOut(0);
        });

    });
});

