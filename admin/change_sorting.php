<?php
	setcookie('fail', 2);
	if(session_id() == '')
	{
		session_start();
	}
	if ($_SESSION["admin"] != "true")
	{
		header("Location: http://$_SERVER[HTTP_HOST]/admin");
		die("ERROR!");
	}
	$type = $_COOKIE["type"];

	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_sorting.txt", "w") or die("ERROR! The file does not exist!");
	fwrite($fl, $type);
	fclose($fl);

	setcookie('fail', 0);
	setcookie('success', 2);
?>
<script>
window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/admin.php";
</script>