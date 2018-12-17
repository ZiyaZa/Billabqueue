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
	$newpass = $_COOKIE["newpass"];

	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_password.txt", "w") or die("ERROR! The file does not exist!");
	fwrite($fl, $newpass);
	fclose($fl);

	setcookie('fail', 0);
	setcookie('success', 5);
?>
<script>
window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/admin.php";
</script>