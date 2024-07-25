function appendpatientinfototransaction(info) {
	$('.patient-information td .patient-name').text(info.last_name+', '+info.first_name+' '+info.middle_name.charAt(0)+'. ');
	$('.patient-information td .patient-birth-date').text(dateCalculate(info.birthday));
	$('.patient-information td .patient-age').text(calculateAge(info.birthday));
	$('.patient-information td .patient-c-status').text(checkobject(info.civil_status));
	$('.patient-information td .patient-hospital-no').text((info.hospital_no)?info.hospital_no:'WALK-IN-'+info.walkin);
	$('.patient-information td .patient-address').text(checkobject(info.address)).css('font-size', '11px');
	$('.patient-information td .patient-sex').text();
	var sex = (info.sex == 'M' ? 'Male' : 'Female');
	$('.patient-information td .patient-sex').text(sex);
	$('.patient-information td .patient-qr-code').text(info.barcode);
	// $('.patient-information td .patient-mss').text(checkobject(info.label)+'-'+checkobject(info.description)).attr('data-discount', info.discount); comment due to changes 01/04/2020
	$('.patient-information td .patient-mss').text('N/A').attr('data-discount', 0); /*changes*/
	$('.patient-information td .patient-regestered').text(dateCalculate(info.regestered));
}
/*===============END OF PATIENT==============*/

