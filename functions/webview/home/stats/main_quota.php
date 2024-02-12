<?php
function webview__home__stats__main_quota($data){
    ob_start();
    $start = time()-24*60*60;
    // $end = time();
    ?>
    <div class="row no-gutters align-items-center">
        <div class="col-auto">
            <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                <?=$data['base_quota_used']?>
                /
                <?=$data['base_quota_max']?>
            </div>
        </div>
        <?php 
        $percent = round(100*$data['base_quota_used']/$data['base_quota_max']);
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
    <div class="row no-gutters align-items-center">
        <div class="col">
            <div class="my-3"><?=date("H:i:s (d/m/Y)")?></div>
        </div>
    </div>
    <div class="row no-gutters align-items-center">
        <div class="col text-right">
            <div id="base_tunggu_kuota" class='font-italic'></div>
        </div>
    </div>
    <?php  ?>
    <?php
    if(!empty($data['base_quota_used'])){
        f("webview._component.js.second_to_time")();
        ?>
        <script>
        var base_tunggu_kuota = <?=$data['base_tunggu_kuota']?>;
        function set_base_time(){
            base_tunggu_kuota--;
            if(base_tunggu_kuota <= 0){
                $("#base_tunggu_kuota").html("<small>Please <a href='.'>refresh</a></small>");
            }
            else{
                $("#base_tunggu_kuota").html(second_to_time(base_tunggu_kuota));
                setTimeout(() => {
                    set_base_time();
                }, 1000);
            }
        }
        setTimeout(() => {
            set_base_time();
        }, 1000);
    </script>
        <?php
    }
    ?>
    
    <?php
    return ob_get_clean();
}