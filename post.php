<?php
include("init.php");
$user = f("cek_login")();
$userid = $user["id"];
// echo "<a href='index.php'>ok</a>";
$must_contains_one_of = f("get_config")("must_contains_one_of",[" "]);
$valid = false;
foreach($must_contains_one_of as $val){
    if(f("str.contains")($_POST['text'],"$val ")
    or f("str.contains")($_POST['text'],"$val#")
    or f("str.contains")($_POST['text'],"$val,")
    or f("str.contains")($_POST['text'],"$val.")
    or f("str.contains")($_POST['text'],"$val/")
    or f("str.contains")($_POST['text'],"$val\n")
    or f("str.contains")($_POST['text'],"$val\r\n")
    or f("str.is_diakhiri")($_POST['text'],$val)
    ){
        $valid = true;
        break;
    }
}
if(!$valid){
    $info = "GAGAL:<br>Teks harus mengandung " . implode("/",$must_contains_one_of) . ".";
    f("webview.errorpost")($info);
}

$banned_word = f("get_config")("banned_word",[]);
foreach($banned_word as $val){
    if(f("str.contains")($_POST['text'],$val)
    ){
        $info = "GAGAL:<br>Teks tidak boleh mengandung \"$val\".";
        f("webview.errorpost")($info);
    }
}

$last_post = f("db.select_one")("select time from posts where user_id='$userid' order by time desc");
if(!empty($last_post['time'])){
    $wait_per_post = f("get_config")("wait_per_post",0);
    $last_post_time = strtotime($last_post['time']);
    $since_last = time() - $last_post_time;
    if($since_last <= $wait_per_post){
        $info = "GAGAL:<br>Anda baru saja posting, silakan tunggu ".($wait_per_post-$since_last)." detik.";
        f("webview.errorpost")($info);
    } 
}

$txt_quota_max = f("get_config")("txt_quota_max",0);
$txt_quota_seconds = f("get_config")("txt_quota_seconds",0);
$txt_biaya = f("get_config")("txt_biaya",0);
$media_quota_max = f("get_config")("media_quota_max",0);
$media_quota_seconds = f("get_config")("media_quota_seconds",0);
$media_biaya = f("get_config")("media_biaya",0);
$output = "";
if(!empty($_FILES["fileToUpload"]["name"])){
    $output .= "Anda akan memposting media.<br>";
    $q_quota_used = "select count(1) cnt from posts where 
    user_id='$userid' 
    and is_free = '1'
    and type='img'
    and time > now() - interval $media_quota_seconds second";
    $datadb = f("db.q")($q_quota_used);
    if(!isset($datadb[0])){
        f("webview.errorpost")("Mohon maaf, data penggunaan tidak bisa didapatkan dari database, coba lagi nanti.");
    }
    $jml = $datadb[0]['cnt'];
    $output .= "Kuota digunakan sebelumnya: $jml<br>";
    $output .= "Maksimal: $media_quota_max<br>";
    if($jml < $media_quota_max){
        $is_free = "1";
        $output .= "Anda menggunakan kuota gratis!<br>";
        $jml++;
        $output .= "Kuota digunakan: $jml<br>";
    }
    else{
        $is_free = "0";
        $output .= "Anda TIDAK BISA menggunakan kuota gratis!<br>";
        $coin = $user['coin'];
        $output .= "Koin Anda: $coin<br>";
        $output .= "Biaya (media): $media_biaya<br>";
        if($coin >= $media_biaya){
            $output .= "Anda menggunakan koin.<br>";
            $coin -= $media_biaya;
            $output .= "Sisa koin Anda: $coin<br>";
            f("db.q")("update users set coin='$coin' where id = '$userid'");
        }
        else{
            f("webview.errorpost")("GAGAL:<br>$output Koin Anda tidak cukup!");
        }
    }
    $type = "img";
    $target_dir = "temp/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    $result = f("twitter.post_media")($_POST['text'],$target_file);
    /*
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
    */
}
else{
    $output .= "Anda akan memposting text.<br>";
    $q_quota_used = "select count(1) cnt from posts where 
    user_id='$userid' 
    and is_free = '1'
    and type='txt'
    and time > now() - interval $txt_quota_seconds second";
    $datadb = f("db.q")($q_quota_used);
    if(!isset($datadb[0])){
        f("webview.errorpost")("Mohon maaf, data penggunaan tidak bisa didapatkan dari database, coba lagi nanti.");
    }
    $jml = $datadb[0]['cnt'];
    $output .= "Kuota digunakan sebelumnya: $jml<br>";
    $output .= "Maksimal: $txt_quota_max<br>";
    if($jml < $txt_quota_max){
        $is_free = "1";
        $output .= "Anda menggunakan kuota gratis!<br>";
        $jml++;
        $output .= "Kuota digunakan: $jml<br>";
    }
    else{
        $is_free = "0";
        $output .= "Anda TIDAK BISA menggunakan kuota gratis!<br>";
        $coin = $user['coin'];
        $output .= "Koin Anda: $coin<br>";
        $output .= "Biaya (media): $txt_biaya<br>";
        if($coin >= $txt_biaya){
            $output .= "Anda menggunakan koin.<br>";
            $coin -= $txt_biaya;
            $output .= "Sisa koin Anda: $coin<br>";
            f("db.q")("update users set coin='$coin' where id = '$userid'");
        }
        else{
            f("webview.errorpost")("GAGAL:<br>$output Koin Anda tidak cukup!");
        }
    }
    $type = "txt";
    $result = f("twitter.post_text")($_POST['text']);
}
// echo "<pre>";
// print_r($result);
// die();
$msgid = $result->data->id;
f("db.q")(
    "insert into posts (id, time, type, user_id, is_free) 
    values ('$msgid', '".date("Y-m-d H:i:s")."', '$type', '$userid', '$is_free')"
);
$username = f("get_config")("username");
$link = "https://twitter.com/$username/status/$msgid";
// header("Location: https://twitter.com/$username/status/$msgid");
// exit();
// echo "<pre>";
// print_r($_SESSION);
// print_r($_POST);
// print_r($result);
echo "<br><h3>$output</h3>";
?>
<a href='<?=$link?>'>Lihat (otomatis dipilih dalam 10 detik)</a>
<br>
<a href='index.php'>Kembali</a>
<script>
    setTimeout(() => {
        window.location.href = "<?=$link?>";
    }, 10000);
</script>