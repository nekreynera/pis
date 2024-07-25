
$(document).on('change','.selectitemsTbody tr input.select', function(){
	var input = this;
	var discount = $('table#patient-table input[name="discount"]').val();
	if (input.checked) {
		$(this).closest('td').parent('tr').addClass('bg-success');
		var tr = $('<tr>').attr('data-id-type', $(input).parent('td').parent('tr').attr('data-id-type')).attr('data-type', $(input).parent('td').parent('tr').attr('data-type'));
		var td = $('<td class="text-center">').html('<input type="checkbox" name="selected[]" value="'+$(input).val()+'" class="'+$(input).val()+'" checked>\
													<input type="hidden" name="request_id[]" value="0">\
													<input type="hidden" name="request_type[]" value="'+$(input).parent('td').parent('tr').attr('data-type')+'">');
		var td2 = $('<td class="text-capitalize item-name">').text($(input).closest('td').siblings('td.item-name').text());
		var td3 = $('<td class="text-right item-price">').html($(input).closest('td').siblings('td.item-price').text()+
																'<input type="hidden" name="item_price[]" value="'+$(input).closest('td').siblings('td.item-price').text()+'">');
		var td4 = $('<td class="text-center item-qty">').html('<input type="number" name="qty[]" value="1" min="1" readonly>');
		var td5 = $('<td class="text-right item-amount">').text($(input).closest('td').siblings('td.item-price').text());
		var item_discount = (Number($(input).closest('td').siblings('td.item-price').text()) * discount);
		var item_net_amount = (Number($(input).closest('td').siblings('td.item-price').text()) - item_discount);
		var td6 = $('<td>').addClass('text-right item-discount').html(item_discount.toFixed(2)+
																'<input type="hidden" name="item_discount[]" value="'+item_discount.toFixed(2)+'">');
		var td7 = $('<td>').addClass('text-right item-net-amount').text(item_net_amount.toFixed(2));
		$(tr).append(td, td2, td3, td4, td5, td6, td7);
		$('tr.noSelectedTRwrapper').remove();
		$('.selectedItemsTbody').prepend(tr);
	}else{
		$(this).closest('td').parent('tr').removeClass('bg-success');
		$('.selectedItemsTbody tr').each(function(){
			if ($(this).attr('data-id-type') == $(input).closest('td').parent('tr').attr('data-id-type') &&
				$(this).children('td').children('input[name="selected[]"]').val() == $(input).val()) {
				var request_id = $(this).children('td').children('input[name="request_id[]"]').val();
				var request_type = $(this).children('td').children('input[name="request_type[]"]').val();
				if (request_id != '0') {
					deleteRequisition(request_id, request_type);
				}
				$(this).remove();
			}
		});
	}
	overallTOTAL();

});

function checkselecteditems() {
	$('.selectedItemsTbody tr').each(function(){
		var tr = $(this);
		data_id_type.push($(tr).attr('data-id-type'));
	});
}
