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
	$name1 = $_COOKIE["name1"];
	$name2 = $_COOKIE["name2"];
	$stat1 = $_COOKIE["stat1"];
	$stat2 = $_COOKIE["stat2"];

	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA2.txt", "w") or die("ERROR! The file does not exist!");
	fwrite($fl, $name2);
	fclose($fl);

	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA1.txt", "w") or die("ERROR! The file does not exist!");
	fwrite($fl, $name1);
	fclose($fl);

	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_stat1.txt", "w") or die("ERROR! The file does not exist!");
	fwrite($fl, $stat1);
	fclose($fl);

	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_stat2.txt", "w") or die("ERROR! The file does not exist!");
	fwrite($fl, $stat2);
	fclose($fl);

	setcookie('fail', 0);
	setcookie('success', 3);
?>
<script>
window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/admin.php";
</script>