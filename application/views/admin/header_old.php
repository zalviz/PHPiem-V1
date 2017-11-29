<!DOCTYPE html>
<html>
<head>
	<title>PHPIEM</title>
	<meta name="robots" content="noindex, nofollow">
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
<div class="app app-blue-sky">
	<aside class="app-sidebar" id="sidebar">
		<div class="sidebar-header">
			<a class="sidebar-brand" href="/backpanel"><span class="highlight">PHPI</span> EM</a>
			<button type="button" class="sidebar-toggle"><i class="fa fa-times"></i></button>
		</div>
		<div class="sidebar-menu">
			<ul class="sidebar-nav">
				<li class="active">
					<a href="./index.html">
						<div class="icon"><i class="fa fa-tasks" aria-hidden="true"></i></div>
						<div class="title">Dashboard</div>
					</a>
				</li>
				<li class="@@menu.messaging">
					<a href="./messaging.html">
						<div class="icon"><i class="fa fa-comments" aria-hidden="true"></i></div>
						<div class="title">Messaging</div>
					</a>
				</li>
				<li class="dropdown ">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<div class="icon"><i class="fa fa-cube" aria-hidden="true"></i></div>
						<div class="title">UI Kits</div>
					</a>
					<div class="dropdown-menu">
						<ul>
							<li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> UI Kits</li>
							<li><a href="./uikits/customize.html">Customize</a></li>
							<li><a href="./uikits/components.html">Components</a></li>
							<li><a href="./uikits/card.html">Card</a></li>
							<li><a href="./uikits/form.html">Form</a></li>
							<li><a href="./uikits/table.html">Table</a></li>
							<li><a href="./uikits/icons.html">Icons</a></li>
							<li class="line"></li>
							<li class="section"><i class="fa fa-file-o" aria-hidden="true"></i> Advanced Components</li>
							<li><a href="./uikits/pricing-table.html">Pricing Table</a></li>
							<!-- <li><a href="./uikits/timeline.html">Timeline</a></li> -->
							<li><a href="./uikits/chart.html">Chart</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
		<div class="sidebar-footer">
			<ul class="menu">
				<li><a href="/"><i class="fa fa-cogs" aria-hidden="true"></i></a></li>
			</ul>
		</div>
	</aside>
	<div class="app-container">
		<nav class="navbar navbar-default" id="navbar">
			<div class="container-fluid">
				<div class="navbar-collapse collapse in">
					<ul class="nav navbar-nav navbar-mobile">
						<li>
							<button type="button" class="sidebar-toggle"><i class="fa fa-bars"></i></button>
						</li>
						<li class="logo">
							<a class="navbar-brand" href="#"><span class="highlight">PHPI</span> EM</a>
						</li>
						<li>
							<button type="button" class="navbar-toggle">
								<img class="profile-img" src="./assets/images/profile.png">
							</button>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-left">
						<li class="navbar-title">Dashboard</li>
						<li class="navbar-search hidden-sm">
							<input id="search" type="text" placeholder="Search..">
							<button class="btn-search"><i class="fa fa-search"></i></button>
						</li>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown profile">
							<a href="/html/pages/profile.html" class="dropdown-toggle"  data-toggle="dropdown">
								<img class="profile-img" src="<?= base_url(); ?>assets/images/profile.png">
								<div class="title">Profile</div>
							</a>
							<div class="dropdown-menu">
								<div class="profile-info">
									<h4 class="username">Scott White</h4>
								</div>
								<ul class="action">
									<li><a href="#">Profile</a></li>
									<li><a href="#"><span class="badge badge-danger pull-right">5</span>My Inbox</a></li>
									<li><a href="#">Setting</a></li>
									<li><a href="#">Logout</a></li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>