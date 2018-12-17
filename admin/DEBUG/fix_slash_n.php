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
	
	$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips.txt") or die("ERROR!\n");
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips.txt", "w") or die("ERROR!\nFile not found.");

	for ($i = 0; $i < strlen($str); $i++)
	{
		if ($str[$i] === "\\")
		{
			fwrite($fl, "\n");
			$i++;
		}
		else fwrite($fl, $str[$i]);
	}
  	fclose($fl);
?>
