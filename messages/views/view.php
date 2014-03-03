<h2 id="page_title" class="page-title"><?=lang('view_sended_messages');?></h2>
<? if ($messages) { ?>
<div>
    <? foreach ($messages as $message) { ?>
    <div style="float: left; width: 25%">+<?= $message->to; ?></div>
    <div style="float: left; width: 25%"><?= $message->date; ?></div>
    <div style="float: left; width: 50%"><?= $message->message; ?></div>
        <? } ?>
</div>
<?= $pagination; ?>
<? } else { ?>
<p> <?= lang('no_sended_messages');?> </p>
<? } ?>