$('#modal-store-patient').on('shown.bs.modal', function(){
    $('#modal-store-patient input.middle_name').focus();
});

$(document).on('click', '#savereg, #saveclose', function(){
	if ($(this).attr('id') == 'savereg') {
		$('#modal-store-patient .registeragain').val('yes');
	}else{
		$('#modal-store-patient .registeragain').val('no');
	}
});


$(document).on('submit', '#modal-store-patient #store-form', function(e){
	$('#modal-store-patient .loaderRefresh').fadeIn('fast');
		e.preventDefault();
		var action = $(this).attr('action');
		data = $(this).serialize();
		request = $.ajax({
		    url: action,
		    type: "post",
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    data: data,
		    dataType: "json"
		});

		request.done(function (response, textStatus, jqXHR) {
		    console.log(response);
		    if (response.patient == 'Synchronize Registration Not Allowed.') {
		    	toastr.error(response.patient);
		    }
		    if (response.errors) {
		    	if (response.errors.last_name) {
		    		toastr.error(response.errors.last_name);
		    	}
		    	if (response.errors.first_name) {
		    		toastr.error(response.errors.first_name);
		    	}
		    	if (response.errors.birthday) {
		    		toastr.error(response.errors.birthday);
		    	}
		    	if (response.errors.city_municipality) {
		    		toastr.error(response.errors.city_municipality);
		    	}
		    	if (response.errors.sex) {
		    		toastr.error(response.errors.sex);
		    	}
		    }else{
		    	if ($('#modal-store-patient .registeragain').val() == 'yes') {
		    		modalCheckpatient();
		    	}
		    	clearinputs();
		    	refreshpatienttableContent();
		    	$('#modal-store-patient').modal('toggle');
		    	toastr.success('The Data Entry Successfully Saved');
		    }
		    
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
		    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		    toastr.error('Oops! something went wrong.');
		});
		request.always(function (response){
		    console.log("To God Be The Glory...");
	    	$('#modal-store-patient .loaderRefresh').fadeOut('fast');
		});
});



