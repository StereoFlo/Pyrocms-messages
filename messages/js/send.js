$(document).ready(function(){
	$('#btnSendSMS').click(function(){
		var message = $('#message').val();
		var to = $('#to').val();
		var url = $('form').attr('action');
		
		if ($.trim(message) == '' || $.trim(to) == '')
		{
			alert('Заполните обязательные поля');
		}
		else
		{
			$.ajax({
				url: url,
				type: "POST",
				data: { message : message, to : to},
			}).done(function(data){
				if (data == 1)
				{
					$('#send_form').hide();
					$('#results').show();
				}
				else
				{
					alert("Was an error. You message do not send: \n" + data);
				}
			});
		}
	});
});