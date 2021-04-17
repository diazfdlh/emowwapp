<?php 
    require_once('./config.php');
    include(INC_DIR.'header.php');
    include(INC_DIR.'nav.php');
?>
<div class="container" style="padding-top:150px">
    <div class="row">
        <div class="col-sm-8">
            <div class="row main-btn" style="text-align: center;">
                <div class="col-sm card card-nb m-3 p-3">
                    <a href="<?php echo BASE_URL ?>konsultasi">
                        <img class="card-img-top" style="width: 150px;margin:auto;margin-top:-50px;" src="<?php echo BASE_URL?>ass/img/main/icon1.png" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title">Konsultasi</h4>
                            <p class="card-text">Konsultasi bersama penyuluh kami.</p>
                        </div>
                    </a>
                </div>
                <div class="col-sm card card-nb m-3 p-3">
                <a href="<?php echo BASE_URL ?>dairyedu">
                    <img class="card-img-top" style="width: 150px;margin:auto;margin-top:-50px;" src="<?php echo BASE_URL?>ass/img/main/icon2.png" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title">DairyEdu</h4>
                        <p class="card-text">Jelajah edukasi dari kami.</p>
                    </div>
                </a>
                </div>
            </div>
        </div>
        <div class="col-sm-4 popular-post">
            <h5 style="font-weight:600;border-bottom:3pt solid #B5D653;padding:10px 0;">Popular DairyEdu</h5>
            <?php 
                $sql = mysqli_query($conn,"SELECT * FROM artikel order by view desc limit 5");
                $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
                foreach($row as $r){
            ?>
            <div class="card card-nb post-hv mt-2 mb-2">
                <a href="<?php echo BASE_URL ?>dairyedu/<?php echo $r['id_a']; ?>">
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

<?php 
    include(INC_DIR.'publikfoot.php');
    include(INC_DIR.'footer.php');
?>
</body>
</html>