<?php
function webview__home__stats__msg_quota($data){
    $txt_quota_max = f("get_config")("txt_quota_max",0);
    $txt_quota_seconds = f("get_config")("txt_quota_seconds",0);
    $media_quota_max = f("get_config")("media_quota_max",0);
    $media_quota_seconds = f("get_config")("media_quota_seconds",0);
    $txt_used = 0;
    $media_used = 0;
    $secondleft_txt = false;
    $secondleft_img = false;
    $current_time = time();
    foreach($data['my_posts'] as $item){
        if($item['type'] == 'txt' and $txt_used > $txt_quota_max) continue;
        if($item['type'] == 'img' and $media_used > $media_quota_max) continue;
        if($item['type'] == 'txt'){
            if(!empty($item['is_free']) and $current_time-strtotime($item['input_time']) <= $txt_quota_seconds){
                $txt_used++;
                if($secondleft_txt === false){
                    $secondleft_txt = $txt_quota_seconds - ($current_time-strtotime($item['input_time']));
                }
            }
        }
        if($item['type'] == 'img'){
            if(!empty($item['is_free']) and $current_time-strtotime($item['input_time']) <= $media_quota_seconds){
                $media_used++;
                if($secondleft_img === false){
                    $secondleft_img = $media_quota_seconds - ($current_time-strtotime($item['input_time']));
                }
            }
        }
    }

    ob_start();
    ?>
    <div class="row no-gutters align-items-center">
        <div class="col-auto">
            <div class="h7 mb-0 mr-3 font-weight-bold text-gray-800">Pesan</div>
        </div>
        <div class="col-auto">
            <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                <?=$txt_used?>
                /
                <?=$txt_quota_max?>
            </div>
        </div>
        <?php 
        $percent = round(100*$txt_used/$txt_quota_max);
        if($percent > 80){
            $color = "danger";
        }
        elseif($percent > 60){
            $color = "warning";
        }
        elseif($percent > 30){
            $color = "success";
        }
        else{
            $color = "info";
        }
        ?>
        <div class="col">
            <div class="progress progress-sm mr-2">
                <div class="progress-bar bg-<?=$color?>" role="progressbar"
                    style="width: <?=$percent?>%" aria-valuenow="<?=$percent?>" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-right mb-1 font-italic"><small id='secondleft_txt'></small></div>
    </div>
    <div class="row no-gutters align-items-center">
        <div class="col-auto">
            <div class="h7 mb-0 mr-3 font-weight-bold text-gray-800">Media</div>
        </div>
        <div class="col-auto">
            <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                <?=$media_used?>
                /
                <?=$media_quota_max?>
            </div>
        </div>
        <?php 
        $percent = round(100*$media_used/$media_quota_max);
        if($percent > 80){
            $color = "danger";
        }
        elseif($percent > 60){
            $color = "warning";
        }
        elseif($percent > 30){
            $color = "success";
        }
        else{
            $color = "info";
        }
        ?>
        <div class="col">
            <div class="progress progress-sm mr-2">
                <div class="progress-bar bg-<?=$color?>" role="progressbar"
                    style="width: <?=$percent?>%" aria-valuenow="<?=$percent?>" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-right font-italic"><small id='secondleft_img'></small></div>
    </div>
    
    <?php
    if(!empty($txt_used)){
        f("webview._component.js.second_to_time")();
        ?>
        <script>
            var secondleft_txt = <?=$secondleft_txt?>;
            function set_txt_time(){
                secondleft_txt--;
                if(secondleft_txt <= 0){
                    $("#secondleft_txt").html("<small>Please <a href='.'>refresh</a></small>");
                }
                else{
                    $("#secondleft_txt").html(second_to_time(secondleft_txt));
                    setTimeout(() => {
                        set_txt_time();
                    }, 1000);
                }
            }
            setTimeout(() => {
                set_txt_time();
            }, 1000);
        </script>
        <?php
    }
    if(!empty($media_used)){
        f("webview._component.js.second_to_time")();
        ?>
        <script>
            var secondleft_img = <?=$secondleft_img?>;
            function set_img_time(){
                secondleft_img--;
                if(secondleft_img <= 0){
                    $("#secondleft_img").html("<small>Please <a href='.'>refresh</a></small>");
                }
                else{
                    $("#secondleft_img").html(second_to_time(secondleft_img));
                    setTimeout(() => {
                        set_img_time();
                    }, 1000);
                }
            }
            setTimeout(() => {
                set_img_time();
            }, 1000);
        </script>
        <?php
    }
    return ob_get_clean();
}