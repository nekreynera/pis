$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});

$(document).ready(function() {
    $('#transaction').DataTable();
    $(document).on('click', '.edit', function(){
    	$('.qtye').attr('type', 'hidden');
    	$('.tdqty').css('display', 'block');
    	$(this).closest('tr').find('.tdqty').css('display', 'none');
    	var input = $(this).closest('tr').find('.qtye');
    	var qty = $(this).closest('tr').find('.tdqty').text();
    	$(input).attr('type', 'number').val(qty).focus();
    });
    $(document).on('submit', '.submitqty', function(e){
    	e.preventDefault();
    	var id = $(this).attr('id');
    	var qtyinput = $('#qtyinput'+id).val();
    	$('#qtyid'+id).text(qtyinput).css('display', 'block');
    	$('#qtyinput'+id).attr('type', 'hidden');
    	    		$.post(baseUrl+"/updatemanageqty", {
    		       		id: id,
    		       		qtyinput: qtyinput
    		        },
                        function (data, status){
                            var request = JSON.parse(data);
                            // alert(console.log(request));
                        }
    				);
    });
    $(document).on('click', '.remove', function(){
    	var conf = confirm('are you sure?')
    	if (conf) {
    		var id = $(this).attr('id');
    		$(this).closest('tr').hide();
    		    		$.post(baseUrl+"/deletemanageqty", {
    			       		id: id,
    			        });
    	}
    })
    // $(document).on('blur', '.qtye', function(){
    // 	$('.submitqty').submit();
    // 	alert($(this).val());
    // })
});

