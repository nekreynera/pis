function chargeuser(scope){
	patientid = $(scope).attr('data-id');
	$.get(baseUrl+'/getpatientinfo/'+patientid, {

		},
		function (data, status){
	        var request = JSON.parse(data);
	        // console.log(request);
	        $(".Phospital").val(request.patient.hospital_no);
	        $(".Pname").val(request.patient.last_name+', '+request.patient.first_name+', '+request.patient.middle_name+'. ');
	        // if (request.patient.label) {
	        // 	$(".Pmss").val(request.patient.label+' - '+request.patient.description);
	        // }else{
	        // 	$(".Pmss").val('NOT CLASSIFIED/EXPIRED');
	        // } comment due to changes 01/04/2020
	        $(".Pmss").val('N/A');
	        $(".Pdiscount").val(request.patient.discount);
	        $(".Pmss_id").val(request.patient.mss_id);
	        $(".Ppatient_id").val(request.patient.id);
	        $("#view-charging-history").attr('data-id', request.patient.id);

	        forservices(request.services);
	        forpending(request.pending);
	        

		}
	)

    $("#chargingmodal").modal('toggle');
}
function forservices(services){
	$('.service-count').text(services.length);
	$('.services-tbody').empty();
	for (var i = 0; i < services.length; i++) {
		var tr = $('<tr>');
		var td1 =  '<td align="center"><button class="btn btn-default btn-sm" id="add-service" data-id="'+services[i].id+'"><span class="fa fa-plus"></span></button></td>';
		var td2 = $('<td class="sservice">').text(services[i].sub_category);
		var td3 = $('<td align="right" class="sprice">').text(services[i].price.toFixed(2));
		var td4 = $('<td class="rowcount info" align="center">').text("0");
		var tr2 = $('</tr>');
		$(tr).append(td1,td4, td2, td3, tr2);
		$('.services-tbody').append(tr);
	}
}
// var mss_sponsors = [9,10,11,12,13];
function forpending(pending){
	// var discount = $('.Pdiscount').val(); comment due to changes 01/04/2020
	var discount = 0;
	$('.order-tbody').empty();
	if (pending.length > 0) {
		for (var i = 0; i < pending.length; i++) {
			var tr = $('<tr>');
			if (pending[i].cashid) {
				if (pending[i].mss_discount == 1 || pending[i].price <= 0) {
					var td1 = '<td align="center"><button class="btn btn-danger minuspaidservice" id="minus-free-service" data-id="'+pending[i].cashid+'"><span class="fa fa-minus"></span></button></td>';	
				}
				else{
					var td1 = '<td align="center"><button class="btn btn-danger minuspaidservice" data-id="'+pending[i].cashid+'" disabled><span class="fa fa-minus"></span></button></td>';	
				}
			}else{
			var td1 = '<td align="center"><button class="btn btn-warning btn-sm" id="minus-requistion" data-id="'+pending[i].reqid+'"><span class="fa fa-minus"></span></button></td>';
			}
			var td2 = $('<td>').text(pending[i].sub_category);
			var td3 = $('<td align="right" class="ppprice">').text(pending[i].price.toFixed(2));
			var td4 = '<td align="center"><input type="number" class="form-control service-qty" value="'+pending[i].qty+'" disabled></td>';
			var amount = Number(pending[i].price) * (pending[i].qty);
			var td5 = $('<td align="right" class="ppamount" cash-id="'+pending[i].cashid+'">').text(amount.toFixed(2));
			var disc = Number(amount) * Number(discount)
			if (pending[i].discount) {
				disc = Number(pending[i].discount);
			}else if(pending[i].bb_discount){
				disc = Number(pending[i].bb_discount);
			}
			var td6 = $('<td align="right" class="ppdiscount" cash-id="'+pending[i].cashid+'">').text(disc.toFixed(2));
			var td11 = $('<td align="right" class="ppsponsors" cash-id="'+pending[i].cashid+'">').text(Number(pending[i].pgg_granted_amount).toFixed(2));
			disc+=Number(pending[i].pgg_granted_amount);
			if (Number(amount) > Number(disc)) {
				var net = Number(amount) - Number(disc);
			}else{
				var net = Number(disc) - Number(amount);
			}
			var td7 = $('<td align="right" class="pnetamount" cash-id="'+pending[i].cashid+'">').text(net.toFixed(2));
			if (pending[i].cashid) {
			var td8 = '<td align="center"><a href="#" id="done-request" data-id="'+pending[i].cashid+'"><span class="fa fa-check"></span> Done</a></td>';	
			}else{
			var td8 = '<td align="center"><a href="#" id="edit-request" data-id="'+pending[i].reqid+'" hidden><span class="fa fa-pencil"></span> Edit</a></td>';		
			}
			if (pending[i].cashid) {
				if (pending[i].mss_discount == 1) {
					var td9 = '<td align="center" class="info" id="rstatus">'+pending[i].mss_name+'</a></td>';
				}
				else{
					var td9 = '<td align="center" class="info" id="rstatus">PAID</a></td>';
				}
			}else{
				var td9 = '<td align="center" class="info" id="rstatus">UNPAID</a></td>';
			}
			var td10 = $('<td align="center">').text(pending[i].created_at);
			var tr2 = $('</tr>');
			$(tr).append(td1,td2,td3,td4,td5,td6,td11, td7,td10,td9,td8,tr2);
			if (pending[i].get != "Y") {
				$('.order-tbody').append(tr);
			}
		}
	}else{
		var tr = $('<tr class="order-empty">');
		var td1 = '<td align="center" colspan="9" class="info">EMPTY TRANSACTION</td>';
		$(tr).append(td1);
		$('.order-tbody').append(tr);
	}
	fortotalpayment();
	forpaidtransaction();
}


