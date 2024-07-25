$(document).ready(function(){
	$('.rentedcheck').change(function(){
		if (this.checked) {
			$('.rentedtext').focus();
		}
	})
	$('.rentedtext').keyup(function(){
		var rented = ('rented-'+$(this).val());
		$('.rentedcheck').val(rented);
	})

	$('.electriccheck').change(function(){
		if (this.checked) {
			$('.electrictext').focus();
		}
	})
	$('.electrictext').keyup(function(){
		var rented = ('electric-'+$(this).val());
		$('.electriccheck').val(rented);
	})

	$('.candlecheck').change(function(){
		if (this.checked) {
			$('.candletext').focus();
		}
	})
	$('.candletext').keyup(function(){
		var rented = ('candle-'+$(this).val());
		$('.candlecheck').val(rented);
	})

	$('.kerosenecheck').change(function(){
		if (this.checked) {
			$('.kerosenetext').focus();
		}
	})
	$('.kerosenetext').keyup(function(){
		var rented = ('kerosene-'+$(this).val());
		$('.kerosenecheck').val(rented);
	})

	$('.publicchecked').change(function(){
		if (this.checked) {
			$('.publictext').focus();
		}
	})
	$('.publictext').keyup(function(){
		var rented = ('public-'+$(this).val());
		$('.publicchecked').val(rented);
	})

	$('.ownedwcheck').change(function(){
		if (this.checked) {
			$('.ownedwtext').focus();
		}
	})
	$('.ownedwtext').keyup(function(){
		var rented = ('owned-'+$(this).val());
		$('.ownedwcheck').val(rented);
	})

	$('.wdcheck').change(function(){
		if (this.checked) {
			$('.wdtext').focus();
		}
	})
	$('.wdtext').keyup(function(){
		var rented = ('water_distric-'+$(this).val());
		$('.wdcheck').val(rented);
	})

	// $('input[name="mlkstsect"]').change(function(){
	// 	if (this.checked) {
	// 		var ini = $('.mlkstsectorial').val();
	// 		$('.mlkstsectorial').val(ini+''+$(this).val()+',');
	// 	}
	// 	else{
	// 		// var ini = $('.mlkstsectorial').val();
	// 		// $('.mlkstsectorial').val(ini+','+$(this).val());
	// 	}
	// })


})