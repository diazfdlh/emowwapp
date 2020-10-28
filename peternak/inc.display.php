<?php
$un = $_GET['un'];
$sql = mysqli_query($conn,"SELECT * FROM user inner join peternak on user.id_user=peternak.id_user WHERE uname = '$un'");
$row = mysqli_fetch_assoc($sql);
//echo "<p>Time Passed: " . $years . " Years, " . $days . " Days, " . $hours . " Hours, " . $mins . " Minutes.</p>";
if($row['thn_mulai']==null){
    $thn = 'N/A';
}else{
    $thn = date("Y",time()) - substr($row['thn_mulai'], 0, 4);
}
?>
<div class="card-nb p-5" style="width: 500px;margin:150px auto;">
    <div class="dp" style="width:150px;margin:0 auto;border: 2pt solid #077703">
        <div>
            <img src="<?php echo DP_DIR.$row['dp'].'.png'?>" alt="">
        </div>
    </div>
    <h2 style="text-align: center;"><?php echo $row['nama'];?></h2>
    <div class="row" style="max-width:400px;margin:10px auto;">
        <div class="col-1" style="text-align: center;">
            <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="col-11">
            <h5>Lulusan Dari</h5>
            <?php if($row['pend_pt']){
                echo $row['pend_pt'];
            }else{
                echo 'N/A';
            }
            
            ?>
        </div>
    </div>
    <div class="row" style="max-width:400px;margin:10px auto;">
        <div class="col-1" style="text-align: center;">
            <i class="fas fa-briefcase"></i>
        </div>
        <div class="col-11">
            <h5>Pengalaman</h5>
            <?php echo $thn;?> Tahun
        </div>
    </div>
    <div class="row" style="max-width:400px;margin:10px auto;">
        <div class="col-1" style="text-align: center;">
            <i class="fas fa-store-alt"></i>
        </div>
        <div class="col-11">
            <h5>Koperasi</h5>
            <?php 
                if($row['kop_stat']){
                    $id_k = $row['id_kop'];
                    $sql = mysqli_query($conn,"SELECT nama_kp FROM koperasi where id_koperasi='$id_k'");
                    $kop = mysqli_fetch_assoc($sql);
                    echo $kop['nama_kp'];
                }else{
                    echo 'Belum Terdaftar';
                }
            ?>
        </div>
    </div>
</div>