<?php 
	$root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
	$root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
	$baseurl = $root;
	?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>404 Page Not Found</title>
<link rel="shortcut icon" href="<?php echo $baseurl; ?>style/admin/images/logovesta.ico" type="image/x-icon">

<style type="text/css">

::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }

body {
	background-color: #fff;
	margin: 40px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #4F5155;
}

a {
	color: #fff;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #444;
	background-color: transparent;
	border-bottom: 1px solid #D0D0D0;
	font-size: 19px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 14px 15px 10px 15px;
}

csode {
	font-family: Consolas, Monaco, Courier New, Courier, monospace;
	font-size: 12px;
	background-color: #f9f9f9;
	border: 1px solid #D0D0D0;
	color: #fff;
	display: block;
	margin: 14px 0 14px 0;
	padding: 12px 10px 12px 10px;
}

#container {
	margin: 10px;
	sborder: 1px solid #D0D0D0;
	-webkit-box-shadow: 0 0 8px #D0D0D0;
}

p {
	margin: 12px 15px 12px 15px;
}
	body{
		
		background-color: #fff;
	}
</style>
</head>
<body>
	<div id="container">
		<center>
			<img width="800px" src="<?php echo $baseurl; ?>style/web/images/404.png">
			<h2 style="color:white; font-size:35px; font-weight:normal"> Maaf, halaman yang Anda cari tidak dapat ditemukan</h2>
			<br>
			<a style="color:#2e3092" href="<?php echo $baseurl; ?>"><b>[ Kembali Ke Halaman Awal ]</b></a>
		</center>
	</div>
</body>
</html>