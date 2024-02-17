<?php 
include("init.php");
$q = "select * from posts 
order by schedule desc";
$my_posts = f("db.q")($q);
dump($my_posts);