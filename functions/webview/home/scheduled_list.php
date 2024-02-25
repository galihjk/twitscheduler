<?php
function webview__home__scheduled_list($data){
    // dump($data);
    $screen_name = $_SESSION['access_token']['screen_name'];
    $list_limit = f("get_config")("txt_quota_max",0)+f("get_config")("media_quota_max",0);
    ?>
    <style>
        .errorbox{
            max-width: 170px;
            max-height: 100px;
            overflow: auto;
            font-size: small;
            border-style: solid;
            border-width: thin;
            border-color: lightgray;
            margin-bottom: 0;
        }
        .scheduledmedia{
            max-width: 100px;
            max-height: 100px;
            float: left;
            margin-right: 10px;
        }
        .postedmedia{
            width: 100px;
            float: left;
            margin-right: 10px;
            font-size: small;
        }
    </style>
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
                                        if(!empty($item['media']) and $item['status'] != 'success'){
                                            ?>
                                            <img class="scheduledmedia" src="scheduled_media/<?=$item['media']?>" style="max-width:100px;max-height:100px;" />
                                            <?php
                                        }
                                        elseif(!empty($item['media']) and $item['status'] == 'success'){
                                            ?>
                                            <div class="bg-info text-white p-2 rounded text-center postedmedia"><i class="fa fa-image"></i><br>Gambar sudah diposting</div>
                                            <?php
                                        }
                                        ?>
                                        <?=nl2br(str_replace("<","&lt;",$item['text']))?> 
                                    </td>
                                    <td><?=$item['schedule']?></td>
                                    <td>
                                        <?php
                                        if($item['status'] == 'success'){
                                            $time = json_decode($item['info'],true)[0];
                                            ?>
                                            <span class="text-success">Sukses</span> (<?=$time?>)
                                            <a target="_blank" href="https://twitter.com/<?=$screen_name?>/status/<?=$item['msg_id']?>">Lihat <i class="fa fa-external-link"></i></a>
                                            <?php
                                        }
                                        elseif($item['status'] == 'fail'){
                                            $info = json_decode($item['info'],true);
                                            ?>
                                            <strong class='text-danger'>Gagal</strong> (<?=$info[0]?>):
                                            <pre class="errorbox"><?=print_r($info[1],true)?></pre>
                                            Silakan hubungi admin.
                                            <?php
                                        }
                                        elseif($item['status'] == 'suspend'){
                                            ?>
                                            <div class="text-warning">Ditunda </div><small class="text-muted">*Sedang dalam antrian, mohon bersabar..</small>
                                            <?php
                                        }
                                        elseif($item['status'] == ''){
                                            ?>
                                            <small class="text-muted">Belum diposting</small>
                                            <button type="button" 
                                            class="btn btn-sm btn-secondary"
                                            onclick="alert('Untuk mengubah/menghapus ini, silakan hubungi admin. Id post=<?=$item['id']?>')">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <?php
                                        }
                                        else{
                                            echo "Mohon maaf, terjadi kesalahan. Silakan hubungi admin.";
                                        }
                                        ?>
                                    </td>
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
    