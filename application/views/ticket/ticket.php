<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Ticket SDD 2017</title>
	<style type="text/css" media="screen">
	body {
		font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		font-size: 14px;
		line-height: 1.42857143;
		color: #333;
		background-color: #fff;
		margin: 0;
		padding: 0;
	}
	h1,
	h2,
	h3 {
		font-weight: 500;
		line-height: 1.1;
		margin-top: 20px;
		margin-bottom: 10px;
	}
	p {
		margin: 0 0 10px;
	}
	.text-muted {
		color: #777;
	}
	.bordered {
		border: 1px solid #ddd;
	}

	#ticket {
		width: 7.02in;
		height: 4.3in;
		padding: 15px;
		background-image: url(<?=$ticket;?>);
		background-repeat: no-repeat;
	}
	#ticket .ticket-body {
		width: 4.2in;
		height: 4.22in;
	}
	#ticket .ticket-side {
		position: absolute;
		right: 15px;
		top: 15px;
		width: 2.45in;
		height: 4.22in;
	}
	#ticket .ticket-brand img {
		width: 279px;
	}
	#ticket .ticket-qrcode {
		margin-top: 25px;
		text-align: center;
	}
	#ticket .ticket-qrcode img {
		width: 80%;
	}
	#ticket .ticket-qrcode p {
		margin-top: 10px;
	}
	#ticket .ticket-title h3,
	#ticket .ticket-speaker h3,
	#ticket .ticket-time h3,
	#ticket .ticket-location h3,
	#ticket .ticket-attendee h3 {
		margin-bottom: 0px;
	}
	#ticket .ticket-title h1 {
		margin-top: 0;
	}
	</style>
</head>
<body>

	<section id="ticket">
		<div class="ticket-body">
			<div class="ticket-brand">
				<img src="<?=$logo;?>">
			</div>
			<div class="ticket-title">
				<h3 class="text-muted">Event</h3>
				<h1><?=$event_name;?></h1>
			</div>
			<div class="ticket-speaker">
				<?=$description;?>
			</div>
			<div class="ticket-time">
				<h3 class="text-muted">Date and Time</h3>
					<?=$event_from;?>
				</div>
			<div class="ticket-location">
			<h3 class="text-muted">Location</h3>
			<?=$event_venue;?>
			</div>
		</div>

		<div class="ticket-side">
			<div class="ticket-qrcode">
				<img src="<?=@$qrcode;?>">
				<p>Scan this QR code at the event to check in.</p>
			</div>
			<div class="ticket-attendee">
				<h3 class="text-muted">Attendee</h3>
				<?=@$ticket_code;?><br>
				<?=@$full_name?><br>
				<?=@$email;?><br>
				<?=@$city;?>
			</div>
		</div>
	</section>

</body>
</html>