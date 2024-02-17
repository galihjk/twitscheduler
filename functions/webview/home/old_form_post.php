<?php
function webview__home__form_post($data){
    $barusan_posting = false;
    if(!empty($data['my_posts'])){
        $last_post = end($data['my_posts']); 
        $wait_per_post = f("get_config")("wait_per_post",0);
        $last_post_time = strtotime($last_post['input_time']);
        $since_last = time() - $last_post_time;
        if($since_last <= $wait_per_post){
            $barusan_posting = true;
        } 
    }
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-primary mb-4">
                <?php
                if($barusan_posting){
                    ?>
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-danger text-white">
                        <h6 class="m-0 font-weight-bold text-white">Anda baru saja melakukan input</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body bg-light-danger">
                        Anda baru saja melakukan input, silakan tunggu, lalu nanti refresh kembali.
                    </div>
                    <?php
                }
                elseif ($data['allow_post']){
                    ?>
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Buat Postingan Baru</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <form action="post.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <textarea class="form-control" name="text" placeholder="Tulis pesanmu di sini.."></textarea>
                                    <div class="text-right">
                                        <small> Sesuaikan dengan ketentuan </small>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group row">
                                        <label for="fileToUpload" class="col-sm-2 col-form-label">Media</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" accept="image/*" placeholder="upload gambar">
                                            <small>
                                                (Jika menambahkan media, biaya media akan diterapkan) 
                                                <button type="button" onclick="document.getElementById('fileToUpload').value=''" style='font-size: smaller;'>kosongkan media</button>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 mb-3">
                                    <div class="form-group row">
                                        <label for="schedule" class="col-sm-3 col-form-label">Jadwal Posting</label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="datetime-local" 
                                            min="<?=date("Y-m-d").'T'.date("H:i", time()+120)?>"
                                            value="<?=date("Y-m-d").'T'.date("H:i", time()+120)?>"
                                            name="schedule" id="schedule" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="mt-2 text-right pr-4">
                                        <button type="submit" class=" btn btn-lg btn-primary shadow-sm" onClick="this.form.submit(); this.disabled=true; this.value='Mengirim...'; ">
                                            <i class="fa fa-sm fa-calendar-plus text-white"></i> Buat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                }
                else{
                    ?>
                    <div
                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-danger text-white">
                        <h6 class="m-0 font-weight-bold text-white">Tidak Bisa Membuat Postingan</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body bg-light-danger">
                        Kuota utama telah mencapai batas maksimum. Silakan tunggu.
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
   
    

    <?php    
    return true;
}
    