<?php 
    require_once('../config.php');
    include(INC_DIR.'header.php');
    if(!isset($_SESSION['user'])){
        header('location: ' . BASE_URL );
    }
?>
<style>
    .page-item.active .page-link{
        background-color:#019961;
        border-color:#019961;
        color:#fff !important;
    }
</style>
<div class="container" style="max-width: 1300px;">
    <div class="card card-nb p-3">
        <img src="<?php echo BASE_URL?>ass/img/main/logo.png" style="width:200px;margin:0 auto" alt="">
    </div>
    <div class="row">
        <div class="col-sm-3" style="padding:0">
            <div class="card m-3 card-nb sidenav" style="position: -webkit-sticky;position: sticky;top: 0;">
                <ul>
                    <li id="nav-info" onclick="adminNav('info')" class="active"><i class="fas fa-user-alt"></i>INFO AKUN</li>
                    <li id="nav-sec" onclick="adminNav('sec')"><i class="fas fa-lock"></i>KEAMANAN</li>
                    <li id="nav-akt-us" onclick="adminNav('akt-us')"><i class="fas fa-user-plus"></i>AKTIVASI USER</li>
                    <li id="nav-man-us" onclick="adminNav('man-us')"><i class="fas fa-users"></i>MANAJEMEN USER</li>
                    <a href="<?php echo BASE_URL?>logout.php"><li><i class="fas fa-sign-out-alt"></i>LOGOUT</li></a>
                </ul>
            </div>
        </div>
        <div class="col-sm-9 py-3">
            <div class="card-nb p-3 body-content">
                <div id="isi-info" class="active">
                    <?php include(ROOT_PATH.'/admin/inc/inc.infoakun.php');?>
                </div>
                <div id="isi-sec">
                    <?php include(ROOT_PATH.'/admin/inc/inc.secur.php');?>
                </div>
                <div id="isi-akt-us">
                    <?php include(ROOT_PATH.'/admin/inc/inc.useract.php');?>
                </div>
                <div id="isi-man-us">
                    <?php include(ROOT_PATH.'/admin/inc/inc.usermanaj.php');?>
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
    function adminNav(menu){
        $('.sidenav li').removeClass('active');
        $('#nav-'+menu).addClass('active')
        $('.body-content>div').removeClass('active')
        $('#isi-'+menu).addClass('active')
    }
</script>

<script>
    $(document).ready(function(){
        $image_crop = $('#crop-body').croppie({
            enableExif: true,
            viewport: {
                width:200,
                height:200,
                type:'circle' //square
            },
            boundary:{
                width:300,
                height:300
            }
        });
    })
    $('#dp-file').on('change',function(){
        console.log('hm')
        var reader = new FileReader();
        reader.onload = function (event) {
        $image_crop.croppie('bind', {
            url: event.target.result
        }).then(function(){
            console.log('jQuery bind complete');
        });
        }
        reader.readAsDataURL(this.files[0]);
        $('#crop-mod').css('display','block');
    })
    $('#crop-close').click(function(){
        $('#crop-mod').css('display','none');
    })
    $('#apply-img').click(function(event){
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(response){
        $.ajax({
            url:"<?php echo BASE_URL?>ajax/ajax.upload.php",
            type: "POST",
            data:{"image": response},
            success:function(data)
            {
                $('#crop-mod').css('display','none');
                $('#dp').attr('src',data);
            }
        });
        })
    })
</script>

