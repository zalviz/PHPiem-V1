<!DOCTYPE html>
<html>
<head>
<title>PHPIEM - Login</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/vendor.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/flat-admin.css">

	<!-- Theme -->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/theme/blue-sky.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/theme/blue.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/theme/red.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/theme/yellow.css">

</head>
<body>
	<div class="app app-default">

		<div class="app-container app-login">
			<div class="flex-center">
				<div class="app-header"></div>
				<div class="app-body">
					<div class="loader-container text-center">
						<div class="icon">
							<div class="sk-folding-cube">
								<div class="sk-cube1 sk-cube"></div>
								<div class="sk-cube2 sk-cube"></div>
								<div class="sk-cube4 sk-cube"></div>
								<div class="sk-cube3 sk-cube"></div>
							</div>
						</div>
						<div class="title">Logging in...</div>
					</div>
					<div class="app-block">
						<div class="app-form">
							<div class="form-header">
								<div class="app-brand"><span class="highlight">PHPIEM</span> Admin</div>
							</div>
							<?php if($msg != ''): ?>
							<div class="alert alert-warning alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
								<strong>Warning!</strong> <br><?=$msg;?>
							</div>
							<?php endif; ?>
							<?= form_open('login'); ?>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">
										<i class="fa fa-user" aria-hidden="true"></i>
									</span>
									<input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?=$username; ?>" aria-describedby="basic-addon1">
								</div>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon2">
										<i class="fa fa-key" aria-hidden="true"></i>
									</span>
									<input type="password" name="password" id="password" class="form-control" placeholder="Password" aria-describedby="basic-addon2">
								</div>
								<div class="text-center">
									<input type="submit" class="btn btn-success btn-submit" value="Login">
								</div>
							</form>

							<div class="form-line"></div>
							<div class="form-footer"></div>
						</div>
					</div>
				</div>
				<div class="app-footer"></div>
			</div>
		</div>

	</div>
</body>
</html>