<?php
    require_once('../config.php');
?>
<?php 
    
    if(isset($_POST['mode']) && $_POST['mode'] == 'ls'){
        $id = $_SESSION['user']['id_user'];
        if($_SESSION['user']['role']=='ahli'){
            $sql = mysqli_query($conn,"UPDATE ahli set last_seen = now()");
        }elseif($_SESSION['user']['role']=='peternak'){
            $sql = mysqli_query($conn,"UPDATE peternak set last_seen = now()");
        }
    }
?>