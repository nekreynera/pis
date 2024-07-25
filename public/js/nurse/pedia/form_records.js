var pid;
function showPediaForms($pid)
{
    pid = $pid;

    $('#therapeuticCareDivWrapper').collapse('hide');
    $('#childHoodCareHeader').collapse('hide');
    $('#kmcHeader').collapse('hide');

    $('.therapeuticCareAnchorCreate').attr('href',baseUrl+'/otpc_homepage/'+pid);
    $('.childHoodCareAnchorCreate').attr('href',baseUrl+'/childhood_care/'+pid);
    $('.kmcAnchorCreate').attr('href',baseUrl+'/kmc/'+pid);

    $('#formRecordsModal').modal();
}


$(document).ready(function () {


   $('#therapeuticCareDivWrapper').on('show.bs.collapse', function () {

       $('#formRecordsModal .loaderRefresh').fadeIn();

       request = $.ajax({
           url: baseUrl+"/therapeuticCareList",
           type: "post",
           data: {'pid':pid},
           dataType: "json"
       });

       request.done(function (response, textStatus, jqXHR) {
           console.log(response);

           $('.therapeuticCareUL').empty();

            if (response.data.length > 0){
                response.data.forEach(function (index) {
                    var li = $('<li class="list-group-item">');
                    var em = $('<em class="text-muted small">').text('Created Date: '+ dateCalculate(index.created_at));
                    var view = $('<a href="'+baseUrl+'/printOTC/'+index.id+'" target="_blank" class="btn btn-sm btn-success" style="margin: auto 5px">').text('View');
                    var edit = $('<a href="'+baseUrl+'/otpc_edit/'+index.id+'" target="_blank" class="btn btn-sm btn-info">').text('Edit');
                    if (response.clinic == 26) {
                      $(li).append(em,view,edit);
                    } else {
                      $(li).append(em,view);
                    }
                    $('.therapeuticCareUL').append(li);
                });
            }else{
                   var li = $('<li class="list-group-item list-group-item-danger">');
                   var p = $('<p class="text-center small">').text('There was no saved Therapeutic Care for this patient.');
                   $(li).append(p);
                   $('.therapeuticCareUL').append(li);
            }

       });

       request.fail(function (jqXHR, textStatus, errorThrown){
           console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
       });

       request.always(function (){
           $('#formRecordsModal .loaderRefresh').fadeOut();
       });

   });




   // childhood care


    $('#childHoodCareHeader').on('show.bs.collapse', function () {

        $('#formRecordsModal .loaderRefresh').fadeIn();

        request = $.ajax({
            url: baseUrl+"/childHoodCareList",
            type: "post",
            data: {'pid':pid},
            dataType: "json"
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log(response);

            $('.childHoodCareUL').empty();

            if (response.data.length > 0){
                response.data.forEach(function (index) {
                    var li = $('<li class="list-group-item">');
                    var em = $('<em class="text-muted small">').text('Created Date: '+ dateCalculate(index.created_at));
                    var view = $('<a href="'+baseUrl+'/printChildHoodCare/'+index.id+'" target="_blank" class="btn btn-sm btn-success" style="margin: auto 5px">').text('View');
                    var edit = $('<a href="'+baseUrl+'/childhood_care_edit/'+index.id+'" target="_blank" class="btn btn-sm btn-info">').text('Edit');
                    if (response.clinic == 26) {
                      $(li).append(em,view,edit);
                    } else {
                      $(li).append(em,view);
                    }
                    $('.childHoodCareUL').append(li);
                });
            }else{
                var li = $('<li class="list-group-item list-group-item-danger">');
                var p = $('<p class="text-center small">').text('There was no saved Childhood Care for this patient.');
                $(li).append(p);
                $('.childHoodCareUL').append(li);
            }

        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });

        request.always(function (){
            $('#formRecordsModal .loaderRefresh').fadeOut();
        });

    });



    // kmc


    $('#kmcHeader').on('show.bs.collapse', function () {

        $('#formRecordsModal .loaderRefresh').fadeIn();

        request = $.ajax({
            url: baseUrl+"/kmcList",
            type: "post",
            data: {'pid':pid},
            dataType: "json"
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log(response);

            $('.kmcUL').empty();

            if (response.length > 0){
                response.forEach(function (index) {
                    var li = $('<li class="list-group-item">');
                    var em = $('<em class="text-muted small">').text('Created Date: '+ dateCalculate(index.created_at));
                    var view = $('<a href="'+baseUrl+'/printKMC/'+index.id+'" target="_blank" class="btn btn-sm btn-success" style="margin: auto 5px">').text('View');
                    var edit = $('<a href="'+baseUrl+'/kmc_edit/'+index.id+'" target="_blank" class="btn btn-sm btn-info">').text('Edit');
                    $(li).append(em,view,edit);
                    $('.kmcUL').append(li);
                });
            }else{
                var li = $('<li class="list-group-item list-group-item-danger">');
                var p = $('<p class="text-center small">').text('There was no saved KMC for this patient.');
                $(li).append(p);
                $('.kmcUL').append(li);
            }

        });


        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });


        request.always(function (){
            $('#formRecordsModal .loaderRefresh').fadeOut();
        });

    });

});