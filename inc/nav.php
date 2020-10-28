 
<nav>
    <div class="container" style="display: flex;align-items:center">
        <div class="logo">
            <a href="<?php echo BASE_URL?>"><img src="<?php echo BASE_URL?>ass/img/main/logo.png" alt=""></a>
        </div>
        <ul>
            <a href="<?php echo BASE_URL?>konsultasi"><li>Konsultasi</li></a>
            <a href="<?php echo BASE_URL?>dairyedu"><li>DairyEdu</li></a>
            <a href="<?php echo BASE_URL?>peternak"><li>Peternak</li></a>
            <a href="<?php echo BASE_URL?>koperasi"><li>Koperasi</li></a>
        </ul>
        <?php if(isset($_SESSION['user'])){
            if($_SESSION['user']['role']=='admin'){
            ?>
            
            <a href="<?php echo BASE_URL?>admin"><li class="btn-login" style="display:flex;align-items:center;">
                <div class="dp" style="width:40px;float:left;margin-right:10px;background:#fff;">
                    <div>
                        <img src="<?php echo DP_DIR.$_SESSION['user']['dp'].'.png'?>" alt="">
                    </div>
                </div><?php echo $_SESSION['user']['nama'];?>
            </li></a>
        <?php }else{?>
                <a href="<?php echo BASE_URL?>dashboard"><li class="btn-login" style="display:flex;align-items:center;">
                    <div class="dp" style="width:40px;float:left;margin-right:10px;background:#fff;">
                        <div>
                            <img src="<?php echo DP_DIR.$_SESSION['user']['dp'].'.png'?>" alt="">
                        </div>
                    </div><?php echo $_SESSION['user']['nama'];?>
                </li></a>
        <?php }
        }else{?>
            <a href="<?php echo BASE_URL?>login.php"><li class="btn-login">Login</li></a>
        <?php }?>
    </div>
</nav>