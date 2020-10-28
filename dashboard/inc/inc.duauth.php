<style>
    .page-item.active .page-link{
        background-color:#019961;
        border-color:#019961;
        color:#fff !important;
    }
</style>
<div class="container" style="max-width: 1200px;">
    <div class="card card-nb p-3"  style="text-align: center;">
    <a href="<?php echo BASE_URL?>"><img src="<?php echo BASE_URL?>ass/img/main/logo.png" style="width:200px;margin:0 auto" alt=""></a>
    </div>
    <div class="row">
        <div class="col-sm-3" style="padding:0">
            <div class="card m-3 card-nb sidenav" style="position: -webkit-sticky;position: sticky;top: 20px;">
                <ul>
                    <li id="nav-info" onclick="nav('info')" class="active"><i class="fas fa-user-alt"></i>INFO AKUN</li>
                    <li id="nav-sec" onclick="nav('sec')"><i class="fas fa-lock"></i>KEAMANAN</li>
                    <li id="nav-dairyedu" onclick="nav('dairyedu')"><i class="fas fa-newspaper"></i>DAIRY EDU</li>
                    <a href="<?php echo BASE_URL?>logout.php"><li><i class="fas fa-sign-out-alt"></i>LOGOUT</li></a>
                </ul>
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
                <div id="isi-dairyedu">
                    <?php include(ROOT_PATH.'/dashboard/inc/inc.dairyedu.php');?>
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
        dairyeduList()
    })
    $(".close").click(function(){
        $(".modternak-konten").empty();
        $(".mod-ternak").css('display','none');
    })
    $("#add-dairyedu").click(function(){
        var mode = 'showModAdd';
        $('#ternak-loader').css('display','block');
        $(".mod-ternak").css('display','block');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.dairyedu.php",
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
            url:"<?php echo BASE_URL?>/ajax/ajax.dairyedu.php",
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
            url:"<?php echo BASE_URL?>/ajax/ajax.dairyedu.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                dairyeduList();
            }
        })
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
                data:{mode:mode,e:e,e2:e2,n:n,un:un,un2:un2,pend:pend,thn:thn,ttl:ttl},
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
        if($('#dairyedu-srch').length){
            $('#dairyedu-currPage').attr('value',1)
            dairyeduList();
            $('#dairyedu-srch-cncl').css('display','flex')
        }
    }
    function clearSrch(){
        $('#dairyedu-srch').prop('value','');
        $('#dairyedu-currPage').attr('value',1)
        dairyeduList();
        $('#dairyedu-srch-cncl').css('display','none')
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
    
    function dairyeduList(){
        var cp = $('#dairyedu-currPage').val()
        var q = $('#dairyedu-srch').val()
        if(q.length == 0){
            q = 0
        }
        var mode = "dairyeduList";
        ajaxCusLoad('#body-dairyedu');
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.dairyedu.php",
            method:"POST",
            data:{mode:mode,q:q,cp:cp},
            success:function(data)
            {
                $('#body-dairyedu').empty();
                $('#body-dairyedu').append(data);
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
        if(menu == '#dairyedu'){
            dairyeduList()
        }
    }
</script>