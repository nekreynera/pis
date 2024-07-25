$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
    $('#transaction').DataTable();
});
$(document).on('click', '.transaction-body tr', function(){
    var id = $(this).attr('id');
	var discounted = Number($(this).attr('discount'));
    var from = $('.from').val();
    var to = $('.to').val();
    var hospital_no = $('.hospital_no').val();
    // alert(hospital_no);

		$.post(baseUrl+"/viewpatientmedtransaction", {
       		id: id,
            from: from,
            to: to,
            hospital_no: hospital_no
        },
        	function (data, status){
        		var request = JSON.parse(data);
        		console.log(request);
        		$('.usertransaction-tbody').empty();
        		$('.check-item').each(function(){
			        $(this).attr('checked', false);
			    })
                if (request.length > 0) {
                        for (var i = 0; i < request.length; i++) {
                            var tr = $('<tr class='+request[i].patient+' id="'+request[i].item_id+'">')
                            if (request[i].sales != null) {
                                if (Number(request[i].mss_id) >= 9 && Number(request[i].mss_id) <= 13) 
                                {
                                    if (request[i].get == 'Y') {
                                        var td1 = $('<td align="center" style="border-left: 15px solid #00e600;" class="td-check"><input type="checkbox" name="" class="select-transact" reqid="'+request[i].requisition+'" disabled></td>');
                                    }else{
                                        var td1 = $('<td align="center" style="border-left: 15px solid #3385ff;" class="td-check"><input type="checkbox" name="" class="select-transact" reqid="'+request[i].requisition+'"></td>');
                                    }
                                }
                                else if(Number(request[i].mss_id) <= 8 || Number(request[i].mss_id) >= 14) 
                                {
                                    if (Number(request[i].sale_price <= 0)) 
                                    {
                                        
                                        if (request[i].get == 'Y') {
                                            var td1 = $('<td align="center" style="border-left: 15px solid #00e600;" class="td-check"><input type="checkbox" name="" class="select-transact" reqid="'+request[i].requisition+'" disabled></td>');
                                        }else{
                                            var td1 = $('<td align="center" style="border-left: 15px solid #3385ff;" class="td-check"><input type="checkbox" name="" class="select-transact" reqid="'+request[i].requisition+'"></td>');
                                        }
                                    }
                                    else
                                    {
                                        if (request[i].get == 'Y') {
                                             var td1 = $('<td align="center" style="border-left: 15px solid #00e600;" class="td-check"><input type="checkbox" name="" class="select-transact" disabled></td>');
                                        }else{
                                             var td1 = $('<td align="center" style="border-left: 15px solid #3385ff;" class="td-check"><input type="checkbox" name="" class="select-transact" disabled></td>');
                                        }
                                      
                                    }
                                }
                            }else if (request[i].managed != null ) {
                                var td1 = $('<td align="center" style="border-left: 15px solid orange" class="td-check"><input type="checkbox" name="" class="select-transact" reqid="'+request[i].requisition+'"></td>');
                            }else{
                                var td1 = $('<td align="center" style="border-left: 15px solid yellow" class="td-check"><input type="checkbox" name="" class="select-transact" reqid="'+request[i].requisition+'"></td>');
                            }
                            var td2 = $('<td class="brand">').text(request[i].brand);
                            var td3 = $('<td class="item_description">').text(request[i].item_description);
                            var td4 = $('<td align="right" class="price">').text(request[i].price.toFixed(2));
                            var td16 = $('<td align="center" class="info medstock">').text(request[i].stock);
                            var td5 = $('<td class="mtdqty">').text(request[i].qty);
                            var td11 = $('<td><input type="number" class="form-control mgmtqty" value='+Number(request[i].mgmtqty)+' disabled></td>');
                            var amount = request[i].price * Number(request[i].mgmtqty);
                            var td6 = $('<td align="right" class="amount" discount="'+request[i].discount+'">').text(amount.toFixed(2));
                            var discount = amount * request[i].discount; 
                            var td7 = $('<td align="right" class="discount">').text(discount.toFixed(2));
                            var netamount = amount - discount; 
                            var td9 = $('<td align="right" class="netamount">').text(netamount.toFixed(2));


                            if (request[i].sales != null) {
                                if (Number(request[i].mss_id) >= 9 && Number(request[i].mss_id) <= 13) 
                                {
                                     if (request[i].get == 'Y') {
                                        var td10 = $('<td align="center" class="tdstatus" id="FREE">').text("ISSUED");
                                     }else{
                                        var td10 = $('<td align="center" class="tdstatus" id="FREE">').text("FREE");    
                                     }
                                }
                                else if(Number(request[i].mss_id) <= 8 || Number(request[i].mss_id) >= 14) 
                                {
                                    if (Number(request[i].sale_price <= 0)) 
                                    {
                                        if (request[i].get == 'Y') {
                                            var td10 = $('<td align="center" class="tdstatus" id="FREE">').text("ISSUED");
                                        }else{
                                            var td10 = $('<td align="center" class="tdstatus" id="FREE">').text("FREE");    
                                        }   
                                    }
                                    else
                                    {
                                        if (request[i].get == 'Y') {
                                            var td10 = $('<td align="center" class="tdstatus" id="PAID">').text("ISSUED");
                                        }else{
                                            var td10 = $('<td align="center" class="tdstatus" id="PAID">').text("PAID");    
                                        }   
                                    }
                                }
                            }else if (request[i].managed != null ) {
                                var td10 = $('<td align="center" class="tdstatus" id="MANAGED">').text("MANAGED");
                            }else{
                                var td10 = $('<td align="center" class="tdstatus" id="REQUEST">').text("REQUEST");
                            }
                            var td13 = $('<td class="req_name">').text(request[i].req_name);
                            if (request[i].mgmt_name) {
                                var td14 = $('<td class="mgmt_name">').text(request[i].mgmt_name);
                            }else{
                                var td14 = $('<td>').text("NONE");   
                            }
                            
                            var td15 = $('<td class="created_at">').text(request[i].created_at);



                            if (request[i].sales != null) {
                                if (Number(request[i].mss_id) >= 9 && Number(request[i].mss_id) <= 13) 
                                {
                                     if (request[i].get == 'Y') {
                                        var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-history" style="color:#ff3333"></span> <a href="#" class='+request[i].sales+' id="paidrevert">REVERT</a></td>');
                                     }else{
                                        var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-check" style="color:rgb(45, 178, 45)"></span> <a href="#" class='+request[i].sales+' id="paidissue">ISSUE</a>\
                                            <br><span class="fa fa-pencil" style="color:#e6b800"></span> <a href="#" class="'+request[i].managed+'" id="editmanaged">EDIT</a>\
                                            </td>');  
                                     }
                                }
                                else if(Number(request[i].mss_id) <= 8 || Number(request[i].mss_id) >= 14) 
                                {
                                    if (Number(request[i].sale_price <= 0)) 
                                    {
                                        if (request[i].get == 'Y') {
                                            var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-history" style="color:#ff3333"></span> <a href="#" class='+request[i].sales+' id="paidrevert">REVERT</a></td>');
                                        }else{
                                            var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-check" style="color:rgb(45, 178, 45)"></span> <a href="#" class='+request[i].sales+' id="paidissue">ISSUE</a>\
                                            <br><span class="fa fa-pencil" style="color:#e6b800"></span> <a href="#" class="'+request[i].managed+'" id="editmanaged">EDIT</a>\
                                            </td>');   
                                        }   
                                    }
                                    else
                                    {
                                        if (request[i].get == 'Y') {
                                            var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-history" style="color:#ff3333"></span> <a href="#" class='+request[i].sales+' id="paidrevert">REVERT</a></td>');
                                        }else{
                                            var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-check" style="color:rgb(45, 178, 45)"></span> <a href="#" class='+request[i].sales+' id="paidissue">ISSUE</a></td>');     
                                        }   
                                    }
                                }
                            }else if (request[i].managed != null ) {
                                var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-pencil" style="color:#e6b800" id="pencil"> <a href="#" class='+request[i].managed+' id="editmanaged">EDIT</a><br>\
                                </td>');
                            }else{
                                var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-balance-scale" style="color:#ff9933"></span> <a href="#" class='+request[i].requisition+' id="managerequistion">MANAGE</a></td>');
                            }

                            var tr2 = $('</tr>');
                        $(tr).append(td1,td2,td3,td4,td16,td5,td11,td6,td7,td9,td13,td14,td15,td10,td12,tr2);

                        $('.usertransaction-tbody').append(tr);
                        }
                    }else{

                        var tr = $('<tr class='+id+'">');
                        var td = $('<td colspan="14" class="amount" discount="'+discounted+'" align="center">').text("EMPTY TRANSACTION!");
                        var tr2 = $('<tr/>')
                        $(tr).append(td, tr2);

                        $('.usertransaction-tbody').append(tr);
                    }

                } 
		);
    
	$('#usertransactionsmed-modal').modal("toggle");
})


