<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12 text-left"><?= $label; ?></label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<input type="text" id="<?= $id; ?>" name="<?= $id; ?>" class="form-control col-md-<?=$grid; ?>" <?= (isset($disabled)) ? "disabled" : "";  ?> placeholder="<?= $label; ?>">
	</div>
</div>