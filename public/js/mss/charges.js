$(document).on('click', '#patient-charges', function(){
    $('#patient-pending-charges').modal({backdrop: 'static', keyboard: false});
    getpatientdetails($(this).attr('patient-id'));
});

var mss_patient_id = null;
var mss_sponsors = [];
var mssrequestlist = [];
var mssrequestsponsors = [];
function getpatientdetails(patient_id) {
	$('#patient-pending-charges .loaderRefresh').fadeIn('fast');
	request = $.ajax({
	    url: baseUrl+'/getpatientdetailsandcharges/'+patient_id,
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		mssrequestlist = response;
		mssrequestsponsors = response.sponsors;
		mss_sponsors = response.mss_sponsors;
		appenddatatopatientinfo(response.patient);
		appenddatatopatientrequesttable(response, status = 'all');
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	    $('#patient-pending-charges .loaderRefresh').fadeOut('fast');
	});
}
function appenddatatopatientinfo(response) {
	$('#patient-pending-charges').attr('patient-id', response.patient_id).attr('mss-id', response.mss_id).attr('mss-discount', response.discount);
	$('table#patient-table td font.patient-info').text(response.last_name+','+response.first_name+' '+response.middle_name+' (\
														'+fulldateFormat(response.birthday)+' | '+getpatientAge(response.birthday)+'\
														 | '+response.sex+' )');
	$('table#patient-table td font.patient-address').text(response.brgyDesc+' '+response.citymunDesc);
	$('table#patient-table td b.patient-hospital-no').text(response.hospital_no);
	$('table#patient-table td font.patient-classification').text(checkifnull(response.label)+'-'+checkifnull(response.description));
}

/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
/*========continue with discoount checking=======*/
function appenddatatopatientrequesttable(response, status) {
	console.table(response.request);
	var paid = 0;
	var unpaid = 0;
	// console.table(response.request);
	var request_ids = [];
	$('table#ancillary-request tbody').empty();
	for (var i = 0; i < response.request.length; i++) {
		var tr = $('<tr>').attr('request-id', response.request[i].request_id);
		if ((!response.request[i].mss_charge && response.request[i].payment_id) || response.request[i].mss_charge == 2) {
			var td = $('<td>').attr('title', 'This service is paid, adjustment of payments discount are not available').addClass('text-center bg-default').html('<input type="checkbox" \
								name="request_id[]" value="'+response.request[i].request_id+'" disabled>');
		}else{
			var td = $('<td>').addClass('text-center').html('<input type="checkbox" name="request_id[]" class="request_id" \
															value="'+response.request[i].request_id+'" \
															data-type="'+response.request[i].type+'">');
		}
		var td1 = $('<td>').addClass('text-center').text(response.request[i].category);
		var td2 = $('<td>').text(response.request[i].sub_category);
		var td3 = $('<td>').addClass('text-center').html(datetimeformat(response.request[i].daterequested));
		var td4 = $('<td>').addClass('text-right').text(response.request[i].price.toFixed(2));
		var td5 = $('<td>').addClass('text-center').text(response.request[i].qty);
		var amount = response.request[i].price * response.request[i].qty;
		var td6 = $('<td>').addClass('text-right').text(amount.toFixed(2));
		var td7 = $('<td>').addClass('text-center text-capitalize bg-success').text((response.request[i].label)?response.request[i].label+'-'+response.request[i].description:'--');
		var discount = amount * Number(response.request[i].discount);
		var remaining_amount = amount - discount;
		var td8 = $('<td>').addClass('text-right bg-success').text(remaining_amount.toFixed(2));
		var td9 = $('<td>').addClass('text-center text-capitalize bg-info').text((response.request[i].guarantor)?response.request[i].guarantor:'--');

		var granted_amount = Number(response.request[i].granted_amount);
		var td10 = $('<td>').addClass('text-right bg-info').text((granted_amount)?granted_amount.toFixed(2):'--');
		var td11 = $('<td>').addClass('text-center bg-info').html(datetimeformat(response.request[i].dategranted));
		granted_amount = 0;
		response.request.forEach(function(item) {
		    if (response.request[i].request_id == item.request_id) {
		    	granted_amount+=Number(item.granted_amount);
		    }
		});
		var payable = remaining_amount - granted_amount;
		var td12 = $('<td>').addClass('text-right bg-warning').text(payable.toFixed(2));
		var transaction_status = '<span class="label bg-unpaid">Charged<span>';
		if (response.request[i].mss_charge == 1) {
			transaction_status = '<span class="label bg-info">Discount Adjusted<span>';
		}else if(response.request[i].mss_charge == 2 || (!response.request[i].mss_charge && response.request[i].payment_id)){
			transaction_status = '<span class="label bg-success">Paid<span>';
		}	
		var td13 = $('<td>').addClass('text-center').html(transaction_status);
		var td14 = $('<td>').addClass('text-center').html(((!response.request[i].mss_charge || response.request[i].mss_charge == 2)?datetimeformat(response.request[i].datepaid):'--'));

		var tdblank = $('<td>').addClass('success').attr('colspan', 9);
		var tdlastblank = $('<td>').addClass('success').attr('colspan', 3);
		if ($.inArray(response.request[i].request_id, request_ids) == -1) {
			request_ids.push(response.request[i].request_id);
			$(tr).append(td, td1, td2, td3, td4, td5, td6, td7, td8,td9, td10, td11, td12, td13, td14);
		}else{
			$(tr).append(tdblank, td9, td10, td11, tdlastblank);
		}
		$('table#ancillary-request tbody').append(tr);
	}
	$('.request-action-button button small.request-number.unpaid').text(unpaid);
	$('.request-action-button button small.request-number.paid').text(paid);
	$('.request-action-button button small.request-number.all').text(response.request.length);
}

