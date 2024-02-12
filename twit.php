<?php

die("asd");
require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth("7x9somKjYoyerEKDdyMatMf3Z", 
"tHktXxBgSv0UrlJOQpje6g80FCnExhK1vhZXDfHWvLGb6mMAm0", "1386176390085496839-Zc350Vns35u6q1VtxrG7F10GfH3RFw", 
"cGtv95gmeel5GfzWczssnjJf1p386v9XUJQXOPTNo21lF");

$connection->setApiVersion('2');

echo "<pre>";


echo "connection";
print_r($connection);

$response = $connection->get('users', ['ids' => 12]);


echo "response";
print_r($response);

exit();

$content = $connection->get("account/verify_credentials");

// echo "content";
// print_r($content);

// $status = 'This is a test tweet.';
// $result = $connection->post("statuses/update", ["status" => $status]);

// echo "post";
// print_r($result);

$statuses = $connection->get("search/tweets", ["q" => "twitterapi"]);
echo "statuses";
print_r($statuses);