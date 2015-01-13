		$(document).ready(function(){
			
			/*
			Отправляем данные в адресную
			книгу
			*/
			
			$('#btnSend').click(function(){
				var name = $('#name').val();
				var phone = $('#phone').val();
				if ($.trim(name) == '' || $.trim(phone) == '')
				{
					alert('Поля Имя или Телефон не заполнены');
				}
				else {
					$.ajax({
						url: '/messages/book/save',
						type: "POST",
						data: { name : name, phone : phone},
					}).done(function(data){
						if (data == 1)
						{
							var content = $('#items').html();
							$('#items').html(content+'<div class="name">' + name + '</div><div class="phone">' + phone + '</div><div class="delete"></div>');
						}
						else
						{
							$('#result').html(data);
						}
					});
					$('#name').val('');
					$('#phone').val('');
				}
			});
			
			/*
			открываем адресную книгу
			*/
				
			$(document).ready(function(){
				$('#toLnk').click(function(){
					$('.window').modalBox({
						width: '280px'
					});
				});
			});
		    
		    /*
		    Закрываем адресную книгу
		    и очищаем результаты
		    */
		    
		    $('a.Close').click(function(){
		        $('.window').modalBox('close');
		    });
		    
		    /*
		    Очищаем результаты из
		    поля "кому" и снимаем галочки
		    */
		    
		    $('a.Clear').click(function(){
		    	$('#to').val('');
		    	$('[id^=num_]').prop('checked', false);
		    });
		    
		    /*
		    Добавляем все контакты в 
		    адресную книгу и ставим галочки
		    */
		    
		    $('a.AddAll').click(function(){
		    	//alert('Пока не работает =)');
		    	 $('[id^=num_]').each(function(){
		    	 	var number = $(this).attr('value');
				    	var l = $('#to').val();
				    	if (l == 0)
				    	{
				    		$('#to').val(number);
				    	}
				    	else
				    	{
				    		$('#to').val($('#to').val() + ', ' + number);
				    	}	
				  $(this).prop('checked', true);
		    	 });
		    });
		    
		    /*
		    Добавляем в поле "кому" выбранные контакты по одному
		    */
		    
		    $('[id^=num_]').change(function(){
		    	var number = $(this).attr('value');
		    	if($(this).is(":checked"))
		    	{
			    	var l = $('#to').val();
			    	if (l == 0)
			    	{
			    		$('#to').val(number);
			    	}
			    	else
			    	{
			    		$('#to').val($('#to').val() + ', ' + number);
			    	}	
		    	}
		    	else
		    	{
		    		if ($('#to').attr('value').match(', ' + number)){
			    		$('#to').each(function(){
			    			$(this).val($(this).val().replace(', ' + number, ''))
			    		});
		    		}
		    		else if ($('#to').attr('value').match(number+ ', ')) {
			    		$('#to').each(function(){
			    			$(this).val($(this).val().replace(number + ', ', ''))
			    		});
		    		}
		    		else if ($('#to').attr('value').match(number)) {
			    		$('#to').each(function(){
			    			$(this).val($(this).val().replace(number, ''))
			    		});
		    		}
		    	}    	
		    });
		});
		
		/*
		Удаление контакта из адресной книги
		*/
		
		function delete_contact (id)
		{
			$.ajax({
				url: '/messages/book/delete',
				type: 'POST',
				data: { id: id },
			}).done(function(data){
				if (data == 1){
					$('#num_' + id).hide();
				} else {
					alert('was an Error id = ' + id);
				}
			});
		}