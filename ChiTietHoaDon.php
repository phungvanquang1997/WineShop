<?php
	require_once "./lib/db.php";
	session_start();
	if(isset($_GET["OrderID"]))
	{
		$orderID = $_GET["OrderID"];
		$_SESSION["ChiTietHoaDon"] = $orderID;
		//var_dump($_SESSION["ChiTietHoaDon"]);
		header('Location: LichSuMuaHang.php');
	}
?>