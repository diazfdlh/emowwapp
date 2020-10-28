<?php
    require_once('../config.php');
    $nperlist = 5;
?>
<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'daftList'){
        $cp = $_POST['cp'];
        $id=$_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"SELECT id_koperasi FROM koperasi where id_user='$id'");
        $row = mysqli_fetch_assoc($sql);
        $id_k = $row['id_koperasi'];
        $rStart = $nperlist * ($cp - 1);
        $q = $_POST['q'];
        if($q){
            $srch = "AND user.nama LIKE '%".$q."%'";
        }else{
            $srch = '';
        }
        $sql1 = mysqli_query($conn,"SELECT * FROM peternak inner join user on peternak.id_user=user.id_user where id_kop='$id_k' and kop_stat = 0 ".$srch." order by id_pt desc LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
        //$id = mysqli_insert_id($sql);
        echo '<div class="row m-1 mt-3">';
        foreach($row as $r){
            ?>
            <div class="col-sm-4 p-2">
                <div class="card p-3">
                    <h5><?php echo $r['nama']?></h5>
                    <p><?php echo $r['pend_pt']?></p>
                    <p><?php echo $r['thn_mulai']?></p>
                    <span style="font-size: 8pt;">
                    <a target="_blank" href="<?php BASE_URL?>profile/?r=peternak&v=<?php echo $r['id_user']?>"><i>Lihat Profil</i></a>
                    <i style="margin-left:10px;cursor: pointer;color:#077703;" onclick="acc(<?php echo $r['id_user'];?>)"> <i class="fas fa-user-plus" style="color:#077703;"></i> Terima</i>
                    <i style="margin-left:10px;cursor: pointer;color:#d44950;" onclick="rej(<?php echo $r['id_user'];?>)"> <i class="fas fa-times" style="color:#d44950;"></i> Tolak</i>
                    </span>
                </div>
            </div>
            <?php
        } echo '</div>';
        $n = mysqli_num_rows($sql1);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada Pendaftar</div>
        <?php 
        }else{
            $sql = mysqli_query($conn,"SELECT * FROM peternak inner join user on peternak.id_user=user.id_user where id_kop='$id_k' and kop_stat = 0 ".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#pend')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
                <?php
            }
            ?>
                </div>
            <?php
        }
        
    }

?>
<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'acc'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"UPDATE peternak set kop_stat = 1 where id_user = '$id'");
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'rej'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"UPDATE peternak set id_kop= NULL,kop_stat=0 where id_user = '$id'");
    }
?>



