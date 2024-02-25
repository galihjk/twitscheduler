<?php
function webview__home__stats($data){
    // f("webview._component.statcard")([
    //     'color'=>'success',
    //     'title'=>'Kuota Utama Terpakai Saat Ini',
    //     'icon'=>'fa-clock',
    //     'content'=>f("webview.home.stats.main_quota")($data),
    // ]);
    f("webview._component.statcard")([
        'width'=>'5',
        'color'=>'danger',
        'title'=>'Kuota Gratis Terpakai Anda',
        'icon'=>'fa-pencil',
        'content'=>f("webview.home.stats.msg_quota")($data),
    ]);
    f("webview._component.statcard")([
        'width'=>'3',
        'color'=>'warning',
        'title'=>'Koin Anda',
        'icon'=>'fa-coins',
        'content'=>f("webview.home.stats.coin")($data),
    ]);
    f("webview._component.statcard")([
        'width'=>'4',
        'color'=>'info',
        'title'=>'Akun Premium',
        'icon'=>'fa-crown',
        'content'=>f("webview.home.stats.premium")($data),
    ]);
    return true;
}