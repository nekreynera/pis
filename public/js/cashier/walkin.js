$(document).on('click', 'a.walk-in-patient', function(e){
	e.preventDefault();
	$('#modal-check-patient').modal({backdrop: 'static', keyboard: false});
	// $('#scan-modal').modal('toggle');
});

function openregistrationforpatientbycashier(last_name, first_name) {
	
	$('#walk-in-modal input.last_name').val(last_name);
	$('#walk-in-modal input.first_name').val(first_name);
	$('#walk-in-modal').modal({backdrop: 'static', keyboard: false});
	$('#walk-in-modal input.birthday').focus();
}

$('.select2').select2();

$(document).on('submit', 'form#walk-in-form', function(e){
	e.preventDefault();
	$('#walk-in-modal .loaderRefresh').fadeIn('fast');
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
		if (response.errors) {
			if (response.errors.last_name) {
				toastr.error(response.errors.last_name)
			}
			if (response.errors.first_name) {
				toastr.error(response.errors.first_name)
			}
			if (response.errors.birthday) {
				toastr.error(response.errors.birthday)
			}
			if (response.errors.city_municipality) {
				toastr.error(response.errors.city_municipality)
			}
			if (response.errors.sex) {
				toastr.error(response.errors.sex)
			}
		}else if (response == 'Synchronize Registration Not Allowed.') {
			toastr.error(response)
		}else{
			viewpatienttocashierwindow(response);
			$('#walk-in-modal').modal('toggle');
		}
		$('#walk-in-modal .loaderRefresh').fadeOut('fast');
	});

	request.fail(function (jqXHR, textStatus, errorThrown){
       console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
   	});

   	request.always(function(){
   		console.log('To God be the Glory...');
   	});
});


function viewpatienttocashierwindow(response) {
	nos = 1;
	getpatientinforandcharges(response.barcode);
}