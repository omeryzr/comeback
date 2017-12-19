<?php
include "layout/header.php";

require "vendor/TwitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

if (!isset($_SESSION['access_token'])) {
    include 'login.php';
}
else
{
    $accessToken = $_SESSION['access_token'];
    $connectionOauth = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
    $connectionOauth->setTimeouts(30, 30);

    $tweets = $connectionOauth->get("statuses/user_timeline" , array('count' => 200));

    foreach ( $tweets as $tweet ){

		$id = $tweet->id_str;
		$text = $tweet->text;
		$created_at = date("Y-m-d H:i:s", strtotime($tweet->created_at));

		echo '<a href="https://twitter.com/'.$username.'/statuses/'.$id.'" target="_blank">
			'.nl2br($text).'<br />
			'.$created_at.' - #'.$id.'
		</a>
		<hr />';

	}

}

include "layout/footer.php";