/*===================================for issuance==========================*/
$(document).on('click', '#paidissue', function(){
    var scope = $(this);
    $(scope).closest('tr').find('td.actioncol span').hide();
    $(scope).closest('tr').find('td.actioncol a').hide();
	var id = $(this).attr('class');
	var gets = 'Y';
		$.post(baseUrl+"/updatetransactionissuance", {
       		id: id,
       		gets: gets, 
        },
        	function (data, status){
        		var request = JSON.parse(data);
        		console.log(request);
                   
        	}
        	
        )
    $(this).closest('tr').find('td .select-transact').attr('disabled', true);
    $(this).closest('tr').find('.td-check').css('border-left', '15px solid #00e600');
    var span = '<span class="fa fa-history" style="color:#ff3333"></span> <a href="#" class='+id+' id="paidrevert">REVERT</a>';
    $(scope).closest('tr').find('.actioncol').prepend(span);
	$(scope).closest('tr').find('td.tdstatus').text("ISSUED");
	toastr.success('requesition issued');
    }
)
$(document).on('click', '#paidrevert', function(){
    var scope = $(this);
	var id = $(scope).attr('class');
	var gets = 'N';
    var statuse = $(scope).closest('tr').find('td.tdstatus').attr('id');
		$.post(baseUrl+"/updatetransactionissuance", {
       		id: id,
       		gets: gets, 
        },
        	function (data, status){
        		var request = JSON.parse(data);
        		console.log(request);
                // alert(statuse);
                if (statuse == "FREE") {
                    // alert("naages");
                    var span = '<br><span class="fa fa-pencil" style="color:#e6b800"></span> <a href="#" class="'+request.pharmanagerequest_id+'" id="editmanaged">EDIT</a>';
                    $(scope).closest('tr').find('.actioncol').append(span);
                    $(scope).closest('tr').find('td .select-transact').attr('disabled', false);
                }else{
                    $(scope).closest('tr').find('td .select-transact').attr('disabled', true);
                }
        	}
        	
        )
    $(this).closest('tr').find('.td-check').css('border-left', '15px solid #3385ff');
	$(this).text("ISSUE").attr('id', 'paidissue');
	$(this).closest('tr').find('td.actioncol span').attr('class', 'fa fa-check').css('color', 'rgb(45, 178, 45)');
	$(this).closest('tr').find('td.tdstatus').text($(this).closest('tr').find('td.tdstatus').attr('id'));

	toastr.warning('requesition reverted');
})


