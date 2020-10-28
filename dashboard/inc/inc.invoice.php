<div class="row">
    <div class="col-sm">
        <h3>INVOICE</h3>
        <p>Buat Invoice Setoran Susu Peternak</p>
    </div>
    <div class="col-sm">
        <!--<div class="input-group">
            <div id="invoice-srch-cncl" class="input-group-prepend" onclick="clearSrch('invoice')" style="display: none;cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-times"></i></span>
            </div>
            <input id="invoice-srch" type="text" placeholder="Cari Peternak" class="form-control">
            <div class="input-group-append" onclick="srch('invoice')" style="cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>-->
    </div>
</div>
<input id="invoice-currPage" type="text" value="1" hidden>
<div class="invoice-msg"></div>
    <form action="" method="post" id="inv-form">
<div class="row list">
    <div class="col-2">
        <input type="text" name="mode" value="inv" hidden>
        <input type="number" name="thn" class="form-control" placeholder="Tahun" value="<?php echo date('Y',time());?>">
    </div>
    <div class="col-2">
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
    <div class="col-3">
        <select name="weeks" id="" class="form-control">
            <option value="1">2 Minggu Pertama</option>
            <option value="2">2 Minggu Kedua</option>
        </select>
    </div>
    <div class="col-3">
        <div class="input-group">
            <input type="text" class="form-control" id="nama_p" name="nama_p" disabled placeholder="Pilih peternak">
            <input type="text" id="id_p" name="id_p" class="form-control" style="opacity:0;position:absolute;z-index:-1" required>
            <div class="input-group-append" id="show-pt" onclick="showPt2()">
                <div class="input-group-text" style="background:#fff;cursor:pointer">
                <i id="chev" class="fas fa-chevron-left"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2" style="display: flex;justify-content:center;align-items:center">
        <button type="submit" name="buat" class="btn-chat p-2" style="color:#000;border:none;">
            Buat Invoice
        </button>
    </div>
</div>
    </form>
<div class="row">    
    <div class="col-12">
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
                            <td style="font-weight: 600;"><?php echo $r['nama']?></td>
                            <td><?php echo $r['pend_pt']?></td>
                            <td><?php echo $r['thn_mulai']?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><div style="margin:0 auto;" class="btn-chat" onclick="pilih2(<?php echo $r['id_user'] ?>,'<?php echo $r['nama']?>')">Pilih</div></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="body-invoice" style="position:relative;padding:50px 0;min-height: 400px;">
    
</div>
