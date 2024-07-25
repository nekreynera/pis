$("#modal-patients-list").on('shown.bs.modal', function(){
    $(this).find("input#search-print-patient").focus();
});

function getalltransactedpatiens() {
    $('#modal-patients-list').modal({backdrop: 'static', keyboard: false});   
	$('#modal-patients-list .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/getalltransactedpatiens',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		appendtransactedpatientstotable(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
		$('#modal-patients-list .loaderRefresh').fadeOut('fast');
	});
}

function updatetablecontent(ele) {
    if(event.key === 'Enter') {
    	if (ele.value.length > 0) {
        	searchtransactedpatients(ele.value);    
        	ele.value = '';  
    	}else{
    		toastr.error("Please input a keyword");
    	}
	}
	// body...
}

function searchtransactedpatients(value){
	$('#modal-patients-list .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/searchtransactedpatients',
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {'keyword': value},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		appendtransactedpatientstotable(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
		$('#modal-patients-list .loaderRefresh').fadeOut('fast');
	});
}

var print_id = [];


$(function(){
	$("#selectall").click(function () {
		$('tbody.print-tbody tr td input.transacted').prop('checked', this.checked);
		tobePrint();
	});
});

function tobePrint()
{	
	$('tbody.print-tbody tr td input.transacted').each(function(){
		var ini = $(this).val();
		if (this.checked) {
			if($.inArray(ini, print_id) == -1){
				print_id.push($(this).val());
			}
		}else{
			print_id = jQuery.grep(print_id, function(value){
				return value != ini;
			});	
		}
	});
}

$(document).on('change', 'tbody.print-tbody tr td input.transacted', function(){
	if($("input.transacted").length == $("input.transacted:checked").length) {
		$("#selectall").prop("checked", "checked");
	} else {
		$("#selectall").removeAttr("checked");
	}

	/*=====FOR MOTHER CHECKBOX=====*/

	var ini = $(this).val();

	if (this.checked) {
		if($.inArray(ini, print_id) == -1){
			print_id.push($(this).val());
		}
	} else {
		print_id = jQuery.grep(print_id, function(value){
			return value != ini;
		});	
	}
	
	tobePrint();
});

$(document).on('click', '#modal-patients-list .modal-footer button#print-selected-record', function(e){
	if (print_id.length > 0 ) {
		toggleprintmodal();
		// $('#modal-patients-list').modal('toggle');
	} else {
		toastr.error("Kindly select a record to print")
	}
});

function toggleprintmodal() {
	$('#modal-request-form').find('iframe').attr('src', baseUrl+'/printopdlrlogs/'+print_id);
	$('#modal-request-form').modal({backdrop: 'static', keyboard: false});  
}

$("#modal-patients-list").on('hidden.bs.modal', function(){
    print_id = [];
    $('tbody.print-tbody tr td input.transacted').prop('checked', false);
    $("#selectall").prop("checked", false);
});


// $(document).on('click', '#modal-new-transaction .modal-footer button#print', function(e){
// 	e.preventDefault();
// 	var request_id = [];
// 	var patient_id = patient_request.patient.id;

// 	$('tbody.ancillary-request-tbody tr td input.item_id').each(function(){
// 		var input = this;
// 		if (input.checked) {
// 			if ($(input).parent('td').parent('tr').attr('data-status') != 'added') {
// 				request_id.push($(input).siblings('input[name="request_id"]').val());
// 			}
// 		}		
// 	});
// 	if (request_id.length > 0) {
// 		$('#modal-request-form').find('iframe').attr('src', baseUrl+'/getlaboratoryrequestfulldata/'+patient_id+'/'+request_id);
// 		$('#modal-request-form').modal('toggle');
// 	}
// 	$('tbody.ancillary-request-tbody tr td input.item_id').prop('checked', false);
// 	hidefooterbuttons();
// });



