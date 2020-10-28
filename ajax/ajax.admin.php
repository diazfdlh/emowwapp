<?php
    require_once('../config.php');
    $nperlist = 5;
?>

<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'useractList'){
        $cp = $_POST['cp'];
        $rStart = $nperlist * ($cp - 1);
        $q = $_POST['q'];
        if($q){
            $srch = " AND nama LIKE '%".$q."%'";
        }else{
            $srch = '';
        }
        $sql = mysqli_query($conn,"SELECT * FROM user WHERE status = 0".$srch." LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        foreach($row as $r){
            ?>
            <div id="useract-row-<?php echo $r['id_user'];?>" class="row list mt-1 mb-1" style="border: 1pt solid #dcdcdc;">
                <div class="col-2"><?php echo $r['nama']?></div>
                <div class="col-2"><?php echo $r['uname']?></div>
                <div class="col-3"><?php echo $r['email']?></div>
                <div class="col-2"><?php echo $r['role']?></div>
                <div class="col-2"><?php echo $r['created']?></div>
                <div class="col-1">
                    <i class="fas fa-check-square" style="cursor: pointer;color:#019961;" onclick="userAct(<?php echo $r['id_user'];?>,1,'<?php echo $r['nama'];?>')"></i>
                    <i class="fas fa-times" style="cursor: pointer;color:#d44950;" onclick="userAct(<?php echo $r['id_user'];?>,0,'<?php echo $r['nama'];?>')"></i>
                </div>
            </div>
            <?php
        }
        $n = mysqli_num_rows($sql);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada pendaftar</div>
        <?php 
        }else{
            $sql = mysqli_query($conn,"SELECT * FROM user WHERE status = 0".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#useract')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
                <?php
            }
            ?>
                </div>
            <?php
        }
        
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'userAct'){
        $id = $_POST['id'];
        $sql=mysqli_query($conn,"SELECT * from user WHERE id_user='$id'");
        $data = mysqli_fetch_assoc($sql);
        if($_POST['a'] == 1){
            $sql=mysqli_query($conn,"UPDATE user set status = 1 WHERE id_user='$id'");
            if($data['role'] == 'admin'){
                
            }elseif($data['role'] == 'peternak'){
                $sql=mysqli_query($conn,"SELECT * FROM peternak WHERE id_user='$id'");
                if(!mysqli_num_rows($sql)){
                    $sql=mysqli_query($conn,"INSERT INTO peternak (id_user,last_seen) VALUES ('$id',now())");
                }
            }elseif($data['role'] == 'ahli'){
                $sql=mysqli_query($conn,"SELECT * FROM ahli WHERE id_user='$id'");
                if(!mysqli_num_rows($sql)){
                    $sql=mysqli_query($conn,"INSERT INTO ahli (id_user,last_seen,avail) VALUES ('$id',now(),0)");
                }
            }elseif($data['role'] == 'deauthor'){
                $sql=mysqli_query($conn,"SELECT * FROM deauthor WHERE id_user='$id'");
                if(!mysqli_num_rows($sql)){
                    $sql=mysqli_query($conn,"INSERT INTO deauthor (id_user) VALUES ('$id')");
                }
            }elseif($data['role'] == 'koperasi'){
                $sql=mysqli_query($conn,"SELECT * FROM koperasi WHERE id_user='$id'");
                if(!mysqli_num_rows($sql)){
                    $sql=mysqli_query($conn,"INSERT INTO koperasi (id_user) VALUES ('$id')");
                }
            }
            echo '<div style="padding:10px;background:#019961;color:#fff">Berhasil Aktivasi '.$data['nama'].'</div>';
        }else{
            $sql=mysqli_query($conn,"DELETE FROM user where id_user='$id'");
            echo '<div style="padding:10px;background:#019961;color:#fff">Berhasil Hapus '.$data['nama'].'</div>';
        }
    }
?>


<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'cp'){
        $id=$_POST['id'];
        $cp=md5($_POST['cp']);
        //echo $_POST['p1'];
        $ps=md5($_POST['p1']);
        $sql = mysqli_query($conn,"SELECT * FROM user WHERE id_user = '$id' and pass = '$cp'");
        if(mysqli_num_rows($sql)){
            $sql = mysqli_query($conn,"UPDATE user set pass = '$ps' WHERE id_user='$id'");
            if($sql){echo '<div style="padding:10px;background:#019961;color:#fff">Berhasil Mengubah Password</div>';}
        }else{
            echo '<div style="padding:10px;background:#d44950;color:#fff">Password Sekarang anda salah</div>';
        }
        
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'save'){
        $un = $_POST['un'];
        $e = $_POST['e'];
        $n = $_POST['n'];
        $id= $_POST['id'];
        $sql = mysqli_query($conn,"UPDATE user set nama='$n', email='$e', uname='$un' WHERE id_user='$id'");
        $_SESSION['user']['nama'] = $n;
        $_SESSION['user']['email'] = $e;
        $_SESSION['user']['uname'] = $un;
        if($sql){echo '<div style="padding:10px;background:#019961;color:#fff">Berhasil Mengubah Info</div>';}
    }
?>



<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'usermanajList'){
        $cp = $_POST['cp'];
        $rStart = $nperlist * ($cp - 1);
        $q = $_POST['q'];
        if($q){
            $srch = " AND nama LIKE '%".$q."%'";
        }else{
            $srch = '';
        }
        $sql = mysqli_query($conn,"SELECT * FROM user WHERE status = 1".$srch." LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        foreach($row as $r){
            ?>
            <div id="usermanaj-row-<?php echo $r['id_user'];?>" class="row list mt-1 mb-1" style="border: 1pt solid #dcdcdc;">
                <div class="col-2"><?php echo $r['nama']?></div>
                <div class="col-2"><?php echo $r['uname']?></div>
                <div class="col-3"><?php echo $r['email']?></div>
                <div class="col-2"><?php echo $r['role']?></div>
                <div class="col-2"><?php echo $r['created']?></div>
                <div class="col-1">
                    <i class="fas fa-ban" style="cursor: pointer;color:#d44950;" onclick="openPop('Nonaktifkan <?php echo $r['nama'];?>?','ban',1,'<?php echo $r['id_user'];?>')"></i>
                </div>
            </div>
            <?php
        }
        $n = mysqli_num_rows($sql);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada User terdaftar</div>
        <?php 
        }else{
            $sql = mysqli_query($conn,"SELECT * FROM user WHERE status = 1".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#usermanaj')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
                <?php
            }
            ?>
                </div>
            <?php
        }
        
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'ban'){
        $id = $_POST['id'];
        $sql=mysqli_query($conn,"UPDATE user set status = 0 WHERE id_user='$id'");
        $sql=mysqli_query($conn,"SELECT * FROM user WHERE id_user='$id'");
        $data = mysqli_fetch_assoc($sql);
        echo '<div style="padding:10px;background:#019961;color:#fff">Berhasil Menonaktifkan '.$data['nama'].'</div>';
    }
?>