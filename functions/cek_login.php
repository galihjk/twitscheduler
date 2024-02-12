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
        $q = "INSERT INTO users 
        (id, screen_name) VALUES 
        ('$userid', '$screen_name')";
        f("db.q")($q);
        $userdata = f("user.get")($userid);
    }
    if($userdata["banned_at"]){
        die("Your account ($userid) is banned. Please contact administrator.");
    }
    return $userdata;
}
    