$('#modal-remove-patient').on('shown.bs.modal', function(){
    $('#modal-remove-patient textarea.remark').focus();
});


function removePatientInfo(id) {
	request = $.ajax({
	    url: baseUrl+'/removePatientInfo/'+id,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {
		console.log(response);	
		updateINputsValue(response);    
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('#modal-remove-patient').modal('toggle');
	    $('#modal-remove-patient .loaderRefresh').fadeIn('fast');
	    $('#modal-remove-patient .loaderRefresh').fadeOut('fast');
	});
}

function updateINputsValue(response) {
	$('#modal-remove-patient form').attr('action', baseUrl+/patients/+ response.patient.id);
	$('#modal-remove-patient .id_no').val(response.patient.hospital_no);
	$('#modal-remove-patient .last_name').val(response.patient.last_name);
	$('#modal-remove-patient .first_name').val(response.patient.first_name);
	$('#modal-remove-patient .request_by').val(response.user.first_name+' '+response.user.middle_name+' '+response.user.last_name);
	$('#modal-remove-patient .date_request').val(dateCalculate(dateToday));
}

$(document).on('submit', '#remove-form', function(e){
	e.preventDefault();
	$('#modal-remove-patient .loaderRefresh').fadeIn('fast');
	var scope = $(this);
	var url = $(scope).attr('action');
	var data = $(scope).serialize();
		request = $.ajax({
		    url: url,
		    type: "post",
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    data: data,
		    dataType: "json"
		});

		request.done(function (response, textStatus, jqXHR) {
			if (response) {
					if (response.errors) {
						toastr.error(response.errors.remark);
					}else{
				    $('#modal-remove-patient').modal('toggle');
				    $('#patient-table tbody tr').each(function(){
				    	var id = $(this).attr('data-id');
				    	if (id == response.patient_id) {
				    		$(this).find('td .fa-user-o').addClass('text-red');
				    		$(this).attr('status', 'remove');
				    	}
				    });
				    toastr.info('The Patient record is now marked for delete');
				    $('#remove-button').html('<span class="fa fa-reply"></span> Cancel').attr('status', 'cancel');
				    $('.trial-click #remove-button').html('<span class="fa fa-reply"></span> Cancel').attr('status', 'cancel');
					// console.log(response);	
					}
				}else{
					toastr.error('The Patient record is already marked for delete');
				}
			
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
		    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		    toastr.error('Oops! something went wrong.');
		});
		request.always(function (response){
		    console.log("To God Be The Glory...");
		    $('#modal-remove-patient .loaderRefresh').fadeOut('fast');
		});
});



function cancelRemoveRequest(id) {
	var conf = confirm("Are you sure you want to Cancel your request to remove this patient?");
	if (conf) {
		$('#main-page .box-footer .text-muted').hide();
		$('#main-page .loaderRefresh').fadeIn('fast');
		request = $.ajax({
		    url: baseUrl+/cancelRemoveRequest/+id,
		    type: "get",
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    dataType: "json"
		});

		request.done(function (response, textStatus, jqXHR) {
			console.log(response);
			toastr.info('The deletion request for patient record cancelled');
			$('#remove-button').html('<span class="fa fa-trash"></span> Remove').attr('status', '');
			$('.trial-click #remove-button').html('<span class="fa fa-trash"></span> Remove').attr('status', '');
		});

		request.fail(function (jqXHR, textStatus, errorThrown){
		    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		    toastr.error('Oops! something went wrong.');
		});

		request.always(function (response){
		    console.log("To God Be The Glory...");
		    $('#main-page .loaderRefresh').fadeOut('fast');
		});

		$('#patient-table tbody tr').each(function(){
			var ids = $(this).attr('data-id');
			if (ids == id) {
				$(this).find('td .fa-user-o').removeClass('text-red');
				$(this).attr('status', '');
			}
		});
	}
}

function deletepatient(id) {
	$('#main-page .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+/deletepatient/+id,
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
	    $('#main-page .loaderRefresh').fadeOut('fast');
	});

	$('#patient-table tbody tr').each(function(){
		var ids = $(this).attr('data-id');
		if (ids == id) {
			$(this).remove();
		}
	});
	// $(this).attr('href', baseUrl+'/deletepatient/'+id);
}