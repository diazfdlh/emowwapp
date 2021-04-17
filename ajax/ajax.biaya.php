<?php
    require_once('../config.php');
    $nperlist = 5;
?>
<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'biayaList'){
        $cp = $_POST['cp'];
        $id = $_SESSION['user']['id_user'];
        $rStart = $nperlist * ($cp - 1);
        $q = $_POST['q'];
        if($q){
            $srch = "AND user.nama LIKE '%".$q."%'";
        }else{
            $srch = '';
        }
        $sql1 = mysqli_query($conn,"SELECT * FROM biaya inner join user on id_p=user.id_user where id_k='$id' ".$srch." order by id_b desc LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql1,MYSQLI_ASSOC);
        //$id = mysqli_insert_id($sql);
        foreach($row as $r){
            $tgl = date('M Y',strtotime('01-'.$r['bulan'].'-'.$r['tahun']));
            $id_b = $r['id_b'];
            ?>
            <div id="biaya-row-<?php echo $r['id_user'];?>" class="row list m-1" style="border: 1pt solid #dcdcdc;font-size:8pt">
                <div class="col-1"><?php echo $tgl?></div>
                <div class="col-2"><?php if($r['mingguke'] == 0){echo "Minggu Ke 1";}else{echo "Minggu Ke 2";}?></div>
                <div class="col-2"><?php echo $r['nama']?></div>
                <div class="col-5">
                    <?php
                        $sql = mysqli_query($conn,"SELECT * FROM biaya_ext where id_b='$id_b' order by jenis");
                        $row1 = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                        foreach($row1 as $r1){
                    ?>
                        <div class="row">
                            <?php
                                $arr = array("Fat","SNF","Density","Protein","Lactose","Salts","Added Water","Freezing Point","TPC");
                                if(in_array($r1['nama_b'],$arr) && $r1['nama_b']!="Freezing Point" && $r1['nama_b'] != "TPC"){ $qty = '%';}
                                else if($r1['nama_b'] == "Freezing Point"){$qty = "°C";}
                                else if($r1['nama_b'] == "TPC"){$qty = "CFU/ml";}
                                else{ $qty = "x";}
                            ?>
                            <div class="col-4"><?php echo $r1['nama_b'].' <b>'.$r1['qty'].''.$qty;?></b></div>
                            <div class="col-4" style="text-align: right;"><?php if($r1['jenis']=='kredit'){echo 'Rp '.number_format($r1['nominal'],0,"",".");}else{echo '-';}?></div>
                            <div class="col-4" style="text-align: right;"><?php if($r1['jenis']=='debit'){echo 'Rp '.number_format($r1['nominal'],0,"",".");}else{echo '-';}?></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-2">
                    <i class="fas fa-pencil-alt" style="cursor: pointer;color:#019961;" onclick="editB(<?php echo $r['id_b'];?>)"><span style="font-family:Arial, Helvetica, sans-serif;color:#019961;font-size:8pt;"> Edit</span></i>
                    <i class="fas fa-trash" style="cursor: pointer;color:#d44950;" onclick="delB(<?php echo $r['id_b'];?>)"><span style="font-family:Arial, Helvetica, sans-serif;color:#d44950;font-size:8pt;"> Delete</span></i>
                </div>
            </div>
            <?php
        }
        $n = mysqli_num_rows($sql1);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada data setoran</div>
        <?php 
        }else{
            $sql = mysqli_query($conn,"SELECT * FROM biaya inner join user on id_p=user.id_user where id_k='$id' ".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#biaya')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
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
            <h3 style="border-bottom:solid 1pt #dcdcdc;padding-bottom:10px">Tambah Transaksi</h3>
            <form action="" id="add-form-b" method="post">
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
                    <div class="col-5">Bulan - Tahun</div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-sm">
                            <select name="bln" class="form-control">
                                <option value="01" <?php if(date('m',time())==1){echo'selected';}?>>Jan</option>
                                <option value="02" <?php if(date('m',time())==2){echo'selected';}?>>Feb</option>
                                <option value="03" <?php if(date('m',time())==3){echo'selected';}?>>Mar</option>
                                <option value="04" <?php if(date('m',time())==4){echo'selected';}?>>Apr</option>
                                <option value="05" <?php if(date('m',time())==5){echo'selected';}?>>Mei</option>
                                <option value="06" <?php if(date('m',time())==6){echo'selected';}?>>Jun</option>
                                <option value="07" <?php if(date('m',time())==7){echo'selected';}?>>Jul</option>
                                <option value="08" <?php if(date('m',time())==8){echo'selected';}?>>Aug</option>
                                <option value="09" <?php if(date('m',time())==9){echo'selected';}?>>Sep</option>
                                <option value="10" <?php if(date('m',time())==10){echo'selected';}?>>Oct</option>
                                <option value="11" <?php if(date('m',time())==11){echo'selected';}?>>Nov</option>
                                <option value="12" <?php if(date('m',time())==12){echo'selected';}?>>Dec</option>
                            </select>
                            </div>
                            <div class="col-sm">
                                <input required type="number" name="thn" class="form-control" value="<?php echo date('Y',time());?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Bagian</div>
                    <div class="col-7">
                        <select required name="bagian" class="form-control">
                            <option value="0">2 Minggu Pertama</option>
                            <option value="1">2 Minggu Kedua</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-12"><div id="add-field-btn" onclick="addField()" class="chat-btn" style="background:linear-gradient(45deg, rgba(1,153,97,1) 0%, rgba(181,214,83,1) 70%);display: inline-block;margin-right:10px"><i class="fas fa-plus"></i></div>Tambah Field </div>
                </div>
                <div class="row field-header">
                    <div class="col-2">Jenis Transaksi</div>
                    <div class="col-3">Nama Transaksi</div>
                    <div class="col-3">Jumlah</div>
                    <div class="col-3">Nominal</div>
                    <div class="col-1"></div>
                </div>
                <div id="ext-wrap">
                    <div class="row mt-2 mb-2">
                        <div class="col-2">
                            <select name="ext[0][plusmin]" class="form-control"><option value="kredit">+Kredit</option><option value="debit">-Debit</option></select>
                        </div>
                        <div class="col-3">
                            <select class="form-control nama-transaksi">
                                <option value="Custom">-Custom-</option>
                                <option value="Fat">Fat</option>
                                <option value="SNF">SNF</option>
                                <option value="Density">Density</option>
                                <option value="Protein">Protein</option>
                                <option value="Lactose">Lactose</option>
                                <option value="Salts">Salts</option>
                                <option value="Added Water">Added Water</option>
                                <option value="Freezing Point">Freezing Point</option>
                                <option value="TPC">TPC</option>
                            </select>
                            <input required type="text" id="n-t" name="ext[0][detail]" class="form-control" placeholder="Nama Transaksi">
                        </div>
                        <div class="col-3">
                            <div class="input-group mb-3">
                                <input required type="number" step="0.01" value="" name="ext[0][qty]" class="form-control qty" placeholder="Qty">
                                <div class="input-group-append">
                                    <span class="input-group-text">x</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="ext[0][biaya]" class="form-control nomm" placeholder="Nominal">
                            </div>
                            
                        </div>
                        <div class="col-1">
                            <i style="color:#dcdcdc;">default</i>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="mode" value="initAdd">
                <input type="number" hidden name="n" id="n" value="1">
                <small class="text-danger">*CATATAN :</small><br/>
                <small class="text-danger">Total Transaksi Custom hasil pengkalian jumlah dan nominal</small><br/>
                <small class="text-danger">Total Transaksi selain Custom akan di kalikan dengan jumlah susu periode 2 minggu yang tercantum</small><br/>
                <div class="row mt-2 mb-2">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <button type="submit" name="submitAdd" class="btn-act px-2 py-3 mt-3" style="border:none;width:100%;font-size:12pt;">Tambah Transaksi</button>
                    </div>
                </div>
            </form>
            <script> 
            
            $(document).on('change','.nama-transaksi',function(e){
                var opt = $(this).val();
                if(opt==='Custom'){
                    $(this).next('#n-t').prop('value','').show();
                }else{
                    $(this).next('#n-t').hide().prop('value',opt);
                    switch (opt) {
                        case 'Fat':
                            pre = "%";
                            break;
                        case 'SNF':
                            pre = "%";
                            break;
                        case 'Density':
                            pre = "%";
                            break;
                        case 'Protein':
                            pre = "%";
                            break;
                        case 'Lactose':
                            pre = "%";
                            break;
                        case 'Salts':
                            pre = "%";
                            break;
                        case 'Added Water':
                            pre = "%";
                            break;
                        case 'Freezing Point':
                            pre = "&deg;C";
                            break;
                        case 'TPC':
                            pre = "<small style='font-size:7pt;'>CFU/ml</small>";
                            break;
                        default:
                            pre = "-";
                    }
                    $(this).closest('.row').find('.input-group-append>.input-group-text').empty().html(pre);
                }
            })

                function addField(){
                    var n = $('.mod-ternak #n').val();
                    n = parseInt(n);
                    n += 1; 
                    $('.mod-ternak #ext-wrap').append('<div class="row mt-2 mb-2"><div class="col-2"><select name="ext['+n+'][plusmin]" class="form-control"><option value="kredit">+Kredit</option><option value="debit">-Debit</option></select></div><div class="col-3"><select class="form-control nama-transaksi"> <option value="Custom">-Custom-</option> <option value="Fat">Fat</option> <option value="SNF">SNF</option> <option value="Density">Density</option> <option value="Protein">Protein</option> <option value="Lactose">Lactose</option> <option value="Salts">Salts</option> <option value="Added Water">Added Water</option> <option value="Freezing Point">Freezing Point</option> <option value="TPC">TPC</option> </select> <input required type="text" id="n-t" name="ext['+n+'][detail]" class="form-control" placeholder="Nama Transaksi"></div><div class="col-3"><div class="input-group mb-3"> <input required type="number" step="0.01" value="" name="ext['+n+'][qty]" class="form-control qty" placeholder="Qty"> <div class="input-group-append"> <span class="input-group-text">x</span> </div></div></div><div class="col-3"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input  type="number" name="ext['+n+'][biaya]" class="form-control nomm" placeholder="Nominal"></div></div><div class="col-1"><div class="chat-btn remove-field-btn" style="background:red;"><i class="fas fa-times"></i></div></div></div>');
                    $('.mod-ternak #n').attr('value',n);
                }
                $('.mod-ternak #ext-wrap').on('click','.remove-field-btn',function(e){
                    $(this).closest('.row').remove();
                });
                $('#ext-wrap .remove-field-btn').on('click',function(e){
                    $(this).closest('.row').remove();
                });
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
        $id_b = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * from biaya inner join user on user.id_user=biaya.id_p where id_b ='$id_b'");
        $row = mysqli_fetch_assoc($sql);
        ?>
            <h3 style="border-bottom:solid 1pt #dcdcdc;padding-bottom:10px">Edit Setoran</h3>
            <form action="" id="edit-form-b" method="post">
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
                    <div class="col-5">Bulan - Tahun</div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-sm">
                            <select name="bln" class="form-control">
                                <option value="01" <?php if($row['bulan']==1){echo'selected';}?>>Jan</option>
                                <option value="02" <?php if($row['bulan']==2){echo'selected';}?>>Feb</option>
                                <option value="03" <?php if($row['bulan']==3){echo'selected';}?>>Mar</option>
                                <option value="04" <?php if($row['bulan']==4){echo'selected';}?>>Apr</option>
                                <option value="05" <?php if($row['bulan']==5){echo'selected';}?>>Mei</option>
                                <option value="06" <?php if($row['bulan']==6){echo'selected';}?>>Jun</option>
                                <option value="07" <?php if($row['bulan']==7){echo'selected';}?>>Jul</option>
                                <option value="08" <?php if($row['bulan']==8){echo'selected';}?>>Aug</option>
                                <option value="09" <?php if($row['bulan']==9){echo'selected';}?>>Sep</option>
                                <option value="10" <?php if($row['bulan']==10){echo'selected';}?>>Oct</option>
                                <option value="11" <?php if($row['bulan']==11){echo'selected';}?>>Nov</option>
                                <option value="12" <?php if($row['bulan']==12){echo'selected';}?>>Dec</option>
                            </select>
                            </div>
                            <div class="col-sm">
                                <input required type="number" name="thn" class="form-control" value="<?php echo $row['tahun'];?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-5">Bagian</div>
                    <div class="col-7">
                        <select required name="bagian" class="form-control">
                            <option value="0" <?php if($row['mingguke']=='0'){echo 'selected';}?>>2 Minggu Pertama</option>
                            <option value="1" <?php if($row['mingguke']=='1'){echo 'selected';}?>>2 Minggu Kedua</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-12"><div id="add-field-btn" onclick="addField()" class="chat-btn" style="background:linear-gradient(45deg, rgba(1,153,97,1) 0%, rgba(181,214,83,1) 70%);display: inline-block;margin-right:10px"><i class="fas fa-plus"></i></div>Tambah Field </div>
                </div>
                <div class="row field-header">
                    <div class="col-2">Jenis Transaksi</div>
                    <div class="col-3">Nama Transaksi</div>
                    <div class="col-3">Jumlah</div>
                    <div class="col-3">Nominal</div>
                    <div class="col-1"></div>
                </div>
                <div id="ext-wrap">
                    <?php 
                        $sql = mysqli_query($conn,"SELECT * FROM biaya_ext where id_b ='$id_b'");
                        $row3 = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                        $n1 = mysqli_num_rows($sql);
                        $n = 0;
                        foreach($row3 as $r){
                            $n +=1;
                    ?>
                        <div class="row mt-2 mb-2">
                            <div class="col-2">
                                <select name="ext[<?php echo $n?>][plusmin]" class="form-control unedited">
                                    <option value="kredit" <?php if($r['jenis']=='kredit'){echo 'selected';}?>>+Kredit</option>
                                    <option value="debit" <?php if($r['jenis']=='debit'){echo 'selected';}?>>-Debit</option>
                                </select>
                            </div>
                            <div class="col-3">
                            <?php
                                $arr = array("Fat","SNF","Density","Protein","Lactose","Salts","Added Water","Freezing Point","TPC");
                            ?>
                                <select class="form-control nama-transaksi unedited">
                                    <option value="Custom" <?php if(!in_array($r['nama_b'],$arr)){echo "selected";}?>>-Custom-</option>
                                    <option value="Fat" <?php if($r['nama_b'] === "Fat"){echo "selected";}?>>Fat</option>
                                    <option value="SNF" <?php if($r['nama_b'] === "SNF"){echo "selected";}?>>SNF</option>
                                    <option value="Density" <?php if($r['nama_b'] === "Density"){echo "selected";}?>>Density</option>
                                    <option value="Protein" <?php if($r['nama_b'] === "Protein"){echo "selected";}?>>Protein</option>
                                    <option value="Lactose" <?php if($r['nama_b'] === "Lactose"){echo "selected";}?>>Lactose</option>
                                    <option value="Salts" <?php if($r['nama_b'] === "Salts"){echo "selected";}?>>Salts</option>
                                    <option value="Added Water" <?php if($r['nama_b'] === "Added Water"){echo "selected";}?>>Added Water</option>
                                    <option value="Freezing Point" <?php if($r['nama_b'] === "Freezing Point"){echo "selected";}?>>Freezing Point</option>
                                    <option value="TPC" <?php if($r['nama_b'] === "TPC"){echo "selected";}?>>TPC</option>
                                </select>
                                <input required type="text" id="n-t" value="<?php echo $r['nama_b'];?>" name="ext[<?php echo $n?>][detail]" style="<?php if(in_array($r['nama_b'],$arr)){echo "display:none;";}?>" class="form-control unedited" placeholder="Nama Transaksi">
                                <input required type="number" value="<?php echo $r['id_be'] ?>" name="ext[<?php echo $n?>][id_b]" hidden>
                            </div>
                            <div class="col-3">
                            <div class="input-group mb-3">
                                <input required type="number"step="0.01" value="<?php echo $r['qty'];?>" name="ext[<?php echo $n?>][qty]" class="form-control unedited qty" placeholder="Qty">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <?php 
                                            if(in_array($r['nama_b'],$arr) && $r['nama_b'] != 'Freezing Point' && $r['nama_b'] != "TPC"){
                                                echo "%";
                                            }else if($r['nama_b'] == "Freezing Point"){echo "&deg;C";}
                                            else if($r['nama_b'] == "TPC"){echo "<small style='font-size:7pt;'>CFU/ml</small>";}
                                            else{echo "x";}
                                        ?>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div class="col-3">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" value="<?php echo $r['nominal'];?>" name="ext[<?php echo $n?>][biaya]" class="form-control unedited nomm" placeholder="Nominal">
                            </div>
                                <input required type="number" class="editedstat" value="0" name="ext[<?php echo $n?>][status]" hidden>
                            </div>
                            <div class="col-1">
                                <?php if($n!=1){?>
                                    <div class="chat-btn remove-field-btn unedited" style="background: red;"><i class="fas fa-times"></i></div>
                                <?php }else{?>
                                    <i style="color:#dcdcdc;">Default</i>
                                <?php }?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <input type="hidden" name="mode" value="initEdit">
                <input type="hidden" name="id" value="<?php echo $id_b;?>">
                <input type="number" hidden name="n" id="n" value="<?php echo $n1;?>">
                <small class="text-danger">*CATATAN :</small><br/>
                <small class="text-danger">Total Transaksi Custom hasil pengkalian jumlah dan nominal</small><br/>
                <small class="text-danger">Total Transaksi selain Custom akan di kalikan dengan jumlah susu periode 2 minggu yang tercantum</small><br/>
                <div class="row mt-2 mb-2">
                    <div class="col-7"></div>
                    <div class="col-5">
                        <button type="submit" name="submitEdit" class="btn-act px-2 py-3 mt-3" style="border:none;width:100%;font-size:12pt;">Simpan Setor</button>
                    </div>
                </div>
            </form>
            
            <script> 
                function addField(){
                    var n = $('.mod-ternak #n').val();
                    n = parseInt(n);
                    n += 1; 
                    $('.mod-ternak #ext-wrap').append('<div class="row mt-2 mb-2"><div class="col-2"><select name="ext['+n+'][plusmin]" class="form-control"><option value="kredit">+Kredit</option><option value="debit">-Debit</option></select></div><div class="col-3"><select class="form-control nama-transaksi"> <option value="Custom">-Custom-</option> <option value="Fat">Fat</option> <option value="SNF">SNF</option> <option value="Density">Density</option> <option value="Protein">Protein</option> <option value="Lactose">Lactose</option> <option value="Salts">Salts</option> <option value="Added Water">Added Water</option> <option value="Freezing Point">Freezing Point</option> <option value="TPC">TPC</option> </select><input id="n-t" required type="text" name="ext['+n+'][detail]" class="form-control" placeholder="Nama Transaksi"></div><div class="col-3"><div class="input-group mb-3"> <input required type="number" step="0.01" value="" name="ext['+n+'][qty]" class="form-control qty" placeholder="Qty"> <div class="input-group-append"> <span class="input-group-text">x</span> </div></div></div><div class="col-3"><div class="input-group mb-3"><div class="input-group-prepend"><span class="input-group-text">Rp</span></div><input type="number" name="ext['+n+'][biaya]" class="form-control nomm" placeholder="Nominal"></div><input required type="number" value="2" name="ext['+n+'][status]" hidden></div><div class="col-1"><div class="chat-btn remove-field-btn added" style="background:red;"><i class="fas fa-times"></i></div></div></div>');
                    $('.mod-ternak #n').attr('value',n);
                }
                $('.mod-ternak #ext-wrap').on('change','.unedited',function(e){
                    $(this).closest('.row').find('.editedstat').attr('value',1);
                })
                $('.mod-ternak #ext-wrap').on('keyup','.unedited',function(e){
                    $(this).closest('.row').find('.editedstat').attr('value',1);
                })
                $('.mod-ternak #ext-wrap').on('click','.remove-field-btn.added',function(e){
                    $(this).closest('.row').remove();
                });
                $('.mod-ternak #ext-wrap').on('click','.remove-field-btn.unedited',function(e){
                    $(this).closest('.row').css('display','none');
                    $(this).closest('.row').find('.editedstat').attr('value',3);
                });
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
        $bln = $_POST['bln'];
        $thn = $_POST['thn'];
        $bagian = $_POST['bagian'];
        //echo $id_p.' '.$tgl.' '.$bagian.' '.$jumlah.' '.$harga.' '.$total;
        $sql = mysqli_query($conn,"INSERT INTO biaya (id_p,id_k,tahun,bulan,mingguke) VALUES('$id_p','$id','$thn','$bln','$bagian')");
        $id_b = mysqli_insert_id($conn);
        foreach($_POST['ext'] as $x => $x_value) {
            $biaya = 0;
            $qty = 1;
            $detail = '';
            foreach($x_value as $sub_x => $sub_x_value) {
                if($sub_x == 'detail'){
                    $detail = $sub_x_value;
                }else if($sub_x == 'biaya' && !empty($sub_x)){
                    $biaya = $sub_x_value;
                }else if($sub_x == 'qty' && !empty($sub_x)){
                    $qty = $sub_x_value;
                }else{
                    $mode = $sub_x_value;
                }
            }
            $sql = mysqli_query($conn,"INSERT INTO biaya_ext (id_b,nama_b,nominal,jenis,qty) values('$id_b','$detail','$biaya','$mode','$qty')");       
        }
        echo '<div style="background:#077703;color:#fff" class="p-2">Berhasil Tambah Transaksi</div>';
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'initEdit'){
        $id = $_SESSION['user']['id_user'];
        $id_b = $_POST['id'];
        $id_p = $_POST['id_p'];
        $bln = $_POST['bln'];
        $thn = $_POST['thn'];
        $bagian = $_POST['bagian'];
        $sql = mysqli_query($conn,"UPDATE biaya set id_p='$id_p',id_k='$id',mingguke='$bagian',bulan='$bln',tahun='$thn' where id_b='$id_b'");
        
        foreach($_POST['ext'] as $x => $x_value) {
            $biaya = 0;
            $detail = '';
            foreach($x_value as $sub_x => $sub_x_value) {
                if($sub_x == 'detail'){
                    $detail = $sub_x_value;
                }else if($sub_x == 'biaya'){
                    $biaya = $sub_x_value;
                }else if($sub_x == 'id_b'){
                    $id_be = $sub_x_value;
                }else if($sub_x == 'plusmin'){
                    $mode = $sub_x_value;
                }else if($sub_x == 'qty' && !empty($sub_x)){
                    $qty = $sub_x_value;
                }else{
                    $status = $sub_x_value;
                }
            }
            if($status == 1){//edited
                $sql = mysqli_query($conn,"UPDATE biaya_ext set id_b='$id_b',nama_b='$detail',nominal='$biaya',jenis='$mode',qty='$qty' where id_be='$id_be'");
            }else if($status == 2){//added
                $sql = mysqli_query($conn,"INSERT INTO biaya_ext (id_b,nama_b,nominal,jenis,qty) values('$id_b','$detail','$biaya','$mode','$qty')");
            }else if($status == 3){//removed
                $sql = mysqli_query($conn,"DELETE FROM biaya_ext where id_be='$id_be'");
            }else{
            }
                    
        }
        echo '<div style="background:#077703;color:#fff"  class="p-2">Berhasil Edit Transaksi</div>';
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'initDel'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"DELETE FROM biaya_ext where id_b='$id'");
        $sql = mysqli_query($conn,"DELETE FROM biaya where id_b='$id'");
    }
?>