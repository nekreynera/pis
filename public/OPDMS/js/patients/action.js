$(document).on('click', '#check-patient-toggle', function(){
	modalCheckpatient();
})
$(document).on('click', '#edit-button', function(){
	var id = $(this).attr('data-id');
	if (id == "#") {
		toastr.error('Kindly Select Patient Record First');
	}else{
		edit_patient(id, enable = false);
	}
})

$(document).on('click', '#print-button', function(){
	var id = $(this).attr('data-id');
	if (id == "#") {
		toastr.error('Kindly Select Patient Record First');
	}else{
		$('#patient-table tbody tr').each(function(){
			var tr_id = $(this).attr("data-id");
			if (id == tr_id) {
				$(this).find('.print_status').html('<small class="label bg-green">Printed</small>');
			}
		})


		$(this).attr('href', baseUrl+'/patients/'+id);
		$(this).attr("target", "_blank")
	}
})


$(document).on('click', '#delete-button', function(){
	var id = $(this).attr('data-id');
	if (id == "#") {
		toastr.error('Kindly Select Patient Record First');
	}else{
		var conf = confirm("Are you sure you want to delete this patient?");
		if (conf) {
    		deletepatient(id);
			
		}
		
	}
})

$(document).on('click', '#remove-button', function(){
	var id = $(this).attr('data-id');
	var status = $(this).attr('status');
	if (id == '#') {
		toastr.error('Kindly Select Patient Record First');
	}else{
		if (status == "cancel") {
			cancelRemoveRequest(id);
		}else{
			removePatientInfo(id);
		}
	}
});


$(document).on('click', '#print-multiple', function(){
	var count = 50; 
	$('.print-count').val('50');
	printMultipleTable(count);
	$('#modal-print-patient').modal('toggle');
});

var something = $('.trial-click');
$(document).on('mousedown', '#patient-table tbody tr', function(event) {
	
    switch (event.which) {
        
        case 3:
        	var id = $(this).attr('data-id');
        	foractionandtr($(this));
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
