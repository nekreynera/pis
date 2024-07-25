$(document).ready(function() {
    $('#logs').DataTable();
    $('#infos').removeAttr('class');
    $('th').click(function() {
    	$('#infos').removeAttr('class');
    });
    $('.logs-info').click(function() {
    		// alert($(this).find('.info-icon').attr('id'));
    		var item_id = $(this).find('.info-icon').attr('id');
    		$.post(baseUrl+"/getItemstatus", {
	       		item_id: item_id,
	        },
	        	function (data, status){
	        		var request = JSON.parse(data);
                    $('.names').text(request.name);
                    $('.actions').text(request.action);
                    $('.itemcodes').text(request.item_id);
                    $('.brands').text(request.brand);
                    $('.genericnames').text(request.item_description);
                    $('.expires').text(request.expire_date);
                    $('.stocks').text(request.stock);
	        		$('.expires').text(request.expire_date);
                    if (request.status == 'Y') {
                        $('.statuss').text('ACTIVE');
                    }
                    else{
                        $('.statuss').text('NOT ACTIVE');
	        	      }
                    }
			);
        	$('#mySidenav').css('width', '500px');
        })
        $('.closebtn').click(function() {
        	$('#mySidenav').css('width', '0');
        })
});
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
