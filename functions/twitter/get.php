<?php
function twitter__get($endpoint, $data){
    $connection = f("twitter.connect")();
    // print_r(['connection'=>$connection, 'endpoint'=>$endpoint, 'data'=>$data]);
    // echo "---[[[-]----";
    $response = $connection->get("statuses/home_timeline", ["count" => 25, "exclude_replies" => true]);
    // echo "responseXXX";
    // print_r($response);
    // echo "---]-]----";
    $result = $connection->get($endpoint, $data);
    // echo " result: ";
    // print_r($result);
    // if ($connection->getLastHttpCode() != 200) {
    //     echo 'error: ' . $result->errors[0]->message;
    //     file_put_contents("log/ErrorTwitterGet ".date("YmdHis").".txt", print_r($result,true));
    // }
    return $result;
}