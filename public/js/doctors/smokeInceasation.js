function smokeInceasation($pid, $scope) {


	var data_status = $($scope).attr('data-status');
	/* if status is off then insert smoke inceasation */
	if (data_status.trim() == 'off') {


		var ans = confirm('Do you want to insert smoke cessation on the consultation form?');

		if(ans){
			request = $.ajax({
				url: baseUrl+"/storeSmoke/"+$pid,
				type: "get",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			});
			request.done(function (response, textStatus, jqXHR) {
				var icd = '<strong id="smoke" class="mceNonEditable">Smoke Cessation &nbsp;</strong>';
				tinymce.activeEditor.execCommand('mceInsertContent', false, icd);


				/* change button color */
				$($scope).css('background-color','#a94442');
				$($scope).find('i').css('color','#fff');

				$($scope).attr('data-status', 'on');
			});
			request.fail(function (jqXHR, textStatus, errorThrown){
				console.log("The following error occured: "+ jqXHR, textStatus, errorThrown);
			});
			request.always(function(){
			});

		}




		

	}else{ /* else delete smoke inceasation */



		var ans = confirm('Do you want to delete smoke cessation on the consultation form?');

		if(ans) {

			request = $.ajax({
				url: baseUrl + "/deleteSmoke/" + $pid,
				type: "get",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			});
			request.done(function (response, textStatus, jqXHR) {

				tinymce.activeEditor.dom.remove(tinymce.activeEditor.dom.select('strong#smoke'));

				/* change to default button color */
				$($scope).css('background-color', '#fff');
				$($scope).find('i').css('color', '#a94442');


				$($scope).attr('data-status', 'off');

			});
			request.fail(function (jqXHR, textStatus, errorThrown) {
				console.log("The following error occured: " + jqXHR, textStatus, errorThrown);
			});
			request.always(function () {
			});
		}


		
	}
}