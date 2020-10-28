<?php
    require_once('../config.php');
?>

<?php

if(isset($_POST["image"]))
{
	$data = $_POST["image"];
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);

    $imgname = $_SESSION['user']['id_user'].'.png';
    $img = $_SESSION['user']['id_user'];
    $id = $_SESSION['user']['id_user'];
    $location = ROOT_PATH.'/ass/img/dp/'.$imgname;
    file_put_contents($location, $data);
    $sql = mysqli_query($conn,"UPDATE user set dp='$img' where id_user='$id'");
    $_SESSION['user']['dp'] = $img;
	echo DP_DIR.$imgname;

}

?>