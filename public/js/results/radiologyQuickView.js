function radiologyResult($scope) {
    alert('dasdsad');
    event.preventDefault();
    $('.loaderWrapper').fadeIn(0);

    request = $.ajax({
        url: baseUrl+'/quickView',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'rid':$scope},
        dataType: "json"
    });
    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
            $('#radiologyResultWrapper').html(response.result);
        $('#radiologyResultModal').modal();
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });
}