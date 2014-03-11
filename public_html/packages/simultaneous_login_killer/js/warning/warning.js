var isAlreadyProcessing = false;
$('#warning-agree').on('submit', function(e){
	if (!isAlreadyProcessing) {
		isAlreadyProcessing = true;
		$this = $(this);
		$.ajax({
			type: 'POST',
			url: WARNING_TOOL_URL,
			dataType: 'json',
			data: {
				'warning': 'read'
			},
			beforeSend:function(){
					   // this is where we append a loading image
					   $this.find('div.throbber').show();
					}
				})
		.done(function(data, status, obj) {
					// do something on success
					switch (data.success) {
						case false:
						alert(data.message);
						break;

						case true:
							$.colorbox.remove();
							break;

							default:
						// Nothing special
					}

				})
		.always(function() {
					// something that will always run
					isAlreadyProcessing = false;
					$this.find('div.throbber').hide();
				})
		.fail(function(jqXHR, textStatus, errorThrown){
			if (textStatus === 'parsererror') {
				alert('Requested JSON parse failed.');
			} else if (textStatus === 'timeout') {
				alert('Time out error.');
			} else if (textStatus === 'abort') {
				alert('Ajax request aborted.');
			} else if (jqXHR.status === 0) {
				alert('Not connect.\n Verify Network.');
			} else if (jqXHR.status == 404) {
				alert('Requested page not found. [404]');
			} else if (jqXHR.status == 500) {
				alert('Internal Server Error [500].');
			} else {
				alert('Uncaught Error.\n' + jqXHR.responseText);
			}
		});
	}

	e.preventDefault();
});