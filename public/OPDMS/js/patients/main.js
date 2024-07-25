function timeCalculateformat($date){
    var d = new Date($date);
    var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var hour = d.getHours();
    var min = d.getMinutes();
    if(hour < 10){
        hour = '0'+hour;
    }
    if(min < 10){
        min = '0'+min;
    }
    var ini = 'AM';
    if (hour >= 12 && min >= 1) {
        ini = 'PM';
    }
    var today = month+'/'+day+'/'+year+' '+hour+':'+min+' '+ini;
    return today;
}

function dateCalculate($date){
    var d = new Date($date);
    var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    if (day < 10) {
        day = '0'+day;
    }
    var today = month+'/'+day+'/'+year;
    return today;
}

function mysqlDateformat($date){
    var d = new Date($date);
    var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
     if (day < 10) {
        day = '0'+day;
    }
    var today = year+'-'+month+'/'+day;
    return today;
}
function calculateAge(birthday) {
        var d = new Date(birthday);
        var days = [1,2,3,4,5,6,7,8,9,10,11,12];
        var dobMonth = days[d.getMonth()];
        var dobDay = d.getDate();
        var dobYear = d.getFullYear();

        var bthDate, curDate, days;
        var ageYears, ageMonths, ageDays;

            bthDate = new Date(dobYear, dobMonth-1, dobDay);
            curDate = new Date(dateToday);
        
        var ageText = '';

            ageYears = curDate.getFullYear() - bthDate.getFullYear();
            ageMonths = curDate.getMonth() - bthDate.getMonth();
            ageDays = curDate.getDate() - bthDate.getDate(); 

                if (ageDays < 0) {
                    ageMonths = ageMonths - 1;
                    ageDays = ageDays + 31;
                }
                ageWeeks = ageDays;
                if (ageMonths < 0) {
                    ageYears = ageYears - 1;
                    ageMonths = ageMonths + 12;
                }
                ageText = "";
                ageText = ageText + ageYears + "Y";
                ageText = ageText + ageMonths + "M";
                ageText = ageText + ageWeeks + "D";
                return ageText;

};

function getAge(dateString) {
    
    var today = new Date(dateToday);

    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

$('#datemask1, #datemask2').change(function(){
    $('.calculated-age').val(getAge($(this).val()));
})

// $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
$('[data-mask]').inputmask();

$(document).ready(function(){

    $( "#datemask1, #datemask2" ).datepicker({
        dateFormat: 'mm/dd/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: "-110:+0",
        maxDate: dateToday,
    });

    $("#from-month").datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/dd/yy',
        maxDate: dateToday,
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year,month,1));
            $(".ui-datepicker-calendar").hide();
        },
        
    });

    $("#to-month").datepicker({
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'mm/dd/yy',
        maxDate: dateToday,
        onClose: function (dateText, inst) {
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year,month,(lastday(year, month))));
            $(".ui-datepicker-calendar").hide();
        },
        
    });

    $("#from-month, #to-month").focus(function () {
        $(".ui-datepicker-calendar").hide();
    });
});

function lastday(y,m){
    return  new Date(y, Number(m) + 1, 0).getDate();
}


function getallclinics(triage){
    request = $.ajax({
        url: baseUrl+'/registerclinics',
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        $('.clinic_code').empty();
        var opt = $('<option>').attr('value', "").attr('hidden', true).text('--');
        $('.clinic_code').append(opt);
        for (var i = 0;i < response.length; i++) {

            if (triage && triage.clinic_code == response[i].code) {
            var option = $('<option>').attr('value', response[i].code).attr('selected', true).text(response[i].name);
            }else{
            var option = $('<option>').attr('value', response[i].code).text(response[i].name);
            }
            $('.clinic_code').append(option);
        }
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
    });
}



function refreshpatienttableContent(){
    $('#main-page .loaderRefresh').fadeIn('fast');

    request = $.ajax({
        url: baseUrl+'/RegisteredToday',
        type: "get",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: "json"
    });

    request.done(function (response, textStatus, jqXHR) {
        console.log(response);
        refreshpatienttableContentController(response);
    });
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
        toastr.error('Oops! something went wrong.');
    });
    request.always(function (response){
        console.log("To God Be The Glory...");
        $('#main-page .loaderRefresh').fadeOut('fast');
    });
}


function clearinputs(){
    $('.modal .hospital_no').val('');
    $('.modal .last_name').val('');
    $('.modal .first_name').val('');
    $('.modal .middle_name').val('');
    $('.modal .suffix').val('');
    $('.modal .birthday').val('');
    $('.modal .sex').val('');
    $('.modal .civil_status').val('');
    $('.modal .contact_no').val('');
    $('.modal .address').val('');
    $('.modal .city_municipality_modal').val('');
    $('.modal .brgy_modal').val('');
    $('.modal .clinic_code').val('');
    $('.modal .weight').val('');
    $('.modal .height').val('');
    $('.modal .blood_pressure').val('');
    $('.modal .pulse_rate').val('');
    $('.modal .respiration_rate').val('');
    $('.modal .body_temperature').val('');
}