<?php
    require_once('../config.php');
    $nperlist = 5;
?>

<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'dairyeduList'){
        $cp = $_POST['cp'];
        $id=$_SESSION['user']['id_user'];
        $rStart = $nperlist * ($cp - 1);
        $q = $_POST['q'];
        if($q){
            $srch = " where judul LIKE '%".$q."%' and";
        }else{
            $srch = ' Where ';
        }
        $sql = mysqli_query($conn,"SELECT * FROM artikel ".$srch." id_user='$id'  order by id_a desc LIMIT ".$rStart.",".$nperlist);
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        foreach($row as $r){
            ?>
            <div id="dairyedu-row-<?php echo $r['id_user'];?>" class="row list m-1" style="border: 1pt solid #dcdcdc;">
                <div class="col-3"><?php echo $r['judul']?></div>
                <div class="col-4"><a target="_blank" href="<?php echo BASE_URL?>ass/dufile/<?php echo $r['file']?>"><?php echo $r['file']?></a></div>
                <div class="col-3"><?php echo $r['created']?></div>
                <div class="col-2">
                    <i class="fas fa-pencil-alt" style="cursor: pointer;color:#019961;" onclick="edit(<?php echo $r['id_a'];?>)"></i>
                    <i class="fas fa-trash" style="cursor: pointer;color:#d44950;" onclick="del(<?php echo $r['id_a'];?>)"></i>
                </div>
            </div>
            <?php
        }
        $n = mysqli_num_rows($sql);
        if($n == 0){?>
            <div style="width:100%;text-align:center;">Tidak ada DairyEdu</div>
        <?php 
        }else{
            if($q){
                $srch = " where judul LIKE '%".$q."%'";
            }else{
                $srch = ' ';
            }
            $sql = mysqli_query($conn,"SELECT * FROM artikel ".$srch);
            $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
            $n = mysqli_num_rows($sql);
            $total = ceil($n/$nperlist);
            ?>
                <div id="pgn-wrap">
            <?php
            for($i=1;$i<=$total;$i++){
                ?>
                    <span onclick="goto(<?php echo $i?>,'#dairyedu')" class="card pgnum <?php if($cp == $i){echo 'active';}?>"><?php echo $i;?></span>
                <?php
            }
            ?>
                </div>
            <?php
        }
        
    }

    if(isset($_POST['mode']) && $_POST['mode'] == 'showModAdd'){
        ?>
            <h3 style="border-bottom:solid 1pt #dcdcdc;padding-bottom:10px">Tambah DairyEdu</h3>
            <form action="" id="add-form" enctype="multipart/form-data" method="post">
                <div class="row mt-2 mb-2">
                    <div class="col-4">Judul</div>
                    <div class="col-7"><input type="text" name="judul" class="form-control" placeholder="Masukan Judul Dairy Edu"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-4">Thumbnail</div>
                    <div class="col-7"><input type="file" accept="image/*" name="img" class="form-control"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-4">Deskripsi</div>
                    <div class="col-7"><textarea name="isi" id="" class="form-control" width="100%"></textarea></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-4">File</div>
                    <div class="col-7">
                    <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <input hidden name="mode" value="initAdd">
                <div class="row mt-2 mb-2">
                    <div class="col-4"></div>
                    <div class="col-7">
                        <button type="submit" name="submitAdd" class="btn-chat p-2" style="border:none;width:100%;">Tambah DairyEdu</button>
                    </div>
                </div>
            </form>
            <script> 
                $("#add-form").on('submit',function(e){
                    e.preventDefault();
                    $('#ternak-loader').css('display','block');
                    $.ajax({
                        url:"<?php echo BASE_URL?>/ajax/ajax.dairyedu.php",
                        method:"POST",
                        data:  new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success:function(data)
                        {
                            $('#ternak-loader').css('display','none');
                            console.log(data)
                            if(data!=0){
                                dairyeduList();
                                $(".msg-mod").append(data);
                                setTimeout(function(){
                                    $(".msg-mod").empty();
                                },3000)
                                setTimeout(function(){
                                    $(".modternak-konten").empty();
                                    $(".mod-ternak").css('display','none');
                                },3000)
                            }else{
                                $(".msg-mod").append('<div style="background:red;color:#fff">Gagal Tambah Dairy Edu, Coba Lagi..</div>');
                                setTimeout(function(){
                                    $(".msg-mod").empty();
                                },3000)
                            }
                        },
                        error:function(data)
                        {
                            $(".msg-mod").append('<div style="background:red;color:#fff">Gagal Tambah Dairy Edu, Coba Lagi..</div>');
                        }
                    })
                })
            </script>
        <?php
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'showModEdit'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"SELECT * FROM artikel where id_a='$id'");
        $row = mysqli_fetch_assoc($sql);
        ?>
            <h3 style="border-bottom:solid 1pt #dcdcdc;padding-bottom:10px">Tambah DairyEdu</h3>
            <form action="" id="add-form" enctype="multipart/form-data" method="post">
                <div class="row mt-2 mb-2">
                    <div class="col-4">Judul</div>
                    <div class="col-7"><input value="<?php echo $row['judul'];?>" type="text" name="judul" class="form-control" placeholder="Masukan Judul Dairy Edu"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-4">Thumbnail</div>
                    <div class="col-7"><input type="file" accept="image/*" name="img" class="form-control"></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-4">Deskripsi</div>
                    <div class="col-7"><textarea name="isi" id="" class="form-control" width="100%"><?php echo $row['isi'];?></textarea></div>
                </div>
                <div class="row mt-2 mb-2">
                    <div class="col-4">File</div>
                    <div class="col-7">
                    <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <input hidden name="mode" value="initEdit">
                <input hidden name="id" value="<?php echo $row['id_a'];?>">
                <div class="row mt-2 mb-2">
                    <div class="col-4"></div>
                    <div class="col-7">
                        <button type="submit" name="submitAdd" class="btn-chat p-2" style="border:none;width:100%;">Edit DairyEdu</button>
                    </div>
                </div>
            </form>
            <script> 
                $("#add-form").on('submit',function(e){
                    e.preventDefault();
                    $('#ternak-loader').css('display','block');
                    $.ajax({
                        url:"<?php echo BASE_URL?>/ajax/ajax.dairyedu.php",
                        method:"POST",
                        data:  new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success:function(data)
                        {
                            $('#ternak-loader').css('display','none');
                            console.log(data)
                            if(data!=0){
                                dairyeduList();
                                $(".msg-mod").append(data);
                                setTimeout(function(){
                                    $(".msg-mod").empty();
                                },3000)
                                setTimeout(function(){
                                    $(".modternak-konten").empty();
                                    $(".mod-ternak").css('display','none');
                                },3000)
                            }else{
                                $(".msg-mod").append('<div style="background:red;color:#fff">Gagal Edit Dairy Edu, Coba Lagi..</div>');
                                setTimeout(function(){
                                    $(".msg-mod").empty();
                                },3000)
                            }
                        },
                        error:function(data)
                        {
                            $(".msg-mod").append('<div style="background:red;color:#fff">Gagal Edit Dairy Edu, Coba Lagi..</div>');
                        }
                    })
                })
            </script>
        <?php
    }

