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



    // Kullanıcıdan aldığı sayı kadar en son takip edileni takipten çıkarma /*/*/*/*/*/*/*omeryazir.com
        echo  "<div class='container'>
                <h3>Takibi Bırakmak İstediğiniz Kullanıcı Sayısını Giriniz(İlk Takip Edilenler) </h3>
                  <form role='form' action='/takipbirak.php' method='post'>
                   <div class='input-group input-group-lg'>
                    <span class='input-group-addon'><i class='fa fa-users fa' aria-hidden='true'><span ></i></span>
                    <input type='text' class='form-control' placeholder='Kullanıcı Sayısı' name='kullanicisayisi' /></p>
                   </div><br />
                    <p><button class='btn btn-lg btn-primary btn-block' type='submit' />Uygula</button></p>
                  </form>
              </div><hr />";
          $sayi = htmlspecialchars($_POST['kullanicisayisi']);
          $takipedilenler = $connectionOauth->get('friends/ids');
          //print_r ($takipedilenler);
         if (isset($_POST['kullanicisayisi'])){
            $i = 0;
            foreach (array_reverse($takipedilenler->ids) as $key => $userID){
              $i++;
                if ($i == $sayi) {
                  break;
                }
              $connectionOauth->post('friendships/destroy', array('user_id' => $userID, 'count' => $sayi));
              }
        }
        // Kullanıcıdan aldığı sayı kadar en son takip edileni takipten çıkarma /*/*/*/*/*/*/*omeryazir.com
            echo  "<div class='container'>
                    <h3>Takibi Bırakmak İstediğiniz Kullanıcı Sayısını Giriniz(Son Takip Edilenler) </h3>
                      <form role='form' action='/takipbirak.php' method='post'>
                       <div class='input-group input-group-lg'>
                        <span class='input-group-addon'><i class='fa fa-users fa' aria-hidden='true'><span ></i></span>
                        <input type='text' class='form-control' placeholder='Kullanıcı Sayısı' name='kullanicisayisi1' /></p>
                       </div><br />
                        <p><button class='btn btn-lg btn-primary btn-block' type='submit' />Uygula</button></p>
                      </form>
                  </div><hr />";
              $sayi1 = htmlspecialchars($_POST['kullanicisayisi1']);
              $takipedilenler = $connectionOauth->get('friends/ids', array('count' => $sayi1));
              //print_r ($takipedilenler);
             if (isset($_POST['kullanicisayisi1'])){
                foreach ($takipedilenler->ids as $key => $userID){
                                  $connectionOauth->post('friendships/destroy', array('user_id' => $userID));
                  }
            }

            //En başta takip edilen 100 kullanıcıyı takipten çıkarma /*/*/* omeryazir.com
                echo "<div class='container'>
                        <form role='form' action='/takipbirak.php' method='get'>
                          <div class='alert alert-info'><strong>100</strong> kullanıcıyı takipten çıkar.
                            <input type='hidden' name='act' value='run'>
                            <input type='submit' value='Takibi Bırak!'>
                          </div>
                        </form>
                      </div> <hr />";
                      $takipedilenler = $connectionOauth->get('friends/ids');
                if (!empty($_GET['act'])) {
                    $i = 0;
                    foreach (array_reverse($takipedilenler->ids) as $key => $userID){
                      $i++;
                      if ($i == 100) {
                        break;
                      }
                      $connectionOauth->post('friendships/destroy', array('user_id' => $userID, 'count' => 100));
                    }
                  }

            // Bütün takipcileri sil /*/*/* omeryazir.com
                echo "<div class='container'>
                        <form role='form' action='/takipbirak.php' method='get'>
                          <div class='alert alert-info'><strong>Sıfırlama:</strong> Tüm kullanıcıları takipten çıkar.
                            <input type='hidden' name='actall' value='run'>
                            <input type='submit' value='Takibi Bırak!'>
                          </div>
                        </form>
                      </div><hr />";
                if (!empty($_GET['actall'])) {
                  $accountCredentials = $connectionOauth->get("account/verify_credentials");
                  $friendscount = $accountCredentials->friends_count;
                  $takipedilenler = $connectionOauth->get('friends/ids', array('count' => $friendscount));
                    foreach ($takipedilenler->ids as $key => $userID){
                       $connectionOauth->post('friendships/destroy', array('user_id' => $userID));
                     }
                   }

}
include "layout/footer.php";
