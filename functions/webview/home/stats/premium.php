<?php
function webview__home__stats__premium($data){
    ob_start();
    $user = f("user.get")();
    $userid = $user['id'];
    ?>
        <div class="mb-0 font-weight-bold text-gray-800">
            <h1>
            <i class="fa fa-crown fa-2x text-warning"></i>
                <a href="#" class=" btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#premiumModal">
                    <i class="fas fa-crown fa-sm text-text-warning"></i> Akun Premium
                </a>
            </h1>
        </div>
    <?php
    return ob_get_clean();
}
    