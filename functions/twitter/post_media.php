<?php
function twitter__post_media($text, $file){
    // $result = f("twitter.post")('media/upload', [
    //     'media' => $file,
    // ]);
    $connection = f("twitter.connect")("base1");
    $connection->setApiVersion('1.1');
    // die("asd");
    $media1 = $connection->upload('media/upload', ['media' => $file]);
    // echo "<pre>";
    // print_r($media1);
    // echo "\n========";
    // print_r([$media1->media_id_string]);
    // die();
    // $media2 = $connection->upload('media/upload', ['media' => '/path/to/file/kitten2.jpg']);
    $connection->setApiVersion('2');
    $param = [
        'text' => $text,
        'media' => [
            'media_ids'=>[$media1->media_id_string],
        ],
    ];
    $result = f("twitter.post")('tweets', $param);
    // $parameters = [
    //     'status' => $text,
    //     'media_ids' => implode(',', [$media1->media_id_string])
    // ];
    // $result = $connection->post('statuses/update', $parameters);
    // echo "\n===xxx=====";
    // print_r([$param ,$result]);
    // die();
    
    return $result;
}
    