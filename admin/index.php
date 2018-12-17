<?php
if(session_id() == '')
{
	session_start();
}
if ($_SESSION["admin"] == "true")
{
	header("Location: http://$_SERVER[HTTP_HOST]/admin/admin.php");
	die("ERROR!");
}
mkdir ("/tmp/$_SERVER[HTTP_HOST]/");
?>
<!doctype html>
<html>

<head>
    <title>Lab Queue admin login page</title>
    <meta charset = "utf-8" />
	<style>
	.warn
	{
		color: red;
		font-weight: bold;
	}
	</style>
</head>

<body>
	Please enter the admin password:
	<hr>
	<form action="login.php" method="post">
		Password: 
		<input type="password" name="pwd" title="Password" required>
		<input type="submit" value="Submit">
	</form>
	<br>
	<br>
	<?php
	$str = file_get_contents ("/tmp/$_SERVER[HTTP_HOST]/Labqueue_password.txt") or $str = "password";
	if ($str === "password") echo "<div class=\"warn\">WARNING! You are using the default password! Please change it from the admin panel for security issues.</div>";
	?>
	<br>
	<br>
	<br>
	<a href="/queue.php" target="_blank">Current queue</a> 
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	<hr>
	<div style="text-align: center;">© 2018 Ziya Mukhtarov</div>
</body>

</html>
