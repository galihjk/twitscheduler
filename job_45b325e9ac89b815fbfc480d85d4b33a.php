<?php 
include("init.php");
$current_time = date("Y-m-d H:i:s");
dump("current_time=$current_time");
$limit_per_job = f("get_config")("limit_per_job",10);
dump("limit_per_job=$limit_per_job");
$q = "select * from posts 
where schedule <= '$current_time'
and (status='suspend' or status is null)
order by schedule asc";

dump($q);
$my_posts = f("db.q")($q);
$delayed_post = [];
$count = 0;
foreach($my_posts as $k=>$item){
    if($count >= $limit_per_job){
        $delayed_post[] = $item;
        unset($my_posts[$k]);
    }
    $count++;
}
dump(['my_posts'=>$my_posts]);
dump(['delayed_post'=>$delayed_post]);

foreach($delayed_post as $item){
    if(empty($q_delay)) $q_delay = [];
    if($item['status'] != 'suspend'){
        $q = "update posts set status='suspend', info='limit $limit_per_job reached' where id=".$item['id'];
        $q_delay[] = $q;
    }
}
if(!empty($q_delay)){
    dump(['q_delay'=>$q_delay]);
    foreach($q_delay as $q){
        f("db.q")($q);
    }
}

$q_post = [];
$done_count = 0;
$post_count = count($my_posts);
$wait = f("get_config")("job_wait_per_post");
foreach($my_posts as $item){
    $posted_at = date("Y-m-d H:i:s");
    dump('posting [id='.$item['id']."] $posted_at");
    $user = f("user.get")($item['user_id']);
    $connection = f("twitter.connect")($user['token'],$user['token_secret']);
    if($item['type'] == "txt"){
        $result = $connection->post('tweets', [
            'text' => $item['text'],
        ], true);
    }
    elseif($item['type'] == "img"){
        $connection->setApiVersion('1.1');
        $filepath = "scheduled_media/".$item['media'];
        if(file_exists($filepath)){
            $media1 = $connection->upload('media/upload', ['media' => $filepath]);
            $connection->setApiVersion('2');
            $param = [
                'text' => $item['text'],
                'media' => [
                    'media_ids'=>[$media1->media_id_string],
                ],
            ];
            $result = $connection->post('tweets', $param, true);
        }
        else{
            $result = ['error'=>"file '$filepath' not exists."];
        }
    }
    if(empty($result->data->id)){
        $q = "update posts set status='fail', info=".f("str.dbq")(json_encode([$posted_at,$result]))." where id=".$item['id'];
        $q_post[] = $q;
    }
    else{
        $msg_id = $result->data->id;
        $q = "update posts set status='success', msg_id='$msg_id',
         info=".f("str.dbq")(json_encode([$posted_at,$result]))." where id=".$item['id'];
        $q_post[] = $q;
        if($item['type'] == "img") unlink($filepath);
        dump("success: https://twitter.com/".$user['screen_name']."/status/$msg_id");
    }
    $done_count++;
    if($done_count < $post_count){
        dump("$done_count/$post_count done, wait $wait s");
        sleep($wait);
    }
}
if(!empty($q_post)){
    dump(['q_post'=>$q_post]);
    foreach($q_post as $q){
        f("db.q")($q);
    }
}