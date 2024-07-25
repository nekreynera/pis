var auth = false;
$(document).ready(function () {
    request = $.ajax({
        url: baseUrl+'/getAuth',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        auth = response;
    });
});

function medicalRecords($scope) {
    $('.loaderWrapper').fadeIn(0);
    $("#medRecordsModal").modal();

    request = $.ajax({
        url: baseUrl+'/approvalMedicalRecords',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':$scope},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response)
        var consultation = (response.history[0].consultations != null)? response.history[0].consultations : 0;
        // var labs = (response[0].lab != null)? response[0].lab : 0;
        var requisitions = (response.history[0].requisitions != null)? response.history[0].requisitions : 0;
        var ultrasound = (response.history[0].ultrasound != null)? response.history[0].ultrasound : 0;
        var xray = (response.history[0].xray != null)? response.history[0].xray : 0;
        var refferals = (response.history[0].refferals != null)? response.history[0].refferals : 0;
        var followups = (response.history[0].followups != null)? response.history[0].followups : 0;
        var dental = (response.history[0].dental != null)? response.history[0].dental : 0;

        $('.approvalPatientName').text(response.history[0].name);
        $('.consultationBadge').text(consultation);
        $('.laboratoryBadge').text(response.laboratory.length);
        $('.requisitionBadge').text(requisitions);
        $('.ultrasoundBadge').text(ultrasound);
        $('.xrayBadge').text(xray);
        $('.refferalBadge').text(refferals);
        $('.followupBadge').text(followups);
        $('.dentalBadge').text(dental);

        $('.recordsList').attr('data-pid', $scope);

        console.log(response);
        console.log(response.history[0].consultations);
        console.log(response.history[0].requisitions);
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });

    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}













/*----------- ajax for requisition -------*/

function checkRequisition($scope) {
    event.preventDefault();
    $("#requisitionModal").modal();
    $('.loaderWrapper').fadeIn(0);
    var pid = $($scope).attr('data-pid');

    request = $.ajax({
        url: baseUrl+'/ajaxRequisitionList',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':pid},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        $('.requisitionListTbody').empty();

        if (response.length > 0) {
            for (var i = 0; i < response.length; i++) {
                var clinic = (response[i].clinic != null)? response[i].clinic : 'N/A';
                var today = getCustomDate(response[i].created_at);
                var file_text = $('<i class="fa fa-file-text-o">');
                var anchor = $('<a href="#" onclick="medsWatch('+response[i].id+')" target="_blank" ' +
                    'title="Click to view medical records" class="btn btn-success btn-sm">').text(' View Meds');
                $(anchor).prepend(file_text);
                var tr = $('<tr>');
                var td1 = $('<td>').text(response[i].name);
                var td2 = $('<td>').text(clinic);
                var td3 = $('<td>').text(response[i].doctor);
                var td4 = $('<td>').text(today);
                var td5 = $('<td>').append(anchor);
                $('.requisitionListTbody').append($(tr).append(td1, td2, td3, td4, td5));
            }
        }else{
            var strong = $('<strong>').text('NO RESULTS FOUND !');
            var tr = $('<tr>');
            var td1 = $('<td colspan="5" class="text-center text-danger">').append(strong);
            $('.requisitionListTbody').append($(tr).append(td1));
        }

    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });

    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}







/*-------------- AJAX FOR REFFERAL -----------*/

