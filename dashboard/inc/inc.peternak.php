<style>
    .page-item.active .page-link{
        background-color:#019961;
        border-color:#019961;
        color:#fff !important;
    }
</style>
<div class="container" style="max-width: 1200px;">
    <div class="card card-nb p-3" style="text-align: center;">
        <a href="<?php echo BASE_URL?>"><img src="<?php echo BASE_URL?>ass/img/main/logo.png" style="width:200px;margin:0 auto" alt=""></a>
    </div>
    <div class="row">
        <div class="col-sm-3" style="padding:0">
            <div class="card m-3 card-nb sidenav" style="position: -webkit-sticky;position: sticky;top: 20px;">
                <ul>
                    <li id="nav-info" onclick="nav('info')" class="active"><i class="fas fa-user-alt"></i>INFO AKUN</li>
                    <li id="nav-sec" onclick="nav('sec')"><i class="fas fa-lock"></i>KEAMANAN</li>
                    <li id="nav-ternak" onclick="nav('ternak')"><i class="fas fa-horse-head"></i>TERNAK</li>
                    <li id="nav-stats" onclick="nav('stats')"><i class="fas fa-chart-line"></i>SETORAN KOPERASI</li>
                    <li id="nav-invoice" onclick="nav('invoice')"><i class="fas fa-receipt"></i>INVOICE</li>
                    <a href="<?php echo BASE_URL?>logout.php"><li><i class="fas fa-sign-out-alt"></i>LOGOUT</li></a>
                </ul>
            </div>
            <div class="card-nb m-3 p-3" style="position:sticky;top:350px;">
            <?php
                $id = $_SESSION['user']['id_user'];
                $sql = mysqli_query($conn,"SELECT * FROM peternak where id_user = '$id'");
                $data = mysqli_fetch_assoc($sql);
                $id_k= $data['id_kop'];
                if($data['id_kop'] && $data['kop_stat']==1){
                    $sql = mysqli_query($conn,"SELECT nama_kp FROM peternak inner join koperasi on id_kop = id_koperasi where peternak.id_user='$id'");
                    $dataK = mysqli_fetch_assoc($sql);
                    ?>
                        <div class="stat-wrap">
                            <h5 id="msg-stat">Anda Terdaftar di <?php echo $dataK['nama_kp'];?></h5>
                            <div>Status : <div class="stat-kop">AKTIF</div></div>
                        </div>
                    <?php
                }elseif($data['id_kop'] && $data['kop_stat']==0){
                        $sql = mysqli_query($conn,"SELECT nama_kp FROM peternak inner join koperasi on id_kop = id_koperasi where peternak.id_user='$id'");
                        $dataK = mysqli_fetch_assoc($sql);
                    ?>
                    <div class="stat-wrap">
                        <h5 id="msg-stat">Anda Terdaftar di <?php echo $dataK['nama_kp'];?></h5>
                        <div>Status : <div class="stat-kop">TIDAK AKTIF</div></div>
                        <p style="font-size: 8pt;">Mohon Tunggu Aktivasi Admin Koperasi</p>
                        <div class="btn-chat" id="btn-daftarKop" onclick="batalKop()">Batal Daftar <i class="fas fa-times"></i></div>
                        <div class="msg-load"></div>
                    </div>
                    <?php
                }else{ ?>
                <div class="stat-wrap">
                    <h5 id="msg-stat">Anda Belum Terdaftar Di Koperasi</h5>
                    <div class="btn-chat" id="btn-daftarKop" onclick="daftarKopMod()">Daftar Koperasi</div>
                    <div class="msg-load"></div>
                </div>
                <?php
                }
            ?>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="card-nb body-content mt-3">
                <div id="isi-info" class="active">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.infoakun.php');?>
                </div>
                <div id="isi-sec">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.secur.php');?>
                </div>
                <div id="isi-ternak">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.ternak.php');?>
                </div>
                <div id="isi-stats">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.stats.php');?>
                </div>
                <div id="isi-invoice">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.invoicept.php');?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="img-mod">
  <span id="img-close" onclick="closeImg()">&times;</span>
  <img class="" id="img-mod-src">
</div>

<div class="mod-kop" style="display:none">
    <div class="mod-kop-body card-nb p-3">
        <div class="close">&times;</div>
        <h3 class="mb-2 pt-2 pb-2" style="border-bottom:1pt solid #dcdcdc">Daftar Koperasi</h3>
        <div class="kop-list">
            
        </div>
        <div id="daf-kop-loader">
            <div class="spinner" style="position: absolute;top:0;left:0;right:0;">
                <div class="dot1"></div>
                <div class="dot2"></div>
            </div>
        </div>
    </div>
</div>
<?php 
    include(INC_DIR.'footer.php');
?>
<script>
    function nav(menu){
        $('.sidenav li').removeClass('active');
        $('#nav-'+menu).addClass('active')
        $('.body-content>div').removeClass('active')
        $('#isi-'+menu).addClass('active')
    }
