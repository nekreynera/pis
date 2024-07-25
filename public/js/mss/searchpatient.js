$(document).ready(function() {
    $('#unprintedTable').DataTable();
});
$(document).ready(function () {
	$('.dropdown-menu a').on('click', function () {
		event.preventDefault();
		var filter = $(this).attr('class');
		switch(filter){
			case 'birthday':
				$('#searchInput').attr({'type':'date','placeholder':'Search For Patient Birthday...','name':'birthday'});
				break;
			case 'barcode':
				$('#searchInput').attr({'type':'text','placeholder':'Search For Patient Barcode...','name':'barcode'});
				break;
			case 'hospital_no':
				$('#searchInput').attr({'type':'text','placeholder':'Search For Patient Hospital No#...,','name':'hospital_no'});
				break;
			case 'created_at':
				$('#searchInput').attr({'type':'date','placeholder':'Search For Patient Registered Date...','name':'created_at'});
				break;
			default :
				$('#searchInput').attr({'type':'text','placeholder':'Search For Patient Name...','name':'name'});

		}
	});
});

