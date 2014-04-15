<section class="title">
	<h4><?= lang('view_sended_messages'); ?></h4>
</section>
<section class="item">
<table>
	<tr>
		<th>Пользователь</th>
		<th>Причина (Сообщение, за которое заблокирован)</th>
		<th>Управление</th>
	</tr>
	<? foreach ($blocked as $result) { ?>
	<tr>
		<td>
			<a href="/admin/messages/view/user/<?= $result["user_id"]; ?>/"><?= $result["user_name"]; ?></a>
		</td>
		<td>
			<?= $result["message_content"]; ?>
		</td>
		<td><?= anchor('/admin/messages/block/unblock/' . $result["user_id"],'Unblock');?></td>
	</tr>
	<? } ?>
</table>
</section>