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
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips.txt", "r");
	while ($line = fgets($fl))
	{
		echo $line;
		echo "<br>";
	}
	fclose($fl);
?>
