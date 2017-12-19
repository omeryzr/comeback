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



    // İstenilen Kullanıcının İstendiği Kadar Takipcilerini Takip Etme  /*/*/*/*/*/*/*omeryazir.com
        echo  "
        <div class='container'>
            <h3>İstenilen Kullanıcının Takipcisini Takip Etme </h3>
              <form role='form' action='/trgy/takipet.php' method='post'>
                <div class='col-lg-12 col-sm-12'>
                   <div class='col-md-9'>
                     <div class='input-group input-group-lg'>
                      <span class='input-group-addon'><i class='fa fa-users fa' aria-hidden='true'></i></span>
                      <input type='text' class='form-control' placeholder='Kullanıcı Adı' name='takipet' />
                     </div>
                   </div>

                   <div class='col-md-3'>
                         <div class='input-group input-group-lg'>
                           <input type='text' class='form-control' value='1' min='1' max='100' name='count1' >
                             <div class='input-group-btn-vertical'>
                               <button class='btn btn-default' type='button'><i class='fa fa-caret-up'></i></button>
                               <button class='btn btn-default' type='button'><i class='fa fa-caret-down'></i></button>
                             </div>
                         </div>
                               <p class='help-block'>Min 1 - Max 100.</p>
                   </div>
                               <p><button class='btn btn-lg btn-primary btn-block' type='submit'>Uygula</button>
                </div>
              </form>
          </div><hr />";

         if (!empty($_POST['takipet'])) {
           $screen_name = htmlspecialchars($_POST['takipet']);
           $count1 = htmlspecialchars($_POST['count1']);
           $takipedenler = $connectionOauth->get('followers/ids', array('screen_name' => $screen_name, 'count' => $count1));
           //print_r($takipedenler);
           foreach ($takipedenler->ids as $key => $userID){
             $connectionOauth->post('friendships/create', array('user_id' => $userID));
           }
         }


     // Kelimeye göre Tweet Atan kullanıcıları Takip Etme  /*/*/*/*/*/*/*omeryazir.com
        echo  "
        <div class='container'>
              <h3>Kelimeye göre Tweet Atan Kullanıcıları Takip Etme</h3>
                   <form role='form' action='/trgy/takipet.php' method='post'>
                     <div class='col-lg-12 col-sm-12'>
                        <div class='col-md-9'>
                          <div class='input-group input-group-lg'>
                           <span class='input-group-addon'>https://twitter.com/search/tweets/</span>
                           <input type='text' class='form-control' placeholder='Herhangi Bir Kelime Giriniz' name='kelime' />
                          </div>
                        </div>

                        <div class='col-md-3'>
                              <div class='input-group input-group-lg'>
                                <input type='text' class='form-control' value='1' min='1' max='100' name='count2' >
                                  <div class='input-group-btn-vertical'>
                                    <button class='btn btn-default' type='button'><i class='fa fa-caret-up'></i></button>
                                    <button class='btn btn-default' type='button'><i class='fa fa-caret-down'></i></button>
                                  </div>
                              </div>
                                    <p class='help-block'>Min 1 - Max 100.</p>
                        </div>
                                    <p><button class='btn btn-lg btn-primary btn-block' type='submit'>Uygula</button>
                     </div>
                   </form>
               </div><hr />";

         $qu1 = htmlspecialchars($_POST['kelime']);
         $count2 = htmlspecialchars($_POST['count2']);
       	 $lasttweets = $connectionOauth->get('search/tweets', array('q' => $qu1, 'count' => $count2));
         //print_r($lasttweets);
           if (isset($_POST['kelime'])){
             echo "<pre>";
               foreach ($lasttweets->statuses as $statuses) {
                   echo $statuses->user->name.' ✓ Takip Edildi<br/ >';
                   $userID1 = $statuses->user->id;
                   $connectionOauth->post('friendships/create', array('user_id' => $userID1));
                 }
             echo "</pre>";
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

          // Trend Listesine Göre Takip Etme  /*/*/*/*/*/*/*omeryazir.com
          $woeid = '23424969';
          $ret = $connectionOauth->get('/trends/place', array('id' => $woeid));
            echo "
                <div class='row'>
                        <div class='col-md-12 '>
                          <div class='panel-body'>
                            <table class='table table-striped table-bordered table-list'>
                              <thead>
                                <tr>
                                    <th class='hidden-xs'>Sıra</th>
                                    <th>#Hastag İsmi</th>
                                    <th>Takip Sayısı ve Takip Et</th>
                                </tr>
                              </thead>
                              <tbody>";
                              $i = 0;
                              foreach ($ret[0]->trends as $topic) {
                                // $a = $topic->name;
                                // $a = preg_replace("'", " ", $a);
                                $i++;
                                      echo "
                                        <tr>
                                          <td class='hidden-xs'>$i</td>
                                          <td>$topic->name</td>
                                          <td><form role='form' action='/trgy/takipet.php' method='get'>
                                          <input type='text' name='$topic->name' placeholder='Takip Sayısı' >
                                          <input type='submit' value='Takip Et'></form>
                                          </td>
                                        </tr>";

                                  //$count3 = htmlspecialchars($_POST['count2']);
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
                                    }
                                  }
                                    echo "</tbody>
                            </table>
                        </div>
            </div>
            </div>";

          //
          //   // 1- trend listesini aliyorum
          //   $woeid = '23424969';
          //   $ret = $connectionOauth->get('/trends/place', array('id' => $woeid));
          //   echo "<pre>";
          //   // 1- trend listesini foreach ile çevirip tane tane işleme sokuyorum
          //   foreach ($ret[0]->trends as $topic) {
          //   // 2- trend listesindeki hastagleri sırasıyla yazıp ve buton atıyorum
          //     echo "<form role='form' action='/trgy/takibetakip.php' method='get'>
          //               <div class='alert alert-info'><strong>Canlı Takipçi:</strong> $topic->name Hastagine En Son Yazı Yazan 10 Kullanıcıyı Takip Et.
          //                 <input type='hidden' name='$topic->name' value='run'>
          //                 <input type='submit' value='$topic->name'>
          //               </div>
          //           </form>";
          //   // 3- trend listesindeki hastagleri sırasıyla yazıp ve butonların kontrolünü yapıyorum
          //     if (!empty($_GET[$topic->name])) {
          //  // 4- trend listesindeki hastagin ismini aldım
          //       $ret1 = $topic->name;
          // // 5- aldığım isimle atılan son 10 tweeti aldım
          //       $lasttweets = $connectionOauth->get('search/tweets', array('q' => $ret1, 'count' => 10));
          // // 6- aldığım son 10 tweeti foreach ile çevirip tane tane işleme sokuyorum
          //         foreach ($lasttweets->statuses as $statuses) {
          // // 7- aldığım her bir tweetin screen name'ini aldım
          //           $userID1 = $statuses->user->screen_name;
          // // 8- aldığım screen name ye eşdeğer kişiyi  takip  etmeye başladım
          //           $connectionOauth->post('friendships/create', array('screen_name' => $userID1));
          //       }
          //   		//echo '<a href="'.$topic->url.'">'.$topic->name.'</a><br />';
          //   	}
          //   }
          //   echo "</pre>";
}
include "layout/footer.php";