/*==============================for charging service=================================*/   
$(document).on('click', '#charge-all', function(){
	ctr = 0;
	$('td #charge-service').each(function(){
		console.log('ctr:',ctr);
		console.log('ids:',$(this).attr('data-id'));
		ctr++;
		forcharging($(this));
	});
	$(this).attr('disabled', true);
	toastr.success('requesitions charged');
})
$(document).on('click', '#charge-service', function(){
	forcharging($(this));
	// var scope = $(this);
	toastr.success('requesition charged');
});
function forcharging(scope){
	var id = $(scope).attr('data-id');
	var mss_id = $('.Pmss_id').val();
	var patient_id = $(".Ppatient_id").val();
	var qty = $(scope).closest('tr').find('td .service-qty').val();
	console.log('mss id:',mss_id);
	console.log('patient id:',patient_id);
	console.log('qty:',qty);

	$.post(baseUrl+"/insertServiceRequest/",{
		id: id,
		mss_id: mss_id,
		patient_id: patient_id,
		qty: qty,
		},
			function (data, status){
				var request = JSON.parse(data);
				console.log(request);
				if (request.cashincome == null) {
					$(scope).closest('tr').find('#rstatus').text("PENDING");
					$(scope).closest('tr').find('#minus-service').attr('class', 'btn btn-warning btn-sm').attr('id', 'minus-requistion').attr('data-id', request.requisition.id);
					$(scope).closest('tr').find('td.service-date').text(request.requisition.created_at);
					var a = '<a href="#" id="edit-request" data-id="'+request.requisition.id+'" hidden><span class="fa fa-pencil"></span> Edit</a>';
					$(scope).parent().append(a);
					$(scope).remove();
				}else{
					
					$(scope).closest('tr').find('#minus-service').attr('class', 'btn btn-danger minuspaidservice').attr('id', 'minus-free-service').attr('data-id', request.cashincome.id);
					$(scope).closest('tr').find('#rstatus').text("PAID");
					$(scope).closest('tr').find('td.service-date').text(request.cashincome.created_at);
					var a = '<a href="#" id="done-request" data-id="'+request.cashincome.id+'"><span class="fa fa-check"></span> Done</a>';
					$(scope).parent().append(a);
					$(scope).remove();
				}
				forpaidtransaction();
			}
	)
	// $('#chargingmodal').modal("hide");
	$(scope).closest('tr').find('td .service-qty').attr('disabled', true);
}

