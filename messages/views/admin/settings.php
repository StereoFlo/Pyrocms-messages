<style type="text/css">
	label { width: 23% !important; }
</style>
<section class="title">
	<h4><?= lang('module_name'); ?></h4>
</section>

<section class="item">
<?php echo form_open('admin/messages/settings?action=save', 'class="crud"');?>
<table style="width: 450px; border: 1px solid #eee;">
	<tr>
		<td><?= lang('host'); ?>:</td>
		<td><input type=text name="host" value="<?= (isset($messages[0]->host)) ? $messages[0]->host : ""; ?>"></td>
	</tr>
	<tr>
		<td><?= lang('port'); ?>:</td>
		<td><input type='text' name="port" value="<?= (isset($messages[0]->port)) ? $messages[0]->port : ""; ?>" class="frmPass"></td>
	</tr>
	<tr>
		<td><?= lang('user'); ?>:</td>
		<td><input type=text name="user" value="<?= (isset($messages[0]->user)) ? $messages[0]->user : ""; ?>"></td>
	</tr>
	<tr>
		<td><?= lang('pass'); ?>:</td>
		<td><input type=text name="pass" value="<?= (isset($messages[0]->pass)) ? $messages[0]->pass : ""; ?>"></td>
	</tr>
	<tr>
		<td><?= lang('src_number'); ?>:</td>
		<td><input type=text name="src_number" value="<?= (isset($messages[0]->src_number)) ? $messages[0]->src_number : ""; ?>"></td>
	</tr>
	<tr>
		<td><?= lang('template'); ?>:</td>
		<td><textarea name="template"><?= (isset($messages[0]->template)) ? $messages[0]->template : ""; ?></textarea></td>
	</tr>
	<tr>
		<td>Use ajax on the frontend:</td>
		<td><?= form_dropdown('ajax', array('0' => 'No', '1' => 'Yes'), (isset($messages[0]->ajax)) ? $messages[0]->ajax : "");  ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<button class="btn blue" value="save" name="btnAction" type="submit"><span><?= lang('btnSave'); ?></span></button>
				&nbsp;&nbsp;
			<a class="btn-more" href="/admin/messages"><?= lang('btnCancel'); ?></a>
		</td>
	</tr>
</table>

<?php 
 if(isset($messages[0]->id)){
?>
<input type="hidden" name="id" value="<?= $messages[0]->id; ?>">
<?php } ?>

<?php echo form_close(); ?>
</section>