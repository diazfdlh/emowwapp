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
                <input type="text" hidden id="uname2" value="<?php echo $_SESSION['user']['uname']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5">Email</div>
            <div class="col-sm-7">
                <input type="email" id="email" value="<?php echo $_SESSION['user']['email']?>" class="form-control">
                <input type="email" hidden id="email2" value="<?php echo $_SESSION['user']['email']?>" class="form-control">
            </div>
        </div>
        <?php if($_SESSION['user']['role']=='ahli'){
            $id =$_SESSION['user']['id_user'];
            $sql = mysqli_query($conn,"SELECT * FROM ahli where id_user='$id'");
            $row = mysqli_fetch_assoc($sql);    
        ?>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"><i class="fas fa-graduation-cap"></i> Pendidikan</div>
            <div class="col-sm-7">
                <input type="text" id="pend" value="<?php echo $row['pend_ah']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"><i class="fas fa-clock"></i>  Sejak</div>
            <div class="col-sm-7">
                <input type="number" maxlength="4" id="thn" value="<?php echo $row['thn_mulai']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5">Sebagai</div>
            <div class="col-sm-7">
                <select id="kat" class="form-control">
                    <option value="penyuluh" <?php if($row['kat']=='penyuluh'){echo'selected';} ?>>Penyuluh</option>
                    <option value="inseminator" <?php if($row['kat']=='inseminator'){echo'selected';} ?>>Inseminator</option>
                </select>
            </div>
        </div>
        <?php } ?>
        
        <?php if($_SESSION['user']['role']=='peternak'){
            $id =$_SESSION['user']['id_user'];
            $sql = mysqli_query($conn,"SELECT * FROM peternak where id_user='$id'");
            $row = mysqli_fetch_assoc($sql);    
        ?>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5">Tempat Tanggal Lahir</div>
            <div class="col-sm-7">
                <input required type="date" id="ttl" value="<?php echo $row['ttl']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"><i class="fas fa-graduation-cap"></i> Pendidikan</div>
            <div class="col-sm-7">
                <input required type="text" id="pend" value="<?php echo $row['pend_pt']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"><i class="fas fa-clock"></i>  Sejak</div>
            <div class="col-sm-7">
                <input required type="number" maxlength="4" id="thn" value="<?php echo $row['thn_mulai']?>" class="form-control">
            </div>
        </div>
        <?php } ?>
        
        <?php if($_SESSION['user']['role']=='koperasi'){
            $id =$_SESSION['user']['id_user'];
            $sql = mysqli_query($conn,"SELECT * FROM koperasi where id_user='$id'");
            $row = mysqli_fetch_assoc($sql);    
        ?>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5">Nama Koperasi</div>
            <div class="col-sm-7">
                <input type="text" id="nk" value="<?php echo $row['nama_kp']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"><i class="fas fa-clock"></i>  Sejak</div>
            <div class="col-sm-7">
                <input type="date" maxlength="4" id="tgl" value="<?php echo $row['tgl']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"><i class="fas fa-landmark"></i> Sejarah</div>
            <div class="col-sm-7">
                <input type="text" id="sej" value="<?php echo $row['sejarah']?>" class="form-control">
            </div>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"><i class="fas fa-map-marked-alt"></i> Alamat</div>
            <div class="col-sm-7">
                <input type="text" id="alamat" value="<?php echo $row['alamat']?>" class="form-control">
            </div>
        </div>
        <?php } ?>
        
        <?php if($_SESSION['user']['role']=='deauthor'){
            $id =$_SESSION['user']['id_user'];
            $sql = mysqli_query($conn,"SELECT * FROM deauthor where id_user='$id'");
            $row = mysqli_fetch_assoc($sql);    
        ?>
        <div class="row mt-1 mb-1">
            <div class="col-sm-5"><i class="fas fa-graduation-cap"></i> Pendidikan</div>
            <div class="col-sm-7">
                <input type="text" id="pend" value="<?php echo $row['pend_de']?>" class="form-control">
            </div>
        </div>
        <?php } ?>
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