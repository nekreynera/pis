$(document).on('submit', '.incomeform', function(e){
	e.preventDefault();
	nos = 1;
	var barcode = $('.barcodeinput').val();
	getpatientinforandcharges(barcode);
	
	
})

function getpatientinforandcharges(barcode) {
	$.post(baseUrl+"/getpatientbybarcode", {
	    barcode: barcode,
	 },
	    function (data, status){
	      	$('.itemsbody').empty();
	      	$('.transaction-content').empty();
	      	var request = JSON.parse(data);
	      	if (request.reciept) {
	      		var charges = request.charge;
	      		var input2 = $('<input type="hidden" name="category_id" value="4">');  
		      	if (request.data.length < 1) {
		      		$('.error_ms').text('patient credentials not found').show();
		      		hidemsg($('.error_ms'));

		      	}
		      	/*start of comment doe to changes 01/04/2019*/
		       //  else if (request.data[0].mss_id && request.data[0].label) {
		       //  	 patientvalueincome(request);
		       //  	 var input3 = $('<input type="hidden" name="patient_id" value='+request.data[0].id+'>');  
		       //  	 var input1 = $('<input type="hidden" class="mss_idincome" name="mss_id" value='+request.data[0].mss_id+'>'); 
		       //  	 $('.transaction-content').append(input1, input2, input3);

		       //  	 var option = "<option value="+request.data[0].mss_id+'-'+request.data[0].discount+">"+request.data[0].label+'-'+request.data[0].description+'%'+"</option>";
		       //  	 var option2 = "<option value='15-0.2'>Senior Citizen 20%</option>";
		       //  	 var option3 = "<option value='14-0.2'>PWD 20%</option>";
		       //  	 var option4 = "<option value='1-0'>FULL PAY</option>";

			    	 // $('.patient_classification').append(option, option2, option3, option4);	

		       //  	 $('.th-discount').attr('id', request.data[0].discount);
		       //  	 $('.error_msgs').hide();
		       //  	 $('.error_msg').hide();
	      		// 	chargelist(charges);

		       //  }
		       //  else if (request.data[0].mss_id && request.data[0].label == null) {
		        	
		       //  	$('.error_msg').show();
		       //  	$('.error_msg a').attr('id', 'continue');
		       //  	$('.error_msgs').hide();
		       //  	$(document).on('click', '#continue', function(){
		       //  		var input3 = $('<input type="hidden" name="patient_id" value='+request.data[0].id+'>');  
		       //  		var input1 = $('<input type="hidden" class="mss_idincome" name="mss_id" value="0">'); 
		       //  		$('.transaction-content').append(input1, input2, input3);    
		       //  		$('.th-discount').attr('id', '0');

		       //  		var option = "<option value='0-0'>N/A</option>";
		       //  		var option2 = "<option value='15-0.2'>Senior 20%</option>";
		       //  	 	var option3 = "<option value='14-0.2'>PWD 20%</option>";
		       //  		$('.patient_classification').append(option, option2, option3);
		       //  		patientvalueincome(request);
	      		// 		chargelist(charges);

		       //  	})
		       //  }
		       //  else if(request.data[0].mss_id == null){
		       //  	$('.error_msgs').show();
		       //  	$('.error_msgs a').attr('id', 'continue');
		       //  	$('.error_msg').hide();
		       //  	$(document).on('click', '#continue', function(){
		       //  		var input3 = $('<input type="hidden" name="patient_id" value='+request.data[0].id+'>');  
		       //  		var input1 = $('<input type="hidden" class="mss_idincome" name="mss_id" value="0">'); 
		       //  		$('.transaction-content').append(input1, input2, input3);  
		       //  		$('.th-discount').attr('id', '0');

		       //  		var option = "<option value='0-0'>N/A</option>";
		       //  		var option2 = "<option value='15-0.2'>Senior 20%</option>";
		       //  	 	var option3 = "<option value='14-0.2'>PWD 20%</option>";
		       //  		$('.patient_classification').append(option, option2, option3);
		       //  		patientvalueincome(request);
	      		// 		chargelist(charges);

		        		
		       //  	})
		       //  }
		      	/*end of comment doe to changes 01/04/2019*/

		      	/*start of changes doe to changes 01/04/2019*/
		       	var input3 = $('<input type="hidden" name="patient_id" value='+request.data[0].id+'>');  
        		var input1 = $('<input type="hidden" class="mss_idincome" name="mss_id" value="0">'); 
        		$('.transaction-content').append(input1, input2, input3);  
        		$('.th-discount').attr('id', '0');

        		var option = "<option value='0-0'>N/A</option>";
        		var option2 = "<option value='15-0.2'>Senior 20%</option>";
        	 	var option3 = "<option value='14-0.2'>PWD 20%</option>";
        		$('.patient_classification').append(option, option2, option3);
        		patientvalueincome(request);
  				chargelist(charges);
		      	/*end of changes doe to changes 01/04/2019*/

		        
		        if (charges.length < 1) {
		        	appendthisincome(nos)	
		        }
		    }else{
		    	$('.reciept-msg').text('kindly set your INCOME O.R number first').css('display', 'block')
		    	$('#editreciept-modal').modal('show');
		    }

	    }
	);
}
/*============================for patient==========================================*/
function patientvalueincome(request){
	$('.patient_name').val(request.data[0].patient_name);
	$('.patient_sex').val(request.data[0].sex);
	$('.hospital_number').val((request.data[0].hospital_no)?request.data[0].hospital_no:'WALK-IN-'+request.data[0].walkin);
	$('.invoicno').val(request.reciept.reciept_no);
	$('#scan-modal').modal('toggle');
	$('.addbuttonincome').css('display', 'block');
}
/*============================for patient==========================================*/


