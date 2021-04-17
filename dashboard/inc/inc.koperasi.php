<style>
    .page-item.active .page-link{
        background-color:#019961;
        border-color:#019961;
        color:#fff !important;
    }
</style>
<div class="container" style="max-width: 1500px;">
    <div class="card card-nb p-3" style="text-align: center;">
    <a href="<?php echo BASE_URL?>"><img src="<?php echo BASE_URL?>ass/img/main/logo.png" style="width:200px;margin:0 auto" alt=""></a>
    </div>
    <div class="row">
        <div class="col-sm-2" style="padding:0">
            <div class="card m-3 card-nb sidenav" style="position: -webkit-sticky;position: sticky;top: 20px;">
                <ul>
                    <li id="nav-info" onclick="nav('info')" class="active"><i class="fas fa-user-alt"></i>INFO AKUN</li>
                    <li id="nav-sec" onclick="nav('sec')"><i class="fas fa-lock"></i>KEAMANAN</li>
                    <li id="nav-daftar" onclick="nav('daftar')"><i class="fas fa-user-plus"></i>PENDAFTAR</li>
                    <li id="nav-terdaftar" onclick="nav('terdaftar')"><i class="fas fa-users"></i>PETERNAK</li>
                    <li id="nav-setor" onclick="nav('setor')"><i class="fas fa-wine-bottle"></i>SETORAN SUSU</li>
                    <li id="nav-biaya" onclick="nav('biaya')"><i class="fas fa-coins"></i>TRANSAKSI</li>
                    <li id="nav-invoice" onclick="nav('invoice')"><i class="fas fa-receipt"></i>INVOICE</li>
                    <a href="<?php echo BASE_URL?>logout.php"><li><i class="fas fa-sign-out-alt"></i>LOGOUT</li></a>
                </ul>
            </div>
        </div>
        <div class="col-sm-10">
            <div class="card-nb body-content mt-3">
                <div id="isi-info" class="active">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.infoakun.php');?>
                </div>
                <div id="isi-sec">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.secur.php');?>
                </div>
                <div id="isi-daftar">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.kop-daf.php');?>
                </div>
                <div id="isi-terdaftar">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.kop-terd.php');?>
                </div>
                <div id="isi-setor">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.setor.php');?>
                </div>
                <div id="isi-biaya">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.biaya.php');?>
                </div>
                <div id="isi-invoice">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.invoice.php');?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="img-mod">
  <span id="img-close" onclick="closeImg()">&times;</span>
  <img class="" id="img-mod-src">
</div>


<div class="mod-ternak" style="display:none;">
    <div class="overlay"></div>
    <div class="card-nb modbody-ternak py-4 px-3" style="width:1000px">
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

<div class="popup" >
    <div class="overlay"></div>
    <div class="pop-modal card p-3 pt-4">
        <div class="pop-close" onclick="closePopup()">
            <i class="fas fa-times"></i>
        </div>
        <h4 id="pop-msg"></h4>
        <div id="pop-act" class="row" style="margin: 0">
            <div class="col-sm btn-yes card-nb p-2" style="text-align: center;cursor:pointer;background:linear-gradient(90deg, rgba(1,153,97,1) 0%, rgba(181,214,83,1) 61%);color:#fff">YES</div>
            <div class="col-sm card-nb p-2" style="text-align: center;cursor:pointer" onclick="closePopup()">NO</div>
        </div>
    </div>
</div>
<?php 
    include(INC_DIR.'footer.php');
?>
<script>
    <?php if(isset($_GET['page'])){?>    
        $(document).ready(function(){
            <?php if($_GET['page']=='peternak'){?>
            nav('terdaftar');
            <?php }?>
        })
    <?php }?>
    function showPt2(){
        if($('#pt-wrap').css('display') === 'none'){
            //console.log('none');
            $('i#chev').css('transform','rotate(-90deg)')
        }else{
            $('i#chev').css('transform','rotate(0deg)')
        }
        $('#pt-wrap').toggle();
    }
    function pilih(id,nama){
        $('#id_p').attr('value',id);
        $('#nama_p').attr('value',nama);
        $('#pt-wrap').hide();
        $('i#chev').css('transform','rotate(0deg)')
    }
    function pilih2(id,nama){
        $('#id_p').attr('value',id);
        $('#nama_p').attr('value',nama);
        $('#pt-wrap').hide();
        $('i#chev').css('transform','rotate(0deg)')
    }
