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
	session_unset();
	session_destroy();
	header("Location: http://$_SERVER[HTTP_HOST]/admin");
?>