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
                    <li id="nav-chat" onclick="nav('chat')"><i class="fas fa-comments"></i>CHAT</li>
                    <a href="<?php echo BASE_URL?>logout.php"><li><i class="fas fa-sign-out-alt"></i>LOGOUT</li></a>
                </ul>
            </div>
            <div id="chat-act" class="card-nb m-3 p-3" style="position: -webkit-sticky;position: sticky;top: 270px;">
                <?php 
                    $id_user = $_SESSION['user']['id_user'];
                    $sql = mysqli_query($conn,"SELECT * from ahli where id_user='$id_user'");
                    $row = mysqli_fetch_assoc($sql);
                    if($row['avail']==0){
                    ?>
                <h5 style="border-bottom:1pt solid #dcdcdc">Mode Konsultasi</h5>
                <h6>Status : <span id="stat" style="color:#999;font-weight:700">TIDAK AKTIF</span></h6>
                <span id="stat-btn" class="btn-chat" onclick="actMod(1)">Aktifkan</span>
                    <?php }else{?>
                <h5 style="border-bottom:1pt solid #dcdcdc">Mode Konsultasi</h5>
                <h6>Status : <span id="stat" style="color:#019961;font-weight:700">AKTIF</span></h6>
                <span id="stat-btn" class="btn-chat" onclick="actMod(0)">NonAktifkan</span>
                    <?php }?>
                <div id="stat-msg" style="display: none;">Gagal Aktifasi, Mohon Coba Lagi</div>
                <span id="stat-load" style="display: none;">
                    <div class="spinner" style="width:20px;height:20px;margin-top:5px">
                        <div class="dot1"></div>
                        <div class="dot2"></div>
                    </div>
                </span>
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
                <div id="isi-chat">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.ahlichat.php');?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="popup">
    <div class="overlay"></div>
    <div class="pop-modal card p-3 pt-4">
        <div class="pop-close" onclick="closePopup()">
            <i class="fas fa-times"></i>
        </div>
        <h4 id="pop-msg">Akhiri Sesi Chat ini ?</h4>
        <div id="pop-act" class="row" style="margin: 0">
            <div class="col-sm btn-yes card-nb p-2" style="text-align: center;cursor:pointer;background:linear-gradient(90deg, rgba(1,153,97,1) 0%, rgba(181,214,83,1) 61%);color:#fff">YES</div>
            <div class="col-sm card-nb p-2" style="text-align: center;cursor:pointer" onclick="closePopup()">NO</div>
        </div>
    </div>
</div>

<div id="img-mod">
  <span id="img-close" onclick="closeImg()">&times;</span>
  <img class="" id="img-mod-src">
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
        chatListO();
        chatListC();
        lastSeen();
        setInterval(function(){
            var mode = "cek";
            var lcid = $('#lastNewCh').val();
            var opch = $('#currOpCh').val();
            var stat = $('#chStat').val();
            console.log(lcid+' '+opch)
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
                method:"POST",
                dataType : "json",
                data:{mode:mode,lcid:lcid,opch:opch},
                success:function(data)
                {
                    console.log(data.nc+' '+data.nm+' '+data.nmc)
                    if(data.nc){chatListO()}
                    if(data.nm){chatListO()}
                    if(data.nmc && stat==1){
                        rec(opch);
                    }
                }
            });
        }, 5000);
        setInterval(function(){
            lastSeen()
        }, 50000);
        setInterval(function(){
            var opch = $('#currOpCh').val();
            if(opch != 0){ 
                cek(opch)
            }
        }, 5000);
    })
    function actMod(s){
        var mode = 'actMod';
        $('#stat-load').css('display','block')
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
            method:"POST",
            data:{mode:mode,s:s},
            success:function(data)
            {
                $('#stat-load').css('display','none')
                if(s==1){
                    $('#stat-btn').empty().append('Nonaktifkan');
                    $('#stat-btn').attr("onclick","actMod(0)");
                    $('#stat').empty().append('AKTIF');
                    $('#stat').css('color','green');
                }else{
                    $('#stat-btn').empty().append('Aktifkan');
                    $('#stat-btn').attr("onclick","actMod(1)");
                    $('#stat').empty().append('TIDAK AKTIF');
                    $('#stat').css('color','#999');
                }
            },error:function(data){
                $('#stat-msg').css('display','block');
                setTimeout(function(){
                    $('#stat-msg').css('display','none');
                }, 5000)
            }
        });
    }
    function cek(id){
        var mode = 'cek2';
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                if(data==1){
                    setSeen()
                }
            }
        });
    }
    
    function setSeen(){
        console.log('masuk')
        $('.chat-sent .isi-detail:not(.seen)').prepend('seen ');
        $('.chat-sent .isi-detail:not(.seen)').addClass('seen');
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
        var kat = $('#kat').val();
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
                data:{mode:mode,e:e,e2:e2,n:n,un:un,un2:un2,pend:pend,thn:thn,kat:kat},
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
    function chatListO(){
        var mode = "cl";
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
                $('#opened-chat').empty();
                $('#opened-chat').append(data);
            }
        });
    }
    function chatListC(){
        var mode = "clr";
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
                $('#closed-chat').empty();
                $('#closed-chat').append(data);
            }
        });
        
    }
    function openChat(id,stat){
        $('#chStat').attr('value',stat);
        var mode = "oc";
        $('#currOpCh').attr('value',id);
        $('.kiri-load').css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('.kiri-load').css('display','none');
                $('.kanan-body').empty();
                $('.kanan-body').append(data);
                chatListO();
                $('.chat-body').stop().animate({ scrollTop: $('.chat-body')[0].scrollHeight}, 1000);
            }
        });
    }
    function closeC(id){
        $('.popup').css('display','block')
        $('.btn-yes').attr("onclick","initClose("+id+")")
    }
    function initClose(id){
        closePopup();
        var mode = "cc";
        $('#currOpCh').attr('value','0');
        $('.kiri-load').css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {   
                $('.kiri-load').css('display','none');
                $('.kanan-body').empty();
                chatListO();
                chatListC();
            }
        });
    }
    function send(id){
        var mode='send';
        var isi = $('#msg-content').text();
        if(isi){
            $('.kiri-load').css('display','block');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
                method:"POST",
                data:{mode:mode,id:id,isi:isi},
                success:function(data)
                {
                    $('.kiri-load').css('display','none');
                    $('.chat-body').append(data);
                    $('#msg-content').empty();
                    $('.chat-body').stop().animate({ scrollTop: $('.chat-body')[0].scrollHeight}, 1000);
                }
            });
        }
    }
    function rec(id){
        var mode='rec';
        console.log(id);
        $('.kiri-load').css('display','block');
        $('#notif-msg').remove();
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.chat.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('.kiri-load').css('display','none');
                $('.chat-body').append('<div id="notif-msg" style="clear:both;position: relative;text-align:center;padding:10px;"><h5 style="color:#dcdcdc;">Pesan Baru</h5><div style="position: absolute;top:20px;right:0;left:0;height:2pt;background:linear-gradient(90deg, rgba(220,220,220,1) 0%, rgba(220,220,220,1) 23%, rgba(255,255,255,0) 24%, rgba(255,255,255,0) 75%, rgba(220,220,220,1) 76%, rgba(220,220,220,1) 100%);"></div></div>');
                $('.chat-body').append(data);
                $('.chat-body').stop().animate({ scrollTop: $('.chat-body')[0].scrollHeight}, 1000);
            }
        });
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
        if(menu == '#useract'){
            useractList()
        }
        else if(menu == '#usermanaj'){
            usermanajList()
        }
    }
</script>