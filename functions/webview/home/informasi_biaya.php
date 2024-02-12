<?php
function webview__home__informasi_biaya(){
    ?>
    <ul>
        <li>
            Jika mencantumkan gambar, kuota dan biaya yang diterapkan adalah "Media".
        </li>
        <li>
            Jika kuota gratis habis, akan dikenakan biaya:
            <ul>
                <li>Media: <strong><?=f("get_config")("media_biaya")?> koin</strong>.</i>
                <li>Tanpa Media: <strong><?=f("get_config")("txt_biaya")?> koin</strong>.</i>
            </ul>
        </li>
    </ul>
    <?php
    return true;
}
    