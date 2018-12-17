<?php
	if(session_id() == '')
	{
		session_start();
	}
	if ($_SESSION["admin"] == "true")
	{
		header("Location: http://$_SERVER[HTTP_HOST]/admin/admin.php");
		die("ERROR!");
	}
	$pwd = $_POST["pwd"];
	$str = file_get_contents ("/tmp/$_SERVER[HTTP_HOST]/Labqueue_password.txt") or $str = "password";
	if ($pwd !== $str) die("ERROR! Wrong password!\n<br>\nDon`t try to hack the password! Your ip is being recorded!");
	$_SESSION["admin"] = "true";
	header("Location: http://$_SERVER[HTTP_HOST]/admin/admin.php");
	die("ERROR!");
?>