function appendreuqesttotable(response, status){
    patient_request = null;
    patient_request = response;
	$('.status-button button').each(function(){
		var button = $(this);
		if ($(button).attr('status') == 'All') {
			$(button).attr('id', 'selected').siblings('button').attr('id','');
		}
	});
	$('tbody.ancillary-request-tbody').empty();
	for (var i = 0; i < response.request.length; i++) {
		if (response.request[i].user_id == authenticate) {
		var tr = $('<tr>').attr('deletable', true);
		}else{
		var tr = $('<tr>').attr('deletable', true);
		}
		var td1 = $('<td>').html('\
									<input type="checkbox" name="item_id" class="item_id" value="'+response.request[i].item_id+'">\
									<input type="hidden" name="request_id" value="'+response.request[i].request_id+'">\
								');
		var payment_created = '';
		var paid_by = 'N/A';
		var payment_status = '<span class="label bg-yellow active">Unpaid</span>';
		var lab_or_no = null;
		if (response.request[i].payment_created) {
			payment_created = timeCalculate(response.request[i].payment_created);
			payment_status = '<span class="label bg-green active">'+response.request[i].pa_status+'</span>';
			if (response.request[i].mss_discount == 1) {
				lab_or_no = response.request[i].pa_status;
			}else{
				lab_or_no = response.request[i].or_no;
				paid_by = response.request[i].paid_by;
			}
		}
		var done_created = '';
		if (response.request[i].done_created) {
			done_created = timeCalculate(response.request[i].done_created);
		}
		

		var td2 = $('<td>').addClass('text-capitalize item_name').html('<font class="td-text">'+response.request[i].name+'</font>\
			<div class="popover__content">\
				<button type="button" class="pull-right popover__fadout">&times;</button>\
                <label>Requested By: </label> <font class="text-capitalize">'+((response.request[i].request_by)? response.request[i].request_by: 'N/A')+'</font><br>\
                <label>Datetime Requested: </label> <font>'+timeCalculate(response.request[i].request_created)+'</font><br>\
                <label>Payment Status: </label> '+payment_status+' <font></font><br>\
                <label>Cashier: </label> <font>'+paid_by+'</font><br>\
                <label>O.R: </label> <font>'+checkobject(lab_or_no)+'</font><br>\
                <label>Datetime Paid: </label> <font>'+payment_created+'</font><br>\
                <label>Done By: </label> <font class="done_by">'+checkobject(response.request[i].done_by)+'</font><br>\
                <label>Datetime Done: </label> <font class="done_created">'+done_created+'</font>\
            </div>');
		var td3 = $('<td>').addClass('text-right item_price').text((response.request[i].price).toFixed(2));

		var readonly = 'readonly';
		if (response.request[i].pa_status == 'Unpaid' && response.request[i].pr_status == 'Pending') {
			readonly = '';
		}
		var td4 = $('<td>').addClass('text-center').html('<input type="number" class="text-center qty" value="'+response.request[i].qty+'" min="1" '+readonly+'>');
		var amount = response.request[i].qty * Number((response.request[i].price).toFixed(2));
		var td5 = $('<td>').addClass('text-right item_amount').text((amount).toFixed(2));

		// var discount = amount.toFixed(2) * Number(response.info.discount); comment due to changes 01/04/2020
		var discount = 0; 
		if (response.request[i].discount || response.info.discount == 1 || response.request[i].discount == 0) {
			discount = Number(response.request[i].discount);
		}else if(response.request[i].mss_addjusted_discount){
			discount = Number(response.request[i].mss_addjusted_discount);
		}

		var td6 = $('<td>').addClass('text-right item_discount').text((Number(discount)).toFixed(2));
		var net_amount = amount.toFixed(2) - Number(discount).toFixed(2);

		var td66 = $('<td>').addClass('text-right item_sponsor').text((Number(response.request[i].granted_amount)).toFixed(2));
		
		net_amount-=(Number(response.request[i].granted_amount)).toFixed(2);
		var td7 = $('<td>').addClass('text-right item_netamount').text((net_amount).toFixed(2));

		var pr_span = '<span class="label bg-yellow active">Pending</span>';

		if(response.request[i].pr_status == 'Done'){
			pr_span = '<span class="label bg-aqua active">Done</span>';
		}

		var pa_span = '<span class="label bg-yellow active">Unpaid</span>';

		if (response.request[i].pa_status != 'Unpaid') {
			pa_span = '<span class="label bg-green active">'+response.request[i].pa_status+'</span>';
		}

		var td8 = $('<td>').addClass('text-center item_pa_status').html(pa_span);
		var td9 = $('<td>').addClass('text-center item_pr_status').html(pr_span);
		$(tr).append(
						td1,
						td2,
						td3,
						td4,
						td5,
						td6,
						td66,
						td7,
						td8,
						td9
					)
		if (status == 'All') {
			$('tbody.ancillary-request-tbody').append(tr);
		}else{
			if (status == 'Paid') {
				if (response.request[i].pa_status != 'Unpaid') {
					$('tbody.ancillary-request-tbody').append(tr);
				}
			}else if (status == 'Unpaid') {
				if (response.request[i].pa_status == 'Unpaid') {
					$('tbody.ancillary-request-tbody').append(tr);
				}
			}else if (status == 'Done') {
				if (response.request[i].pr_status == 'Done') {
					$('tbody.ancillary-request-tbody').append(tr);
				}
			}else if (status == 'Pending') {
				if (response.request[i].pr_status == 'Pending') {
					$('tbody.ancillary-request-tbody').append(tr);
				}
			}
		}
	}
	counttotalamountdiscountneamount();
}
function appenddatatorequesttable(scope){
	var tr = $('<tr>').addClass('selected').attr('data-status', 'added');
	var td1 = $('<td>').html('\
								<input type="checkbox" name="item_id" class="item_id" value="'+$(scope).val()+'" checked>\
								<input type="hidden" name="request_id" value="0">\
							');
	var td2 = $('<td>').addClass('text-capitalize item_name').text($(scope).parent('td').siblings('td.item_name').text());
	var td3 = $('<td>').addClass('text-right item_price').text($(scope).parent('td').siblings('td.item_price').text());
	var td4 = $('<td>').addClass('text-center').html('<input type="number" class="text-center qty" value="1" min="1">');
	var td5 = $('<td>').addClass('text-right item_amount').text($(scope).parent('td').siblings('td.item_price').text());

	// var discount = Number($(scope).parent('td').siblings('td.item_price').text()) * Number(patient_request.info.discount); comment due to changes 01/04/2020
	var discount = 0;

	var td6 = $('<td>').addClass('text-right item_discount').text((discount).toFixed(2));
	var td66 = $('<td>').addClass('text-right item_sponsor').text('0.00');
	var net_amount = Number($(scope).parent('td').siblings('td.item_price').text()) - discount.toFixed(2);
	var td7 = $('<td>').addClass('text-right item_netamount').text((net_amount).toFixed(2));
	var td8 = $('<td>').addClass('text-center').text('');
	var td9 = $('<td>').addClass('text-center').text('');
	$(tr).append(
					td1,
					td2,
					td3,
					td4,
					td5,
					td6,
					td66,
					td7,
					td8,
					td9
				)
	$('tbody.ancillary-request-tbody').prepend(tr);
}

