<?php 
	session_start();
	// connect to database
	$conn = mysqli_connect("localhost", "root", "yaz12345", "emow");

	if (!$conn) {
		die("Error connecting to database: " . mysqli_connect_error());
	}
    // define global constants
	define ('ROOT_PATH', realpath(dirname(__FILE__)).'/');
	define('BASE_URL', 'http://emowapp.com/');
	define('AJAX_DIR', 'http://emowapp.com/ajax/');
	define('DP_DIR', 'http://emowapp.com/ass/img/dp/');
	define('CHATIMG_DIR', 'http://emowapp.com/ass/img/chat/');
	define('INC_DIR',realpath(dirname(__FILE__)).'/inc/');
	date_default_timezone_set('Asia/Jakarta');
?>
