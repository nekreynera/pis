/*============================for patient==========================================*/
$(document).on('submit', '.manualform', function(e){
	e.preventDefault();
	no = 1;
	var barcode = $('.barcodeinput').val();
	$.post(baseUrl+"/getpatientbybarcode", {
	    barcode: barcode,
	  },
	    function (data, status){
	      	$('.itemsbody').empty();
	      	$('.transaction-content').empty();
	      	var request = JSON.parse(data);
	      	if (request.reciept) {
	      		var input2 = $('<input type="hidden" name="category_id" value="3">');  
		      	if (request.data.length < 1) {
		      		$('.error_ms').text('patient credentials not found').show();
		      		hidemsg($('.error_ms'));

		      	}
		        else if (request.data[0].mss_id && request.data[0].label) {
		        	 patientvalue(request);
		        	 appendthis(no);
		        	 var input3 = $('<input type="hidden" name="patient_id" value='+request.data[0].id+'>');  
		        	 var input1 = $('<input type="hidden" name="mss_id" value='+request.data[0].mss_id+'>'); 
		        	 $('.transaction-content').append(input1, input2, input3);
		        	 
		        	 var option = "<option>"+request.data[0].label+'-'+request.data[0].description+'%'+"</option>";
		        	 $('.patient_classification').append(option);	

		        	 $('.th-discount').attr('id', request.data[0].discount);
		        	 $('.error_msgs').hide();
		        	 $('.error_msg').hide();
		        }
		        else if (request.data[0].mss_id && request.data[0].label == null) {
		        	
		        	$('.error_msg').show();
		        	$('.error_msg a').attr('id', 'continue');
		        	$('.error_msgs').hide();
		        	$(document).on('click', '#continue', function(){
		        		var input3 = $('<input type="hidden" name="patient_id" value='+request.data[0].id+'>');  
		        		var input1 = $('<input type="hidden" name="mss_id" value="0">'); 
		        		$('.transaction-content').append(input1, input2, input3);    
		        		$('.th-discount').attr('id', '0');

		        		var option = "<option>N/A</option>";
		        		$('.patient_classification').append(option);

		        		patientvalue(request);
		        		appendthis(no);
		        	})
		        }
		        else if(request.data[0].mss_id == null){
		        	$('.error_msgs').show();
		        	$('.error_msgs a').attr('id', 'continue');
		        	$('.error_msg').hide();
		        	$(document).on('click', '#continue', function(){
		        		var input3 = $('<input type="hidden" name="patient_id" value='+request.data[0].id+'>');  
		        		var input1 = $('<input type="hidden" name="mss_id" value="0">'); 
		        		$('.transaction-content').append(input1, input2, input3);  
		        		$('.th-discount').attr('id', '0');

		        		var option = "<option>N/A</option>";
		        		$('.patient_classification').append(option);
		        		
		        		patientvalue(request);
		        		appendthis(no);
		        	})
		        }
		    }else{
		    	$('.reciept-msg').text('kindly set your INCOME O.R number first').css('display', 'block')
		    	$('#editreciept-modal').modal('show');
		    }

	    }
	);
	
})
/*============================for patient==========================================*/
function patientvalue(request){
	$('.patient_name').val(request.data[0].patient_name);
	$('.patient_sex').val(request.data[0].sex);
	$('.hospital_number').val(request.data[0].hospital_no);
	$('.invoicno').val(request.reciept.reciept_no);
	$('#scan-modal').modal('toggle');
	$('.addbutton').css('display', 'block');
}


/*============================for row prepend and delete==========================================*/
$('.add').on('click', function(){
	var no = $('.required-entry').val();
	appendthis(no);
})
$(document).on('click', '.remove', function(){
	$(this).closest('tr').remove();
	fortotal();
})
function appendthis(no){
	for (var i = 1; i <= no; i++) {
	var ini = $('<tr class="participantRow">\
	                <td><textarea class="form-control item_name" placeholder="ITEM NAME..." name="item_name[]"></textarea></td>\
	                <td width="10%"><input type="text" name="item_price[]" class="form-control item_price" placeholder="PRICE"></td> \
	                <td width="10%"><input type="number" name="item_qty[]" class="form-control item_qty" value="1"></td>\
	                <td width="10%"><input type="text" name="" class="form-control item_amount" placeholder="AMOUNT" readonly></td>\
	                <td width="10%"><input type="text" name="" class="form-control item_discount" readonly></td>\
	                <td width="10%"><input type="text" name="item_netamount[]" class="form-control item_netamount" readonly></td>\
	                <td align="center" width="5%"><span class="glyphicon glyphicon-remove-circle remove" type="button" style="margin-top: 40%;color: red;cursor: pointer;"></span></td>\
	            </tr>');

		$('.forrequest .itemsbody').prepend(ini);
	}
}
/*============================for row prepend==========================================*/


/*======================================for pricing===============================*/


$(document).on('keyup', '.item_price', function(){
	var amount = $(this).val() * $(this).closest('tr').find('.item_qty').val();
	$(this).closest('tr').find('.item_amount').val(amount.toFixed(2));
	var discount = amount * $('.th-discount').attr('id');
	$(this).closest('tr').find('.item_discount').val(discount.toFixed(2));
	var netamount = amount - discount;  
	$(this).closest('tr').find('.item_netamount').val(netamount.toFixed(2));
	fortotal()
	
})
$(document).on('change', '.item_qty', function(){
	
	var amount = $(this).closest('tr').find('.item_price').val() * Number($(this).val());
	$(this).closest('tr').find('.item_amount').val(amount.toFixed(2));
	var discount = amount * $('.th-discount').attr('id');
	$(this).closest('tr').find('.item_discount').val(discount.toFixed(2));
	var netamount = amount - discount;  
	$(this).closest('tr').find('.item_netamount').val(netamount.toFixed(2));
	fortotal()
})

function fortotal(){
	var tot_amount = 0; 
	$('.participantRow .item_price').each(function(){
		 tot_amount += Number($(this).closest('tr').find('.item_amount').val());
	})
	$('.tot_amount').val(tot_amount.toFixed(2));
	var tot_discount = 0;
	$('.participantRow .item_price').each(function(){
		 tot_discount += Number($(this).closest('tr').find('.item_discount').val());
	})
	$('.tot_discount').val(tot_discount.toFixed(2));
	var tot_netamount = 0;
	$('.participantRow .item_price').each(function(){
		 tot_netamount += Number($(this).closest('tr').find('.item_netamount').val());
	})
	$('.tot_payment').val(tot_netamount.toFixed(2));
}



/*======================================for pricing===============================*/

