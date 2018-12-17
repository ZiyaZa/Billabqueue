<?php
	$h = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt", "a") or die("ERROR!\nFile not found.");
	$name = $_COOKIE['name'];
	$id = $_COOKIE['id'];
	$id = ltrim($id, '0');

	// checking whether the values are correct
	if ($id < 1 || $id > 42) die("ERROR!\n<br>\nWrong pc number.");
	if (mb_strlen($name, 'UTF-8') > 10 || mb_strlen($name, 'UTF-8') < 1 || strpbrk($name, "0123456789") !== FALSE ) die("ERROR!\n<br>\nIncorrect name.");

	$ip=$_SERVER['REMOTE_ADDR'];
	$pattern = file_get_contents ("/tmp/$_SERVER[HTTP_HOST]/Labqueue_pattern.txt") or $pattern = "*.*.*.*";
	
	$i1 = strpos ($pattern, '.');
	$p1 = substr ($pattern, 0, $i1);
	$pattern = substr ($pattern, $i1+1);
	$i2 = strpos ($pattern, '.');
	$p2 = substr ($pattern, 0, $i2);
	$pattern = substr ($pattern, $i2+1);
	$i3 = strpos ($pattern, '.');
	$p3 = substr ($pattern, 0, $i3);
	$pattern = substr ($pattern, $i3+1);
	$p4 = $pattern;
	
	$i1 = strpos ($ip, '.');
	$ip1 = substr ($ip, 0, $i1);
	$ip = substr ($ip, $i1+1);
	$i2 = strpos ($ip, '.');
	$ip2 = substr ($ip, 0, $i2);
	$ip = substr ($ip, $i2+1);
	$i3 = strpos ($ip, '.');
	$ip3 = substr ($ip, 0, $i3);
	$ip = substr ($ip, $i3+1);
	$ip4 = $ip;
	
	// echo $p1."<br>".$p2."<br>".$p3."<br>".$p4."<br><br>".$ip1."<br>".$ip2."<br>".$ip3."<br>".$ip4."<br><br>";
	// echo ($p4 === "*")."<br>";
	
	$ip=$_SERVER['REMOTE_ADDR'];
	if (!(($p1 === $ip1 || $p1 === "*") && ($p2 === $ip2 || $p2 === "*") && ($p3 === $ip3 || $p3 === "*") && ($p4 === $ip4 || $p4 === "*"))) die("ERROR!\n<br>\nYour IP isn`t compatible with the IP pattern! Please contact your TA if you think there is a problem");
	
	// Searching for the ip in the list of ips and if it exists setting id accordingly
	$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips.txt");
	$s = "";
	$found = 0;
	for ($i = 0; $i < strlen($str); $i++)
	{
		$c = $str[$i];
		if ($c == " ")
		{
			if ($s == $ip)
			{
				$id = $str[$i+1].$str[$i+2];
				$id = ltrim($id, '0');
				$found = 1;
				break;
			}
			$i = $i + 3;
			$s = "";
		}
		else
		{
			$s = $s.$c;
		}
	}

	// Searching for this id inside the current queue
	$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt");
	$j = 0;
	$s = "";
	for ($i = 0; $i < strlen($str); $i++)
	{
		if ($str[$i] == "\n")
		{
			if ($j == 0)
			{
				$name1 = $s;
				$s = "";
				$j = 1;
			}
			else
			if ($j == 1)
			{
				$id1 = $s;
				$s = "";
				$j = 2;
			}
			else
			{
				$time1 = $s;
				$s = "";
				$j = 0;
				
				if ($id1 === $id)
				{
					die ("ERROR!\n<br>\nThis pc is already in the queue! Please wait!");
				}
			}
		}
		else
		{
			$s = $s.$str[$i];
		}
	}

	// Calculating the time
	date_default_timezone_set('Europe/Istanbul');
	$time = date('H:i', time());
	echo $time."<br>";
	
	// Writing to the file
  	fwrite($h, $name."\n".$id."\n".$time."\n");
  	fclose($h);
	
	// Writing to firstSince.txt if first in the queue
	if ($id <= 21) $str = file_get_contents ("/tmp/$_SERVER[HTTP_HOST]/Labqueue_firstSince1.txt") or $str = "";
	else $str = file_get_contents ("/tmp/$_SERVER[HTTP_HOST]/Labqueue_firstSince2.txt") or $str = "";
	// echo "\"".$str."\"<br>";
	if ($str === "")
	{
		if ($id <= 21) $fl = fopen ("/tmp/$_SERVER[HTTP_HOST]/Labqueue_firstSince1.txt", "w");
		else $fl = fopen ("/tmp/$_SERVER[HTTP_HOST]/Labqueue_firstSince2.txt", "w");
		fwrite ($fl, $time);
		fclose($fl);
	}

	// Adding this ip<->id to ip list if it is new
	$h = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips.txt", "a") or die("ERROR!\nFile not found.");
	if ($found == 0)
	{
		fwrite($h, $ip." ".($id < 10 ? "0" : "").$id."\n");
	}
	fclose($h);
	
  	echo "Successfully added to the queue!<br>If you don`t see yourself in the queue after 10 seconds, please try again.<br><a href=\"/queue.php\" target=\"_blank\">Current queue</a>";
?>