?>

<?php
    if(isset($_POST['mode']) && $_POST['mode'] == 'initAdd'){
        $id = $_SESSION['user']['id_user'];
        $judul = $_POST['judul'];
        $img = $_FILES['img']['name'];
        $file = $_FILES['file']['name'];
        $isi = $_POST['isi'];
        $e = 0;
        if(empty($judul)){$e++;}
        if(empty($img)){$e++;}
        if(empty($file)){$e++;}
        if(empty($isi)){$e++;}
        if(!$e){
            $location = ROOT_PATH.'/ass/dufile/'.$file;
            move_uploaded_file($_FILES["file"]["tmp_name"], $location);
            $location = ROOT_PATH.'/ass/img/du/'.$img;
            move_uploaded_file($_FILES["img"]["tmp_name"], $location);
            $sql = mysqli_query($conn,"INSERT INTO artikel (id_user,judul,img,file,isi,created) VALUES('$id','$judul','$img','$file','$isi',now())");
            echo '<div style="background:#077703;color:#fff">Berhasil Tambah DairyEdu</div>';
        }else{
            echo 0;
        }
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'initEdit'){
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $img = $_FILES['img']['name'];
        $file = $_FILES['file']['name'];
        $isi = $_POST['isi'];
        $e = 0;
        if(empty($judul)){$e++;}
        if(empty($isi)){$e++;}
        if(empty($file)){
            $nFile = "";
        }else{
            $nFile = ",file='$file'";
            $location = ROOT_PATH.'/ass/dufile/'.$file;
            move_uploaded_file($_FILES["file"]["tmp_name"], $location);
        }
        if(empty($img)){
            $nImg = "";
        }else{
            $nImg = ",img='$img'";
            $location = ROOT_PATH.'/ass/img/du/'.$img;
            move_uploaded_file($_FILES["img"]["tmp_name"], $location);
        }
        if(!$e){
            $sql = mysqli_query($conn,"UPDATE artikel set judul='$judul'".$nImg.$nFile.",isi='$isi' where id_a='$id'");
            echo '<div style="background:#077703;color:#fff">Berhasil Edit DairyEdu</div>';
        }else{
            echo 0;
        }
    }
    if(isset($_POST['mode']) && $_POST['mode'] == 'initDel'){
        $id = $_POST['id'];
        $sql = mysqli_query($conn,"DELETE FROM artikel where id_a='$id'");
    }
?>