/*====================================for edit===================================*/
$(document).on('click', '#edit-all', function(){
	$(this).empty();
	$(this).html("<span class='fa fa-pencil'></span> Update").attr('id', 'update-all');
	$('td #edit-request').each(function(){
		foredit($(this));
	})
})
$(document).on('click', '#edit-request', function(){
	foredit($(this));
})
function foredit(scope){
	var reqid = $(scope).attr('data-id');
	var a = '<a href="#" id="update-request" data-id="'+reqid+'"><span class="fa fa-save"></span> Update</a>';
	$(scope).parent().append(a);
	$(scope).closest('tr').find('td .service-qty').attr('disabled', false);
	$(scope).remove();
}

$(document).on('click', '#update-all', function(){
	$(this).empty();
	$(this).html("<span class='fa fa-pencil'></span> Edit").attr('id', 'edit-all');
	$('td #update-request').each(function(){
		forupdate($(this));
	})
	toastr.success('all requesitions updated');
})

$(document).on('click', '#update-request', function(){
	forupdate($(this));
	toastr.success('requesition updated');
})

function forupdate(scope){
	var reqid = $(scope).attr('data-id');
	var reqqty = $(scope).closest('tr').find('td .service-qty').val();
	$.post(baseUrl+'/editServiceRequest/', {
			reqid: reqid,
			reqqty: reqqty,
		},
		function (data, status){
			var request = JSON.parse(data);
			console.log(request);
		}
	)
	var a = '<a href="#" id="edit-request" data-id="'+reqid+'"><span class="fa fa-pencil"></span> Edit</a>';
	$(scope).parent().append(a);
	$(scope).closest('tr').find('td .service-qty').attr('disabled', true);
	$(scope).remove();
}




/*========================================for add service==============================*/

$(document).on('click', '#add-service', function(){
	$('.order-empty').remove();
	var serviceid = $(this).attr('data-id');
	var service = $(this).closest('tr').find('.sservice').text();
	var price = $(this).closest('tr').find('.sprice').text();
	var discount = $('.Pdiscount').val();

	var tr = $('<tr class="success">');
	var td1 = '<td align="center"><button class="btn btn-default btn-sm" id="minus-service" data-id="'+serviceid+'"><span class="fa fa-minus"></span></button></td>';
	var td2 = $('<td>').text(service);
	var td3 = $('<td align="right" class="ppprice">').text(price);
	var td4 = '<td align="center"><input type="number" class="form-control service-qty" value="1"></td>';
	var td5 = $('<td align="right" class="ppamount" cash-id="null">').text(price);
	var disc = Number(price) * Number(discount)
	var td6 = $('<td align="right" class="ppdiscount" cash-id="null">').text(disc.toFixed(2));
	var net = Number(price) - Number(disc);
	var td7 = $('<td align="right" class="pnetamount" cash-id="null">').text(net.toFixed(2));
	var td77 = $('<td>').text('');
	var td8 = '<td align="center"><a href="#" id="charge-service" data-id="'+serviceid+'" hidden><span class="fa fa-money"></span> Charge</a></td>';
	var td9 = '<td align="center" class="info" id="rstatus"></a></td>';	
	var td10 = '<td align="center" class="service-date"></td>';	
	var tr2 = $('</tr>');
	$(tr).append(td1,td2,td3,td4,td5,td6,td7,td77,td10,td9,td8,tr2);
	$('.order-tbody').prepend(tr);
	fortotalpayment();
	var qty = $(this).closest('tr').find("td.rowcount").text();
	$(this).closest('tr').find("td.rowcount").text(Number(qty) + 1);
	forinablechargebutton();
	
})

/*========================================for minus service================================*/

$(document).on('click', '#minus-service', function(){
	var scope = $(this);
	var minus = $(scope).attr('data-id');

	var conf = confirm("remove this service?");
	if (conf) {
		$(scope).closest('tr').remove();
		fortotalpayment();
		$("td #add-service").each(function(){
			id = $(this).attr('data-id');
			if (minus == id) {
				var qty = $(this).closest('tr').find('td.rowcount').text();
				$(this).closest('tr').find('td.rowcount').text(Number(qty)-1);
			}
		})
		forinablechargebutton();
	}
})

