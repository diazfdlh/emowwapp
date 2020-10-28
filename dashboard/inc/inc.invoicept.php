<div class="row">
    <div class="col-sm">
        <h3>INVOICE</h3>
        <p>Lihat Invoice Setoran Susu</p>
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
    <div class="col-3">
        <?php
            $sql = mysqli_query($conn,"SELECT id_user from koperasi where id_koperasi='$id_k'");
            $k = mysqli_fetch_assoc($sql);
            $id_k = $k['id_user'];
        ?>
        <input type="text" name="mode" value="inv2" hidden>
        <input type="text" name="id_k" value="<?php echo $id_k;?>" hidden>
        <input type="number" name="thn" class="form-control" placeholder="Tahun" value="<?php echo date('Y',time());?>">
    </div>
    <div class="col-3">
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
    <div class="col-3" style="display: flex;justify-content:center;align-items:center">
        <button type="submit" name="buat" class="btn-chat p-2" style="color:#000;border:none;">
            Buat Invoice
        </button>
    </div>
</div>
    </form>
<div id="body-invoice" style="position:relative;padding:50px 0;min-height: 400px;">
    
</div>
