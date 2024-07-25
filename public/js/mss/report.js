$(document).ready(function(){
	$('.generatemssreport').submit(function(){
		$('.submitclassificationgenerate').css('display', 'block');
	})
})
$(document).ready(function(){
	var tot_ref = 0;
	$('.refclass').each(function(index){
		tot_ref += Number($(this).text());
	})
	$('.tot_ref').text(tot_ref);

	var tot_orig = 0;
	$('.origclass').each(function(index){
		tot_orig += Number($(this).text());
	})
	$('.tot_orig').text(tot_orig);

	var tot_cat = 0;
	$('.catclass').each(function(index){
		tot_cat += Number($(this).text());
	})
	$('.tot_cat').text(tot_cat);

	var tot_four = 0;
	$('.fourclass').each(function(index){
		tot_four += Number($(this).text());
	})
	$('.tot_four').text(tot_four);

	var tot_sect = 0;
	$('.sectclass').each(function(index){
		tot_sect += Number($(this).text());
	})
	$('.tot_sect').text(tot_sect);

	var tot_classif = 0;
	$('.classifclass').each(function(index){
		tot_classif += Number($(this).text());
	})
	$('.tot_classif').text(tot_classif);

	var tot_doh = 0;
	$('.dohclass').each(function(index){
		tot_doh += Number($(this).text());
	})
	$('.tot_doh').text(tot_doh);


	/*=============================for referral*/

})
$(window).load(function(){
	var gh = 0;
	$('.gh').each(function(index){
		gh += Number($(this).text());
	})
	$('.tot_gh').text(gh).css({'text-align': 'center', 'font-size': '12px'});

	var phpc = 0;
	$('.phpc').each(function(index){
		phpc += Number($(this).text());
	})
	$('.tot_phpc').text(phpc).css({'text-align': 'center', 'font-size': '12px'});

	var polit = 0;
	$('.polit').each(function(index){
		polit += Number($(this).text());
	})
	$('.tot_polit').text(polit).css({'text-align': 'center', 'font-size': '12px'});

	var media = 0;
	$('.media').each(function(index){
		media += Number($(this).text());
	})
	$('.tot_media').text(media).css({'text-align': 'center', 'font-size': '12px'});

	var hct = 0;
	$('.hct').each(function(index){
		hct += Number($(this).text());
	})
	$('.tot_hct').text(hct).css({'text-align': 'center', 'font-size': '12px'});

	var ngo = 0;
	$('.ngo').each(function(index){
		ngo += Number($(this).text());
	})
	$('.tot_ngo').text(ngo).css({'text-align': 'center', 'font-size': '12px'});

	var govt = 0;
	$('.govt').each(function(index){
		govt += Number($(this).text());
	})
	$('.tot_govt').text(govt).css({'text-align': 'center', 'font-size': '12px'});

	var walkin = 0;
	$('.walkin').each(function(index){
		walkin += Number($(this).text());
	})
	$('.tot_walkin').text(walkin).css({'text-align': 'center', 'font-size': '12px'});

	var other = 0;
	$('.other').each(function(index){
		other += Number($(this).text());
	})
	$('.tot_other').text(other).css({'text-align': 'center', 'font-size': '12px'});
	var tot_totalperline = 0;
	$('.tot_totalperline').each(function(index){
		tot_totalperline += Number($(this).text());
	})
	$('.tot_totals').text(tot_totalperline).css({'text-align': 'center', 'font-size': '12px'});




	var a = 0;
	$('.a').each(function(index){
		a += Number($(this).text());
	})
	$('.tot_a').text(a).css({'text-align': 'center', 'font-size': '12px'});

	var b = 0;
	$('.b').each(function(index){
		b += Number($(this).text());
	})
	$('.tot_b').text(b).css({'text-align': 'center', 'font-size': '12px'});

	var c1 = 0;
	$('.c1').each(function(index){
		c1 += Number($(this).text());
	})
	$('.tot_c1').text(c1).css({'text-align': 'center', 'font-size': '12px'});

	var c2 = 0;
	$('.c2').each(function(index){
		c2 += Number($(this).text());
	})
	$('.tot_c2').text(c2).css({'text-align': 'center', 'font-size': '12px'});

	var c3 = 0;
	$('.c3').each(function(index){
		c3 += Number($(this).text());
	})
	$('.tot_c3').text(c3).css({'text-align': 'center', 'font-size': '12px'});

	var sc = 0;
	$('.sc').each(function(index){
		sc += Number($(this).text());
	})
	$('.tot_sc').text(sc).css({'text-align': 'center', 'font-size': '12px'});

	var de = 0;
	$('.de').each(function(index){
		de += Number($(this).text());
	})
	$('.tot_de').text(de).css({'text-align': 'center', 'font-size': '12px'});

	var totals = 0;
	$('.totals').each(function(index){
		totals += Number($(this).text());
	})
	$('.tot_total').text(totals).css({'text-align': 'center', 'font-size': '12px'});

	/*===ED CLASSIFICATION*/

	var ed_c1 = 0;
	$('.ed_c1').each(function(index){
		ed_c1 += Number($(this).text());
	})
	$('.ed_tot_c1').text(ed_c1).css({'text-align': 'center', 'font-size': '12px'});

	var ed_c2 = 0;
	$('.ed_c2').each(function(index){
		ed_c2 += Number($(this).text());
	})
	$('.ed_tot_c2').text(ed_c2).css({'text-align': 'center', 'font-size': '12px'});

	var ed_c3 = 0;
	$('.ed_c3').each(function(index){
		ed_c3 += Number($(this).text());
	})
	$('.ed_tot_c3').text(ed_c3).css({'text-align': 'center', 'font-size': '12px'});


	// var ed_de = 0;
	// $('.ed_de').each(function(index){
	// 	ed_de += Number($(this).text());
	// })
	// $('.ed_tot_de').text(ed_de).css({'text-align': 'center', 'font-size': '12px'});

	var ed_totals = 0;
	$('.ed_totals').each(function(index){
		ed_totals += Number($(this).text());
	})
	$('.ed_tot_total').text(ed_totals).css({'text-align': 'center', 'font-size': '12px'});

	/*== Dependent classification*/

	var d_c1 = 0;
	$('.d_c1').each(function(index){
		d_c1 += Number($(this).text());
	})
	$('.d_tot_c1').text(d_c1).css({'text-align': 'center', 'font-size': '12px'});

	var d_c2 = 0;
	$('.d_c2').each(function(index){
		d_c2 += Number($(this).text());
	})
	$('.d_tot_c2').text(d_c2).css({'text-align': 'center', 'font-size': '12px'});


	var d_c3 = 0;
	$('.d_c3').each(function(index){
		d_c3 += Number($(this).text());
	})
	$('.d_tot_c3').text(d_c3).css({'text-align': 'center', 'font-size': '12px'});


	// var ed_de = 0;
	// $('.ed_de').each(function(index){
	// 	ed_de += Number($(this).text());
	// })
	// $('.ed_tot_de').text(ed_de).css({'text-align': 'center', 'font-size': '12px'});

	var d_totals = 0;
	$('.d_totals').each(function(index){
		d_totals += Number($(this).text());
	})
	$('.d_tot_total').text(d_totals).css({'text-align': 'center', 'font-size': '12px'});
})

