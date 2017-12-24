  <?php
  session_start();
  include "config.php";
  ?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
      <title>Socialogin | Twitter</title>
      <base href="<?php echo $baseUrl;?>" />
      <link rel="stylesheet" href="css/twitter.css"/>

      <!-- Bootstrap -->
      <link href="../static/css/bootstrap.min.css" rel="stylesheet">
      <link href="../static/css/twitterstyle.css" rel="stylesheet">

      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body>
      <?php
      if (!isset($_SESSION['access_token'])) {
      echo "<div class='navbar navbar-default navbar-fixed-top'>
      <div class='container'>
          <div class='navbar-header'>
              <button class='navbar-toggle' type='button' data-toggle='collapse' data-target='#navbar-main'>
                  <span class='icon-bar'></span>
                  <span class='icon-bar'></span>
                  <span class='icon-bar'></span>
              </button>
              <a class='navbar-brand' href='/'>Socialogin</a>
          </div>
          <center>
              <div class='navbar-collapse collapse' id='navbar-main'>
                  <ul class='nav navbar-nav'>
                      <li><a href='/nedir.php'>Nedir?</a></li>
                      <li><a href='/kullanim.php'>Ne İşe Yarar?</a></li>
                  </ul>
              </div>
          </center>
      </div>
    </div>";
    }
    else {
    echo "<div class='navbar navbar-default navbar-fixed-top'>
    <div class='container'>
        <div class='navbar-header'>
            <button class='navbar-toggle' type='button' data-toggle='collapse' data-target='#navbar-main'>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
                <span class='icon-bar'></span>
            </button>
            <a class='navbar-brand' href='/'>Socialogin</a>
        </div>
        <center>
            <div class='navbar-collapse collapse' id='navbar-main'>
                <ul class='nav navbar-nav'>
                    <li><a href='/takipet.php'>Takip Et</a></li>
                    <li><a href='/takipbirak.php'>Takip Bırak</a></li>
                    <li><a href='/rt.php'>RT</a></li>
                    <li><a href='/fav.php'>FAV</a></li>
                    <li><a href='/trendlist.php'>Trend Listesi</a></li>
                    <li><a href='/takibetakip.php'>Takibe Takip</a></li>
                    <li><a href='/rtfav.php'>Rt-Fav</a></li>
                    <li><a href='/tweetat.php'>Tweet At</a></li>
                    <li><a href='/dm.php'>DM</a></li>
                    <li><a href='/takipalg.php'>Takip Algoritması</a></li>
                    <li><a href='/istatistik.php'>İstatistik</a></li>

                </ul>
                <ul class='nav navbar-nav navbar-right'>
                    <li><a href='/logout.php'><i class='glyphicon glyphicon-circle-arrow-right'></i> Çıkış</a>
                </ul>

            </div>
        </center>
    </div>
  </div>";
  }
    echo "<br><br><br><div class='container theme-showcase' role='main'>
      <!-- Carousel
      ================================================== -->";
