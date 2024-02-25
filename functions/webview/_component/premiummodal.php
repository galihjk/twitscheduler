<?php
function webview___component__premiummodal(){
    ?>
    <div class="modal fade" id="premiumModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="premiumModalLabel">Akun Premium</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        Underconstruction
                        <input class="form-control" type="text" readonly value="<?= $_SESSION['access_token']['user_id'] ?>" onClick="this.select();" style="text-align: center;" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}
    