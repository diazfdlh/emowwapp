<?php
    require_once('../../config.php');
    include(INC_DIR.'header.php');
    if(!isset($_SESSION['user'])  && $_SESSION['user']['role']!='koperasi'){
        header('location: ' . BASE_URL.'login.php' );
    }
    function esc($unamelue){
        // bring the global db connect object into function
        global $conn;
        $unamel = trim($unamelue);
        $unamel = mysqli_real_escape_string($conn, $unamelue);
        return $unamel;
    }
    $msg ='';
    include(INC_DIR.'header.php');
?>
<script src="<?php echo BASE_URL?>ass/js/jquery-3.4.1.min.js"></script>
		<style>
			#loading{
				background: whitesmoke;
				position: absolute;
				top: 140px;
				left: 82px;
				padding: 5px 10px;
				border: 1px solid #ccc;
			}
		</style>
	</head>
	<body>
		
<div class="wrapper mt-5">

	<div class="content-wrapper">

		<section class="content">
      		<div class="container" style="max-width: 1010px;">
				<section>
					<div class="card card-nb">
						<div class="card-header">
						Import Data Pendaftaran Peternak
						</div>
						<div class="card-body">
							<a target="_blank" href="Format_Daftar.xlsx"> <button class="btn btn-primary">
								<span class="fas fa-download"></span>
								Download Template Excel
								</button>
							</a><br><br>
								<form action="" method="post" enctype="multipart/form-data">
							<div class="row">
								<div class="col-9">
									<input type="file" name="files" class="form-control pull-left">
								</div>
								<div class="col-3">
									<button type="submit" name="preview" class="btn btn-success btn-sm">
										<span class="fas fa-eye"></span> Preview
									</button>
								</div>
							</div>
							<div class="text-danger">**PENTING** Pastikan File Excel Sesuai Template diatas</div>
								</form>
						<hr>
						<!-- Buat Preview Data -->
						<?php
						if(isset($_POST['preview'])){
							$pass_file_baru = 'data.xlsx';

							if(is_file('./tmp/'.$pass_file_baru)) // Jika file tersebut ada
								unlink('tmp/'.$pass_file_baru); // Hapus file tersebut

							$ext = pathinfo($_FILES['files']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
							$tmp_file = $_FILES['files']['tmp_name'];

							// Cek apakah file yang diupload adalah file Excel 2007 (.xlsx)
							if($ext == "xlsx"){
								move_uploaded_file($tmp_file, './tmp/'.$pass_file_baru);
								require_once './PHPExcel/PHPExcel.php';

								$excelreader = new PHPExcel_Reader_Excel2007();
								$loadexcel = $excelreader->load('./tmp/'.$pass_file_baru); // Load file yang tadi diupload ke folder tmp
								$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

								// Buat sebuah tag form untuk proses import data ke database
								echo "<form method='post' action=''>";

								echo "<div class='alert alert-danger' id='kosong' style='display:none;'>
								Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
								</div>";

								echo "<table class='table table-bordered'>
								<tr>
									<th colspan='5' class='text-center' style='color:#000'>Preview Data</th>
								</tr>
								<tr>
									<th style='color:#000'>Username</th>
									<th style='color:#000'>Password</th>
									<th style='color:#000'>Email</th>
									<th style='color:#000'>Nama Lengkap</th>
									<th style='color:#000'>Role</th>
								</tr>";

								$numrow = 1;
								$kosong = 0;
								foreach($sheet as $row){ 
									$uname = $row['A']; 
									$pass = $row['B']; 
									$email = $row['C'];
									$nama = $row['D'];
									$role = $row['E'];
									
									if($uname == "" && $pass == "" && $email == "" && $nama == "" && $role == "")
										continue; 

									if($numrow > 1){
										// Validasi apakah semua data telah diisi
										$uname_td = ( ! empty($uname))? "" : " style='background: #E07171;'"; 
										$pass_td = ( ! empty($pass))? "" : " style='background: #E07171;'"; 
										$email_td = ( ! empty($email))? "" : " style='background: #E07171;'"; 
										$nama_td = ( ! empty($nama))? "" : " style='background: #E07171;'"; 
										$role_td = ( ! empty($role))? "" : " style='background: #E07171;'";

										if($uname == "" or $pass == "" or $nama == "" or $role == ""){
											$kosong++; 
										}

										echo "<tr>";
										echo "<td".$uname_td.">".$uname."</td>";
										echo "<td".$pass_td.">".$pass."</td>";
										echo "<td".$email_td.">".$email."</td>";
										echo "<td".$nama_td.">".$nama."</td>";
										echo "<td".$role_td.">".$role."</td>";
										echo "</tr>";
									}

									$numrow++; 
								}

								echo "</table>";

								if($kosong >= 1){
								?>
									<script>
									$(document).ready(function(){
										$(".card-body #jumlah_kosong").html('<?php echo $kosong; ?>');

										$(".card-body #kosong").show(); 
									});
									</script>
								<?php
								}else{ 
									echo "<hr>";

									
									echo "<button type='submit' name='import' class='btn btn-primary'><span class='fas fa-upload'></span> Submit</button>";
									echo '<a href="'.BASE_URL.'admin/users"><div class="btn btn-secondary ml-3">Kembali Ke Dashboard</div></a>';
								}

								echo "</form>";
							}else{ 
								
								echo "<div class='alert alert-danger'>
								Hanya File Excel 2007 (.xlsx) yang diperbolehkan
								</div>";
							}
						}
						else if(isset($_POST['import'])){ 
							$pass_file_baru = 'data.xlsx';
						
							require_once './PHPExcel/PHPExcel.php';
						
							$excelreader = new PHPExcel_Reader_Excel2007();
							$loadexcel = $excelreader->load('./tmp/'.$pass_file_baru); 
							$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
							
							echo "<div class='alert alert-danger' id='kosong2' style='display:none;'>
							Ada <b id='jumlah_kosong2'></b> user yang <b>tidak dapat didaftarkan</b>. hal ini terjadi jika ada username yang telah ada terdaftar.
							</div>";
							echo "<div class='alert alert-success' id='sukses' style='display:none;'>
							Berhasil Import Data Transfer
							</div>";

							echo "<table class='table table-bordered'>
								<tr>
									<th colspan='5' class='text-center' style='color:#000'>Preview Data</th>
								</tr>
								<tr>
									<th style='color:#000'>Username</th>
									<th style='color:#000'>Password</th>
									<th style='color:#000'>Email</th>
									<th style='color:#000'>Nama Lengkap</th>
									<th style='color:#000'>Role</th>
								</tr>";
							$numrow = 1;
							$kosong = 0;
							foreach($sheet as $row){
								
								$uname = $row['A']; 
								$pass = $row['B']; 
								$email = $row['C'];
								$nama = $row['D']; 
								$role = $row['E']; 
						
								
								if($uname == "" && $pass == "" && $nama == "" && $email == "" && $role == "")
									continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
						
								
								if($numrow > 1){
									$red ='';
									$sql = mysqli_query($conn,"SELECT * FROM user where uname ='$uname'");
									
									if(mysqli_num_rows($sql)){
										$kosong++; 
										$red = " style='background: #E07171;'";
										echo "<tr".$red.">";
										echo "<td>".$uname."</td>";
										echo "<td>".$pass."</td>";
										echo "<td>".$email."</td>";
										echo "<td>".$nama."</td>";
										echo "<td>".$role."</td>";
										echo "</tr>";
									}else{
										echo "<tr>";
										echo "<td>".$uname."</td>";
										echo "<td>".$pass."</td>";
										echo "<td>".$email."</td>";
										echo "<td>".$nama."</td>";
										echo "<td>".$role."</td>";
										echo "</tr>";
										// Buat query Insert
										$query = "INSERT INTO user (uname,pass,email,nama,role,status,created,dp) VALUES('".$uname."','".$pass."','".$email."','".$nama."','".$role."',1,now(),'default')";
							
										// Eksekusi $query
										mysqli_query($conn, $query);
									}

								}
						
								$numrow++; 
							}
							echo "</table>";
							echo '<a href="'.BASE_URL.'admin/users"><div class="btn btn-secondary">Kembali Ke Dashboard</div></a>';
							if($kosong >= 1){
							?>
								<script>
								$(document).ready(function(){
									
									$(".card-body #jumlah_kosong2").html('<?php echo $kosong; ?>');

									$(".card-body #kosong2").show(); 
								});
								</script>
							<?php
							}else{
							?>
								<script>
								$(document).ready(function(){
									$(".card-body #sukses").show(); 
								});
								</script>
							<?php
							}
						}else{
							echo '<a href="'.BASE_URL.'admin/users"><div class="btn btn-secondary">Kembali Ke Dashboard</div></a>';
						}

						?>
						</div>
					</div>
				</section>
			
			</div>
		</section>
	</div>
</div>
<?php 
    include(INC_DIR.'footer.php');
?>

	</body>
	
	
</html>
