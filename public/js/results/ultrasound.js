function checkRadiology($scope) {
    event.preventDefault();
    $('.medsPrint').fadeOut(0);
    $("#recordsModal").modal();
    $('.loaderWrapper').fadeIn(0);
    var pid = $($scope).attr('data-pid');
    var category = $($scope).attr('data-category');
    $('#recordsHeaderTitle').text($($scope).attr('data-title'));

    request = $.ajax({
        url: baseUrl+'/ultrasoundShow',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':pid,'category':category},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        console.log(response)
        $('.recordsThead').empty();
        $('.medsWatchTbody').empty();
        var thead = labsThead();
        $('.recordsThead').append(thead);
        if (response.length > 0) {
            for (var i = 0; i < response.length; i++) {
                var content = labContent(response, i);
                $('.medsWatchTbody').append(content);
            }
            $('#recordsModal').modal();
        }else{
            $('.medsWatchTbody').append(noResults());
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}

function checklaboratory($scope) {
    $('.medsPrint').fadeOut(0);
    $("#recordsModal").modal();
    $('.loaderWrapper').fadeIn(0);
    var pid = $($scope).attr('data-pid');
    var category = $($scope).attr('data-category');
    $('#recordsHeaderTitle').text($($scope).attr('data-title'));
    request = $.ajax({
        url: baseUrl+'/checklaboratory',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'patient':pid},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        $('.recordsThead').empty();
        $('.medsWatchTbody').empty();
        var thead = '<tr>\n' +
                        '<th>REQUESTED / CHARGED BY</th>\n' +
                        '<th>CLINIC</th>\n' +
                        '<th>DESCRIPTION</th>\n' +
                        '<th>PRICE</th>\n' +
                        '<th>DATE</th>\n' +
                        '<th>EXTRACTION</th>\n' +
                        '<th>RESULT</th>\n' +
                    '</tr>';
        $('.recordsThead').append(thead);
        if (response.length > 0) {
            for (var i = 0; i < response.length; i++) {
                var tr = $('<tr>');
                if (response[i].last_name) {
                    var td1 = $('<td>').addClass('text-capitalize').text(response[i].first_name+' '+((response[i].middle_name)?(response[i].middle_name).charAt(0)+'. ':'')+checkifnull(response[i].last_name));
                }else{
                    var td1 = $('<td>').addClass('text-capitalize').text('N/A');
                }
                var td2 = $('<td>').addClass('text-capitalize').text(checkifnull(response[i].clinic_name));
                var td3 = $('<td>').addClass('text-capitalize').text(response[i].item_name);
                var td4 = $('<td>').addClass('text-capitalize text-right').text('₱ '+(response[i].price).toFixed(2));formatDate
                var td5 = $('<td>').addClass('text-capitalize').text(formatDate(response[i].created_at));
                if (response[i].status == 'Paid') {
                    span = '<span class="label label-success">Paid</span>';
                }else if(response[i].status == 'Pending'){
                    span = '<span class="label label-danger">Pending</span>';
                }else{
                    span = '<span class="label label-primary">Finished</span>';
                }
                var td6 = $('<td>').addClass('text-capitalize text-center').html(span);
                if (new Date(response[i].created_at) >= new Date('2019-08-07 00:00:00')) {
                    if (response[i].lis_result_link) {
                        var td7 = $('<td>').addClass('text-center').html('<button type="button" class="btn btn-sm btn-success laboratory-result" '+((response[i].lis_result_link)?'':'style="display: none;"')+' data-id="'+response[i].request_id+'">Result</button>');
                    }else{
                        var td7 = $('<td>').addClass('text-center').html('<span class="label label-danger">Pending</span>');
                    } 
                }else{
                    var td7 = $('<td>').addClass('text-center').text('N/A');
                }
                $(tr).append(td1,td2,td3,td4,td5,td6, td7)
                $('.medsWatchTbody').append(tr);
            }
            $('#recordsModal').modal();
        }else{
            $('.medsWatchTbody').append(noResults());
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
    
}
$(document).on('click', 'button.laboratory-result', function(e){
    $('#laboratory_result').modal('toggle');
    $('#laboratory_result .loaderRefresh').fadeIn('fast');

    request = $.ajax({
        url: baseUrl+'/getlaboratorypdf/'+ $(this).attr('data-id'),
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        // console.log(response)
        $('#laboratory_result iframe').attr('src', baseUrl+'/public/laboratory/result/pdf/'+response+'.pdf');

    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
});

$('#laboratory_result iframe').load(function(){
    $(this).show();
    $('#laboratory_result .loaderRefresh').fadeOut('fast');
});




function labContent(response, $i) {
    if (response[$i].get == null){
        var status = '<span class="label label-danger">Pending</span>';
        var disable = 'disabled';
    }else{
        if (response[$i].get == 'N'){
            var status = '<span class="label label-danger">Pending</span>';
            var disable = 'disabled';
        }else{
            var status = '<span class="label label-primary">Finished</span>';
            var disable = '';
        }
    }
    var authenticate = (response[$i].users_id == auth)? '' : 'disabled';
    var content = '<tr>\n' +
        '                                <td>'+response[$i].doctorsname+'</td>\n' +
        '                                <td>'+response[$i].name+'</td>\n' +
        '                                <td>'+response[$i].sub_category+'</td>\n' +
        '                                <td>₱ '+response[$i].price+'.00</td>\n' +
        '                                <td>'+formatDate(response[$i].created_at)+'</td>\n' +
        '                                <td>\n' +
        '                                    '+status+'\n' +
        '                                </td>\n' +
        '                                <td>\n' +
        '                                    <a href="'+baseUrl+'/radiologyPrint/'+response[$i].rid+'" target="_blank"  class="btn btn-sm btn-success '+disable+'">\n' +
        '                                        <i class="fa fa-file-text-o"></i> Result\n' +
        '                                    </a>\n' +
        '                                </td>\n' +
        '                            </tr>';
    return content;
}

/*onclick="radiologyResult('+response[$i].rid+')"*/



function labsThead() {
    var thead = '<tr>\n' +
        '                            <th>REQUESTED_BY</th>\n' +
        '                            <th>CLINIC</th>\n' +
        '                            <th>DESCRIPTION</th>\n' +
        '                            <th>PRICE</th>\n' +
        '                            <th>DATE</th>\n' +
        '                            <th>STATUS</th>\n' +
        '                            <th>VIEW RESULT</th>\n' +
        '                        </tr>';
    return thead;
}

function noResults() {
    var noResult = '<tr>\n' +
        '                                    <td colspan="8" class="text-center">\n' +
        '                                        <h5><strong class="text-danger">\n' +
        '                                            No Results Found <i class="fa fa-exclamation"></i>\n' +
        '                                        </strong></h5>\n' +
        '                                    </td>\n' +
        '                                </tr>';
    return noResult;
}

function checkifnull(data) {
    if (data) {
        return data;
    }else{
        return '';
    }
    // body...
}