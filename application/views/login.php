<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!-- Meta, title, CSS, favicons, etc. -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robot" content="noindex/nofollow">

	<title>PHP Indonesia Event Management | Administrator Login</title>

	<!-- Bootstrap -->
	<link href="<?= base_url(); ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="<?= base_url(); ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="<?= base_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- Animate.css -->
	<link href="<?= base_url(); ?>vendors/animate.css/animate.min.css" rel="stylesheet">

	<!-- Custom Theme Style -->
	<link href="<?= base_url(); ?>dist/css/custom.min.css" rel="stylesheet">
</head>
<body class="login">
	<div>
		<a class="hiddenanchor" id="signup"></a>
		<a class="hiddenanchor" id="signin"></a>

		<div class="login_wrapper">
			<div class="animate form login_form">
				<section class="login_content">
					<?= form_open('login'); ?>
						<h1>Login Form</h1>
						<div>
							<input type="text" id="username" name="username" class="form-control" placeholder="Username" required />
						</div>
						<div>
							<input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
						</div>
						<div>
							<input type="submit" value="Log in" class="btn btn-default submit" />
							<a class="reset_pass" href="#">Lost your password?</a>
						</div>

						<div class="clearfix"></div>

						<div class="separator">
							<p class="change_link">New to site? <a href="#signup" class="to_register"> Create Account </a></p>
							<div class="clearfix"></div>
							<br />

							<div>
								<h1><i class="fa fa-paw"></i> PHPIEM</h1>
								<p>&copy; 2017 All Rights Reserved. <br />PHP Indonesia Event Management <br />powered by <a href="https://www.pradesga.com">Pradesga Indonesia</a></p>
							</div>
						</div>
					</form>
				</section>
			</div>

			<div id="register" class="animate form registration_form">
				<section class="login_content">
					<?= form_open('register'); ?>
						<h1>Create Account</h1>
						<div>
							<input type="text" class="form-control" placeholder="Username" required="" />
						</div>
						<div>
							<input type="email" class="form-control" placeholder="Email" required="" />
						</div>
						<div>
							<input type="password" class="form-control" placeholder="Password" required="" />
						</div>
						<div>
							<input type="submit" value="Submit" class="btn btn-default submit" />
						</div>

						<div class="clearfix"></div>

						<div class="se parator">
							<p class="change_link">Already a member ? <a href="#signin" class="to_register"> Log in </a></p>
							<div class="clearfix"></div>
							<br />

							<div>
								<h1><i class="fa fa-paw"></i> PHPIEM</h1>
								<p>&copy; 2017 All Rights Reserved. <br />PHP Indonesia Event Management <br />powered by <a href="https://www.pradesga.com">Pradesga Indonesia</a></p>
							</div>
						</div>
					</form>
				</section>
			</div>
		</div>
	</div>
</body>
</html>