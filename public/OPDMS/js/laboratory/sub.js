$(document).on('click', '.ancillary-sidebar-special li', function(){
    if ($(this).attr('class') != 'header text-uppercase') {
        $('.content-container .loaderRefresh').fadeIn('fast');
        $(this).addClass('active').siblings().removeClass('active');
        var id = $(this).attr('data-id');
        gotosubactionJs(id);
        getLaboratorySublist(id);
    }
});


function clicksubcategory(id) {
	$('.ancillary-sidebar-special li').each(function(){
		if ($(this).attr('class') != 'header text-uppercase') {
			if ($(this).attr('data-id') == id) {
				$(this).click();
			}
		}
	});
}

/*===================END OF LI TAG JS======================*/

$(document).on('submit', '#new-sub-form', function(e){
	e.preventDefault();
	$('#modal-new-sub .loaderRefresh').fadeIn('fast');
		var action = $(this).attr('action');
		var data = $(this).serialize();
		request = $.ajax({
		    url: action,
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
		    	$('#new-sub-form .name').val('');
		    	updatepathologynavigation(response);
		    	toastr.success('The new pathology successfully saved!');
		    	$('#modal-new-sub').modal('toggle');
		    }
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
		    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		    toastr.error('Oops! something went wrong.');
		});
		request.always(function (response){
		    console.log("To God Be The Glory...");
		    $('#modal-new-sub .loaderRefresh').fadeOut('fast');
		});
	
});

/*===============END FOR NEW PATHOLOGY JS=================*/

function EditPathology(id){
	request = $.ajax({
	    url: baseUrl+'/laboratorysub/'+id+'/edit',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    console.log(response);
	    $('#edit-sub-form').attr('action', baseUrl+'/laboratorysub/'+id);
	    getLaboratory(response.laboratory_id);
	    // $('#modal-edit-sub #select2-laboratory_id-container').text(response.name).attr('title', response.name);
	    $("#modal-edit-sub select.laboratory_id").val(response.laboratory_id);
        $("#modal-edit-sub input.name").val(response.name);

	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
		$('#modal-edit-sub').modal('toggle');
	    console.log("To God Be The Glory...");
	});
}

$(document).on('submit', '#edit-sub-form', function(e){
	e.preventDefault();
	$('#modal-edit-sub .loaderRefresh').fadeIn('fast');
	var data = $(this).serialize();
	request = $.ajax({
	    url: $(this).attr('action'),
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
	    	updatepathologynavigation(response)
	        $('#modal-edit-sub').modal('toggle');
	        toastr.success('The Pathology Entry Successfully Updated');
	    }
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('#modal-edit-sub .loaderRefresh').fadeOut('fast');
	});
});

/*=================END OF EDIT SUB====================*/


function updatepathologynavigation(response){
	$('.ancillary-sidebar-special').empty();
	for (var i = 0; i < response.laboratory.length; i++) {
		var li_header = $('<li>').addClass('header text-uppercase').attr('data-id', response.laboratory[i].id).text(response.laboratory[i].name);
		$('.ancillary-sidebar-special').append(li_header);
		for (var s = 0; s < response.sub.length; s++) {
			if (response.laboratory[i].id == response.sub[s].laboratory_id) {
				var li_tag = $('<li>').addClass('text-capitalize').attr('data-id', response.sub[s].id).html('<a href="#"><span>'+response.sub[s].name+'</span></a>');
				$('.ancillary-sidebar-special').append(li_tag);
			}
		}
	}
}

/*===============END OF UPDATING NAVIGATION==============*/


function getLaboratorySub(id, selected) {
	request = $.ajax({
	    url: baseUrl+'/laboratorysub/'+id,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		$('select.laboratory_sub_id').empty();
		for (var i = 0; i < response.length; i++) {
			var select = '';
			if (response[i].id == selected) {
				select = "selected";
			}
			var option = $('<option '+select+'>').val(response[i].id).text(response[i].name);
			$('form.ancillary-form select.laboratory_sub_id').append(option);
		}
		// ancillarytbody(response);
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

/*=====END OF PUTTING OPTION TO SELECT IN ANCILLARY FORM=====*/
