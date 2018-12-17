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
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt", "w") or die("ERROR! The file does not exist!");
	fclose($fl);
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AWT1.txt", "w") or die("ERROR! The file does not exist!");
	fclose($fl);
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AWT2.txt", "w") or die("ERROR! The file does not exist!");
	fclose($fl);
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AGT1.txt", "w") or die("ERROR! The file does not exist!");
	fclose($fl);
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AGT2.txt", "w") or die("ERROR! The file does not exist!");
	fclose($fl);
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_firstSince1.txt", "w") or die("ERROR! The file does not exist!");
	fclose($fl);
	$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_firstSince2.txt", "w") or die("ERROR! The file does not exist!");
	fclose($fl);
	echo "SUCCESS! The queue has been cleared.<br>Redirecting in <div id=\"id\" style=\"display: inline\"></div> seconds...";
?>
<script>

var s = 3;
function f()
{
	s = s - 1;
	if (s < 0)
	{
		window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/admin.php";
	}
	else
	{
		document.getElementById("id").innerHTML = s;
		window.setTimeout("f()", 1000);
	}
}
f();
</script>