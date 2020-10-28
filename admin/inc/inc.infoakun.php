<h3>INFORMASI AKUN</h3>
<div class="userinfo-msg"></div>
<div class="row">
    <div class="col-3">
        <div class="dp">
            <div style="position: relative;cursor:pointer">
                <img id="dp" src="<?php echo DP_DIR.$_SESSION['user']['dp'].'.png'?>" alt="">
                <input type="file" id="dp-file" style="display: none;">
                <label for="dp-file" class="dp-change"><i class="fas fa-camera"></i></label>
            </div>
        </div>
        <div id="crop-mod">
            <div class="overlay"></div>
            <div id="crop-wrap" class="card-nb">
                <div id="crop-head" class="row">
                    <div class="col-3">
                        <div id="crop-close" class="chat-btn"><i class="fas fa-arrow-left"></i></div>
                    </div>
                    <div class="col-6">
                        <h4>UPLOAD PROFILE</h4>
                    </div>
                    <div class="col-3">
                        <div id="apply-img" class="btn-chat p-2">SIMPAN</div>
                    </div>
                </div>
                <div id="crop-body" style="width: 100%;overflow:hidden;"></div>
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="row mt-1 mb-1">
            <div class="col-sm-5">USERID</div>
            <div class="col-sm-7">
                <?php 
                $tgl = $_SESSION['user']['created'];
                $string = preg_replace('/[^a-zA-Z0-9]/', '', $tgl);
                //date_format($_SESSION['user']['created'],Ymd);
                echo 'U'.$string.$_SESSION['user']['id_user'];
                ?>
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5">Nama Lengkap</div>
            <div class="col-sm-7">
                <input type="text" id="nama" value="<?php echo $_SESSION['user']['nama']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5">UserName</div>
            <div class="col-sm-7">
                <input type="text" id="uname" value="<?php echo $_SESSION['user']['uname']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5">Email</div>
            <div class="col-sm-7">
                <input type="email" id="email" value="<?php echo $_SESSION['user']['email']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"></div>
            <div class="col-sm-7">
                <div class="btn-daftar" onclick="saveInfo()">SIMPAN</div>
                <div class="btn-daftar dissabled">
                    <div class="spinner" style="width: 20px; height:20px; margin:5px auto">
                        <div class="dot1"></div>
                        <div class="dot2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>