/*===============================for row prepend and delete=========================*/

$('.addincome').on('click', function(){
	var nos = $('.required-entryincome').val();
	appendthisincome(nos)
})
$(document).on('click', '.removeincome', function(){
	$(this).closest('tr').remove();
	fortotalincome()
})

function appendthisincome(nos){
	for (var i = 1; i <= nos; i++) {
	var incomerow = $('<tr class="incomerow">' +
		                '<td><div class="col-md-6" style="padding: 0px;">' +
		                        '<select class="form-control category" name="category[]" required>' +
		                             '<option value="" hidden>CATEGORY</option>' +   
		                             '<option value="18" >FAMILY MEDICINE</option>' +   
		                             '<option value="1" >PEDIATRICS</option>' +   
		                             '<option value="2" >ENT</option>' +   
		                             '<option value="3" >OPHTHALMOLOGY</option>' +   
		                             '<option value="4" >SURGERY</option>' +   
		                             '<option value="5" >DENTAL</option>' + 
		                             '<option value="6" >ULTRASOUND</option>' +  
		                             '<option value="11" >X-RAY</option>' +   
		                             '<option value="7" >INJECTION ROOM/ABTC</option>' +   
		                             '<option value="8" >ORTHOPEDIC</option>' +   
		                             '<option value="9" >REHABILITATION</option>' +   
		                             '<option value="10">LABORATORY</option>' +   
		                             '<option value="12" >ECG</option>' +   
		                             '<option value="14" >OB-OPD</option>' +   
		                             '<option value="15" >INDUSTRIAL CLINIC</option>' +
		                             '<option value="19" >INTERNAL MEDICINE</option>' +
		                             '<option value="13" >OTHER FEES</option>' +      
		                        '</select>' +
		                    '</div>' +
		                    '<div class="col-md-6" style="padding: 0px;" required>' +
		                        '<select class="form-control sub_category" name="sub_category[]" required>' +
		                        '</select>' +
		                    '</div>' +
		                    '<input type="hidden" name="sub_description[]" class="sub_description">' +
		                    '<input type="hidden" name="request_id[]" class="request_id" value="0">' +
		                '</td>' +
		                '<td width="10%"><input type="text" name="item_price[]" class="form-control item_pricei" required></td>' +
		                '<td width="10%"><input type="number" name="item_qty[]" class="form-control item_qtyi" value="1"  required></td>' +
		                '<td width="10%"><input type="text" name="item_amount[]" class="form-control item_amounti" readonly></td>' +
		                '<td width="10%"><input type="text" name="item_discount[]" class="form-control item_discounti"></td>' +
		                '<td width="8%"><input type="text" name="granted_amount[]" class="form-control text-right granted_amounti" readonly></td>' +
		                '<td width="8%"><input type="text" name="item_netamount[]" class="form-control text-right item_netamounti"  readonly></td>' +
		                '<td width="13%" class="text-capitalize"></td>' +
		                '<td width="10%" class="text-center"></td>' +
		                '<td align="center" width="5%"><span class="glyphicon glyphicon-remove-circle removeincome" type="button" style="margin-top: 40%;color: red;cursor: pointer;"></span></td>' +
		            '</tr>');
		$('.forrequest .itemsbody').prepend(incomerow);
	}
}
/*===============================for row prepend and delete=========================*/






