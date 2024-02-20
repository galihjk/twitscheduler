<?php
function user__get($userid = "current", $noupdate = false){
    if($userid == "current"){
        $userid = $_SESSION['access_token']['user_id'];
    }
    if($noupdate){
        if(!empty($GLOBALS["user$userid"])){
            return $GLOBALS["user$userid"];
        }
        $userdata = f("db.select_one")("select * from users where id = ".f("str.dbq")($userid,true));
        $GLOBALS["user$userid"] = $userdata;
        return $userdata;
    }
    return f("db.select_one")("select * from users where id = ".f("str.dbq")($userid,true));
}