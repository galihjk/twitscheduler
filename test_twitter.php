<?php
require_once 'vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

// OAuth settings
$consumerKey = 'GeZMaqt1G1RNlDvlFQnZZlo1T';
$consumerSecret = 'mUCFr3vrL1ROdGippJiUCo27h5nC7C041GKqqq6IUqmcIx05gT';
$accessToken = '1386176390085496839-PyQ425MxcPPeMk4snGuLkmBGVW0KuO';
$accessTokenSecret = 'jZqc7ET0RvDGIJoLEnSO5EhaDUrDoZPtOLo2RUWy2xdMI';

if(!empty($_GET['consumerKey'])){
    $consumerKey = $_GET['consumerKey'];
}

if(!empty($_GET['consumerSecret'])){
    $consumerSecret = $_GET['consumerSecret'];
}

if(!empty($_GET['accessToken'])){
    $accessToken = $_GET['accessToken'];
}

if(!empty($_GET['accessTokenSecret'])){
    $accessTokenSecret = $_GET['accessTokenSecret'];
}

echo "<h1>TEST TWITTER</h1>";
?>
<div style='font-size: large;'>
    <form method='get'>
        consumerKey: 
        <input type='text' name='consumerKey' value='<?=$consumerKey?>'/>
        <br>
        consumerSecret:
        <input type='text' name='consumerSecret' value='<?=$consumerSecret?>'/>
        <br>
        accessToken:
        <input type='text' name='accessToken' value='<?=$accessToken?>'/>
        <br>
        accessTokenSecret:
        <input type='text' name='accessTokenSecret' value='<?=$accessTokenSecret?>'/>
        <br>
        <input type='submit'/>
    </form>
</div>
<?php
echo "<pre>";

print_r([$consumerKey, $consumerSecret, $accessToken, $accessTokenSecret]);

// Create TwitterOAuth object
$twitter = new TwitterOAuth($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);

// Use Twitter API v2
$twitter->setApiVersion('2');

// echo "\n----------------\n";
// print_r($twitter);

// Create a Tweet
$tweetParams = [
    'text' => 'This is a test tweet.',
];

$status = $twitter->post('tweets', $tweetParams, true);

echo "\n-------HASILNYA:---------\n";
print_r($status);
echo "\n----------------\n";


if ($twitter->getLastHttpCode() == 201) {
    echo "Successfully posted a test tweet.\n";
    echo "Tweet ID: " . $status->data->id . "\n";
    echo "Tweet Text: " . $status->data->text . "\n";
} else {
    echo "Error posting a test tweet.\n";
    echo "HTTP Code: " . $twitter->getLastHttpCode() . "\n";
    echo "API Response:\n";
    var_dump($status);
}
?>