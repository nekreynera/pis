$(document).on('click', '.show-pending-request', function(){
		$('.cancel-pending').attr('id', 'cancel-request').html('<span class="fa fa-mail-reply"></span> Cancel');
		var from = $('.from').val();
		var to = $('.to').val();

	$.post(baseUrl+'/getallpendingrequesition', {
		from: from,
		to: to,
	}, 
		function(data, status){
			var request = JSON.parse(data);
			$('.pendingthead').empty();
			$('.pendingtbody').empty();
			var tr = $('<tr>');
			var th1 = '<th><input type="checkbox" name="" class="thcheck-cancel"></th>';
			var th2 = $('<th>').text('BRAND');
			var th3 = $('<th>').text('GENERIC NAME');
			var th4 = $('<th>').text('PRICE');
			var th5 = $('<th>').text('QTY');
			var th6 = $('<th>').text('PATIENT NAME');
			var th7 = $('<th>').text('REQUESTED BY');
			$(tr).append(th1,th2,th3,th4,th5,th6,th7);
			$('.pendingthead').append(tr);
			console.log(request);
			if (request.length > 0) {
				for (var i = 0; i < request.length; i++) {
				var tr = $('<tr>');
				if (request[i].role_id == 7) {
					var td1 = '<td align="center"><input type="checkbox" name="" disabled></td>';
				}else{
					var td1 = '<td align="center"><input type="checkbox" name="" class="tdcheck-cancel" value="'+request[i].id+'"></td>';
				}
				var td2 = $('<td align="center">').text(request[i].brand);
				var td3 = $('<td>').text(request[i].item_description+'('+request[i].unitofmeasure+')');
				var td4 = $('<td align="right">').text(request[i].price.toFixed(2));
				var td5 = $('<td align="center">').text(request[i].qty);
				var td6 = $('<td>').text(request[i].last_name+', '+request[i].first_name);
				if (request[i].role_id == '7') {
				var td7 = $('<td>').text('DR. '+request[i].users).css('text-transform', 'uppercase');
				}else{
				var td7 = $('<td>').text(request[i].users).css('text-transform', 'uppercase');
				}
				$(tr).append(td1, td2, td3, td4, td5, td6, td7)
				$('.pendingtbody').append(tr);
				}
			}else{
				var tr = $('<tr>');
				var td1 = $('<td>').text("EMPTY!").attr('colspan', '7').attr('align', 'center');
				$(tr).append(td1)
				$('.pendingtbody').append(tr);
			}
		}
	)
	$('#pendingmodal').modal('toggle');
})

$(document).on('click', '#cancel-request', function(){
	var i = 0
	$('.tdcheck-cancel').each(function(){
		if ($(this).is(':checked')) {
			i++;
		}
	})
	if (i > 0) {
		var conf = confirm("Cancel all checked requesition?");
		if (conf) {
			$('.tdcheck-cancel').each(function(){
				if ($(this).is(':checked')) {
					var id = $(this).val();
					$.get(baseUrl+"/deletecheckpendingrequesition/"+id, {

						},
						function (data, status){
							var request = JSON.parse(data);
							console.log(request);

						}
					)
					$(this).closest('tr').remove();
				}
			})
			toastr.warning('requesitions cancelled');
		}
	}else{
		toastr.warning('No row selected');
	}
})
/*================================================================================*/
$(document).on('click', '.show-pending-manage', function(){
		$('.cancel-pending').attr('id', 'cancel-managed').html('<span class="fa fa-mail-reply"></span> Cancel');
		var from = $('.from').val();
		var to = $('.to').val();

	$.post(baseUrl+'/getallpendingmanaged', {
		from: from,
		to: to,
	}, 
		function(data, status){
			var request = JSON.parse(data);
			console.log(request);
			$('.pendingthead').empty();
			$('.pendingtbody').empty();
			var tr = $('<tr>');
			var th1 = '<th><input type="checkbox" name="" class="thcheck-cancel"></th>';
			var th2 = $('<th>').text('BRAND');
			var th3 = $('<th>').text('GENERIC NAME');
			var th4 = $('<th>').text('PRICE');
			var th5 = $('<th>').text('QTY');
			var th6 = $('<th>').text('PATIENT NAME');
			var th7 = $('<th>').text('MANAGED BY');
			$(tr).append(th1,th2,th3,th4,th5,th6,th7);
			$('.pendingthead').append(tr);
			if (request.length > 0) {
				for (var i = 0; i < request.length; i++) {
					var tr = $('<tr>');
					var td1 = '<td align="center"><input type="checkbox" name="" class="tdcheck-cancel" value="'+request[i].id+'"></td>';
					var td2 = $('<td align="center">').text(request[i].brand);
					var td3 = $('<td>').text(request[i].item_description+'('+request[i].unitofmeasure+')');
					var td4 = $('<td align="right">').text(request[i].price.toFixed(2));
					var td5 = $('<td align="center">').text(request[i].qty);
					var td6 = $('<td>').text(request[i].last_name+', '+request[i].first_name);
					var td7 = $('<td>').text(request[i].users).css('text-transform', 'uppercase');
					$(tr).append(td1, td2, td3, td4, td5, td6, td7)
					$('.pendingtbody').append(tr);
				}
			}else{
					var tr = $('<tr>');
					var td1 = $('<td>').text("EMPTY!").attr('colspan', '7').attr('align', 'center');
					var tr2 = $('</tr>');
					$(tr).append(td1, tr2)
				$('.pendingtbody').append(tr);
			}
			
		}
	)
	$('#pendingmodal').modal('toggle');
})