/*==============APPENDED DATA FROM LIST TABLE==========*/

function removedatatorequesttable(scope){
	$('tbody.ancillary-request-tbody tr').each(function(){
		if ($(this).attr('data-status') == 'added') {

			if ($(scope).val() == $(this).find('td').children('input.item_id').val()) {
				$(this).remove();
			}
		}
	});
}


/*=============END OF REQUEST TABLE===========*/

$(document).on('click', '.status-button button', function(){
	appendreuqesttotable(patient_request,status = $(this).attr('status'));
	$(this).attr('id', 'selected').siblings('button').attr('id', '');
	$('tbody.ancillary-tbody tr td.item_id input.item_id').prop('checked', false);
	$('tbody.ancillary-tbody tr').removeClass('selected');
	viewbuttoninfootersaveif();
});

/*=============END OF STATUS BUTTON===========*/

$(document).on('change', 'tbody.ancillary-request-tbody tr td input.item_id', function(){
	var scope = $(this);
	var item_id = $(scope).val();

	if ($(scope).parent('td').parent('tr').attr('data-status') == 'added') {
		$('.ancillary-tbody tr td input.item_id').each(function(){
			if (item_id == $(this).val()) {
				$(this).attr('checked', false);
				$(this).parent('td').parent('tr').removeClass('selected');
			}
		});	
		$(scope).parent('td').parent('tr').remove();
		viewbuttoninfootersaveif();
	}else{
		if (this.checked) {
			$(this).parent('td').parent('tr').addClass('selected');
		}else{
			$(this).parent('td').parent('tr').removeClass('selected');
		}
		viewbuttoninfooterif();
		/*==========END OF REMOVE TR IN REQUEST TABLE======*/
	}
});


/*=============END OF STATUS BUTTON===========*/

function viewbuttoninfootersaveif(){
	var added = 0;
	$('#ancillary-request tbody tr').each(function(){
		if ($(this).attr('data-status') == 'added') {
			added+=1;
		}
	});
	if (added > 0) {
		$('#modal-new-transaction .modal-footer button#proceed').fadeIn();
	}else{
		$('#modal-new-transaction .modal-footer button#proceed').fadeOut();
	}
}

