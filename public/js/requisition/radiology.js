$(document).ready(function () {

    $('.laboratories').on('click', function (e) {
        e.preventDefault();

        blurTable(this);

        $('#searchDesc').addClass('labsSearch');

        var category = $(this).attr('category');
        request = $.ajax({
            url: baseUrl+"/ultrasoundWatch",
            type: "post",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {'category':category},
            dataType: "json"
        });

        request.done(function (response, textStatus, jqXHR) {

            if (response.length > 0){

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
                var th2 = $('<th>').text('DESCRIPTION');
                var th3 = $('<th>').text('PRICE');
                var th4 = $('<th>').text('STATUS');
                $('.theadRequistion').append(th1,th2,th3,th4);

                for (var i = 0; i < response.length; i++) {
                    var notApplicable = $('<span class="text-danger">').text('N/A');
                    var statistic = (response[i].status == 'active')? true : false;
                    var statColor = (statistic)? 'bg-success' : 'bg-danger';
                    var classColor = (statistic)? 'text-success' : 'text-danger';

                    var tr = $('<tr class="'+statColor+'">');
                    var td1 = $('<td>').append('<input type="checkbox" name="" data-check="'+response[i].id+'" ' +
                        'data-category="'+response[i].cashincomecategory_id+'" data-id="'+response[i].id+'" onclick="chooseItem($(this))" />');
                    var td2 = $('<td class="item_description">').text(response[i].sub_category);
                    var td3 = $('<td class="price">').text((response[i].price)? response[i].price : 'N/A');
                    var td4 = $('<td class="status '+classColor+'">').text((statistic)? 'Available' : 'Unavailable');
                    $('.selectitemsTbody').append($(tr).append(td1,td2,td3,td4));


                    /*-- check if selected items is filled---*/
                    if(selectedItemsOntable.length > 0){
                        var isInArray = $.inArray(''+response[i].id+'', arrayItemsSelect);
                        if(isInArray != -1){
                            $(td1).find('input').attr({'checked':'true'});
                        }
                    }
                    /*-- check if selected items is filled---*/



                }/*-- end of forloop --*/

            }/*-- end of if --*/
            else{
                $('.selectitemsTbody').empty();
                var tr = '<tr><td colspan="8" class="text-center">' +
                    '<strong class="text-danger">' +
                    'No Results Found.' +
                    '</strong>' +
                    '</td></tr>';
                $('.selectitemsTbody').append(tr);
            }

            $('#countResults').text(response.length);
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
        });
        request.always(function(){
            $('.loaderWrapper').fadeOut('fast');
            $('#itemsDeptTable').css({'opacity':'1'});
        });


    });




});