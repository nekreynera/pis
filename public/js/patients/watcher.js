	function searchWatcher() {
        var ted = document.getElementById('searchwatcherInput').value;
        if (ted.length > 0) {
            watchersForm();
        }
    }



function watchersForm() {

			event.preventDefault();

			$('.loaderRefresh').fadeIn('fast');

			var data = $('#watchersForm').serialize();

			console.log(data);

		    request = $.ajax({
		        url: baseUrl+"/searchwatcher",
		        type: "post",
		        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        dataType: "json",
		        data: data
		    });

		    request.done(function (response, textStatus, jqXHR) {
		    	console.log(response)
		    	$('.watchersTbody').empty();
		    	if (response) {
		    		for (var i = 0; i < response.length; i++) {
		    			var tr = $('<tr>');
		    			var td1 = $('<td>').text(response[i].wName);
		    			var td2 = $('<td>').text(response[i].pName);
		    			var td3 = $('<td>').text(response[i].created_at);
		    			$('.watchersTbody').append($(tr).append(td1,td2,td3));
		    		}
		    	}else{
		    		var strong = $('<strong>').text('No Results Found');
		    		var tr = $('<tr class="bg-danger">');
		    		var td = $('<td class="text-danger text-center" colspan="3">').append(strong);
		    		$('.watchersTbody').append($(tr).append(td));
		    	}
		    });

		    request.fail(function (jqXHR, textStatus, errorThrown){
		       	console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
		   	});
			  
			request.always(function(){
				$('.loaderRefresh').fadeOut('fast');
			});

}

    