<?php
function twitter__post_text($text){
    $result = f("twitter.post")('tweets', [
        'text' => $text,
    ]);
    return $result;
}
    