/*=============================for managed==============================*/
$(document).on('click', '#managerequistion', function(){
	$(this).closest('tr').find('td .mgmtqty').attr('disabled', false);
    $(this).closest('tr').find('td .select-transact').attr('checked', true);
	$(this).text('SAVE').attr('id', 'savemanaged');
	$(this).closest('tr').find('td.actioncol span').attr('class', 'fa fa-save').css('color', '#1a8cff');
})

$(document).on('click', '#savemanaged', function(){
	var scope = $(this);
	var id = $(this).attr('class');
    forsavemanaged(scope, id);
    
	
})
/*===============================for save managed==========================*/
function forsavemanaged(scope, id){
    var reqqty = $(scope).closest('tr').find('td.mtdqty').text();
    // alert(reqqty);
    var qty = $(scope).closest('tr').find('td .mgmtqty').val();
    var price = $(scope).closest('tr').find('.price').text();
    var patient_id = $(scope).closest('tr').attr('class');
    var item_id = $(scope).closest('tr').attr('id');
    var stock = $(scope).closest('tr').find('td.medstock').text();
    // alert(stock);
    if (Number(qty) <= Number(stock)) {
        if (Number(qty) <= Number(reqqty)) {
            $.post(baseUrl+"/managerequisition", {
                id: id,
                qty: qty,
                patient_id: patient_id,
                price: price,
                item_id: item_id
            },
                function (data, status){
                    var request = JSON.parse(data);
                    console.log(request);
                    
                        if (request.sale) {
                            $(scope).closest('tr').find('.tdstatus').text("FREE");
                            $(scope).closest('tr').find('.td-check').css('border-left', '15px solid #3385ff');

                            $(scope).closest('tr').find('td #savemanaged').text('ISSUE').attr('id', 'paidissue').attr('class', request.sale.id);
                            $(scope).closest('tr').find('td.actioncol .fa-save').attr('class', 'fa fa-check').css('color', 'rgb(45, 178, 45)');
                            $(scope).closest('tr').find('td .mgmtqty').attr('disabled', true);
                            $(scope).closest('tr').find('td.mgmt_name').text("CURRENT USER").css('text-align', 'center');
                            var span = '<br><span class="fa fa-pencil" style="color:#e6b800"></span> <a href="#" class="'+request.manage.id+'" id="editmanaged">EDIT</a>';
                            $(scope).closest('tr').find('td .mgmtqty').css('border', '1px solid rgb(204, 204, 204)');
                            $(scope).closest('tr').find('td.medstock').text(Number(stock) - Number(qty));
                            toastr.success('requesition is now for issuance');
                        }
                        else if (request.manage) {
                            $(scope).closest('tr').find('.tdstatus').text("MANAGED");
                            $(scope).closest('tr').find('.td-check').css('border-left', '15px solid orange');

                            var span = "";
                            $(scope).closest('tr').find('td #savemanaged').text('EDIT').attr('id', 'editmanaged');
                            $(scope).closest('tr').find('td.actioncol .fa-save').attr('class', 'fa fa-pencil').css('color', '#e6b800');
                            $(scope).closest('tr').find('td .mgmtqty').attr('disabled', true);
                            $(scope).closest('tr').find('td.mgmt_name').text("CURRENT USER").css('text-align', 'center');
                            $(scope).closest('tr').find('td .mgmtqty').css('border', '1px solid rgb(204, 204, 204)');
                            $(scope).closest('tr').find('td.medstock').text(Number(stock) - Number(qty));
                            toastr.success('requesition managed');
                        }
                        else{
                            toastr.error('Invalid qty');
                        }
                    
                    
                    $(scope).closest('tr').find('.actioncol').append(span);
                    transactiontable();
                    
                }
            )
        }else{
            toastr.error('Invalid qty');
            $(scope).closest('tr').find('td .mgmtqty').css('border', '1px solid red');
        }
    }else{
        toastr.error('managed qty must be lesser or equal than stock');
        $(scope).closest('tr').find('td .mgmtqty').css('border', '1px solid red');
    }

}



