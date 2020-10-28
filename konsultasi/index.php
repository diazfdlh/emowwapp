<?php 
    require_once('../config.php');
    include(INC_DIR.'header.php');
    include(INC_DIR.'nav.php');
?>
<input type="text" id="currOpCh" value="0" hidden>
<input type="text" id="chStat" value="0" hidden>
<div class="container" style="padding-top:100px;min-height:500px">
    <div class="row">
        <div class="col-sm-4" id="kiri" style="position: relative;padding:0;">
            <div id="kiri-body">
                
            </div>
            <div class="kiri-load" style="display: none;">
                <div class="overlay"></div>
                <div class="spinner" style="width:40px;height:40px;margin-top:200px">
                    <div class="dot1"></div>
                    <div class="dot2"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-8" id="kanan">
            <div id="alert-avail"><h5>Maaf Konsultan sedang tidak tersedia, Mohon pilih konsultan lainnya</h5></div>
            <div class="row">
                <div id="list-back" onclick="backList()" class="col-1" style="display: none;">
                    <div class="chat-btn">
                        <i class="fas fa-arrow-left"></i>
                    </div>
                </div>
                <div id="srch-wrap" class="col-11">
                    <input type="text" placeholder="Cari Penyuluh atau Inseminator" class="card-nb pl-4" id="srch">
                </div>
                <div class="col-1">
                    <div class="chat-btn" onclick="srch()">
                        <i class="fas fa-search"></i>
                    </div>
                </div>
            </div>
            <input id="filter" type="text" value="all" hidden>
            <div id="fil-wrap" class="row" style="width: 500px;margin: 30px auto">
                <div class="col-4">
                    <div id="all" onclick="filter('all')" class="kat-btn active">
                        Semua
                    </div>
                </div>
                <div class="col-4">
                    <div id="p" onclick="filter('p')" class="kat-btn">
                        Penyuluh
                    </div>
                </div>
                <div class="col-4">
                    <div id="r" onclick="filter('r')" class="kat-btn">
                        Reproduksi
                    </div>
                </div>
            </div>
            <div class="srch-msg" style="text-align: center;"></div>
            <div class="kanan-body">
                
            </div>
            <div class="kanan-load" style="display: none;">
                <div class="spinner" style="width:40px;height:40px;margin-top:200px">
                    <div class="dot1"></div>
                    <div class="dot2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="img-mod">
  <span id="img-close" onclick="closeImg()">&times;</span>
  <img class="" id="img-mod-src">
</div>
<?php 
    include(INC_DIR.'publikfoot.php');
    include(INC_DIR.'footer.php');
