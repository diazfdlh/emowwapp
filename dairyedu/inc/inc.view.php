<?php
    $id = $_GET['view'];
    $sql = mysqli_query($conn,"SELECT * FROM artikel inner join user on artikel.id_user=user.id_user where id_a = '$id' limit 1");
    $data = mysqli_fetch_assoc($sql);
?>

<div class="container" style="max-width: 1200px;padding-top:100px;">
    <div class="row">
        <div class="col-sm-8 p-2">
            <div class="card-nb p-3">
                <div class="thumb-post" style="
                    background-image: url('<?php echo BASE_URL?>ass/img/du/<?php echo $data['img']?>');
                    background-position: center;
                    background-position-y: top;
                    background-size: cover;
                    height:200px;
                    width:100%;
                "></div>
                <h1 style="padding-bottom: 10px;border-bottom:2pt solid #dcdcdc;"><?php echo $data['judul'];?></h1>
                <div class="post-info" style="color: #999;">
                    <i class="fas fa-user-alt pr-2"></i> <?php echo $data['nama']?>
                    <i class="fas fa-clock pl-2 pr-2"></i> <?php echo substr($data['created'],0,10)?>
                </div>
                <p class="mt-2 mb-2"><?php echo $data['isi']?></p>
                
                <h4>Berikut File Edukasinya yang dapat di Download: </h4>
                <a href="<?php echo BASE_URL?>ass/dufile/<?php echo $data['file']?>">
                <div class="btn-chat p-3" style="text-align: center;width:100%;font-size:12pt;">
                    Download : <?php echo $data['file'];?>
                </div>
                </a>
            </div>
        </div>
        <div class="col-sm-4 p-2">
            <div class="popular-post">
                <h5 style="font-weight:600;border-bottom:3pt solid #B5D653;padding:10px 0;">Popular DairyEdu</h5>
                <?php 
                    $sql = mysqli_query($conn,"SELECT * FROM artikel order by view desc limit 5");
                    $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                    foreach($row as $r){
                ?>
                <div class="card card-nb post-hv mt-2 mb-2">
                    <a href="/dairyedu/?view=<?php echo $r['id_a']; ?>">
                        <div class="row">
                            <div class="col-4 thumb-post" style="
                                background-image: url('<?php echo BASE_URL?>ass/img/du/<?php echo $r['img']?>');
                                background-position: center;
                                background-position-y: top;
                                background-size: cover;
                                height:100px;
                            "></div>
                            <h5 class="col-8 p-3"><?php echo $r['judul']?></h5>
                        </div>
                    </a>
                </div>
                    <?php } ?>
            </div>
        </div>
    </div>

</div>
<?php
    $nview = $data['view']+1;
    $sql = mysqli_query($conn,"UPDATE artikel set view='$nview' where id_a='$id'");
?>