/*====================================for pricing==================================*/

$(document).on('keyup', '.item_pricei', function(){
	forrowpricing($(this));
})
$(document).on('keyup', '.item_discounti', function(){
	fordiscount($(this));
})
$(document).on('change', '.item_qtyi', function(){
	
	var amount = $(this).closest('tr').find('.item_pricei').val() * Number($(this).val());
	$(this).closest('tr').find('.item_amounti').val(amount.toFixed(2));
	var discount = amount * $('.th-discount').attr('id');
	$(this).closest('tr').find('.item_discounti').val(discount.toFixed(2));
	var netamount = amount - discount;  
	$(this).closest('tr').find('.item_netamounti').val(netamount.toFixed(2));
	fortotalincome()
})
function forrowpricing(element){
	var amount = $(element).val() * $(element).closest('tr').find('.item_qtyi').val();
	$(element).closest('tr').find('.item_amounti').val(amount.toFixed(2));
	var discount = amount * $('.th-discount').attr('id');
	$(element).closest('tr').find('.item_discounti').val(discount.toFixed(2));
	var netamount = amount - discount;  
	$(element).closest('tr').find('.item_netamounti').val(netamount.toFixed(2));
	fortotalincome()
}

function fortotalincome(){
	var tot_amount = 0; 
	$('.incomerow .item_pricei').each(function(){
		 tot_amount += Number($(this).closest('tr').find('.item_amounti').val());
	})
	$('.tot_amount').val(tot_amount.toFixed(2));
	var tot_discount = 0;
	$('.incomerow .item_pricei').each(function(){
		 tot_discount += Number($(this).closest('tr').find('.item_discounti').val());
	})
	$('.tot_discount').val(tot_discount.toFixed(2));
	var tot_netamount = 0;
	$('.incomerow .item_pricei').each(function(){
		 tot_netamount += Number($(this).closest('tr').find('.item_netamounti').val());
	})
	$('.tot_payment').val(tot_netamount.toFixed(2));
	$('.cash').val(tot_netamount.toFixed(2));
}

function fordiscount(element) {
	var discount = $(element).val();
	var amount = $(element).closest('tr').find('.item_amounti').val();
	var netamount = amount - discount;
	$(element).closest('tr').find('.item_netamounti').val(netamount);
	fortotalincome();
}
/*========================================for pricing===============================*/



/*====================================for subcategory================================*/
$(document).on('change', '.category',function(){
	var category_id = $(this).val();
	var scope = $(this);
	$.post(baseUrl+"/getsubcaegorybycaetogoryid", {
	    category_id: category_id,
	  },
	    function (data, status){

	      	var request = JSON.parse(data);
	      	console.log(request);
	      		$(scope).closest('tr').find('td .sub_category').empty();
	      		var option1 = '<option value="" hidden>     SELECT</option>';
	      		for (var i = 0; i < request.length; i++) {
	      			if (request[i].status == 'inactive') {
	      				option = '<option value='+request[i].id+'  price='+request[i].price+' class="bg-danger" disabled>'+request[i].sub_category+'- <b>NOT AVAILABLE</b></option>';
	      			}else{
	      				option = '<option value='+request[i].id+'  price='+request[i].price+'>'+request[i].sub_category+'</option>';
	      			}
	      		$(scope).closest('tr').find('td .sub_category').append(option1, option);
	      		}
	    }
	);
})

$(document).on('change', '.sub_category', function(){
	var options = $('option:selected', this).attr('price');
	var description = $('option:selected', this).text();
	var price = $(this).closest('tr').find('td .item_pricei').val(Number(options).toFixed(2));
	$(this).closest('tr').find('td .sub_description').val(description)
	forrowpricing(price);
})



/*====================================for subcategory================================*/


/*=========================for selection of discount===============================*/
$(document).on('change', '.patient_classification' ,function(){
	var value = $(this).val();
	var val = value.split("-");
	$('.th-discount').attr('id', val[1]);
	$('.mss_idincome').val(val[0]);
	$('.item_amounti').each(function(){
		var amount = $(this).val();
		var discount = Number(amount) * Number(val[1]);
		$(this).closest('tr').find('.item_discounti').val(discount.toFixed(2));
		var netamount = Number(amount) - Number(discount);
		$(this).closest('tr').find('.item_netamounti').val(netamount.toFixed(2));
		fortotalincome();
	})
})




