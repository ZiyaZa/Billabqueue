<?php
	setcookie('fail', 4);
	if(session_id() == '')
	{
		session_start();
	}
	if ($_SESSION["admin"] != "true")
	{
		header("Location: http://$_SERVER[HTTP_HOST]/admin");
		die("ERROR!");
	}
	$ips = $_POST['IP'];
	$ids = $_POST['ID'];
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips.txt", "w");
	for ($i = 0; $i < count($ips); $i++)
	{
		if ($ips[$i] != "")
		{
			fwrite ($fl, $ips[$i]." ".($ids[$i] < 10 ? "0" : "").$ids[$i]."\n");
		}
	}
	fclose($fl);

	setcookie('fail', 0);
	setcookie('success', 4);
?>
<script>
window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/admin.php";
</script>