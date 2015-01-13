<h2 id="page_title" class="page-title"><?= lang('titleMessage');?></h2>
<div id="form1">
	<p>Добавить контакт в адресную книгу:</p>
	Имя: <?= form_input('name', NULL, 'placeholder="Name" id="name"'); ?> 
	Телефон: <?= form_input('phone', NULL, 'placeholder="9211234567" id="phone"'); ?>
	<?= form_button('', lang('btnSend'), 'id="btnSend"'); ?>      
</div>
<div id="result"></div>
<div id="contacts">
	<h2>Ваши контакты</h2>
	<div id="items">
	<? foreach ($contacts as $contact) { ?>
	<div id="num_<?= $contact->id ?>">
		<div class="name"><?= $contact->name ?></div>
		<div class="phone"> <?= $contact->phone ?></div>
		<div class="delete"><a href="#<?= $contact->id ?>" onclick="delete_contact(<?= $contact->id ?>);">Удалить</a></div>
	</div>
	<? } ?>
	</div>
</div>