/*==============================for edit managed==========================*/

$(document).on('click', '#editmanaged', function(){
	

    $(this).closest('tr').find('td .mgmtqty').attr('disabled', false);
	$(this).closest('tr').find('td .select-transact').attr('checked', true);
	$(this).text('UDPATE').attr('id', 'saveeditmanaged');
	$(this).closest('tr').find('td.actioncol #pencil').attr('class', 'fa fa-reorder').css('color', '#1a8cff');
})
$(document).on('click', '#saveeditmanaged', function(){
    var scope = $(this);
	var id = $(this).attr('class');
    forupdateall(scope, id);
})
$(document).on('click', '#update-medicine', function(){
    $('.select-transact').each(function(){
        if (this.checked) {
            var scope = $(this);
            var id = $(this).closest('tr').find('td #saveeditmanaged').attr('class');
            forupdateall(scope, id);
        }
    })
})
/*=========================for update all ==================================*/
function forupdateall(scope, id){
    var qty = $(scope).closest('tr').find('td .mgmtqty').val();
    var reqqty = $(scope).closest('tr').find('.mtdqty').text();
    var stock = $(scope).closest('tr').find('.medstock').text();
    // alert(stock);
    if (Number(qty) > 0 && Number(qty) <= Number(reqqty)) {
        $.post(baseUrl+"/updatemanagerequisition", {
            id: id,
            qty: qty,

        },
            function (data, status){
                var request = JSON.parse(data);
                console.log(request);
            }
        )
    $(scope).closest('tr').find('td .mgmtqty').attr('disabled', true);
    $(scope).closest('tr').find('td #saveeditmanaged').text('EDIT').attr('id', 'editmanaged');
    $(scope).closest('tr').find('td.actioncol #pencil').attr('class', 'fa fa-pencil').css('color', '#e6b800');
    $(scope).closest('tr').find('td .select-transact').attr('checked', false);
    $(scope).closest('tr').find('td .mgmtqty').css('border', '1px solid rgb(204, 204, 204)');

    toastr.info('managed requesition successfuly edited');
    }else{
        toastr.error('Invalid qty');
        $(scope).closest('tr').find('td .mgmtqty').css('border', '1px solid red');
    }   
}





