$(document).ready(function() {
    $('#radiologyTable').DataTable();
});


function manageRequest($pid) {
    event.preventDefault();
    $('.loaderWrapper').fadeIn(0);
    request = $.ajax({
        url: baseUrl+'/radiologyWatch',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'pid':$pid},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response)
        $('#radiologyModalBody').empty();
        if (response.length > 0) {
            $('#patientName').text(response[0].patient);
            for (var i=0; i<response.length; i++){
                content(response, i);
            }
        }else{
            $('#patientName').text('');
            noResults();
        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}


function content(response, $i) {
    var checkIfSaved = (response[$i].radiologyID == null)? false : true;
    var timestamp = formatDate(response[$i].created_at);

    if (checkIfSaved){
        var radiologyStatus = $('<span class="label label-success"">').text('Done');
        var disableAddBtn = 'disabled';
        var disableEditBtn = '';
    }else{
        var radiologyStatus = $('<span class="label label-danger"">').text('Pending');
        var disableAddBtn = '';
        var disableEditBtn = 'disabled';
    }

    var payment = (response[$i].get == null)? $('<span class="label label-danger"">').text('Unpaid') : $('<span class="label label-success"">').text('Paid');

    var addResult = '<a href="'+baseUrl+'/addResult/'+response[$i].id+'" target="_blank" class="btn btn-success btn-circle '+disableAddBtn+'">\n' +
        '                                        <i class="fa fa-plus"></i>\n' +
        '                                    </a>';
    var editResult = '<a href="'+baseUrl+'/radiology/'+response[$i].radiologyID+'/edit" target="_blank" class="btn btn-primary btn-circle '+disableEditBtn+'">\n' +
        '                                        <i class="fa fa-pencil"></i>\n' +
        '                                    </a>';
    var quickView = '<a href="'+baseUrl+'/radiologyPrint/'+response[$i].radiologyID+'" target="_blank" /*onclick="quickView('+response[$i].radiologyID+')"*/ class="btn btn-danger btn-circle '+disableEditBtn+'">\n' +
        '                                        <i class="fa fa-file-text-o"></i>\n' +
        '                                    </a>';

    var categoryColor = (response[$i].category == 'ULTRASOUND')? 'bg-info' : 'bg-warning';
    var tr = $('<tr>');
    var td1 = $('<td>').text(response[$i].requestedBy);
    var td2 = $('<td>').text(response[$i].clinic);
    var td3 = $('<td class="'+categoryColor+'">').text(response[$i].category);
    var td4 = $('<td>').text(response[$i].sub_category);
    var td5 = $('<td>').text('₱ '+response[$i].price+'.00');
    var td6 = $('<td>').append(radiologyStatus);
    var td7 = $('<td>').append(payment);
    var td8 = $('<td>').text(timestamp);
    var td9 = $('<td>').append(quickView);
    var td10 = $('<td>').append(editResult);

    var td11 = $('<td>').append(addResult);
    var row = $(tr).append(td1,td2,td3,td4,td5,td6,td7,td8,td9,td10,td11);
    $('#radiologyModalBody').append(row);

}




function noResults() {
    var noResults = '<tr>\n' +
        '                                <td colspan="10" class="text-center">\n' +
        '                                    <strong class="text-danger">\n' +
        '                                        No Results Found <i class="fa fa-exclamation"></i>\n' +
        '                                    </strong>\n' +
        '                                </td>\n' +
        '                            </tr>';
    $('#radiologyModalBody').append(noResults);
}