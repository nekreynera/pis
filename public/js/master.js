function openHamburger(x) {
    x.classList.toggle("change");
}

$(document).ready(function () {
	$('.hamburger').on('mouseenter', function(){
           $(this).css('background-color','transparent');
    }) ;
});


var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({container: "body"});
});



$(document).ready(function(){
    $('.dropdown-submenu a.test').on("click", function(e){
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
});

$(document).on('click', 'a.change-clinic', function(e){
    // e.prevenDefault();
    $('#modal-clinic').modal('toggle');
});



/*--- Date Time ---*/
function timeCalculate($date){
    var d = new Date($date);
    var days = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
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
    var today = month+' '+day+', '+year+' '+hour+':'+min;
    return today;
}


/*--- Date Time ---*/
function hourMinCalculate($date){
    var d = new Date($date);
    var hour = d.getHours();
    var min = d.getMinutes();
    if(hour < 10){
        hour = '0'+hour;
    }
    if(min < 10){
        min = '0'+min;
    }
    var hourMin = hour+':'+min;
    return hourMin;
}

function dateCalculate($date){
    var d = new Date($date);
    var days = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    var today = month+' '+day+', '+year;
    return today;
}
// function datatabasedateCalculate($date){
//     var d = new Date($date);
//     var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
//     var month = days[d.getMonth()];
//     var day = d.getDate();
//     var year = d.getFullYear();
//     var today = year+'-'+month+'-'+day;
//     return today;
// }
function getpatientAge(dateString) {
    var today = new Date(dateToday);
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

// $('.modal-dialog').draggable({ cursor: "move"});

function toast($color, $message)
{
    var msg = new SpeechSynthesisUtterance();
    msg.text = $message;
    window.speechSynthesis.speak(msg);

    toastr.options = {
        "progressBar": true,
        "positionClass":"toast-bottom-right"
    };
    if($color == 'info'){
        toastr.error($message);
    }else if($color == 'error'){
        toastr.error($message);
    }else if($color == 'warning'){
        toastr.warning($message);
    }else{
        toastr.success($message);
    }
}

