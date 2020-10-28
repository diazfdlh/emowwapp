<?php
    require_once('../config.php');
?>

<?php
if(isset($_POST['mode']) && $_POST['mode'] == 'save'){
    $id = $_SESSION['user']['id_user'];
    $un = $_POST['un'];
    $e = $_POST['e'];
    $un2 = $_POST['un2'];
    $e2 = $_POST['e2'];
    $n = $_POST['n'];
    if($un!=$un2){
        $sqln = mysqli_query($conn,"SELECT * FROM user where uname='$un'");
        if(mysqli_num_rows($sqln)){
            $sqln = 1;
        }else{
            $sqln = 0;
        }
    }else{
        $sqln = 0;
    }
    if($e!=$e2){
        $sqle = mysqli_query($conn,"SELECT * FROM user where email='$e'");
        if(mysqli_num_rows($sqle)){
            $sqle = 1;
        }else{
            $sqle = 0;
        }
    }else{
        $sqle = 0;
    }
    if($sqln == 0 && $sqle == 0){
        $sql = mysqli_query($conn,"UPDATE user set nama='$n', email='$e', uname='$un' WHERE id_user='$id'");
        if($sql){
            $_SESSION['user']['nama'] = $n;
            $_SESSION['user']['email'] = $e;
            $_SESSION['user']['uname'] = $un;
            if($_SESSION['user']['role']=='ahli'){
                $pend = $_POST['pend'];
                $thn = $_POST['thn'];
                $kat = $_POST['kat'];
                $sql = mysqli_query($conn,"UPDATE ahli set kat='$kat', pend_ah='$pend', thn_mulai='$thn' WHERE id_user='$id'");
            }else if($_SESSION['user']['role']=='peternak'){
                $pend = $_POST['pend'];
                $thn = $_POST['thn'];
                $ttl = $_POST['ttl'];
                $sql = mysqli_query($conn,"UPDATE peternak set ttl='$ttl', pend_pt='$pend', thn_mulai='$thn' WHERE id_user='$id'");
            }else if($_SESSION['user']['role']=='koperasi'){
                $nk = $_POST['nk'];
                $tgl = $_POST['tgl'];
                $sej = $_POST['sej'];
                $alamat = $_POST['alamat']; 
                $sql = mysqli_query($conn,"UPDATE koperasi set tgl='$tgl', nama_kp='$nk', sejarah='$sej', alamat='$alamat' WHERE id_user='$id'");
            }else if($_SESSION['user']['role']=='deauthor'){
                $pend = $_POST['pend']; 
                $sql = mysqli_query($conn,"UPDATE deauthor set pend_de='$pend' WHERE id_user='$id'");
            }
            if($sql){echo '<div style="padding:10px;background:#019961;color:#fff">Berhasil Mengubah Info</div>';}
        }else{
            echo 'ERRORxx Contact Admin Support';
        }
            
    }else if ($sqln == 1){
        echo '<div style="padding:10px;background:red;color:#fff">Username sudah ada, coba yang lain</div>';
    }else{
        echo '<div style="padding:10px;background:red;color:#fff">Email sudah ada, coba yang lain</div>';
    }
    
}
?>