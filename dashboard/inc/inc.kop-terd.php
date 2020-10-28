<div class="row m-2 pb-2" style="border-bottom: 2pt solid #dcdcdc;">
    <div class="col-sm"><h3>DATA PETERNAK</h3></div>
    <div class="col-sm">
        <div class="input-group">
            <div id="terd-srch-cncl" class="input-group-prepend" onclick="clearSrch('terd')" style="display: none;cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-times"></i></span>
            </div>
            <input id="terd-srch" type="text" placeholder="Cari Terdaftar" class="form-control">
            <div class="input-group-append" onclick="srch('terd')" style="cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</div>
<input id="terd-currPage" type="text" value="1" hidden>
<div class="terd-msg"></div>
<div id="body-terd" style="min-height: 400px;">
</div>
