<?php
	require_once "./lib/db.php";
	session_start();

	if(isset($_GET["ProID"]))
	{
		$proid = $_GET["ProID"];
		$sql = "delete from products where ProID = $proid";
		write($sql);
		
		header('Location: AdminLogin_SanPham.php');
	}

?>	