$(document).on('click', '#cancel-managed', function(){
	var i = 0
	$('.tdcheck-cancel').each(function(){
		if ($(this).is(':checked')) {
			i++;
		}
	})
	if (i > 0) {
		var conf = confirm("Cancel all checked managed requesition?");
		if (conf) {
			$('.tdcheck-cancel').each(function(){
				if ($(this).is(':checked')) {
					var id = $(this).val();
					$.get(baseUrl+"/deletecheckpendingmanaged/"+id, {

						},
						function (data, status){
							var request = JSON.parse(data);
							console.log(request);

						}
					)
					$(this).closest('tr').remove();
				}
			})
			toastr.warning('managed requesitions cancelled');
		}
	}else{
		toastr.warning('No row selected');
	}
})

/*==============================================================================================*/
$(document).on('click', '.show-pending-done', function(){
	$('.cancel-pending').attr('id', 'done-undone').html('<span class="fa fa-check"></span> Done');
		var from = $('.from').val();
		var to = $('.to').val();

	$.post(baseUrl+'/getallundonetransactions', {
		from: from,
		to: to,
	}, 
		function(data, status){
			var request = JSON.parse(data);
			console.log(request);
			$('.pendingthead').empty();
			$('.pendingtbody').empty();
			var tr = $('<tr>');
			var th1 = '<th><input type="checkbox" name="" class="thcheck-cancel"></th>';
			var th2 = $('<th>').html('CLASSIFICATION <br> O.R.');
			var th3 = $('<th>').text('BRAND/GENERIC NAME(unit)');
			var th4 = $('<th>').text('QTY');
			var th5 = $('<th>').text('AMOUNT');
			var th6 = $('<th>').text('PATIENT NAME');
			$(tr).append(th1,th2,th3,th4,th5,th6);
			$('.pendingthead').append(tr);
			if (request.length > 0) {
				for (var i = 0; i < request.length; i++) {
					var tr = $('<tr>');
					var td1 = '<td align="center"><input type="checkbox" name="" class="tdcheck-cancel" value="'+request[i].id+'"></td>';
					if (request[i].mss_id >= 9 && request[i].mss_id <= 13) {
					var td2 = $('<td align="center">').text(request[i].label+'-'+request[i].description);
					}else if (request[i].mss_id <= 0){
					var td2 = $('<td align="center">').text('N/A - '+request[i].or_no);
					}else{
					var td2 = $('<td align="center">').html(request[i].label+'-'+request[i].description+'%<br>'+request[i].or_no);	
					}
					var td3 = $('<td>').text(request[i].brand+' '+request[i].item_description+'('+request[i].unitofmeasure+')');
					var td4 = $('<td align="right">').text(request[i].amount.toFixed(2));
					var td5 = $('<td align="center">').text(request[i].qty);
					var td6 = $('<td>').text(request[i].last_name+', '+request[i].first_name);
					$(tr).append(td1, td2, td3, td5, td4, td6)
					$('.pendingtbody').append(tr);
				}
			}else{
					var tr = $('<tr>');
					var td1 = $('<td>').text("EMPTY!").attr('colspan', '6').attr('align', 'center');
					$(tr).append(td1)
				$('.pendingtbody').append(tr);
			}
		}
	)
	$('#pendingmodal').modal('toggle');
})

$(document).on('click', '#done-undone', function(){
	var i = 0
		$('.tdcheck-cancel').each(function(){
			if ($(this).is(':checked')) {
				i++;
			}
		})
		if (i > 0) {
			var conf = confirm("Done all paid requesition?");
			if (conf) {
				$('.tdcheck-cancel').each(function(){
					if ($(this).is(':checked')) {
						var id = $(this).val();
						$.get(baseUrl+"/donepaidrequisition/"+id, {

							},
							function (data, status){
								var request = JSON.parse(data);
								console.log(request);

							}
						)
						$(this).closest('tr').remove();
					}
				})
				toastr.success('all paid requistion marked as done');
			}
		}else{
			toastr.warning('No row selected');
		}
})

/*=================================================================*/
$('#pendingmodal').on('hide.bs.modal', function(){
    location.reload();
    $('.loaderWrapper').show();
})

$(document).on('click', '.thcheck-cancel', function(){
	if (this.checked) {
		$('.tdcheck-cancel').each(function(){
			if (this.checked) {
			}else{
				$(this).click();
			}
		})
	}else{
		$('.tdcheck-cancel').each(function(){
			if (this.checked) {
				$(this).click();
			}
		})
	}
})
$(document).on('click', '.tdcheck-cancel', function(){
	if (this.checked) {
		$('.thcheck-cancel').attr('checked', true);
	}else{
		$('.thcheck-cancel').attr('checked', false);
	}
})