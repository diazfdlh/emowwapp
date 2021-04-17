<div class="row">
    <div class="col-sm"><h3>SETORAN SUSU<div id="add-setor" class="btn-chat ml-2 pt-2 pb-2 pl-3 pr-3" style="display: inline;"><i class="fas fa-plus mr-1"></i> Tambah Setoran</div></h3></div>
    <div class="col-sm">
        <div class="input-group">
            <div id="setor-srch-cncl" class="input-group-prepend" onclick="clearSrch('setor')" style="display: none;cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-times"></i></span>
            </div>
            <input id="setor-srch" type="text" placeholder="Cari Peternak" class="form-control">
            <div class="input-group-append" onclick="srch('setor')" style="cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</div>
<input id="setor-currPage" type="text" value="1" hidden>
<div class="setor-msg"></div>
<div class="row list header m-1">
    <div class="col-2">Tgl</div>
    <div class="col-1">Bagian</div>
    <div class="col-2">Peternak</div>
    <div class="col-1">Jumlah</div>
    <div class="col-2" style="text-align: right;">Harga</div>
    <div class="col-2" style="text-align: right;">Total</div>
    <div class="col-2"></div>
</div>

<div id="body-setor" style="min-height: 400px;">
</div>
