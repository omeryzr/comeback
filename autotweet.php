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
    <h3>Kelimeye göre Tweet Topla </h3>
      <form role='form' action='/autotweet.php' method='post'>
       <div class='input-group input-group-lg'>
        <span class='input-group-addon'>https://twitter.com/search/tweets/</span>
         <input type='text' class='form-control' placeholder='Herhangi Bir Kelime Giriniz' name='kelime' /></p>
       </div><br />
        <p><button class='btn btn-lg btn-primary btn-block' type='submit' />Görüntüle</button></p>
      </form>
    </div><hr />";

      $qu1 = htmlspecialchars($_POST['kelime']);
    	$lasttweets = $connectionOauth->get('search/tweets', array('q' => $qu1, 'count' => 100));

      if (isset($_POST['kelime'])){

      foreach ($lasttweets->statuses as $statuses) {
          echo $statuses->text.'<br/ >';
        }
      }
      echo  "

      <div class='container'>
      <h3>Kullanıcı Adına göre Tweet Topla </h3>
        <form role='form' action='/autotweet.php' method='post'>
         <div class='input-group input-group-lg'>
          <span class='input-group-addon'>https://twitter.com/</span>
           <input type='text' class='form-control' placeholder='Kullanıcı Acını Giriniz' name='isim' /></p>
         </div><br />
          <p><button class='btn btn-lg btn-primary btn-block' type='submit' />Görüntüle</button></p>
        </form>
      </div><hr />";

      $qu = htmlspecialchars($_POST['isim']);
      $userstweets = $connectionOauth->get('statuses/user_timeline', array('screen_name' => $qu, 'count' => 500));
      // print_r($userstweets);
      if (isset($_POST['isim'])){

        foreach ( $userstweets as $tweet ){

        $id = $tweet->id_str;
        $text = $tweet->text;
        $created_at = date("Y-m-d H:i:s", strtotime($tweet->created_at));

          echo '
          <a href="https://twitter.com/'.$username.'/statuses/'.$id.'" target="_blank">
            '.nl2br($text).'<br />
            '.$created_at.' - #'.$id.'
          </a><hr />';
          }
      }
}

include "layout/footer.php";
