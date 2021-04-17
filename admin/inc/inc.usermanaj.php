<div class="row mb-3">
    <div class="col-sm">
        <h3>MANAJEMEN USER</h3>
        <a href="<?php echo BASE_URL?>admin/import">
            <div class="btn-act" style="width: 200px;">Import Data Pendaftaran</div>
        </a>
    </div>
    <div class="col-sm">
        <div class="input-group">
            <div id="usermanaj-srch-cncl" class="input-group-prepend" onclick="clearSrchMU()" style="display: none;cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-times"></i></span>
            </div>
            <input id="usermanaj-srch" type="text" placeholder="Search" class="form-control">
            <div class="input-group-append" onclick="srchMU()" style="cursor:pointer;">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
        </div>
    </div>
</div>
<input id="usermanaj-currPage" type="text" value="1" hidden>
<div class="usermanaj-msg"></div>
<div class="row list header mt-1 mb-1">
    <div class="col-2">Nama</div>
    <div class="col-2">Username</div>
    <div class="col-3">Email</div>
    <div class="col-2">Role</div>
    <div class="col-2">Dibuat</div>
    <div class="col-1"></div>
</div>

<div id="body-usermanaj" style="min-height: 400px;">
</div>