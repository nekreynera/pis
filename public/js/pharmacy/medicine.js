$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
$(document).ready(function() {
    $('#medicine').DataTable();
});
$(document).ready(function() {
	$(document).on('click', '.edit', function(){
		id = $(this).closest('tr').find('td.idt').text();
		$.post(baseUrl+"/edititem", {
       		id: id
        },
        	function (data, status){
        		var request = JSON.parse(data);
        		$('.item_ide').val(request.item_id);
        		$('.brande').val(request.brand);
        		$('.item_descriptione').val(request.item_description);
        		$('#expire_date').val(request.expire_date);
        		$('.unitofmeasuree').val(request.unitofmeasure);
        		$('.pricee').val(request.price);
        		if (request.status == null) {
        		$('.statuse').val('N')
        		}
        		else{
        		$('.statuse').val(request.status)	

        		}
        		$('.stocke').val(request.stock)
        		$('.ids').val(request.id)
        	}
		);
		 $("#editMedicine").modal("toggle"); 
	})

	$(document).on('click', '.remove', function(){
		var scope = $(this);
		
		id = $(this).closest('tr').find('td.idt').text();

		var conf = confirm('    are you sure???\nthis cant be undone');

		if (conf) {
			$(scope).closest('tr').find('td.item_idt').css("border-left", "11px solid red");
			$(scope).closest('tr').attr('class', 'danger');
			$(scope).closest('tr').find('.actioncol a').hide();
			var span = '<a href="#" class="btn btn-warning restore btn-sm" data-toggle="tooltip" data-placement="top" title="RESTORE ITEM"><span class="fa fa-recycle"></span> RESTORE</a>';
		    $(scope).closest('tr').find('.actioncol').append(span);
			$.get(baseUrl+'/deleteitem/'+id+'', {

			},
				function (data, status){
					var request = JSON.parse(data);
				}
			)
			var total = $('.deleted').text();
		    $('.deleted').text(Number(total)+1);

			toastr.error(' Medicine Moved to trashed');
		}
	})

})
$('.editMedicine').submit(function(e){
	e.preventDefault();
	var id =  $('.ids').val();
			$('td.idt').each(function(){
				if ($(this).text() == id) {
					var abcd = $('.chooseb').text();
					if (abcd == 'ADD ') {
						var totalqty = Number($(this).siblings('td#stockid').text()) + Number($('#stocke').val());
						var inputstock = $('#stocke').val();
						var actstock = 'added';
					}else if(abcd == 'DEDUCT '){
						var totalqty = Number($(this).siblings('td#stockid').text()) - Number($('#stocke').val());
						var inputstock = '-'+$('#stocke').val();
						var actstock = 'deducted';
					}
					else{
						var totalqty = Number($(this).siblings('td#stockid').text());
						var inputstock = null;
					}
					$.get(baseUrl+'/updateditem/'+id+'', {
						id: id,
						brand: $('.brande').val(),
						item_description: $('.item_descriptione').val(),
						expire_date: $('#expire_date').val(),
						unitofmeasure: $('.unitofmeasuree').val(),
						price: $('.pricee').val(),
						status: $('.statuse').val(),
						stock: totalqty,
						inputstock: inputstock,
						actstock: actstock,
						remarks: $('.remarks').val()

						},
							function (data, status){
								var request = JSON.parse(data);
							}
					)

					$(this).siblings('td.item_idt').text($('.item_ide').val()); 
					$(this).siblings('td.brandt').text($('.brande').val()); 
					$(this).siblings('td.desct').text($('.item_descriptione').val());	
					$(this).siblings('td.unitofmeasuret').text($('.unitofmeasuree').val());
					$(this).siblings('td.pricet').text($('.pricee').val());
					$(this).siblings('td.expiredate').text($('#expire_date').val());
					if ($('.statuse').val() == 'Y') {
						var stats = 'ACTIVE';
						$(this).closest('tr').find('td.item_idt').css("border-left", "11px solid #00e600");
						var total = $('.actived').text();
						$('.actived').text(Number(total)+1);
						var totin = $('.inactived').text();
						$('.inactived').text(totin-1);

					}
					else{
						var stats = 'INACTIVE'
						$(this).closest('tr').find('td.item_idt').css("border-left", "11px solid #00e600");
						var total = $('.actived').text();
						$('.actived').text(Number(total)-1);
						var totin = $('.inactived').text();
						$('.inactived').text(Number(totin)+1);

					}
					$(this).siblings('td.statust').text(stats);
					$(this).siblings('td#stockid').text(totalqty);
					if (totalqty <= 0) {
					$(this).siblings('td.info').css('background-color', 'rgb(242, 222, 222)');
					$(this).siblings('td.danger').css('background-color', 'rgb(242, 222, 222)');
					}else{
					$(this).siblings('td.info').css('background-color', 'rgb(217, 237, 247)');
					$(this).siblings('td.danger').css('background-color', 'rgb(217, 237, 247)');	
					}
					
				}
			})
	$("#editMedicine").modal("toggle"); 
	toastr.success(''+$('.brande').val()+' Succesfully Updated');
})
$(document).ready(function () {
	$('.dropdown-menu a').on('click', function (e) {
		e.preventDefault();
			var chooseb = ($(this).text());
			$('.chooseb').text(chooseb);

		
	});
});

$(document).on('click', '.restore', function(e){

		
	e.preventDefault();
	id = $(this).closest('tr').find('td.idt').text();
	statust = $(this).closest('tr').find('td.statust').text();

	var conf = confirm("restore this medicine?")
	if (conf) {
			$.post(baseUrl+'/restoremeds', {
				id: id,
			})
			$(this).hide();
			if (statust == "ACTIVE") {
				$(this).closest('tr').find('td.item_idt').css("border-left", "11px solid #00e600");
			}else{
				$(this).closest('tr').find('td.item_idt').css("border-left", "11px solid orange");
			}
			$(this).closest('tr').attr('class', '');
			var span = '<a href="#" class="btn btn-default edit" data-toggle="tooltip" data-placement="top" title="EDIT ITEM"><span class="fa fa-pencil"></span></a>\
		                <a href="#" class="btn btn-default remove" data-toggle="tooltip" data-placement="top" title="MOVE TO TRASH"><span class="fa fa-trash"></span></a>';
		    $(this).closest('tr').find('.actioncol').append(span);
		    var total = $('.deleted').text();
		    $('.deleted').text(total-1);
	}
	toastr.success('Medicine is now restored');
})



