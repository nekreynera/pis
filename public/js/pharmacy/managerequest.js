$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
$(document).ready(function(){
	$('.th-check').change(function() {
	    if (this.checked) {
	    	var checked = $(this).prop('checked');
	    	$('tbody').find('input.td-check').prop('checked', checked);
	    	$('.submitbutton').attr('disabled', false);
		} 
		else{
			$('tbody').find('input.td-check').prop('checked', false);
			$('.submitbutton').attr('disabled', true);
		}
		$('input.td-check').each(function() {
			if (this.checked) {
				$(this).closest('tr').find('input.manage').attr("readonly", false);
				$(this).closest('tr').find('input.manage').css('cursor', 'pointer');

			}
			else{
				$(this).closest('tr').find('input.manage').attr("readonly", true);
				$(this).closest('tr').find('input.manage').css('cursor', 'not-allowed');
			}
		})
	})
	$('.td-check').change(function() {
			if (this.checked) {
				$(this).closest('tr').find('input.manage').attr("readonly", false);
				$(this).closest('tr').find('input.manage').css('cursor', 'pointer');

			}
			else{
				$(this).closest('tr').find('input.manage').attr("readonly", true);
				$(this).closest('tr').find('input.manage').css('cursor', 'not-allowed');

			}
			var what = 0;
			$('input.td-check:checked').each(function() {
				what += Number($(this).length);

			})
			if (what > 0) {
				$('.submitbutton').attr('disabled', false);
			}
			else{
				$('.submitbutton').attr('disabled', true);
			}
	})


	$('.managerequest').submit(function(e){
		var conf = confirm("are you sure???");
		var asd = 0
		if (conf) {
			$('input.td-check:checked').each(function() {
					var contents = $('.contents');
					var reqqty = Number($(this).closest('tr').find('td.reqqty').text());
					
					var qty = Number($(this).closest('tr').find('input.manage').val());
				
					if(reqqty < qty){
						$(this).closest('tr').find('td input.manage').css('border', '1px solid red');
						e.preventDefault();	
						asd++;
					}
			})
			if (asd <= 0) {
				$('input.td-check:checked').each(function() {
						var price = Number($(this).closest('tr').find('td.price').text());
						var anc_id = $(this).closest('tr').find('input.anc_id').val();
						var qty = $(this).closest('tr').find('input.manage').val();
						var contents = $('.contents');
						var ancillary_id = $("<input type='' name='anc_id[]' value="+anc_id+">");
						var inputqty = $("<input type='' name='inputqty[]' value="+qty+">");
						var id = $(this).closest('tr').find('input.item_id').val();
						var inputid = $("<input type='' name='inputid[]' value="+id+">");
						var priceid = $("<input type='' name='priceid[]' value="+price+">");
						(contents).append(inputqty, inputid, ancillary_id, priceid);
						$('.tobesubmit').append(contents);
				})
			}
		}else{
			e.preventDefault();	
		}
	})
})


