
function appendtoitemstable(response, type, data_id_type) {
	
	$(".selectitemsTbody").empty();
	for (var i = 0; i < response.length; i++) {
		var status = '<span class="text-success">Available</span>';
		var color = '';
		var disable = '';
		var checked = '';
		if (response[i].status == "inactive" || response[i].status == "Inactive") {
			status = '<span class="text-danger">Unavailable</span>';
			color = 'bg-danger';
			disable = 'disabled';
		}
		var compare = response[i].id+'-'+type;
		if ($.inArray(compare, data_id_type) > -1) {
			checked = 'checked';
			if (response[i].status == "active" || response[i].status == "Active") {
				color = 'bg-success';
			}

		}

		var tr = $('<tr class="'+color+'" data-id-type="'+response[i].id+'-'+type+'" data-type="'+type+'">');
		var td = $('<td class="text-center">').html('<input type="checkbox" name="select" class="select" value="'+response[i].id+'" '+disable+' '+checked+'>');
		var td2 = $('<td class="text-capitalize item-name">').text(response[i].name);
		var td3 = $('<td class="text-right item-price">').text((response[i].price).toFixed(2));
		var td4 = $('<td class="text-center item-status">').html(status);
		$(tr).append(td, td2, td3, td4);
		$(".selectitemsTbody").append(tr);
	}
}


function appendtoselectedtbody(response){
	var discount = $('table#patient-table input[name="discount"]').val();
	$('tbody.selectedItemsTbody').empty();
	console.log(response);
	for (var i = 0; i < response.length; i++) {
		var tr = $('<tr>').attr('data-type', response[i].item_type).attr('data-id-type', response[i].item_id+'-'+response[i].item_type);
		var td1 = $('<td>').addClass('text-center').html('<input type="checkbox" name="selected[]" value="'+response[i].item_id+'" checked>\
													<input type="hidden" name="request_id[]" value="'+response[i].request_id+'">\
													<input type="hidden" name="request_type[]" value="'+response[i].item_type+'">');

		var td2 = $('<td>').addClass('text-capitalize item-name').text(response[i].name);
		var td3 = $('<td>').addClass('text-right item-price').html((response[i].price).toFixed(2)+
																'<input type="hidden" name="item_price[]" value="'+(response[i].price).toFixed(2)+'">');
		var td4 = $('<td>').addClass('text-center item-qty').html('<input type="number" name="qty[]" value="'+response[i].qty+'" min="1">');

		var item_amount = Number(response[i].price) * Number(response[i].qty);
		var td5 = $('<td>').addClass('text-right item-amount').text(item_amount.toFixed(2));

		var item_discount = (item_amount * Number(discount));
		var item_net_amount = (item_amount - item_discount);
		var td6 = $('<td>').addClass('text-right item-discount').html(item_discount.toFixed(2)+
																'<input type="hidden" name="item_discount[]" value="'+item_discount.toFixed(2)+'">');
		var td7 = $('<td>').addClass('text-right item-net-amount').text(item_net_amount.toFixed(2));
		$(tr).append(td1, td2, td3, td4, td5, td6, td7);
		$('tbody.selectedItemsTbody').prepend(tr);
	}
	overallTOTAL();

}