$(document).on('click', '#cancelmanaged', function(){
	var scope = $(this);
	$(this).closest('tr').find('.actioncol span').hide();
	$(this).closest('tr').find('.actioncol a').hide();
	var id = $(this).attr('class');
		$.post(baseUrl+"/cancelmanagerequisition", {
       		id: id,
        },
        	function (data, status){
        		var request = JSON.parse(data);
        		console.log(request);

        		var span = '<span class="fa fa-balance-scale" style="color:#ff9933"></span> <a href="#" class="'+request.requisition_id+'" id="managerequistion">MANAGE</a>';
        		$(scope).closest('tr').find('.actioncol').append(span);
        		transactiontable();
        	}
        )
	$(this).closest('tr').find('td .mgmtqty').val('0');
    $(this).closest('tr').find('.tdstatus').text("REQUEST");
	toastr.warning('managed requesition cancelled');
})
   

/*================================for adding meds========================================*/

$(document).on('click', '#add-medicine', function(){
    var discount = $('.amount').attr('discount');
    $('.check-item').each(function(){
        if (this.checked) {

            var patient_id = $('.usertransaction-tbody tr').attr('class');
            var id = $(this).attr('data-id');
            var brand = $(this).closest('tr').find('.item_brand').text();
            var item_description = $(this).closest('tr').find('.item_description').text();
            var price = $(this).closest('tr').find('.price').text();
            var stocks = $(this).closest('tr').find('.stocks').text();
            var tr = $('<tr id='+id+' class='+patient_id+' style="background-color:#e6ffee">')
            var td1 = $('<td align="center"><input type="checkbox" name="" class="check-req" data-id='+id+' checked></td>');
            var td2 = $('<td class="brand">').text(brand);
            var td3 = $('<td class="item_description">').text(item_description);
            var td4 = $('<td align="right" class="price">').text(price);
            var td16 = $('<td align="center" class="info medstock">').text(stocks);
            var td5 = $('<td class="mtdqty"><input type="number" class="form-control reqqty" value="0" min="0"></td>');
            var td11 = $('<td><input type="number" class="form-control mgmtqty" value="0" min="0"></td>');
            var td6 = $('<td align="right" class="amount" discount="'+discount+'">').text("0.00");
            var td7 = $('<td align="right" class="discount">').text("0.00");
            var td9 = $('<td align="right" class="netamount">').text("0.00");
            var td13 = $('<td align="right" class="req_name">').text("-");
            var td14 = $('<td align="right" class="mgmt_name">').text("-");
            var td15 = $('<td align="right" class="created_at">').text("-");
            var td10 = $('<td align="right" class="tdstatus" id="REQUEST">').text("REQUEST");
            var td12 = $('<td align="center" class="actioncol"> <span class="fa fa-save" style="color:#1a8cff"></span> <a href="#" class="test" id="saverequistion">SAVE</a> \
                        <br> <span class="fa fa-remove" style="color:red"></span> <a href="#" class="test" id="remove-medicine">REMOVE</a></td>');
            var tr2 = $('</tr>');
            $(tr).append(td1,td2,td3,td4, td16, td5,td11,td6,td7,td9,td13,td14,td15,td10,td12,tr2);

            if (this.checked) {
                $('.usertransaction-tbody').append(tr);   
                $(this).attr('checked', false);
               
            }
            
        }
    })
})

$(document).on('click','#saverequistion', function(){
    var scope = $(this);
    forsaverequisition(scope);
    
    
})

/*===============================for save all=======================================*/
$(document).on('click', '#save-medicine', function(){
    $('.check-req').each(function(){
        if (this.checked) {
            var scope = $(this);
            forsaverequisition(scope);
        }
    })
    $('.select-transact').each(function(){
        if ((this).checked) {
            var scope = $(this);
            var id = $(this).closest('tr').find('td #savemanaged').attr('class');
            forsavemanaged(scope, id);
        }
    })
})



