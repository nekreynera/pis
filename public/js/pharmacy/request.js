$(document).ready(function() {
	var totalamount = 0;
	$('.amountc').each(function() {
		totalamount += Number($(this).text());
		
	});
	$('.total_amount').text(totalamount.toFixed(2)).css('text-align', 'right');

	var totaldiscount = 0;
	$('.discountc').each(function() {
		totaldiscount += Number($(this).text());
	});
	$('.total_discount').text(totaldiscount.toFixed(2)).css('text-align', 'right');

	var totalnetamount = 0;
	$('.netamountc').each(function() {
		totalnetamount += Number($(this).text());
		// alert(totalnetamount);
	});
	$('.total_netamount').text(totalnetamount.toFixed(2)).css('text-align', 'right');
	
})