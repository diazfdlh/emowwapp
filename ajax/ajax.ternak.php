<?php
    require_once('../config.php');
    $nperlist = 5;
?>

<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'ternakList'){
        $cp = $_POST['cp'];
        $id=$_SESSION['user']['id_user'];
        $rStart = $nperlist * ($cp - 1);
        $q = $_POST['q'];
        if($q){
            $srch = "AND no_ternak LIKE '%".$q."%'";
        }else{
            $srch = '';
        }
        $sql = mysqli_query($conn,"SELECT * FROM ternak where id_user='$id' ".$srch." order by id_ternak desc LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        foreach($row as $r){
            ?>
            <div id="ternak-row-<?php echo $r['id_user'];?>" class="row list m-1" style="border: 1pt solid #dcdcdc;">
                <div class="col-2"><?php echo $r['no_ternak']?></div>
                <div class="col-2"><?php echo $r['bulan']?></div>
                <div class="col-3"><?php echo $r['tahun']?></div>
                <div class="col-2"><?php echo $r['dara']?></div>
                <div class="col-2"><?php echo $r['pedet']?></div>
                <div class="col-1">
                    <i class="fas fa-pencil-alt" style="cursor: pointer;color:#019961;" onclick="edit(<?php echo $r['id_ternak'];?>)"></i>
                    <i class="fas fa-trash" style="cursor: pointer;color:#d44950;" onclick="del(<?php echo $r['id_ternak'];?>)"></i>
                </div>
            </div>
            <?php
        }
        $n = mysqli_num_rows($sql);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada ternak</div>
        <?php 
        }else{
            $sql = mysqli_query($conn,"SELECT * FROM ternak ".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#ternak')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
                <?php
            }
            ?>
                </div>
            <?php
        }
        
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'setorList'){
        $cp = $_POST['cp'];
        $id = $_SESSION['user']['id_user'];
        $rStart = $nperlist * ($cp - 1);
        
        $sql1 = mysqli_query($conn,"SELECT * FROM setor where id_p='$id' order by id_s desc LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
        //$id = mysqli_insert_id($sql);
        foreach($row as $r){
            $tgl = date('d-M-Y',strtotime($r['tgl']));
            ?>
            <div id="setor-row-<?php echo $r['id_user'];?>" class="row list m-1" style="border: 1pt solid #dcdcdc;">
                <div class="col-3"><?php echo $tgl?></div>
                <div class="col-2"><?php echo $r['bagian']?></div>
                <div class="col-2"><?php echo $r['jumlah']?></div>
                <div class="col-2"><?php echo 'Rp.'.$r['biaya_susu']?></div>
                <div class="col-3"><?php echo 'Rp.'.$r['total'];?></div>    
            </div>
            <?php
        }
        $n = mysqli_num_rows($sql1);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada data setoran</div>
        <?php 
        }else{
            $sql = mysqli_query($conn,"SELECT * FROM setor where id_p='$id' ");
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
        ?>
            <h3 style="border-bottom:solid 1pt #dcdcdc;padding-bottom:10px">Tambah Ternak</h3>
            <form action="" id="add-form" method="post">
                <div class="row mt-2 mb-2">
                    <div class="col-6">Nomor Ternak</div>
                    <div class="col-6"><input required type="text" name="no" class="form-control" placeholder="Masukan Nomor Ternak"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-6">Bulan</div>
                    <div class="col-6"><input required type="number" maxlength="2" name="bulan" class="form-control" placeholder="Masukan Bulan Ternak"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-6">Tahun</div>
                    <div class="col-6"><input required type="number" maxlength="4" name="tahun" class="form-control" placeholder="Masukan Tahun Ternak"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-6">Dara</div>
                    <div class="col-6">
                        <select required name="dara" class="form-control">
                            <option value="Bunting">Bunting</option>
                            <option value="Siap kawin">Siap Kawin</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-6">Pedet</div>
                    <div class="col-6">
                        <select required name="pedet" class="form-control">
                            <option value="Betina">Betina</option>
                            <option value="Jantan">Jantan</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="mode" value="initAdd">
                <div class="row mt-2 mb-2">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <button type="submit" name="submitAdd" class="btn-chat p-2" style="border:none;width:100%;">Tambah Ternak</button>
                    </div>
                </div>
            </form>
            <script> 
                $("#add-form").on('submit',function(e){
                    e.preventDefault();
                    $('#ternak-loader').css('display','block');
                    $.ajax({
                        url:"<?php echo BASE_URL?>/ajax/ajax.ternak.php",
                        method:"POST",
                        data:$("#add-form").serialize(),
                        success:function(data)
                        {
                            $('#ternak-loader').css('display','none');
                            if(data!=0){
                                ternakList();
                                $(".msg-mod").append(data);
                                setTimeout(function(){
                                    $(".msg-mod").empty();
                                },3000)
                                setTimeout(function(){
                                    $(".modternak-konten").empty();
                                    $(".mod-ternak").css('display','none');
                                },3000)
                            }else{
                                $(".msg-mod").append('<div style="background:red;color:#fff">Gagal Tambah Ternak, Coba Lagi..</div>');
                                setTimeout(function(){
                                    $(".msg-mod").empty();
                                },3000)
                            }
                        },
                        error:function(data)
                        {
                            $(".msg-mod").append('<div style="background:red;color:#fff">Gagal Tambah Ternak, Coba Lagi..</div>');
                        }
                    })
                })
            </script>
        <?php
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'showModEdit'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * FROM ternak where id_ternak='$id'");
        $row = mysqli_fetch_assoc($sql);
        ?>
            <h3 style="border-bottom:solid 1pt #dcdcdc;padding-bottom:10px">Tambah Ternak</h3>
            <form action="" id="edit-form" method="post">
                <div class="row mt-2 mb-2">
                    <div class="col-6">Nomor Ternak</div>
                    <div class="col-6"><input value="<?php echo $row['no_ternak'];?>" required type="text" name="no" class="form-control" placeholder="Masukan Nomor Ternak"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-6">Bulan</div>
                    <div class="col-6"><input value="<?php echo $row['bulan'];?>"" required type="number" maxlength="2" name="bulan" class="form-control" placeholder="Masukan Bulan Ternak"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-6">Tahun</div>
                    <div class="col-6"><input value="<?php echo $row['tahun'];?>"" required type="number" maxlength="4" name="tahun" class="form-control" placeholder="Masukan Tahun Ternak"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-6">Dara</div>
                    <div class="col-6">
                        <select required name="dara" class="form-control">
                            <option value="Bunting" <?php if($row['dara']=='Bunting'){echo 'selected';}?>>Bunting</option>
                            <option value="Siap kawin" <?php if($row['dara']=='Siap kawin'){echo 'selected';}?>>Siap Kawin</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-6">Pedet</div>
                    <div class="col-6">
                        <select required name="pedet" class="form-control">
                            <option value="Betina" <?php if($row['pedet']=='Betina'){echo 'selected';}?>>Betina</option>
                            <option value="Jantan" <?php if($row['pedet']=='Jantan'){echo 'selected';}?>>Jantan</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="mode" value="initEdit">
                <input type="hidden" name="id" value="<?php echo $id;?>">
                <div class="row mt-2 mb-2">
                    <div class="col-6"></div>
                    <div class="col-6">
                        <button type="submit" name="submitEdit" class="btn-chat p-2" style="border:none;width:100%;">Edit Ternak</button>
                    </div>
                </div>
            </form>
            <script> 
                $("#edit-form").on('submit',function(e){
                    e.preventDefault();
                    $('#ternak-loader').css('display','block');
                    $.ajax({
                        url:"<?php echo BASE_URL?>/ajax/ajax.ternak.php",
                        method:"POST",
                        data:$("#edit-form").serialize(),
                        success:function(data)
                        {
                            $('#ternak-loader').css('display','none');
                            if(data!=0){
                                ternakList();
                                $(".msg-mod").append(data);
                                setTimeout(function(){
                                    $(".msg-mod").empty();
                                },3000)
                                setTimeout(function(){
                                    $(".modternak-konten").empty();
                                    $(".mod-ternak").css('display','none');
                                },3000)
                            }else{
                                $(".msg-mod").append('<div style="background:red;color:#fff">Gagal Edit Ternak, Coba Lagi..</div>');
                                setTimeout(function(){
                                    $(".msg-mod").empty();
                                },3000)
                            }
                        },
                        error:function(data)
                        {
                            $(".msg-mod").append('<div style="background:red;color:#fff">Gagal Edit Ternak, Coba Lagi..</div>');
                        }
                    })
                })
            </script>
        <?php
    }

?>
<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'initAdd'){
        $id = $_SESSION['user']['id_user'];
        $no = $_POST['no'];
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];
        $pedet = $_POST['pedet'];
        $dara = $_POST['dara'];
        $e = 0;
        if(empty($no)){$e++;}
        if(empty($bulan)){$e++;}
        if(empty($tahun)){$e++;}
        if(empty($pedet)){$e++;}
        if(empty($dara)){$e++;}
        if(!$e){
            $sql = mysqli_query($conn,"INSERT INTO ternak (id_user,no_ternak,bulan,tahun,dara,pedet,created) VALUES('$id','$no','$bulan','$tahun','$dara','$pedet',now())");
            echo '<div style="background:#077703;color:#fff">Berhasil Tambah Ternak</div>';
        }else{
            echo 0;
        }
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'initEdit'){
        $id = $_POST['id'];
        $no = $_POST['no'];
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];
        $pedet = $_POST['pedet'];
        $dara = $_POST['dara'];
        $e = 0;
        if(empty($no)){$e++;}
        if(empty($bulan)){$e++;}
        if(empty($tahun)){$e++;}
        if(empty($pedet)){$e++;}
        if(empty($dara)){$e++;}
        if(!$e){
            $sql = mysqli_query($conn,"UPDATE ternak set no_ternak='$no', bulan='$bulan', tahun='$tahun', dara='$dara', pedet='$pedet' where id_ternak ='$id'");
            echo '<div style="background:#077703;color:#fff">Berhasil Edit Ternak</div>';
        }else{
            echo 0;
        }
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'initDel'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"DELETE FROM ternak where id_ternak='$id'");
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'dafKopMod'){
        ?>
        <input type="text" id="srch-kop" class="form-control mb-3" placeholder="Cari Koperasi">
        <table width="100%">
            <thead>
                <tr>
                    <th>Koperasi</th>
                    <th>Alamat</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="kop-table" style="max-height: 400px;overflow-y:scroll;">
                <?php
                    $sql = mysqli_query($conn,"SELECT * from koperasi");
                    $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                    foreach($row as $r){
                ?>
                <tr>
                    <td><?php echo $r['nama_kp'] ?></td>
                    <td><div style="overflow:hidden;width:200px;white-space: nowrap;text-overflow: ellipsis;"><?php echo $r['alamat']?></div></td>
                    <td><div class="btn-chat" onclick="daftarInit(<?php echo $r['id_koperasi']?>)">Daftar</div></td>
                </tr>
                    <?php }?>
            </tbody>
        </table>
        <script>
            $("#srch-kop").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#kop-table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $('.mod-kop-body .close').click(function(){
                $('.mod-kop').css('display','none');
                $('.kop-list').empty();
            })
        </script>
        <?php
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'daftarInit'){
        $id_k = $_POST['id'];
        $id_p = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"UPDATE peternak set id_kop='$id_k' where id_user = '$id_p'");
        $sql = mysqli_query($conn,"SELECT nama_kp from koperasi where id_koperasi='$id_k'");
        $dataK = mysqli_fetch_assoc($sql);
        ?>
        <h5 id="msg-stat">Anda Terdaftar di <?php echo $dataK['nama_kp'];?></h5>
        <div>Status : <div class="stat-kop">TIDAK AKTIF</div></div>
        <p style="font-size: 8pt;">Mohon Tunggu Aktivasi Admin Koperasi</p>
        <div class="btn-chat" id="btn-daftarKop" onclick="batalKop()">Batal Daftar <i class="fas fa-times"></i></div>
        <div class="msg-load"></div>
        <?php
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'batalKop'){
        $id_p = $_SESSION['user']['id_user'];
        $sql = mysqli_query($conn,"UPDATE peternak set id_kop = NULL, kop_stat=0 where id_user = '$id_p'");
        ?>
        <div class="stat-wrap">
            <h5 id="msg-stat">Anda Belum Terdaftar Di Koperasi</h5>
            <div class="btn-chat" id="btn-daftarKop" onclick="daftarKopMod()">Daftar Koperasi</div>
            <div class="msg-load"></div>
        </div>
        <?php
    }
?>



