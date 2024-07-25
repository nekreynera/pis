$(document).trigger('mouseenter', '.infos',function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
$(document).ready(function (){
    var $some_datepicker = $('.some_datepicker');
    $some_datepicker.datepicker();
    var datepicker = jQueryDatepicker.data($some_datepicker);

    var date = new Date();
    datepicker.setDate({
        year: date.getFullYear(),
        month: date.getMonth()+1,
        day: date.getDate()
    });
    var calendar_year = date.getFullYear();
        var calendar_month = date.getMonth()+1;
        var clicked_day = date.getDate();
        var chooseday = calendar_year+"-"+calendar_month+"-"+clicked_day;
        getallTransactionsbyday(chooseday);
});
function getallTransactionsbyday(chooseday) {
    // tot_amount = 0;
    // tots_discount = 0;
    // tots_netamount = 0;

    // tot_amountv = 0;
    // tots_discountv = 0;
    // tots_netamountv = 0;
    var tot_medicine = 0;
    var tot_otherfees = 0;
    var tot_rehab = 0;
    var tot_laboratory = 0;
    var tot_radiology = 0;
    var tot_cardiology = 0;
    var tot_supply = 0;
    var tot_consultation = 0;
    var tot_income = 0;
    var date = new Date(chooseday);
    $('.reciept-number h3').text($.fulldate(date));
    $('.transdate').val(date.getFullYear() + '-' + (date.getMonth() + 1)  + '-' +  date.getDate());
    $.post(baseUrl+"/getallTransactionsbyday", {
        day: chooseday,
      },
        function (data, status){
            $('.transaction-table-body').empty();
             var request = JSON.parse(data);
             console.log(request);
             for (i = 0; i < request.length; i++) {
                var tr = $('<tr class="transactionrow">');
                var td = $('<td align="center"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="CLICK ROW TO VIEW TRANSACTION"></i></td>');
                if (request[i].void == '1') {
                var tdd = $('<td class="voidstatus" id='+request[i].void+'>').text(' ').css('background-color', 'red'); 
                }else{
                var tdd = $('<td class="voidstatus" id='+request[i].void+'>').text(' ').css('background-color', '#2196f3'); 
                }
                var td1 = $('<td align="center" class="tddate">').text(request[i].dates).css('text-transform', 'uppercase');
                var td2 = $('<td align="center" class="tdorno">').text(request[i].numbers);
                var td3 = $('<td class="tdname">').text(request[i].payor);
                var td4 = $('<td align="center">').text(request[i].particulars);
                var td5 = $('<td align="right">').text(Number(request[i].total).toFixed(2));
                if (request[i].other > 0) {
                var td6 = $('<td align="right">').text(Number(request[i].other).toFixed(2));    
                }else{
                var td6 = $('<td align="right">').text(''); 
                }
                if (request[i].medicines > 0) {

                var td7 = $('<td align="right">').text(Number(request[i].medicines).toFixed(2));
                }else{
                var td7 = $('<td align="right">').text('');
                }
                if (request[i].medical > 0) {
                    var td8 = $('<td align="right">').text(Number(request[i].medical).toFixed(2));
                }else{
                    var td8 = $('<td align="right">').text(''); 
                }
                if (request[i].laboratory > 0) {
                    var td9 = $('<td align="right">').text(Number(request[i].laboratory).toFixed(2));
                }else{
                    var td9 = $('<td align="right">').text(''); 
                }
                if (request[i].radiology > 0) {
                    var td10 = $('<td align="right">').text(Number(request[i].radiology).toFixed(2));
                }else{
                    var td10 = $('<td align="right">').text('');    
                }
                if (request[i].cardiology > 0) {
                    var td11 = $('<td align="right">').text(Number(request[i].cardiology).toFixed(2));
                }else{
                    var td11 = $('<td align="right">').text('');    
                }
                if (request[i].supply > 0) {
                    var td13 = $('<td align="right">').text(Number(request[i].supply).toFixed(2));
                }else{
                    var td13 = $('<td align="right">').text('');    
                }
                // if (request[i].consultation > 0) {
                //  var td13 = $('<td align="right">').text(Number(request[i].consultation).toFixed(2));
                // }else{
                //  var td13 = $('<td align="right">').text('');    
                // }
                
                var td12 = $('<td class="tdtype" hidden>').text(request[i].type);
                var tr2 = $('</tr>');
                
                $(tr).append(td, tdd, td1, td2, td3, td4, td5, td6, td7, td8, td9, td10, td11 ,td11, td13, td12, tr2);
                $('.transaction-table-body').append(tr);
                if (request[i].void <= 0) {
                    tot_medicine += Number(request[i].medicines);
                    tot_otherfees += Number(request[i].other);
                    tot_rehab += Number(request[i].medical);
                    tot_laboratory += Number(request[i].laboratory);
                    tot_radiology += Number(request[i].radiology);
                    tot_cardiology += Number(request[i].cardiology);
                    tot_supply += Number(request[i].supply);
                    if (request[i].type != 'pharmacy') {
                    tot_income += Number(request[i].total);
                    }
                }
                // tot_income = tot_otherfees + tot_rehab + tot_laboratory + tot_radiology + tot_cardiology;
                
             }
             $('.tot_medicine').val(tot_medicine.toFixed(2));
             $('.tot_otherfees').val(tot_otherfees.toFixed(2));
             $('.tot_rehab').val(tot_rehab.toFixed(2));
             $('.tot_laboratory').val(tot_laboratory.toFixed(2));
             $('.tot_radiology').val(tot_radiology.toFixed(2));
             $('.tot_cardiology').val(tot_cardiology.toFixed(2));
             $('.tot_supply').val(tot_supply.toFixed(2));
             var total =  Number(tot_income);
             $('.tot_income').val(total.toFixed(2));

        }

    );
}
$('.monthlya').click(function(){
    $('.some_datepicker').css('display','none');
    $('.monthly').css('display','block');
    $.get(baseUrl+'/monthlya', {

    },
        function(data, status){
            $('.monthlydivision').empty();
            var request = JSON.parse(data)
            for (i = 0; i < request.length; i++) {
                var tr = $('<tr class="choosemonth" id='+request[i].dates+'>').css('cursor', 'pointer');
                var td = $('<td>').text($.date(request[i].dates)).css('text-align', 'center');
                var tr2 = $('</tr>');
                $(tr).append(td, tr2);
                $('.monthlydivision').append(tr);
            }
        }
    )
})
$('.daylya').click(function(){
    $('.some_datepicker').css('display','block');
    $('.monthly').css('display','none');
})
$(document).on('click', '.choosemonth', function() {
    var tot_medicine = 0;
    var tot_otherfees = 0;
    var tot_rehab = 0;
    var tot_laboratory = 0;
    var tot_radiology = 0;
    var tot_cardiology = 0;
    var tot_income = 0;
    var tot_consultation = 0;
    
    var month = $(this).attr('id');
    $('.reciept-number h3').text($.date(month));
    $.post(baseUrl+'/gettransactionbymonth', {
        month: month
    },
        function (data, status){
            $('.transaction-table-body').empty();
             var request = JSON.parse(data);
             console.log(request);
             for (i = 0; i < request.length; i++) {
                var tr = $('<tr class="transactionrow">');
                var td = $('<td align="center"><i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="CLICK ROW TO VIEW TRANSACTION"></i></td>');
                if (request[i].void == '1') {
                var tdd = $('<td class="voidstatus" id='+request[i].void+'>').text(' ').css('background-color', 'red'); 
                }else{
                var tdd = $('<td class="voidstatus" id='+request[i].void+'>').text(' ').css('background-color', '#2196f3'); 
                }
                var td1 = $('<td align="center" class="tddate">').text(request[i].dates).css('text-transform', 'uppercase');
                var td2 = $('<td align="center" class="tdorno">').text(request[i].numbers);
                var td3 = $('<td class="tdname">').text(request[i].payor);
                var td4 = $('<td align="center">').text(request[i].particulars);
                var td5 = $('<td align="right">').text(Number(request[i].total).toFixed(2));
                if (request[i].other > 0) {
                var td6 = $('<td align="right">').text(Number(request[i].other).toFixed(2));    
                }else{
                var td6 = $('<td align="right">').text(''); 
                }
                if (request[i].medicines > 0) {
                var td7 = $('<td align="right">').text(Number(request[i].medicines).toFixed(2));
                }else{
                var td7 = $('<td align="right">').text('');
                }
                if (request[i].medical > 0) {
                    var td8 = $('<td align="right">').text(Number(request[i].medical).toFixed(2));
                }else{
                    var td8 = $('<td align="right">').text(''); 
                }
                if (request[i].laboratory > 0) {
                    var td9 = $('<td align="right">').text(Number(request[i].laboratory).toFixed(2));
                }else{
                    var td9 = $('<td align="right">').text(''); 
                }
                if (request[i].radiology > 0) {
                    var td10 = $('<td align="right">').text(Number(request[i].radiology).toFixed(2));
                }else{
                    var td10 = $('<td align="right">').text('');    
                }
                if (request[i].cardiology > 0) {
                    var td11 = $('<td align="right">').text(Number(request[i].cardiology).toFixed(2));
                }else{
                    var td11 = $('<td align="right">').text('');    
                }
                // if (request[i].consultation > 0) {
                //  var td13 = $('<td align="right">').text(Number(request[i].consultation).toFixed(2));
                // }else{
                //  var td13 = $('<td align="right">').text('');    
                // }
                
                var td12 = $('<td class="tdtype" hidden>').text(request[i].type);
                var tr2 = $('</tr>');
                
                $(tr).append(td, tdd, td1, td2, td3, td4, td5, td6, td7, td8, td9, td10, td11, td12, tr2);
                $('.transaction-table-body').append(tr);
                if (request[i].void <= 0) {
                    tot_medicine += Number(request[i].medicines);
                    tot_otherfees += Number(request[i].other);
                    tot_rehab += Number(request[i].medical);
                    tot_laboratory += Number(request[i].laboratory);
                    tot_radiology += Number(request[i].radiology);
                    tot_cardiology += Number(request[i].cardiology);
                    if (request[i].type != 'pharmacy') {
                    tot_income += Number(request[i].total);
                    }
                }
                // tot_income = tot_otherfees + tot_rehab + tot_laboratory + tot_radiology + tot_cardiology;
                
             }
             $('.tot_medicine').val(tot_medicine.toFixed(2));
             $('.tot_otherfees').val(tot_otherfees.toFixed(2));
             $('.tot_rehab').val(tot_rehab.toFixed(2));
             $('.tot_laboratory').val(tot_laboratory.toFixed(2));
             $('.tot_radiology').val(tot_radiology.toFixed(2));
             $('.tot_cardiology').val(tot_cardiology.toFixed(2));
             $('.tot_consultation').val(tot_consultation.toFixed(2));
             var total =  Number(tot_income);
             $('.tot_income').val(total.toFixed(2));
        }

    )
})

$(document).on('click', '.transactionrow', function(){
    var tdor_no = $(this).find('.tdorno').text();
    var tdname = $(this).find('.tdname').text();
    var tddate = $(this).find('.tddate').text();
    var tdtype = $(this).find('.tdtype').text();
    var voided = $(this).find('.voidstatus').attr('id');
    $('.voidtransaction b').attr('id', voided+'action');
    $('.voidtransaction').attr('id', voided+'button');
    $('#0action').text('VOID');
    $('#1action').text('UNVOID');
    $('.hidden_type').val(tdtype);
    var total = 0;
    // alert(tdor_no+'-'+tdtype);
    $.post(baseUrl+'/gettransactionbyorno',{
        tdor_no: tdor_no,
        tdtype: tdtype
    },
        function (data, status){
            $('.modaltbody').empty();
            var request = JSON.parse(data);
            console.table(request)
            for (i = 0; i < request.length; i++) {
                var tr = $('<tr>');
                var td1 = $('<td>').text(request[i].brand+'  '+request[i].item_description)
                var td2 = $('<td align="right">').text(request[i].price.toFixed(2))
                var td3 = $('<td>').text(request[i].qty)
                var td4 = $('<td align="right">').text(request[i].amount.toFixed(2))
                var td5 = $('<td align="right">').text(request[i].tot_discount.toFixed(2))
                var td5s = $('<td align="right">').text(Number(request[i].granted_amount).toFixed(2))
                var td6 = $('<td align="right">').text(request[i].tot_amount.toFixed(2))
                var tr2 = $('</tr>');
                $(tr).append(td1, td2, td3, td4, td5, td5s, td6, tr2);
                $('.modaltbody').append(tr);
                total += Number(request[i].tot_amount);
               
            }
            $('.totalm').text(total.toFixed(2));
        }
    )






    if (tdtype == 'pharmacy') {
        tdtype = 'medicine';
    }
    else if(tdtype == 'hospital id'){
        tdtype = 'income';
    }
    else if(tdtype == 'manual'){
        tdtype = 'income';
    }
    var tduser = $(this).find('.tduser').text();
    var tdclassification = $(this).find('.tdclassification').text();
    $('.namem').text(tdname)
    $('.datem').text(tddate)
    $('.or_nom').text(tdtype +' - '+tdor_no).css('text-transform', 'uppercase')
    $('.userm').text(tduser)
    $('.hidden_or').val(tdor_no);
     $('#transaction-modal .change-patient').attr('data-or', tdor_no);
    $('.classificationm').text(tdclassification);
    $('#transaction-modal').modal('toggle');
})
$(document).on('click', '#0button', function(){
    var conf = confirm("Reminder!\nIf you are about to use the Receipt of this ('voided') transaction, kindly edit first the O.R number of this transaction, to avoid merging of transaction with same O.R. number\nEx. *1234567 or -1234567\nThank you.");
    if (conf) {


        var or_no = $('.hidden_or').val();
        var type = $('.hidden_type').val();

        $.post(baseUrl+'/voidtransaction',{
            or_no: or_no,
            type: type,
        },
            function (data, status){
                var request = JSON.parse(data);
                
            }
        )
        $('.transactionrow').each(function(){
            var trtd = $(this).find('.tdorno').text();
            if (trtd == or_no) {
                $(this).find('.voidstatus').css('background-color', 'red');
                $(this).find('.voidstatus').attr('id', '1');
            }
        })
        toastr.error('transaction voided');
        $('#transaction-modal').modal('hide');
    }
})
$(document).on('click', '#1button', function(){
    var conf = confirm('unvoid transaction?');
    if (conf) {
        var or_no = $('.hidden_or').val();
        var type = $('.hidden_type').val();

        $.post(baseUrl+'/unvoidtransaction',{
            or_no: or_no,
            type: type,
        },
            function (data, status){
                var request = JSON.parse(data);
                
            }
        )
        $('.transactionrow').each(function(){
            var trtd = $(this).find('.tdorno').text();
            if (trtd == or_no) {
                $(this).find('.voidstatus').css('background-color', '#2196f3');
                $(this).find('.voidstatus').attr('id', '0')
            }
        })
        toastr.info('transaction successfuly unvoid');
        $('#transaction-modal').modal('hide');
    }

})
$(document).on('click', '.edit-reciept', function(){
    var or_no = $('.hidden_or').val();
    var hidden_or = $('.hidden_or').val();
    var type = $('.hidden_type').val();
    var tot_amount = 0;
    $.post(baseUrl+'/getortransaction',{
        or_no: or_no,
        type: type,
    },
        function (data, status){
            var request = JSON.parse(data);
            
            $('.payer').val(request[0].patient_name);
            $('.reciepttype').val(request[0].reciept_type);
            $('.seriespayer').val(request[0].series_type);
            $('.recieptno').val(request[0].or_no);
            $('.recieptdate').val(request[0].created_at);
            $('.oramount').val(request[0].tot_amount.toFixed(2));
            
            
        }
    )
});
$('.submitofficialreciept').submit(function(e){
    e.preventDefault()
    var or_no = $('.recieptno').val();
    var hidden_or = $('.hidden_or').val();
    var type = $('.hidden_type').val();

    
    
    var recieptnoorig = $('#recieptnoorig').val();
    $.post(baseUrl+'/updaterecieptnumber', {
        or_no: or_no,
        type: type,
        recieptnoorig: recieptnoorig,
    },
        function (data, status){
            var request = JSON.parse(data);
            console.log(request);
            if (request == 'The O.R number you want to entry successfully saved.') {
                $('#ore-modal').modal('toggle');
                toastr.info(request);
                $('.tdorno').each(function(s){
                    var scope = $(this);
                    if ($(scope).text() == hidden_or) {
                        $(scope).text(or_no);
                    }
                });
                if (type == 'pharmacy') {
                    $('.or_nom').text('MEDICINE - '+or_no);
                }else{
                    $('.or_nom').text(type+' - '+or_no);
                }
            }else{
                toastr.error(request);
            }
        }
    )
    // toastr.success('O.R.Number Updated');
    
    $('.hidden_or').val(or_no);
})



$.date = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth();
    var year = d.getFullYear();
    var monthNames = ["Jan", "Feb", "March", "Apr", "May", "June",
      "July", "Aug", "Sept", "Oct", "Nov", "Dec"
    ];   
    var date =  monthNames[month] + "-" + year;

    return date;
};
$.fulldate = function(dateObject) {
    var d = new Date(dateObject);
    var day = d.getDate();
    var month = d.getMonth();
    var year = d.getFullYear();
    var monthNames = ["01", "02", "03", "04", "05", "06",
      "07", "08", "09", "10", "11", "12"
    ];   
    var date =  monthNames[month] +"/"+day+"/"+year;

    return date;
};
$('#patient_name').keyup(function(){
    var name, filter, table, tr, td, i;
    name = document.getElementById("patient_name");
    filter = name.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[4];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }

})
// $('#hospital').keyup(function(){
//     var name, filter, table, tr, td, i;
//     name = document.getElementById("hospital");
//     filter = name.value.toUpperCase();
//     table = document.getElementById("myTable");
//     tr = table.getElementsByTagName("tr");

