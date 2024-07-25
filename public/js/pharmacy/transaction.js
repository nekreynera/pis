
$(document).ready(function() {
    $('#transaction').DataTable();
});
$(document).ready(function() {
    $('#infos').removeAttr('class');
    $('th').click(function() {
    	$('#infos').removeAttr('class');
    });
    $('.logs-info').click(function() {
    	var from = $('.frominput').val();
    	var to = $('.toinput').val();
        var or_no = $(this).find('.info-icon').attr('id');
    	var modifier = $(this).find('.info-icon').attr('modifier');
    			$.post(baseUrl+"/getusertransaction", {
    	       		from: from,
    	       		to: to,
                    or_no: or_no,
    	       		modifier: modifier,
    	        },
    	        	function (data, status){
                        $('.tbodysidenav').empty();
    	        		var request = JSON.parse(data);
    	        			$('.names').text(request[0].patient_name);
    	        			$('.classifications').text(request[0].label+'-'+request[0].description+'% '+request[0].or_no);
    	        			$('.addresss').text(request[0].address);
                            $('.ages').text(request[0].age);
    	        		for (var i = 0; i < request.length; i++) {
    	        			var tr = $('<tr>');
    	        			var td1 = $('<td>').text(request[i].brand);
    	        			var td2 = $('<td>').text(request[i].item_description);
    	        			var td3 = $('<td>').text(request[i].unitofmeasure);
    	        			var td4 = $('<td align="right">').text((request[i].price).toFixed(2));
    	        			var td5 = $('<td>').text(request[i].qty);
    	        			var td6 = $('<td align="right">').text((request[i].discount_price).toFixed(2));
    	        			var td7 = $('<td align="right">').text((request[i].paid).toFixed(2));
    	        			var tr2 = $("<tr/>");
    	        			$(tr).append(td1,td2,td3,td4,td5,td6,td7,tr2);
    	        			$('.tbodysidenav').append(tr);
    	        		}
    	        	}
    			);
    	$('#mySidenav').css('width', '500px');

    })
    $('.closebtn').click(function() {
    	
    	$('#mySidenav').css('width', '0');
    	$('.tbodysidenav').empty();
    })

});
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
// function openNav() {
//     document.getElementById("mySidenav").style.width = "250px";
// }

// function closeNav() {
//     document.getElementById("mySidenav").style.width = "0";
// }
