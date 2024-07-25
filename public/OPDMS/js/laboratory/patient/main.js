function getpatientstoday() {
	request = $.ajax({
	    url: baseUrl+'/getlaboratorypatients/',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		console.log(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('.content-container .loaderRefresh').fadeOut('fast');
	});
}


function checkobject(response){
	var response = (response ? response : "N/A")
	return response;
}

$(document).on('click', '.queing-status-button button', function(){
	$(this).attr('id', 'selected').siblings('button').attr('id', '');
	$('#main-page .box-body .loaderRefresh').fadeIn('fast');
	var status = $(this).attr('data');
	appendqueuedpatientstotable(json_patient_queued, status);
	// request = $.ajax({
	//     url: baseUrl+'/getlaboratorypatientsbystatus/'+status,
	//     type: "get",
	//     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	//     dataType: "json"
	// });
	// request.done(function (response, textStatus, jqXHR) {
	// 	appendqueuedpatientstotable(response)
	// });
	// request.fail(function (jqXHR, textStatus, errorThrown){
	//     console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	//     toastr.error('Oops! something went wrong.');
	// });
	// request.always(function (response){
	//     console.log("To God Be The Glory...");
		$('#main-page .box-body .loaderRefresh').fadeOut('fast');
	// });
	
});

function patientqueuedtabs(json_patient_queued){
	var pending = 0;
	var done = 0;
	var removed = 0;
	console.log(json_patient_queued);
	for (var i = 0; i < json_patient_queued.length; i++) {
		if (json_patient_queued[i].status == 'P') {
			pending+=1;
		}
		if (json_patient_queued[i].status == 'F') {
			done+=1;
		}
		if (json_patient_queued[i].status == 'R') {
			removed+=1;

		}
	}
	
	$('small#pending-badge').text(pending);
	$('small#done-badge').text(done);
	$('small#removed-badge').text(removed);
	$('small#all-badge').text(json_patient_queued.length);

}

$('#modal-request-form .modal-content').resizable({
    alsoResize: "#modal-request-form .modal-body",
    maxHeight: 800,
    maxWidth: 1200,
    minHeight: 530,
    minWidth: 700
});


function updatepatientqueingstatus(id, action) {
	var status = $('.queing-status-button button#selected').attr('data');
	request = $.ajax({
	    url: baseUrl+'/updatepatientqueingstatus/'+id+'/'+action+'/'+status,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		json_patient_queued = response;
		appendqueuedpatientstotable(response, action);
        patientqueuedtabs(response);

		toastr.info('Queued patient move to '+action);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
		$('#main-page .box-body .loaderRefresh').fadeOut('fast');
	});
}

