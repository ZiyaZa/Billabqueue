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
$success = $_COOKIE['success'];
$fail = $_COOKIE['fail'];
setcookie('success', 0);
setcookie('fail', 0);
?>
<!doctype html>
<html>

<head>
    <title>Lab Queue admin page</title>
    <meta charset = "utf-8" />
	<style>
	.header
	{
   		display: flex;
   		justify-content: center;
   		font-size: 30px;
   		font-weight: bold;
		color: blue;
		margin: 10px;
	}
	.middleimg
	{
		display: flex;
		justify-content: center;
		font-size: 16px;
		font-weight: bold;
		color: blue;
	}
	.IP
	{
		text-align: center;
		width: 100px;
	}
	.success, .fail
	{
		display: flex;
		justify-content: space-around;
		font-size: 20px;
		font-weight: bold;
		margin: 5px;
	}
	.success
	{
		color: green;
	}
	.fail
	{
		color: red;
	}
	img
	{
		display: block;
		margin-left: auto;
		margin-right: auto;
	}
	option
	{
		font-family: consolas;
	}
	body
	{
		width: 750px;
	}
	table, th, td
	{
		border: 1px solid black;
		border-collapse: collapse;
		padding-left: 15px;
		padding-right: 15px;
	}
	td:nth-child(odd)
	{
		background-color: #C6E0B4;
	}
	th
	{
		background-color: #70AD47;
		color: white;
	}
	.warn
	{
		color: red;
		font-weight: bold;
		text-align: center;
		font-size: 20px;
	}
	</style>
	<script>
	function updateIPs()
	{
		var table, rows, i, id1, id2, id3, ip1, ip2, ip3, a;

		table = document.getElementById("table");
		rows = table.rows;

		for (i = 1; i < rows.length; i++)
		{
			a = rows[i].getElementsByTagName("TD")[0].innerHTML;
			id1 = a.substring(37, a.indexOf('">'));
			a = rows[i].getElementsByTagName("TD")[1].innerHTML;
			ip1 = a.substring(37, a.indexOf('">'));

			a = rows[i].getElementsByTagName("TD")[2].innerHTML;
			id2 = a.substring(37, a.indexOf('">'));
			a = rows[i].getElementsByTagName("TD")[3].innerHTML;
			ip2 = a.substring(37, a.indexOf('">'));

			a = rows[i].getElementsByTagName("TD")[4].innerHTML;
			id3 = a.substring(37, a.indexOf('">'));
			a = rows[i].getElementsByTagName("TD")[5].innerHTML;
			ip3 = a.substring(37, a.indexOf('">'));

			document.cookie = "id" + id1 + "='" + ip1 + "'";
			document.cookie = "id" + id2 + "='" + ip2 + "'";
			document.cookie = "id" + id3 + "='" + ip3 + "'";
		}
	}
	function clearAll()
	{
		document.getElementById("warn1").style.visibility = "visible";
		var table, rows, i, id1, id2, id3, ip1, ip2, ip3, a;

		table = document.getElementById("table");
		rows = table.rows;

		for (i = 1; i < rows.length; i++)
		{
			rows[i].getElementsByTagName("TD")[1].innerHTML = "<input type=\"text\" class=\"IP\" name=\"IP[]\" value=\"\">";
			rows[i].getElementsByTagName("TD")[3].innerHTML = "<input type=\"text\" class=\"IP\" name=\"IP[]\" value=\"\">";
			rows[i].getElementsByTagName("TD")[5].innerHTML = "<input type=\"text\" class=\"IP\" name=\"IP[]\" value=\"\">";
		}
	}
	function add_names()
	{
		document.cookie = "fail=3";
		document.cookie = "name1="+document.getElementById("name1").value;
		document.cookie = "name2="+document.getElementById("name2").value;
		if (document.getElementById("stat1").checked === true) document.cookie = "stat1=1";
		else document.cookie = "stat1=0";
		if (document.getElementById("stat2").checked === true) document.cookie = "stat2=1";
		else document.cookie = "stat2=0";

		window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/change_TA.php";
	}
	function change_pass()
	{
		document.cookie = "fail=5";
		document.cookie = "newpass="+document.getElementById("newpass").value;

		window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/change_pass.php";
	}
	function change_pattern()
	{
		document.cookie = "fail=6";
		document.cookie = "pattern="+document.getElementById("pattern").value;

		window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/change_pattern.php";
	}
	function remove1()
	{
		var e = document.getElementById("select1");
		document.cookie = "fail=1";
		document.cookie = "word=" + e.options[e.selectedIndex].value;
		document.cookie = "file=/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt";
		window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/remove_someone.php";
	}
	function remove2()
	{
		var e = document.getElementById("select2");
		document.cookie = "fail=1";
		document.cookie = "word=" + e.options[e.selectedIndex].value;
		document.cookie = "file=/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt";
		window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/remove_someone.php";
	}
	function set(o)
	{
		document.cookie = "type=" + o;
		window.location = "http://<?php echo $_SERVER[HTTP_HOST];?>/admin/change_sorting.php";
	}
	</script>
