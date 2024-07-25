$(document).ready(function() {
    $('#servicesTable').DataTable();


    /*$('#addServicesFormTest').on('submit', function(){
    	event.preventDefault();
    	$('.loaderWrapper').fadeIn('fast');
    	var data = $(this).serialize();
    	console.log(data);

    	request = $.ajax({
    	    url: $(this).attr('action'),
    	    type: "post",
    	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    	    data: data,
    	    dataType: "json",
    	});
    	request.done(function (response, textStatus, jqXHR) {
    		$('#servicesTable').load(baseUrl+"/radiology #servicesTable");
    		toastr.success("Radiology service successfully saved");
    	});
    	request.fail(function (jqXHR, textStatus, errorThrown){
    	    console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    	    toastr.error("Data unsaved, an error occured!");
    	});
    	request.always(function(){
    		$('.loaderWrapper').fadeOut('fast');
    	});
    });


    $('#editServicesFormTest').on('submit', function(){
    	event.preventDefault();
    	$('.loaderWrapper').fadeIn('fast');
    	var data = $(this).serialize();
    	console.log(data);

    	request = $.ajax({
    	    url: baseUrl+'/editService',
    	    type: "post",
    	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    	    data: data,
    	    dataType: "json",
    	});
    	request.done(function (response, textStatus, jqXHR) {
    		$('#servicesTable').load(baseUrl+"/radiology #servicesTable");
    		toastr.success("Radiology service successfully updated");
    	});
    	request.fail(function (jqXHR, textStatus, errorThrown){
    	    console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
    	    toastr.error("Data unsaved, an error occured!");
    	});
    	request.always(function(){
    		$('.loaderWrapper').fadeOut('fast');
    	});
    });*/


});

function radiologyEdit(scope) {
	event.preventDefault();
	var id = $(scope).attr('data-id');
	var clinic_code = $(scope).closest('tr').find('td.clinic_code').text();
	var description = $(scope).closest('tr').find('td.description').text();
	var price = $(scope).closest('tr').find('td.price').find('span').text();
	var status = $(scope).closest('tr').find('td.status').find('span').text();
	$('.editID').val(id);
	if (clinic_code == 'X-RAY') {
		$('.xray').selected();
	}else{
		$('.ultrasound').selected();
	}
	$('.item_description').val(description);
	$('.editPrice').val(price);
	if (status == 'Active') {
		$('.active').selected();
	}else{
		$('.inactive').selected();
	}
}