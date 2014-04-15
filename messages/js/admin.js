$(document).ready(function(){
	$('[id^=block_]').click(function(){
		var ids = $(this).attr("id");
		var messageDID = $('#' + ids).attr("messageID");
		var userDID = $('#' + ids).attr("userID");
		if (messageDID.length == 0 || userDID.length == 0)
		{
			alert('messageID or userID is not specified');
		}
		else
		{
			$.ajax({
			    type: "POST",
			    url: "/admin/messages/block/ajax_block",
			    data: { messageID: messageDID, userID: userDID }
			}).done(function(data){
				if (data == 1)
				{
					$('tr[id="tr_' + messageDID + '"]').hide("slow");
				}
			});	
		}	
	});
});