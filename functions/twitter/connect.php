<?php
require_once "vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', f("get_config")("CONSUMER_KEY"));
define('CONSUMER_SECRET', f("get_config")("CONSUMER_SECRET"));

function twitter__connect($ACCESS_TOKEN = null, $ACCESS_TOKEN_SECRET = null){
    if(f("str.is_diawali")($ACCESS_TOKEN,"base")){
        $ACCESS_TOKEN = f("get_config")("ACCESS_TOKEN");
        $ACCESS_TOKEN_SECRET = f("get_config")("ACCESS_TOKEN_SECRET");
    }
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $ACCESS_TOKEN, $ACCESS_TOKEN_SECRET);
    if($ACCESS_TOKEN == "base1"){
        $connection->setApiVersion('1.1');
    }
    else{
        $connection->setApiVersion('2');
    }    
    return $connection;
}
    