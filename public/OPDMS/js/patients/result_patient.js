$('#modal-check-result').on('shown.bs.modal', function(){
    $('#modal-check-result .search-patient-input').focus();
});

function result_patient(response) {
	if (response.length > 0) {
			// console.log(response);
			$('#modal-check-result').modal('toggle');
			result_tbody(response);
			// $('#ignore-and-create').attr('href', baseUrl+'/blankpage/'+$('.l_name').val()+'/'+$('.f_name').val());	
	}else{
		if (getUrl.href == 'http://172.17.4.8/opd/cashier') {
			var last_name = $('#modal-check-patient .l_name').val();
			var first_name = $('#modal-check-patient .f_name').val();
			openregistrationforpatientbycashier(last_name, first_name);
		}else{
			clonevalue(hospital_no = true);
		}
	}
	$('#modal-check-patient').modal('toggle');
}


$(document).on('click', '#back-to-search', function(){
	$('#modal-check-patient').modal('toggle');
});

$(document).on('click', '#ignore-and-create', function(){
	if (getUrl.href == 'http://localhost/opd/cashier') {
		var last_name = $('#modal-check-patient .l_name').val();
		var first_name = $('#modal-check-patient .f_name').val();
		openregistrationforpatientbycashier(last_name, first_name);
	}else{
		clonevalue(hospital_no = false);
	}
});	


function clonevalue(hospital_no) {
	var last_name = $('#modal-check-patient .l_name').val();
	var first_name = $('#modal-check-patient .f_name').val();
	var id_no = $('#modal-check-patient .id_no').val();
	var option = $('#modal-check-patient .search-option').val();
	if (option == '1') {
		$('#modal-store-patient input.last_name').val(last_name);
		$('#modal-store-patient input.first_name').val(first_name);
		$('#modal-store-patient input.hospital_no').val('');
	}else{
		$('#modal-store-patient input.last_name').val('');
		$('#modal-store-patient input.first_name').val('');
		if (hospital_no) {
			reserveHospitalNo(id_no);
			$('#modal-store-patient input.hospital_no').val(id_no);
		}else{
			$('#modal-store-patient input.hospital_no').val('');
		}
	}
	getallclinics(triage = null);
	$('#modal-store-patient').modal('toggle');
}

function reserveHospitalNo(id_no) {
	request = $.ajax({
	    url: baseUrl+'/reserveHospitalNo',
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {'hospital_no': id_no},
	    dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {
	    // toastr.error(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('#modal-check-patient .loaderRefresh').fadeOut('fast');
	});
}


$(document).on('click', '#modal-check-result #select-active-record', function(){
	
	var id = $(this).attr('data-id');

	if (id == "#") {
		toastr.error('Kindly Select Patient Record First');
	}else{
		setTimeout(function(){ 
			$('#modal-check-result').modal('toggle');
		},500);
		edit_patient(id, enable = true);
	}

})