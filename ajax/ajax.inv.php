<?php
    require_once('../config.php');
    if(isset($_GET['mode']) && $_GET['mode'] == 'inv'){
        $thn = $_GET['thn'];
        $bln = $_GET['bln'];
        $weeks = $_GET['weeks'];
        $ww = "";
        if($weeks == '1'){
            $w = '(14 >= day(tgl) >= 1)';
            $m = 0;
            $ww = "2 Minggu Pertama";
        }else if($weeks =='2'){
            $w = '(day(tgl) >= 15)';
            $m = 1;
            $ww = "2 Minggu Kedua";
        }
        $id_p = $_GET['id_p'];
        $id_k = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"SELECT * from user inner join koperasi on user.id_user=koperasi.id_user where user.id_user='$id_k'");
        $kop = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn,"SELECT * from user inner join peternak on user.id_user=peternak.id_user where user.id_user='$id_p'");
        $pt = mysqli_fetch_assoc($sql);
        $sql1 = mysqli_query($conn,"SELECT count(id_s) as n, SUM(jumlah) as jum, biaya_susu FROM `setor` WHERE id_p='$id_p' and id_k='$id_k' and ".$w." and month(tgl) = '$bln' and year(tgl)='$thn' GROUP BY biaya_susu ORDER BY COUNT(id_s)");
        $susu = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
        $sql2 = mysqli_query($conn,"SELECT * FROM `biaya` inner join biaya_ext on biaya.id_b=biaya_ext.id_b where id_p='$id_p' and id_k='$id_k' and tahun='$thn' and bulan='$bln' and mingguke='$m' 
        order by CASE
            WHEN nama_b='Fat' THEN 1
            WHEN nama_b='SNF' THEN 2
            WHEN nama_b='Density' THEN 3
            WHEN nama_b='Protein' THEN 4
            WHEN nama_b='Lactose' THEN 5
            WHEN nama_b='Salts' THEN 6
            WHEN nama_b='Added Water' THEN 7
            WHEN nama_b='Freezing Point' THEN 8
            WHEN nama_b='TPC' THEN 9
            ELSE 10
        END");
        $biaya = mysqli_fetch_all($sql2,MYSQLI_ASSOC);
        if(mysqli_num_rows($sql1)  or mysqli_num_rows($sql2)){
        ?>
        <a target="_blank" href="<?php echo BASE_URL."ajax/ajax.inv.php?mode=pdf&thn=".$thn."&bln=".$bln."&weeks=".$weeks."&id_p=".$id_p."&id_k=".$id_k;?>"><div class="btn my-3 btn-chat py-2 px-3" style="font-size:12pt;margin:0 auto;display:block;width:150px;border:1pt solid #dcdcdc;box-shadow: 0 3px 6px 0 rgba(0,0,0,.11);"><i class="fas fa-print"></i> Download</div></a>
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
                    <div><?php echo $ww;?></div>
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
                            <th scope="col" style="text-align: right;">Harga</th>
                            <th scope="col" style="text-align: right;">Kredit</th>
                            <th scope="col" style="text-align: right;">Debit</th>
                            <th scope="col" style="text-align: right;">Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $n = 0;
                        $total = 0;
                        $nsusu = 0;
                        foreach($susu as $s){
                            $n +=1;
                            $total += $s['jum']*$s['biaya_susu'];
                            $nsusu += $s['jum'];
                            
                            ?>
                        <tr>
                            <td scope="row"><?php echo $n?></td>
                            <td>Susu</td>
                            <td><?php echo $s['jum'];?>x</td>
                            <td style="text-align: right;"><?php echo 'Rp '.$s['biaya_susu'];?></td>
                            <td style="text-align: right;"><?php echo 'Rp '.$s['jum']*$s['biaya_susu'];?></td>
                            <td>-</td>
                            <td style="text-align: right;"><?php echo 'Rp '.$s['jum']*$s['biaya_susu'];?></td>
                        </tr>
                        <?php }?>
                        <?php 
                    if(mysqli_num_rows($sql2)){
                        ?>
                        <tr style="background-color: #dcdcdc;">
                            <td colspan="7" style="text-align: center;">-Catatan Tambahan-</td>
                        </tr>
                        <?php
                    }
                        foreach($biaya as $b){
                            $n +=1;
                            if($b['jenis']=='kredit'){
                                $total += $b['nominal']*$nsusu;
                            }else{
                                $total -= $b['nominal']*$nsusu;
                            }
                            ?>
                        <tr>
                            <td scope="row"><?php echo $n?></td>
                            <td><?php echo $b['nama_b']; ?></td>
                            <td><?php
                            $arr = array("Fat","SNF","Density","Protein","Lactose","Salts","Added Water","Freezing Point","TPC");
                            if(in_array($b['nama_b'],$arr) && $b['nama_b']!="Freezing Point" && $b['nama_b'] != "TPC"){ $qty = '%';}
                            else if($b['nama_b'] == "Freezing Point"){$qty = "°C";}
                            else if($b['nama_b'] == "TPC"){$qty = "CFU/ml";}
                            else{ $qty = "x";}
                            echo $b['qty'].' '.$qty;
                            ?></td>
                            <td style="text-align: right;"><?php echo 'Rp '.number_format($b['nominal'],0,"",".");?></td>
                            <td style="text-align: right;"><?php if($b['jenis']=='kredit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '-';}?></td>
                            <td style="text-align: right;"><?php if($b['jenis']=='debit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '-';}?></td>
                            <td style="text-align: right;"><?php if($b['jenis']=='kredit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '(-)Rp '.number_format($b['nominal']*$nsusu,0,"",".");}?></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td scope="row" colspan="6">Total Akhir</td>
                            <td style="text-align: right;"><b style="font-size: 10pt;"><?php echo 'Rp '.number_format($total,0,"",".");?></b></td>
                        </tr>
                        <tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="garis mt-3 mb-3"></div>
            </div>
            <div class="row" style="padding-bottom:50px !important;padding-top:100px !important;display:block !important">
                <div style="float: left;"><b class="pr-1">INVOICE</b> dibuat pada <?php echo date('d M Y',time())?></div>
                <div style="float: right;margin-right:20px">................................................</div>
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
    $ww = "";
    if($weeks == '1'){
        $w = '(14 >= day(tgl) >= 1)';
        $m = 0;
        $ww = "2 Minggu Pertama";
    }else if($weeks =='2'){
        $w = '(day(tgl) >= 15)';
        $m = 1;
        $ww = "2 Minggu Kedua";
    }
    $id_k = $_POST['id_k'];
    $id_p = $_SESSION['user']['id_user'];
    //echo $id_k.'-'.$id_p.'-'.$thn.'-'.$bln.'-'.$weeks;
    $sql = mysqli_query($conn,"SELECT * from user inner join koperasi on user.id_user=koperasi.id_user where user.id_user='$id_k'");
    $kop = mysqli_fetch_assoc($sql);
    $sql = mysqli_query($conn,"SELECT * from user inner join peternak on user.id_user=peternak.id_user where user.id_user='$id_p'");
    $pt = mysqli_fetch_assoc($sql);
    $sql1 = mysqli_query($conn,"SELECT count(id_s) as n, SUM(jumlah) as jum, biaya_susu FROM `setor` WHERE id_p='$id_p' and id_k='$id_k' and ".$w." and month(tgl) = '$bln' and year(tgl)='$thn' GROUP BY biaya_susu ORDER BY COUNT(id_s)");
    $susu = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
    $sql2 = mysqli_query($conn,"SELECT * FROM `biaya` inner join biaya_ext on biaya.id_b=biaya_ext.id_b where id_p='$id_p' and id_k='$id_k' and tahun='$thn' and bulan='$bln' and mingguke='$m' 
    order by CASE
        WHEN nama_b='Fat' THEN 1
        WHEN nama_b='SNF' THEN 2
        WHEN nama_b='Density' THEN 3
        WHEN nama_b='Protein' THEN 4
        WHEN nama_b='Lactose' THEN 5
        WHEN nama_b='Salts' THEN 6
        WHEN nama_b='Added Water' THEN 7
        WHEN nama_b='Freezing Point' THEN 8
        WHEN nama_b='TPC' THEN 9
        ELSE 10
    END");
    $biaya = mysqli_fetch_all($sql2,MYSQLI_ASSOC);
    if(mysqli_num_rows($sql1)  or mysqli_num_rows($sql2)){
    ?>
    <a target="_blank" href="<?php echo BASE_URL."ajax/ajax.inv.php?mode=pdf&thn=".$thn."&bln=".$bln."&weeks=".$weeks."&id_p=".$id_p."&id_k=".$id_k;?>"><div class="btn my-3 btn-chat py-2 px-3" style="font-size:12pt;margin:0 auto;display:block;width:150px;border:1pt solid #dcdcdc;box-shadow: 0 3px 6px 0 rgba(0,0,0,.11);"><i class="fas fa-print"></i> Download</div></a>
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
            <div><?php echo $ww;?></div>
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
                    <th scope="col" style="text-align: right;">Harga</th>
                    <th scope="col" style="text-align: right;">Kredit</th>
                    <th scope="col" style="text-align: right;">Debit</th>
                    <th scope="col" style="text-align: right;">Akhir</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $n = 0;
                $total = 0;
                $nsusu = 0;
                foreach($susu as $s){
                    $n +=1;
                    $total += $s['jum']*$s['biaya_susu'];
                    $nsusu += $s['jum'];
                    ?>
                <tr>
                    <td scope="row"><?php echo $n?></td>
                    <td>Susu</td>
                    <td><?php echo $s['jum']; ?>x</td>
                    <td style="text-align: right;"><?php echo 'Rp '.$s['biaya_susu'];?></td>
                    <td style="text-align: right;"><?php echo 'Rp '.$s['jum']*$s['biaya_susu'];?></td>
                    <td>-</td>
                    <td style="text-align: right;"><?php echo 'Rp '.$s['jum']*$s['biaya_susu'];?></td>
                </tr>
                <?php }?>
                <?php 
                    if(mysqli_num_rows($sql2)){
                        ?>
                        <tr style="background-color: #dcdcdc;">
                            <td colspan="7" style="text-align: center;">-Catatan Tambahan-</td>
                        </tr>
                        <?php
                    }
                foreach($biaya as $b){
                    $n +=1;
                    if($b['jenis']=='kredit'){
                        $total += $b['nominal']*$nsusu;
                    }else{
                        $total -= $b['nominal']*$nsusu;
                    }
                    ?>
                <tr>
                    <td scope="row"><?php echo $n?></td>
                    <td><?php echo $b['nama_b']; ?></td>
                    <td><?php
                    $arr = array("Fat","SNF","Density","Protein","Lactose","Salts","Added Water","Freezing Point","TPC");
                    if(in_array($b['nama_b'],$arr) && $b['nama_b']!="Freezing Point" && $b['nama_b'] != "TPC"){ $qty = '%';}
                    else if($b['nama_b'] == "Freezing Point"){$qty = "°C";}
                    else if($b['nama_b'] == "TPC"){$qty = "CFU/ml";}
                    else{ $qty = "x";}
                    echo $b['qty'].' '.$qty;
                    ?></td>
                    <td style="text-align: right;"><?php echo 'Rp '.number_format($b['nominal'],0,"",".");?></td>
                    <td style="text-align: right;"><?php if($b['jenis']=='kredit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '-';}?></td>
                    <td style="text-align: right;"><?php if($b['jenis']=='debit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '-';}?></td>
                    <td style="text-align: right;"><?php if($b['jenis']=='kredit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '(-)Rp '.number_format($b['nominal']*$nsusu,0,"",".");}?></td>
                </tr>
                <?php }?>
                <tr>
                    <td scope="row" colspan="6">Total Akhir</td>
                    <td style="text-align: right;"><b style="font-size: 10pt;"><?php echo 'Rp '.number_format($total,0,"",".");?></b></td>
                </tr>
                <tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="garis mt-3 mb-3"></div>
    </div>
    <div class="row" style="padding-bottom:50px !important;padding-top:100px !important;display:block !important">
        <div style="float: left;"><b class="pr-1">INVOICE</b> dibuat pada <?php echo date('d M Y',time())?></div>
        <div style="float: right;margin-right:20px">................................................</div>
    </div>

    </div>
<?php }else {?>
<h5 style="text-align: center;">Tidak ada Data Invoce yang dapat ditampilkan</h5>

<?php }?>
<?php }?>
<?php
    if(isset($_GET['mode']) && $_GET['mode'] == 'pdfsource'){
        include(ROOT_PATH.'inc/header.php');
        $thn = $_GET['thn'];
        $bln = $_GET['bln'];
        $weeks = $_GET['weeks'];
        $ww = '';
        if($weeks == '1'){
            $w = '(14 >= day(tgl) >= 1)';
            $m = 0;
            $ww = "2 Minggu Pertama";
        }else if($weeks =='2'){
            $w = '(day(tgl) >= 15)';
            $m = 1;
            $ww = "2 Minggu Kedua";
        }
        $id_p = $_GET['id_p'];
        $id_k = $_GET['id_k'];
        $sql = mysqli_query($conn,"SELECT * from user inner join koperasi on user.id_user=koperasi.id_user where user.id_user='$id_k'");
        $kop = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn,"SELECT * from user inner join peternak on user.id_user=peternak.id_user where user.id_user='$id_p'");
        $pt = mysqli_fetch_assoc($sql);
        $sql1 = mysqli_query($conn,"SELECT count(id_s) as n, SUM(jumlah) as jum, biaya_susu FROM `setor` WHERE id_p='$id_p' and id_k='$id_k' and ".$w." and month(tgl) = '$bln' and year(tgl)='$thn' GROUP BY biaya_susu ORDER BY COUNT(id_s)");
        $susu = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
        $sql2 = mysqli_query($conn,"SELECT * FROM `biaya` inner join biaya_ext on biaya.id_b=biaya_ext.id_b where id_p='$id_p' and id_k='$id_k' and tahun='$thn' and bulan='$bln' and mingguke='$m' 
        order by CASE
            WHEN nama_b='Fat' THEN 1
            WHEN nama_b='SNF' THEN 2
            WHEN nama_b='Density' THEN 3
            WHEN nama_b='Protein' THEN 4
            WHEN nama_b='Lactose' THEN 5
            WHEN nama_b='Salts' THEN 6
            WHEN nama_b='Added Water' THEN 7
            WHEN nama_b='Freezing Point' THEN 8
            WHEN nama_b='TPC' THEN 9
            ELSE 10
        END");
        $biaya = mysqli_fetch_all($sql2,MYSQLI_ASSOC);
        if(mysqli_num_rows($sql1)  or mysqli_num_rows($sql2)){
    ?>
    <style>
        .inv{
            overflow: hidden;
            margin: 0 auto;
            width: 100%;
            background: #fff;
            border-radius: .25rem;
            box-shadow: 0 3px 6px 0 rgba(0,0,0,.11);
        }
        .inv > .row{
            margin: 0 10px;
        }
        .inv-bord{
            width: 100%;
            height: 40px;
            background: #b5d653;
        }

        .head-inv{
            padding: 20px;
            text-align: center;
        }
        .garis{
            border-bottom: 1pt solid #dcdcdc;
            width: 100%;
        }
        .body-inv{
            padding: 20px;
        }

        .inv{
            font-size: 12pt;
        }
        .inv .kop, .inv .info{
            text-align: right;
        }
        .inv table, .inv table td{
            font-size: 10pt;
        }
        .thead-dark th{
            background-color: #252525 !important;
            border-color: #252525 !important;
            padding: 10px !important;
        }
        .garis{
            margin: 1rem 0 !important;
        }
        .row{
            width: 100%;
            display: block;
        }

    </style>
    <div class="inv">
        <div class="inv-bord mb-3"></div>
        <table class="table">
            <tr>
                <td style="width: 50%;">
                    <img src="<?php echo BASE_URL?>ass/img/main/logo.png" style="width:400px;" alt="">
                </td>
                <td class="kop">
                    <div style="text-transform: uppercase;"><?php echo $kop['nama_kp'];?></div>
                    <div><?php echo $kop['alamat'];?></div>
                    <div><?php echo $kop['email'];?></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="text-transform: uppercase;"><?php echo $pt['nama'];?></div>
                    <div><?php echo $pt['email'];?></div>
                </td>
                <td class="info">
                    <div style="font-weight:700">INVOICE</div>
                    <b>DATE</b>
                    <div><?php echo date('M',strtotime('01-'.$bln.'-2020')).' '.$thn?></div>
                    <div><?php echo $ww;?></div>
                </td>
            </tr>
        </table>
        <div class="row">
            <table class="table" style="border-bottom: 2pt solid #dcdcdc;">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Uraian</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col" style="text-align:right;">Harga</th>
                        <th scope="col" style="text-align:right;">Kredit</th>
                        <th scope="col" style="text-align:right;">Debit</th>
                        <th scope="col" style="text-align:right;">Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $n = 0;
                    $total = 0;
                    $nsusu = 0;
                    foreach($susu as $s){
                        $n +=1;
                        $total += $s['jum']*$s['biaya_susu'];
                        $nsusu += $s['jum'];
                        
                        ?>
                        <tr>
                            <td scope="row"><?php echo $n?></td>
                            <td>Susu</td>
                            <td><?php echo $s['jum']; ?>x</td>
                            <td style="text-align: right;"><?php echo 'Rp '.$s['biaya_susu'];?></td>
                            <td style="text-align: right;"><?php echo 'Rp '.$s['jum']*$s['biaya_susu'];?></td>
                            <td>-</td>
                            <td style="text-align: right;"><?php echo 'Rp '.$s['jum']*$s['biaya_susu'];?></td>
                        </tr>
                    <?php }?>
                    <?php 
                    if(mysqli_num_rows($sql2)){
                        ?>
                        <tr style="background-color: #dcdcdc;">
                            <td colspan="7" style="text-align: center;">-Catatan Tambahan-</td>
                        </tr>
                        <?php
                    }
                    foreach($biaya as $b){
                        $n +=1;
                        if($b['jenis']=='kredit'){
                            $total += $b['nominal']*$nsusu;
                        }else{
                            $total -= $b['nominal']*$nsusu;
                        }
                        ?>
                    <tr>
                        <td scope="row"><?php echo $n?></td>
                        <td><?php echo $b['nama_b']; ?></td>
                        <td>
                        <?php
                            $arr = array("Fat","SNF","Density","Protein","Lactose","Salts","Added Water","Freezing Point","TPC");
                            if(in_array($b['nama_b'],$arr) && $b['nama_b']!="Freezing Point" && $b['nama_b'] != "TPC"){ $qty = '%';}
                            else if($b['nama_b'] == "Freezing Point"){$qty = "°C";}
                            else if($b['nama_b'] == "TPC"){$qty = "CFU/ml";}
                            else{ $qty = "x";}
                            echo $b['qty'].' '.$qty;
                        ?></td>
                        <td style="text-align: right;"><?php echo 'Rp '.number_format($b['nominal'],0,"",".");?></td>
                        <td style="text-align: right;"><?php if($b['jenis']=='kredit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '-';}?></td>
                        <td style="text-align: right;"><?php if($b['jenis']=='debit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '-';}?></td>
                        <td style="text-align: right;"><?php if($b['jenis']=='kredit'){echo 'Rp '.number_format($b['nominal']*$nsusu,0,"",".");}else{echo '(-)Rp '.number_format($b['nominal']*$nsusu,0,"",".");}?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td scope="row" colspan="6">Total Akhir</td>
                        <td style="text-align: right;"><b style="font-size: 10pt;"><?php echo 'Rp '.number_format($total,0,"",".");?></b></td>
                    </tr>
                    <tr>
                </tbody>
            </table>
            <table style="width: 100%;margin-top:200px">
                <tr>
                    <td style="width:50%;"><b style="margin-right: 20px;">INVOICE</b> dibuat pada <?php echo date('d M Y',time())?></td>
                    <td style="text-align: right;">................................................</td>
                </tr>
            </table>
        </div>
            
        
    </div>
<?php }else{?>
<h5 style="text-align: center;">Tidak ada Data Invoce yang dapat ditampilkan</h5>
    
<?php }?>
        <?php
    }
?>
<?php
    include(ROOT_PATH."vendor/autoload.php");

    use Dompdf\Dompdf;
    use Dompdf\Options;
    $options = new Options();
    $options->setIsRemoteEnabled(true);
    $options->setDpi(150);
    $dompdf = new Dompdf($options);

    if(isset($_GET['mode']) && $_GET['mode'] == 'pdf'){
        //include(ROOT_PATH.'inc/header.php');
        $thn = $_GET['thn'];
        $bln = $_GET['bln'];
        $weeks = $_GET['weeks'];
        $ww = '';
        if($weeks == '1'){
            $w = '(14 >= day(tgl) >= 1)';
            $m = 0;
            $ww = "2 Minggu Pertama";
        }else if($weeks =='2'){
            $w = '(day(tgl) >= 15)';
            $m = 1;
            $ww = "2 Minggu Kedua";
        }
        $id_p = $_GET['id_p'];
        $id_k = $_GET['id_k'];
        $sql = mysqli_query($conn,"SELECT * from user inner join koperasi on user.id_user=koperasi.id_user where user.id_user='$id_k'");
        $kop = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn,"SELECT * from user inner join peternak on user.id_user=peternak.id_user where user.id_user='$id_p'");
        $pt = mysqli_fetch_assoc($sql);
        $sql1 = mysqli_query($conn,"SELECT count(id_s) as n, SUM(jumlah) as jum, biaya_susu FROM `setor` WHERE id_p='$id_p' and id_k='$id_k' and ".$w." and month(tgl) = '$bln' and year(tgl)='$thn' GROUP BY biaya_susu ORDER BY COUNT(id_s)");
        $susu = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
        $sql2 = mysqli_query($conn,"SELECT * FROM `biaya` inner join biaya_ext on biaya.id_b=biaya_ext.id_b where id_p='$id_p' and id_k='$id_k' and tahun='$thn' and bulan='$bln' and mingguke='$m' 
        order by CASE
            WHEN nama_b='Fat' THEN 1
            WHEN nama_b='SNF' THEN 2
            WHEN nama_b='Density' THEN 3
            WHEN nama_b='Protein' THEN 4
            WHEN nama_b='Lactose' THEN 5
            WHEN nama_b='Salts' THEN 6
            WHEN nama_b='Added Water' THEN 7
            WHEN nama_b='Freezing Point' THEN 8
            WHEN nama_b='TPC' THEN 9
            ELSE 10
        END");
        $biaya = mysqli_fetch_all($sql2,MYSQLI_ASSOC);
        if(mysqli_num_rows($sql1)  or mysqli_num_rows($sql2)){
            $html = '
            <style>
                *{
                    font-family: montserrat;
                }
                .table {
                    width: 100%;
                    margin-bottom: 1rem;
                    color: #212529;
                }
                .table td, .table th {
                    padding: .75rem;
                    vertical-align: top;
                    border-top: 1px solid #dee2e6;
                }
                .inv{
                    overflow: hidden;
                    margin: 0 auto;
                    width: 100%;
                    background: #fff;
                    border-radius: .25rem;
                    box-shadow: 0 3px 6px 0 rgba(0,0,0,.11);
                }
                .inv > .row{
                    margin: 0 10px;
                }
                .inv-bord{
                    width: 100%;
                    height: 40px;
                    background: #b5d653;
                }

                .head-inv{
                    padding: 20px;
                    text-align: center;
                }
                .garis{
                    border-bottom: 1pt solid #dcdcdc;
                    width: 100%;
                }
                .body-inv{
                    padding: 20px;
                }

                .inv{
                    font-size: 12pt;
                }
                .inv .kop, .inv .info{
                    text-align: right;
                }
                .inv table, .inv table td{
                    font-size: 10pt;
                }
                .thead-dark th{
                    background-color: #252525 !important;
                    border-color: #252525 !important;
                    padding: 10px !important;
                }
                thead {
                    background: #252525;
                    color : #fff;
                }
                .garis{
                    margin: 1rem 0 !important;
                }
                .row{
                    width: 100%;
                    display: block;
                }

            </style>
            <div class="inv">
                <div class="inv-bord mb-3"></div>
                <table class="table">
                    <tr>
                        <td style="width: 50%;">
                            <h1 style="font-size:40pt">EMOWW</h1>
                        </td>
                        <td class="kop">
                            <div style="text-transform: uppercase;">'. $kop['nama_kp'].'</div>
                            <div>'. $kop['alamat'].'</div>
                            <div>'. $kop['email'].'</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div style="text-transform: uppercase;">'. $pt['nama'].'</div>
                            <div>'. $pt['email'].'</div>
                        </td>
                        <td class="info">
                            <div style="font-weight:700">INVOICE</div>
                            <b>DATE</b>
                            <div>'. date('M',strtotime('01-'.$bln.'-2020')).' '.$thn.'</div>
                            <div>'. $ww.'</div>
                        </td>
                    </tr>
                </table>
                <div class="row">
                    <table class="table" style="border-bottom: 2pt solid #dcdcdc;">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Uraian</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col" style="text-align:right;">Harga</th>
                                <th scope="col" style="text-align:right;">Kredit</th>
                                <th scope="col" style="text-align:right;">Debit</th>
                                <th scope="col" style="text-align:right;">Akhir</th>
                            </tr>
                        </thead>
                        <tbody>';
                    
                            $n = 0;
                            $total = 0;
                            $nsusu = 0;
                            foreach($susu as $s){
                                $n +=1;
                                $total += $s['jum']*$s['biaya_susu'];
                                $nsusu += $s['jum'];
                                $html .= ' 
                                <tr>
                                    <td scope="row">'. $n.'</td>
                                    <td>Susu</td>
                                    <td>'. $s['jum'].'x</td>
                                    <td style="text-align: right;">Rp '.$s['biaya_susu'].'</td>
                                    <td style="text-align: right;">Rp '.$s['jum']*$s['biaya_susu'].'</td>
                                    <td>-</td>
                                    <td style="text-align: right;">Rp '.$s['jum']*$s['biaya_susu'].'</td>
                                </tr>';
                            }
                            if(mysqli_num_rows($sql2)){
                                
                                $html.='
                                <tr style="background-color: #dcdcdc;">
                                    <td colspan="7" style="text-align: center;">-Catatan Tambahan-</td>
                                </tr>';
                            }
                            foreach($biaya as $b){
                                $n +=1;
                                if($b['jenis']=='kredit'){
                                    $total += $b['nominal']*$nsusu;
                                }else{
                                    $total -= $b['nominal']*$nsusu;
                                }
                                $html .= '
                                <tr>
                                    <td scope="row">'. $n .'</td>
                                    <td>'. $b['nama_b'].'</td>
                                    <td>';
                                        $arr = array("Fat","SNF","Density","Protein","Lactose","Salts","Added Water","Freezing Point","TPC");
                                        if(in_array($b['nama_b'],$arr) && $b['nama_b']!="Freezing Point" && $b['nama_b'] != "TPC"){ 
                                            $qty = '%';
                                        }
                                        else if($b['nama_b'] == "Freezing Point"){
                                            $qty = "°C";
                                        }
                                        else if($b['nama_b'] == "TPC"){
                                            $qty = "CFU/ml";
                                        }
                                        else{
                                             $qty = "x";
                                        }
                                        $html .= $b['qty'].' '.$qty.'</td>
                                    <td style="text-align: right;">Rp '.number_format($b['nominal'],0,"",".").'</td>
                                    <td style="text-align: right;">';
                                    if($b['jenis']=='kredit'){
                                        $html.='Rp '.number_format($b['nominal']*$nsusu,0,"",".");
                                    }else{
                                        $html.= '-';
                                    }
                                    $html .='
                                    </td>
                                    <td style="text-align: right;">';
                                    if($b['jenis']=='debit'){
                                        $html.='Rp '.number_format($b['nominal']*$nsusu,0,"",".");
                                    }else{
                                        $html.='-';
                                    }
                                    $html .='
                                    </td>
                                    <td style="text-align: right;">';
                                    if($b['jenis']=='kredit'){
                                        $html.='Rp '.number_format($b['nominal']*$nsusu,0,"",".");
                                    }else{
                                        $html.='(-)Rp '.number_format($b['nominal']*$nsusu,0,"",".");
                                    }
                                    $html .= '
                                    </td>
                                </tr>';
                            }
                            $html .= '
                                <tr>
                                    <td scope="row" colspan="6">Total Akhir</td>
                                    <td style="text-align: right;"><b style="font-size: 10pt;">'. 'Rp '.number_format($total,0,"",".").'</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%;margin-top:200px">
                            <tr>
                                <td style="width:50%;"><b style="margin-right: 20px;">INVOICE</b> dibuat pada '. date('d M Y',time()).'</td>
                                <td style="text-align: right;">................................................</td>
                            </tr>
                        </table>
                    </div> 
            </div>';
        }
        else{
            $html = '<h5 style="text-align: center;">Tidak ada Data Invoce yang dapat ditampilkan</h5>';
        }
        //$html = file_get_contents(BASE_URL."ajax/ajax.inv.php?mode=pdfsource&thn=".$thn."&bln=".$bln."&weeks=".$weeks."&id_p=".$id_p."&id_k=".$id_k);
        //echo $html;
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $judul = "Invoice_".date("d_m_Y_h_i_s",time());
        $dompdf->stream($judul,array("Attachment"=>1));

    }
?>