$(document).on('click', '.request-action-button button', function(){
	appenddatatopatientrequesttable(mssrequestlist, $(this).attr('id'));
});

$(document).on('submit', 'form#patient-pending-charges-form', function(e){
	e.preventDefault();
	$('#patient-pending-charges .loaderRefresh').fadeIn('fast');
		e.preventDefault();
		var action = $(this).attr('action');
		data = $(this).serialize();
		request = $.ajax({
		    url: action,
		    type: "post",
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    data: data + '&patient_id=' + $('#patient-pending-charges').attr('patient-id'),
		    dataType: "json"
		});
		request.done(function (response, textStatus, jqXHR) {
    		getpatientdetails($('#patient-pending-charges').attr('patient-id'));
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
		    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		    toastr.error('Oops! something went wrong.');
		});
		request.always(function (response){
		    console.log("To God Be The Glory...");
		});
});

function appenddatamss_idselect(response, charges, disabled) {
	var blank_option = '<option value="">--</option>';
	var select = $('<select name="mss_id[]" class="form-control mss_id">').attr('disabled', disabled);
	var div = $('<div>');
	$(select).append(blank_option);
	for (var s = 0; s < response.sponsors.length; s++) {
		var selected = '';
		if (charges.mss_id == response.sponsors[s].id) {
			selected = 'selected'; 
		}
		var op_disabled = '';
		if (response.sponsors[s].status == 0) {
			op_disabled = 'disabled';
		}

		var option = $('<option '+selected+' '+op_disabled+'>').val(response.sponsors[s].id).text(response.sponsors[s].label+' - '+response.sponsors[s].description);
		$(select).append(option);
	}
	$(div).append(select);
	if (disabled) {
		return $('<td>').html($(div).html());
	}else{
		return $('<td>').html('<input type="hidden" name="request_id[]" class="request_id" value="'+charges.request_id+'">\
							<input type="hidden" name="type[]" class="type" value="'+charges.type+'">\
							<input type="hidden" name="income_id[]" class="income_id" value="'+charges.income_id+'">\
							<input type="hidden" name="price[]" class="price" value="'+charges.price+'">\
							<input type="hidden" name="qty[]" class="qty" value="'+charges.qty+'">\
							'+$(div).html());
	}
}
$(document).on("click", "td.lock span.lock-transaction", function(){
	var conf  = confirm("Lock this transaction? this can't be undone");
	if (conf) {
		lockthistransaction($(this).attr('income-id'), $(this).attr('type'));
		$(this).removeClass('fa-unlock-alt').addClass('fa-lock');
		$(this).parent('td').siblings('td').find('select.mss_id').attr('disabled', true);
	}
});

