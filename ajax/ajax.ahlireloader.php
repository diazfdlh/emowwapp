<?php
require_once('../config.php');

    $sql = mysqli_query($conn,"SELECT * from ahli where avail=1");
    $row = mysqli_fetch_all($sql,MYSQLI_ASSOC);
    $n = 0;
    foreach($row as $r){
        $firstTime=strtotime($r['last_seen']);
        $lastTime=strtotime(date("Y-m-d H:i:s",time()));
        $timeDiff=$lastTime-$firstTime;
        $years = abs(floor($timeDiff / 31536000));
        $days = abs(floor(($timeDiff-($years * 31536000))/86400));
        $hours = abs(floor(($timeDiff-($years * 31536000)-($days * 86400))/3600));
        $mins = abs(floor(($timeDiff-($years * 31536000)-($days * 86400)-($hours * 3600))/60));#floor($timeDiff / 60);
        if($mins > 2){
            $n +=1;
            $id_user = $r['id_user'];
            $sql = mysqli_query($conn,"UPDATE ahli set avail=0 where id_user='$id_user'");
        }
    }
    if($n){
        echo 1;
    }else{
        echo 0;
    }
?>