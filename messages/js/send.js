$(document).ready(function(){
	$('#btnSendSMS').click(function(){
		$('.window').modalBox('close');
		var message = $('#message').val();
		var to = $('#to').val();
		var url = $('form').attr('action');
		
		if ($.trim(message) == '' || $.trim(to) == '')
		{
			alert('Вы что-то не заполнили');
		}
		else
		{
			$('#btnSendSMS').attr("disabled", "disabled");
			$.ajax({
				url: url,
				type: "POST",
				data: { message : message, to : to},
			}).done(function(data){
				if (data != 1)
				{
					alert("Was an error. You message not sent: \n" + data);
				}
			});
		}
	});
	
	$('#showForm').click(function(){
		$('#results').hide();
		$('#send_form').show();
		$('#to').val('');
		$('#message').val('');
		$('#btnSendSMS').removeAttr('disabled');
		$('[id^=num_]').prop('checked', false);
	});
});

$(document).ajaxStart(function(){
	$('#send_form').hide();
	$('#process').show();
});
$(document).ajaxStop(function(){
	$('#process').hide();
	$('#results').show();
});