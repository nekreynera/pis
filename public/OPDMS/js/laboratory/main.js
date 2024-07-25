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

$(document).ready(function(){

    $( "#datemask1, #datemask2" ).datepicker({
        dateFormat: 'mm/dd/yyyy',
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