/*==========================================for minus request==============================*/
$(document).on('click', '#minus-requistion', function(){
	var scope = $(this);

	var conf = confirm("remove this requistion?");
	if (conf) {
		var id = $(scope).attr('data-id');

		$.get(baseUrl+"/deleteserviceRequistion/"+id, {

			},
			function (data, status){
				var request = JSON.parse(data);
				console.log(request);
			}
		)
		$(scope).closest('tr').remove();
		toastr.warning('requesition removed');
		fortotalpayment();
		
	}
})
/*==========================================for minus-free-service================================*/
$(document).on('click','#minus-free-service', function(){
	var scope = $(this);
	var freeid = $(this).attr('data-id');
	var conf = confirm("Remove this Free Charge Service?")
	if (conf) {
		$.get(baseUrl+"/deletefreeservicerequisition/"+freeid, {

			},
			function (data, status){
				var request = JSON.parse(data);
				console.log(request);
				$(scope).closest('tr').remove();
			}
		);
		toastr.warning('Free Charge Service removed');
	}
})
/*=======================================for done/revert request=================================*/

$(document).on('click', '#done-all', function(){
	var scope = $(this);
	var conf = confirm("all requisitions finished?")
	if (conf) {
		$('td #done-request').each(function(){
			fordone($(this));
		});
		toastr.info('all requesitions mark as finished');
		$(scope).html("<span class='fa fa-recycle'></span> Revert").attr('id', 'revert-all').attr('data-original-title', 'REVERT ALL ITEMS');
	}
})

$(document).on('click', '#done-request', function(){
	var conf = confirm("requisition finished?")
	if (conf) {
		fordone($(this));
		toastr.info('requesition mark as finished');

	}
})
function fordone(scope){
	var cashid = $(scope).attr('data-id');
	var stats = "Y";
		$.post(baseUrl+'/statusServiceRequistion', {
				cashid: cashid,
				stats: stats,
			},
			function (data, status){
				var request = JSON.parse(data);
				console.log(request);
			}
		)
		$(scope).closest('tr').find('#minus-free-service').attr('disabled', true);
		var infos = $(scope).closest('tr').find('#rstatus').text();
		$(scope).closest('tr').find('#rstatus').text("FINISHED").attr('status', infos);
		var a = '<a href="#" id="revert-request" data-id="'+cashid+'"><span class="fa fa-recycle"></span> Revert</a>';
		$(scope).parent().append(a);
		$(scope).remove();
}

$(document).on('click', '#revert-all', function(){
	var scope = $(this);
	var conf = confirm("revert all requisitions?")
	if (conf) {
		$('td #revert-request').each(function(){
			forrevert($(this));
		});
		toastr.warning('all requesitions reverted');
		$(scope).html("<span class='fa fa-check'></span> Done").attr('id', 'done-all').attr('data-original-title', 'MARK ALL PAID ITEMS AS DONE').attr('title', 'MARK ALL PAID ITEMS AS DONE');
	}
})

$(document).on('click', '#revert-request', function(){
	var conf = confirm("revert requisition?")
	if (conf) {
		forrevert($(this));
		toastr.warning('requesition reverted');
	}
})

function forrevert(scope) {
	var cashid = $(scope).attr('data-id');
	var stats = "N";
		$.post(baseUrl+'/statusServiceRequistion', {
				cashid: cashid,
				stats: stats,
			},
			function (data, status){
				var request = JSON.parse(data);
				console.log(request);
			}
		)
		$(scope).closest('tr').find('#minus-free-service').attr('disabled', false);
		var infos = $(scope).closest('tr').find('#rstatus').attr('status');
		$(scope).closest('tr').find('#rstatus').text(infos);
		var a = '<a href="#" id="done-request" data-id="'+cashid+'"><span class="fa fa-check"></span> Done</a>';
		$(scope).parent().append(a);
		$(scope).remove();
}

