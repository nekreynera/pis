$(document).ready(function () {

   $('#pharmacyDepartment').on('click', function (e) {

       e.preventDefault();
       $('#searchDesc').removeClass('labsSearch');
       blurTable(this);

       var clinic_code = $(this).attr('clinic-code');

       request = $.ajax({
           url: baseUrl+"/choosedepartment",
           type: "post",
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           data: {'clinic_code':clinic_code},
           dataType: "json"
       });

       request.done(function (response, textStatus, jqXHR) {
           if (response.length > 0) {
               $('.selectitemsTbody').empty();


               /*---- check if selected items id filled ----*/
               var selectedItemsOntable = $.makeArray($('.selectedItemsTbody tr').not('.noSelectedTRwrapper'));
               if(selectedItemsOntable.length > 0){
                   var arrayItemsSelect = [];
                   $(selectedItemsOntable).each(function (index) {
                       arrayItemsSelect.push($(this).find('input:checkbox').attr('data-check'));
                   });
               }
               /*---- check if selected items id filled ----*/


                $('.theadRequistion').empty();

               var theadTR = $('<tr>');
               var th1 = $('<th>').append($('<i class="fa fa-question">'));
               var th2 = $('<th>').text('ITEM ID');
               var th3 = $('<th>').text('ITEM DESCRIPTION');
               var th4 = $('<th>').text('BRAND');
               var th5 = $('<th>').text('UNIT');
               var th6 = $('<th>').text('PRICE');
               var th7 = $('<th>').text('STOCKS');
               var th8 = $('<th>').text('STATUS');
               $('.theadRequistion').append(th1,th2,th3,th4,th5,th6,th7,th8);





               for (var i = 0; i < response.length; i++) {
                   var na = $('<span class="text-danger">').text('N/A');
                   var statistic = (response[i].status == 'Y' && response[i].stock)? true : false;
                   var statColor = (statistic)? 'bg-success' : 'bg-danger';
                   var classColor = (statistic)? '' : 'text-danger';
                   var tr = $('<tr class="'+statColor+'">');
                   var td1 = $('<td>').append('<input type="checkbox" data-check="'+response[i].id+'M"' +
                       ' data-category="1031" name="" data-id="'+response[i].id+'" onclick="chooseItem($(this))" />');
                   var td2 = $('<td class="item_id ">').text(response[i].item_id);
                   var td3 = $('<td class="item_description">').text(response[i].item_description);
                   var td4 = $('<td class="item_brand '+classColor+'">').text((response[i].brand)? response[i].brand : 'N/A' );
                   var td5 = $('<td class="unitofmeasure '+classColor+'">').text((response[i].unitofmeasure)? response[i].unitofmeasure : 'N/A');
                   var td6 = $('<td class="price">').text((response[i].price)? response[i].price : 'N/A');
                   var td7 = $('<td class="stocks '+classColor+'">').text((response[i].stock)? response[i].stock : 'Out');
                   var td8 = $('<td class="status '+classColor+'">').text((statistic)? 'Available' : 'Unavailable');

                   $('.selectitemsTbody').append($(tr).append(td1,td2,td3,td4,td5,td6,td7,td8));


                   /*-- check if selected items is filled---*/
                   if(selectedItemsOntable.length > 0){
                       var isInArray = $.inArray(''+response[i].id+'M'+'', arrayItemsSelect);
                       if(isInArray != -1){
                           $(td1).find('input').attr({'checked':'true'});
                       }
                   }
                   /*-- check if selected items is filled---*/

               }
           }else{
               $('.selectitemsTbody').empty();
               var tr = '<tr><td colspan="8" class="text-center">' +
                            '<strong class="text-danger">' +
                            'No Results Found.' +
                            '</strong>' +
                        '</td></tr>';
               $('.selectitemsTbody').append(tr);
           }
           $('#countResults').text(response.length);
       });/*-- end of request dene --*/

       request.fail(function (jqXHR, textStatus, errorThrown){
           console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
       });
       request.always(function(){
           $('.loaderWrapper').fadeOut('fast');
           $('#itemsDeptTable').css({'opacity':'1'});
       });



   });



});