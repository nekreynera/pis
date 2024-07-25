$(document).on('submit', '.medicineform', function(e){
	var barcode = $('.barcodeinput').val();
	e.preventDefault();
	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();

	var today = d.getFullYear() + '-' +
	    (month<10 ? '0' : '') + month + '-' +
	    (day<10 ? '0' : '') + day;

		$.post(baseUrl+"/scanbarcode", {
		    barcode: barcode,
		  },
		    function (data, status){
		    	var request = JSON.parse(data);
		    	console.log(request);
		    	if (request.reciept) {
		    	 	if (request.patient == null) { 
	 	 	    		$('.error_ms').text('patient credentials not found').show();
	 	 	    		hidemsg($('.error_ms'));
		    	 	}else if (request.patient.mss_id == null) {
			    	 	$('.error_msgs').show();
			    	 	hidemsg($('.error_msgs'));
			    	 	$('.continue').click(function(){
			    	 		checkmanage(request);
			    	 	})
			    	}else if(request.patient.validity < today) {
			    	 	$('.error_msg').show();
    	 	    	 	hidemsg($('.error_msg'));
			    	 	$('.continue').click(function(){
			    	 		checkmanage(request);
			    	 	})
			    	}
			    	else if(request.manage == ""){
	 	 	    		toastr.error('patient dont have transaction to be paid');
			    	}
			    	else{
			    	 	var input4 = $('<input type="hidden" name="mss_id" class="mss_id mss_idincome" value='+request.patient.mss_id+'>');
			    	 	
    	 	         	 var option = "<option value="+request.patient.mss_id+'-'+request.patient.discount+">"+request.patient.label+'-'+request.patient.description+'%'+"</option>";
    	 	         	 var option2 = "<option value='15-0.2'>Senior 20%</option>";
    	 	         	 var option3 = "<option value='14-0.2'>PWD 20%</option>";
    	 	         	 var option4 = "<option value='0-0'>DISABLE</option>";
    	 	 	    	 $('.patient_classification').append(option, option2,option3,option4);	
			    	 	 forcontent(request ,input4);
			    	}
			    }else{
			    	$('.reciept-msg').text('kindly set your MEDICINE O.R number first').css('display', 'block')
			    	$('#editreciept-modal').modal('show');
			    }
		    }
		);
})
function forcontent(request ,input4){
	var tot_amount = 0;
	var tot_discount = 0;
	var tot_netamount = 0;
	     $('.invoicno').val(request.reciept.reciept_no);
	   	 $('.itemsbody').empty();
	   	 $('.transaction-content').empty();
	   	 $('.patient_name').val(request.patient.last_name+', '+request.patient.first_name+' '+request.patient.middle_name);
	   	 $('.patient_sex').val(request.patient.gender);
	   	 $('.hospital_number').val(request.patient.hospital_no);
	   	 var input3 = $('<input type="hidden" name="category_id" value="2">');
	   	 var input5 = $('<input type="hidden" name="patient_id" value='+request.patient.id+'>');

	   	 for (var i = 0; i < request.manage.length; i++) {
	   	 	var tr = $('<tr>');
		        var td1 = $('<td>').text(request.manage[i].medicine);
		        var td2 = $('<td align="right" width="100px">').text(request.manage[i].price.toFixed(2));
		        var td3 = $('<td align="center" width="50px">').text(request.manage[i].qty);
		        var td4 = $('<td align="right" width="100px" class="mamount">').text(request.manage[i].amount.toFixed(2));
		        var td5 = $('<td align="right" width="100px" class="mdiscount">').text(request.manage[i].discount.toFixed(2));
		        var td6 = $('<td align="right" width="100px" class="mnetamount">').text(request.manage[i].netamount.toFixed(2));
		        var td7 = '<td hidden><input type="hidden" name="item_netamount[]" class="item_netamount" value="'+request.manage[i].netamount.toFixed(2)+'"></td>';
		        var tr = $('<tr/>');
		        $(tr).append(td1, td2, td3, td4, td5, td6, td7);
		        $('.itemsbody').append(tr);
		        tot_amount += Number(request.manage[i].amount);
		        tot_discount += Number(request.manage[i].discount);
		        tot_netamount += Number(request.manage[i].netamount);
		        var input1 = $('<input type="hidden" name="manage_id[]" value='+request.manage[i].id+'>');
		        var input2 = $('<input type="hidden" name="price[]" value='+request.manage[i].price.toFixed(4)+'>');
		        var input6 = $('<input type="hidden" name="medicine_name[]" value="'+request.manage[i].medicine+'">');
		       	// var input7 = $('<input type="" name="item_netamount[]" value="'+request.manage[i].netamount+'">');
		       		 	       
		       		 	        
		       	$('.transaction-content').append(input1, input2, input3, input4, input5, input6);

	   	 }
	   	 $('.tot_amount').val(tot_amount.toFixed(2));
	   	 $('.tot_discount').val(tot_discount.toFixed(2));
	   	 $('.tot_payment').val(tot_netamount.toFixed(2));
	   	 $('#scan-modal').modal('toggle');
}
function checkmanage(request){
	if(request.manage == ""){
	 	toastr.error('patient dont have transaction to be paid');
	}
	else{
		var option = "<option value='0-0'>N/A</option>";
		var option2 = "<option value='15-0.2'>Senior 20%</option>";
	 	var option3 = "<option value='14-0.2'>PWD 20%</option>";
		$('.patient_classification').append(option, option2, option3);
	 	var input4 = $('<input type="hidden" name="mss_id" class="mss_idincome" value="0">');
	 	forcontent(request ,input4);
	}
	
}

/*=========================for selection of discount===============================*/

$(document).on('change', '.patient_classification' ,function(){
	var value = $(this).val();
	var val = value.split("-");
	$('.th-discount').attr('id', val[1]);
	$('.mss_idincome').val(val[0]);
	// alert(val[1]);
	var totamount2 = 0;
	var totdiscount2 = 0;
	var totnetamount2 = 0;
	$('.mamount').each(function(){
		var amount = $(this).text();
		var discount = Number(amount) * Number(val[1]);
		$(this).closest('tr').find('.mdiscount').text(discount.toFixed(2));
		var netamount = Number(amount) - Number(discount);
		$(this).closest('tr').find('.mnetamount').text(netamount.toFixed(2));
		$(this).closest('tr').find('td .item_netamount').val(netamount.toFixed(2));
		



			totamount2 += Number(amount);
			totdiscount2 += Number(discount);
			totnetamount2 += Number(netamount);

			$('.tot_amount').val(totamount2.toFixed(2));
		   	$('.tot_discount').val(totdiscount2.toFixed(2));
		   	$('.tot_payment').val(totnetamount2.toFixed(2));
	})
})
// $(document).on('click', '.removemedicine', function(){
// 	$(this).closest('tr').remove();
// })