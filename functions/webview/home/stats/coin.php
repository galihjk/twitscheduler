<?php
function webview__home__stats__coin($data){
    ob_start();
    $user = f("user.get")();
    $userid = $user['id'];
    ?>
        <div class="mb-0 font-weight-bold text-gray-800">
            <h1>
                <?=$user['coin']?>
                <a href="#" class=" btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#topUpModal">
                    <i class="fas fa-sack-dollar fa-sm text-white-50"></i> Top Up
                </a>
            </h1>
        </div>
    <?php
    return ob_get_clean();
}
    