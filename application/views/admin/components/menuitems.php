
<li>
	<a><i class="fa fa-<?= (isset($icon)) ? @$icon : 'edit'; ?>"></i> <?= @$label; ?> <span class="fa fa-chevron-down"></span></a>
	<ul class="nav child_menu">
		<?php foreach ($child as $k => $v) { ?>
			<li><a href="<?=$v['url']; ?>"><?=$v['label']; ?></a></li>
		<?php } ?>
	</ul>
</li>