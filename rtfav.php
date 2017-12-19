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
    <h3>Kelimeye göre Son 10 Tweet'i Favorilere Ekle</h3>
      <form role='form' action='/rtfav.php' method='post'>
       <div class='input-group input-group-lg'>
        <span class='input-group-addon'>https://twitter.com/search/tweets/</span>
         <input type='text' class='form-control' placeholder='Herhangi Bir Kelime Giriniz' name='kelime' /></p>
       </div><br />
        <p><button class='btn btn-lg btn-primary btn-block' type='submit' />Görüntüle</button></p>
      </form>
    </div><hr />";

      $qu1 = htmlspecialchars($_POST['kelime']);


    	$lasttweets = $connectionOauth->get('search/tweets', array('q' => $qu1, 'count' => 10));

      if (isset($_POST['kelime'])){
        echo "<pre>";
      foreach ($lasttweets->statuses as $statuses) {
          echo $statuses->text.'<br/ >';
          $tweetid = $statuses->id;
          $connectionOauth->post('favorites/create', array('id' => $tweetid));
        }
        echo "</pre>";
      }

      echo  "
      <div class='container'>
      <h3>Kelimeye göre Son 1 Tweet'i Retweet Yap</h3>
        <form role='form' action='/rtfav.php' method='post'>
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


}
include "layout/footer.php";
