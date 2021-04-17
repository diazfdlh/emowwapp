<div class="row">
    <div class="col-sm"><h3>TERNAK ANDA <div id="add-ternak" class="btn-chat ml-2 pt-2 pb-2 pl-3 pr-3" style="display: inline;"><i class="fas fa-plus mr-1"></i> Tambah Ternak</div></h3></div>
    <div class="col-sm">
        <div class="input-group">
            <div id="ternak-srch-cncl" class="input-group-prepend" onclick="clearSrch()" style="display: none;cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-times"></i></span>
            </div>
            <input id="ternak-srch" type="text" placeholder="Cari Nomor Ternak" class="form-control">
            <div class="input-group-append" onclick="srch()" style="cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</div>
<input id="ternak-currPage" type="text" value="1" hidden>
<div class="ternak-msg"></div>
<div class="row list header m-1">
    <div class="col-2">Bulan</div>
    <div class="col-2">Tahun</div>
    <div class="col-6">Detail</div>
    <div class="col-2"></div>
</div>

<div id="body-ternak" style="min-height: 400px;">
</div>

<div class="mod-ternak" style="display:none;">
    <div class="overlay"></div>
    <div class="card-nb modbody-ternak">
        <div class="close"><i class="fas fa-times"></i></div>
        <div class="spinner" id="ternak-loader" style="display: none;">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
        <div class="msg-mod"></div>
        <div class="modternak-konten p-3">
            
        </div>
    </div>
</div>

<div class="popup">
    <div class="overlay"></div>
    <div class="pop-modal card p-3 pt-4">
        <div class="pop-close" onclick="closePopup()">
            <i class="fas fa-times"></i>
        </div>
        <h4 id="pop-msg">Apakah Anda yakin akan menghapus ini?</h4>
        <div id="pop-act" class="row" style="margin: 0">
            <div class="col-sm btn-yes card-nb p-2" style="text-align: center;cursor:pointer;background:linear-gradient(90deg, rgba(1,153,97,1) 0%, rgba(181,214,83,1) 61%);color:#fff">YES</div>
            <div class="col-sm card-nb p-2" style="text-align: center;cursor:pointer" onclick="closePopup()">NO</div>
        </div>
    </div>
</div>