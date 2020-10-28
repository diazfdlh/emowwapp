<?php
    require_once('../config.php');
    include(INC_DIR.'header.php');
    include(INC_DIR.'nav.php');
?>

<?php
    if(isset($_GET['view']) && $_GET['view'] !=null){ 
        include(ROOT_PATH.'/dairyedu/inc/inc.view.php');
    }else{
        include(ROOT_PATH.'/dairyedu/inc/inc.index.php');
    }
?>


<?php 
    include(INC_DIR.'publikfoot.php');
    include(INC_DIR.'footer.php');
?>
</body>
</html>