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

    $woeid = '23424969';
    $ret = $connectionOauth->get('/trends/place', array('id' => $woeid));
    echo "<pre>";
    foreach ($ret[0]->trends as $topic)
    	{
    		echo '<a href="'.$topic->url.'">'.$topic->name.'</a><br />';
    	}
    echo "</pre>";
    // $placecode = '2343980'; // Bölge kodu, yahodan bulabilirsin ben şuan Türkiye için koydum
    // $trendlist = $connectionOauth->get('trends/place', array('id' => $placecode));
    // //$a = $trendlist[0]->trends[0]->name;
    // $a = $trendlist[0];
    // //print_r($a);
    // echo "<pre>";
    // foreach ($a->trends as $statuses) {
    //     echo $statuses->name.'<br/ >';
    //   }
    // echo "</pre>";


}

include "layout/footer.php";
