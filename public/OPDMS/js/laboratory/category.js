function getLaboratory(id) {
	request = $.ajax({
	    url: baseUrl+'/getLaboratory/',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		// console.log(response);
	    $('select#laboratory_id').empty();
	    for (var i = 0; i < response.length; i++) {
	    	var selected = "";
	    	if (response[i].id == id) {
	    		selected = "selected";
	    	}
	    	var option = $('<option '+ selected +'>').val(response[i].id).text((response[i].name).toUpperCase());
	    	$('select#laboratory_id').append(option);
	    }

	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
}