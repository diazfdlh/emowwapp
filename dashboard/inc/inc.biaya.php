<div class="row">
    <div class="col-sm-7"><h3>BIAYA TAMBAHAN<div id="add-biaya" class="btn-chat ml-2 pt-2 pb-2 pl-3 pr-3" style="display: inline;"><i class="fas fa-plus mr-1"></i> Tambah Biaya</div></h3></div>
    <div class="col-sm-5">
        <div class="input-group">
            <div id="biaya-srch-cncl" class="input-group-prepend" onclick="clearSrch('biaya')" style="display: none;cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-times"></i></span>
            </div>
            <input id="biaya-srch" type="text" placeholder="Cari Peternak" class="form-control">
            <div class="input-group-append" onclick="srch('biaya')" style="cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</div>
<input id="biaya-currPage" type="text" value="1" hidden>
<div class="biaya-msg"></div>
<div class="row list header m-1">
    <div class="col-1">Tgl</div>
    <div class="col-2">Minggu Ke</div>
    <div class="col-3">Peternak</div>
    <div class="col-4">
        <div class="row">
            <div class="col-4">Biaya</div>
            <div class="col-4">Kredit</div>
            <div class="col-4">Debit</div>
        </div>
    </div>
    <div class="col-2"></div>
</div>

<div id="body-biaya" style="min-height: 400px;">
</div>

