$(document).ready(function () {

    var fontSize = 13;
    var enableToggle = true;


    $('#windowMinimize').on('click', function () {
        $('#viewerContainer').fadeOut('fast', function () {
            $('#minimizer').fadeIn(0);
        });
    });


    $('.closeWindow').on('click', function () {
        $('#viewerContainer').fadeOut('fast', function () {
            $('#minimizer').fadeOut(0);
        });
    });



    $('#chevronMinimize').on('click', function () {
        var screen = screenWidth();
        if (screen > 768) {
             $('#thumbnailsContainer').hide('slow', function () {
                 $('.mainContentWrapper').animate({
                     width:'100%'
                 });
                 $('#chevronMaximize').fadeIn('fast');
             });
        }else{
             $('#thumbnailsContainer').fadeOut('fast', function () {
                 $('.mainContentWrapper').animate({
                     width:'100%'
                 });
                 $('#chevronMaximize').fadeIn('fast');
             });
        }
    });





    $('#chevronMaximize').on('click', function () {
         var screen = screenWidth();
         var sheight = screenHeight();
         $('.thumbnailsWrapper').css({'height':sheight - '150' +'px'})
         if (screen > 1023) {
             $('.mainContentWrapper').animate({
                 width:'83.1%'
             }, function () {
                 $('#thumbnailsContainer').show('slow');
                 $('#chevronMaximize').fadeOut('fast');
             });
        }else{
             $('.mainContentWrapper').animate({
                 width:'100%'
             }, function () {
                 $('#thumbnailsContainer').fadeIn('fast');
                 $('#chevronMaximize').fadeOut('fast');
             });
        }
    });




    $('#zoomIn').on('click', function () {
        fontSize += 1;
        var pagewidth = $('.pageContent').width();
        alert(pagewidth)
        if (pagewidth < 1200) {
            $('.pageContent').css({'width': 100 + pagewidth});
            $('.pageContent td').css({'font-size': fontSize + 'px'});
            $('#zoomOut').removeClass('disabled');
        }else{
            $('#zoomIn').addClass('disabled');
        }
    });

    $('#zoomOut').on('click', function () {
        fontSize -= 1;
        var pagewidth = $('.pageContent').width();
        alert(pagewidth)
        if (pagewidth > 800){
            $('.pageContent').css({'width':pagewidth - 100});
            $('.pageContent td').css({'font-size':fontSize+'px'});
            $('#zoomIn').removeClass('disabled');
        }else{
            $('#zoomOut').addClass('disabled');
            $('.pageContent td').css({'font-size':'13px'});
            fontSize = 13;
        }
    });


    $('#viewerContainer').on('dblclick', function () {
        if (enableToggle){
            windowRestore();
            enableToggle = false;
        }else{
            windowMaximize();
            enableToggle = true;
        }
    });






});


function screenWidth() {
     return screen.width;
}

function screenHeight() {
     return screen.height;
}

function windowGrow() {
    $('#viewerContainer').show();
    $('#minimizer').fadeOut(0);
    windowMaximize();
}



function windowMaximize() {
    $('#viewerContainer').removeClass('halfViewer').addClass('fullViewer').css({'left':'10px','top':0,'bottom':0,'right':0});
    $('.contentWindow #windowRestore').addClass('fa-window-restore').removeClass('fa-window-maximize').attr('onclick','windowRestore()');
    $('#minimizer').fadeOut(0);
    maximizePoint();
}



function windowRestore() {
    $('#viewerContainer').addClass('halfViewer').removeClass('fullViewer');
    $('.contentWindow #windowRestore').addClass('fa-window-maximize').removeClass('fa-window-restore').attr('onclick','windowMaximize()');
    restorePoint();
}



function maximizePoint() {
    $('.mainContent').css('height','620px');
    $('.thumbnailsWrapper').css('height','620px');
    $('.thumbnailContent').css({'height':'150px','width':'130px'});
    deactivateDragging();
}


function restorePoint() {
    $('.mainContent').css('height','430px');
    $('.thumbnailsWrapper').css('height','430px');
    $('.thumbnailContent').css({'height':'100px','width':'100px'});
    activateDragging();
}


function activateDragging() {
    $('#viewerContainer').draggable({'disabled':false});
}


function deactivateDragging() {
    $('#viewerContainer').draggable({'disabled':true});
}