function viewbuttoninfooterif() {
	var paid = 0;
	var done = 0;
	var remove = 0;
	var count = 0;
	$('tbody.ancillary-request-tbody tr td input.item_id').each(function(){
		if (this.checked) {
			if ($(this).parent('td').siblings('td.item_pa_status').children('span').text() != 'Unpaid'){
				if ($(this).parent('td').siblings('td.item_pr_status').children('span').text() == 'Pending') {
					paid+=1;
				}
			}
			if ($(this).parent('td').siblings('td.item_pr_status').children('span').text() == 'Done') {
				done+=1;
			}
			if ($(this).parent('td').parent('tr').attr('deletable') == "true") {
				if ($(this).parent('td').siblings('td.item_pa_status').children('span').text() == 'Unpaid' || 
					$(this).parent('td').siblings('td.item_pa_status').children('span').text() == 'D - CHARITY'){
					if($(this).parent('td').siblings('td.item_pr_status').children('span').text() == 'Pending') {
						remove+=1;
					}
				}
			}
			count+=1;
		}
	});	
	// if (paid > 0) {
	// 	$('#modal-new-transaction .modal-footer button#done').fadeIn();
	// }else{
	// 	$('#modal-new-transaction .modal-footer button#done').fadeOut();
	// }
	if (done > 0) {
		$('#modal-new-transaction .modal-footer button#undone').fadeIn();
	}else{
		$('#modal-new-transaction .modal-footer button#undone').fadeOut();
	}
	if (remove > 0) {
		$('#modal-new-transaction .modal-footer button#remove').fadeIn();
		$('#modal-new-transaction .modal-footer button#print-charge-slip').fadeIn();
	}else{
		$('#modal-new-transaction .modal-footer button#remove').fadeOut();
		$('#modal-new-transaction .modal-footer button#print-charge-slip').fadeOut();
	}
	if (count > 0) {
		$('#modal-new-transaction .modal-footer button#done').fadeIn();
		$('#modal-new-transaction .modal-footer button#print').fadeIn();
	}else{
		$('#modal-new-transaction .modal-footer button#print').fadeOut();
		$('#modal-new-transaction .modal-footer button#done').fadeOut();
	}
}

/*============END OF FOOTER BUTTON=========*/

$(document).on('change', 'tbody.ancillary-request-tbody tr td input.qty', function(){
	var scope = $(this);
	var qty = $(scope).val();
	var price = $(scope).parent('td').siblings('td.item_price').text();
	var amount = Number(qty) * Number(price).toFixed(2);
	var discount = amount * Number(patient_request.info.discount);
	var net_amount = amount - discount;
	$(this).parent('td').siblings('td.item_amount').text(amount.toFixed(2));
	$(this).parent('td').siblings('td.item_discount').text(discount.toFixed(2));
	$(this).parent('td').siblings('td.item_netamount').text(net_amount.toFixed(2));
});

/*=============END OF INPUT NUMBER SCRIPT==========*/

