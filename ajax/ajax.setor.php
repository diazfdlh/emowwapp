<?php
    require_once('../config.php');
    $nperlist = 5;
?>
<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'setorList'){
        $cp = $_POST['cp'];
        $id = $_SESSION['user']['id_user'];
        $rStart = $nperlist * ($cp - 1);
        $q = $_POST['q'];
        if($q){
            $srch = "AND user.nama LIKE '%".$q."%'";
        }else{
            $srch = '';
        }
        $sql1 = mysqli_query($conn,"SELECT * FROM setor inner join user on id_p=user.id_user where id_k='$id' ".$srch." order by id_s desc LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
        //$id = mysqli_insert_id($sql);
        foreach($row as $r){
            $tgl = date('d-M-Y',strtotime($r['tgl']));
            ?>
            <div id="setor-row-<?php echo $r['id_user'];?>" class="row list m-1" style="border: 1pt solid #dcdcdc;">
                <div class="col-2"><?php echo $tgl?></div>
                <div class="col-1"><?php echo $r['bagian']?></div>
                <div class="col-2"><?php echo $r['nama']?></div>
                <div class="col-1"><?php echo $r['jumlah']?></div>
                <div class="col-2" style="text-align: right;"><?php echo 'Rp '.number_format($r['biaya_susu'],0,"",".")?></div>
                <div class="col-2" style="text-align: right;"><?php echo 'Rp '.number_format($r['total'],0,"",".");?></div>    
                <div class="col-2">
                    <i class="fas fa-pencil-alt" style="cursor: pointer;color:#019961;" onclick="edit(<?php echo $r['id_s'];?>)"><span style="font-family:Arial, Helvetica, sans-serif;color:#019961;font-size:8pt;"> Edit</span></i>
                    <i class="fas fa-trash" style="cursor: pointer;color:#d44950;" onclick="del(<?php echo $r['id_s'];?>)"><span style="font-family:Arial, Helvetica, sans-serif;color:#d44950;font-size:8pt;"> Delete</span></i>
                </div>
            </div>
            <?php
        }
        $n = mysqli_num_rows($sql1);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada data setoran</div>
        <?php 
        }else{
            $sql = mysqli_query($conn,"SELECT * FROM setor inner join user on id_p=user.id_user where id_k='$id' ".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#setor')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
                <?php
            }
            ?>
                </div>
            <?php
        }
        
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'showModAdd'){
        $date = date('Y-m-d',time());
        ?>
            <h3 style="border-bottom:solid 1pt #dcdcdc;padding-bottom:10px">Tambah Setoran</h3>
            <form action="" id="add-form" method="post">
                <div class="row mt-2 mb-2">
                    <div class="col-5">Peternak</div>
                    <div class="col-7">
                        <div class="input-group">
                            <input required disabled type="text" id="nama_p" name="nama_p" class="form-control" placeholder="Pilih Peternak">
                            <input type="text" id="id_p" name="id_p" class="form-control" style="opacity:0;position:absolute;z-index:-1" required>
                            <div class="input-group-append" id="show-pt" onclick="showPt()">
                                <div class="input-group-text" style="background:#fff;cursor:pointer">
                                <i id="chev" class="fas fa-chevron-left"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5"></div>
                    <div class="col-7">
                        <div id="pt-wrap" style="display:none;border: 1pt solid #dcdc;padding:10px">
                            <input id="pt-srch" type="text" class="form-control" placeholder="Cari Peternak" style="font-size: 10pt;">
                            <table width="100%">
                                <thead></thead>
                                <tbody id="pt-tbl">
                                    <?php
                                        $sql = mysqli_query($conn,"SELECT * FROM peternak inner join user on peternak.id_user=user.id_user where id_kop is not null and kop_stat = 1");
                                        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                                        foreach($row as $r){
                                    ?>
                                        <tr style="border-bottom: 1pt solid #dcdc;">
                                            <td><?php echo $r['nama']?></td>
                                            <td><div style="margin:0 auto;" class="btn-chat" onclick="pilih(<?php echo $r['id_user'] ?>,'<?php echo $r['nama']?>')">Pilih</div></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Tanggal Setor</div>
                    <div class="col-7"><input required type="date" name="tgl" class="form-control" value="<?php echo $date?>"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Bagian</div>
                    <div class="col-7">
                        <select required name="bagian" class="form-control">
                            <option value="pagi">Pagi</option>
                            <option value="sore">Sore</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Jumlah Susu</div>
                    <div class="col-7"><input required type="number" step="0.01" name="jum" class="form-control" placeholder="Masukan Jumlah Susu"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Harga per susu</div>
                    <div class="col-7">
                        <div class="input-group">
                            <div class="input-group-append">
                                <div class="input-group-text">Rp</div>
                            </div>
                            <input required type="number" name="nom" class="form-control" placeholder="Masukan Biaya Susu"></div>
                        </div>
                </div>
                <input type="hidden" name="mode" value="initAdd">
                <input type="number" hidden name="n" id="n" value="0">
                <div class="row mt-2 mb-2">
                    <div class="col-5"></div>
                    <div class="col-7">
                        <button type="submit" name="submitAdd" class="btn-act p-2" style="border:none;width:100%;">Setor</button>
                    </div>
                </div>
            </form>
            <script>
                function showPt(){
                    if($('.mod-ternak #pt-wrap').css('display') === 'none'){
                        //console.log('none');
                        $('.mod-ternak i#chev').css('transform','rotate(-90deg)')
                    }else{
                        $('.mod-ternak i#chev').css('transform','rotate(0deg)')
                    }
                    $('.mod-ternak #pt-wrap').toggle();
                    console.log('masuk')
                }
                function pilih(id,nama){
                    $('.mod-ternak #id_p').attr('value',id);
                    $('.mod-ternak #nama_p').attr('value',nama);
                    $('.mod-ternak #pt-wrap').hide();
                    $('.mod-ternak i#chev').css('transform','rotate(0deg)')
                }
            </script>
        <?php
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'showModEdit'){
        $id_s = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * from setor inner join user on user.id_user=setor.id_p where id_s ='$id_s'");
        $row = mysqli_fetch_assoc($sql);
        ?>
            <h3 style="border-bottom:solid 1pt #dcdcdc;padding-bottom:10px">Edit Setoran</h3>
            <form action="" id="edit-form" method="post">
                <div class="row mt-2 mb-2">
                    <div class="col-5">Peternak</div>
                    <div class="col-7">
                        <div class="input-group">
                            <input required disabled type="text" id="nama_p" value="<?php echo $row['nama']?>" name="nama_p" class="form-control" placeholder="Pilih Peternak">
                            <input type="text" id="id_p" name="id_p" value="<?php echo $row['id_p']?>" class="form-control" style="opacity:0;position:absolute;z-index:-1" required>
                            <div class="input-group-append" id="show-pt" onclick="showPt()">
                                <div class="input-group-text" style="background:#fff;cursor:pointer">
                                <i id="chev" class="fas fa-chevron-left"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5"></div>
                    <div class="col-7">
                        <div id="pt-wrap" style="display:none;border: 1pt solid #dcdc;padding:10px">
                            <input id="pt-srch" type="text" class="form-control" placeholder="Cari Peternak" style="font-size: 10pt;">
                            <table width="100%">
                                <thead></thead>
                                <tbody id="pt-tbl">
                                    <?php
                                        $sql = mysqli_query($conn,"SELECT * FROM peternak inner join user on peternak.id_user=user.id_user where id_kop is not null and kop_stat = 1");
                                        $row2 = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                                        foreach($row2 as $r){
                                    ?>
                                        <tr style="border-bottom: 1pt solid #dcdc;">
                                            <td><?php echo $r['nama']?></td>
                                            <td><div style="margin:0 auto;" class="btn-chat" onclick="pilih(<?php echo $r['id_user'] ?>,'<?php echo $r['nama']?>')">Pilih</div></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Tanggal Setor</div>
                    <div class="col-7"><input required type="date" name="tgl" class="form-control" value="<?php echo $row['tgl']?>"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Bagian</div>
                    <div class="col-7">
                        <select required name="bagian" class="form-control">
                            <option value="pagi" <?php if($row['bagian']=='pagi'){echo 'selected';}?>>Pagi</option>
                            <option value="sore" <?php if($row['bagian']=='sore'){echo 'selected';}?>>Sore</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Jumlah Susu</div>
                    <div class="col-7"><input value="<?php echo $row['jumlah'];?>" required type="number" step="0.01" name="jumlah" class="form-control" placeholder="Masukan Jumlah Susu"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Harga per susu</div>
                    <div class="col-7">
                        <div class="input-group">
                            <div class="input-group-append">
                                <div class="input-group-text">Rp</div>
                            </div>
                            <input value="<?php echo $row['biaya_susu'];?>" required type="number" name="harga" class="form-control" placeholder="Masukan Biaya Susu">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="mode" value="initEdit">
                <input type="hidden" name="id" value="<?php echo $id_s;?>">
                <input type="number" hidden name="n" id="n" value="<?php echo $n1;?>">
                <div class="row mt-2 mb-2">
                    <div class="col-5"></div>
                    <div class="col-7">
                        <button type="submit" name="submitEdit" class="btn-act p-2" style="border:none;width:100%;">Simpan Setor</button>
                    </div>
                </div>
            </form>
            
            <script> 
                function showPt(){
                    if($('.mod-ternak #pt-wrap').css('display') === 'none'){
                        //console.log('none');
                        $('.mod-ternak i#chev').css('transform','rotate(-90deg)')
                    }else{
                        $('.mod-ternak i#chev').css('transform','rotate(0deg)')
                    }
                    $('.mod-ternak #pt-wrap').toggle();
                    console.log('masuk')
                }
                function pilih(id,nama){
                    $('.mod-ternak #id_p').attr('value',id);
                    $('.mod-ternak #nama_p').attr('value',nama);
                    $('.mod-ternak #pt-wrap').hide();
                    $('.mod-ternak i#chev').css('transform','rotate(0deg)')
                }
            </script>
        <?php
    }

?>
<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'initAdd'){
        $id = $_SESSION['user']['id_user'];
        $id_p = $_POST['id_p'];
        $tgl = $_POST['tgl'];
        $bagian = $_POST['bagian'];
        $jumlah = $_POST['jum'];
        $harga = $_POST['nom'];
        $total = $jumlah*$harga;
        //echo $id_p.' '.$tgl.' '.$bagian.' '.$jumlah.' '.$harga.' '.$total;
        $sql = mysqli_query($conn,"INSERT INTO setor (id_p,id_k,bagian,jumlah,biaya_susu,tgl,total) VALUES('$id_p','$id','$bagian','$jumlah','$harga','$tgl','$total')");
        echo '<div style="background:#077703;color:#fff" class="p-2">Berhasil Tambah Setor</div>';
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'initEdit'){
        $id = $_SESSION['user']['id_user'];
        $id_s = $_POST['id'];
        $id_p = $_POST['id_p'];
        $tgl = $_POST['tgl'];
        $bagian = $_POST['bagian'];
        $jumlah = $_POST['jumlah'];
        $harga = $_POST['harga'];
        $total = $jumlah*$harga;
        //echo $id_p.' '.$tgl.' '.$bagian.' '.$jumlah.' '.$harga.' '.$total;
        $sql = mysqli_query($conn,"UPDATE setor set id_p='$id_p',id_k='$id',bagian='$bagian',jumlah='$jumlah',biaya_susu='$harga',tgl='$tgl',total='$total' where id_s='$id_s'");
        echo '<div style="background:#077703;color:#fff" class="p-2">Berhasil Tambah Setor</div>';
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'initDel'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"DELETE FROM setor where id_s='$id'");
    }
?>