function forsaverequisition(scope){
    var item_id = $(scope).closest('tr').attr('id');
    var patient_id = $(scope).closest('tr').attr('class');
    var req_qty = $(scope).closest('tr').find('td .reqqty').val();
    var mgmt_qty = $(scope).closest('tr').find('td .mgmtqty').val();
    var price = $(scope).closest('tr').find('.price').text();
    var stock = $(scope).closest('tr').find('.medstock').text();
    // alert(stock);
    if (Number(mgmt_qty) <= Number(stock)) {
        if (Number(req_qty) > 0 && Number(mgmt_qty) > 0) {
            if (Number(req_qty) >= Number(mgmt_qty)) {
                $(scope).closest('tr').find('.actioncol .fa-remove').remove();
                $(scope).closest('tr').find('.actioncol #remove-medicine').remove();
                 $(scope).closest('tr').find('.mtdqty').text(req_qty);
                $.post(baseUrl+"/saverequistion", {
                    item_id: item_id,
                    patient_id: patient_id,
                    req_qty: req_qty,
                    mgmt_qty: mgmt_qty,
                    price: price,
                },
                    function (data, status){
                        var request = JSON.parse(data);
                        console.log(request);
                        $(scope).closest('tr').find('.req_name').text("CURRENT USER").css('text-align', 'center');
                        $(scope).closest('tr').find('.mgmt_name').text("CURRENT USER").css('text-align', 'center');
                        $(scope).closest('tr').find('.created_at').text(request.manage.created_at)
                        if (request.sale) {
                            $(scope).closest('tr').find('.tdstatus').text("FREE");
                            $(scope).text('ISSUE').attr('id', 'paidissue').attr('class', request.sale.id);
                            $(scope).closest('tr').find('td.actioncol .fa-save').attr('class', 'fa fa-check').css('color', 'rgb(45, 178, 45)');
                            var span = '<span class="fa fa-pencil" style="color:#e6b800"></span> <a href="#" class="'+request.manage.id+'" id="editmanaged">EDIT</a>';
                            $(scope).closest('tr').find('.actioncol').append(span);
                        }
                        else{
                            $(scope).closest('tr').find('.tdstatus').text("MANAGED");
                            $(scope).text('EDIT').attr('id', 'editmanaged');
                            $(scope).closest('tr').find('td #saverequistion').text('EDIT').attr('id', 'editmanaged');
                            $(scope).closest('tr').find('td.actioncol .fa-save').attr('class', 'fa fa-pencil').css('color', '#e6b800');
                        }
                        transactiontable();
                    }

                )
                $(scope).closest('tr').find('td.medstock').text(Number(stock) - Number(mgmt_qty));
                $(scope).closest('tr').find('td .check-req').attr("checked", false);
                $(scope).closest('tr').find('td .mgmtqty').attr('disabled', true);
                $(scope).closest('tr').find('td .mgmtqty').css('border', '1px solid rgb(204, 204, 204)');
                toastr.success('requesition added');
            }else{
                $(scope).closest('tr').find('td .mgmtqty').attr('disabled', false);
                toastr.error('invalid qty');
            }
        }else{
            $(scope).closest('tr').find('td .mgmtqty').attr('disabled', false);
            toastr.error('invalid qty');
        }
    }else{
        toastr.error('managed qty must be lesser or equal than stock');
        $(scope).closest('tr').find('td .mgmtqty').css('border', '1px solid red');
    }

}

/*==============================for delete of request=============================*/
$(document).on('click', '#delete-medicine', function(){
    
    // $(this).closest('tr').find('.actioncol').empty();
    var conf = confirm("Cancel checked transaction? \n this can't be undone")
    if (conf){

        $(".select-transact").each(function(){
            var mgmtqty = $(this).closest('tr').find('.mgmtqty').val();
            var stock = $(this).closest('tr').find('.medstock').text();
            var scope = $(this);
            if (this.checked) {
                $(this).closest('tr').find('.actioncol').empty();
                var reqid = $(this).attr('reqid');
                $.post(baseUrl+"/deleterequistion", {
                    reqid: reqid,
                },
                    function (data, status){
                            var request = JSON.parse(data);
                            console.log(request);
                            var span = '<span class="fa fa-balance-scale" style="color:#ff9933"></span> <a href="#" class="'+request.requisition.id+'" id="managerequistion">MANAGE</a>';
                            $(scope).closest('tr').find('.actioncol').append(span);
                    }
                )
                transactiontable(true);
                $(this).closest('tr').find('.mgmtqty').val("0"); 
                $(this).closest('tr').find('.amount').text("0.00"); 
                $(this).closest('tr').find('.discount').text("0.00"); 
                $(this).closest('tr').find('.netamount').text("0.00"); 
                $(this).closest('tr').find('.mgmt_name').text("NONE"); 
                $(this).closest('tr').find('.tdstatus').text("REQUEST"); 
                $(this).closest('tr').find('.td-check').css('border-left', '15px solid yellow');
                $(this).attr('checked', false);
                $(this).closest('tr').find('.medstock').text(Number(stock) + Number(mgmtqty));
                toastr.warning('Requesitions transactions cancelled');
            }

        })
    }
    
})


