<?php
include "layout/header.php";

require "vendor/TwitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

if (!isset($_SESSION['access_token']))
{
    include 'login.php';
}
else
{
    $accessToken = $_SESSION['access_token'];
    $connectionOauth = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
    $connectionOauth->setTimeouts(30, 30);
    date_default_timezone_set ('Europe/Istanbul');
    $timezone= date("g:i");
    $tweetMessage = "Peki bu sayı " .$timezone. " size ne ifade ediyor.";
    print_r($tweetMessage);



      // $age=array("alanyaspor fenerbahçe karşısında 2-0 öne geçmesine rağmen 3-2 yenildi.","alanyaspor (temsili psg)");
      //   foreach($age as $x)
      //     {
      //       $deneme = $x;
      //       $tweettext = $connectionOauth->post('statuses/update', array('status' => $deneme));
      //       echo "<br>";
      //     }

  //Takip Edeni Takip Etme  /*/*/*/*/*/*/*omeryazir.com
   echo "<div class='container'>
          <form role='form' action='/trgy/tweetat.php' method='get'>
            <div class='alert alert-info'><strong>Takip'e - Takip:</strong> Seni Takip Eden Herkesi Sende Takip Et.
              <input type='hidden' name='takibetakip' value='run'>
              <input type='submit' value='Tweet At!'>
            </div>
          </form>
        </div><hr />";
       if (!empty($_GET['takibetakip'])) {
         echo "<pre>";
         $dosyaismi="deneme.txt";
         $tweet=file($dosyaismi);
              foreach($tweet as $satir)
                {
                  $deneme = "Efsane Sözler: ".$satir;
                  $tweettext = $connectionOauth->post('statuses/update', array('status' => $deneme));
                  echo $deneme."<br>";
                  sleep(60);
                }
        echo "</pre>";

}
      echo "<div class='form-group'>
              <form role='form' action='/trgy/tweetat.php' method='get'>
              <label for='comment'>Tweetler:</label>
              <textarea class='form-control' rows='5' name='comment'></textarea>
              <input type='submit' value='Tweetleri belgeye kaydet!'>
            </div>";
      if (!empty($_GET['comment'])) {

      }

      echo "<hr />";

      if (file_exists("deneme.txt")){
       echo "Dosya Mevcut<br/>";
        }else{
               echo "Dosya Bulunamadı<br/>";
        }

        $dosyaismi="deneme.txt";
        $tweet=file($dosyaismi);
        foreach($tweet as $sira => $satir)
           {
           print "Tweet : $sira - $satir <br>";
           }


}

// include "layout/footer.php";
//
// $aylar = Array("ocak","temmuz","subat","mart","nisan"); // Aylar dizisini ekrana yazdıralım.
//
// foreach($aylar as $deger) // $aylar as $deger - aylar değişkenindeki verileri $deger değişkenine aktarıyoruz.
//
// {
//
// echo $deger."<br/>"; // Echo ile alt alta yazdırıyoruz :)
//
// }
