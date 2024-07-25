function quickView($rid) {
    event.preventDefault();
    $('.loaderWrapper').fadeIn(0);
    request = $.ajax({
        url: baseUrl+'/quickView',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'rid':$rid},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        if (response) {
            $('#editResultAnchor').attr('href',baseUrl+'/radiology/'+response.id+'/edit');
            $('#printResultAnchor').attr('href',baseUrl+'/radiologyPrint/'+response.id);
            $('#quickViewContent').html(response.result);
        }else{
            $('#quickViewContent').html($('<strong class="text-danger">Failed to Load File.</strong>'));
        }
        $('#quickViewModal').modal();
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}