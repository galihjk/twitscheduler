<?php
function twitter__update_status($status){
    return f("twitter.post")("statuses/update", ["status" => $status]);
}
    