<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $label; ?> <?php if( @$require ){ ?><span class="required">*</span><?php } ?></label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<textarea id="<?= $id; ?>" name="<?= $id; ?>" class="form-control" rows="3" placeholder="<?= $label; ?>" <?= (@$require) ? 'required' : ''; ?>></textarea>
	</div>
</div>