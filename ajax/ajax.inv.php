<?php
    require_once('../config.php');
    if(isset($_POST['mode']) && $_POST['mode'] == 'inv'){
        $thn = $_POST['thn'];
        $bln = $_POST['bln'];
        $weeks = $_POST['weeks'];
        if($weeks == '1'){
            $w = '(14 >= day(tgl) >= 1)';
            $m = 0;
        }else if($weeks =='2'){
            $w = '(day(tgl) >= 15)';
            $m = 1;
        }
        $id_p = $_POST['id_p'];
        $id_k = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"SELECT * from user inner join koperasi on user.id_user=koperasi.id_user where user.id_user='$id_k'");
        $kop = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn,"SELECT * from user inner join peternak on user.id_user=peternak.id_user where user.id_user='$id_p'");
        $pt = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn,"SELECT count(id_s) as n, SUM(jumlah) as jum, biaya_susu FROM `setor` WHERE id_p='$id_p' and id_k='$id_k' and ".$w." and month(tgl) = '$bln' and year(tgl)='$thn' GROUP BY biaya_susu ORDER BY COUNT(id_s)");
        $susu = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        $sql = mysqli_query($conn,"SELECT * FROM `biaya` inner join biaya_ext on biaya.id_b=biaya_ext.id_b where id_p='$id_p' and id_k='$id_k' and tahun='$thn' and bulan='$bln' and mingguke='$m' order by jenis");
        $biaya = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        if(mysqli_num_rows($sql)){
    ?>
    <div class="inv">
        <div class="inv-bord mb-3"></div>
        <div class="row">
            <div class="col-6 logo">
                <img src="<?php echo BASE_URL?>ass/img/main/logo.png" style="width:130px;" alt="">
            </div>
            <div class="col-6 kop">
                <div style="text-transform: uppercase;"><?php echo $kop['nama_kp'];?></div>
                <div><?php echo $kop['alamat'];?></div>
                <div><?php echo $kop['email'];?></div>
            </div>
        </div>
        <div class="row">
            <div class="garis mt-3 mb-3"></div>
        </div>
        <div class="row">
            <div class="col-5 pet">
                <div style="text-transform: uppercase;"><?php echo $pt['nama'];?></div>
                <div><?php echo $pt['email'];?></div>
            </div>
            <div class="col-2"></div>
            <div class="col-5 info">
                <div style="font-weight:700">INVOICE</div>
                <b>DATE</b>
                <div><?php echo date('M',strtotime('01-'.$bln.'-2020')).' '.$thn?></div>
            </div>
        </div>
        <div class="row">
            <div class="garis mt-3 mb-3"></div>
        </div>
        <div class="row">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Uraian</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Kredit</th>
                        <th scope="col">Debit</th>
                        <th scope="col">Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $n = 0;
                    $total = 0;
                    foreach($susu as $s){
                        $n +=1;
                        $total += $s['jum']*$s['biaya_susu'];
                        ?>
                    <tr>
                        <td scope="row"><?php echo $n?></td>
                        <td>Susu</td>
                        <td><?php echo $s['jum']; ?></td>
                        <td><?php echo 'Rp.'.$s['biaya_susu'];?></td>
                        <td><?php echo 'Rp.'.$s['jum']*$s['biaya_susu'];?></td>
                        <td>-</td>
                        <td><?php echo 'Rp.'.$s['jum']*$s['biaya_susu'];?></td>
                    </tr>
                    <?php }?>
                    <?php 
                    foreach($biaya as $b){
                        $n +=1;
                        if($b['jenis']=='kredit'){
                            $total += $b['nominal'];
                        }else{
                            $total -= $b['nominal'];
                        }
                        ?>
                    <tr>
                        <td scope="row"><?php echo $n?></td>
                        <td><?php echo $b['nama_b']; ?></td>
                        <td>1</td>
                        <td><?php echo 'Rp.'.$b['nominal'];?></td>
                        <td><?php if($b['jenis']=='kredit'){echo 'Rp.'.$b['nominal'];}else{echo '-';}?></td>
                        <td><?php if($b['jenis']=='debit'){echo 'Rp.'.$b['nominal'];}else{echo '-';}?></td>
                        <td><?php if($b['jenis']=='kredit'){echo 'Rp.'.$b['nominal'];}else{echo '(-)Rp.'.$b['nominal'];}?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td scope="row" colspan="6">Total Akhir</td>
                        <td><?php echo 'Rp.'.$total;?></td>
                    </tr>
                    <tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="garis mt-3 mb-3"></div>
        </div>
        <div class="row p-2 pb-3">
            <b class="pr-1">INVOICE</b> dibuat pada <?php echo date('d M Y',time())?>
        </div>
        
    </div>
<?php }else{?>
<h5 style="text-align: center;">Tidak ada Data Invoce yang dapat ditampilkan</h5>
    
<?php }?>
<?php }
if(isset($_POST['mode']) && $_POST['mode'] == 'inv2'){
    $thn = $_POST['thn'];
    $bln = $_POST['bln'];
    $weeks = $_POST['weeks'];
    if($weeks == '1'){
        $w = '(14 >= day(tgl) >= 1)';
        $m = 0;
    }else if($weeks =='2'){
        $w = '(day(tgl) >= 15)';
        $m = 1;
    }
    $id_k = $_POST['id_k'];
    $id_p = $_SESSION['user']['id_user'];
    //echo $id_k.'-'.$id_p.'-'.$thn.'-'.$bln.'-'.$weeks;
    $sql = mysqli_query($conn,"SELECT * from user inner join koperasi on user.id_user=koperasi.id_user where user.id_user='$id_k'");
    $kop = mysqli_fetch_assoc($sql);
    $sql = mysqli_query($conn,"SELECT * from user inner join peternak on user.id_user=peternak.id_user where user.id_user='$id_p'");
    $pt = mysqli_fetch_assoc($sql);
    $sql = mysqli_query($conn,"SELECT count(id_s) as n, SUM(jumlah) as jum, biaya_susu FROM `setor` WHERE id_p='$id_p' and id_k='$id_k' and ".$w." and month(tgl) = '$bln' and year(tgl)='$thn' GROUP BY biaya_susu ORDER BY COUNT(id_s)");
    $susu = mysqli_fetch_all($sql,MYSQLI_ASSOC);
    $sql = mysqli_query($conn,"SELECT * FROM `biaya` inner join biaya_ext on biaya.id_b=biaya_ext.id_b where id_p='$id_p' and id_k='$id_k' and tahun='$thn' and bulan='$bln' and mingguke='$m' order by jenis");
    $biaya = mysqli_fetch_all($sql,MYSQLI_ASSOC);
    if(mysqli_num_rows($sql)){
?>
<div class="inv">
<div class="inv-bord mb-3"></div>
<div class="row">
    <div class="col-6 logo">
        <img src="<?php echo BASE_URL?>ass/img/main/logo.png" style="width:130px;" alt="">
    </div>
    <div class="col-6 kop">
        <div style="text-transform: uppercase;"><?php echo $kop['nama_kp'];?></div>
        <div><?php echo $kop['alamat'];?></div>
        <div><?php echo $kop['email'];?></div>
    </div>
</div>
<div class="row">
    <div class="garis mt-3 mb-3"></div>
</div>
<div class="row">
    <div class="col-5 pet">
        <div style="text-transform: uppercase;"><?php echo $pt['nama'];?></div>
        <div><?php echo $pt['email'];?></div>
    </div>
    <div class="col-2"></div>
    <div class="col-5 info">
        <div style="font-weight:700">INVOICE</div>
        <b>DATE</b>
        <div><?php echo date('M',strtotime('01-'.$bln.'-2020')).' '.$thn?></div>
    </div>
</div>
<div class="row">
    <div class="garis mt-3 mb-3"></div>
</div>
<div class="row">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Uraian</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Harga</th>
                <th scope="col">Kredit</th>
                <th scope="col">Debit</th>
                <th scope="col">Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $n = 0;
            $total = 0;
            foreach($susu as $s){
                $n +=1;
                $total += $s['jum']*$s['biaya_susu'];
                ?>
            <tr>
                <td scope="row"><?php echo $n?></td>
                <td>Susu</td>
                <td><?php echo $s['jum']; ?></td>
                <td><?php echo 'Rp.'.$s['biaya_susu'];?></td>
                <td><?php echo 'Rp.'.$s['jum']*$s['biaya_susu'];?></td>
                <td>-</td>
                <td><?php echo 'Rp.'.$s['jum']*$s['biaya_susu'];?></td>
            </tr>
            <?php }?>
            <?php 
            foreach($biaya as $b){
                $n +=1;
                if($b['jenis']=='kredit'){
                    $total += $b['nominal'];
                }else{
                    $total -= $b['nominal'];
                }
                ?>
            <tr>
                <td scope="row"><?php echo $n?></td>
                <td><?php echo $b['nama_b']; ?></td>
                <td>1</td>
                <td><?php echo 'Rp.'.$b['nominal'];?></td>
                <td><?php if($b['jenis']=='kredit'){echo 'Rp.'.$b['nominal'];}else{echo '-';}?></td>
                <td><?php if($b['jenis']=='debit'){echo 'Rp.'.$b['nominal'];}else{echo '-';}?></td>
                <td><?php if($b['jenis']=='kredit'){echo 'Rp.'.$b['nominal'];}else{echo '(-)Rp.'.$b['nominal'];}?></td>
            </tr>
            <?php }?>
            <tr>
                <td scope="row" colspan="6">Total Akhir</td>
                <td><?php echo 'Rp.'.$total;?></td>
            </tr>
            <tr>
        </tbody>
    </table>
</div>
<div class="row">
    <div class="garis mt-3 mb-3"></div>
</div>
<div class="row p-2 pb-3">
    <b class="pr-1">INVOICE</b> dibuat pada <?php echo date('d M Y',time())?>
</div>

</div>
<?php }else {?>
<h5 style="text-align: center;">Tidak ada Data Invoce yang dapat ditampilkan</h5>

<?php }?>
<?php }?>