/*==============================for auto selecltion=====================================*/
function getcategory(cat_id, s){
	$.get(baseUrl+"/getcategory", {
	   
	},
	    function (data, status){
	      	var request = JSON.parse(data);
	      	$('#catid'+s).empty();
	      	for (var i = 0; i < request.length; i++) {
	      		if (cat_id == request[i].id) {
	      			option =  '<option value='+request[i].id+' selected>'+request[i].category+'</option>';
	      		}else{
	      			option =  '<option value='+request[i].id+'>'+request[i].category+'</option>';	
	      		}
	      		$('#catid'+s).append(option);
	      	}
	    }
	)
}

function getsubcaegoryby(cat_id, sub_id, s){
	$.post(baseUrl+"/getsubcategorybycatid", {
		   cat_id: cat_id
		},
	    function (data, status){
	      	var request = JSON.parse(data);
	      	console.log(request);
	      	$('#subcat'+s).empty();
	      	for (var i = 0; i < request.length; i++) {
	      		if (sub_id == request[i].id) {
	      			option =  '<option value='+request[i].id+' price='+request[i].price+' selected>'+request[i].sub_category+'</option>';
	      		}else{
	      			option =  '<option value='+request[i].id+' price='+request[i].price+' disabled>'+request[i].sub_category+'</option>';	
	      		}
	      		$('#subcat'+s).append(option);
	      	}
	    }
	)

}
function chargelist(charges){
	console.table(charges);
	for (var s = 0; s < charges.length; s++) {
	var discount = 0;
	var cat_id = charges[s].cat_id;
	var sub_id = charges[s].sub_id;
	getcategory(cat_id, s);
	getsubcaegoryby(cat_id, sub_id, s);
	var amount = charges[s].price * charges[s].qty;

	discount = amount * Number(charges[s].discount);
	if (charges[s].payment_discount) {
		discount = charges[s].payment_discount;
	}
	// discount+=Number(charges[s].granted_amount);
	var netamount = ((amount - discount) - Number(charges[s].granted_amount).toFixed(2));
	var incomerow = $('<tr class="incomerow">' +
		                '<td width="30%"><div class="col-md-6" style="padding: 0px;">' +
		                        '<select class="form-control category" id="catid'+s+'" name="category[]" required>' +
		                             '<option value="" hidden>CATEGORY</option>' +   
		                             	
		                        '</select>' +
		                    '</div>' +
		                    '<div class="col-md-6" style="padding: 0px;" required>' +
		                        '<select class="form-control sub_category" id="subcat'+s+'" name="sub_category[]" required>' +
		                        '</select>' +
		                    '</div>' +
		                    '<input type="hidden" name="sub_description[]" class="sub_description" value='+charges[s].sub_category+'>' +
		                    '<input type="hidden" name="request_id[]" class="request_id" value='+charges[s].id+'>' +
		                '</td>' +
		                '<td width="8%"><input type="text" name="item_price[]" class="form-control text-right item_pricei" value='+charges[s].price.toFixed(2)+' required></td>' +
		                '<td width="8%"><input type="number" name="item_qty[]" class="form-control text-center item_qtyi" value='+charges[s].qty+'  required readonly></td>' +
		                '<td width="8%"><input type="text" name="item_amount[]" class="form-control text-right item_amounti" value='+amount.toFixed(2)+' readonly></td>' +
		                '<td width="8%"><input type="text" name="item_discount[]" class="form-control text-right item_discounti" value='+discount.toFixed(2)+' readonly></td>' +
		                '<td width="8%"><input type="text" name="granted_amount[]" class="form-control text-right granted_amounti" value='+Number(charges[s].granted_amount).toFixed(2)+' readonly></td>' +
		                '<td width="8%"><input type="text" name="item_netamount[]" class="form-control text-right item_netamounti"  value='+netamount.toFixed(2)+' readonly></td>' +
		                '<td width="13%" class="text-capitalize">'+((charges[s].charged_by)?charges[s].charged_by:"N/A")+'</td>' +
		                '<td width="10%" class="text-center">'+timeCalculate(charges[s].created_at)+'</td>' +
		                '<td align="center" width="5%"><span class="glyphicon glyphicon-remove-circle removeincome" type="button" style="margin-top: 40%;color: red;cursor: pointer;"></span></td>' +
		            '</tr>');
		$('.forrequest .itemsbody').append(incomerow);
	}
	fortotalincome();
}