/*==================================for pricing==================================*/
function fortotalpayment(){
	var tamount = 0;
	var tdiscount = 0;
	var tnetamount = 0;
	$('.ppamount').each(function(){
		var amount = $(this).text();
		var discount = $(this).closest('tr').find('td.ppdiscount').text();
		var netamount = $(this).closest('tr').find('td.pnetamount').text();
		var cashid = $(this).attr('cash-id');
		if (cashid == "null") {
			tamount+=Number(amount);
			tdiscount+=Number(discount);
			tnetamount+=Number(netamount);
		}
	});
	$(".tamount").val(tamount.toFixed(2));
	$(".tdiscount").val(tdiscount.toFixed(2));
	$(".tnetamount").val(tnetamount.toFixed(2));
}   

$(document).on('change', '.service-qty', function(){
	var discount = $('.Pdiscount').val();
	var qty = $(this).val();
	var price = $(this).closest('tr').find('td.ppprice').text();
	var amount = Number(qty) * Number(price);
	var desc = Number(amount) * Number(discount);
	var netamount = Number(amount) - Number(desc);
	$(this).closest('tr').find('td.ppamount').text(amount.toFixed(2));
	$(this).closest('tr').find('td.ppdiscount').text(desc.toFixed(2));
	$(this).closest('tr').find('td.pnetamount').text(netamount.toFixed(2));
	fortotalpayment();
}) 

/*==================================for charging history===============================*/  
$(document).on('click', '#view-charging-history', function(){
	var scope = $(this);
	$('#patient-history-modal').modal('toggle');
	var patient_id = $(scope).attr('data-id');
	$.get(baseUrl+"/patientservicehistory/"+patient_id, {

		},
		function (data, status){
			var request = JSON.parse(data);
			console.log(request);
			$(".history-tbody").empty();
			var total_amount = 0;
			var total_discount = 0;
			var total_netamount = 0;
			var total_sponsors = 0;
			if (request.length > 0) {
				for (var i = 0; i < request.length; i++) {
					var tr = $('<tr>');
					var td9 = $('<td align="center">').text(($.isNumeric(request[i].or_no))?request[i].or_no:'');
					var td1 = $('<td>').text(request[i].sub_category);
					var td2 = $('<td align="right">').text(request[i].price.toFixed(2));
					var td3 = $('<td>').addClass('text-center').text(request[i].qty);
					var amount = Number(request[i].price) * Number(request[i].qty)
					total_amount += amount;
					var td4 = $('<td align="right">').text(amount.toFixed(2));
					var td5 = $('<td align="right">').text(request[i].discount.toFixed(2));
					total_discount += request[i].discount
					var td11 = $('<td align="right">').text(Number(request[i].granted_amount).toFixed(2));
					total_sponsors += Number(request[i].granted_amount);
					var netamount = Number(amount) - Number(request[i].discount);
					netamount-=Number(request[i].granted_amount).toFixed(2);
					total_netamount += netamount;
					var td6 = $('<td align="right">').text(netamount.toFixed(2));
					var td7 = $('<td>').text(request[i].reqname);
					var td8 = $('<td>').addClass('text-center').text(dateCalculate(request[i].dates));
					var tr2 = $('</tr>');
					$(tr).append(td9, td1, td2, td3, td4, td5, td11, td6, td7, td8, tr2);
					$(".history-tbody").append(tr);
				}
			}else{
				var tr = $('<tr>');
				var td = $('<td colspan="8" align="center" class="info">').text("EMPTY HISTORY");
				var tr2 = $('</tr>');
				$(tr).append(td, tr2);
				$(".history-tbody").append(tr);
			}
			$(".total_amount").text(total_amount.toFixed(2))
			$(".total_discount").text(total_discount.toFixed(2))
			$(".total_netamount").text(total_netamount.toFixed(2))
			$(".total_sponsored").text(total_sponsors.toFixed(2))
		}
	)
})

/*================================for styles=========================================*/   
$(document).on('click', '.order-expand', function(){
	$('#order-table').css('max-height', '2000px');
	$(this).html("<span class='fa fa-window-minimize'></span> Restore Order View").attr("class", "order-restore");
}) 
$(document).on('click', '.order-restore', function(){
	$('#order-table').css('max-height', '200px');
	$(this).html("<span class='fa fa-window-maximize'></span> Expand Order View").attr("class", "order-expand");

})   

