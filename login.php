<?php 
    require_once('./config.php');
?>
<?php
    if(isset($_SESSION['user'])){
        if($_SESSION['user']['role']=='admin'){
            $header = 'admin';
        }else{
            $header = 'dashboard';	
        }header('location: ' . BASE_URL . $header);
    }
    $errors = array();
    if(isset($_POST['login'])){
        $uname = esc($_POST['uname']);
        $pass = md5(esc($_POST['pass1']));
        $sql = mysqli_query($conn,"SELECT * FROM user WHERE uname = '$uname' and pass = '$pass'");
        $data = mysqli_fetch_assoc($sql);
        if($data){
            $sql = mysqli_query($conn,"SELECT * FROM user WHERE uname = '$uname' and pass = '$pass' and status = '1'");
            $data = mysqli_fetch_assoc($sql);
            if($data){
                $_SESSION['user'] = getUserById($data['id_user']); 
                $_SESSION['message'] = "You are now logged in";
                if(isset($_SESSION['user'])){
                    if($_SESSION['user']['role']=='admin'){
                        $header = 'admin';
                    }else{
                        $header = 'dashboard';	
                    }header('location: ' . BASE_URL . $header);
                }
            }else{
                array_push($errors,'<div style="padding:10px;background:#d44950;color:#fff">Akun anda belum dikonfirmasi oleh admin, mohon tunggu beberapa saat nanti..</div>');
            }
        }else{
            array_push($errors,'<div style="padding:10px;background:#d44950;color:#fff">Username atau password salah</div>');
        }
    }
    function getUserById($id){
        global $conn;
        $sql = "SELECT * FROM user WHERE id_user=$id LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        return $user; 
    }
    function esc($value){
        // bring the global db connect object into function
        global $conn;
        $val = trim($value);
        $val = mysqli_real_escape_string($conn, $value);
        return $val;
    }	
?>
<?php
    include(INC_DIR.'header.php');
?>
<style>
    .btn-daftar{
        width: 100%;
        background: linear-gradient(90deg, rgba(1,153,97,1) 0%, rgba(181,214,83,1) 61%);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 10px;
    }
    form{
        font-size:10pt;
    }
    input{
        font-size:10pt;
    }
</style>
<div class="container pt-5" style="max-width:550px">
    <div class="card card-nb p-5">
        <div style="width:100%;border-bottom:solid 3pt #252525;text-align:center" class="pb-3 mb-3">
            <a href="<?php echo BASE_URL?>"><img src="<?php echo BASE_URL?>ass/img/main/logo.png" style="width:200px;" alt=""></a>
        </div>
        <h3>LOGIN</h3>
        <?php 
        if(!empty($errors)){ 
            ?>
            <?php 
            foreach($errors as $er){
                echo $er;
            } 
            ?>
            
            <?php
        } 
        ?>
        <form action="" method="post">  
            <div class="form-group">
                <label for="UserName">Username</label>
                <input value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : '' ?>" name="uname" id="UserName" type="text" class="form-control" placeholder="Masukan Username" minlength="6" maxlength="10" required>
            </div>
            <div class="form-group">
                <label for="pass1">Password</label>
                <input name="pass1" id="pass1" type="password" class="form-control" placeholder="Masukan Password" required>
            </div>
            <button class="btn-daftar" name="login">LOGIN</button>
        </form>
        <div class="mt-2">Belum punya akun? <a href="<?php echo BASE_URL?>signup.php">Daftar Akun</a></div>
    </div>
</div>

<?php 
    include(INC_DIR.'footer.php');
?>
<script>
    $("input#UserName").on({
        keydown: function(e) {
            if (e.which === 32)
            return false;
        },
        change: function() {
            this.value = this.value.replace(/\s/g, "");
        }
    });
</script>

</body>
</html>