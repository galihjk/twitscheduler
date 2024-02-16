<?php
function webview__home__scheduled_list($data){
    ?>
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-primary mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Tweet Anda</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Twit</th>
                            <th scope="col">Media</th>
                            <th scope="col">Jadwal Posting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">1</th>
                            <td>Mark ojasdlojosidjfo Mark ojasdlojosidjfo Mark ojasdlojosidjfo Mark ojasdlojosidjfo Mark ojasdlojosidjfo Mark ojasdlojosidjfo Mark ojasdlojosidjfo Mark ojasdlojosidjfo Mark ojasdlojosidjfo </td>
                            <td>Otto</td>
                            <td>@mdo</td>
                            </tr>
                            <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                            </tr>
                            <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php    
    return true;
}
    