//     // Loop through all table rows, and hide those who don't match the search query
//     for (i = 0; i < tr.length; i++) {
//       td = tr[i].getElementsByTagName("td")[9];
//       if (td) {
//         if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
//           tr[i].style.display = "";
//         } else {
//           tr[i].style.display = "none";
//         }
//       }
//     }

// })
$('#reciept').keyup(function(){
    var name, filter, table, tr, td, i;
    name = document.getElementById("reciept");
    filter = name.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[3];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }

})
$('#transaction').keyup(function(){
    var name, filter, table, tr, td, i;
    name = document.getElementById("transaction");
    filter = name.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[5];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }

})
$(document).ready(function(){
    $('.input-group-addon').on('click', function(){
        $(this).closest('div.input-group').find('input').focus();
    });
});



$('.reprint-reciept').click(function(){
    var hidden_or = $('.hidden_or').val();
    var hidden_type = $('.hidden_type').val();
    window.open(baseUrl+'/reprint/'+hidden_or+'/'+hidden_type);
})

$(document).on('click', '#search-patient', function(){
    var scope = $(this);
    var  no = $('.hospital_no').val();
    if (no.length != 6) {
        $(scope).closest('div.form-group').attr('class', 'form-group has-error');
        $(scope).closest('div.form-group').find('.help-inline').text('The hospital number length is 6 digits');
    }else{
        request = $.ajax({
            url: baseUrl+'/searchospitalno/'+no,
            type: "get",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json"
        });
        
        request.done(function (response, textStatus, jqXHR) {
            if (response == null) {
                $(scope).closest('div.form-group').attr('class', 'form-group has-error');
                $(scope).closest('div.form-group').find('.help-inline').text('Patient not found, please try another combination');
            }else{
                $(scope).closest('div.form-group').attr('class', 'form-group has-success');
                $(scope).closest('div.form-group').find('.help-inline').attr('class', 'help-inline text-success hospital_no-error').html('<span class="fa fa-check"></span> Patient found');
                $('#refincome-modal .ptname').val(response.first_name+' '+response.middle_name+' '+response.last_name);
                $('#refincome-modal .ptname').closest('div.form-group').attr('class', 'form-group has-success');
                $('#refincome-modal .ptid').val(response.id);
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
            toastr.error('Oops! something went wrong.');
        });

        request.always(function (){
            console.log("tnx God")
        });
    }
})

$(document).on('click', '#transaction-modal .change-patient', function(){
    var id = $(this).attr('data-or');
    var type = $('.hidden_type').val();
    $('.pthtype').val(type);
    $('#changept-modal .modal-body form').attr('action', baseUrl+'/changetransactionpatient/'+id).attr('data-or', id);
    $('#changept-modal').modal('toggle')
    // alert($(this).attr('data-id'));
})

$(document).on('submit', '#changepatientform', function(e){
        e.preventDefault();

        var name = $('#changept-modal .pthname').val();
        $('#transaction-modal .namem').text(name);

        var or = $(this).attr('data-or');
        $('.transactionrow .tdorno').each(function(){
            if ($(this).text() == or) {
                $(this).closest('tr').find('.tdname').text(name);
            };
        })

        var url = $(this).attr('action');
        var data = $(this).serialize();
            request = $.ajax({
                url: url,
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data,
                dataType: "json"
            });

            request.done(function (response, textStatus, jqXHR) {
                if (response.errors) {
                    if (response.errors.patient_hospital_no) {
                        toastr.error(response.errors.patient_hospital_no);
                    }else if(response.errors.patient_name){
                        toastr.error(response.errors.patient_name);
                    }
                }else{
                    $('#changept-modal').modal('toggle');
                }
                console.log(response);  
            });
            request.fail(function (jqXHR, textStatus, errorThrown){
                console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
                 toastr.error('Oops! something went wrong.');
            });
            request.always(function (){
                console.log("To God Be The Glory...");
            });
})
$(document).on('click', '#searchhn-patient', function(){
    var scope = $(this);
    var no = $('.pth_no').val();
   
    if (no.length != 6) {
        $(scope).closest('div.form-group').attr('class', 'form-group has-error');
        $(scope).closest('div.form-group').find('.help-inline').text('The hospital number length is 6 digits');
    }else{
        request = $.ajax({
            url: baseUrl+'/searchospitalno/'+no,
            type: "get",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json"
        });
        
        request.done(function (response, textStatus, jqXHR) {
            if (response == null) {
                $(scope).closest('div.form-group').attr('class', 'form-group has-error');
                $(scope).closest('div.form-group').find('.help-inline').text('Patient not found, please try another combination');
            }else{
                $(scope).closest('div.form-group').attr('class', 'form-group has-success');
                $(scope).closest('div.form-group').find('.help-inline').attr('class', 'help-inline text-success hospital_no-error').html('<span class="fa fa-check"></span> Patient found');
                $('#changept-modal .pthname').val(response.last_name+', '+response.first_name+' '+response.middle_name);
                $('#changept-modal .pthname').closest('div.form-group').attr('class', 'form-group has-success');
                $('#changept-modal .pthid').val(response.id);              
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occurred: "+ jqXHR, textStatus, errorThrown);
            toastr.error('Oops! something went wrong.');
        });

        request.always(function (){
            console.log("tnx God")
        });
    }
})