function checkRefferals($scope) {
    event.preventDefault();
    $("#refferalsModal").modal();
    $('.loaderWrapper').fadeIn(0);
    var pid = $($scope).attr('data-pid');

    request = $.ajax({
        url: baseUrl+'/ajaxRefferals',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':pid},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        $('.refferalsListTbody').empty();

        if (response.length > 0) {
            for (var i = 0; i < response.length; i++) {
                var clinic = (response[i].fromClinic != null)? response[i].fromClinic : 'N/A';
                var fromDoctor = (response[i].fromDoctor != null)? 'Dr. '+response[i].fromDoctor : 'N/A';
                var toClinic = (response[i].toClinic != null)? response[i].toClinic : 'N/A';
                var toDoctor = (response[i].toDoctor != null)? 'Dr. '+response[i].toDoctor : 'N/A';
                var reason = (response[i].reason != null)? response[i].reason : 'N/A';
                var status = (response[i].status == 'P')? $('<span class="text-danger">').text('Pending') : $('<span class="text-success">').text('Finished');
                var today = getCustomDate(response[i].created_at);

                var checkAuth = (response[i].users_id == auth && response[i].status == 'P')? '' : 'disabled';
                var pencil = $('<i class="fa fa-pencil text-info">');
                var trash = $('<i class="fa fa-trash text-danger">');
                var edit = $('<a href="' + baseUrl + '/refferal/' + response[i].id + '/edit" target="_blank" title="Click to edit this refferal" class="btn btn-default btn-circle '+checkAuth+'">').append(pencil);
                var deleted = $('<a href="' + baseUrl + '/delete_refferal/' + response[i].id + '" target="_blank" title="Click to delete this refferal" class="btn btn-default btn-circle '+checkAuth+'">').append(trash);

                var tr = $('<tr>');
                var td1 = $('<td>').text(response[i].name);
                var td2 = $('<td>').text(clinic);
                var td3 = $('<td>').text(fromDoctor);
                var td4 = $('<td>').text(toClinic);
                var td5 = $('<td>').text(toDoctor);
                var td6 = $('<td>').text(reason);
                var td7 = $('<td>').append(status);
                var td8 = $('<td>').text(today);
                var td9 = $('<td>').append(edit);
                var td10 = $('<td>').append(deleted);

                $('.refferalsListTbody').append($(tr).append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td10));
            }
        }else{
            var strong = $('<strong>').text('NO RESULTS FOUND !');
            var tr = $('<tr>');
            var td1 = $('<td colspan="10" class="text-center text-danger">').append(strong);
            $('.refferalsListTbody').append($(tr).append(td1));
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });

    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}



/*-------------- AJAX FOR FOLLOWUP -----------*/

function checkFollowups($scope) {
    event.preventDefault();
    $("#followupModal").modal();
    $('.loaderWrapper').fadeIn(0);
    var pid = $($scope).attr('data-pid');

    request = $.ajax({
        url: baseUrl+'/ajaxFollowup',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':pid},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        $('.followupListTbody').empty();

        if (response.length > 0) {
            for (var i = 0; i < response.length; i++) {
                var fromDoctor = (response[i].fromDoctor != null)? 'Dr. '+response[i].fromDoctor : 'N/A';
                var toDoctor = (response[i].toDoctor != null)? 'Dr. '+response[i].toDoctor : 'N/A';
                var reason = (response[i].reason != null)? response[i].reason : 'N/A';
                var status = (response[i].status == 'P')? $('<span class="text-danger">').text('Pending') : $('<span class="text-success">').text('Finished');
                var today = getDateString(response[i].followupdate);

                var checkAuth = (response[i].users_id == auth && response[i].status == 'P')? '' : 'disabled';
                var pencil = $('<i class="fa fa-pencil text-info">');
                var trash = $('<i class="fa fa-trash text-danger">');
                var edit = $('<a href="' + baseUrl + '/followup/' + response[i].id + '/edit" target="_blank" title="Click to edit this refferal" class="btn btn-default btn-circle '+checkAuth+'">').append(pencil);
                var deleted = $('<a href="' + baseUrl + '/delete_followup/' + response[i].id + '" target="_blank" title="Click to delete this refferal" class="btn btn-default btn-circle '+checkAuth+'">').append(trash);

                var tr = $('<tr>');
                var td1 = $('<td>').text(response[i].name);
                var td2 = $('<td>').text(response[i].clinic);
                var td3 = $('<td>').text(fromDoctor);
                var td5 = $('<td>').text(toDoctor);
                var td6 = $('<td>').text(reason);
                var td7 = $('<td>').append(status);
                var td8 = $('<td>').text(today);
                var td9 = $('<td>').append(edit);
                var td10 = $('<td>').append(deleted);

                $('.followupListTbody').append($(tr).append(td1, td2, td3, td5, td6, td7, td8, td9, td10));
            }
        }else{
            var strong = $('<strong>').text('NO RESULTS FOUND !');
            var tr = $('<tr>');
            var td1 = $('<td colspan="10" class="text-center text-danger">').append(strong);
            $('.followupListTbody').append($(tr).append(td1));
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });

    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}









function getCustomDate(rawDate) {
    var d = new Date(rawDate);
    var days = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var hour = d.getHours();
    var min = d.getMinutes();
    var today = month + ' ' + day + ', ' + year + ' ' + hour + ':' + min;
    return today;
}

function getDateString(rawDate) {
    var d = new Date(rawDate);
    var days = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var today = month + ' ' + day + ', ' + year;
    return today;
}
