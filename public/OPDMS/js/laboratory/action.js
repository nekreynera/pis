function gotosubactionJs(id) {
	$('#edit-sub').attr('data-id', id);
	$('#remove-sub').attr('data-id', id);
	$('#edit-list').addClass('disabled').attr('data-id', '#');
	$('#remove-list').addClass('disabled').attr('data-id', '#');
	$('#service-information').attr('data-id', '#').closest('li').addClass('disabled');

}

function gotolistJs(id){
	$('#edit-list').removeClass('disabled').attr('data-id', id);
	$('#remove-list').removeClass('disabled').attr('data-id', id);
	$('#service-information').attr('data-id', id).closest('li').removeAttr('class');
}

/*============================*/


$(document).on('click', '#new-sub', function(){
	getLaboratory(id = null);
	$('#modal-new-sub').modal('toggle');
});


$(document).on('click', '#new-list', function(e){
	getLaboratorySub(2, selected = null);
	getLaboratory(id = 2);

    $('#modal-new-list').modal("toggle");
});


/*===== END OF NEW ACTION=====*/

$(document).on('click', '#edit-sub', function(){

	var id = $(this).attr('data-id');
	if (id == '#') {
		toastr.error('Kindly Select Pathology First');
	}else{
		EditPathology(id);
	}
	
});

$(document).on('click', '#edit-list', function(){

	var id = $(this).attr('data-id');
	if (id == '#') {
		toastr.error('Kindly Select Serviced First');
	}else{
		EditLIst(id);
	}
	
});






/*===== END OF EDIT ACTION=====*/

var something = $('.trial-click');
$(document).on('mousedown', '#ancillary-table tbody tr', function(event) {
    switch (event.which) {
        case 3:
        	var id = $(this).attr('data-id');
        	gotolistJs(id);
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