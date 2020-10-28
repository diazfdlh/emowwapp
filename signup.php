<?php 
    require_once('./config.php');
    include(INC_DIR.'header.php');
?>
<?php
    $errors = array();
    function esc($value){
        // bring the global db connect object into function
        global $conn;
        $val = trim($value);
        $val = mysqli_real_escape_string($conn, $value);
        return $val;
    }	
    if(isset($_POST['daftar'])){
        $uname = esc($_POST['uname']);
        $sql = mysqli_query($conn,"SELECT * FROM user WHERE uname = '$uname'");
        if(mysqli_num_rows($sql)){
            array_push($errors,'<div style="padding:10px;background:#d44950;color:#fff">- Username sudah digunakan, coba yang lain</div>');
        }
        $email = esc($_POST['email']);
        $sql = mysqli_query($conn,"SELECT * FROM user WHERE email = '$email'");
        if(mysqli_num_rows($sql)){
            array_push($errors,'<div style="padding:10px;background:#d44950;color:#fff">- Email sudah digunakan, coba yang lain</div>');
        }
        $pass1 = esc($_POST['pass1']);
        $pass2 = esc($_POST['pass2']);
        if($pass1 != $pass2){array_push($errors,'<div style="padding:10px;background:#d44950;color:#fff">- Password tidak sama</div>');}
        if(empty($errors)){
            $pass = md5($pass1);
            $name = esc($_POST['nama']);
            $role = esc($_POST['role']);
            $created = date("Y-m-d",time());
            $sql = mysqli_query($conn,"INSERT INTO `user`(`id_user`, `uname`, `pass`, `email`, `nama`, `dp`, `role`, `status`, `created`) VALUES (null,'$uname','$pass','$email','$name','default','$role',0,now())");
            if(!$sql){
                array_push($errors,'<div style="padding:10px;background:#d44950;color:#fff">- Hubungi divisi IT anda</div>');
            }else{
                array_push($errors,'<div style="padding:10px;background:#019961;color:#fff">- Berhasil Membuat Akun, Tunggu Verifikasi dari admin secara berkala dengan melakukan <a href="./login.php" style="color:#fff;font-weight:700">LOGIN</a></div>');
            }
        }
    }
?>

<style>
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
        <h3>DAFTAR AKUN</h3>
        <?php 
        if(!empty($errors)){ 
            foreach($errors as $er){
                echo $er;
            } 
        } 
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input value="<?php echo isset($_POST['nama']) ? $_POST['nama'] : '' ?>" name="nama" id="nama" type="text" class="form-control" placeholder="Masukan Nama Lengkap" required>
            </div>    
            <div class="form-group">
                <label for="UserName">Username</label>
                <input value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : '' ?>" name="uname" id="UserName" type="text" class="form-control" placeholder="Masukan Username" minlength="6" maxlength="10" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" name="email" id="email" type="email" class="form-control" placeholder="Masukan Email" required>
            </div>
            <div class="form-group">
                <label for="pass1">Password</label>
                <input name="pass1" id="pass1" type="password" class="form-control" placeholder="Masukan Password" required>
            </div>
            <div class="form-group">
                <label for="pass2">Ulangi Password</label>
                <input name="pass2" id="pass2" type="password" class="form-control" placeholder="Ulangi Password" required>
            </div>
            <div class="form-group">
                <label for="role">Sebagai</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="" disabled selected>- Pilih -</option>
                    <option value="admin">Admin</option>
                    <option value="peternak">Peternak</option>
                    <option value="koperasi">Koperasi</option>
                    <option value="ahli">Ahli</option>
                    <option value="deauthor">DairyEdu Author</option>
                </select>
            </div>
            <button class="btn-daftar" name="daftar">DAFTAR</button>
            
        </form>
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