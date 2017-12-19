<?php
include "layout/header.php";

require "vendor/TwitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
if (!isset($_SESSION['access_token'])) {
    include 'login.php';
    echo "<div class='jumbotron'>
            <h1>SociaLogin</h1>
            <p>SociaLogin uygulaması ile twitter hesabınız veya hesaplarınıza bir çok yönde etki edebilirsiniz. Uygulamaya girerken şifre gereği duymadan özelliklerden faydalanabilirsiniz.
            <br><center><a href = '$url'> <img src='images/signIn.png' style='width: 300px'></center></a></p>
          </div>";
}
else
{
    $accessToken = $_SESSION['access_token'];
    $connectionOauth = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken['oauth_token'], $accessToken['oauth_token_secret']);
    $connectionOauth->setTimeouts(30, 30);
    $accountCredentials = $connectionOauth->get("account/verify_credentials");

    echo "
    <div class='col-lg-12 col-sm-12'>
    <div class='card hovercard'>
        <div class='card-background'>
            <img src='$accountCredentials->profile_banner_url' alt='$accountCredentials->name' title='$accountCredentials->name' id='profileBanner' />
        </div>
        <div class='useravatar'>
        <img src='$accountCredentials->profile_image_url' alt='$accountCredentials->name' title='$accountCredentials->name'  />

        </div>
        <div class='card-info'> <span class='card-title'>$accountCredentials->name - @$accountCredentials->screen_name</span>
        </div>
        <div class='description'> <span class='description-text'>$accountCredentials->description </span>
        </div>
    </div>
    <div class='btn-pref btn-group btn-group-justified btn-group-lg' role='group' aria-label='...'>
        <div class='btn-group' role='group'>
            <button type='button' id='stars' class='btn btn-primary' href='#tab1' data-toggle='tab'><span class='glyphicon glyphicon-star' aria-hidden='true'></span>
                <div class='hidden-xs'>Ana Sayfa</div>
            </button>
        </div>
        <div class='btn-group' role='group'>
            <button type='button' id='favorites' class='btn btn-default' href='#tab2' data-toggle='tab'><span class='glyphicon glyphicon-user' aria-hidden='true'></span>
                <div class='hidden-xs'>Tweetler :<span> $accountCredentials->statuses_count </span></div>
            </button>
        </div>
        <div class='btn-group' role='group'>
            <button type='button' id='following' class='btn btn-default' href='#tab3' data-toggle='tab'><span class='glyphicon glyphicon-user' aria-hidden='true'></span>
                <div class='hidden-xs'>Takip Edilen :<span> $accountCredentials->friends_count </span></div>
            </button>
        </div>
        <div class='btn-group' role='group'>
            <button type='button' id='following' class='btn btn-default' href='#tab4' data-toggle='tab'><span class='glyphicon glyphicon-heart' aria-hidden='true'></span>
                <div class='hidden-xs'>Takipçiler :<span> $accountCredentials->followers_count </span></div>
            </button>
        </div>
        <div class='btn-group' role='group'>
            <button type='button' id='following' class='btn btn-default' href='#tab5' data-toggle='tab'><span class='glyphicon glyphicon-heart' aria-hidden='true'></span>
                <div class='hidden-xs'>Beğendiklerim :<span> $accountCredentials->favourites_count </span></div>
            </button>
        </div>
    </div>

        <div class='well-content'>
      <div class='tab-content'>
        <div class='tab-pane fade in active' id='tab1'>";
        $homeTimeline = $connectionOauth->get("statuses/home_timeline");

        foreach ($homeTimeline as $timeLine) {
            $userName = $timeLine->user->name;
            $userImg = $timeLine->user->profile_image_url;
            @$Image = $timeLine->entities->media['0']->media_url;
            echo "
                <div class='col-lg-4 col-sm-4'><div class ='data'>
                    <img src='$userImg' alt='$userName' title='$userName' id='userImage'/>
                    <h3>$userName</h3>
                    <div class='clear'></div>
                    <h2>$timeLine->text</h2>
                    <br/>
                    <img src='$Image' alt=''/>
                </div></div>
                ";
        }
        echo "</div>
        <div class='tab-pane fade in' id='tab2'>";
        $myTimeline = $connectionOauth->get("statuses/user_timeline" , array('count' => 50));

        foreach ($myTimeline as $timeLine) {
            $userName = $timeLine->user->name;
            $userImg = $timeLine->user->profile_image_url;
            @$Image = $timeLine->entities->media['0']->media_url;

            echo "
                <div class='col-lg-4 col-sm-4'><div class ='data'>
                    <img src='$userImg' alt='$userName' title='$userName' id='userImage'/>
                    <h3> $userName</h3>
                    <div class='clear'></div>
                    <h2>$timeLine->text</h2>
                    <br/>
                    <img src='$Image' alt=''/>
                </div></div>
                ";
          }
        echo " </div>
        <div class='tab-pane fade in' id='tab3'>";
          $friends = $connectionOauth->get("friends/list" , array('count' => 200));
          foreach ($friends->users as $friend) {
              echo "<div class='col-lg-3 col-sm-3'>
                  <div class ='data'>
                      <img src='$friend->profile_image_url' alt='$friend->name' title='$friend->name' id='userImage'/>
                      <h3>$friend->name</h3>
                  </div></div>
                  ";
        }
        echo "</div>
        <div class='tab-pane fade in' id='tab4'>";
        $followers = $connectionOauth->get("followers/list" , array('count' => 200));

        foreach ($followers->users as $follower) {
            echo "<div class='col-lg-3 col-sm-3'>
                <div class ='data'>
                    <img src='$follower->profile_image_url' alt='$follower->name' title='$follower->name' id='userImage'/>
                    <h3>$follower->name</h3>
                </div></div>
                ";
        }
          echo "</div>
        <div class='tab-pane fade in' id='tab5'>";
        $favorites = $connectionOauth->get("favorites/list" , array('count' => 200));
        //print_r($favorites);
        foreach ($favorites as $favorite) {
            $userName = $favorite->user->name;
            $userImg = $favorite->user->profile_image_url;
            @$Image = $favorite->entities->media['0']->media_url;

            echo "
                <div class='col-lg-4 col-sm-4'><div class ='data'>
                    <img src='$userImg' alt='$userName' title='$userName' id='userImage'/>
                    <h3> $userName</h3>
                    <div class='clear'></div>
                    <h2>$favorite->text</h2>
                    <br/>
                    <img src='$Image' alt=''/>
                </div></div>
                ";
        }
          echo "</div>
      </div>
    </div>

    </div>";




}
include 'layout/footer.php';
