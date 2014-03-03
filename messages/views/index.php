<h2 id="page_title" class="page-title"><?= lang('titleMessage');?></h2>
<div>
	<?php if(validation_errors()):?>
	<div class="error-box">
		<?php echo validation_errors();?>
	</div>
	<?php endif;?>
        
        <?= form_open('messages?action=send');?>

			<p>
				<label for="first_name"><?= lang('sender');?>:</label><br/>
				<?= form_input('from', $user_name, 'disabled="disabled"'); ?>
			</p>

			<p>
				<label for="last_name"><?= lang('reciver');?>:</label><br/>
				<?= form_input('to'); ?>
			</p>
			<p>
				<label for="display_name"><?= lang('message');?>:</label>
				<?php echo form_textarea(array('name' => 'message', 'cols' => 20, 'rows' => 5)); ?>
			</p>
        <?= form_submit('', lang('btnSend')); ?>
        <?= form_close(); ?>
</div>