$(document).on('click', '.order-culomn-show', function(){
	$('#order-table td:nth-child(5)').show();
	$('#order-table td:nth-child(6)').show();
	$('#order-table td:nth-child(7)').show();
	$('#order-table th:nth-child(5)').show();
	$('#order-table th:nth-child(6)').show();
	$('#order-table th:nth-child(7)').show();
	$(this).html("<span class='fa fa-th-large'></span> Hide Some Columns").attr("class", "order-culomn-hide");
}) 
$(document).on('click', '.order-culomn-hide', function(){
	$('#order-table td:nth-child(5)').css('display', 'none');
	$('#order-table td:nth-child(6)').css('display', 'none');
	$('#order-table td:nth-child(7)').css('display', 'none');
	$('#order-table th:nth-child(5)').css('display', 'none');
	$('#order-table th:nth-child(6)').css('display', 'none');
	$('#order-table th:nth-child(7)').css('display', 'none');
	$(this).html("<span class='fa fa-table'></span> Show Some Columns").attr("class", "order-culomn-show");
}) 

function forinablechargebutton(){
	var i=0;
	$("td #minus-service").each(function(){
		i++;
		// alert($(this).attr('data-id'));
	});
	if (i > 0) {
		$('#charge-all').attr("disabled", false);
	}
	else{
		$('#charge-all').attr("disabled", true);
	}
	
	
}
function forpaidtransaction(){
	var paid = 0;
	$("td .minuspaidservice").each(function(){
		// alert($(this).attr('data-id'));
		paid++;
	})
	// alert(paid);
	if (paid > 0) {
		$("#done-all").attr('disabled', false);
	}else{
		$("#done-all").attr('disabled', true);
	}
}
$('#chargingmodal').on('hide.bs.modal', function(){
	// recoded by Archie
		// openLoader();
		let myString = $('.loadPatients').attr('charoff');
		let wStat = myString.match(/status/g);
		let status = myString.charAt(myString.length-1);
		let chargingIDs = new Array();
		let chargingQueueStatus = new Array();
		let drpIDs = new Array();
		status = wStat == 'status' ? wStat[0]+"/"+status : status;
		console.log(status);
		if(status != 'status/F' && status != 'status/P' && status != 'status/S' && status != 'status/C' && status != 'status/H'){
			// loadPatient();
			if($('.clinic-notes')[0])
			{
				$('.clinic-notes').each(function() {
					chargingIDs.push($(this).attr('id'));
					chargingQueueStatus.push($(this).attr('rel'));
				});
				// This function is seen at loadReception.js file
				loadCharging(chargingIDs,chargingQueueStatus);
			}

			$('.ul-id').each(function(){
				drpIDs.push($(this).attr('id'));
			});
			// This function is seen at loadReception.js file
			loadAllUndonePatients(drpIDs);
		}else{
			location.reload();
		}
		$('[data-toggle="tooltip"]').tooltip("hide");
		$('#charge-all').prop('disabled', false);

})

	

/*==================================for search========================================*/
$(document).on('keyup', '#searchchargeparticular', function(){
	
	var input, filter, table, tr, td, i;
	input = document.getElementById("searchchargeparticular");
	filter = input.value.toUpperCase();
	table = document.getElementById("order-table-table");
	tr = table.getElementsByTagName("tr");

	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) {
	  td = tr[i].getElementsByTagName("td")[1];
	  if (td) {
	    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	      tr[i].style.display = "";
	    } else {
	      tr[i].style.display = "none";
	    }
	  }
	}

})

$(document).on('keyup', '#searchparticular', function(){
	
	var input, filter, table, tr, td, i;
	input = document.getElementById("searchparticular");
	filter = input.value.toUpperCase();
	table = document.getElementById("services-table-table");
	tr = table.getElementsByTagName("tr");

	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) {
	  td = tr[i].getElementsByTagName("td")[2];
	  if (td) {
	    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	      tr[i].style.display = "";
	    } else {
	      tr[i].style.display = "none";
	    }
	  }
	}

})
                                                                                                                                                                                                                                                                                                                                                                        