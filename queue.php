<?php
if(session_id() == '')
{
	session_start();
}
if ($_SESSION["admin"] == "true")
{
	$admin = 1;
}
else $admin = 0;
mkdir ("/tmp/$_SERVER[HTTP_HOST]/");
?>
<!doctype html>
<html>

<head>
    <title>Lab Queue</title>
    <meta charset="utf-8" />
    <meta http-equiv="refresh" content="2">
    <style>
		* {
			font-family: consolas;
		}
    	.middle {
    		display: flex;
    		justify-content: center;
    		font-size: 30px;
    		font-weight: bold;
			color: red;
		}
    	.row {
    		display: flex;
			justify-content: center;
    		font-size: 30px;
    		font-weight: bold;
		}
    	.row2 {
    		display: flex;
			justify-content: space-around;
    		font-size: 30px;
    		font-weight: bold;
		}
    	.rowinfo {
    		display: flex;
			justify-content: space-around;
    		font-size: 18px;
			color: gray;
		}
    	.column {
			height: calc(100vh - 120px);
			display: flex;
			flex: 50%;
			flex-direction: column;
			flex-wrap: wrap;
		}
    	.column2 {
			flex: 50%;
			flex-direction: column;
		}
    	.column1 {
			flex: 50%;
		    display: flex;
			flex-direction: column;
			flex-wrap: wrap;
		}
		.line {
			margin: 5px;
			border-left: 6px solid gray;
			height: calc(100vh - 120px);
		}
		.item {
			height: 30px;
		}
		<?php
		if ($admin == 1)
		{
			echo "div.item:hover {text-decoration: line-through; text-decoration-color: red;cursor: pointer;}\n";
		}
		?>
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
    </style>
	<script>
	document.cookie="height="+window.innerHeight;
	<?php
	if ($admin == 1)
	{
		echo "function remove(word)\n	{\n		document.cookie = \"word1=\" + word;\n		document.cookie = \"file1=/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt\";\n		window.location = \"http://$_SERVER[HTTP_HOST]/admin/delete_from_queue.php\";\n	}\n";
	}
	?>
	</script>
</head>

<body>
<div class="middle">
	Link: <?php echo $_SERVER[HTTP_HOST]; ?> &nbsp&nbsp&nbsp&nbsp Current queue: 
	<br>
</div>

<div class="row2">
	<div>TA: 
	<?php
	$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA1.txt");
	if (strlen($str) == 0) $str = 1;
	echo $str;
	?>
	</div>
	<div>TA: 
	<?php
	$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA2.txt");
	if (strlen($str) == 0) $str = 2;
	echo $str;
	?>
	</div>
</div>

<i><div class="rowinfo">
<?php
	$stats1 = true;
	$stats2 = true;
	if (file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_stat1.txt") === "0") $stats1 = false;
	if (file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_stat2.txt") === "0") $stats2 = false;
	if ($stats1 === true)
	{
		$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AWT1.txt", "r");
		$sum1 = 0;
		$cnt1 = 0;
		while ($tm = fgets($fl))
		{
			$sum1 = $cnt1;
			$cnt1 = $tm;
		}
		fclose($fl);
		$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AGT1.txt", "r");
		$sum2 = 0;
		$cnt2 = 0;
		while ($tm = fgets($fl))
		{
			$sum2 = $cnt2;
			$cnt2 = $tm;
		}
		fclose($fl);
		echo "<div>(Graded: ".$cnt1.($cnt1 > 1 ? " people" : " person").", average wait time: ".number_format((float)($cnt1>0 ? $sum1/$cnt1 : 0), 1, '.', '')." min., average grade time: ".number_format((float)($cnt2>0 ? $sum2/$cnt2 : 0), 1, '.', '')." min.)</div>";
	}
	else echo "<div style=\"width: 550px\"></div>";
	if ($stats2 === true)
	{
		$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AWT2.txt", "r");
		$sum1 = 0;
		$cnt1 = 0;
		while ($tm = fgets($fl))
		{
			$sum1 = $cnt1;
			$cnt1 = $tm;
		}
		fclose($fl);
		$fl = fopen("/tmp/$_SERVER[HTTP_HOST]/Labqueue_AGT2.txt", "r");
		$sum2 = 0;
		$cnt2 = 0;
		while ($tm = fgets($fl))
		{
			$sum2 = $cnt2;
			$cnt2 = $tm;
		}
		fclose($fl);
		echo "<div>(Graded: ".$cnt1.($cnt1 > 1 ? " people" : " person").", average wait time: ".number_format((float)($cnt1>0 ? $sum1/$cnt1 : 0), 1, '.', '')." min., average grade time: ".number_format((float)($cnt2>0 ? $sum2/$cnt2 : 0), 1, '.', '')." min.)</div>";
	}
	else echo "<div style=\"width: 550px\"></div>";
?>
</div></i>

<div class="row">
	<div class="column1">
		<div style="color: blue"> &nbsp№) TIME &nbspPC NAME </div>
	</div>
	<div class="column1">
		<div style="color: blue"> &nbsp№) TIME &nbspPC NAME </div>
	</div>
</div>

