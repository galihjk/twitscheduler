<?php
include("init.php");
$user = f("cek_login")();
dump($_SESSION);

$connection = f("twitter.connect")($_SESSION['access_token']['oauth_token'],$_SESSION['access_token']['oauth_token_secret']);

dump($connection);

$result = $connection->post('tweets', [
    'text' => "This is a test tweet from php",
], true);

dump($result);

echo "DONE. https://twitter.com/". $_SESSION['access_token']['screen_name'];