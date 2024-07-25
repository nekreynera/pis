$(document).on('click', 'button.btn-edit-sponsor', function(){
	getmsssponsorsdatabyid($(this).attr('data-id'));
	$('#modal-edit-mss-classification').modal('toggle');
});

$(document).on('click', 'button.btn-new-sponsor', function(){
	$('#modal-store-mss-classification').modal('toggle');
});
$('#modal-store-mss-classification, #modal-edit-mss-classification').on('shown.bs.modal', function(){
	$('input.labels').focus();
});

function getmsssponsorsdatabyid(sponsor_id) {
	request = $.ajax({
	    url: baseUrl+'/sponsors/'+sponsor_id+'/edit',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    appenddatatoform(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
}

function appenddatatoform(response) {
	$('form#edit-sponsors .form-group input, form#edit-sponsors .form-group select').val('');
	$('form#edit-sponsors').attr('action', baseUrl+'/sponsors/'+response.id);
	$('form#edit-sponsors input.labels').val(response.label);
	$('form#edit-sponsors input.description').val(response.description);
	$('form#edit-sponsors input.discount').val(response.discount);
	$('form#edit-sponsors select.type').val(response.type).trigger('change');
	$('form#edit-sponsors select.status').val(response.status).trigger('change');
}

$(document).on('submit', 'form#edit-sponsors, form#store-sponsors', function(e){
	$('#modal-edit-mss-classification .loaderRefresh, #modal-store-mss-classification .loaderRefresh').fadeIn('fast');
});


function documentReady() {
  var selectedItem = $('select.type :selected');
  $('select.type').css({'background-color': selectedItem.css('background-color'), 'color': '#fff'});
  var selectedItems = $('select.status :selected');
  $('select.status').css({'background-color': selectedItems.css('background-color'), 'color': '#fff'});
  
  $('select.type, select.status').change(function() {
    var selectedItem = $(this).find("option:selected");
    $(this).css({'background-color': selectedItem.css('background-color'), 'color': '#fff'});
  });
}
                   
$(document).ready(documentReady);


$(document).on('submit', '#form-monitoring-mss-guarantor', function(e){
	e.preventDefault();
	$('#modal-monitoring-mss-guarantor .loaderRefresh').fadeIn('fast');
	var scope = $(this);
	var data = $(scope).serialize();
	var url = baseUrl+'/guarantormonitoring/';
	request = $.ajax({
	    url: url,
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: data,
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		appendtodetailedtable(response.data);
		appenddatatosummarytable(response.sponsors);
		$('#modal-monitoring-mss-guarantor .loaderRefresh').fadeOut('fast');
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
});

function appenddatatosummarytable(sponsors) {
	var total_amount = 0;
	var patients = [];
	for (var i = 0; i < sponsors.length; i++) {
		total_amount+=Number(sponsors[i].total_amount);
		if ($.inArray(sponsors[i].patient_id, patients) == -1) {
			patients.push(sponsors[i].patient_id);
		}
	}
	if (sponsors.length > 0) {
		$('table#guarantor-summary td.guarantor').text(sponsors[0].label+'-'+(($.isNumeric(sponsors[0].description))?sponsors[0].description+'%':sponsors[0].description));
	}else{
		$('table#guarantor-summary td.guarantor').text('N/A');
	}
		$('table#guarantor-summary td.pateint_total').text(patients.length);
		$('table#guarantor-summary td.amount_total').text(total_amount.toFixed(2));
}

function appendtodetailedtable(data) {
	$('table#guarantor-detailed tbody').empty();
	if (data.length > 0) {
		for (var i = 0; i < data.length; i++) {
			var tr = $('<tr>');
			var td1 = $('<td>').text(data[i].last_name+', '+data[i].first_name+' '+data[i].middle_name.split(0,1));
			var td2 = $('<td>').addClass('text-capitalize').text(data[i].clinic_ancillary);
			var td3 = $('<td>').text(data[i].services);
			var td4 = $('<td>').addClass('text-right').text(Number(data[i].total_amount).toFixed(2));
			$(tr).append(td1,td2,td3,td4);
			$('table#guarantor-detailed tbody').append(tr);
		}
	}else{
		var tr = $('<tr>').attr('class', 'bg-danger');
			var td1 = $('<td>').attr('class', 'text-center').attr('colspan', 4).text('Empty data!');
			$(tr).append(td1);
			$('table#guarantor-detailed tbody').append(tr);
	}
	
}

function searchsponsors(scope) {
	var filter, table, tr, td1, td2, i, txtValue1,txtValue2;
	  	filter = $(scope).val().toUpperCase();
	  	// console.log(filter);
	  	table = document.getElementById("sponsorsTable");
	  	tr = table.getElementsByTagName("tr");
	  	for (i = 0; i < tr.length; i++) {
	    	td1 = tr[i].getElementsByTagName("td")[0];
	    	td2 = tr[i].getElementsByTagName("td")[1];
	    	if (td1 || td2) {
	      		txtValue1 = td1.textContent || td1.innerText;
	      		txtValue2 = td2.textContent || td2.innerText;
	      		if (txtValue1.toUpperCase().indexOf(filter) > -1 ||
	      			txtValue2.toUpperCase().indexOf(filter) > -1) {
	        		tr[i].style.display = "";
	      		} else {
	        		tr[i].style.display = "none";
	      		}
	   		}       
		}
	// body...
}
$(document).on('click', '.btn-view-monitoring', function(){
	var scope = $(this);
	var id = $(scope).attr('data-id');
	$('#modal-monitoring-mss-guarantor').find('select.mss_id').val(id).trigger('change');
    $('#modal-monitoring-mss-guarantor').modal('toggle');

});