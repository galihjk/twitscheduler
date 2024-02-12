<?php
function webview__home__ketentuan(){
    ?>
    <ol>
        <li>
            Teks harus mengandung setidaknya satu dari:
            <ul>
                <?php
                foreach(f("get_config")("must_contains_one_of",[]) as $item){
                    echo "<li>$item</li>";
                }
                ?>
            </ul>
        </li>
        <li>
            KUOTA MENFESS adalah kuota yang bisa dipakai menfess saat ini, jika sudah terpakai semua, silakan tunggu sampai ada kuota lagi untuk bisa melakukan posting. Jika masih ada kuota, silakan gunakan,siapa cepat dia dapat.
        </li>
        <li>
            KUOTA GRATIS adalah kuota yang bisa anda gunakan secara gratis, baik itu dengan media, atau tanpa media.
        </li>
        <li>
            Saat ini, media yang disupport adalah gambar.
        </li>
    </ol>
    <?php
    return true;
}
    