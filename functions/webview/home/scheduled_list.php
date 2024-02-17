<?php
function webview__home__scheduled_list($data){
    // dump($data);
    $list_limit = f("get_config")("list_limit",10);
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-primary mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tweet Anda</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="text-right mb-1">
                        <a href="create.php" class="btn btn-sm btn-primary shadow-sm" onclick="this.form.submit(); this.disabled=true; this.value='Mengirim...'; ">
                            <i class="fa fa-sm fa-calendar-plus text-white"></i> Buat Postingan
                        </a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Twit</th>
                            <th scope="col">Jadwal Posting</th>
                            <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach($data['my_posts'] as $item){
                                ?>
                                <tr>
                                    <th scope="row"><?=$no?></th>
                                    <td>
                                        <?php
                                        if(!empty($item['media'])){
                                            ?>
                                            <img src="scheduled_media/<?=$item['media']?>" style="max-width:100px;max-height:100px;" />
                                            <?php
                                        }
                                        ?>
                                        <?=nl2br(str_replace("<","&lt;",$item['text']))?> 
                                    </td>
                                    <td><?=$item['schedule']?></td>
                                    <td>-</td>
                                </tr>
                                <?php
                                $no++;
                                if($no > $list_limit){
                                    ?>
                                    <tr><td><?=$no?></td><td colspan="3">
                                        <small class="text-muted font-italic">*Postinganmu mungkin lebih dari ini..</small>
                                    </td></tr>
                                    <?php
                                }
                            }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php    
    return true;
}
    