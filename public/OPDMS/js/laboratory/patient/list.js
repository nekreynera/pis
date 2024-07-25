
function updatepathologytable(response){
	$('#ancillary-table .ancillary-tbody').empty();
	for (var i = 0; i < response.length; i++) {
		var disabled = '';
		if (response[i].status == 'Inactive') {
			disabled = 'disabled';
		}
		var tr = $('<tr>').attr('data-id', response[i].id);
		var td1 = $('<td>').addClass('item_id').html('<input type="checkbox" name="item_id" class="item_id" value="'+response[i].id+'" '+disabled+'>');
		var td2 = $('<td>').addClass('text-capitalize item_name').text(response[i].name);
		var td3 = $('<td>').addClass('text-right item_price').text((response[i].price).toFixed(2));
		var span = '<small class="label bg-green">Active</small>';
		if (response[i].status == 'Inactive') {
			span = '<small class="label bg-red">Inactive</small>';
		}
		var td4 = $('<td>').addClass('text-center').html(span);
		$(tr).append(
						td1,
						td2,
						td3,
						td4
					);
		$('#ancillary-table .ancillary-tbody').append(tr);
	}
	if (response.length <= 0) {
		$('#ancillary-table tfoot tr.deeper_tr').css('visibility', 'visible').children('td').text('EMPTY RESULT');
	}else{
		$('#ancillary-table tfoot tr.deeper_tr').css('visibility', 'hidden')
	}
}


/*===============END OF ITEMS===================*/

$(document).on('change', '#ancillary-table .ancillary-tbody tr td input.item_id', function(){
	if (this.checked) {
		appenddatatorequesttable($(this));
		$(this).parent('td').parent('tr').addClass('selected');
	}else{
		removedatatorequesttable($(this));
		$(this).parent('td').parent('tr').removeClass('selected');
	}
	viewbuttoninfootersaveif();
	counttotalamountdiscountneamount();
});


/*=============END ITEMS CHECKBOX==============*/