/*==============================for remove add meds==============================*/
$(document).on('click', '#remove-medicine', function(){
    $(this).closest('tr').remove();
})



/*==============================for transactions================================*/
function transactiontable(){
    // var from = $('.from').val();
    // var to = $('.to').val();
    // var hospital_no = $('.hospital_no').val();
    // // alert(hospital_no);
    // $.get(baseUrl+"/transactionlist", {
    //     from: from,
    //     to: to,
    //     hospital_no: hospital_no
    // },
    //     function (data, status){
    //             $('.transaction-body').empty();
    //             var request = JSON.parse(data);
    //             console.log(request);
                
    //                 for (var i = 0; i < request.length; i++) {

    //                     var tr = $('<tr id='+request[i].patients_id+'>');
    //                     var td1 = '<td hidden></td>';
    //                         if(request[i].label){
                              
    //                     var td2 = '<td align="center">'+request[i].label+' - '+request[i].description+'%</td>';
                            
    //                         }    
    //                         else{
    //                     var td2 = '<td align="center" class="danger">NOT CLASSIFIED</td>';
    //                         }
    //                     var td3 = '<td align="center">'+request[i].hospital_no+'</td>';
    //                     var td4 = '<td>'+request[i].last_name+', '+request[i].first_name+' '+request[i].middle_name+'.</td>';
    //                     var td5 = '<td align="center">'+request[i].requisition+'</td>';
    //                     var td6 = '<td align="center">'+request[i].managed+' / '+request[i].requisition+'</td>';
    //                     var td7 = '<td align="center">'+request[i].paid+' / '+request[i].requisition+'</td>';
    //                     var tr2 = '</tr>';

    //                     $(tr).append(td1, td2, td3, td4, td5, td6, td7, tr2);
    //                     $('.transaction-body').append(tr);
    //                 }

    //         }
    // )   
    // window.reload();
}

/*========================medicene table seach=================================*/

