<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="FemaleGeek Surabaya - Timeline">
	<title>Event - Timeline</title>

	<!-- stylesheet -->
	<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?= base_url(); ?>assets/css/styles.css" rel="stylesheet">

</head>
<body>
	<!-- navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>assets/img/brand_white.png" alt=""></a>
			</div>
		</div>
	</nav>

	<section id="timeline">
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<h1>Timeline Registrations</h1>
				</div>
				<div class="col-md-12">
					<div class="timeline">
						<article class="timeline-entry left-aligned begin">
							<div class="timeline-entry-inner">
								<time class="timeline-time"><span>&nbsp&nbsp&nbsp23:00:00</span> <span>14 January 2017</span></time>
								<div class="timeline-icon bg-secondary">
									<span class="glyphicon glyphicon-flag"></span>
								</div>
								<div class="timeline-label">
									<h2>Registration Open</h2>
								</div>
							</div>
						</article>
					</div>
				</div>
			</div><!-- /.row -->
		</div>
	</section>

	<a href="#" class="scrolling scroll-up"><span class="glyphicon glyphicon-menu-up"></span></a>

	<footer>
		<div class="container">
			<p class="text-center">Copyright 2017 - Team PHP indo Surabaya</p>
		</div>
	</footer>

	<a href="#" class="scrolling scroll-up"><span class="glyphicon glyphicon-menu-up"></span></a>

	<!-- javascript -->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>

	<script type="text/javascript">
	$(window).on('scroll', function() {
		if($(window).scrollTop() >= 100) {
			$('.scroll-up').fadeIn();
		} else {
			$('.scroll-up').fadeOut();
		}
	}).scroll();

	$('.scroll-up').click(function(){
	$("html, body").animate({ scrollTop: 0 }, 1000);
	return false;
	});
	</script>

</body>
</html>