</head>

<body>
	<button type="button" onclick="location.href = 'http://<?php echo $_SERVER[HTTP_HOST];?>/admin/clear.php';">Clear queue and stats</button>

	<button type="button" onclick="location.href = 'http://<?php echo $_SERVER[HTTP_HOST];?>/admin/logout.php';">Log out</button>
	
	<?php
	$str = file_get_contents ("/tmp/$_SERVER[HTTP_HOST]/Labqueue_password.txt") or $str = "password";
	if ($str === "password")
	{
		echo "<div class=\"warn\"><br>WARNING! You are using the default password! Please change it for security issues.</div><br>";
	}
	?>
	
	<div class="header">Change admin password:</div>
	<?php
	if ($success === "5") echo "<div class=\"success\">Success!</div>";
	if ($fail === "5") echo "<div class=\"fail\">Error!</div>";
	?>
	<div style="display: flex; justify-content: space-around;">
		<div>
			New password:
			<input type="password" id="newpass">
			<button type="button" onclick="change_pass()">Set the new password</button>
		</div>
	</div>
	
	<br><hr><br>
	
	<div class="header">Remove from queue:</div>
	<?php
	if ($success === "1") echo "<div class=\"success\">Success!</div>";
	if ($fail === "1") echo "<div class=\"fail\">Error!</div>";
	?>
	<div style="display: flex; justify-content: space-around;"><i>
	You can also remove someone from queue by clicking on it on queue while being logged in as an admin. <br>
	Please note that, removing someone from this page WILL NOT affect the average wait and grade times, while clicking on it on the queue page will affect them.
	</i></div>
	<br>
	<div style="display: flex; justify-content: space-around;">
	<div>
	TA: <?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA1.txt"); echo $str;?>
	<br>
	<select id="select1">
		<?php
			$i = 1;
			$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt");
			$arr = str_split($str);
			$s = "";
			$j = 0;
			foreach ($arr as $c)
			{
				if ($c == "\n")
				{
					if ($j == 0)
					{
						$names[$i] = $s;
						$s = "";
						$j = 1;
					}
					else
					if ($j == 1)
					{
						$ids[$i] = $s;
						$s = "";
						$j = 2;
					}
					else
					{
						$times[$i] = $s;
						$s = "";
						$j = 0;
						
						$i++;
					}
				}
				else
				{
					$s = $s.$c;
				}
			}
			$cnt = 1;
			for ($i = 1; $i <= count($times); $i++)
			{
				if ($ids[$i] <= 21)
				{
					echo "<option value=\"".$names[$i]." ".$ids[$i]." ".$times[$i]."\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</option>\n";
					$cnt++;
				}
			}
		?>
	</select>
	<br>
	<button type="button" onclick="remove1()">Remove</button>
	</div>

	<div>
	TA: <?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA2.txt"); echo $str;?>
	<br>
	<select id="select2">
		<?php
			$cnt = 1;
			for ($i = 1; $i <= count($times); $i++)
			{
				if ($ids[$i] > 21)
				{
					echo "<option value=\"".$names[$i]." ".$ids[$i]." ".$times[$i]."\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</option>\n";
					$cnt++;
				}
			}
		?>
	</select>
	<br>
	<button type="button" onclick="remove2()">Remove</button>
	</div>
	</div>

	<br><hr><br>
	
	<div class="header">Change queue style:</div>
	<?php
	if ($success === "2") echo "<div class=\"success\">Success!</div>";
	if ($fail === "2") echo "<div class=\"fail\">Error!</div>";
	?>
	<div style="display: flex; justify-content: space-around;">
	<div>
		<button type="button" style="margin-right: 100px;" onclick="set(1)">
		1) --- <br>
		2) --- <br>
		3) --- <br>
		...
		</button>
		<button type="button" onclick="set(0)">
		... <br>
		3) --- <br>
		2) --- <br>
		1) --- <br>
		</button>
	</div>
	</div>

	<br><hr><br>

	<div class="header">Edit TA info:</div>
	<?php
	if ($success === "3") echo "<div class=\"success\">Success!</div>";
	if ($fail === "3") echo "<div class=\"fail\">Error!</div>";
	?>
	<div style="display: flex; justify-content: space-around;">
		<div>
			TA for PCs with number <= 21
			<input type="text" id="name1" value="<?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA1.txt"); echo $str;?>"> 
			<input type="checkbox" id="stat1"<?php
			$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_stat1.txt");
			if ($str === false) $str = "1";
			if ($str == "1") echo "checked";
			?>>Show stats</input>
		</div>
	</div>
	<div style="display: flex; justify-content: space-around;">
		<div>TA for PCs with number >= 22
			<input type="text" id="name2" value="<?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA2.txt"); echo $str;?>">
			<input type="checkbox" id="stat2"<?php
			$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_stat2.txt");
			if ($str === false) $str = "1";
			if ($str == "1") echo "checked";
			?>>Show stats</input>
		</div>
	</div>
	<div style="display: flex; justify-content: space-around;">
		<button type="button" onclick="add_names()">Edit</button>
	</div>

	<br><hr><br>
	
	<div class="header">IP mapping:</div>
	<?php
	if ($success === "4") echo "<div class=\"success\">Success!</div>";
	if ($fail === "4") echo "<div class=\"fail\">Error!</div>";
	?>
	<div style="display: flex; justify-content: space-around;">
	<form action="update_IPs.php" method="post">
	<table id="table">
		<tr>
			<th>ID</th>
			<th>IP</th>
			<th>ID</th>
			<th>IP</th>
			<th>ID</th>
			<th>IP</th>
		</tr>
		<?php
		$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_ips.txt", "r");
		$arr = array();
		while ($line = fgets($fl))
		{
			$ip = "";
			for ($i = 0; $i < strlen($line); $i++)
			{
				if ($line[$i] == ' ') break;
				$ip = $ip.$line[$i];
			}

			$id = "";
			for (; $i < strlen($line); $i++)
			{
				$id = $id.$line[$i];
			}
			$id = intval($id);
			$arr[$id] = $ip;
		}
		fclose($fl);
		for ($i = 1; $i < 15; $i++)
		{
			echo "<tr><td><input type=\"text\" name=\"ID[]\" style=\"border: 0; width: 20px; background-color: #C6E0B4\" value=\"".$i."\" readonly></td><td><input type=\"text\" class=\"IP\" name=\"IP[]\" value=\"".$arr[$i]."\"></td><td><input type=\"text\" name=\"ID[]\" style=\"border: 0; width: 20px; background-color: #C6E0B4\" value=\"".($i+14)."\" readonly></td><td><input type=\"text\" class=\"IP\" name=\"IP[]\" value=\"".$arr[$i+14]."\"></td><td><input type=\"text\" name=\"ID[]\" style=\"border: 0; width: 20px; background-color: #C6E0B4\" value=\"".($i+28)."\" readonly></td><td><input type=\"text\" class=\"IP\" name=\"IP[]\" value=\"".$arr[$i+28]."\"></td></tr>";
		}
		?>
	</table>
	<br>
	<div style="margin-left: 230px">
	<button type="button" onclick="clearAll()" style="margin-right: 20px">Clear all</button>
	<input type="submit" value="Edit">
	</div>
	<div class="warn" id="warn1" style="visibility: hidden">
	Don`t forget to click "Edit"
	</div>
	</div>

	<br><hr><br>
	
	<!-- <div class="warn">[UNDER CONSTRUCTION]<br>Sorry for inconvenience!</div>  -->
	<div class="header">IP pattern:</div>
	<?php
	if ($success === "6") echo "<div class=\"success\">Success!</div>";
	if ($fail === "6") echo "<div class=\"fail\">Error!</div>";
	?>
	<div style="display: flex; justify-content: space-around;">
		<div>
			<input type="text" id="pattern" value=<?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_pattern.txt") or $str = "*.*.*.*"; echo $str; ?>>
			<br><br>
			<button type="button" onclick="change_pattern()">Set the IP pattern</button>
		</div>
	</div>
	<br>
	<div style="display: flex; justify-content: space-around;"><i>
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Examples:<br>
	Everybody: *.*.*.*<br>
	All devices from Bilkent network: 139.179.*.*<br>
	All PCs from Lab №202: 139.179.22.*<br><br>
	
	&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Explanation:<br>
	The IP pattern determines the devices that will be able to stand in the queue. You may put * in some parts of the IP to allow all connections. 
	For special lab room, the IP should start with "139.179." as the PCs are located in the Bilkent network and the third part of the IP should be 
	the number of the room with the middle digit removed.</i></div>
	
	
	<br><hr><br>
	
	<div class="header">Lab scheme:</div>
	<img src="../Lab1.png">
	<br>
	<div class="middleimg"> TA: 
	<?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA1.txt"); echo $str;?>
	</div>
	<br>
	<img src="../Lab2.png">
	<br>
	<div class="middleimg"> TA: 
	<?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA2.txt"); echo $str;?>
	</div>
	<br>
	<img src="../Lab3.png">
	<hr>
	<div style="text-align: center;">© 2018 Ziya Mukhtarov</div>
</body>

</html>
