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
	$deleted = 0;

	$j = 0;
	$s = "";
	$isEmpty = 1;
	for ($i = 0; $i < strlen($str); $i++)
	{
		if ($str[$i] == "\n")
		{
			if ($j == 0)
			{
				$name = $s;
				$s = "";
				$j = 1;
			}
			else
			if ($j == 1)
			{
				$id = $s;
				$s = "";
				$j = 2;
			}
			else
			{
				$time = $s;
				$s = "";
				$j = 0;
				
				$ln = $name." ".$id." ".$time;
//				echo "Checking: ".$ln;
				
				if ($deleted === 1 && ($id <= 21) === ($idd <= 21))
				{
					$isEmpty = 0;
				}
				
				if (strpos($ln, $word) === false || $deleted == 1)
				{
					fwrite($tmp, $name."\n".$id."\n".$time."\n");
				}
				else
				{
					$idd = $id;
					$timed = $time;
					$deleted = 1;
				}
			}
		}
		else
		{
			$s = $s.$str[$i];
		}
	}
  	fclose($tmp);

	$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_tmp.txt");
	$fl = fopen($_COOKIE["file"], "w") or die("ERROR!\nFile not found.");
	fwrite($fl, $str);
	fclose($fl);

	// Average Wait Time computation
	// if ($idd <= 21) $fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AWT1.txt", "r");
	// else $fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AWT2.txt", "r");
	// $sum = 0;
	// $cnt = 0;
	// while ($tm = fgets($fl))
	// {
		// $sum = $cnt;
		// $cnt = $tm;
	// }
	// fclose($fl);

	// $x = strtotime ($timed);
	// echo $timed."<br>";
	// date_default_timezone_set('Europe/Istanbul');
	// $y = strtotime (date('H:i', time()));
	// echo $x." ".$y."<br>";
	// $wt = abs($x - $y) / 60;

	// $sum = $sum + $wt;
	// $cnt++;
	// if ($idd <= 21) $fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AWT1.txt", "w");
	// else $fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AWT2.txt", "w");
	// fwrite($fl, $sum."\n".$cnt);
	// fclose ($fl);

	// Average Grade Time firstSince.txt computation
	if ($idd <= 21) $fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_firstSince1.txt", "w");
	else $fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_firstSince2.txt", "w");
	if ($isEmpty === 1) fwrite ($fl, "");
	else fwrite ($fl, date('H:i', time()));
	fclose ($fl);

	setcookie('fail', 0);
	setcookie('success', 1);
?>
<script>
window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/admin.php";
</script>