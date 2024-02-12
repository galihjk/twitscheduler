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
        <div class="modal fade" id="topUpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="topUpModalLabel">Top Up Koin</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            Untuk Top-Up, silakan hubungi admin. ID Anda: 
                            <input class="form-control" type="text" readonly value="<?= $userid ?>" onClick="this.select();" style="text-align: center;" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    return ob_get_clean();
}
    