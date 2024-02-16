<?php
function cek_login(){
    if(empty($_SESSION['access_token'])){
        $location = "login.php";
        if(!empty($_GET)){
            $location .= "?".http_build_query($_GET);
        }
        header("Location: $location");
        exit();
    }
    $userid = $_SESSION['access_token']['user_id'];
    $userdata = f("user.get")($userid);
    if(empty($userdata)){
        $screen_name = $_SESSION['access_token']['screen_name'];
        $token = $_SESSION['access_token']['oauth_token'];
        $token_secret = $_SESSION['access_token']['oauth_token_secret'];
        $q = "INSERT INTO users 
        (id, screen_name, token, token_secret) VALUES 
        ('$userid', '$screen_name', '$token', '$token_secret')";
        f("db.q")($q);
        $userdata = f("user.get")($userid);
    }
    elseif($_SESSION['access_token']['oauth_token'] != $userdata['token']
    or $_SESSION['access_token']['oauth_token_secret'] != $userdata['token_secret']){
        $token = $_SESSION['access_token']['oauth_token'];
        $token_secret = $_SESSION['access_token']['oauth_token_secret'];
        $q = "UPDATE users SET
        token='$token', token_secret='$token_secret'
        WHERE id='$userid'";
        f("db.q")($q);
    }
    if($userdata["banned_at"]){
        die("Your account ($userid) is banned. Please contact administrator.");
    }
    return $userdata;
}
    