</script>
<script>
    function nav(menu){
        $('.sidenav li').removeClass('active');
        $('#nav-'+menu).addClass('active')
        $('.body-content>div').removeClass('active')
        $('#isi-'+menu).addClass('active')
    }
    $(".close").click(function(){
        $(".modternak-konten").empty();
        $(".mod-ternak").css('display','none');
    })
    $("#add-setor").click(function(){
        var mode = 'showModAdd';
        $('#ternak-loader').css('display','block');
        $(".mod-ternak").css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.setor.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
                $('#ternak-loader').css('display','none');
                $('.modternak-konten').append(data);
            }
        })
    })
    $("#add-biaya").click(function(){
        var mode = 'showModAdd';
        $('#ternak-loader').css('display','block');
        $(".mod-ternak").css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.biaya.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
                $('#ternak-loader').css('display','none');
                $('.modternak-konten').append(data);
            }
        })
    })
</script>
<script>
    $(document).ready(function(){
        setorList()
        terdList()
        pendList()
        biayaList()
        $('#pt-srch').on('keyup',function(){
            var value = $(this).val().toLowerCase();
            console.log(value)
            $("#pt-tbl tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $('.mod-ternak').on('keyup','#pt-srch',function(){
            var value = $(this).val().toLowerCase();
            console.log(value)
            $("#pt-tbl tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        $('.mod-ternak').on('submit','#add-form',function(e){
            e.preventDefault();
            $('#ternak-loader').css('display','block');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.setor.php",
                method:"POST",
                data:$(".mod-ternak #add-form").serialize(),
                success:function(data)
                {
                    $('#ternak-loader').css('display','none');
                    if(data!=0){
                        setorList();
                        $(".msg-mod").append(data);
                        setTimeout(function(){
                            $(".msg-mod").empty();
                        },3000)
                        setTimeout(function(){
                            $(".modternak-konten").empty();
                            $(".mod-ternak").css('display','none');
                        },2000)
                    }else{
                        $(".msg-mod").append('<div style="background:red;color:#fff" class="p-2">Gagal Tambah Data, Coba Lagi..</div>');
                        setTimeout(function(){
                            $(".msg-mod").empty();
                        },3000)
                    }
                },
                error:function(data)
                {
                    $(".msg-mod").append('<div style="background:red;color:#fff" class="p-2">Gagal Tambah Data, Coba Lagi..</div>');
                }
            })
        });
        $('.mod-ternak').on('submit','#edit-form',function(e){
            e.preventDefault();
            $('#ternak-loader').css('display','block');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.setor.php",
                method:"POST",
                data:$(".mod-ternak #edit-form").serialize(),
                success:function(data)
                {
                    $('#ternak-loader').css('display','none');
                    if(data!=0){
                        setorList();
                        $(".msg-mod").append(data);
                        setTimeout(function(){
                            $(".msg-mod").empty();
                        },3000)
                        setTimeout(function(){
                            $(".modternak-konten").empty();
                            $(".mod-ternak").css('display','none');
                        },2000)
                    }else{
                        $(".msg-mod").append('<div style="background:red;color:#fff" class="p-2">Gagal Edit Data, Coba Lagi..</div>');
                        setTimeout(function(){
                            $(".msg-mod").empty();
                        },3000)
                    }
                },
                error:function(data)
                {
                    $(".msg-mod").append('<div style="background:red;color:#fff" class="p-2">Gagal Edit Data, Coba Lagi..</div>');
                }
            })
        });
        $('.mod-ternak').on('submit','#add-form-b',function(e){
            e.preventDefault();
            $('#ternak-loader').css('display','block');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.biaya.php",
                method:"POST",
                data:$(".mod-ternak #add-form-b").serialize(),
                success:function(data)
                {
                    $('#ternak-loader').css('display','none');
                    if(data!=0){
                        biayaList();
                        $(".msg-mod").append(data);
                        setTimeout(function(){
                            $(".msg-mod").empty();
                        },3000)
                        setTimeout(function(){
                            $(".modternak-konten").empty();
                            $(".mod-ternak").css('display','none');
                        },2000)
                    }else{
                        $(".msg-mod").append('<div style="background:red;color:#fff" class="p-2">Gagal Tambah Data, Coba Lagi..</div>');
                        setTimeout(function(){
                            $(".msg-mod").empty();
                        },3000)
                    }
                },
                error:function(data)
                {
                    $(".msg-mod").append('<div style="background:red;color:#fff" class="p-2">Gagal Tambah Data, Coba Lagi..</div>');
                }
            })
        });
        $('.mod-ternak').on('submit','#edit-form-b',function(e){
            e.preventDefault();
            $('#ternak-loader').css('display','block');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.biaya.php",
                method:"POST",
                data:$(".mod-ternak #edit-form-b").serialize(),
                success:function(data)
                {
                    $('#ternak-loader').css('display','none');
                    if(data!=0){
                        biayaList();
                        $(".msg-mod").append(data);
                        setTimeout(function(){
                            $(".msg-mod").empty();
                        },3000)
                        setTimeout(function(){
                            $(".modternak-konten").empty();
                            $(".mod-ternak").css('display','none');
                        },2000)
                    }else{
                        $(".msg-mod").append('<div style="background:red;color:#fff" class="p-2">Gagal Edit Data, Coba Lagi..</div>');
                        setTimeout(function(){
                            $(".msg-mod").empty();
                        },3000)
                    }
                },
                error:function(data)
                {
                    $(".msg-mod").append('<div style="background:red;color:#fff" class="p-2">Gagal Edit Data, Coba Lagi..</div>');
                }
            })
        });
        $('#inv-form').on('submit',function(e){
            e.preventDefault();
            ajaxCusLoad('#body-invoice');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.inv.php",
                method:"GET",
                data:$("#inv-form").serialize(),
                success:function(data)
                {
                    $("#body-invoice").empty().append(data);
                }
            })
        });

    })
    
    function edit(id){
        var mode = 'showModEdit';
        $('#ternak-loader').css('display','block');
        $(".mod-ternak").css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.setor.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('#ternak-loader').css('display','none');
                $('.modternak-konten').append(data);
            }
        })
    }
    function del(id){
        $('.popup').css('display','block')
        $('#pop-msg').append('Apakah anda yakin akan menghapus data setor ini?')
        $('.btn-yes').attr("onclick","initDel("+id+")");
    }
    function initDel(id){
        var mode = 'initDel';
        closePopup();
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.setor.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                setorList();
            }
        })
    }
    function editB(id){
        var mode = 'showModEdit';
        $('#ternak-loader').css('display','block');
        $(".mod-ternak").css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.biaya.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('#ternak-loader').css('display','none');
                $('.modternak-konten').append(data);
            }
        })
    }
    function delB(id){
        $('.popup').css('display','block')
        $('#pop-msg').append('Apakah anda yakin akan menghapus data biaya ini?')
        $('.btn-yes').attr("onclick","initDelB("+id+")");
    }
    function initDelB(id){
        var mode = 'initDel';
        closePopup();
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.biaya.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                biayaList();
            }
        })
    }
    function acc(id){
        $('.popup').css('display','block')
        $('#pop-msg').append('Apakah anda yakin akan menerima peternak ini?')
        $('.btn-yes').attr("onclick","initAcc("+id+")");
    }
    function initAcc(id){
        var mode = "acc";
        ajaxCusLoad('#body-pend');
        closePopup();
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.daft.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('#body-pend').empty();
                pendList();
                terdList();
            }
        });
    }
    function rej(id){
        $('.popup').css('display','block')
        $('#pop-msg').append('Apakah anda yakin akan menolak peternak ini?')
        $('.btn-yes').attr("onclick","rejInit("+id+")"); 
    }
    function rejInit(id){
        var mode = "rej";
        ajaxCusLoad('#body-pend');
        closePopup();
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.daft.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('#body-pend').empty();
                pendList();
            }
        });
    }
    function delTerd(id){
        $('.popup').css('display','block')
        $('#pop-msg').append('Apakah anda yakin akan menghapus peternak ini?')
        $('.btn-yes').attr("onclick","delTerdInit("+id+")"); 
    }
    function delTerdInit(id){
        var mode = "delTerd";
        ajaxCusLoad('#body-terd');
        closePopup();
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.terd.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('#body-terd').empty();
                terdList();
            }
        });
    }
    function srch(menu){
        console.log(menu);
        if($('#'+menu+'-srch').length){
            $('#'+menu+'-currPage').attr('value',1)
            if(menu == 'setor'){
                setorList();
            }
            if(menu == 'pend'){
                pendList();
            }
            if(menu == 'terd'){
                terdList();
            }
            if(menu == 'biaya'){
                biayaList();
            }
            $('#'+menu+'-srch-cncl').css('display','flex')
        }
    }
    function clearSrch(menu){
        $('#'+menu+'-srch').prop('value','');
        $('#'+menu+'-currPage').attr('value',1)
        if(menu == 'setor'){
            setorList();
        }
        if(menu == 'pend'){
            pendList();
        }
        if(menu == 'terd'){
            terdList();
        }
        if(menu == 'biaya'){
            biayaList();
        }
        $('#'+menu+'-srch-cncl').css('display','none')
    }
    function closePopup(){
        $('.popup').css('display','none')
        $('#pop-msg').empty()
        $('.btn-yes').prop('onclick','');
    }
    function openPop(msg,func,prm,id){
        console.log(msg)
        $('.popup').css('display','block')
        $('#pop-msg').append(msg)
        $('.btn-yes').attr("onclick",func+"("+prm+","+id+")")
    }
    
    function setorList(){
        var cp = $('#setor-currPage').val()
        var q = $('#setor-srch').val()
        if(q.length == 0){
            q = 0
        }
        var mode = "setorList";
        ajaxCusLoad('#body-setor');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.setor.php",
            method:"POST",
            data:{mode:mode,q:q,cp:cp},
            success:function(data)
            {
                $('#body-setor').empty();
                $('#body-setor').append(data);
            }
        });
    }
    function biayaList(){
        var cp = $('#biaya-currPage').val()
        var q = $('#biaya-srch').val()
        if(q.length == 0){
            q = 0
        }
        var mode = "biayaList";
        ajaxCusLoad('#body-biaya');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.biaya.php",
            method:"POST",
            data:{mode:mode,q:q,cp:cp},
            success:function(data)
            {
                $('#body-biaya').empty();
                $('#body-biaya').append(data);
            }
        });
    }
    
    function pendList(){
        var cp = $('#pend-currPage').val()
        var q = $('#pend-srch').val()
        if(q.length == 0){
            q = 0
        }
        var mode = "daftList";
        ajaxCusLoad('#body-daft');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.daft.php",
            method:"POST",
            data:{mode:mode,q:q,cp:cp},
            success:function(data)
            {
                $('#body-pend').empty();
                $('#body-pend').append(data);
            }
        });
    }
    function terdList(){
        var cp = $('#terd-currPage').val()
        var q = $('#terd-srch').val()
        if(q.length == 0){
            q = 0
        }
        var mode = "terdList";
        ajaxCusLoad('#body-terd');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.terd.php",
            method:"POST",
            data:{mode:mode,q:q,cp:cp},
            success:function(data)
            {
                $('#body-terd').empty();
                $('#body-terd').append(data);
            }
        });
    }

    function ajaxCusLoad(e){
        $(e).empty()
        $(e).append('<div class="spinner">'
                        +'<div class="dot1"></div>'
                        +'<div class="dot2"></div>'
                    +'</div>');
    }