function lockthistransaction(id, type) {
	request = $.ajax({
	    url: baseUrl+'/lockthistransaction/'+id+'/'+type,
	    type: 'GET',
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    toastr.info('Transaction locked');

	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
}

$(document).on('click', 'button.select-charges', function(){
	$('#patient-adjust-charges').modal({backdrop: 'static', keyboard: false});
	$('#patient-adjust-charges .loaderRefresh').fadeIn('fast');
	var checked_id = [];
	var checked_type = [];
	$('table#ancillary-request tbody tr td input.request_id').each(function(){
		if (this.checked) {
			checked_id.push($(this).val());
			checked_type.push($(this).attr('data-type'));
		}
	});
	request = $.ajax({
	    url: baseUrl+'/getallcheckcharges',
	    type: 'POST',
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {
	    		'id': checked_id,
	    		'type': checked_type,
	    	},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		appendtoancillarydiscounttable(response.requests, response.classification, response.guarantor,
			$('#patient-pending-charges').attr('mss-discount'), $('#patient-pending-charges').attr('mss-id'));
		// appendtomssclassificationselect(response.classification, $('#patient-pending-charges').attr('mss-id'));
		// appendtoguarantorselect(response.guarantor);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
})
function appendtoancillarydiscounttable(request, classification, guarantor, mss_discount, mss_id) {
	// console.table(request);
	if (mss_discount == null) {
		mss_discount = 0;
	}
	total_remain_amount = 0;
	var request_ids = [];
	$('table#ancillary-discounts tbody').empty();
	for (var i = 0; i < request.length; i++) {


		/*============================*/
		var classification_div = $('<div>');
		var select_classification = $('<select>').attr('name', 'mss_classification[]').addClass('form-control mss_classification');
		var null_uption = '<option value="'+null+'" discount="0">--</option>';
		$(select_classification).append(null_uption);
		for (var c = 0; c < classification.length; c++) {
			// if (classification[c].id == request[i].mss_id) {
			// 	var selected = 'selected';
			// }else if(classification[c].id == parseInt(mss_id) && !request[i].mss_id){
			// 	var selected = 'selected';
			// }else{
			// 	var selected = '';
			// }
			var selected = ''
			var option = $('<option '+selected+'>').val(classification[c].id)
												.attr('discount', classification[c].discount)
												.attr('title', (classification[c].discount * 100)+'% Discount')
												.text(classification[c].label+'-\
												'+((Number.isInteger(parseInt(classification[c].description))?classification[c].description+'%\
													':classification[c].description)));
			$(select_classification).append(option);
			$(classification_div).append(select_classification);
		}
		/*======MSS CLASSIFICATION=====*/
		var guarantor_div = $('<div>');
		var select_guarantor = $('<select>').addClass('guarantor form-control').attr('name', 'guarantor[]');
		$(select_guarantor).append(null_uption);
		for (var g = 0; g < guarantor.length; g++) {

			if (guarantor[g].id == request[i].guarantor_id) {
				var selected = 'selected';
			}else{
				var selected = '';
			}

			var option = $('<option '+selected+'>').val(guarantor[g].id).attr('discount', guarantor[g].discount).text(guarantor[g].label+' '+guarantor[g].description);
			$(select_guarantor).append(option);
			$(guarantor_div).append(select_guarantor);

		}


		// $(select).val(request[i].mss_id).trigger('change');
		// $(select_dev).children('select').val(request[i].mss_id).trigger('change');
		var tr = $('<tr>');
		var td1 = $('<td>').text(request[i].category);
		var td2 = $('<td>').addClass('text-capitalize').text(request[i].sub_category);
		var amount = Number(request[i].price) * Number(request[i].qty);
		// var discount = amount * Number(mss_discount);
		var discount = 0;
		var remaining_amount = amount - discount;
		if (request[i].discount) {
			remaining_amount = amount - request[i].discount;
			discount = request[i].discount;
		}
		var td3 = $('<td>').addClass('text-right amount').text(amount.toFixed(2));
		var td4 = $('<td>').addClass('text-center').html(''+$(classification_div).html()+'\
														<input type="hidden" name="request_type[]" class="request_type" value="'+request[i].type+'">\
														<input type="hidden" name="request_price[]" class="request_price" value="'+Number(request[i].price).toFixed(2)+'">\
														<input type="hidden" name="request_qty[]" class="request_qty" value="'+request[i].qty+'">\
														<input type="hidden" name="request_discount[]" class="request_discount" value="'+discount.toFixed(2)+'">\
														<input type="hidden" name="request_id_for_payment[]" class="request_id_for_payment" value="'+request[i].request_id+'">\
														<input type="hidden" name="item_id[]" class="item_id" value="'+request[i].item_id+'">');
		var td5 = $('<td>').addClass('text-right remaining_amount').text(remaining_amount.toFixed(2));
		var td6 = $('<td>').addClass('text-center td-guarantor').html($(guarantor_div).html()+
																	'<input type="hidden" name="request_id_for_guarantor[]" class="request_id_for_guarantor" value="'+request[i].request_id+'">');
		var tdb = $('<td>').html('<button type="button" class="btn btn-default btn-sm add-new-guarantor" title="Click to add another guarantor for this service"><span class="fa fa-plus"></span></button>')
		var td7 = $('<td>').html('<input type="text" name="granted_amount[]" class="form-control granted_amount text-right"\
								placeholder="0.00" value="'+((request[i].granted_amount)?request[i].granted_amount.toFixed(2):'')+'"\
								'+((request[i].granted_amount)?'':'readonly="readonly"')+'">\
								<input type="hidden" name="payment_guarantor_id[]" class="payment_guarantor_id" value="'+request[i].payment_guarantor_id+'">\
								');
		granted_amount = 0;
		request.forEach(function(item) {
		    if (request[i].request_id == item.request_id) {
		    	granted_amount+=Number(item.granted_amount);
		    }
		});
		var payable = remaining_amount - Number(granted_amount);
		var td8 = $('<td>').addClass('text-right payable').text(payable.toFixed(2));

		var tdblank = $('<td>').attr('colspan', 5).addClass('success');
		var tdr = $('<td>').html('<button type="button" class="btn btn-danger btn-sm remove-new-guarantor" data-id="'+request[i].payment_guarantor_id+'" title="Click to remove this row"><span class="fa fa-remove"></span></button>');
		var tdpayable = $('<td>').addClass('text-right payable success').text('');
		if ($.inArray(request[i].request_id, request_ids) == -1) {
			request_ids.push(request[i].request_id);
			$(tr).append(td1,td2,td3,td4,td5,td6,tdb, td7,td8);
		}else{
			$(tr).append(tdblank, td6,tdr, td7,tdpayable);
		}


		// console.log($(tr).children('td').find('select.mss_classification').html());
		$('table#ancillary-discounts tbody').append(tr)
	}
	calculate_total();
	// $('table#ancillary-discounts tfoot th.total_remaining_amount').text(total_remain_amount.toFixed(2))
	$('#patient-adjust-charges .loaderRefresh').fadeOut('fast');
}

$(document).on('click', 'button.add-new-guarantor',function(){
	// var payable = $(this).parent('td').siblings('td.payable').text();
	// console.log($(this).parent('td').parent('tr').html());
	var tr = $('<tr>').addClass('success');
	var td1 = $('<td>').attr('colspan', 5);
	var td2 = $('<td>').html($(this).parent('td').siblings('td.td-guarantor').html());
	var td3 = $('<td>').html('<button type="button" class="btn btn-danger btn-sm remove-new-guarantor" data-id="null" title="Click to remove this row"><span class="fa fa-remove"></span></button>');
	var td4 = $('<td>').html('<input type="text" name="granted_amount[]" class="form-control granted_amount text-right"\
								 placeholder="0.00" readonly="true">\
								<input type="hidden" name="payment_guarantor_id[]" class="payment_guarantor_id" value="">\
								 ');
	var td5 =$('<td>').text('');
	$(tr).append(td1,td2,td3,td4,td5);
	$($(this).parent('td').parent('tr')).after(tr);


});

$(document).on('click', 'button.remove-new-guarantor', function(){
	var scope = $(this);
	var id = $(scope).attr('data-id');
	if (id != 'null') {
		deletepaymentguarantor(id, scope);
	}else{
		$(scope).parent('td').parent('tr').remove();
	}
	var total_granted_amount = 0;
	var request_id = $(scope).parent('td').siblings('td').children('input.request_id_for_guarantor').val();
	var parent_tr = null;
	var loop = 0;
	$('input.request_id_for_guarantor').each(function(){
		if (request_id == $(this).val()) {
			loop++;
			if (loop == 1) {
				parent_tr = $(this).parent('td').parent('tr');
			}
			total_granted_amount+=Number($(this).parent('td').siblings('td').children('input.granted_amount').val());
		}
	});
	var remaining_amount = Number($(parent_tr).children('td.remaining_amount').text());
	var total_remaining_amount = remaining_amount - total_granted_amount;
	$(parent_tr).children('td.payable').text(total_remaining_amount.toFixed(2));
	calculate_total();
});

function deletepaymentguarantor(id, scope) {
	var conf = confirm("Remove this added guarantor for this payment?");
	if (conf) {
		request = $.ajax({
		    url: baseUrl+'/deletepaymentguarantor/'+id,
		    type: 'GET',
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    dataType: "json"
		});
		request.done(function (response, textStatus, jqXHR) {
			console.log(response);
			$(scope).parent('td').parent('tr').remove();
			// toast('success', 'The Patient Payment guarantor had been removed');
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
		    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		    toastr.error('Oops! something went wrong.');
		});
		request.always(function (response){
		    console.log("To God Be The Glory...");
		});
	}
}

function appendtomssclassificationselect(classification, mss_id) {
	$('select.mss_classification').empty();
	if (mss_id == null) {
		mss_id = 0;
	}
	var null_uption = '<option value="'+null+'">--</option>';
	$('select.mss_classification').append(null_uption);
	for (var i = 0; i < classification.length; i++) {
		if (classification[i].id == parseInt(mss_id)) {
				var selected = 'selected';
			}else{
				var selected = '';
			}
		var option = $('<option '+selected+'>').val(classification[i].id)
											.attr('discount', classification[i].discount)
											.attr('title', (classification[i].discount * 100)+'% Discount')
											.text(classification[i].label+'-\
											'+((Number.isInteger(parseInt(classification[i].description))?classification[i].description+'%\
												':classification[i].description)));
		$('select.mss_classification').append(option);
	}
}
function appendtoguarantorselect(guarantor) {
	$('select.guarantor').empty();
	var null_uption = '<option value="'+null+'">--</option>';
	$('select.guarantor').append(null_uption);
	for (var i = 0; i < guarantor.length; i++) {
		var option = $('<option>').val(guarantor[i].id).attr('discount', guarantor[i].discount).text(guarantor[i].label+'-'+guarantor[i].description);
		$('select.guarantor').append(option);
	}
	$('#patient-adjust-charges .loaderRefresh').fadeOut('fast');
}

$(document).on('change', 'select.mss_classification', function(){
	var scope = $(this);
	var discount = $(scope).children(":selected").attr('discount');
	var amount = $(scope).parent('td').siblings('td.amount').text();
	var discount_rate = Number(amount) * Number(discount);
	$(scope).siblings('input.request_discount').val(discount_rate.toFixed(2));
	var remaining_amount = amount - discount_rate;
	var guarantor = $(scope).parent('td').siblings('td').children('select.guarantor').children(':selected').attr('discount');
	if (!guarantor) {
		guarantor = 0;
	}
	var granted_amount = remaining_amount * Number(guarantor);
	var payable = remaining_amount - granted_amount;
	$(scope).parent('td').siblings('td.remaining_amount').text(remaining_amount.toFixed(2));
	$(scope).parent('td').siblings('td').children('input.granted_amount').val(granted_amount.toFixed(2));
	$(scope).parent('td').siblings('td.payable').text(payable.toFixed(2));
	calculate_total()
});

$(document).on('change', 'select.guarantor', function(){
	// var discount = $(this).children(":selected").attr('discount');
	// if (!discount) {
	// 	discount = 0;
	// }
	var remaining_amount = $(this).parent('td').siblings('td.remaining_amount').text();
	// var discount_rate = Number(remaining_amount) * Number(discount);
	// var payable = remaining_amount - discount_rate;
	$(this).parent('td').siblings('td').children('input.granted_amount').prop('readonly', false).focus();
	$(this).parent('td').siblings('td.payable').text(Number(remaining_amount).toFixed(2));
	calculate_total();
});

$(document).on('blur', 'input.granted_amount', function(){
	$(this).val(Number($(this).val()).toFixed(2));
})

$(document).on('keyup', 'input.granted_amount', function(){
	var scope = $(this);
	var request_id = $(scope).parent('td').siblings('td').find('input.request_id_for_guarantor').val();
	var granted_amount = 0;
	var sub_scope = null;
	var loop = 0;

	$('table#ancillary-discounts tbody tr').each(function(){
		var each_scope = $(this);
		var each_request_id = $(each_scope).children('td').find('input.request_id_for_guarantor').val();
		if (request_id == each_request_id) {
			loop++;
			if (loop == 1) {
				sub_scope = $(each_scope);
			}
			granted_amount+=Number($(each_scope).children('td').find('input.granted_amount').val());
		}
	});
	var remaining_amount = $(sub_scope).children('td.remaining_amount').text();
	var payable = Number(remaining_amount) - Number(granted_amount);
	$(sub_scope).children('td.payable').text(payable.toFixed(2));
	calculate_total()
});

function calculate_total() {
	var total_remaining_amount = 0;
	var total_granted_amount = 0;
	var total_payable_amount = 0;
	$('table#ancillary-discounts tbody tr').each(function(){
		total_remaining_amount+=Number($(this).children('td.remaining_amount').text());
		total_granted_amount+=Number($(this).children('td').children('input.granted_amount').val());
		total_payable_amount+=Number($(this).children('td.payable').text());
	});
	$('table#ancillary-discounts tfoot th.total_remaining_amount').text(total_remaining_amount.toFixed(2));
	$('table#ancillary-discounts tfoot th.total_grandted_amount').text(total_granted_amount.toFixed(2));
	$('table#ancillary-discounts tfoot th.total_payable').text(total_payable_amount.toFixed(2));
}

$(document).on('submit', '#form-patient-adjust-charges', function(e){
	e.preventDefault();
	var conf = confirm("submit this transaction???");
	if (conf) {
		$('#patient-adjust-charges .loaderRefresh').fadeIn('fast');
		var scope = $(this);
		var data = $(scope).serialize() + '&patient_id=' + $('#patient-pending-charges').attr('patient-id');
		request = $.ajax({
		    url: baseUrl+'/updatependingpaymentdiscounts',
		    type: 'POST',
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    data:  data,
		    dataType: "json"
		});
		request.done(function (response, textStatus, jqXHR) {
			console.log(response);
			// toast('success', 'The Patient Payment Adjusment Successfully Saved');
			getpatientdetails($('#patient-pending-charges').attr('patient-id'));
			$('#patient-adjust-charges .loaderRefresh').fadeOut('fast');
			$('#patient-adjust-charges').modal('toggle');
		});
		request.fail(function (jqXHR, textStatus, errorThrown){
		    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
		    toastr.error('Oops! something went wrong.');
		});
		request.always(function (response){
		    console.log("To God Be The Glory...");
		});
	}
});


function fulldateFormat($date){
    var d = new Date($date);
    var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
    var month = days[d.getMonth()];
    var day = d.getDate();
    var year = d.getFullYear();
    if (day < 10) {
        day = '0'+day;
    }
    var today = month+'/'+day+'/'+year;
    return today;
}
function checkifnull(data) {
    if (data) {
    }else{
        data = '';
    }
    return data;
}

function datetimeformat($date){
	if ($date) {

	    var d = new Date($date);
	    var days = ["01","02","03","04","05","06","07","08","09","10","11","12"];
	    var month = days[d.getMonth()];
	    var day = d.getDate();
	    var year = d.getFullYear();
	    var hour = d.getHours();
	    var min = d.getMinutes();
	    
	    if(min < 10){
	        min = '0'+min;
	    }
	    var ini = 'AM';
	    if (hour >= 12 && min >= 1) {
	        ini = 'PM';
	    }
	    hour = hour % 12;
	    hour = hour ? hour : 12; // the hour '0' should be '12'
	    if(hour < 10){
	        hour = '0'+hour;
	    }
	    var today = month+'/'+day+'/'+year+' '+hour+':'+min+' '+ini;
	    return today;
	}else{
		return '--';
	}

}