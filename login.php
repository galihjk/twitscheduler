<?php
include("init.php");
if(!empty($_GET['dev'])){
    $_SESSION['access_token'] = f("get_config")("devsession");
    header("Location: index.php");
    exit();
}
else{
    f("twitter.login")();
}