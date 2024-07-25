var bp = '';
var pr = '';
var rr = '';
var temp = '';
var wt = '';
var ht = '';

function bptest()
{

    $('.loaderRefresh').fadeIn('fast');

    request = $.ajax({
        url: baseUrl+'/getBP',
        type: "post",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response)
        if(response){

            var bp = (response.blood_pressure)? 'BP: '+response.blood_pressure : '';
            var pr = (response.pulse_rate)? 'PR: '+response.pulse_rate : '';
            var rr = (response.respiration_rate)? 'RR: '+response.respiration_rate : '';
            var temp = (response.body_temperature)? 'TEMP: '+response.body_temperature : '';
            var wt = (response.weight)? 'WT: '+response.weight : '';
            var ht = (response.height)? 'HT: '+response.height : '';

        }
    });

    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    });

    request.always(function(){

        var table = '<table id="teddy" class="table table-bordered" style="border-collapse:collapse; width:100%;height:1200px;" border="1">' +
            '<thead>' +
            '<tr style="background-color: #ccc;width: 400pxnote">' +
            '<th style="padding:5px;width:90px;text-align:center" class="mceNonEditable">DATE/TIME</th>' +
            '<th style="padding:5px;width:330px;text-align:center" class="mceNonEditable">DOCTOR\'S CONSULTATION</th>' +
            '<th style="padding:5px;width:130px;text-align:center" class="mceNonEditable">NURSE\'S NOTES</th>' +
            '</tr>' +
            '</thead>' +
            '<tbody>' +
            '<tr style="width: 300px;">' +
            '<td valign="top" style="width:90px;" id="doctors" class="mceEditable">' +
            ''+today+'' +
            '<p>'+bp+'</p>'+
            '<p>'+pr+'</p>'+
            '<p>'+rr+'</p>'+
            '<p>'+temp+'</p>'+
            '<p>'+wt+'</p>'+
            '<p>'+ht+'</p>'+
            '</td>' +
            '<td valign="top" style="width:330px;height: 668px" id="doctors" class="mceEditable"><span id="uniqueId">&nbsp;</span></td>' +
            '<td valign="top" style="width:130px;" class="mceEditable"></td>' +
            '</tr>' +
            '</tbody>' +
            '</table>';

        tinyMCE.activeEditor.setContent(table)

        $('.loaderRefresh').fadeOut('fast');
    });

}