<div class="row">
	<div class="column">
		<?php
			$type = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_sorting.txt");

			$h = $_COOKIE['height'] - 135;
			echo "<div style=\"display: none\">".$h."</div>";

			$i = 1;
			$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt");
			$arr = str_split($str);
			$s = "";
			$j = 0;
			$cnt = 0;
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
						if ($ids[$i] <= 21) $cnt++;
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
			$k = (int) ($h/30);
			if ($type == "0")
			{
				for ($i = count($times); $k > 0 and $i > 0; $i--)
				{
					if ($ids[$i] <= 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt--;
						$k--;
					}
				}
				echo "<div class=\"line\"></div>";
				$k = (int) ($h/30);
				for (; $k > 0 and $i > 0; $i--)
				{
					if ($ids[$i] <= 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt--;
						$k--;
					}
				}
			}
			else
			{
				$cnt = 1;
				for ($i = 1; $k > 0 and $i <= count($times); $i++)
				{
					if ($ids[$i] <= 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt++;
						$k--;
					}
				}
				echo "<div class=\"line\"></div>";
				$k = (int) ($h/30);
				for (; $k > 0 and $i <= count($times); $i++)
				{
					if ($ids[$i] <= 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt++;
						$k--;
					}
				}
			}
		?>
		<br>
		<br>
	</div>

	<div class="column">
		<?php
			$i = 1;
			$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt");
			$arr = str_split($str);
			$s = "";
			$j = 0;
			$cnt = 0;
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
						if ($ids[$i] > 21) $cnt++;
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
			if ($type == "0")
			{
				$k = (int) ($h/30);
				for ($i = count($times); $k > 0 and $i > 0; $i--)
				{
					if ($ids[$i] > 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt--;
						$k--;
					}
				}
				echo "<div class=\"line\"></div>";
				$k = (int) ($h/30);
				for (; $k > 0 and $i > 0; $i--)
				{
					if ($ids[$i] > 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt--;
						$k--;
					}
				}
			}
			else
			{
				$cnt = 1;
				$k = (int) ($h/30);
				for ($i = 1; $k > 0 and $i <= count($times); $i++)
				{
					if ($ids[$i] > 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt++;
						$k--;
					}
				}
				echo "<div class=\"line\"></div>";
				$k = (int) ($h/30);
				for (; $k > 0 and $i <= count($times); $i++)
				{
					if ($ids[$i] > 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt++;
						$k--;
					}
				}
			}
		?>
		<br>
		<br>
	</div>
</div>
<br><br><br>
<div class="row">
	<div class="column2">
		<?php
			$i = 1;
			$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt");
			$arr = str_split($str);
			$s = "";
			$j = 0;
			$cnt = 0;
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
						if ($ids[$i] <= 21) $cnt++;
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
			$k = (int) ($h/30);
			$k = 2 * $k;
			if ($type == "0")
			{
				for ($i = count($times); $k > 0 and $i > 0; $i--)
				{
					if ($ids[$i] <= 21)
					{
						$cnt--;
						$k--;
					}
				}
				for (; $i > 0; $i--)
				{
					if ($ids[$i] <= 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt--;
					}
				}
			}
			else
			{
				$cnt = 1;
				for ($i = 1; $k > 0 and $i <= count($times); $i++)
				{
					if ($ids[$i] <= 21)
					{
						$cnt++;
						$k--;
					}
				}
				for (; $i <= count($times); $i++)
				{
					if ($ids[$i] <= 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt++;
					}
				}
			}
		?>
		<br>
		<br>
	</div>
	<div>
	<img src="Lab1.png">
	<br>
	<div class="middleimg"> TA: 
	<?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA1.txt"); echo $str;?>
	</div>
	<br>
	<img src="Lab2.png">
	<br>
	<div class="middleimg"> TA: 
	<?php $str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue_TA2.txt"); echo $str;?>
	</div>
	<br>
	<img src="Lab3.png">
	</div>

	<div class="column2">
		<?php
			$i = 1;
			$str = file_get_contents("/tmp/$_SERVER[HTTP_HOST]/Labqueue.txt");
			$arr = str_split($str);
			$s = "";
			$j = 0;
			$cnt = 0;
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
						if ($ids[$i] > 21) $cnt++;
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
			$k = (int) ($h/30);
			$k = 2 * $k;
			if ($type == "0")
			{
				for ($i = count($times); $k > 0 and $i > 0; $i--)
				{
					if ($ids[$i] > 21)
					{
						$cnt--;
						$k--;
					}
				}
				for (; $i > 0; $i--)
				{
					if ($ids[$i] > 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt--;
					}
				}
			}
			else
			{
				$cnt = 1;
				for ($i = 1; $k > 0 and $i <= count($times); $i++)
				{
					if ($ids[$i] > 21)
					{
						$cnt++;
						$k--;
					}
				}
				for (; $i <= count($times); $i++)
				{
					if ($ids[$i] > 21)
					{
						echo "<div class=\"item\" onclick=\"remove('".$names[$i]." ".$ids[$i]." ".$times[$i]."')\">".($cnt<10 ? "0" : "").$cnt.") ".$times[$i]." ".($ids[$i]<10 ? "0" : "").$ids[$i]." ".$names[$i]."</div>\n";
						$cnt++;
					}
				}
			}
		?>
		<br>
		<br>
	</div>
</div>
<hr>
<div style="text-align: center;">© 2018 Ziya Mukhtarov</div>
</body>

</html>
