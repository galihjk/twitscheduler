<?php
include("init.php");
$user = f("cek_login")();


f("webview.create")([
    'user'=>$user,
    'allow_post'=>true,
]);
f("db.disconnect")();
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";