function showTemplate($scope) {
    event.preventDefault();
    $('.loaderWrapper').fadeIn(0);
    request = $.ajax({
        url: baseUrl+'/showTemplate',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {'id':$scope},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        tinymce.activeEditor.setContent(response.content);
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });
    request.always(function(){
        $('.loaderWrapper').fadeOut(0);
    });


}