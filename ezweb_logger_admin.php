<?php

# @important You must change this defines
define('Username', 'Admin');
define('Password', 'EZHACK');
define('dog', 'PrettyDOG');
define('get_data_filename', 'ezweb_logger_admin'); # Set this file name


session_start();
# ファイル名 0_は特別なファイルを表します。
if ($_SESSION['EZWeblogger_auth'] && isset($_GET['page'])) {
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Day Detail</title>
<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="">
<!--[if lt IE 9]>
<script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" href="">
</head>
<body>
<?
$data = file_get_contents('data/'.$_GET['page']);
$count = mb_substr_count('{', $data);
?>
<!-- Place your content here -->
<!-- SCRIPTS -->
<!-- Example: <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
</body>
</html>
<?
}
if ($_SESSION['EZWeblogger_auth']) {
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>EZWeb logger data viewing</title>
<meta charset="utf-8">
<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="">
<!--[if lt IE 9]>
<script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" href="">
</head>
<body>
	<h1>Hello Admin !</h1>
	<h2>いままでの総計データ</h2>
	<h2>日ごとのデータ</h2>
<?
$dir = "data/" ;
	if( is_dir( $dir ) && $handle = opendir( $dir ) ) {
		while( ($file = readdir($handle)) !== false ) {
			if( filetype( $path = $dir . $file ) == "file"  && !strpos($file, '_admin')) {
				$ip =[];
				$page = [];
				$data = file_get_contents('data/'.$file); # Per day
				$data2[] =0;
				$data2 = explode('{', $data); # Per Access
				for ($i=1; $i < count($data2); $i++) {
					$data3 = explode(':', $data2[$i]);
					$ip[] = $data3[1];
					$page[] = $data3[2];
				}
				$ipvd = array_count_values($ip);
				arsort($ipvd);
				$ipvd = array_slice( $ipvd, 0, 10 );
				$pagevd = array_count_values($page);
				arsort($pagevd);
				$pagevd = array_slice( $pagevd, 0, 10 );
				# 各Dayに対して出力
				echo '<h3><a href="?get='.$file.'">'.$file.'</a>: 総計: '.mb_substr_count($data, "{").'回</h3>';
				echo "<p>		Top 10 accessed ip</p>";
				foreach ($ipvd as $key=>$value) {
					// var_dump($value);
					echo "<li>".$key." : ".$value."回</li>";
				}
				echo "<p>		Top 10 accessed page</p>";
				foreach ($pagevd as $key=>$value) {
					// var_dump($value);
					echo "<li>".$key." : ".$value."回</li>";
				}
				// for ($i=0; $i < 5; $i++) { 
				// 	echo "<li>".$ipvd[$i]."</lu>";
				// }
			}
		}
	}
?>
<!-- Place your content here -->
<!-- SCRIPTS -->
<!-- Example: <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
</body>
</html>
<?
}elseif (isset($_POST['submit'])) {
	if (Username == $_POST['name'] && Password == $_POST['pass'] && dog == $_POST['dog']) {
		session_regenerate_id(true);
		$_SESSION['EZWeblogger_auth'] = true;
		$savefile = 'data/0_admin_login_succeed.txt';
	}else{
		$savefile = 'data/0_admin_login_failed.txt';
	}
	$data = file_get_contents($savefile);
	$data .= date('Y/m/d/H:i').':'.$_SERVER["REMOTE_ADDR"]. "\n";
	file_put_contents($savefile, $data);
	header('Location: ./'.get_data_filename.'.php');
}
else{
	#HTMLは最低限のものです。適当にいじってください。
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>EZWeb loggerㅣLOGIN</title>
<meta charset="utf-8">
<meta name="robots" content="noindex">
<meta name="description" content="This is EZWeb logger admin panel.This software developed by Bhe3spy.">
<meta name="author" content="Bhe3spy">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="">
<!--[if lt IE 9]>
<script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="shortcut icon" href="">
</head>
<body>
	<h1>☆EZWeb logger LOGIN☆</h1>
	<form action="" method="post">
		<label>USERNAME</label>
		<input type="text" name="name" size="40"><br>
		<label>Password</label>
		<input type="password" name="pass" size="40"><br>
		<label>Your favorite dog Name</label>
		<input type="text" name="dog" size="40"><br>
		<label>Submit</label>
		<input type="submit" name="submit" value="送信">
	</form>
<!-- Place your content here -->
<!-- SCRIPTS -->
<!-- Example: <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> -->
</body>
</html>
<?
}