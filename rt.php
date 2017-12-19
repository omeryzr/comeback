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

    echo  "
    <div class='container'>
    <h3>Kelimeye göre Son 1 Tweet'i Retweet Yap</h3>
      <form role='form' action='/trgy/rt.php' method='post'>
       <div class='input-group input-group-lg'>
        <span class='input-group-addon'>https://twitter.com/search/tweets/</span>
         <input type='text' class='form-control' placeholder='Herhangi Bir Kelime Giriniz' name='rtkelime' /></p>
       </div><br />
        <p><button class='btn btn-lg btn-primary btn-block' type='submit' />Görüntüle</button></p>
      </form>
    </div><hr />";

      $qu1 = htmlspecialchars($_POST['rtkelime']);
      $lasttweets = $connectionOauth->get('search/tweets', array('q' => $qu1, 'count' => 1));
      if (isset($_POST['rtkelime'])){
      echo "<pre>";
      foreach ($lasttweets->statuses as $statuses) {
          echo $statuses->text.'<br/ >';
          $tweetid = $statuses->id;
          $connectionOauth->post('statuses/retweet', array('id' => $tweetid));
        }
      echo "</pre>";
      }

      //Trend Listesine göre RT yapma
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
                            $a = $topic->name;
                            $a = preg_replace("'", " ", $a);
                            $i++;

                                  echo "
                                    <tr>
                                      <td class='hidden-xs'>$i</td>
                                      <td>$topic->name</td>
                                      <td><form role='form' action='/trgy/rt.php' method='get'>
                                      <input type='text' name='$a' placeholder='Takip Sayısı' >
                                      <input type='submit' value='Takip Et'></form>
                                      </td>
                                    </tr>";

                              //$count3 = htmlspecialchars($_POST['count2']);
                                  if (!empty($_GET[$topic->name])) {
                              // 4- trend listesindeki hastagin ismini aldım
                                    $ret1 = $topic->name;
                              // 5- aldığım isimle atılan son 10 tweeti aldım
                                    $lasttweets = $connectionOauth->get('search/tweets', array('q' => $ret1, 'count' => 1));
                              // 6- aldığım son 10 tweeti foreach ile çevirip tane tane işleme sokuyorum
                                      foreach ($lasttweets->statuses as $statuses) {
                              // 7- aldığım her bir tweetin screen name'ini aldım
                                        $userID1 = $statuses->id;
                              // 8- aldığım screen name ye eşdeğer kişiyi  takip  etmeye başladım
                                        $connectionOauth->post('statuses/retweet', array('id' => $userid));
                                    }
                                }
                              }
                                echo "</tbody>
                        </table>
                    </div>
        </div>
        </div>";

}
include "layout/footer.php";
