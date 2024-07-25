$(document).on('change', 'td.item-qty input', function(){
	var qty = $(this).val();
	var price = $(this).parent('td').siblings('td.item-price').text();
	var discount = $('table#patient-table input[name="discount"]').val();
	var item_amount = Number(qty) * Number(price);
	var item_discount = item_amount * Number(discount);
	var item_net_amount = item_amount - item_discount;
	$(this).parent('td').siblings('td.item-amount').text(item_amount.toFixed(2))
	$(this).parent('td').siblings('td.item-discount').text(item_discount.toFixed(2));
	$(this).parent('td').siblings('td.item-discount').html(item_discount.toFixed(2)+'<input type="hidden" name="item_discount[]" value="'+item_discount.toFixed(2)+'">');
	$(this).parent('td').siblings('td.item-net-amount').text(item_net_amount.toFixed(2));
	overallTOTAL();

});

function overallTOTAL()
{
	var total_amount = 0;
	var total_discount = 0;
	var total_net_amount = 0;
	$('tbody.selectedItemsTbody tr').each(function(){
		total_amount+= Number($(this).children('td.item-amount').text());
		total_discount+= Number($(this).children('td.item-discount').text());
		total_net_amount+= Number($(this).children('td.item-net-amount').text());
	});
	$('tfoot.selectedItemsTfoot').children('tr').children('td').children('b.total-amount').text(total_amount.toFixed(2));
	$('tfoot.selectedItemsTfoot').children('tr').children('td').children('b.total-discount').text(total_discount.toFixed(2));
	$('tfoot.selectedItemsTfoot').children('tr').children('td').children('b.total-net-amount').text(total_net_amount.toFixed(2));
}

$(document).on('change', '.selectedItemsTbody tr input[name="selected[]"]', function(){
	input = this;
	var id  = $(this).siblings('input[name="request_id[]"]').val();
	var type  = $(this).siblings('input[name="request_type[]"]').val();
	
	if (id != '0') {
		deleteRequisition(id, type);
	}
	
	$('.selectitemsTbody tr input.select').each(function(){
		if ($(this).val() == $(input).val()) {
			$(this).prop('checked', false).closest('td').parent('tr').removeClass('bg-success');
		}
	});
	$(this).closest('td').parent('tr').remove();
	overallTOTAL();
});

$(document).on('click', '#savependingRequistionbutton', function(e){
	$('.tableSelectedItems .loaderRefresh').fadeIn('fast');
	var scope = $(this);
	e.preventDefault();
	var discount = $('table#patient-table input[name="discount"]').val();
	var mss_id = $('table#patient-table input[name="mss_id"]').val();
	var selected = [];
	var request_id = [];
	var request_type = [];
	var item_price = [];
	var qty = [];
	var item_discount = [];
	$('.selectedItemsTbody tr').each(function(){
		selected.push($(this).children('td').children('input[name="selected[]"]').val());
		request_id.push($(this).children('td').children('input[name="request_id[]"]').val());
		request_type.push($(this).children('td').children('input[name="request_type[]"]').val());
		item_price.push($(this).children('td').children('input[name="item_price[]"]').val());
		qty.push($(this).children('td').children('input[name="qty[]"]').val());
		item_discount.push($(this).children('td').children('input[name="item_discount[]"]').val());
	});

	console.log(selected+'\n'+request_id+'\n'+request_type+'\n'+qty);
	request = $.ajax({
	    url: $('form#savependingRequistion').attr('action'),
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {
	    		'selected': selected,
				'request_id': request_id,
				'request_type': request_type,
				'item_price': item_price,
				'qty': qty,
				'item_discount': item_discount,
				'discount': discount,
				'mss_id': mss_id,
				},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    appendtoselectedtbody(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    $('.tableSelectedItems .loaderRefresh').fadeOut('fast');
		toastr.success('Requisition Saved.');

	    console.log("To God Be The Glory...");
	});
});


$(document).on('click', '#selectpamentoption', function(e){
    $('#modal-payment').modal({backdrop: 'static', keyboard: false});
});

$(document).on('submit', '#paymentoption', function(e){
	e.preventDefault();
	$('.tableSelectedItems .loaderRefresh').fadeIn('fast');
	var scope = $(this);
	var mss_id = $(scope).find('select.mss_id').val();
    $('#modal-payment').modal('toggle');
	e.preventDefault();
	// var discount = $('table#patient-table input[name="discount"]').val();
	var discount = (mss_id != '')?1:0;
	// var mss_id = mss_id;
	var selected = [];
	var request_id = [];
	var request_type = [];
	var item_price = [];
	var qty = [];
	var item_discount = [];
	$('.selectedItemsTbody tr').each(function(){
		selected.push($(this).children('td').children('input[name="selected[]"]').val());
		request_id.push($(this).children('td').children('input[name="request_id[]"]').val());
		request_type.push($(this).children('td').children('input[name="request_type[]"]').val());
		item_price.push($(this).children('td').children('input[name="item_price[]"]').val());
		qty.push($(this).children('td').children('input[name="qty[]"]').val());
		item_discount.push($(this).children('td').children('input[name="item_discount[]"]').val());
	});

	console.log(selected+'\n'+request_id+'\n'+request_type+'\n'+qty);
	request = $.ajax({
	    url: $('form#savependingRequistion').attr('action'),
	    type: "post",
	    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	    data: {
	    		'selected': selected,
				'request_id': request_id,
				'request_type': request_type,
				'item_price': item_price,
				'qty': qty,
				'item_discount': item_discount,
				'discount': discount,
				'mss_id': mss_id,
				},
	    dataType: "json"
	});
	request.done(function (response, textStatus, jqXHR) {
	    appendtoselectedtbody(response);
	});
	request.fail(function (jqXHR, textStatus, errorThrown){
	    console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
	    toastr.error('Oops! something went wrong.');
	});
	request.always(function (response){
	    $('.tableSelectedItems .loaderRefresh').fadeOut('fast');
		toastr.success('Requisition Saved.');
	    console.log("To God Be The Glory...");
	});
});

function deleteRequisition(id, type){
	if (id != '0') {
		request = $.ajax({
		    url: baseUrl+'/deleteRequisition/'+id+'/'+type,
		    type: "get",
		    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		    dataType: "json"
		});
		request.done(function (response, textStatus, jqXHR) {
		    console.log(response);
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

