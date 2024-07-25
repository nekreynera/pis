$(document).on('click', '#new-patient', function(){
	$('#modal-scan-patient').modal('toggle');
});

function passidtoactionandlabel(id) {
	// body...
	$("button#view-patient").attr('data-id', id).removeClass('disabled');
	$("a#patient-information").attr('data-id', id);
	$("a#medical-record").attr('data-id', id);
    $('button.queued-status-button').attr('data-id', id);

	$('#patient-information').attr('data-id', id).closest('li').removeAttr('class');
	$('#medical-record').attr('data-id', id).closest('li').removeAttr('class');
	
}
$(document).on('click', '#view-patient', function(){
	var id = $(this).attr("data-id");
    if (id == '#') {
        toastr.error('Kindly Select Patient First');
    }else{
        viewpatienttransaction(id);
    }
});

$(document).on('click', 'button.queued-status-button', function(){
    var id = $(this).attr("data-id");
    var action = $(this).attr("data");
    if (id == '#') {
        toastr.error('Kindly Select Patient First');
    }else{
        updatepatientqueingstatus(id, action);
    }
})




/*===END OF NEW PATIENT===*/
var something = $('.trial-click');
$(document).on('mousedown', '#patient-table tbody tr', function(event) {
    switch (event.which) {
        case 3:
        	var id = $(this).attr('data-id');
        	passidtoactionandlabel(id)
        	something.slideDown('fast');
        	something.css({
        		// display: "block",
        		left: event.pageX-235,
        		top: event.pageY-100
        	});
        	$('.trial-click button, .trial-click a').attr('data-id', id);
        	return false;
            // alert('Right mouse button is pressed');
        break;
    }
});
$('html').click(function() {
        something.slideUp('fast');
});

$(document).on('click', '#printpatientslogs', function(){
    getalltransactedpatiens();
});
