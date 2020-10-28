<div class="row m-2 pb-2" style="border-bottom: 2pt solid #dcdcdc;">
    <div class="col-sm"><h3>PENDAFTAR </h3></div>
    <div class="col-sm">
        <div class="input-group">
            <div id="pend-srch-cncl" class="input-group-prepend" onclick="clearSrch('pend')" style="display: none;cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-times"></i></span>
            </div>
            <input id="pend-srch" type="text" placeholder="Cari Pendaftar" class="form-control">
            <div class="input-group-append" onclick="srch('pend')" style="cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</div>
<input id="pend-currPage" type="text" value="1" hidden>
<div style="overflow-y: scroll;">
    <div class="pend-msg"></div>
    

    <div id="body-pend" style="min-height: 400px;">
    </div>
</div>