?>
<script>
    $(document).ready(function(){
        listAhli();
        listChat();
        setInterval(function(){
            var mode = "cek";
            //var lcid = $('#lastNewCh').val();
            var opch = $('#currOpCh').val();
            console.log(opch)
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
                method:"POST",
                dataType : "json",
                data:{mode:mode,opch:opch},
                success:function(data)
                {
                    console.log(data.nm+' '+data.nmc)
                    if(data.nm && opch == 0){
                        listChat()
                    }
                    if(data.nmc && opch != 0){
                        rec(opch);
                    }
                }
            });
        }, 5000);
        setInterval(function(){
            var opch = $('#currOpCh').val();
            if(opch != 0){ 
                cek(opch)
            }
        }, 5000);
        setInterval(function(){
            lastSeen()
        }, 50000);
        setInterval(function(){
            $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.ahlireloader.php",
            method:"POST",
            success:function(data)
            {
                backlist()
            },error:function(data){
            }
        });
        }, 50000);
    })
    function cek(id){
        var mode = 'cek2';
        var stat = $('#chStat').val();
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                if(data==1){
                    setSeen()
                }
                else if(data==2 && stat==1){
                    viewChat($('#currOpCh').val());
                }
            }
        });
    }
    function setSeen(){
        $('.chat-sent .isi-detail:not(.seen)').prepend('seen ');
        
        $('.chat-sent .isi-detail:not(.seen)').addClass('seen');
    }
    function showImg(e){
        $('#img-mod').css('display','block');
        $('#img-mod-src').attr("src",$(e).attr("src"));
    }
    function closeImg() { 
        $('#img-mod').css('display','none');
    }
    function filter(e){
        $('.kat-btn').removeClass('active');
        $('#'+e).addClass('active');
        $('#filter').attr('value',e);
        listAhli();
    }
    function backList(){
        $('#srch').prop('value','');
        $('#list-back').css('display','none');
        $('#srch-wrap').removeClass('col-10').addClass('col-11');
        listAhli();
        lastSeen();
    }
    function backProf(){
        //$('#fil-wrap').css('display','flex');
        listAhli();
    }
    function srch(){
        if($('#srch').val()){
            $('#list-back').css('display','flex');
            $('#srch-wrap').removeClass('col-11').addClass('col-10');
            listAhli();
        }
    }
    function listAhli(){
        var q = $('#srch').val();
        var fil = $('#filter').val();
        if(q.length == 0){
            q = 0
        }
        var mode = "ahliList";
        $('.kanan-load').css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
            method:"POST",
            data:{mode:mode,q:q,fil:fil},
            success:function(data)
            {
                $('.kanan-load').css('display','none');
                $('.srch-msg').empty();
                if(q){
                    $('.srch-msg').append('Hasil Pencarian dari "'+q+'" :');
                }
                $('.kanan-body').empty();
                $('.kanan-body').append(data);
            }
        });
    }

    function listChat(){
        var mode = "chatList";
        $('.kiri-load').css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
            method:"POST",
            data:{mode:mode},
            success:function(data)
            {
                $('.kiri-load').css('display','none');
                $('#kiri-body').empty();
                $('#kiri-body').append(data);
            }
        });
    }

    function openChat(id){
        var mode = "oc";
        $('.kiri-load').css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('.kiri-load').css('display','none');
                if(data != 0){
                    viewChat(parseInt(data))
                }else{
                    $('#alert-avail').css('display','block');
                    setTimeout(function(){
                        $('#alert-avail').css('display','none');
                    }, 5000)
                    listAhli()
                }
            }
        });
    }
    function backlistChat(){
        $('#currOpCh').attr('value','0');
        $('#chStat').attr('value','0');
        listChat();
    }
    function viewChat(id,stat){
        var mode = "ocr";
        $('.kiri-load').css('display','block');
        $('#currOpCh').attr('value',id);
        $('#chStat').attr('value',stat);
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('.kiri-load').css('display','none');
                $('#kiri-body').empty();
                $('#kiri-body').append(data);
                $('.chat-body').stop().animate({ scrollTop: $('.chat-body')[0].scrollHeight}, 1000);
            }
        });
    }
    function viewAhli(id){
        var mode = "vA";
        $('.kanan-load').css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                //$('#fil-wrap').css('display','none');
                $('.kanan-load').css('display','none');
                $('.kanan-body').empty();
                $('.kanan-body').append(data);
            }
        });
    }

    function rating(n){

    }
    

    /*$(".chat-body").on('scroll', function(){
        scrolled=true;
    });*/


    function send(id){
        var mode='send';
        var isi = $('#msg-content').text();
        if(isi){
            $('.kiri-load').css('display','block');
            $.ajax({
                url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
                method:"POST",
                data:{mode:mode,id:id,isi:isi},
                success:function(data)
                {
                    $('.kiri-load').css('display','none');
                    $('.chat-body').append(data);
                    var isi = $('#msg-content').empty();
                    $('.chat-body').stop().animate({ scrollTop: $('.chat-body')[0].scrollHeight}, 1000);
                }
            });
        }
        

    }
    function rec(id){
        var mode='rec';
        $('.kiri-load').css('display','block');
        $('#notif-msg').remove();
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.kons.php",
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
</script>