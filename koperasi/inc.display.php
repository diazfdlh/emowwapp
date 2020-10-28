<?php
$un = $_GET['un'];
$sql = mysqli_query($conn,"SELECT * FROM user inner join koperasi on user.id_user=koperasi.id_user WHERE uname = '$un'");
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
    <h2 style="text-align: center;"><?php echo $row['nama_kp'];?></h2>
    <div class="row" style="max-width:400px;margin:10px auto;">
        <div class="col-1" style="text-align: center;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="col-11">
            <h5>Sejak</h5>
            <?php echo date('d M Y',strtotime($row['tgl']));?>
        </div>
    </div>
    <div class="row" style="max-width:400px;margin:10px auto;">
        <div class="col-1" style="text-align: center;">
            <i class="fas fa-map-marked-alt"></i>
        </div>
        <div class="col-11">
            <h5>Alamat</h5>
            <?php echo $row['alamat'];?> Tahun
        </div>
    </div>
    <div class="row" style="max-width:400px;margin:10px auto;">
        <div class="col-1" style="text-align: center;">
            <i class="fas fa-landmark"></i>
        </div>
        <div class="col-11">
            <h5>Sejarah</h5>
            <?php 
                echo $row['sejarah'];
            ?>
        </div>
    </div>
</div>