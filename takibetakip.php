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
    // $takipedilenler = $connectionOauth->get('friends/ids', array('count' => 100));
    // print_r ($takipedilenler);
//En başta takip edilen 100 kullanıcıyı takipten çıkarma /*/*/* omeryazir.com
    echo "<div class='container'>
            <form role='form' action='/trgy/takibetakip.php' method='get'>
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
            <form role='form' action='/trgy/takibetakip.php' method='get'>
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

// Kullanıcıdan aldığı sayı kadar en son takip edileni takipten çıkarma /*/*/*/*/*/*/*omeryazir.com
    echo  "<div class='container'>
            <h3>Takibi Bırakmak İstediğiniz Kullanıcı Sayısını Giriniz </h3>
              <form role='form' action='/trgy/takibetakip.php' method='post'>
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
 // Takip Edeni Takip Etme  /*/*/*/*/*/*/*omeryazir.com
  echo "<div class='container'>
         <form role='form' action='/trgy/takibetakip.php' method='get'>
           <div class='alert alert-info'><strong>Takip'e - Takip:</strong> Seni Takip Eden Herkesi Sende Takip Et.
             <input type='hidden' name='takibetakip' value='run'>
             <input type='submit' value='Takip Et!'>
           </div>
         </form>
       </div><hr />";
      if (!empty($_GET['takibetakip'])) {
        $takipedenler = $connectionOauth->get('followers/ids');
        foreach ($takipedenler->ids as $key => $userID){
          $connectionOauth->post('friendships/create', array('user_id' => $userID));
        }
      }

  // İstenilen Kullanıcının Takipcileri Takip Etme  /*/*/*/*/*/*/*omeryazir.com
  echo  "<div class='container'>
          <h3>İstenilen Kullanıcının Takipcisini Takip Etme </h3>
            <form role='form' action='/trgy/takibetakip.php' method='post'>
             <div class='input-group input-group-lg'>
              <span class='input-group-addon'><i class='fa fa-users fa' aria-hidden='true'><span ></i></span>
              <input type='text' class='form-control' placeholder='Kullanıcı Adı' name='takibetakip1' /></p>
             </div><br />
              <p><button class='btn btn-lg btn-primary btn-block' type='submit'>Uygula</button></p>
            </form>
        </div><hr />";
       if (!empty($_POST['takibetakip1'])) {
         $screen_name = htmlspecialchars($_POST['takibetakip1']);
         $takipedenler = $connectionOauth->get('followers/ids', array('screen_name' => $screen_name));
         //print_r($takipedenler);
         foreach ($takipedenler->ids as $key => $userID){
           $connectionOauth->post('friendships/create', array('user_id' => $userID, 'count' => 100));
         }
       }

    // 1.Hastag'e yazan son 10 kullanıcıyı takip etme  /*/*/*/*/*/*/*omeryazir.com
      echo "<div class='container'>
              <form role='form' action='/trgy/takibetakip.php' method='get'>
                <div class='alert alert-info'><strong>Canlı Takipçi:</strong> 1.Hastag'e En Son Yazı Yazanları 10 Kullanıcıyı Takip Et.
                  <input type='hidden' name='hastag1takip' value='run'>
                  <input type='submit' value='Takip Et!'>
                </div>
              </form>
            </div><hr />";
      if (!empty($_GET['hastag1takip'])) {

        // for ($i=0; $i <10; $i++) {
        //   $woeid = '23424969';
        //   $ret = $connectionOauth->get('/trends/place', array('id' => $woeid));
        //   $ret1 = $ret[0]->trends[$i]->name;
        //   print_r ($ret1.'<br />');
        //
        // }
        $woeid = '23424969';
        $ret = $connectionOauth->get('/trends/place', array('id' => $woeid));
        $ret1 = $ret[0]->trends[0]->name;
        $lasttweets = $connectionOauth->get('search/tweets', array('q' => $ret1, 'count' => 10));
          foreach ($lasttweets->statuses as $statuses) {
            $userID1 = $statuses->user->screen_name;
            $connectionOauth->post('friendships/create', array('screen_name' => $userID1));
          }
        }

        // Trend listesinde istediğin hastag'in son 10 kullanıcısını takip et  /*/*/*/*/*/*/*omeryazir.com
        // 1- trend listesini aliyorum
        $woeid = '23424969';
        $ret = $connectionOauth->get('/trends/place', array('id' => $woeid));
        echo "<pre>";
        // 1- trend listesini foreach ile çevirip tane tane işleme sokuyorum
        foreach ($ret[0]->trends as $topic) {
        // 2- trend listesindeki hastagleri sırasıyla yazıp ve buton atıyorum
          echo "<form role='form' action='/trgy/takibetakip.php' method='get'>
                    <div class='alert alert-info'><strong>Canlı Takipçi:</strong> $topic->name Hastagine En Son Yazı Yazan 10 Kullanıcıyı Takip Et.
                      <input type='hidden' name='$topic->name' value='run'>
                      <input type='submit' value='$topic->name'>
                    </div>
                </form>";
        // 3- trend listesindeki hastagleri sırasıyla yazıp ve butonların kontrolünü yapıyorum
          if (!empty($_GET[$topic->name])) {
       // 4- trend listesindeki hastagin ismini aldım
            $ret1 = $topic->name;
      // 5- aldığım isimle atılan son 10 tweeti aldım
            $lasttweets = $connectionOauth->get('search/tweets', array('q' => $ret1, 'count' => 10));
      // 6- aldığım son 10 tweeti foreach ile çevirip tane tane işleme sokuyorum
              foreach ($lasttweets->statuses as $statuses) {
      // 7- aldığım her bir tweetin screen name'ini aldım
                $userID1 = $statuses->user->screen_name;
      // 8- aldığım screen name ye eşdeğer kişiyi  takip  etmeye başladım
                $connectionOauth->post('friendships/create', array('screen_name' => $userID1));
            }
        		//echo '<a href="'.$topic->url.'">'.$topic->name.'</a><br />';
        	}
        }
        echo "</pre>";
}
include "layout/footer.php";
