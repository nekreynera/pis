/*----------- ajax for consultation -------*/

function checkConsultation($scope) {

    event.preventDefault();
    $("#consultationModal").modal();
    $('.loaderWrapper').fadeIn(0);
    var pid = $($scope).attr('data-pid');

    request = $.ajax({
        url: baseUrl+'/approvalConsultationList',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':pid},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        $('.consultationListTbody').empty();

        if (response.length > 0) {
            for (var i=0;i<response.length;i++){
                var file_text = $('<i class="fa fa-file-text-o">');
                var anchor = $('<a href="'+baseUrl+'/rcptn_consultationDetails/'+response[i].id+'" target="_blank" ' +
                    'title="Click to view medical records" class="btn btn-success btn-sm">').text(' View Consultation');
                $(anchor).prepend(file_text);
                var tr = $('<tr>');
                var td1 = $('<td>').text(response[i].last_name+', '+response[i].first_name+' '+response[i].middle_name);
                var td2 = $('<td>').text(response[i].clinic);
                var td3 = $('<td>').text(response[i].uslast_name+', '+response[i].usfirst_name+' '+response[i].usmiddle_name);
                var td4 = $('<td>').text(getCustomDate(response[i].created_at));
                if (response[i].type == 'consultations') 
                {
                    var td5 = $('<td>').html('<a href="'+baseUrl+'/rcptn_consultationDetails/'+response[i].id+'" target="_blank" title="Click to view S.O.A.P" class="btn btn-success btn-sm">VIEW</a>');
                }
                else if (response[i].type == 'kmc' || response[i].type == 'otpc_front' || response[i].type == 'childhood_care') 
                {
                    var td5 = $('<td>').html('<button class="btn btn-warning btn-sm" onclick="showPediaForms('+response[i].patient_id+')">VIEW</button>');
                }
                else if (response[i].type == 'industrial_forms') 
                {  
                    var td5 = $('<td>').html('<a href="'+baseUrl+'/industrialPreviewreception/'+response[i].id+'" target="_blank" title="Click to view Industrial records" class="btn btn-info btn-sm '+response[i].id+'">VIEW</a>');
                }
                // var td5 = $('<td>').html('<a href="#" class="btn btn-success btn-sm" disabled> VIEW</>')
                $('.consultationListTbody').append($(tr).append(td1,td2,td3,td4, td5));
                // $('.consultationListTbody').append($(tr).append(td1,td2,td3,td4,td5));
            }
        }else{
            var strong = $('<strong>').text('NO RESULTS FOUND !');
            var tr = $('<tr>');
            var td1 = $('<td colspan="5" class="text-center text-danger">').append(strong);
            $('.consultationListTbody').append($(tr).append(td1));
        }

    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}