$(document).on('click', '#modal-new-transaction .modal-footer button#proceed', function(){
    $('#modal-opd-doctor').modal('toggle');
    getalldoctors(selected = null);
});
function getalldoctors(selected) {
	request = $.ajax({
	    url: baseUrl+'/getalldoctors/',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		// console.table(response);	
		appendatatodoctorselection(response, selected);   
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
}
function appendatatodoctorselection(response, selected) {
	$('div#modal-opd-doctor select.doctor_id').empty();
	var null_option = $('<option>').val(null).text('N/A');
	var null_option1 = $('<option>').val(672).text('WALK IN PATIENT | FROM PRIVATE');
	var null_option2 = $('<option>').val(777).text('WALK IN PATIENT | FROM PUBLIC');
	$('div#modal-opd-doctor select.doctor_id').append(null_option, null_option1, null_option2);
	for (var i = 0; i < response.length; i++) {
		var option = $('<option>').addClass('text-capitalize').val(response[i].id).text(((response[i].interns_id)? '' : 'Dr. ')+''+capitalize(response[i].last_name)+',\
		 '+capitalize(response[i].first_name)+' '+((response[i].middle_name)? capitalize(response[i].middle_name.slice(0,1))+'.' : '')+' | '+((response[i].name)?response[i].name.toUpperCase(): ''));
		$('div#modal-opd-doctor select.doctor_id').append(option);
	}
	$('div#modal-opd-doctor select.doctor_id').val(selected).trigger("change"); 

}

function capitalize(str) {
	var str = str.charAt(0).toUpperCase() + str.substr(1).toLowerCase();
	return str;
}

$(document).on('submit', 'form#pendingrequesrform', function(e){
	e.preventDefault();
	$('#modal-opd-doctor').modal('toggle');
	$('.div-ancillary-request .loaderRefresh').fadeIn('fast');
	var scope = $(this);
	var item_id = [];
	var item_qty = [];
	var item_price = [];
	var item_discount = [];
	var patient_id = patient_request.patient.id;
	// var mss_id = patient_request.info.mss_id;
	// var mss_discount = patient_request.info.discount;
	var mss_id = 0;
	var mss_discount = 0;
	$('tbody.ancillary-request-tbody tr').each(function(){
		var each = $(this);
		if ($(each).attr('data-status') == 'added') {
			item_id.push($(each).children('td').children('input.item_id').val());
			item_qty.push($(each).children('td').children('input.qty').val());
			item_price.push($(each).children('td.item_price').text());
			item_discount.push($(each).children('td.item_discount').text());
		}	
	});
	// console.log(mss_id);
	request = $.ajax({
	    url: $(scope).attr('action'),
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {
	    		'item_id': item_id,
				'item_qty': item_qty,
				'patient_id': patient_id,
				'mss_id': mss_id,
				'mss_discount': mss_discount,
				'item_price': item_price,
				'item_discount': item_discount,
				'user_id': $('div#modal-opd-doctor select.doctor_id').val(),
			},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    appendreuqesttotable(response, status = 'All')
	    $('tbody.ancillary-tbody tr').removeClass('selected');
	    $('tbody.ancillary-tbody tr td input.item_id').prop('checked', false);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    $('.div-ancillary-request .loaderRefresh').fadeOut('fast');
		toastr.success('Added requisition saved.');
		hidefooterbuttons();
	    console.log("To God Be The Glory...");
	});
});


/*============END OF SAVING ADDED REQUESITION==========*/

$(document).on('click', '#modal-new-transaction .modal-footer button#done', function(){
	var scope = $(this);
	$('.div-ancillary-request .loaderRefresh').fadeIn('fast');
	var request_id = [];
	var patient_id = patient_request.patient.id;
	var mss_id = patient_request.info.mss_id;
	var item_price = [];
	$('tbody.ancillary-request-tbody tr td input.item_id').each(function(){
		var input = this;
		if (input.checked) {
			// if ($(input).parent('td').siblings('td.item_pa_status').children('span').text() != 'Unpaid'){
				if ($(input).parent('td').siblings('td.item_pr_status').children('span').text() == 'Pending') {
						request_id.push($(input).siblings('input[name="request_id"]').val());
						item_price.push($(input).parent('td').siblings('td.item_price').text());
				}
			// }
		}		
	});

	request = $.ajax({
	    url: baseUrl+'/markedlaboratoryrequestasdone/',
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {
	    		'request_id': request_id,
	    		'patient_id': patient_id,
	    		'mss_id': mss_id,
	    		'item_price': item_price,
			},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	   appendreuqesttotable(response, status = 'All');
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
		toastr.success('Paid requisition marked as Done.');
		$('.div-ancillary-request .loaderRefresh').fadeOut('fast');
		hidefooterbuttons();
	    console.log("To God Be The Glory...");
	});
});

/*============END OF SAVING DONE REQUESITION==========*/
var undone_transaction = [];
$(document).on('click', '#modal-new-transaction .modal-footer button#undone', function(){
	undone_transaction = [];
	var scope = $(this);
	$('tbody#remove-tbody').empty();
	$('tbody.ancillary-request-tbody tr td input.item_id').each(function(){
		var input = this;
		if (input.checked) {
			if ($(input).parent('td').siblings('td.item_pr_status').children('span').text() == 'Done') {
					undone_transaction.push($(input).siblings('input[name="request_id"]').val());
					var tr = $('<tr>');
					var td1 = $('<td hidden>');
					var td2 = $('<td>').text($(input).parent('td').siblings('td.item_name').children('font.td-text').text());
					var td3 = $('<td>').text($(input).parent('td').siblings('td.item_name').find('font.done_by').text());
					var td4 = $('<td>').addClass('text-center').text($(input).parent('td').siblings('td.item_name').find('font.done_created').text());
					$(tr).append(
									td1,
									td2,
									td3,
									td4
								)
					$('tbody#remove-tbody').append(tr);
			}
		}		
	});
	$('#modal-undone-transaction').modal('toggle');
});

$(document).on('submit', '#undone-form', function(e){
	e.preventDefault();
	$('.div-ancillary-request .loaderRefresh').fadeIn('fast');
	var remark = $(this).children('textarea.remarks').val();
	var patient_id = patient_request.patient.id;
	var request_id = undone_transaction;
	request = $.ajax({
	    url: $(this).attr('action'),
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {
	    		'remark': remark,
	    		'patient_id': patient_id,
	    		'request_id': request_id,
			},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	   appendreuqesttotable(response, status = 'All');
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
		toastr.success('Done requisition moved to pending.');
		$('.div-ancillary-request .loaderRefresh').fadeOut('fast');
		hidefooterbuttons();
		$('#modal-undone-transaction').modal('toggle');
	    console.log("To God Be The Glory...");
	});
});


$(document).on('click', '#modal-new-transaction .modal-footer button#remove', function(e){
	e.preventDefault();
	var scope = $(this);
	$('.div-ancillary-request .loaderRefresh').fadeIn('fast');
	var request_id = [];
	var patient_id = patient_request.patient.id;

	$('tbody.ancillary-request-tbody tr td input.item_id').each(function(){
		var input = this;
		if (input.checked) {
			if ($(input).parent('td').parent('tr').attr('deletable') == "true") {
				if ($(input).parent('td').siblings('td.item_pa_status').children('span').text() != 'Paid' && 
					$(input).parent('td').siblings('td.item_pr_status').children('span').text() == 'Pending') {
					request_id.push($(input).siblings('input[name="request_id"]').val());
				}
			}
		}		
	});
	request = $.ajax({
	    url: baseUrl+'/markedlaboratoryrequestasremove/',
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {
	    		'request_id': request_id,
	    		'patient_id': patient_id,
			},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	   appendreuqesttotable(response, status = 'All');
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
		toastr.error('Your requisition removed.');
		$('.div-ancillary-request .loaderRefresh').fadeOut('fast');
		hidefooterbuttons();
	    console.log("To God Be The Glory...");
	});
});

/*============END OF REMOVE REQUEST FUNCTION*/

$(document).on('click', '#modal-new-transaction .modal-footer button#print-charge-slip', function(e){
	e.preventDefault();
	var scope = $(this);
	var request_id = [];
	var patient_id = patient_request.patient.id;

	$('tbody.ancillary-request-tbody tr td input.item_id').each(function(){
		var input = this;
		if (input.checked) {
			if ($(input).parent('td').parent('tr').attr('deletable') == "true") {
				if ($(input).parent('td').siblings('td.item_pa_status').children('span').text() == 'Unpaid') {
					request_id.push($(input).siblings('input[name="request_id"]').val());
				}
			}
		}		
	});
	if (request_id.length > 0) {
		$('#modal-request-form').find('iframe').attr('src', baseUrl+'/printlaboatorychargeslip/'+patient_id+'/'+request_id);
		$('#modal-request-form').modal({backdrop: 'static', keyboard: false});  
	}
	$('tbody.ancillary-request-tbody tr td input.item_id').prop('checked', false);
	hidefooterbuttons();
});

/*===========END OF PRINT CHARGE SLIP FUNCTION*/


$(document).on('click', '#modal-new-transaction .modal-footer button#print', function(e){
	e.preventDefault();
	var request_id = [];
	var patient_id = patient_request.patient.id;

	$('tbody.ancillary-request-tbody tr td input.item_id').each(function(){
		var input = this;
		if (input.checked) {
			if ($(input).parent('td').parent('tr').attr('data-status') != 'added') {
				request_id.push($(input).siblings('input[name="request_id"]').val());
			}
		}		
	});
	if (request_id.length > 0) {
		$('#modal-request-form').find('iframe').attr('src', baseUrl+'/getlaboratoryrequestfulldata/'+patient_id+'/'+request_id);
		$('#modal-request-form').modal({backdrop: 'static', keyboard: false});  
	}
	$('tbody.ancillary-request-tbody tr td input.item_id').prop('checked', false);
	hidefooterbuttons();
});

/*============END OF MOVING DONE TRANSACTION TO PENDING*/

function counttotalamountdiscountneamount() {
	var item_amount = 0;
	var item_discount = 0;
	var item_netamount = 0;
	$('.ancillary-request-tbody tr').each(function(){
		item_amount+=Number($(this).children('td.item_amount').text());
		item_discount+=Number($(this).children('td.item_discount').text());
		item_netamount+=Number($(this).children('td.item_netamount').text());
	});
	$('.ancillary-request-tfoot th.item_amount').text(item_amount.toFixed(2));
	$('.ancillary-request-tfoot th.item_discount').text(item_discount.toFixed(2));
	$('.ancillary-request-tfoot th.item_netamount').text(item_netamount.toFixed(2));
}

/*========END OF CONSOLIDATING PAYMENT===============*/

$(document).on('click', 'td.item_name font.td-text', function(event){
	var scope = $(this);
	$('.ancillary-request-tbody tr td.item_name').each(function(){
		$(this).children('.popover__content').fadeOut('fast');
	});
	$(scope).siblings('.popover__content').fadeIn('fast');
	$(scope).siblings('.popover__content').css({
        		left: event.pageX,
        		top: event.pageY - 620
    });
});
$(document).on('click', 'button.popover__fadout', function(){
	$(this).parent('.popover__content').fadeOut('fast');
});

$('#modal-new-transaction').on('shown.bs.modal', function(){
    hidefooterbuttons();
    $('input#list-search-input').val('').focus();
	$('input#sub-search-input').val('');
 });

function hidefooterbuttons() {
	$('#modal-new-transaction .modal-footer button#undone').fadeOut(); ////1
	$('#modal-new-transaction .modal-footer button#save').fadeOut(); ////1
	$('#modal-new-transaction .modal-footer button#proceed').fadeOut(); ////1
	$('#modal-new-transaction .modal-footer button#done').fadeOut(); ////1
	$('#modal-new-transaction .modal-footer button#remove').fadeOut(); ////1
	$('#modal-new-transaction .modal-footer button#print').fadeOut(); ////1
	$('#modal-new-transaction .modal-footer button#print-charge-slip').fadeOut(); ////1
}


$(document).on('click', '.add-new-doctor', function(){
    $('#modal-new-opd-doctor').modal('toggle');
    getopdclinics();
});

$("#modal-new-opd-doctor").on('shown.bs.modal', function(){
    $('#modal-new-opd-doctor input.last_name').focus();
});
function getopdclinics() {
	request = $.ajax({
	    url: baseUrl+'/getopdclinics/',
	    type: "get",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	  
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		$('#modal-new-opd-doctor select.clinic').empty();
			var null_option = $('<option>').val(null).text('N/A');
			$('#modal-new-opd-doctor select.clinic').append(null_option);
		for (var i = 0; i < response.length; i++) {
			var option = $('<option '+selected+'>').val(response[i].id).text(capitalize(response[i].name));
			$('#modal-new-opd-doctor select.clinic').append(option);
		}
    	// $('select.role').val(roles).trigger("change");

	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
}

$(document).on('submit', 'form#laboratory_new_doctor', function(e){
	$('#modal-new-opd-doctor .loaderRefresh').fadeIn('fast');
	e.preventDefault();
	request = $.ajax({
	    url: $(this).attr('action'),
	    type: "POST",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	  	data: $(this).serialize(),
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
		console.log(response);
		
		// setTimeout(function(){ 
			getalldoctors(selected = response.id);
			$('#modal-new-opd-doctor .loaderRefresh').fadeOut('fast');
			$('#modal-new-opd-doctor').modal('toggle');
			$('form#laboratory_new_doctor .form-group input, form#laboratory_new_doctor .form-group select').val('');
		// }, 3000);
		
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    console.log("To God Be The Glory...");
	});
});






