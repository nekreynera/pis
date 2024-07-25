$(document).on('click', '#patient-information', function(){
	var id = $(this).attr('data-id');
	if (id == '#') {
		toastr.error('Kindly Select Patient Record First');
	}else{
		getpatientInformation(id);
		// $('#patient_information_modal').modal('toggle');
	}
});


function getpatientInformation(id){

	$('#patient_information_modal .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/information/'+id,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {
		// console.log(response);	
		updatepatientinformationcontent(response);   
	    
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('#patient_information_modal').modal('toggle')
	    $('#patient_information_modal .loaderRefresh').fadeOut('fast');
	});
	
}
function updatepatientinformationcontent(response){
	$('#patient_information_modal .patient_full_name').text(response.last_name+', '+response.first_name+' '+response.middle_name);
	$('#patient_information_modal .hospital_no').text(response.hospital_no);
	$('#patient_information_modal .patient_qrcode').text(response.barcode);
	$('#patient_information_modal .patient_birthday').text(dateCalculate(response.birthday));
	$('#patient_information_modal .patient_age').text(calculateAge(response.birthday));
	$('#patient_information_modal .patient_address').text(response.address);
	if (response.sex == 'M') {
		$('#patient_information_modal .patient_sex').text('Male');
	}else{
		$('#patient_information_modal .patient_sex').text('Female');	
	}
	if (response.civil_status) {
		$('#patient_information_modal .patient_civil_status').text(response.civil_status);
	}
	if (response.label) {
		$('#patient_information_modal .patient_mss').text(response.label+'-'+response.description);
	}else{
		$('#patient_information_modal .patient_mss').text('N/A');
	}
	$('#patient_information_modal .patient_date_reg').text(dateCalculate(response.created_at));
}