</script>

<script>
    function goto(pn,menu){
        $(menu+'-currPage').attr('value',pn);
        if(menu == '#setor'){
            setorList()
        }
        else if(menu == '#pend'){
            pendList()
        }
        else if(menu == '#terd'){
            terdList()
        }
        else if(menu == '#biaya'){
            biayaList()
        }
    }
    function cpass(){
        var cp = $('#currpass').val();
        var p1 = $('#pass1').val();
        var p2 = $('#pass2').val();
        var mode = "cp";
        if(cp.length == 0 || p1.length == 0 || p2.length == 0){
            $('.usersec-msg').append('<div style="padding:10px;background:#d44950;color:#fff">Isi Semua Kolom!</div>');
            setTimeout(function(){
                $(".usersec-msg").empty();
            },3000);  
        }
        else if(p1 != p2){
            $('.usersec-msg').append('<div style="padding:10px;background:#d44950;color:#fff">Password Tidak Sama, Ulangi lagi!</div>');
            setTimeout(function(){
                $(".usersec-msg").empty();
            },3000);
        }
        else{
            $('.btn-daftar').css('display','none');
            $('.btn-daftar.dissabled').css('display','block');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.cp.php",
                method:"POST",
                data:{mode:mode,cp:cp,p1:p1},
                success:function(data)
                {
                    $('.usersec-msg').append(data);
                    setTimeout(function(){
                        $(".usersec-msg").empty();
                    },1000);   
                    $('.btn-daftar').css('display','block');
                    $('.btn-daftar.dissabled').css('display','none');
                }
            });
        }
        
        
    }
    function saveInfo(){
        var un = $('#uname').val();
        var un2 = $('#uname2').val();
        var e = $('#email').val();
        var e2 = $('#email2').val();
        var n = $('#nama').val();
        var nk = $('#nk').val();
        var tgl = $('#tgl').val();
        var sej = $('#sej').val();
        var alamat = $('#alamat').val();
        var mode = "save";
        if(un.length == 0 || e.length == 0 || n.length == 0) {
            $('.userinfo-msg').append('<div style="padding:10px;background:#d44950;color:#fff">Isi Semua Kolom!</div>');
            setTimeout(function(){
                $(".userinfo-msg").empty();
            },3000);  
        }
        else {
            $('.btn-daftar').css('display','none');
            $('.btn-daftar.dissabled').css('display','block');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.upinfo.php",
                method:"POST",
                data:{mode:mode,e:e,e2:e2,n:n,un:un,un2:un2,nk:nk,tgl:tgl,sej:sej,alamat:alamat},
                success:function(data)
                {
                    $('.userinfo-msg').append(data);
                    setTimeout(function(){
                        $(".userinfo-msg").empty();
                    },1000);   
                    $('.btn-daftar').css('display','block');
                    $('.btn-daftar.dissabled').css('display','none');
                }
            });
        }
    }
</script>