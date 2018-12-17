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
	$str = file_get_contents($_COOKIE["file"]) or die("ERROR!\nFile does not exist.");
	$tmp = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_tmp.txt", "w") or die("ERROR!\nFile not found.");
	$word = $_COOKIE["word"];
	$ln = "";

	for ($i = 0; $i < strlen($str); $i++)
	{
		if ($str[$i] == "\n")
		{
//			echo $ln."<br>";
			if (strpos($ln, $word) === false)
			{
				fwrite($tmp, $ln."\n");
			}
			$ln = "";
		}
		else $ln = $ln.$str[$i];
	}
  	fclose($tmp);

	$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_tmp.txt") or die("ERROR!\nFile not found.");
	$fl = fopen($_COOKIE["file"], "w") or die("ERROR!\nFile not found.");
	fwrite($fl, $str);
	fclose($fl);
?>
