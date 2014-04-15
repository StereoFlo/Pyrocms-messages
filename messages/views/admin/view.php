
<section class="title">
	<h4><?= lang('view_sended_messages'); ?> (<?= $count;?>)</h4>
</section>
<section class="item">
<? if (!empty($messages)) { ?>
<div id="filter-stage">
			<table border="0" class="table-list">
				<thead>
					<tr>
						<th><?= lang('sender'); ?></th>
						<th><?= lang('reciver'); ?></th>
						<th><?= lang('sender_ip'); ?></th>
						<th width="200"><?= lang('message'); ?></th>
						<th><?= lang('date'); ?></th>
						<th width="200"><?= lang('manage'); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="8">
							<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
					<?php $link_profiles = Settings::get('enable_profiles'); ?>
					<?php foreach ($messages as $message): ?>
						<tr id="tr_<?= $message->id; ?>">
							<td class="collapse"><a href="/admin/messages/view/user/<?= $message->from_id; ?>/"><?= $message->from; ?></a> 
							[ <div style="display: inline; cursor: pointer;" id="block_<?= $message->id; ?>" messageID="<?= $message->id; ?>" userID="<?= $message->from_id; ?>">Block</div> ]</td> 
							<? /*href="<?= base_url('/admin/messages/block/block/'. $message->from_id . '/' . $message->id ) ?>"*/ ?>
							<td><?= $message->to; ?></td>
							<td class="collapse"><?= $message->ip; ?></td>
							<td class="collapse"><?= $message->message; ?></td>
							<td class="collapse"><?= $message->date; ?></td>
							<td class="actions">
								<?php echo anchor('admin/messages/delete/' . $message->id, lang('global:delete'), array('class'=>'button delete')); ?>
							</td>
							</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
</div>
<? } else { ?>
    <div class="no_data"><?= lang('no_sended_messages'); ?></div>
<? } ?>

</section>