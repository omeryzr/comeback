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

    // 1.Hastag'e yazan son 10 kullanıcıyı takip etme  /*/*/*/*/*/*/*omeryazir.com
      echo "<button onclick='myFunction()'>Reload page</button>
              <script>
                function myFunction() {
                    location.reload();
                }
              </script>";

      echo "<div class='container'>
              <form role='form' action='/trgy/takipalg.php' method='get'>
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
        $ret1 = $ret[0]->trends[1]->name;
        $lasttweets = $connectionOauth->get('search/tweets', array('q' => $ret1, 'count' => 200));
        echo "<pre>";
          foreach ($lasttweets->statuses as $statuses) {
            echo $statuses->user->name.' ✓ Takip Edildi<br/ >';
            $userID1 = $statuses->user->screen_name;
            $connectionOauth->post('friendships/create', array('screen_name' => $userID1));
            sleep(300);
          }
        echo "</pre>";
        }
        // İstenilen Kullanıcının İstendiği Kadar Takipcilerini Takip Etme  /*/*/*/*/*/*/*omeryazir.com
            echo  "
            <div class='container'>
                <h3>İstenilen Kullanıcının Takipcisini Takip Etme </h3>
                  <form role='form' action='/trgy/takipalg.php' method='post'>
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

}
include "layout/footer.php";
