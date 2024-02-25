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
$list_limit = f("get_config")("txt_quota_max",0)+f("get_config")("media_quota_max",0);
$q = "select * from posts where 
user_id='$userid'     
order by schedule desc limit $list_limit";
$my_posts = f("db.q")($q);
f("webview.home")([
    'check_follow'=>$check_follow,
    'my_posts'=>$my_posts,
]);
f("db.disconnect")();
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";