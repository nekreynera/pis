
$('#searchbrand').keyup(function(){
    var name, filter, table, tr, td, i;
    name = document.getElementById("searchbrand");
    filter = name.value.toUpperCase();
    table = document.getElementById("itemsDeptTable");
    tr = table.getElementsByTagName("tr");
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

$('#searchdescription').keyup(function(){
    var name, filter, table, tr, td, i;
    name = document.getElementById("searchdescription");
    filter = name.value.toUpperCase();
    table = document.getElementById("itemsDeptTable");
    tr = table.getElementsByTagName("tr");
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
var mss = $('.selectedItemsTbody').attr('id');
$(document).on('change', '.check-item', function(){

    var id = $(this).attr('data-id');
    var brand = $(this).closest('tr').find('.item_brand').text();
    var description = $(this).closest('tr').find('.item_description').text();
    var unit = $(this).closest('tr').find('.unitofmeasure').text();
    var price = $(this).closest('tr').find('.price').text();
    $('.noSelectedTRwrapper').hide();
    
    var discount = Number(price) * Number(mss);
    var netamount = Number(price) - Number(discount);

    var tr = $('<tr>');
    var td1 = '<td><input type="checkbox" name="item_id[]" value='+id+' data-id='+id+' class="uncheck-item" style="margin-top: 0px;" checked/></td>';
    var td2 = $('<td>').text(brand);
    var td3 = $('<td>').text(description);
    var td4 = $('<td>').text(unit).css('text-align', 'center');
    var td5 = $('<td class="selprice">').text(price).css('text-align', 'right');
    var td6 = '<td><input type="number" class="form-control qtyreq" name="qtyreq[]" value="1"/><input type="hidden" class="form-control pricereq" name="pricereq[]" value='+price+'/></td>';
    var td7 = '<td><input type="number" class="form-control qtyman" name="qtyman[]" value="1"/></td>';
    var td8 = $('<td class="selamount">').text(price).css('text-align', 'right');
    var td9 = $('<td class="seldiscount">').text(discount.toFixed(2)).css('text-align', 'right');
    var td10 = $('<td class="selnetamount">').text(netamount.toFixed(2)).css('text-align', 'right');
    var tr2 = $('</tr>');
    $(tr).append(td1, td2, td3, td4, td5, td6, td7, td8, td9, td10);

    if (this.checked) {
        $('.selectedItemsTbody').append(tr);    
         
    }else{

        $('.uncheck-item').each(function(){
            var select = $(this).attr('data-id');
            if (id == select) {
                $(this).closest('tr').remove();
            }
        })
    }
    fortotal();
})
$(document).on('click', '.uncheck-item', function(){
    var select = $(this).attr('data-id');
    $('td .check-item').each(function(){
        var id = $(this).attr('data-id');
        if (select == id) {
            $(this).attr('checked', false);
        }
    })
    $(this).closest('tr').remove();
    fortotal();
})

$(document).on('change', '.qtyman', function(){
    var qty = $(this).val();
    var price = $(this).closest('tr').find('.selprice').text();
    var amount = Number(qty) * Number(price);
    $(this).closest('tr').find('.selamount').text(amount.toFixed(2));
    var discount = Number(amount) * Number(mss);
    $(this).closest('tr').find('.seldiscount').text(discount.toFixed(2));
    var netamount = Number(amount) - Number(discount);
    $(this).closest('tr').find('.selnetamount').text(netamount.toFixed(2));
    fortotal();

})
function fortotal(){
    var netamount = 0;
    $('.selamount').each(function(){
        var am = $(this).closest('tr').find('.selnetamount').text();
        netamount += Number(am); 
    });
    $('#grndTotal').text(netamount.toFixed(2)).css('text-align', 'right');
}
$('#saverequisition').click(function(){
	var conf = confirm('proceed for this transaction?');
	if (conf) {
		$('#requisitionpharform').submit();
	}
	
})


$(document).on('click','#viewpendingrequisition', function(){
	var orno = $(this).attr('orno');
    var status = $(this).attr('status');
    var patient_id = $('.patient_id').val();
    $('.status').text(status);
    $('#managerequistion').show();
    $('#editmanagerequistion').hide();
    $('#removemanagerequistion').hide();
    $('#editpaidrequistion').hide();
    $('#markasissuedrequistion').hide();
	$.post(baseUrl+"/viewpendingrequisition", {
   		orno: orno,
    },
    	function (data, status){
    		var request = JSON.parse(data);
            	console.log(request);
                $('.tbodypendingmeds').empty();
                $('#managerequistion').attr('href', 'managerequistion/'+request[0].modifier+'/'+patient_id);
                for (var i = 0; i < request.length; i++) {
                    var tr = $('<tr>');
                    var td1 = $('<td>').text(request[i].brand);
                    var td2 = $('<td>').text(request[i].item_description);
                    var td3 = $('<td align="right">').text(request[i].price.toFixed(2));
                    var td4 = $('<td class="warning">').text(request[i].mgmt+' out of '+request[i].qty).css('text-align', 'center').css('font-weight', 'bold');
                    var tr2 = $('</tr>');
                    $(tr).append(td1, td2, td3, td4, tr2);
                    $('.tbodypendingmeds').append(tr);
                }

            }
	);
    $('#pendingusermedtransaction-modal').modal('toggle');
});

$(document).on('click', '#viewmanagedrequisition', function(){
    var orno = $(this).attr('orno');
    var status = $(this).attr('status');
    var patient_id = $('.patient_id').val();
    $('#managerequistion').hide();
    $('#editpaidrequistion').hide();
    $('#markasissuedrequistion').hide();
    $('#editmanagerequistion').show();
    $('#removemanagerequistion').show();
    $('.status').text(status);
    $.post(baseUrl+"/viewmanagedrequisition", {
        orno: orno,
    },
        function (data, status){
            var request = JSON.parse(data);
                console.log(request);
                $('.tbodypendingmeds').empty();
                $('#editmanagerequistion').attr('href', 'editmanagerequistion/'+request[0].reqmod+'/'+patient_id+'/'+request[0].mgmtmod);
                $('#removemanagerequistion').attr('orno', request[0].mgmtmod);
                for (var i = 0; i < request.length; i++) {
                    var tr = $('<tr>');
                    var td1 = $('<td>').text(request[i].brand);
                    var td2 = $('<td>').text(request[i].item_description);
                    var td3 = $('<td align="right">').text(request[i].price.toFixed(2));
                    var td4 = $('<td class="warning">').text(request[i].qty).css('text-align', 'center').css('font-weight', 'bold');
                    var tr2 = $('</tr>');
                    $(tr).append(td1, td2, td3, td4, tr2);
                    $('.tbodypendingmeds').append(tr);
                }
            }
    );
    $('#pendingusermedtransaction-modal').modal('toggle');

})
$(document).on('click', '#viewpaidrequisition', function(){
    var orno = $(this).attr('orno');
    var status = $(this).attr('status');
    var patient_id = $('.patient_id').val();
    $('#managerequistion').hide();
    $('#editmanagerequistion').hide();
    $('#removemanagerequistion').hide();
    $('#editpaidrequistion').show();
    $('#markasissuedrequistion').show();
    $('.status').text(status);

    $.post(baseUrl+"/viewpaidrequisition", {
        orno: orno,
    },
        function (data, status){
            var request = JSON.parse(data);
                console.log(request);
                $('.tbodypendingmeds').empty();
                // $('#editmanagerequistion').attr('href', 'editmanagerequistion/'+request[0].reqmod+'/'+patient_id+'/'+request[0].mgmtmod);
                // $('#removemanagerequistion').attr('orno', request[0].mgmtmod);
                if (request[0].mss_id <= 8 && request[0].mss_id >= 0 || request[0].mss_id <= 14 && request[0].mss_id >= 15) {
                    $('#editpaidrequistion').attr('data-toggle', 'tooltip');
                    $('#editpaidrequistion').attr('data-placement', 'top');
                    $('#editpaidrequistion').attr('title', 'paid in cashier');
                    $('#editpaidrequistion').attr('disabled', true);
                }else{
                    $('#editpaidrequistion').attr('disabled', false);
                    $('#editpaidrequistion').attr('target', '_blank');
                    $('#editpaidrequistion').attr('href', 'editpaidrequistion/'+request[0].modifier+'/'+request[0].mss_id+'/'+request[0].patients_id);
                }
                for (var i = 0; i < request.length; i++) {
                    var tr = $('<tr>');
                    var td1 = $('<td>').text(request[i].brand);
                    var td2 = $('<td>').text(request[i].item_description);
                    var td3 = $('<td align="right">').text(request[i].price.toFixed(2));
                    var td4 = $('<td class="warning">').text(request[i].qty).css('text-align', 'center').css('font-weight', 'bold');
                    var tr2 = $('</tr>');
                    $(tr).append(td1, td2, td3, td4, tr2);
                    $('.tbodypendingmeds').append(tr);
                }
            }
    );

    $('#pendingusermedtransaction-modal').modal('toggle');
})
$(document).on('click', '#removemanagerequistion', function(e){
    // e.preventDeafult();
    var orno = $(this).attr('orno');
    $.post(baseUrl+"/removemanagerequistion", {
        orno: orno,
    });
    $('#pendingusermedtransaction-modal').modal('hide');
     location.reload();
    
    toastr.error(' Managed Requisiton Removed');

})