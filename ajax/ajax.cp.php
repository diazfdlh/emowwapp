<?php
    require_once('../config.php');
?>

<?php
if(isset($_POST['mode']) && $_POST['mode'] == 'cp'){
    $id=$_SESSION['user']['id_user'];
    $cp=md5($_POST['cp']);
    //echo $_POST['p1'];
    $ps=md5($_POST['p1']);
    $sql = mysqli_query($conn,"SELECT * FROM user WHERE id_user = '$id' and pass = '$cp'");
    if(mysqli_num_rows($sql)){
        $sql = mysqli_query($conn,"UPDATE user set pass = '$ps' WHERE id_user='$id'");
        if($sql){echo '<div style="padding:10px;background:#019961;color:#fff">Berhasil Mengubah Password</div>';}
    }else{
        echo '<div style="padding:10px;background:#d44950;color:#fff">Password Sekarang anda salah</div>';
    }
    
}
?>