<script>
    
    <?php if(isset($_GET['page'])){?>    
        $(document).ready(function(){
            <?php if($_GET['page']=='users'){?>
            adminNav('man-us');
            <?php }?>
        })
    <?php }?>
    $(document).ready(function(){
        useractList()
        usermanajList()
    })
    function srch(){
        if($('#useract-srch').length){
            $('#useract-currPage').attr('value',1)
            useractList();
            $('#useract-srch-cncl').css('display','flex')
        }
    }
    function clearSrch(){
        $('#useract-srch').prop('value','');
        $('#useract-currPage').attr('value',1)
        useractList();
        $('#useract-srch-cncl').css('display','none')
    }
    function srchMU(){
        if($('#usermanaj-srch').length){
            $('#usermanaj-currPage').attr('value',1)
            usermanajList();
            $('#usermanaj-srch-cncl').css('display','flex')
        }
    }
    function clearSrchMU(){
        $('#usermanaj-srch').prop('value','');
        $('#usermanaj-currPage').attr('value',1)
        usermanajList();
        $('#usermanaj-srch-cncl').css('display','none')
    }

    function closePopup(){
        $('.popup').css('display','none')
        $('#pop-msg').empty()
        $('.btn-yes').prop('onclick','');
    }

    function userAct(id,a,nama){
        if(a==1){
            var msg = 'Aktivasi '+nama+'?';
            openPop(msg,'userActConf',a,id);
        }
        else if(a==0){
            var msg = 'Tolak & Hapus '+nama+'?';
            openPop(msg,'userActConf',a,id);
        }
    }
    function openPop(msg,func,prm,id){
        console.log(msg)
        $('.popup').css('display','block')
        $('#pop-msg').append(msg)
        $('.btn-yes').attr("onclick",func+"("+prm+","+id+")")
    }
    function userActConf(a,id){
        var mode = "userAct";
        closePopup();
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.admin.php",
            method:"POST",
            data:{mode:mode,a:a,id:id},
            success:function(data)
            {
                $('.useract-msg').append(data);
                setTimeout(function(){
                    $(".useract-msg").empty();
                },1000);
                $('#useract-row-'+id).remove();
                usermanajList()
            }
        });
    }
    function ban(a,id){
        var mode = "ban";
        closePopup();
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.admin.php",
            method:"POST",
            data:{mode:mode,id:id},
            success:function(data)
            {
                $('.usermanaj-msg').append(data);
                setTimeout(function(){
                    $(".usermanaj-msg").empty();
                },1000);
                $('#usermanaj-row-'+id).remove();
                useractList()
            }
        });
    }
    function cpass(){
        var id = <?php echo $_SESSION['user']['id_user']?>;
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
                url:"<?php echo BASE_URL?>/ajax/ajax.admin.php",
                method:"POST",
                data:{mode:mode,id:id,cp:cp,p1:p1},
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
        var e = $('#email').val();
        var n = $('#nama').val();
        var id = '<?php echo $_SESSION['user']['id_user'];?>';
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
                url:"<?php echo BASE_URL?>/ajax/ajax.admin.php",
                method:"POST",
                data:{mode:mode,e:e,n:n,un:un,id:id},
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

    function useractList(){
        var cp = $('#useract-currPage').val()
        var q = $('#useract-srch').val()
        if(q.length == 0){
            q = 0
        }
        var mode = "useractList";
        ajaxCusLoad('#body-useract');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.admin.php",
            method:"POST",
            data:{mode:mode,q:q,cp:cp},
            success:function(data)
            {
                $('#body-useract').empty();
                $('#body-useract').append(data);
            }
        });
    }
    function usermanajList(){
        var cp = $('#usermanaj-currPage').val()
        var q = $('#usermanaj-srch').val()
        if(q.length == 0){
            q = 0
        }
        var mode = "usermanajList";
        ajaxCusLoad('#body-usermanaj');
        $.ajax({
            url:"<?php echo BASE_URL?>/ajax/ajax.admin.php",
            method:"POST",
            data:{mode:mode,q:q,cp:cp},
            success:function(data)
            {
                $('#body-usermanaj').empty();
                $('#body-usermanaj').append(data);
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
        if(menu == '#useract'){
            useractList()
        }
        else if(menu == '#usermanaj'){
            usermanajList()
        }
    }
</script>
</body>
</html>