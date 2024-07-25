$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({container: "body"});


    $('.viewImage').on('click', function () {
       event.preventDefault();
        var img = $(this).siblings('img').attr('src');
        var title = $(this).siblings('input[type="hidden"]').val();
        var decsription = $(this).siblings('textarea').val();
        $('#showTitle').val(title);
        $('#showDescription').val(decsription);
        $('#showImage').attr('src', img);
        $('#imagePreview').modal('show');
    });



    $('.deleteFile').on('click', function () {
        return confirm('Delete this file?');
    });


    $('.deleteConsultation').on('click', function () {
        return confirm('Delete this consultation?');
    });


    $('.editConsultation').on('click', function () {
        return confirm('Edit this consultation?');
    });






});
