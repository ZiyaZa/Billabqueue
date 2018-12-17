<?php
	if(session_id() == '')
	{
		session_start();
	}
	if ($_SESSION["admin"] != "true")
	{
		header("Location: http://$_SERVER[HTTP_HOST]/admin");
		die("ERROR!");
	}
	$file1 = "/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips1.txt";
	$file2 = "/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips.txt";
	
	$str = file_get_contents ($file1);
	$h = fopen ($file2, "w");
	fwrite ($h, $str);
?>
