var trselected = null;

$(document).on('click', '#ancillary-table tbody tr', function(){
	var tr = $(this);
	var table_id = $(tr).closest('table').attr('id');
	var id = $(tr).attr('data-id');
	$(tr).addClass("selected").siblings().removeClass("selected");
	gotolistJs(id);
});



function clicklisttable(id) {
	trselected = id;
	gotolistJs(id);
}

function ancillarytbody(response) {
	$('.ancillary-tbody').empty();
	if (response.length > 0) {
		for (var i = 0; i < response.length; i++) {

			if (trselected == response[i].id) {
				gotolistJs(trselected);
				var tr = $('<tr>').attr('data-id', response[i].id).addClass('selected');	
			}else{
				var tr = $('<tr>').attr('data-id', response[i].id);
			}
			
			var td1 = $('<td>').html('<span class="fa fa-caret-right"></span>');
			var td2 = $('<td>').attr('hidden', true);
			var td3 = $('<td>').addClass('text-capitalize').text(response[i].name);
			var td4 = $('<td>').addClass('text-right').text(response[i].price.toFixed(2)); 
			if (response[i].status == 'Active') {
			var td5 = $('<td>').addClass('text-center').html('<small class="label bg-green">Active</small>');
			}else{
			var td5 = $('<td>').addClass('text-center').html('<small class="label bg-red">Inactive</small>');
			}
			var td6 = $('<td>').addClass('text-center').html(dateCalculate(response[i].created_at));
			$(tr).append(td1,td2,td3,td4,td5,td6);
			$('.ancillary-tbody').append(tr);
		}
	}else{
		var tr = $('<tr>');
		var td = $('<td hidden>');
		var td1 = $('<td>').attr('colspan', '5').attr('align', 'center').html('<span class="fa fa-warning"></span> Empty Data').css('font-weight', 'bold');
		$(tr).append(td, td1);
		$('.ancillary-tbody').append(tr);
	}
}
function informationtable(response) {
	$('#list-information-table tbody td.pathology').text(response.cat_name);
	$('#list-information-table tbody td.group').text(response.sub_name);
	$('#list-information-table tbody td.service').html('<strong class="text-capitalize"> '+response.name+' </strong>');
	$('#list-information-table tbody td.price').html('<font> ₱'+response.price.toFixed(2)+'</font>');
	if (response.status == 'Active') {
	$('#list-information-table tbody td.status').html('<small class="label bg-green"> '+response.status+' </small>');
	}else{
	$('#list-information-table tbody td.status').html('<small class="label bg-red"> '+response.status+' </small>');
	}
	$('#list-information-table tbody td.created').text(timeCalculateformat(response.created_at));
	$('#list-information-table tbody td.updated').text(timeCalculateformat(response.updated_at));
	$('#modal-info-list .loaderRefresh').fadeOut('fast');
}

