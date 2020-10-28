<div class="row">
    <div class="col-sm"><h3>AKTIVASI USER</h3></div>
    <div class="col-sm">
        <div class="input-group">
            <div id="useract-srch-cncl" class="input-group-prepend" onclick="clearSrch()" style="display: none;cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-times"></i></span>
            </div>
            <input id="useract-srch" type="text" placeholder="Search" class="form-control">
            <div class="input-group-append" onclick="srch()" style="cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</div>
<input id="useract-currPage" type="text" value="1" hidden>
<div class="useract-msg"></div>
<div class="row list header mt-1 mb-1">
    <div class="col-2">Nama</div>
    <div class="col-2">Username</div>
    <div class="col-3">Email</div>
    <div class="col-2">Role</div>
    <div class="col-2">Dibuat</div>
    <div class="col-1"></div>
</div>

<div id="body-useract" style="min-height: 400px;">
</div>