$('#searchbrand').keyup(function(){
    var name, filter, table, tr, td, i;
    name = document.getElementById("searchbrand");
    filter = name.value.toUpperCase();
    table = document.getElementById("medicinestable");
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
    table = document.getElementById("medicinestable");
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
$(document).on('click', '#show-medicine', function(){
    $(this).text('Hide Medicines').attr("id", 'hide-medicine');
    $('#add-medicine').show();
    // $('#delete-medicine').hide();
    $('.table-model').show();
})
$(document).on('click', '#hide-medicine', function(){
    $(this).text('Show Medicines').attr("id", 'show-medicine');
    $('#add-medicine').hide();
    // $('#delete-medicine').show();
    $('.table-model').hide();
})
$(document).on('change', '.mgmtqty', function(){
    forcalcultation($(this));

})
function forcalcultation(scope){
    var mgmtqty = $(scope).val();
    var price = $(scope).closest('tr').find('.price').text();
    var amount = Number(mgmtqty) * Number(price);
    $(scope).closest('tr').find('.amount').text(amount.toFixed(2));
    var desc = $(scope).closest('tr').find('.amount').attr('discount');
    if (desc == "null") {
        var discount = amount * 0;
        
    }else{
        var discount = amount * desc;
       
    }
    
    $(scope).closest('tr').find('.discount').text(discount.toFixed(2));
    var netamount = amount - discount;
    $(scope).closest('tr').find('.netamount').text(netamount.toFixed(2));
}


$(document).on('change', '.reqqty', function(){
    var qty = $(this).val();
    $(this).closest('tr').find('td .mgmtqty').val(qty);
    forcalcultation($(this));
})
$(document).on('click', '#print-medicine', function(){
    $i = 0
    $('.postchargetbody').empty();
    var d = new Date();
    var today = $.date(d);
    $('.tdstatus').each(function(){
        if ($(this).text() == 'ISSUED') {
            var brand = $(this).closest('tr').find('.brand').text();
            var item_description = $(this).closest('tr').find('.item_description').text();
            var price = $(this).closest('tr').find('.price').text();
            var qty = $(this).closest('tr').find('td .mgmtqty').val();
            var date = $(this).closest('tr').find('td.created_at').text();
            var id = $(this).closest('tr').find('td #paidrevert').attr('class');

            var reqdate = $.date(date);
            var tr = $('<tr>');
            if (today == reqdate) {
            var td5 = $('<td><input type="checkbox" name="" class="check-print" value="'+id+'" checked></td>')
            }else{
            var td5 = $('<td><input type="checkbox" name="" class="check-print" value="'+id+'"></td>')
            }
            var td1 = $('<td>').text(brand);
            var td2 = $('<td>').text(item_description);
            var td3 = $('<td>').text(price);
            var td4 = $('<td>').text(qty);
            var td6 = $('<td width="100"align="center" class="issuance_date">').text($.date(date));
            
            $(tr).append(td5,td1,td2,td3,td4,td6);
            if (today == reqdate) {
            }else{
                $(tr).attr('hidden', true);
            }
                $('.postchargetbody').append(tr);
            
        }
    });
    var i = 0
    $('.postchargetbody tr').each(function(){
        if ($(this).attr('hidden') == 'hidden') {
        }else{
            i++;
        }
    });
    if (i <= 0) {
        var tr = $('<tr>');
        var td = $('<td colspan="6" align="center" class="bg-warning">').text('EMPTY ISSUANCE FOR THIS DAY');
        $(tr).append(td);
        $('.postchargetbody').append(tr);
    }
    $('#postchargemodal').modal('toggle');
    // window.open(baseUrl+'/postcharge');
    // alert($i);
})
$(document).on('change', '.select-display', function(){
    if ($(this).val() == 'all') {
        $('.postchargetbody tr').each(function(){
            $(this).attr('hidden', false);
        }); 
    }
    else{
        $('.postchargetbody tr').each(function(){
            var date = $(this).find('td.issuance_date').text();
            var d = new Date();
            var today = $.date(d);
            if (date == today) {
                $(this).attr('hidden', false);
            }else{
                $(this).attr('hidden', true);
            }
        }); 
    }
})

$(document).on('click', '#print-postcharge', function(){
    var display = "";
    $('.check-print').each(function(){
        if (this.checked) {
            var tr = $(this).closest('tr').find('td .check-print').val();
            display+=tr+',';
        }
        
    })
    if (display != "") {
        window.open(baseUrl+'/postcharge/'+display);
    }else{
        toastr.warning('kindly choose issued transaction to print'); 
    }
    
})

$('.thcheck-print').change(function(){
    if (this.checked) {
        $('.check-print').attr('checked', true)
    }else{
        $('.check-print').attr('checked', false)
    }
})


$(document).on('click', '#showallculomn', function(){
    $(this).text('HIDE SOME CULOMN').attr("id", "hidesomeculomn");
    $('.usertransactions-table td').show();
    $('.usertransactions-table th').show();
})

$(document).on('click', '#hidesomeculomn', function(){
    $(this).text('SHOW ALL COLUMN').attr("id", "showallculomn");
    // $('.usertransactions-table td:nth-child(12)').hide();
    $('.usertransactions-table td:nth-child(8)').hide();
    $('.usertransactions-table td:nth-child(10)').hide();
    // $('.usertransactions-table td:nth-child(11)').hide();
    $('.usertransactions-table td:nth-child(9)').hide();

    // $('.usertransactions-table th:nth-child(12)').hide();
    $('.usertransactions-table th:nth-child(8)').hide();
    $('.usertransactions-table th:nth-child(10)').hide();
    // $('.usertransactions-table th:nth-child(11)').hide();
    $('.usertransactions-table th:nth-child(9)').hide();
})
$('#usertransactionsmed-modal').on('hide.bs.modal', function(){
    setInterval(myFunction, 1500);
    
    $('.loaderWrapper').show();
})
function myFunction(){
    location.reload();
}

$.date = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth();
    var year = d.getFullYear();
    var monthNames = ["Jan", "Feb", "March", "Apr", "May", "June",
      "July", "Aug", "Sept", "Oct", "Nov", "Dec"
    ];   
    var date =  monthNames[month] + " " + day + ", " + year;

    return date;
};
    
