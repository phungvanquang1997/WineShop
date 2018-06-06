<?php
	require_once "./lib/db.php";
	session_start();
	if(isset($_GET["idNSX"]))
	{
		$idNSX = $_GET["idNSX"];
		$sql = "delete from nhasanxuat where idNSX = $idNSX";
		write($sql);
		header('Location: AdminLogin_NhaSanXuat.php');
	}
?>