</script>
<script>
    $(document).ready(function(){
        ternakList();
        setorList();
        lastSeen();
        setInterval(function(){
            lastSeen()
        }, 50000);
        $('#inv-form').on('submit',function(e){
            e.preventDefault();
            ajaxCusLoad('#body-invoice');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.inv.php",
                method:"POST",
                data:$("#inv-form").serialize(),
                success:function(data)
                {
                    $("#body-invoice").empty().append(data);
                }
            })
        });
    })
    $(".close").click(function(){
        $(".modternak-konten").empty();
        $(".mod-ternak").css('display','none');
    })
    $("#add-ternak").click(function(){
        var mode = 'showModAdd';
        $('#ternak-loader').css('display','block');
        $(".mod-ternak").css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.ternak.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
                $('#ternak-loader').css('display','none');
                $('.modternak-konten').append(data);
            }
        })
    })
    function edit(id){
        var mode = 'showModEdit';
        $('#ternak-loader').css('display','block');
        $(".mod-ternak").css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.ternak.php",
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
        $('.btn-yes').attr("onclick","initDel("+id+")");
    }
    function initDel(id){
        var mode = 'initDel';
        closePopup();
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.ternak.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                ternakList();
            }
        })
    }

    function lastSeen(){
        var mode = "ls";
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.lastseen.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
            }
        });
    }

    function closePopup(){
        $('.popup').css('display','none')
        $('#pop-msg').empty()
        $('.btn-yes').prop('onclick','');
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
        var pend = $('#pend').val();
        var thn = $('#thn').val();
        var ttl = $('#ttl').val();
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
                data:{mode:mode,e:e,e2:e2,n:n,un2:un2,un:un,pend:pend,thn:thn,ttl:ttl},
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
    function srch(){
        if($('#ternak-srch').length){
            $('#ternak-currPage').attr('value',1)
            ternakList();
            $('#ternak-srch-cncl').css('display','flex')
        }
    }
    function clearSrch(){
        $('#ternak-srch').prop('value','');
        $('#ternak-currPage').attr('value',1)
        ternakList();
        $('#ternak-srch-cncl').css('display','none')
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
    
    function ternakList(){
        var cp = $('#ternak-currPage').val()
        var q = $('#ternak-srch').val()
        if(q.length == 0){
            q = 0
        }
        var mode = "ternakList";
        ajaxCusLoad('#body-ternak');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.ternak.php",
            method:"POST",
            data:{mode:mode,q:q,cp:cp},
            success:function(data)
            {
                $('#body-ternak').empty();
                $('#body-ternak').append(data);
            }
        });
    }
    function setorList(){
        var cp = $('#setor-currPage').val()
        /*var q = $('#setor-srch').val()
        if(q.length == 0){
            q = 0
        }*/
        var mode = "setorList";
        ajaxCusLoad('#body-setor');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.ternak.php",
            method:"POST",
            data:{mode:mode,cp:cp},
            success:function(data)
            {
                $('#body-setor').empty();
                $('#body-setor').append(data);
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
    function showImg(e){
        $('#img-mod').css('display','block');
        $('#img-mod-src').attr("src",$(e).attr("src"));
    }
    function closeImg() { 
        $('#img-mod').css('display','none');
    }
</script>

<script>
    function goto(pn,menu){
        $(menu+'-currPage').attr('value',pn);
        if(menu == '#ternak'){
            ternakList()
        }
        else if(menu == '#setor'){
            setorList()
        }
    }
    function daftarKopMod(){
        var mode = 'dafKopMod';
        $('#daf-kop-loader').show();
        $('.msg-load').append('<i class="fas fa-spinner fa-spin"></i>Please Wait..');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.ternak.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
                $('.msg-load').empty();
                $('#daf-kop-loader').hide();
                $('.mod-kop').css('display','block');
                $('.kop-list').append(data);
            },error:function(){
                $('.msg-load').append('<i class="fas fa-Times"></i>Gagal, Coba Lagi..')
            }
        });

    }
    function daftarInit(id){
        var mode = "daftarInit";
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.ternak.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('#daf-kop-loader').hide();
                $('.mod-kop').css('display','none');
                $('.stat-wrap').empty()
                $('.stat-wrap').append(data)
                $('.kop-list').empty();
            },error:function(){
                $('#daf-kop-loader').hide();
            }
        });
    }
    function batalKop(){
        var mode = "batalKop";
        $('.msg-load').append('<i class="fas fa-spinner fa-spin"></i>Please Wait..');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.ternak.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
                $('.msg-load').empty();
                $('.stat-wrap').empty()
                $('.stat-wrap').append(data)
            },error:function(){
                $('.msg-load').append('<i class="fas fa-spinner fa-spin"></i>Gagal, Coba Lagi..');
            }
        });
    }

</script>
