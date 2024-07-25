function getLaboratorySublist(id){
	request = $.ajax({
	    url: baseUrl+'/laboratorylist/'+id,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		$('.box-footer em.text-muted').html('Showing <b> '+response.length+' </b> result(s).')
		ancillarytbody(response);
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


$(document).on('change', 'form.ancillary-form select.laboratory_id', function(){
	getLaboratorySub($(this).val());
});



$(document).on('submit', '#new-list-form', function(e){
	e.preventDefault();
	$('#modal-new-list .loaderRefresh').fadeIn('fast');
	var data = $(this).serialize();
	var action = $(this).attr('action');
	request = $.ajax({
	    url: action,
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: data,
	    dataType: "json"
	});

	request.done(function (response, textStatus, jqXHR) {
		console.log(response);
	    if (response.errors) {
	    	if (response.errors.name) {
	    		toastr.error(response.errors.name);
	    	}
	    	if (response.errors.price) {
	    		toastr.error(response.errors.price);
	    	}
	    }else{
	    	$('form.ancillary-form input.name').val('');
	    	$('form.ancillary-form input.price').val('');
	    	clicksubcategory(response.laboratory_sub_id);
		    toastr.success('The new Laboratory Service successfully saved!');
	    	$('#modal-new-list').modal("toggle");
	    	clicklisttable(response.id);
	    	
	    }
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
		$('#modal-new-list .loaderRefresh').fadeOut('fast');
	    console.log("To God Be The Glory...");
	});
});


function EditLIst(id){
	$('#modal-edit-list').modal("toggle");
	$('#modal-edit-list .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/laboratorylist/'+id+'/edit',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    getLaboratory(response.lab_id);
	    getLaboratorySub(response.lab_id, response.sub_id);
	    $('form#edit-list-form').attr('action', baseUrl+'/laboratorylist/'+id);
	    $('form#edit-list-form input.name').val(response.name);
	    $('form#edit-list-form input.price').val(response.price.toFixed(2));
	    $('form#edit-list-form select.status').val(response.status);
	    $('form#edit-list-form span#select2-status-container').attr('title', response.status).text(response.status);
		$('#modal-edit-list .loaderRefresh').fadeOut('fast');

	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
}

$(document).on('submit', 'form#edit-list-form', function(e){
	e.preventDefault();
	var scope = $(this);
	$('#modal-edit-list .loaderRefresh').fadeIn('fast');
	var data = $(scope).serialize();
	request = $.ajax({
	    url: $(scope).attr('action'),
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: data,
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    if (response.errors) {
	        if (response.errors.name) {
	            toastr.error(response.errors.name);
	        }
	    }else{
	    	console.log(response);
	    	$('form.ancillary-form input.name').val('');
	    	$('form.ancillary-form input.price').val('');
	    	clicksubcategory(response.laboratory_sub_id);
	    	clicklisttable(response.id);
		    toastr.success('The Laboratory Service successfully Updated!');
	    	$('#modal-edit-list').modal("toggle");
	    }
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('#modal-edit-list .loaderRefresh').fadeOut('fast');
	});
});

/*=======END FOR UPDATE SERVICE CODE=====*/

function infolist(id) {
	$('#modal-info-list').modal('toggle');
	$('#modal-info-list .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/laboratorylist/'+id+'/edit',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		// console.log(response);
		informationtable(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
}