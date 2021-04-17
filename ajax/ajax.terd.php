<?php
    require_once('../config.php');
    $nperlist = 5;
?>
<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'terdList'){
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
        $sql1 = mysqli_query($conn,"SELECT * FROM peternak inner join user on peternak.id_user=user.id_user where id_kop='$id_k' and kop_stat = 1 ".$srch." order by id_pt desc LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
        //$id = mysqli_insert_id($sql);
        echo '<div class="row m-1 mt-3">';
        foreach($row as $r){
            ?>
            <!--<div id="daft-row-<?php echo $r['id_user'];?>" class="row list m-1" style="border: 1pt solid #dcdcdc;">
                <div class="col-3"><?php echo $r['nama']?></div>
                <div class="col-3"><?php echo $r['pend_pt']?></div>
                <div class="col-2"><?php echo $r['thn_mulai']?></div>
                <div class="col-4">
                    <a target="_blank" href="<?php BASE_URL?>profile/?r=peternak&v=<?php echo $r['id_user']?>"><i>Lihat Profil</i></a>
                    <i style="margin-left:10px;cursor: pointer;color:#d44950;" onclick="delTerd(<?php echo $r['id_user'];?>)"> <i class="fas fa-times" style="color:#d44950;"></i> Hapus</i>
                </div>
            </div>-->
            <div class="col-sm-4 p-2">
                <div class="card p-3">
                    <h5><?php echo $r['nama']?></h5>
                    <p><?php echo $r['pend_pt']?></p>
                    <p><?php echo $r['thn_mulai']?></p>
                    <span style="font-size: 8pt;">
                    <a target="_blank" href="<?php echo BASE_URL?>peternak/<?php echo $r['uname']?>"><i>Lihat Profil</i></a>
                    <i style="margin-left:10px;cursor: pointer;color:#d44950;" onclick="delTerd(<?php echo $r['id_user'];?>)"> <i class="fas fa-trash" style="color:#d44950;"></i> Hapus</i>
                    </span>
                </div>
            </div>
            
            <?php
        }
        echo '</div>';
        $n = mysqli_num_rows($sql1);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada Terdaftar</div>
        <?php 
        }else{
            $sql = mysqli_query($conn,"SELECT * FROM peternak inner join user on peternak.id_user=user.id_user where id_kop='$id_k' and kop_stat = 1 ".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#terd')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
                <?php
            }
            ?>
                </div>
            <?php
        }
        
    }

    if(isset($_POST['mode']) && $_POST['mode'] == 'delTerd'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"UPDATE peternak set id_kop= NULL, kop_stat=0 where id_user = '$id'");
    }
?>



