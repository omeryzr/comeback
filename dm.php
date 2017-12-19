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

    // biri beni takip ettiğinde ona dm atma
    $decode_json = json_decode(json_encode($followers), true);

    $message = urlencode($message);


  foreach($decode_json as $i)
  {

    foreach($i as $id)
    {

      $responseDM = $connection->post("https://api.twitter.com/1.1/direct_messages/new.json?text=meraba&user_id=".$id);
      
    }

}
include "layout/footer.php";
