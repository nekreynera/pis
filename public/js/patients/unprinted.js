$(document).ready(function() {
    $('#unprintedTable').DataTable();
});


$(document).ready(function () {
    $('.dropdown-menu a').on('click', function () {
        event.preventDefault();
        var filter = $(this).attr('class');
        switch(filter){
            case 'birthday':
                $('#searchInput').attr({'type':'date','placeholder':'Search For Patient Birthday...','name':'birthday'});
                break;
            case 'barcode':
                $('#searchInput').attr({'type':'text','placeholder':'Search For Patient Barcode...','name':'barcode'});
                break;
            case 'hospital_no':
                $('#searchInput').attr({'type':'text','placeholder':'Search For Patient Hospital No#...,','name':'hospital_no'});
                break;
            case 'created_at':
                $('#searchInput').attr({'type':'date','placeholder':'Search For Patient Registered Date...','name':'created_at'});
                break;
            default :
                $('#searchInput').attr({'type':'text','placeholder':'Search For Patient Name...','name':'name'});

        }
    });
});



    function printcard(scope) {

        var trHide = $(scope);
        var id = $(scope).attr('data-id');
        request = $.ajax({
            url: baseUrl+"/printed",
            type: "post",
            data: {'id':id}
        });
        request.done(function (response, textStatus, jqXHR) {
            /*$(trHide).closest('tr').hide('fast');*/
            $('#unprintedTable').load(baseUrl+"/unprinted #unprintedTable");
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });


    };


    function searchprintcard(scope) {
        var trHide = $(scope);
        var id = $(scope).attr('data-id');
        request = $.ajax({
            url: baseUrl+"/printed",
            type: "post",
            data: {'id':id}
        });
        request.done(function (response, textStatus, jqXHR) {
            $(trHide).closest('tr').hide('fast');
            /*$('#unprintedTable').load(baseUrl+"/unprinted #unprintedTable");*/
        });
        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });
    }
