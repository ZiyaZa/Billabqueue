<!doctype html>
<html>

<head>
    <title>Lab Queue Form</title>
    <meta charset = "utf-8" />
	<script>
	document.cookie="height="+window.innerHeight;
	function Time()
	{
		var t = new Date();
		var h = f(t.getHours());
		var m = f(t.getMinutes());
		var s = f(t.getSeconds());
		document.getElementById('time').innerHTML = "Current time: " + h + ":" + m + ":" + s;
		var x = setTimeout(Time, 1000);
	}
	function f(i)
	{
		if (i<10)
		{
			i="0"+i;
		}
		return i;
	}
	function submit()
	{
		document.cookie = "name="+document.getElementById("name").value;
		document.cookie = "id="+document.getElementById("id").value;
		window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/write.php";
	}
	</script>
	<style>
	input[readonly]
	{
		background-color: #ccc;
	}
	body
	{
		background-color: #f1f1f1;
	}
	.middleimg
	{
		display: flex;
		justify-content: center;
		font-size: 16px;
    	font-weight: bold;
		color: blue;
	}
	img
	{
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
	input
	{
		height: 20px;
		border-color: #f1f1f1;
		background: #fbfbfb;
	}
	button
	{
		background-color: #5bc0de;
		border-color: #46b8da;
		border-radius: 4px;
		color: #fff;
		cursor: pointer;
		margin-left: 45%;
		padding: 5px;
	}
	button:hover
	{
		background-color: #31b0d5;
		border-color: #269abc;
	}
	.container
	{
		background-color: #fff;
		width: 400px;
		border: 2px solid blue;
		border-radius: 25px;
		padding: 25px;
		display: flex;
		margin-left: calc((100vw - 450px) / 2);
		justify-content: center;
	}
	</style>
</head>

<body onload="Time()">
	<?php
	mkdir("/tmp/$_SERVER[HTTP_HOST]");
	// print_r(scandir("/tmp"));
	?>
	<div style="font-size: 20px">Please enter your first name below in order to stand in the queue:</div>
	<hr>
	<div class="container"><div>
		Your first name:<br>
		<input type="text" id="name" title="Your first name, at most 10 characters" maxlength="10">
		<?php
		$ip = $_SERVER['REMOTE_ADDR'];
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
					echo "<input type=\"number\" id=\"id\" value=\"".$str[$i+1].$str[$i+2]."\" readonly style=\"display: none\">";
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
		if ($found == 0) echo "<br><br>Your pc number (find out from the picture below):<br><input type=\"number\" id=\"id\" min=\"1\" max=\"42\">";
		?>
		<br><br>
		<button type="button" onclick="submit()">Submit</button>
	</div></div>
	<br>
	<br>
	<div id="time" style="font-size: 20px;"></div>
	<br>
	<a href="/queue.php" target="_blank" style="font-size: 20px;">Current queue</a>
	<br><br><br>
	<?php
	$str1 = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA1.txt"); 
	$str2 = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA2.txt"); 
	if ($found == 0) echo "<img src=\"Lab1.png\"><br><div class=\"middleimg\"> TA:".$str1."</div><br><img src=\"Lab2.png\"><br><div class=\"middleimg\"> TA: ".$str2."</div><br><img src=\"Lab3.png\">";
	else echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
	?>
	<hr>
	<div style="text-align: center;">© 2018 Ziya Mukhtarov</div>
</body>

</html>
