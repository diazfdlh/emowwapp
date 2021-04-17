<div class="container" style="max-width: 1200px;padding-top:100px">
    <form action="" method="get">
    <div class="row">
        <div id="srch-wrap" class="col-11">
            <input type="text" name="q" placeholder="Cari Peternak" class="card-nb pl-4" id="srch">
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
            $srch = " WHERE nama like '%$q%' ";
        }else{
            $srch = ' ';
        }
        $sql = mysqli_query($conn,"SELECT * FROM peternak inner join user on user.id_user=peternak.id_user ".$srch."order by nama");
        $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
        foreach($row as $r){
        ?>
        <div class="col-sm-3 p-2">
        <a href="<?php echo BASE_URL?>peternak/<?php echo $r['uname']; ?>">
            <div class="card card-nb post-hv">
                <div class="thumb-post card-img-top" style="
                    background:linear-gradient(45deg, rgba(1,153,97,1) 0%, rgba(181,214,83,1) 45%);
                    height:100px;
                "></div>
                <div class="dp" style="width: 100px;margin: -50px auto 0 auto;background:#fff;">
                    <div style="position: relative;cursor:pointer">
                        <img id="dp" src="<?php echo DP_DIR.$r['dp'].'.png'?>" alt="">
                    </div>
                </div>
                <div class="car-body p-3">
                    <h5 class="" style="text-align: center;margin:0;"><?php echo $r['nama']?></h5>
                    <p class="" style="text-align: center;margin:0;font-weight:300;font-size:10pt"><?php if($r['pend_pt']){echo '<i class="fas fa-graduation-cap"></i> '.$r['pend_pt'];}else{echo '-';}?></p>
                </div>
            </div>
        </a>
        </div>
    <?php } ?>
    </div>
    <?php
    if(mysqli_num_rows($sql)==0){
        echo '<h3 style="text-align:center;">Tidak ada Peternak yang anda cari</h3>';
    }
    ?>
</div>
