<?php
include("init.php");
$user = f("cek_login")();
/*
$connection = f("twitter.connect")("base");
$param = [
    'source_screen_name' => $_SESSION['access_token']['screen_name'],
    'target_screen_name' => f("get_config")("username"),
];

$following = $connection->get('friendships/show', $param);
echo "<pre>session\n";
print_r($_SESSION);
echo "connection\n";
print_r($connection);
echo "param\n";
print_r($param);
echo "following\n";
print_r($following);
die();
*/

$check_follow = true;
$allow_post = true;

$userid = $user["id"];
$txt_quota_seconds = f("get_config")("txt_quota_seconds",0);
$media_quota_seconds = f("get_config")("media_quota_seconds",0);
$q = "select * from posts where 
user_id='$userid' 
and time > now() - interval $txt_quota_seconds second - interval $media_quota_seconds second    
order by time asc";
$my_posts = f("db.q")($q);

$base_quota_max = f("get_config")("base_quota_max",1);
$base_quota_seconds = f("get_config")("base_quota_seconds",1);
$q = "select time from posts where time > now() - interval $base_quota_seconds second order by time asc";
$data_base_quota = f("db.q")($q);

if(empty($data_base_quota)){
    $base_quota_used = 0;
    $base_tunggu_kuota = 0;
}
else{
    $base_quota_used = count($data_base_quota);
    $base_tunggu_kuota = 5+($base_quota_seconds - (time()-strtotime($data_base_quota[0]['time'])));
}

if($base_quota_used >= $base_quota_max){
    $allow_post = false;
}

f("webview.home")([
    'check_follow'=>$check_follow,
    'my_posts'=>$my_posts,
    'base_quota_used'=>$base_quota_used,
    'base_quota_max'=>$base_quota_max,
    'base_username'=>f("get_config")("username"),
    'allow_post'=>$allow_post,
    'base_tunggu_kuota'=>$base_tunggu_kuota,
]);
f("db.disconnect")();
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";