<?php 
    require_once('../config.php');
    include(INC_DIR.'header.php');
    if(!isset($_SESSION['user'])){
        header('location: ' . BASE_URL );
    }
    if($_SESSION['user']['role']=='ahli'){
        include(ROOT_PATH.'dashboard/inc/inc.ahli.php');
    }elseif($_SESSION['user']['role']=='peternak'){
        include(ROOT_PATH.'dashboard/inc/inc.peternak.php');
    }elseif($_SESSION['user']['role']=='koperasi'){
        include(ROOT_PATH.'dashboard/inc/inc.koperasi.php');
    }elseif($_SESSION['user']['role']=='deauthor'){
        include(ROOT_PATH.'dashboard/inc/inc.duauth.php');
    }elseif($_SESSION['user']['role']=='admin'){
        header('location: ' . BASE_URL.'admin' );
    }
?>
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
                d = new Date();
                $('#dp').attr('src',data+'?'+d.getTime());
            }
        });
        })
    })
</script>

</body>
</html>