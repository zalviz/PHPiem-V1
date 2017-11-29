<div id="messages"><?= @$message; ?></div>
<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="<?= site_url(str_replace('/new', '/add', $_SERVER['REQUEST_URI'])); ?>">
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Full Name <span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="nama" name="nama" required="required" class="form-control col-md-7 col-xs-12" value="<?=@$nama; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Email <span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12" value="<?=@$email; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nohp">Phone </label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="nohp" name="nohp" class="form-control col-md-7 col-xs-12" value="<?=@$nohp; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat">Address </label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="alamat" name="alamat" class="form-control col-md-7 col-xs-12" value="<?=@$alamat; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kota">City </label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="kota" name="kota" class="form-control col-md-7 col-xs-12" value="<?=@$kota; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="instansi">Company / Campus </label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<input type="text" id="instansi" name="instansi" class="form-control col-md-7 col-xs-12" value="<?=@$instansi; ?>">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div id="kategori" class="btn-group" data-toggle="buttons">
				<?php foreach($kategori_options as $kok => $kov){ ?>
				<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
					<input type="radio" name="kategori" value="<?=$kok;?>"<?= ( $kategori == $kok ) ? ' selected' : '' ?>> &nbsp; <?=$kov;?> &nbsp;
				</label>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="ln_solid"></div>
	<div class="form-group">
		<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
			<button type="submit" class="btn btn-success">Submit</button>
			<button type="Reset" class="btn btn-primary">Cancel</button>
		</div>
	</div>
</form>