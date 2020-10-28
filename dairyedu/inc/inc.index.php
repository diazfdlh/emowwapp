<div class="container" style="max-width: 1200px;padding-top:100px">
    <form action="" method="get">
    <div class="row">
        <div id="srch-wrap" class="col-11">
            <input type="text" name="q" placeholder="Cari DairyEdu" class="card-nb pl-4" id="srch">
        </div>
        <div class="col-1">
            <button class="chat-btn" type="submit" style="border: none;background:#fff;">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    </form>
    <div class="row mt-3">
    <?php 
        if(isset($_GET['q'])){
            $q = $_GET['q'];
            $srch = " WHERE judul like '%$q%' ";
        }else{
            $srch = ' ';
        }
        $sql = mysqli_query($conn,"SELECT * FROM artikel".$srch."order by created desc");
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        foreach($row as $r){
        ?>
        <div class="col-sm-4 p-2">
        <a href="/dairyedu/?view=<?php echo $r['id_a']; ?>">
            <div class="card card-nb post-hv">
                <div class="thumb-post card-img-top" style="
                    background-image: url('<?php echo BASE_URL?>ass/img/du/<?php echo $r['img']?>');
                    background-position: center;
                    background-position-y: top;
                    background-size: cover;
                    height:200px;
                "></div>
                <h5 class="p-3"><?php echo $r['judul']?></h5>
            </div>
        </a>
        </div>
    <?php } ?>
    </div>
    <?php
    if(mysqli_num_rows($sql)==0){
        echo '<h3 style="text-align:center;">Tidak ada Judul yang anda cari</h3>';
    }
    ?>
</div>
