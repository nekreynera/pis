$(document).ready(function() {
    $('#services').DataTable();
});


$(document).on('click', '.editservice', function(){
	var id = $(this).closest('tr').find('.idt').text();
			$.get(baseUrl+"/ancillary/"+id, {
	       		// id: id
	        },
	        	function (data, status){
	        		var request = JSON.parse(data);
	        		console.log(request);
	        		$('.type').val(request.cashincomecategory_id);
	        		$('.sub_category').val(request.sub_category);
	        		$('.price').val(request.price.toFixed(2)).css('text-align', 'right');
	        		$('.status').val(request.status);
	        		$('.type').val(request.type);
	        		$('.hidden_id').val(request.id);
	        		
	        	}
			);
	$('#editservice').modal('toggle');
})
$(document).on('submit', '.editservicemodal', function(e){
	e.preventDefault();
	var sub_category = $('.sub_category').val();
	var type = $('.type').val();
	var price = $('.price').val();
	var status = $('.status').val();
	var type = $('.type').val();
	var hidden_id = $('.hidden_id').val();
			$.post(baseUrl+"/editservice", {
	       		sub_category: sub_category,
	       		type: type,
	       		price: price,
	       		status: status,
	       		status: status,
	       		type: type,
	       		hidden_id: hidden_id,

	        },
	        	function (data, status){
	        		var request = JSON.parse(data);
	        		console.log(request);
	        		
	        		
	        	}
	        	
			);
	        	$('td.idt').each(function(){
					if ($(this).text() == hidden_id) {
						$(this).siblings('td.sub_categorytd').text(sub_category); 
						$(this).siblings('td.pricetd').text(price); 
						if (status == 'active') {
						$(this).siblings('td#statustd').text(status).attr('class', 'success');	
						}
						if (status == 'inactive') {
						$(this).siblings('td#statustd').text(status).attr('class', 'warning');	
						}
						if (type == '1') {
						$(this).siblings('td.typetd').text('SUPPLY');	
						}else{
						$(this).siblings('td.typetd').text('SERVICE');	
						}
					}
				});
	$('#editservice').modal('toggle');
	toastr.success('Service updated');
})
// $(document).on('click', '.removeservice', function(e){
// 	var id = $(this).closest('tr').find('.idt').text(); 
// 	$(this).closest('tr').hide();
// 			$.post(baseUrl+"/movetotrash", {
// 	       		id: id,
// 	        },
// 	        	function (data, status){
// 	        		var request = JSON.parse(data);
// 	        		console.log(request);
	        		
	        		
// 	        	}
	        	
// 			);

// })