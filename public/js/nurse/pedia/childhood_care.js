$(document).ready(function () {
    $('#children_careForm').on('submit', function () {
        var ans = confirm('Do you really want save this form?');
        if (ans){
            $('.loaderRefresh').fadeIn('fast');
        } else{
            event.preventDefault();
        }
    });
});