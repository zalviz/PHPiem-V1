
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="PHP INDONESIA Surabaya - Home">
  <title>PHP INDONESIA Surabaya - Home</title>

  <!-- stylesheet -->
  <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/css/styles.css" rel="stylesheet">

</head>
<body>

  <!-- navigation -->
  <nav class="navbar navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <!--<a class="navbar-brand" href=""><img src="assets/img/brand_white.png" alt=""></a>-->
      </div>
    </div>
  </nav>

  <header id="my-carousel" class="carousel slide">
    <!-- indicators -->
    <ol class="carousel-indicators visible-xs">
      <li data-target="#my-carousel" data-slide-to="0" class="active"></li>
      <li data-target="#my-carousel" data-slide-to="1"></li>
      <li data-target="#my-carousel" data-slide-to="2"></li>
      <li data-target="#my-carousel" data-slide-to="3"></li>
    </ol>

    <!-- carousel -->
    <div class="carousel-inner">
      <div class="item active">
        <div class="fill" style="background-image: url('<?= base_url(); ?>assets/img/four.jpg');">
          <div class="hero">
            <div class="container">
              <h2>Events</h2>
              <img class="img-thumbnail" border="0" src="<?= base_url(); ?>img/SDD2017.jpg" style="border: none">
              <p>Technology and Innovation - PHP INDONESIA Surabaya at Dyandra Convention Center Surabaya</p>
              <button class="btn btn-transparent btn-lg scroll-register" type="button">Register</button>
              <a class="btn btn-transparent btn-lg" href="timeline.php" role="button">Timeline</a>
            </div>
          </div><!-- ./hero -->
        </div>
      </div>
      <div class="item">
        <div class="fill" style="background-image: url('<?= base_url(); ?>assets/img/one.jpg');">
          <div class="hero">
            <div class="container">
              <h2>Jennifer International (Korea)</h2>
              <a href="http://jennifersoft.com"><img class="img-thumbnail" border="0" src="<?= base_url(); ?>img/jennifer-logo2.png" style="background-color: #d45b62; border: none"></a><br />SPONSOR
                          </div>
          </div><!-- ./hero -->
        </div>
      </div>
      <div class="item">
        <div class="fill" style="background-image: url('<?= base_url(); ?>assets/img/two.jpg');">
          <div class="hero">
            <div class="container">
              <h2>Supported</h2>
              <img class="img-thumbnail" src="<?= base_url(); ?>img/midtrans-logo.png"> <img class="<?= base_url(); ?>img-thumbnail" src="<?= base_url(); ?>img/pinjam.jpg"> <img class="img-thumbnail" src="<?= base_url(); ?>img/logo-qwords.png"><br /><br />
              <img class="img-thumbnail" src="<?= base_url(); ?>img/hellow.png"> <img class="img-thumbnail" src="<?= base_url(); ?>img/pradesga.png">
              <br />
            </div>
          </div><!-- ./hero -->
        </div>
      </div>
      <div class="item">
        <div class="fill" style="background-image: url('<?= base_url(); ?>assets/img/three.jpg');">
          <div class="hero">
            <div class="container">
              <h2>MEDIA PARTNER</h2>
              <img class="img-thumbnail" src="<?= base_url(); ?>img/tia.png"><br /><br />
              <img class="img-thumbnail" src="<?= base_url(); ?>img/new_logo.png"> <img class="img-thumbnail" src="<?= base_url(); ?>img/unduhan.png"> <img class="img-thumbnail" src="<?= base_url(); ?>img/dilo.png">
            </div>
          </div><!-- ./hero -->
        </div>
      </div>
      <div class="item">
        <div class="fill" style="background-image: url('<?= base_url(); ?>assets/img/five.jpg');">
          <div class="hero">
            <div class="container">
              <h2>Community Supported</h2>
                <img class="img-thumbnail" src="<?= base_url(); ?>img/SHL.jpg">
              <br />
            </div>
          </div><!-- ./hero -->
        </div>
      </div>      
    </div>

    <!-- controls -->
    <a class="left carousel-control hidden-xs" href="#my-carousel" data-slide="prev">
      <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control hidden-xs" href="#my-carousel" data-slide="next">
      <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    <a class="down carousel-control hidden-xs floating-arrow scroll-about" href="#">
      <span class="glyphicon glyphicon-menu-down" aria-hidden="true"></span>
    </a>
  </header>

  <section id="about">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1>Hi Youths in Surabaya! Here's a good news!</h1>
          <p class="slogan">For you who have a passion in IT, we are from PHP Indonesia Surabaya and Female Geek Surabaya proudly present this event for you "Technology and Innovation".</p>
          <button class="btn btn-success btn-lg scroll-register" type="button">Register Now</button>
        </div>
      </div><!-- /.row -->
    </div>
  </section>

  <section id="speaker">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1>Speakers of the Event</h1>
          <p class="slogan">We have speakers who are experts in theirs fields.</p>
          <div class="row center-block">
            <div class="col-sm-4 text-center">
              <img class="img-circle img-thumbnail" src="<?= base_url(); ?>assets/img/ridhuan.jpg">
              <h3>Ridhuan Daniel</h3>
              <p><em>ERP Adempiere</em></p>
            </div>
            <div class="col-sm-4 text-center">
              <img class="img-circle img-thumbnail" src="<?= base_url(); ?>assets/img/albert.jpg">
              <h3>Albert Sudiro</h3>
              <p><em>Linkedln Indonesia</em></p>
            </div>
            <div class="col-sm-4 text-center">
              <img class="img-circle img-thumbnail" src="<?= base_url(); ?>assets/img/irfanbli.jpg">
              <h3>Irfan Maulana</h3>
              <p><em>Blibli.com</em></p>
            </div>
            <div class="col-sm-4 text-center">
              <img class="img-circle img-thumbnail" src="<?= base_url(); ?>assets/img/Elishatan.jpg">
              <h3>Elisha Tan</h3>
              <p><em>Facebook</em></p>
            </div>            
            <div class="col-sm-4 text-center">
              <img class="img-circle img-thumbnail" src="<?= base_url(); ?>assets/img/luri.jpg">
              <h3>Luri Darmawan</h3>
              <p><em>Fastplaz Indonesia</em></p>
            </div>
          </div>
        </div>
      </div><!-- /.row -->
    </div>
  </section>

  <section id="countdown">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-3 text-center">
          <h1>Countdown to Event</h1>
          <p class="slogan">Event will be held on Sunday, 25 Februari 2017 09:00:00.</p>
          <div class="row countdown">
            <div class="countdown-item col-sm-3 col-xs-6">
              <div id="countdown-days" class="countdown-number"></div>
              <div class="countdown-label">Days</div>
            </div>
            <div class="countdown-item col-sm-3 col-xs-6">
              <div id="countdown-hours" class="countdown-number"></div>
              <div class="countdown-label">Hours</div>
            </div>
            <div class="countdown-item col-sm-3 col-xs-6">
              <div id="countdown-minutes" class="countdown-number"></div>
              <div class="countdown-label">Minutes</div>
            </div>
            <div class="countdown-item col-sm-3 col-xs-6">
              <div id="countdown-seconds" class="countdown-number"></div>
              <div class="countdown-label">Seconds</div>
            </div>
          </div>
        </div>
      </div><!-- /.row -->
    </div>
  </section>

  <section id="register">
    <div class="container">
      <div class="row">
        <div class="col-md-12 center-block text-center">
          <h1>Event Registration Surabaya Developer Day 2017</h1>
          <p class="slogan">Please fill all form with valid data.</p>
          <form id="register-form" method="post" role="form">
            <div class="row">
              <div class="col-md-8 col-md-offset-2">
                <div id="messages"></div>
                <div class="form-group">
                  <input type="text" name="nama" class="form-control" placeholder="Full name" value="<?=$nama; ?>" required>
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="Email" value="<?=$email; ?>" required>
                </div>
                <div class="form-group">
                  <input type="text" name="nohp" class="form-control" placeholder="Phone" value="<?=$nohp; ?>" required>
                </div>
                <div class="form-group">
                  <input type="text" name="alamat" class="form-control" placeholder="Address" value="<?=$alamat; ?>" required>
                </div>
                <div class="form-group">
                  <input type="text" name="kota" class="form-control" placeholder="City" value="<?=$kota; ?>" required>
                </div>
                <div class="form-group">
                  <input type="text" name="instansi" class="form-control" placeholder="Company Or Campus Name" value="<?=$instansi; ?>" required>
                </div>
                <div class="form-group">
                   <select class="form-control" name="kategori">
                   <?php foreach ($kategori_options as $k => $v) { ?>
                     <option value="<?=$k; ?>"<?=($k === $kategori) ? ' selected' : ''; ?>><?=$v; ?></option>
                   <?php } ?>
                   </select>                
                </div>
                <button class="btn btn-warning btn-lg pull-right" type="submit">Register</button>
              </div>
            </div>
          </form>
        </div>
      </div><!-- /.row -->
    </div>
  </section>

  <section id="maps">
    <div id="google-map"></div>
  </section>

  <section id="contact">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 text-center">
          <h3>Event Location</h3>
          <p>Dyandra Convention Surabaya.</p>
          <p>Jalan Basuki Rahmad No 93 Surabaya. Jawa Timur</p>
        </div>
        <div class="col-sm-6 text-center">
          <h3>Call Us</h3>
          <p>Illa (0858-1018-7939)</p>
          <p>Kiki (0812-8984-6568)</p>
        </div>
      </div><!-- /.row -->
    </div>
  </section>

  <footer>
    <div class="container">
      <p class="text-center">Copyright 2017 - <a href="http://surabaya.fg-phpindosby.com">PHP Indonesia Surabaya</a> | <a href="http://femalegeek.fg-phpindosby.com">FemaleGeek Surabaya</a> | <a href="https://www.pradesga.com/">Pradesga Indonesia</a></p>
    </div>
  </footer>

  <a href="#" class="scrolling scroll-up"><span class="glyphicon glyphicon-menu-up"></span></a>

  <!-- javascript -->
  <script src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/jquery.countdown.min.js"></script>
  <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key="AIzaSyDAAf2tAb61DOHG7tTHUHSCsZJ-pzvL2Ig"></script>

  <script type="text/javascript">
    $('.carousel').carousel({
      interval: 5000
    });

    $('.countdown').countdown('2017/02/25 09:00:00').on('update.countdown', function (event) {
      $('#countdown-days').text(event.offset.totalDays);
      $('#countdown-hours').text(('0' + event.offset.hours).slice(-2));
      $('#countdown-minutes').text(('0' + event.offset.minutes).slice(-2));
      $('#countdown-seconds').text(('0' + event.offset.seconds).slice(-2));
    });

    $(window).on('scroll', function() {
      if($(window).scrollTop() >= 15) {
        $('.navbar').addClass('navbar-inverse');
      } else {
        $('.navbar').removeClass('navbar-inverse');
      }

      if($(window).scrollTop() >= 100) {
        $('.scroll-up').fadeIn();
      } else {
        $('.scroll-up').fadeOut();
      }
    }).scroll();

    $('.scroll-about').click(function(){
      $("html, body").animate({ scrollTop: ($('#about').offset().top - 68) }, 1000);
      return false;
    });

    $('.scroll-register').click(function(){
      $("html, body").animate({ scrollTop: ($('#register').offset().top - 68) }, 1000);
      return false;
    });

    $('.scroll-up').click(function(){
      $("html, body").animate({ scrollTop: 0 }, 1000);
      return false;
    });

    $('#register-form').submit(function(event) {
      event.preventDefault();

      $.ajax({
        url: '/register',
        type: 'POST',
        data: $(this).serialize(),
        beforeSend: function() {
          $('#register-form :submit').prop('disabled', true);
          $('#register-form :submit').text('Registering ...');
        },
        success: function(response) {
          $('#register-form :submit').text('Register');
          $('#register-form :submit').prop('disabled', false);
          $('#register-form #messages').html(response);
        },
        error: function(response) {
          $(this).find('#messages').html(response);
        },
      });
    });
  </script>

  <script type="text/javascript">
    function init_map() {
      var myOptions = {
        zoom: 13,
        center: new google.maps.LatLng(-7.2694487,112.7417905),
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      map = new google.maps.Map(document.getElementById('google-map'), myOptions);
      marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(-7.2694487,112.7417905)
      })
      infowindow = new google.maps.InfoWindow({
        content: '<strong>Dyandra Convention Center</strong><br>Surabaya, East Java<br>'
      });
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
      });
      infowindow.open(map, marker);
    }
    google.maps.event.addDomListener(window, 'load', init_map);
  </script>

</body>
</html>