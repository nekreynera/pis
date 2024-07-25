$(document).on('change', '.type', function(){
	var id = $(this).val();
	$.get(baseUrl+'/getuserbyclinic/'+id, {},
			function (data, status){
				var request = JSON.parse(data);
				console.log(request);
				$('.user').empty();
				var optall = '<option value="all">all</option>';
				$('.user').append(optall);
				for (var i = 0; i < request.length; i++) {
					var opt = '<option value="'+request[i].id+'">'+request[i].last_name+ ', '+request[i].first_name+' '+request[i].middle_name+'</option>';
					$('.user').append(opt);
				}
			}
		)
})
$(document).ready(function() {
    $('#reportsTable').DataTable();
});