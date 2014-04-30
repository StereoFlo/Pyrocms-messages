<h2 id="page_title" class="page-title"><?= lang('titleMessage');?></h2>
<div>
	<div class="window">
		<h2>Записная книга</h2>
		<? if (!empty($contacts)) { ?>
		<? foreach ($contacts as $contact) { ?>
		    <p><input type="checkbox" id="num_<?= $contact->id ?>" value="<?= $contact->phone ?>" /> <label for="num_<?= $contact->id ?>"><?= $contact->name ?></label></p>
		<? } ?>
		<? } else { ?>
			<p>У вас нет контактов. <a href="/messages/book">Добавить</a></p>
		<? } ?>
		
	    <a href="#" class="AddAll">Добавить всех</a> | <a href="#" class="Clear">Очистить</a> | <a href="#" class="Close">Закрыть</a> 
	</div>
	<?php if(validation_errors()):?>
	<div class="error-box">
		<?php echo validation_errors();?>
	</div>
	<?php endif;?>
    <div id="send_form">
        <?= form_open('messages?action=send');?>
			<p>
				<label for="from"><?= lang('sender');?>:</label><br/>
				<?= form_input('from', $user_name, 'id="from" disabled="disabled"'); ?>
			</p>

			<p>
				<label for="to"><?= lang('reciver');?>:</label> (<a href="#" id="toLnk">Записная книга</a>)<br/>
				<?= form_input('to', NULL, 'id="to" autocomplete="off"'); ?>
			</p>
			<p>
				<label for="message"><?= lang('message');?>:</label>
				<?php echo form_textarea(array('name' => 'message', 'cols' => 20, 'rows' => 5, 'id' => 'message')); ?>
			</p>
		<? if ($ajax == 0) { ?>
		<?= form_submit('', lang('btnSend')); ?>
        <? } else { ?>
        <?= form_button('', lang('btnSend'), 'id="btnSendSMS"'); ?>
        <? } ?>
        <?= form_close(); ?>
    </div>
    <div id="results" style="display: none">
    	<?= lang('messageSend'); ?>
    </div>
</div>